<td>
  <ul class="sf_admin_td_actions">
    <li><?php echo link_to(image_tag('/sf/sf_admin/images/edit_icon.png', array('alt' => __('edit'), 'title' => __('edit'))), 'sfJob/edit?id='.$sf_job->getId()) ?></li>
    <?php if (!in_array($sf_job->getStatus(), array(sfJob::SUCCESS, sfJob::CANCELLED, sfJob::ERROR))): ?>
      <li><?php echo link_to(image_tag('/sf/sf_admin/images/delete.png', array('alt' => __('Cancel job'), 'title' => __('Cancel job'))), 'sfJob/cancel?id='.$sf_job->getId()) ?></li>
    <?php endif; ?>
  </ul>
</td>