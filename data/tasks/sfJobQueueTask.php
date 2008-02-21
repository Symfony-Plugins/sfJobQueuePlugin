<?php

pake_desc('list and status of the job queues');
pake_task('sfqueue-list-queues');

pake_desc('start a job queue');
pake_task('sfqueue-start-queue');

pake_desc('start the job queue manager');
pake_task('sfqueue-start-queuemanager');

pake_desc('stop a job queue');
pake_task('sfqueue-stop-queue');


function run_sfqueue_list_queues($task, $args)
{
  _sfqueue_initialize_database($args);

  $c = new Criteria();
  $c->addAscendingOrderByColumn(sfJobQueuePeer::NAME);
  $job_queues = sfJobQueuePeer::doSelect($c);

  if ( count($job_queues) > 0)
  {
    foreach ($job_queues as $job_queue)
    {
      pake_echo_action($job_queue->getName(),sprintf(' - %s, %s active, %s completed',
                        $job_queue->getStatusText(),
                        $job_queue->getNbActiveJobs(),
                        $job_queue->getNbCompletedJobs()));
    }
  }
  else
  {
    pake_echo('No job queue found.');
  }
}

function run_sfqueue_start_queue($task, $args)
{
  _sfqueue_initialize_database($args);

  if (count($args) < 2)
  {
    throw new Exception('You must provide a queue name.');
  }

  $queue_name = $args[1];
  $job_queue = sfJobQueuePeer::retrieveByQueueName($queue_name);

  if (!$job_queue)
  {
    throw new Exception('This Job queue could not be found.');
  }

  if ($job_queue->isRunning() === true)
  {
    throw new Exception('This Job queue is already running.');
  }
  else
  {
    $job_queue->setStatus(sfJobQueue::RUNNING);
    $job_queue->setRequestedStatus(sfJobQueue::RUNNING);
    $job_queue->save();
    pake_echo(sprintf('Queue "%s" started.', $queue_name));
    $job_queue->run();
  }
}

function run_sfqueue_start_queuemanager($task, $args)
{
  _sfqueue_initialize_database($args);

  // mark all the job queues as stopped before launching the job manager
  $c = new Criteria();
  $job_queues = sfJobQueuePeer::doSelect($c);

  foreach ($job_queues as $job_queue)
  {
    $job_queue->setStatus(sfJobQueue::STOPPED);
    $job_queue->setRequestedStatus(sfJobQueue::STOPPED);
    $job_queue->save();
  }

  // start the job queue manager
  $sf_job_queue_manager = new sfJobQueueManager();
  $sf_job_queue_manager->run();
}


function run_sfqueue_stop_queue($task, $args)
{
  _sfqueue_initialize_database($args);

  if (count($args) < 2)
  {
    throw new Exception('You must provide a queue name.');
  }

  $queue_name = $args[1];
  $job_queue = sfJobQueuePeer::retrieveByQueueName($queue_name);

  if (!$job_queue)
  {
    throw new Exception('This Job queue could not be found.');
  }

  if ($job_queue->isRunning() === false)
  {
    throw new Exception('This Job queue is already stopped.');
  }
  else
  {
    $job_queue->setRequestedStatus(sfJobQueue::STOPPED);
    $job_queue->save();
    pake_echo(sprintf('Queue "%s" stop requested.', $queue_name));
  }
}

function _sfqueue_initialize_database($args)
{
  if (!count($args))
  {
    throw new Exception('You must provide the app.');
  }

  $app = $args[0];

  if (!is_dir(sfConfig::get('sf_app_dir').DIRECTORY_SEPARATOR.$app))
  {
    throw new Exception('The app "'.$app.'" does not exist.');
  }

  $env = empty($args[2]) ? 'dev' : $args[2];

  // define constants
  define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
  define('SF_APP',         $app);
  define('SF_ENVIRONMENT', $env);
  define('SF_DEBUG',       true);

  // get configuration
  require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

  $databaseManager = new sfDatabaseManager();
  $databaseManager->initialize();
}