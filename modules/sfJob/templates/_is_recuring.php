<?php if ($sf_job->getIsRecuring()): ?>
  <?php echo image_tag('/sf/sf_admin/images/save.png') ?>
<?php else: ?>
  <?php echo image_tag('/sf/sf_admin/images/cancel.png') ?>
<?php endif; ?>