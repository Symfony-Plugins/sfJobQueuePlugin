<?php
$classes = include(sfConfigCache::getInstance()->checkConfig(sfConfig::get('sf_app_config_dir_name').'/autoload.yml'));
$job_schedulers = preg_grep('`^sf(.+)Scheduler`', array_keys($classes));
?>
<select name="sf_job_queue[scheduler_name]" id="sf_job_queue_scheduler_name">
  <option value=""><?php echo __('Scheduling strategy') ?></option>
  <?php foreach ($job_schedulers as $job_scheduler): ?>
    <?php preg_match('`^sf(.+)Scheduler`', $job_scheduler, $name); ?>
    <option value="<?php echo $name[1]; ?>"<?php echo ($name[1] == $sf_job_queue->getSchedulerName())? ' selected="selected"' : ''; ?>><?php echo $name[1]; ?></option>
  <?php endforeach; ?>
</select>