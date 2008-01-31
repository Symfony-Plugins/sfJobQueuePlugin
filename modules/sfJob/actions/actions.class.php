<?php

/**
 * sfJob actions.
 *
 * @package    sfJob
 * @author     Xavier Lacot <xavier@lacot.org>
 */
class sfJobActions extends autosfJobActions
{
  protected function addFiltersCriteria($c)
  {
    if (isset($this->filters['type_is_empty']))
    {
      $criterion = $c->getNewCriterion(sfJobPeer::TYPE, '');
      $criterion->addOr($c->getNewCriterion(sfJobPeer::TYPE, null, Criteria::ISNULL));
      $c->add($criterion);
    }
    else if (isset($this->filters['type']) && $this->filters['type'] !== '')
    {
      $c->add(sfJobPeer::TYPE, strtr($this->filters['type'], '*', '%'), Criteria::LIKE);
    }
    if (isset($this->filters['status_is_empty']))
    {
      $criterion = $c->getNewCriterion(sfJobPeer::STATUS, '');
      $criterion->addOr($c->getNewCriterion(sfJobPeer::STATUS, null, Criteria::ISNULL));
      $c->add($criterion);
    }
    else if (isset($this->filters['status']) && $this->filters['status'] !== '')
    {
      $c->add(sfJobPeer::STATUS, strtr($this->filters['status'], '*', '%'));
    }
    if (isset($this->filters['sf_job_queue_id_is_empty']))
    {
      $criterion = $c->getNewCriterion(sfJobPeer::SF_JOB_QUEUE_ID, '');
      $criterion->addOr($c->getNewCriterion(sfJobPeer::SF_JOB_QUEUE_ID, null, Criteria::ISNULL));
      $c->add($criterion);
    }
    else if (isset($this->filters['sf_job_queue_id']) && $this->filters['sf_job_queue_id'] !== '')
    {
      $c->add(sfJobPeer::SF_JOB_QUEUE_ID, $this->filters['sf_job_queue_id']);
      $this->sf_job_queue = sfJobQueuePeer::retrieveByPk($this->filters['sf_job_queue_id']);
      $this->forward404Unless($this->sf_job_queue);
    }
  }

  public function executeCancel()
  {
    $sf_job = sfJobPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($sf_job);
    $sf_job->setStatus(sfJob::CANCELLED);
    $sf_job->setCompletedAt(time());
    $sf_job->save();
    return $this->redirect('sfJob/list');
  }

  public function executeEdit()
  {
    $sf_job_queue_id = $this->getRequestParameter('sf_job_queue_id', $this->getRequestParameter('id', null));
    $this->sf_job = $this->getsfJobOrCreate();

    if ($this->getRequest()->getMethod() == sfRequest::POST)
    {
      $this->updatesfJobFromRequest();

      $this->savesfJob($this->sf_job);

      $this->setFlash('notice', 'Your modifications have been saved');

      if ($this->getRequestParameter('save_and_add'))
      {
        return $this->redirect('sfJob/create?sf_job_queue_id='.$sf_job_queue_id);
      }
      else if ($this->getRequestParameter('save_and_list'))
      {
        return $this->redirect('sfJob/list?sf_job_queue_id='.$sf_job_queue_id);
      }
      else
      {
        return $this->redirect('sfJob/edit?id='.$this->sf_job->getId());
      }
    }
    else
    {
      $this->labels = $this->getLabels();
    }
  }

  public function executeListQueues()
  {
    $this->forward('sfJobQueue', 'list');
  }

  public function executeParams()
  {
    $type = $this->getRequestParameter('type');

    if (!$type)
    {
      return sfView::NONE;
    }

    $job_class = sprintf('sf%sJobHandler', ucfirst($type));

    if (!class_exists($job_class))
    {
      return sfView::ERROR;
    }

    $job = new $job_class;
    $this->fields = $job->getParamFields();
    $this->params = array();
    $id = $this->getRequestParameter('id');

    if ($id && ($sf_job = sfJobPeer::retrieveByPk($id)))
    {
      $params = $sf_job->getParams();

      if (($params != null) && ($sf_job->getType() == ucfirst($type)))
      {
        $this->params = unserialize($params);
      }
    }
  }

  public function executeRun()
  {
    // don't limit max execution time
    set_time_limit(0);

    // set memory limit to 512MB
    ini_set('memory_limit', sfConfig::get('app_sfJobQueuePlugin_memory', '512M'));

    $sf_job = sfJobPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($sf_job);
    $message = $sf_job->run();

    if ($message == '' || $message == null)
    {
      if ($sf_job->getMessage() == '')
      {
        $message = sfConfig::get('sf_i18n') ? $this->getContext()->getI18n()->__('Job completed') : 'Job completed';
      }
      else
      {
        $message = $sf_job->getMessage();
      }
    }

    $this->setFlash('notice', $message);
    return $this->redirect('sfJob/list');
  }

  protected function getsfJobOrCreate($id = 'id')
  {
    if (!$this->getRequestParameter($id))
    {
      $sf_job = new sfJob();
      $sf_job_queue_id = $this->getRequestParameter('sf_job_queue_id', null);

      if ($sf_job_queue_id)
      {
        $sf_job->setSfJobQueueId($sf_job_queue_id);
      }
    }
    else
    {
      $sf_job = sfJobPeer::retrieveByPk($this->getRequestParameter($id));

      $this->forward404Unless($sf_job);
    }

    return $sf_job;
  }

  protected function savesfJob($sf_job)
  {
    $sf_job->save();

    $job_handler = sprintf('sf%sJobHandler', ucfirst($sf_job->getType()));
    call_user_func(array($job_handler, 'postSave'), $sf_job, unserialize($sf_job->getParams()));
  }

  protected function updatesfJobFromRequest()
  {
    parent::updatesfJobFromRequest();

    $sf_job = $this->getRequestParameter('sf_job');

    if (isset($sf_job['params']))
    {
      $this->sf_job->setParams(serialize($sf_job['params']));
    }
  }
}