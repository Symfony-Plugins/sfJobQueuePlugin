<ul class="sf_admin_actions">
  <li>
    <?php
    echo button_to(__('list'),
                   'sfJobQueue/list?id='.$sf_job_queue->getId(), 
                   array('class' => 'sf_admin_action_list'))
    ?>
  </li>
  <li>
    <?php
    echo submit_tag(__('save'),
                    array('name' => 'save_and_list',
                          'class' => 'sf_admin_action_save'))
    ?>
  </li>
  <?php if ($sf_job_queue->getId()): ?>
    <li>
      <?php
      echo button_to(__('Create a job'),
                     'sfJob/create?sf_job_queue_id='.$sf_job_queue->getId(),
                     array('style' => 'background: #ffc url(/sf/sf_admin/images/add.png) no-repeat 3px 2px'))
      ?>
    </li>
  <?php endif; ?>
</ul>
