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
abstract class sfScheduler
{
  protected
    $queue;

  protected function buildQuery()
  {
    $query = '
    SELECT *
    FROM %s
    WHERE %s = ?
    AND ((%s < %s) OR %s = ?)
    AND %s IS NULL
    AND %s NOT IN (%s, %s, %s)
    AND (%s IS NULL OR UNIX_TIMESTAMP(%s) < ? - %s)
    AND (%s IS NULL OR UNIX_TIMESTAMP(%s) < ?)';

    $query = sprintf($query,
                     sfJobPeer::TABLE_NAME,
                     sfJobPeer::SF_JOB_QUEUE_ID,
                     sfJobPeer::TRIES,
                     sfJobPeer::MAX_TRIES,
                     sfJobPeer::IS_RECURRING,
                     sfJobPeer::COMPLETED_AT,
                     sfJobPeer::STATUS,
                     sfJob::SUCCESS,
                     sfJob::CANCELLED,
                     sfJob::ERROR,
                     sfJobPeer::LAST_TRIED_AT,
                     sfJobPeer::LAST_TRIED_AT,
                     sfJobPeer::RETRY_DELAY,
                     sfJobPeer::SCHEDULED_AT,
                     sfJobPeer::SCHEDULED_AT
                     );
    return $query;
  }

  abstract public function electJob();

  protected function getElectedJob($query)
  {
    $jobs = $this->getJobs($query);

    if (count($jobs) > 0)
    {
      return $jobs[0];
    }
    else
    {
      return null;
    }
  }

  protected function getJobs($query)
  {
    $con = Propel::getConnection();
    $stmt = $con->prepareStatement($query);
    $stmt->setString(1, $this->queue->getId());
    $stmt->setString(2, 1);
    $stmt->setString(3, time());
    $stmt->setString(4, time());
    return sfJobPeer::populateObjects($stmt->executeQuery(null, ResultSet::FETCHMODE_NUM));
  }

  abstract public function getNbReadyJobs();

  public function inititalize($job_queue)
  {
    $this->queue = $job_queue;
  }
}