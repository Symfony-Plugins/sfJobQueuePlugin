<?php use_helper('I18N', 'Date') ?>

<h2><?php echo $sf_job->getName() ?></h2>

<?php if (isset($logs)): ?>
  <table cellspacing="0">
    <tr>
      <th><?php echo __('Date') ?></th>
      <th><?php echo __('Type') ?></th>
      <th><?php echo __('Job') ?></th>
      <th><?php echo __('Message') ?></th>
    </tr>
    <?php foreach ($logs as $log): ?>
      <?php
      preg_match('/{(.*)}(.*)/', $log->getMessage(), $matches);
      ?>
      <tr class="<?php echo $log->getPriorityName() ?>">
        <td><?php echo format_date($log->getCreatedAt(), "MM/dd HH:mm:ss") ?></td>
        <td><?php echo $log->getPriorityName() ?></td>
        <td><?php echo (isset($matches[1])) ? $matches[1] : '-'; ?></td>
        <td><?php echo (isset($matches[2])) ? $matches[2] : $log->getMessage() ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php else: ?>
  <p><?php echo __('There are no logs for this job') ?></p>
<?php endif; ?>