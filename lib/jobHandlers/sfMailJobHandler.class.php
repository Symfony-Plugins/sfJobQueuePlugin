<?php

class sfMailJobHandler extends sfJobHandler
{
  public function getParamFields()
  {
    return array('from', 'to', 'subject', 'message');
  }

  public function run(array $params)
  {
    if (mail($params['to'],
             $params['subject'],
             $params['message'],
             'From: '.$params['from']))
    {
      $this->logger->log(sprintf('{sfMailJobHandler} successfully sent mail %s -> %s', $params['from'], $params['to']));
      return sfJob::SUCCESS;
    }
    else
    {
      throw new Exception('There was an error while sending the mail.');
    }
  }
}