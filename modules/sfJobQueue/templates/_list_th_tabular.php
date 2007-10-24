  <th id="sf_admin_list_th_name" rowspan="2">
    <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/sf_job_queue/sort') == 'name'): ?>
      <?php echo link_to(__('Name'), 'sfJobQueue/list?sort=name&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/sf_job_queue/sort') == 'asc' ? 'desc' : 'asc')) ?>
      (<?php echo __($sf_user->getAttribute('type', 'asc', 'sf_admin/sf_job_queue/sort')) ?>)
    <?php else: ?>
      <?php echo link_to(__('Name'), 'sfJobQueue/list?sort=name&type=asc') ?>
    <?php endif; ?>
  </th>
  <th id="sf_admin_list_th_is_running" rowspan="2">
        <?php echo __('Is running') ?>
  </th>
  <th id="sf_admin_list_th_created_at" rowspan="2">
    <?php if ($sf_user->getAttribute('sort', null, 'sf_admin/sf_job_queue/sort') == 'created_at'): ?>
      <?php echo link_to(__('Date of creation'), 'sfJobQueue/list?sort=created_at&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/sf_job_queue/sort') == 'asc' ? 'desc' : 'asc')) ?>
      (<?php echo __($sf_user->getAttribute('type', 'asc', 'sf_admin/sf_job_queue/sort')) ?>)
    <?php else: ?>
      <?php echo link_to(__('Date of creation'), 'sfJobQueue/list?sort=created_at&type=asc') ?>
    <?php endif; ?>
  </th>
  <th id="sf_admin_list_th_active_jobs" colspan="5">
    <?php echo __('Active jobs') ?>
  </th>
  <th id="sf_admin_list_th_completed_jobs" colspan="3">
    <?php echo __('Completed jobs') ?>
  </th>