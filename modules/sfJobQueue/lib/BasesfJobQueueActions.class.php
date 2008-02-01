<?php

/**
 * sfJobQueue actions.
 *
 * @package    sfJobQueue
 * @author     Xavier Lacot <xavier@lacot.org>
 */
class BasesfJobQueueActions extends autosfJobQueueActions
{
  public function executeSwitchStatus()
  {
    $job_queue = sfJobQueuePeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($job_queue);

    if ($job_queue->getRequestedStatus() == sfJobQueue::RUNNING)
    {
      $job_queue->setRequestedStatus(sfJobQueue::STOPPED);
    }
    else
    {
      $job_queue->setRequestedStatus(sfJobQueue::RUNNING);
    }

    $job_queue->save();
    $this->redirect('sfJobQueue/list?page='.$this->getRequestParameter('page', 1));
  }

  public function executeUpdateStatus()
  {
    $this->job_queue = sfJobQueuePeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->job_queue);
  }
}
