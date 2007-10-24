<?php
/*
 * This file is part of the sfJobQueuePlugin package.
 */
interface sfJobHandlerInterface
{
  public function getParamFields();
  public function run($params);
}