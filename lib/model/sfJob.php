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
 * This plugins enables job queues into Symfony. It includes all the common job
 * queues tasks (start, stop, scheduling through job election strategies, etc.),
 * command line tasks, and a graphical interface for managing queues and jobs.
 * Using a job queue can be useful when asynchronised server-side operations
 * have to be performed (periodically grabbing a RSS feed, automatically sending
 * emails, etc.) or in environments without a cron access.
 *
 * @author   Xavier Lacot <xavier@lacot.org>
 * @see      http://www.symfony-project.com/trac/wiki/sfJobQueuePlugin
 */
class sfJob extends BasesfJob
{
  const ERROR     = -9;
  const CANCELLED = -1;
  const STOPPED   = 0;
  const RUNNING   = 1;
  const IDLE      = 2;
  const SUCCESS   = 9;

  public static $status_text = array(sfJob::ERROR     => 'error',
                                     sfJob::CANCELLED => 'cancelled',
                                     sfJob::STOPPED   => 'stopped',
                                     sfJob::RUNNING   => 'running',
                                     sfJob::IDLE      => 'idle',
                                     sfJob::SUCCESS   => 'success');

  protected $jobhandler;

  public function __construct($type = '', $options = null)
  {
    $job_handler = sprintf('sf%sJobHandler', ucfirst($type));

    if (!class_exists($job_handler))
    {
      throw new Exception(sprintf('Could not find any job of type %s', $job_handler));
    }

    $this->setCreatedAt(time());
    $this->setTries(0);
    $this->setPriority(0);

    if ($type != '')
    {
      $this->setType($type);
    }

    if (isset($options['scheduled_at']))
    {
      $this->setScheduledAt($options['scheduled_at']);
      unset($options['scheduled_at']);
    }

    if (isset($options['is_recurring']))
    {
      $this->setIsRecurring($options['is_recurring']);
      unset($options['is_recurring']);
    }

    if (isset($options['max_tries']))
    {
      $this->setMaxTries($options['max_tries']);
      unset($options['max_tries']);
    }
    else
    {
      $max_tries = sfConfig::get('app_sfJobQueuePlugin_max_tries', 3);
      $this->setMaxTries($max_tries);
    }

    if (!is_null($options))
    {
      $this->setParams(serialize($options));
    }
  }

  public function __destruct()
  {
    restore_error_handler();
  }

  /**
   * Returns the status of the job, as a text
   *
   * @return    string
   */
  public function getStatusText()
  {
    $status_text = self::$status_text;
    return $status_text[$this->getStatus()];
  }

  /**
   * Runs the job
   */
  public function run()
  {
    register_shutdown_function(array($this, 'shutdown'));
    set_error_handler(array($this, 'handleRuntimeError'));
    $status_text = '';

    // increment number of tries
    $this->setTries($this->getTries() + 1);
    $this->setLastTriedAt(time());
    $this->setStatus(sfJob::RUNNING);
    $this->save();

    $params = $this->getParams();
    $params = ($params != null) ? unserialize($params) : array();
    $job_class = sprintf('sf%sJobHandler', ucfirst($this->getType()));
    $this->jobhandler = new $job_class;

    try
    {
      $this->jobhandler->setSfJob($this);
      $status = $this->jobhandler->run($params);

      if ($status == '' || $status == null)
      {
        $status = self::SUCCESS;
      }

      $this->setMessage('');
    }
    catch (Exception $e)
    {
      if (!$this->getIsRecurring())
      {
        $status = self::ERROR;
      }

      // messages should be logged here
      $status_text = $e->getMessage();
      $this->setMessage($status_text);
      $this->jobhandler->getLogger()->err(sprintf('{sfJob} Exception thrown: %s',
                                                  $e->getMessage()));
    }

    if (!$this->getIsRecurring())
    {
      if (($this->getTries() >= $this->getMaxTries())
          && ($status != self::SUCCESS)
          && ($status != self::ERROR))
      {
        $status = self::ERROR;
        $this->setMessage('Too many tries.');
      }

      if (($status == self::SUCCESS) || ($status == self::ERROR))
      {
        $this->setCompletedAt(time());
      }

      $this->setStatus($status);
    }
    else
    {
      $this->setStatus(sfJob::IDLE);
    }

    $this->save();
    restore_error_handler();
    return $status_text;
  }

  /**
   * Handles PHP runtime error. Since jobs are executed in the background, we
   * need to capture all error cases.
   *
   * @author  Tristan Rivoallan <trivoallan@clever-age.com>
   * @author  Xavier Lacot <xavier@lacot.org>
   * @see     http://php.net/set_error_handler
   */
  public function handleRuntimeError($errno, $errstr, $errfile = null, $errline = null, $errcontext = array())
  {
    $error_types = array (
       E_ERROR              => 'Error',
       E_WARNING            => 'Warning',
       E_PARSE              => 'Parsing Error',
       E_NOTICE             => 'Notice',
       E_CORE_ERROR         => 'Core Error',
       E_CORE_WARNING       => 'Core Warning',
       E_COMPILE_ERROR      => 'Compile Error',
       E_COMPILE_WARNING    => 'Compile Warning',
       E_USER_ERROR         => 'User Error',
       E_USER_WARNING       => 'User Warning',
       E_USER_NOTICE        => 'User Notice',
       E_STRICT             => 'Strict compliance warning'
    );

    if (version_compare(PHP_VERSION, '5.2', '>='))
    {
      $error_types[E_RECOVERABLE_ERROR] = 'Catchable Fatal Error';
    }

    $msg = sprintf('%s : "%s" occured in %s on line %d',
                   $error_types[$errno], $errstr, $errfile, $errline);

    switch ($errno)
    {
      // A notice cannot fail the job
      case E_NOTICE:
        $this->setMessage($msg);
        break;
      default:
        // An error occured, revert status to idle
        $this->setStatus(self::IDLE);
        $this->setMessage($msg);

        // Max number of tries reached, change status to "error"
        if (!$this->getIsRecurring()
            && ($this->getTries() >= $this->getMaxTries()))
        {
          $this->setStatus(self::ERROR);
          $this->setCompletedAt(time());
          $this->setMessage('Too many tries. '.$this->getMessage());
        }
    }

    $this->save();
  }

  /**
   * overrides the default save() method. When a job is saved, use its id as
   * name if the name is empty.
   */
  public function save($con = null)
  {
    if ($this->getName() == '')
    {
      $this->setName($this->getId());
    }

    parent::save();
  }

  /**
   * Called at the execution shutdown while the job was running (ie., fatal
   * error)
   */
  public function shutdown()
  {
    if ($this->getStatus() == self::RUNNING)
    {
      $error = error_get_last();

      if ($error)
      {
        $this->jobhandler->getLogger()->err(sprintf('{sfJob} Process died during execution. Last error was "%s" on line %s of file %s.',
                                                    $error['message'],
                                                    $error['line'],
                                                    $error['file']));
      }
      else
      {
        $this->jobhandler->getLogger()->err('{sfJob} Process died during execution.');
      }

      if (!$this->getIsRecurring()
          && ($this->getTries() >= $this->getMaxTries()))
      {
        $this->setStatus(self::ERROR);
        $this->setCompletedAt(time());
      }
      else
      {
        $this->setStatus(self::IDLE);
      }

      $this->save();
    }

    restore_error_handler();
  }
}