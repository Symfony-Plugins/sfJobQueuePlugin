<?php

/**
 * Subclass for performing query and update operations on the 'sf_job_queue' table.
 *
 *
 *
 * @package plugins.sfJobQueuePlugin.lib.model
 */
class sfJobQueuePeer extends BasesfJobQueuePeer
{
  public static function retrieveByQueueName($name)
  {
    $c = new Criteria();
    $c->add(sfJobQueuePeer::NAME, $name);
    return sfJobQueuePeer::doSelectOne($c);
  }
}
