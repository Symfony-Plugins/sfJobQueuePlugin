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
class sfPriorityScheduler extends sfScheduler
{
  protected function buildQuery()
  {
    $query = parent::buildQuery();
    return sprintf('%s ORDER BY %s DESC, %s ASC, %s ASC', 
                    $query, 
                    sfJobPeer::PRIORITY, 
                    sfJobPeer::LAST_TRIED_AT, 
                    sfJobPeer::ID);
  }

  public function electJob()
  {
    return $this->getElectedJob($this->buildQuery());
  }

  public function getNbReadyJobs()
  {
    return count($this->getJobs($this->buildQuery()));
  }
}