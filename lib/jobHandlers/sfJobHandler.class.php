<?php
/*
 * This file is part of the sfJobQueuePlugin package.
 */
class sfJobHandler
{
  protected $logger;

  public function __construct()
  {
    $this->logger = sfLogger::getInstance();
  }

  public function getLogger()
  {
    return $this->logger;
  }

  public function run($params)
  {
    return sfJobQueue::SUCCESS;
  }

  /**
   * Called after a job creation
   *
   * @param    object     the related job
   * @param    array      array of params of the job
   */
  public static function postSave($job, $params)
  {
  }
}