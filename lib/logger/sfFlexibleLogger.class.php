<?php
class sfFlexibleLogger extends sfLogger
{
  /**
   * Returns the sfFlexibleLogger instance.
   *
   * @return  object the sfFlexibleLogger instance
   */
  public static function getInstance()
  {
    // the class exists
    $class = __CLASS__;
    sfFlexibleLogger::$logger = new $class();
    sfFlexibleLogger::$logger->initialize();

    return sfFlexibleLogger::$logger;
  }

  public function getLogger($type)
  {
    if (isset($this->logger[$type]))
    {
      return $this->logger[$type];
    }
  }

  /**
   * Registers a logger.
   *
   * @param object Logger
   */
  public function registerLogger($logger)
  {
    $this->loggers[get_class($logger)] = $logger;
  }

  /**
   * Unregisters a logger.
   *
   * @param string Logger class name
   */
  public function unregisterLogger(string $type)
  {
    if (isset($this->logger[$type]))
    {
      unset($this->logger[$type]);
    }
  }
}