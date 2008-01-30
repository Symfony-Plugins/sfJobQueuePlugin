<?php if ($sf_request->getError('delete')): ?>
  <div class="form-errors">
    <h2><?php echo __('Could not delete the selected %name%', array('%name%' => 'Sf job')) ?></h2>
    <ul>
      <li><?php echo $sf_request->getError('delete') ?></li>
    </ul>
  </div>
<?php endif; ?>

<?php if ($sf_flash->has('notice')): ?>
  <div class="save-ok">
    <h2><?php echo __($sf_flash->get('notice')) ?></h2>
  </div>
<?php endif; ?>