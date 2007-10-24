<?php use_helper('Object') ?>

<div class="sf_admin_filters">
<?php echo form_tag('sfJobQueue/list', array('method' => 'get')) ?>

  <fieldset>
    <h2><?php echo __('filters') ?></h2>

    <div class="form-row">
      <label for="type"><?php echo __('Status:') ?></label>
      <div class="content">
        <?php
        echo select_tag('filters[status]', 
                        options_for_select(array('' => '') + sfJobQueue::$status_text,
                                           isset($filters['status']) ? $filters['status'] : null))
        ?>
      </div>
    </div>
  </fieldset>

  <ul class="sf_admin_actions">
    <li><?php echo button_to(__('reset'), 'sfJobQueue/list?filter=filter', 'class=sf_admin_action_reset_filter') ?></li>
    <li><?php echo submit_tag(__('filter'), 'name=filter class=sf_admin_action_filter') ?></li>
  </ul>

</form>
</div>
