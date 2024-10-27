

<div class="wrapper">
  <?php include(drupal_get_path('theme', 'winmap_admin_theme') . '/templates/admin-main-header.inc'); ?>
  <?php include(drupal_get_path('theme', 'winmap_admin_theme') . '/templates/admin-main-sidebar.inc'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div id="page" class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <?php if ($title): ?>
        <h1 class="page-title">
          <?php print $title; ?>
        </h1>
      <?php endif; ?>

      <?php if ($primary_local_tasks): ?>
        <ul class='primary-local-tasks links clearfix'><?php print render($primary_local_tasks) ?></ul>
      <?php elseif (!empty($breadcrumb)): ?>
        <?php print $breadcrumb; ?>
      <?php endif; ?>

    </section>
    <!-- Main content -->
    <section class="content">
      <div id="content" class="clearfix">
        <div class="element-invisible"><a id="main-content"></a></div>
        <?php if ($messages): ?>
          <div id="console"
               class="clearfix"><?php print $messages; ?></div>
        <?php endif; ?>
        <?php if ($page['help']): ?>
          <div id="help">
            <?php print render($page['help']); ?>
          </div>
        <?php endif; ?>
        <?php if ($action_links): ?>
          <ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
        <?php print render($page['content']); ?>
      </div>
    </section>
    <!-- /.content -->
  </div>

  <?php include(drupal_get_path('theme', 'winmap_admin_theme') . '/templates/admin-main-footer.inc'); ?>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">

    </ul>
    <!-- Tab panes -->
    <div class="tab-content">

    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>

