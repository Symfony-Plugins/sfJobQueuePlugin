<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date') ?>

<?php use_stylesheet('/sf/sf_admin/css/main') ?>

<div id="sf_admin_container">

<h1><?php echo __('edit sfJob', array()) ?></h1>

<div id="sf_admin_header">
<?php include_partial('sfJobQueue/edit_header', array('sf_job_queue' => $sf_job_queue)) ?>
</div>

<div id="sf_admin_content">
<?php include_partial('sfJobQueue/edit_messages', array('sf_job_queue' => $sf_job_queue, 'labels' => $labels)) ?>


<?php echo form_tag('sfJobQueue/saveJob'); ?>

  <fieldset id="sf_fieldset_none" class="">
    <div class="form-row">
      <?php echo label_for('sf_job_queue_id', __('Job queue'), 'class="required" ') ?>
      <div class="content<?php if ($sf_request->hasError('sf_job_queue_id')): ?> form-error<?php endif; ?>">
        <?php if ($sf_request->hasError('sf_job_queue_id')): ?>
          <?php echo form_error('sf_job_queue_id', array('class' => 'form-error-msg')) ?>
        <?php endif; ?>
    
        <?php
        echo select_tag('sf_job_queue_id', 
                        objects_for_select($sf_job_queues, 'getId', 'getName'), 
                        $sf_job->getSfJobQueueId());
        ?>
      </div>
    </div>

    <div class="form-row">
      <?php echo label_for('sf_job[type]', __('Type'), 'class="required" ') ?>
      <div class="content<?php if ($sf_request->hasError('sf_job[type]')): ?> form-error<?php endif; ?>">
        <?php if ($sf_request->hasError('sf_job[type]')): ?>
          <?php echo form_error('sf_job[type]', array('class' => 'form-error-msg')) ?>
        <?php endif; ?>
    
        <?php echo input_tag('sf_job[type]', $sf_job->getType()); ?>
      </div>
    </div>

    <div class="form-row">
      <?php echo label_for('sf_job[max_tries]', __('Max Tries'), 'class="required" ') ?>
      <div class="content<?php if ($sf_request->hasError('sf_job[max_tries]')): ?> form-error<?php endif; ?>">
        <?php if ($sf_request->hasError('sf_job[max_tries]')): ?>
          <?php echo form_error('sf_job[max_tries]', array('class' => 'form-error-msg')) ?>
        <?php endif; ?>
    
        <?php echo input_tag('sf_job[max_tries]', $sf_job->getMaxTries()); ?>
      </div>
    </div>

    <div class="form-row">
      <?php echo label_for('sf_job[retry_delay]', __('Retry delay'), 'class="required" ') ?>
      <div class="content<?php if ($sf_request->hasError('sf_job[retry_delay]')): ?> form-error<?php endif; ?>">
        <?php if ($sf_request->hasError('sf_job[retry_delay]')): ?>
          <?php echo form_error('sf_job[retry_delay]', array('class' => 'form-error-msg')) ?>
        <?php endif; ?>
    
        <?php echo input_tag('sf_job[retry_delay]', $sf_job->getRetryDelay()); ?>
      </div>
    </div>

    <div class="form-row">
      <?php echo label_for('sf_job[priority]', __('Priority'), 'class="required" ') ?>
      <div class="content<?php if ($sf_request->hasError('sf_job[priority]')): ?> form-error<?php endif; ?>">
        <?php if ($sf_request->hasError('sf_job[priority]')): ?>
          <?php echo form_error('sf_job[priority]', array('class' => 'form-error-msg')) ?>
        <?php endif; ?>
    
        <?php echo input_tag('sf_job[priority]', $sf_job->getPriority()); ?>
      </div>
    </div>

    <div class="form-row">
      <?php echo label_for('sf_job[status]', __('Status'), 'class="required" ') ?>
      <div class="content<?php if ($sf_request->hasError('sf_job[status]')): ?> form-error<?php endif; ?>">
        <?php if ($sf_request->hasError('sf_job[status]')): ?>
          <?php echo form_error('sf_job[status]', array('class' => 'form-error-msg')) ?>
        <?php endif; ?>
    
        <?php echo input_tag('sf_job[status]', $sf_job->getStatus()); ?>
      </div>
    </div>

    <div class="form-row">
      <?php echo label_for('sf_job[scheduled_at]', __('Scheduled at'), '') ?>
      <div class="content<?php if ($sf_request->hasError('sf_job[scheduled_at]')): ?> form-error<?php endif; ?>">
        <?php if ($sf_request->hasError('sf_job[scheduled_at]')): ?>
          <?php echo form_error('sf_job[scheduled_at]', array('class' => 'form-error-msg')) ?>
        <?php endif; ?>

        <?php $value = object_input_date_tag($sf_job, 'getScheduledAt', array (
        'rich' => true,
        'withtime' => true,
        'calendar_button_img' => '/sf/sf_admin/images/date.png',
        'control_name' => 'sf_job[scheduled_at]',
      )); echo $value ? $value : '&nbsp;' ?>
      </div>
    </div>

    <div class="form-row">
      <?php echo label_for('sf_job[message]', __('Message'), 'class="required" ') ?>
      <div class="content<?php if ($sf_request->hasError('sf_job[message]')): ?> form-error<?php endif; ?>">
        <?php if ($sf_request->hasError('sf_job[message]')): ?>
          <?php echo form_error('sf_job[message]', array('class' => 'form-error-msg')) ?>
        <?php endif; ?>
    
        <?php echo textarea_tag('sf_job[message]', $sf_job->getMessage()); ?>
      </div>
    </div>

    <div class="form-row">
      <?php echo label_for('sf_job[params]', __('Params'), 'class="required" ') ?>
      <div class="content<?php if ($sf_request->hasError('sf_job[params]')): ?> form-error<?php endif; ?>">
        <?php if ($sf_request->hasError('sf_job[params]')): ?>
          <?php echo form_error('sf_job[params]', array('class' => 'form-error-msg')) ?>
        <?php endif; ?>
    
        <?php echo textarea_tag('sf_job[params]', $sf_job->getParams()); ?>
      </div>
    </div>
  </fieldset>
  
  <ul class="sf_admin_actions">
    <li><?php echo button_to(__('list'), 'sfJobQueue/listJob?id='.$sf_job->getSfJobQueueId(), array (
  'class' => 'sf_admin_action_list',
)) ?></li>
    <li><?php echo submit_tag(__('save'), array (
  'name' => 'save',
  'class' => 'sf_admin_action_save',
)) ?></li>
  </ul>
</form>

</div>

<div id="sf_admin_footer">
<?php include_partial('sfJobQueue/edit_footer', array('sf_job_queue' => $sf_job_queue)) ?>
</div>

</div>