  <th id="sf_admin_list_th_nb_active_jobs_ready">
    <?php echo __('ready') ?>
    <?php echo image_tag(sfConfig::get('sf_admin_web_dir').'/images/help.png', array('align' => 'absmiddle', 'alt' => __('number of jobs ready to be executed'), 'title' => __('number of jobs ready to be executed'))) ?>
  </th>
  <th id="sf_admin_list_th_nb_active_jobs_waiting">
    <?php echo __('waiting') ?>
    <?php echo image_tag(sfConfig::get('sf_admin_web_dir').'/images/help.png', array('align' => 'absmiddle', 'alt' => __('number of waiting jobs'), 'title' => __('number of waiting jobs'))) ?>
  </th>
  <th id="sf_admin_list_th_nb_active_jobs_recuring">
    <?php echo __('recuring') ?>
    <?php echo image_tag(sfConfig::get('sf_admin_web_dir').'/images/help.png', array('align' => 'absmiddle', 'alt' => __('number of recuring jobs'), 'title' => __('number of recuring jobs'))) ?>
  </th>
  <th id="sf_admin_list_th_nb_active_jobs_scheduled">
    <?php echo __('scheduled') ?>
    <?php echo image_tag(sfConfig::get('sf_admin_web_dir').'/images/help.png', array('align' => 'absmiddle', 'alt' => __('number of scheduled jobs'), 'title' => __('number of scheduled jobs'))) ?>
  </th>
  <th id="sf_admin_list_th_nb_active_jobs">
    <?php echo __('total') ?>
    <?php echo image_tag(sfConfig::get('sf_admin_web_dir').'/images/help.png', array('align' => 'absmiddle', 'alt' => __('total number of active jobs'), 'title' => __('total number of active jobs'))) ?>
  </th>
  <th id="sf_admin_list_th_nb_completed_jobs_success">
    <?php echo __('success') ?>
  </th>
  <th id="sf_admin_list_th_nb_completed_jobs_cancelled">
    <?php echo __('cancelled') ?>
  </th>
  <th id="sf_admin_list_th_nb_completed_jobs_failure">
    <?php echo __('failure') ?>
  </th>