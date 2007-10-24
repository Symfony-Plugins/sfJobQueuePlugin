<?php
/*
 * This file is part of the sfJobQueuePlugin package.
 */
class sfJobHandler
{
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