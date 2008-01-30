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
 * @author   Xavier Lacot <xavier@lacot.org>
 * @see      http://www.symfony-project.com/trac/wiki/sfJobQueuePlugin
 */
class sfJobQueueManager
{
  private
    $logger,
    $queue_delay;

  private function getJobQueuesToRun()
  {
    $c = new Criteria();
    $c->add(sfJobQueuePeer::REQUESTED_STATUS, sfJobQueue::RUNNING);
    $c->add(sfJobQueuePeer::STATUS, sfJobQueue::STOPPED);
    return sfJobQueuePeer::doSelect($c);
  }

  public function initialize()
  {
    $this->logger = sfLogger::getInstance();
    $this->queues_polling = sfConfig::get('app_sfJobQueuePlugin_queues_polling', 5);
  }

  public function run()
  {
    $this->initialize();
    $this->logger->log('Queue manager start');

    try
    {
      $apps_dir = glob(sfConfig::get('sf_root_dir').'/apps/*', GLOB_ONLYDIR);
      $app = substr($apps_dir[0],
                    strrpos($apps_dir[0], DIRECTORY_SEPARATOR) + 1,
                    strlen($apps_dir[0]));
      if (!$app)
      {
        throw new Exception('No app has been detected in this project');
      }

      while (true)
      {
        $sf_job_queues = $this->getJobQueuesToRun();

        foreach ($sf_job_queues as $sf_job_queue)
        {
          try
          {
            $this->logger->log(sprintf('Starting queue "%s".', $sf_job_queue->getName()));
            $command = sprintf('(%s symfony sfqueue-start-queue %s "%s" >> %s) > /dev/null &',
                               sfConfig::get('app_sfJobQueuePlugin_php', 'php'),
                               $app,
                               $sf_job_queue->getName(),
                               sfConfig::get('app_sfJobQueuePlugin_logfile', '/tmp/sfJobQueuePlugin.log'));
            passthru($command);
          }
          catch (Exception $e)
          {
            $sf_job_queue->setStatus(sfJobQueue::STOPPED);
            $sf_job_queue->save();
            $this->logger->log($e->getMessage());
          }
        }

        sleep($this->queues_polling);
      }
    }
    catch (Exception $e)
    {
      $this->logger->log(sprintf('Queue manager unexpectidly stopped on error "%s"',
                                 $e->getMessage()));
    }
  }
}