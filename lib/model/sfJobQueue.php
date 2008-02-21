<?php
/*
 * This file is part of the sfJobQueuePlugin package.
 *
 * (c) 2007 Xavier Lacot <xavier@lacot.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This plugins enables job queues into Symfony. It includes all the common job
 * queues tasks (start, stop, scheduling through job election strategies, etc.),
 * command line tasks, and a graphical interface for managing queues and jobs.
 * Using a job queue can be useful when asynchronised server-side operations
 * have to be performed (periodically grabbing a RSS feed, automatically sending
 * emails, etc.) or in environments without a cron access.
 *
 * @author   Xavier Lacot <xavier@lacot.org>
 * @see      http://www.symfony-project.com/trac/wiki/sfJobQueuePlugin
 */
class sfJobQueue extends BasesfJobQueue
{
  private
    $logger,
    $queue_delay;
  protected
    $scheduler;

  const STOPPED = 0;
  const RUNNING = 1;
  const SUCCESS = 'success';

  public static $status_text = array(self::STOPPED => 'stopped',
                                     self::RUNNING => 'running');

  public function __toString()
  {
    return $this->getName();
  }

  /**
   * Creates a new job in the queue
   *
   * @param    string    type of the job
   * @param    array     options of the job
   *
   * @return   object    created job
   */
  public function addJob($type = '', $options = null)
  {
    if ($this->isNew())
    {
      throw new Exception('Please save the queue before adding jobs to it.');
    }

    $job = new sfJob($type, $options);
    $job->setSfJobQueueId($this->getId());
    $job->save();

    $job_handler = sprintf('sf%sJobHandler', ucfirst($job->getType()));
    call_user_func(array($job_handler, 'postSave'), $job, unserialize($job->getParams()));

    return $job;
  }

  /**
   * Returns the number of jobs to be done
   *
   * @return   integer
   */
  public function getNbActiveJobs()
  {
    $c = new Criteria();
    $c->add(sfJobPeer::SF_JOB_QUEUE_ID, $this->getId());
    $c->add(sfJobPeer::STATUS, array(sfJob::RUNNING, sfJob::IDLE, sfJob::STOPPED), Criteria::IN);
    return sfJobPeer::doCount($c);
  }

  public function getNbActiveReadyJobs()
  {
    $this->initialize();
    return $this->scheduler->getNbReadyJobs();
  }

  public function getNbActiveRecurringJobs()
  {
    $c = new Criteria();
    $c->add(sfJobPeer::SF_JOB_QUEUE_ID, $this->getId());
    $c->add(sfJobPeer::STATUS, array(sfJob::RUNNING, sfJob::IDLE, sfJob::STOPPED), Criteria::IN);
    $c->add(sfJobPeer::IS_RECURRING, 1);
    return sfJobPeer::doCount($c);
  }

  public function getNbActiveScheduledJobs()
  {
    $c = new Criteria();
    $c->add(sfJobPeer::SF_JOB_QUEUE_ID, $this->getId());
    $c->add(sfJobPeer::STATUS, array(sfJob::RUNNING, sfJob::IDLE, sfJob::STOPPED), Criteria::IN);
    $c->add(sfJobPeer::SCHEDULED_AT, time(), Criteria::GREATER_THAN);
    return sfJobPeer::doCount($c);
  }

  public function getNbActiveWaitingJobs()
  {
    return $this->getNbActiveJobs() - $this->getNbActiveReadyJobs();
  }

  /**
   * Returns the number of cancelled jobs
   *
   * @return   integer
   */
  public function getNbCompletedCancelledJobs()
  {
    $c = new Criteria();
    $c->add(sfJobPeer::SF_JOB_QUEUE_ID, $this->getId());
    $c->add(sfJobPeer::STATUS, sfJob::CANCELLED);
    return sfJobPeer::doCount($c);
  }

  /**
   * Returns the number of jobs completed on failure
   *
   * @return   integer
   */
  public function getNbCompletedFailureJobs()
  {
    $c = new Criteria();
    $c->add(sfJobPeer::SF_JOB_QUEUE_ID, $this->getId());
    $c->add(sfJobPeer::STATUS, sfJob::ERROR);
    return sfJobPeer::doCount($c);
  }

  /**
   * Returns the number of completed jobs
   *
   * @return   integer
   */
  public function getNbCompletedJobs()
  {
    $c = new Criteria();
    $c->add(sfJobPeer::SF_JOB_QUEUE_ID, $this->getId());
    $c->add(sfJobPeer::STATUS, array(sfJob::SUCCESS, sfJob::ERROR, sfJob::CANCELLED), Criteria::IN);
    return sfJobPeer::doCount($c);
  }

  /**
   * Returns the number of jobs completed on success
   *
   * @return   integer
   */
  public function getNbCompletedSuccessfulJobs()
  {
    $c = new Criteria();
    $c->add(sfJobPeer::SF_JOB_QUEUE_ID, $this->getId());
    $c->add(sfJobPeer::STATUS, sfJob::SUCCESS);
    return sfJobPeer::doCount($c);
  }

  /**
   * Gets the current status of the queue from the database
   *
   * @return integer
   */
  public function getRequestedStatusFromDb()
  {
    $sf_job_queue = sfJobQueuePeer::retrieveByPk($this->getId());
    return $sf_job_queue->getRequestedStatus();
  }

  /**
   * Returns the status of the queue, as a text
   *
   * @return   string
   */
  public function getStatusText()
  {
    $status_text = self::$status_text;
    return $status_text[$this->getStatus()];
  }

  /**
   * Intializes the queue
   */
  protected function initialize()
  {
    $this->logger = sfLogger::getInstance();
    $this->queue_delay = ($this->getPollingDelay() > 1) ? $this->getPollingDelay() : 1;
    $scheduler =  sprintf('sf%sScheduler', ucfirst(strtolower($this->getSchedulerName())));
    $this->scheduler = new $scheduler();
    $this->scheduler->inititalize($this);
  }

  /**
   * Indicates whether the queue is running or not
   *
   * @return   boolean
   */
  public function isRunning()
  {
    return ($this->getStatus() == self::RUNNING);
  }

  /**
   * Runs the queue
   */
  public function run()
  {
    register_shutdown_function(array($this, 'shutdown'));
    $this->initialize();
    $this->logger->log(sprintf('{sfJobQueue} Queue "%s" started.',
                               $this->getName()));

    try
    {
      $status = true;

      while ($status)
      {
        $job = $this->scheduler->electJob();

        if ($job != null)
        {
          try
          {
            $job->run();
          }
          catch (Exception $e)
          {
            $this->logger->log($e->getMessage());
          }
        }

        sleep($this->queue_delay);
        $status = $this->getRequestedStatusFromDb();
      }

      $this->logger->log(sprintf('{sfJobQueue} Queue "%s" stopped.',
                                 $this->getName()));
      $this->setStatus(self::STOPPED);
      $this->save();
    }
    catch (Exception $e)
    {
      $this->logger->log(sprintf('{sfJobQueue} Queue "%s" unexpectedly stopped on error "%s"',
                                 $this->getName(),
                                 $e->getMessage()));
      $this->setStatus(self::STOPPED);
      $this->save();
    }
  }

  /**
   * Called at the execution shutdown while the job was running (ie., fatal
   * error)
   */
  public function shutdown()
  {
    if ($this->getStatus() == self::RUNNING)
    {
      $this->logger->log(sprintf('{sfJobQueue} Queue "%s" died on fatal error.',
                                 $this->getName()));
      $this->setStatus(self::STOPPED);
      $this->save();
    }

    restore_error_handler();
  }
}