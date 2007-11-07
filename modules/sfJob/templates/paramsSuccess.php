<?php use_helper('I18N'); ?>

<?php foreach ($fields as $field): ?>
  <div class="form-row">
    <?php echo label_for('sf_job[params]['.$field.']', __($field), '') ?>
    <div class="content">
      <?php
      echo input_tag('sf_job[params]['.$field.']',
                     isset($params[$field]) ? $params[$field] : '',
                     array ('size' => 30));
      ?>
    </div>
  </div>
<?php endforeach; ?>