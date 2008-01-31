<?php
/*
 * This file is part of the sfJobQueuePlugin package.
 */

/**
 * Interface for job handlers.
 *
 * @author Xavier Lacot <xavier@lacot.org>
 * @author Tristan Rivoallan <tristan@rivoallan.net>
 * @see http://trac.symfony-project.com/wiki/sfJobQueuePlugin#Creatinganewjobtype
 */
abstract class sfJobHandler
{
  protected $logger;

  public function __construct()
  {
    $this->logger = sfFlexibleLogger::getInstance();
    $this->logger->setLogLevel(SF_LOG_INFO);
  }

  public function getLogger()
  {
    return $this->logger;
  }

  /**
   * Returns the lists of parameters accepted by the job.
   *
   * The array must have the form :
   *
   * <code>
   *   array('param1', 'param2', 'param3', etc.)
   * </code>
   *
   * @return array
   */
  public function getParamFields()
  {
    return array();
  }

  /**
   * Executes the job.
   *
   * @param  array  $params   An array of valued job parameters. The key is the
   * parameter name (as what returns the getParamFields() method), and the value
   * is the parameter's value.
   *
   * @throws  Exception  When job execution does not succeed.
   * @return  sfJobQueue::SUCCESS if job execution succeeded.
   */
  abstract public function run(array $params);

  /**
   * Called after a job creation
   *
   * @param    sfJob      the related job
   * @param    array      array of params of the job
   */
  public static function postSave(sfJob $job, array $params)
  {
  }

  /**
   * Attach the job back to its handler. Permits to use the Propel job logger
   *
   * @param  job    $sf_job   The job that is binded to the current jobhandler
   * execution
   */
  public function setSfJob(sfJob $sf_job)
  {
    $sf_propel_job_logger = $this->logger->getLogger('sfPropelJobLogger');

    if (is_null($sf_propel_job_logger))
    {
      $sf_propel_job_logger = new sfPropelJobLogger();
    }

    $sf_propel_job_logger->initialize(array('sf_job_id' => $sf_job->getId()));
    $this->logger->registerLogger($sf_propel_job_logger);
  }
}