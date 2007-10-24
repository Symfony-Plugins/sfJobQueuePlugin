<?php

class sfMailJobHandler extends sfJobHandler implements sfJobHandlerInterface
{
  public function getParamFields()
  {
    return array('from', 'to', 'subject', 'message');
  }

  public function run($params)
  {
    if (false && mail($params['to'], 
             $params['subject'], 
             $params['message'], 
             'From: '.$params['from']))
    {
      return sfJob::SUCCESS;
    }
    else
    {
      throw new Exception('There was an error while sending the mail.');
      return sfJob::ERROR;
    }
  }
}