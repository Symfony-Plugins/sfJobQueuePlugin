<td>
<ul class="sf_admin_td_actions">
  <li><?php echo link_to(image_tag('/sf/sf_admin/images/edit_icon.png', array('alt' => __('edit'), 'title' => __('edit'))), 'sfJobQueue/edit?id='.$sf_job_queue->getId()) ?></li>
  <li><?php echo link_to(image_tag('/sf/sf_admin/images/add.png', array('alt' => __('Create a job'), 'title' => __('Create a job'))), 'sfJob/create?sf_job_queue_id='.$sf_job_queue->getId()) ?></li>
</ul>
</td>
