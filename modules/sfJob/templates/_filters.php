<?php use_helper('Object') ?>
<div class="sf_admin_filters">
<?php echo form_tag('sfJob/list', array('method' => 'get')) ?>
  <fieldset>
    <h2><?php echo __('filters') ?></h2>
    <div class="form-row">
      <label for="type"><?php echo __('Type:') ?></label>
      <div class="content">
        <?php
        $classes = include(sfConfigCache::getInstance()->checkConfig(sfConfig::get('sf_app_config_dir_name').'/autoload.yml'));
        $job_handlers = preg_grep('`^sf(.+)JobHandler$`', array_keys($classes));
        ?>
        <select name="filters[type]" id="filters_type">
          <option value=""></option>
          <?php foreach ($job_handlers as $job_handler): ?>
            <?php preg_match('`^sf(.+)JobHandler$`', $job_handler, $name); ?>
            <option value="<?php echo $name[1]; ?>"<?php echo (isset($filters['type']) && $filters['type'] == $name[1]) ? ' selected="selected"' : null ?>><?php echo $name[1]; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="form-row">
      <label for="type"><?php echo __('Status:') ?></label>
      <div class="content">
        <?php
        echo select_tag('filters[status]', 
                        options_for_select(array('' => '') + sfJob::$status_text,
                                           isset($filters['status']) ? $filters['status'] : null))
        ?>
      </div>
    </div>

        <div class="form-row">
    <label for="sf_job_queue_id"><?php echo __('Sf job queue:') ?></label>
    <div class="content">
    <?php echo object_select_tag(isset($filters['sf_job_queue_id']) ? $filters['sf_job_queue_id'] : null, null, array (
  'include_blank' => true,
  'related_class' => 'sfJobQueue',
  'text_method' => '__toString',
  'control_name' => 'filters[sf_job_queue_id]',
)) ?>
    </div>
    </div>

      </fieldset>

  <ul class="sf_admin_actions">
    <li><?php echo button_to(__('reset'), 'sfJob/list?filter=filter', 'class=sf_admin_action_reset_filter') ?></li>
    <li><?php echo submit_tag(__('filter'), 'name=filter class=sf_admin_action_filter') ?></li>
  </ul>

</form>
</div>
