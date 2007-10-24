<table cellspacing="0" class="sf_admin_list">
  <thead>
    <tr>
      <?php include_partial('list_th_tabular') ?>
      <th id="sf_admin_list_th_sf_actions" rowspan="2"><?php echo __('Actions') ?></th>
    </tr>
    <tr>
      <?php include_partial('list_th_tabular2') ?>
    </tr>
  </thead>
  <tbody>
    <?php $i = 1; foreach ($pager->getResults() as $sf_job_queue): $odd = fmod(++$i, 2) ?>
      <tr class="sf_admin_row_<?php echo $odd ?>">
        <?php include_partial('list_td_tabular', array('sf_job_queue' => $sf_job_queue)) ?>
        <?php include_partial('list_td_actions', array('sf_job_queue' => $sf_job_queue)) ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <th colspan="12">
        <div class="float-right">
          <?php if ($pager->haveToPaginate()): ?>
            <?php echo link_to(image_tag(sfConfig::get('sf_admin_web_dir').'/images/first.png', array('align' => 'absmiddle', 'alt' => __('First'), 'title' => __('First'))), 'sfJobQueue/list?page=1') ?>
            <?php echo link_to(image_tag(sfConfig::get('sf_admin_web_dir').'/images/previous.png', array('align' => 'absmiddle', 'alt' => __('Previous'), 'title' => __('Previous'))), 'sfJobQueue/list?page='.$pager->getPreviousPage()) ?>

            <?php foreach ($pager->getLinks() as $page): ?>
              <?php echo link_to_unless($page == $pager->getPage(), $page, 'sfJobQueue/list?page='.$page) ?>
            <?php endforeach; ?>

            <?php echo link_to(image_tag(sfConfig::get('sf_admin_web_dir').'/images/next.png', array('align' => 'absmiddle', 'alt' => __('Next'), 'title' => __('Next'))), 'sfJobQueue/list?page='.$pager->getNextPage()) ?>
            <?php echo link_to(image_tag(sfConfig::get('sf_admin_web_dir').'/images/last.png', array('align' => 'absmiddle', 'alt' => __('Last'), 'title' => __('Last'))), 'sfJobQueue/list?page='.$pager->getLastPage()) ?>
          <?php endif; ?>
        </div>
        <?php echo format_number_choice('[0] no result|[1] 1 result|(1,+Inf] %1% results', array('%1%' => $pager->getNbResults()), $pager->getNbResults()) ?>
      </th>
    </tr>
  </tfoot>
</table>