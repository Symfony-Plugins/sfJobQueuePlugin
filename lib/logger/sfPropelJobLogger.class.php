<?php

/*
 * This file is part of the sfJobQueuePlugin package.
 *
 * (c) 2008 Xavier Lacot <xavier@lacot.org>
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
class sfPropelJobLogger
{
  protected $sf_job_id,
            $execution;

  /**
   * Initializes the propel logger.
   *
   * @param array Options for the logger
   */
  public function initialize($options = array())
  {
    if (!isset($options['sf_job_id']))
    {
      throw new Exception('sfPropelJobLogger: could not initialize logger, please specify a sf_job_id.');
    }
    else
    {
      $this->sf_job_id = $options['sf_job_id'];
    }

    if (!sfJobPeer::retrieveByPk($this->sf_job_id))
    {
      throw new Exception('sfPropelJobLogger: could not initialize logger, inexistant job.');
    }

    $c = new Criteria();
    $c->add(sfJobLogPeer::SF_JOB_ID, $this->sf_job_id);
    $c->addDescendingOrderByColumn(sfJobLogPeer::EXECUTION);
    $execution = sfJobLogPeer::doSelectOne($c);

    if ($execution)
    {
      $this->execution = $execution->getExecution() + 1;
    }
    else
    {
      $this->execution = 1;
    }
  }

  /**
   * Logs a message.
   *
   * @param string Message
   * @param string Message priority
   * @param string Message priority name
   */
  public function log($message, $priority, $priorityName)
  {
    $log_entry = new sfJobLog();
    $log_entry->setMessage($message);
    $log_entry->setPriorityName($priorityName);
    $log_entry->setSfJobId($this->sf_job_id);
    $log_entry->setExecution($this->execution);
    $log_entry->save();
  }
}