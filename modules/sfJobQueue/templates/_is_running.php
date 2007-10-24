<?php use_helper('Javascript'); ?>
<?php $status = $sf_job_queue->getStatus(); ?>
<?php $requested_status = $sf_job_queue->getRequestedStatus(); ?>
<div id="sf_job_queue_status_<?php echo $sf_job_queue->getId(); ?>">
  <?php if ($requested_status == sfJobQueue::RUNNING): ?>
    <?php if ($status == sfJobQueue::RUNNING): ?>
      <?php echo link_to(image_tag('/sf/sf_admin/images/save.png'), 'sfJobQueue/switchStatus?id='.$sf_job_queue->getId()) ?>
    <?php else: ?>
      <?php echo link_to(image_tag('/sf/sf_admin/images/cancel.png'), 'sfJobQueue/switchStatus?id='.$sf_job_queue->getId()) ?>
      (being started)
      <?php
      echo periodically_call_remote(array(
      'frequency' => 3,
      'update'    => 'sf_job_queue_status_'.$sf_job_queue->getId(),
      'url'       => 'sfJobQueue/updateStatus?id='.$sf_job_queue->getId()))
      ?>
    <?php endif; ?>
  <?php else: ?>
    <?php if ($status == sfJobQueue::RUNNING): ?>
      <?php echo image_tag('/sf/sf_admin/images/save.png') ?>
      (waiting for current job completion)
      <?php
      echo periodically_call_remote(array(
      'frequency' => 3,
      'update'    => 'sf_job_queue_status_'.$sf_job_queue->getId(),
      'url'       => 'sfJobQueue/updateStatus?id='.$sf_job_queue->getId()))
      ?>
    <?php else: ?>
      <?php echo link_to(image_tag('/sf/sf_admin/images/cancel.png'), 'sfJobQueue/switchStatus?id='.$sf_job_queue->getId()) ?>
    <?php endif; ?>
  <?php endif; ?>
</div>