<?php echo $sf_job->getStatusText(); ?>
<?php if ($sf_job->getMessage() != ''): ?>
  <?php
  echo image_tag(sfConfig::get('sf_admin_web_dir').'/images/help.png',
                 array('align' => 'absmiddle',
                       'alt'   => $sf_job->getMessage(),
                       'title' => $sf_job->getMessage()));
  ?>
<?php endif; ?>