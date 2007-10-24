<?php

/**
 * sfJobQueue actions.
 *
 * @package    sfJobQueue
 * @author     Xavier Lacot <xavier@lacot.org>
 */
class sfJobQueueActions extends autosfJobQueueActions
{
  public function executeEditJob()
  {
    $sf_job_queue_id = $this->getRequestParameter('sf_job_queue_id', $this->getRequestParameter('id'));
    $this->sf_job_queue = sfJobQueuePeer::retrieveByPk($sf_job_queue_id);
    $this->forward404Unless($this->sf_job_queue);

    $this->sf_job = $this->getsfJobOrCreate();

    if ($this->getRequest()->getMethod() == sfRequest::POST)
    {
      $this->updatesfJobFromRequest();
      $this->sf_job->save();
      $this->setFlash('notice', 'Your modifications have been saved');

      if ($this->getRequestParameter('save_and_add'))
      {
        return $this->redirect('sfJobQueue/createJob?sf_job_queue_id='.$sf_job_queue_id);
      }
      else if ($this->getRequestParameter('save_and_list'))
      {
        return $this->redirect('sfJobQueue/listJob?sf_job_queue_id='.$sf_job_queue_id);
      }
      else
      {
        return $this->redirect('sfJobQueue/editJob?sf_job_queue_id='.$this->sf_job->getSfJobQueue()->getId().'&sf_job_id='.$this->sf_job->getId());
      }
    }
    else
    {
      $this->sf_job_queues = sfJobQueuePeer::doSelect(new Criteria());
    }
  }

  public function executeSaveJob()
  {
    return $this->forward('sfJobQueue', 'editJob');
  }

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

  private function getsfJobOrCreate()
  {
    $sf_job_id = $this->getRequestParameter('sf_job_id');

    if ($sf_job_id)
    {
      $sf_job = sfJobPeer::retrieveByPk($sf_job_id);
      $this->forward404Unless($sf_job);
    }
    else
    {
      $sf_job = new sfJob();
      $sf_job->setSfJobQueueId($this->sf_job_queue->getId());
    }

    return $sf_job;
  }
  
  private function updatesfJobFromRequest()
  {
    $sf_job = $this->getRequestParameter('sf_job');
    $sf_job_queue_id = $this->getRequestParameter('sf_job_queue_id');

    if ($sf_job_queue_id)
    {
      $this->sf_job->setSfJobQueueId($sf_job_queue_id);
    }

    if (isset($sf_job['type']))
    {
      $this->sf_job->setType($sf_job['type']);
    }

    if (isset($sf_job['max_tries']))
    {
      $this->sf_job->setMaxTries($sf_job['max_tries']);
    }

    if (isset($sf_job['retry_delay']))
    {
      $this->sf_job->setRetryDelay($sf_job['retry_delay']);
    }

    if (isset($sf_job['message']))
    {
      $this->sf_job->setMessage($sf_job['message']);
    }

    if (isset($sf_job['priority']))
    {
      $this->sf_job->setPriority($sf_job['priority']);
    }

    if (isset($sf_job['scheduled_at']))
    {
      if ($sf_job['scheduled_at'])
      {
        try
        {
          $dateFormat = new sfDateFormat($this->getUser()->getCulture());

          if (!is_array($sf_job['scheduled_at']))
          {
            $value = $dateFormat->format($sf_job['scheduled_at'], 'I', $dateFormat->getInputPattern('g'));
          }
          else
          {
            $value_array = $sf_job['scheduled_at'];
            $value = $value_array['year'].'-'.$value_array['month'].'-'.$value_array['day'].(isset($value_array['hour']) ? ' '.$value_array['hour'].':'.$value_array['minute'].(isset($value_array['second']) ? ':'.$value_array['second'] : '') : '');
          }

          $this->sf_job->setScheduledAt($value);
        }
        catch (sfException $e)
        {
          // not a date
        }
      }
      else
      {
        $this->sf_job->setScheduledAt(null);
      }
    }

    if (isset($sf_job['status']))
    {
      $this->sf_job->setStatus($sf_job['status']);
    }

    if (isset($sf_job['params']))
    {
      $this->sf_job->setParams($sf_job['params']);
    }
  }
}
