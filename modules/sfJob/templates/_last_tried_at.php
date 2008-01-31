<?php if ($sf_job->getLastTriedAt() !== null && $sf_job->getLastTriedAt() !== ''): ?>
  <?php echo format_date($sf_job->getLastTriedAt(), "MM/dd HH:mm:ss"); ?>
  <?php
  echo link_to_remote(__('(log)'),
                      array('update' => 'sf_job_logs',
                            'url'    => 'sfJob/getLogs?id='.$sf_job->getId()));
  ?>
<?php endif; ?>