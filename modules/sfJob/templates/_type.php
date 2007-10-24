<?php
$classes = include(sfConfigCache::getInstance()->checkConfig(sfConfig::get('sf_app_config_dir_name').'/autoload.yml'));
$job_handlers = preg_grep('`^sf(.+)JobHandler$`', array_keys($classes));
?>
<select name="sf_job[type]" id="sf_job_type">
  <option value="">Select a job type</option>
  <?php foreach ($job_handlers as $job_handler): ?>
    <?php preg_match('`^sf(.+)JobHandler$`', $job_handler, $name); ?>
    <option value="<?php echo $name[1]; ?>"<?php echo ($name[1] == $sf_job->getType())? ' selected="selected"' : ''; ?>><?php echo $name[1]; ?></option>
  <?php endforeach; ?>
</select>

<?php if ($sf_job->getType()): ?>
  <?php
  echo javascript_tag(
    remote_function(array(
      'update'   => 'sf_job_properties_form',
      'url'      => 'sfJob/params',
      'with'     => "'type=".$sf_job->getType()."&id=".$sf_job->getId()."'",
    ))
  );
  ?>
<?php endif; ?>

<?php
echo observe_field('sf_job_type',
                   array('update'   => 'sf_job_properties_form',
                         'url'      => 'sfJob/params',
                         'with'     => "'type=' + \$F('sf_job_type') + '&id=".$sf_job->getId()."'", 
                         'complete' => visual_effect('highlight', 'sf_job_properties_form')));
?>