<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
              <?php if (!empty($_user) && !empty($_user->picture)): ?>
                <?php
                $_user_avatar = (array) $_user->picture;
                $_user_avatar['style_name'] = 'style_60x60';
                $_user_avatar['path'] = $_user_avatar['uri'];
                $_user_avatar['attributes'] = array('class' => 'img-circle');
                $_user_avatar_url = image_style_url('style_60x60', $_user_avatar['path']);
                print ('<img src="' . $_user_avatar_url . '" class="img-circle user-image" alt="User Image">');
                ?>
              <?php else: ?>
                  <img src="<?php print ($base_url . '/' . drupal_get_path('theme', 'winmap_admin_theme') . '/images/avatar.png') ?>"
                       class="img-circle" alt="User Image">
              <?php endif; ?>
            </div>
            <div class="pull-left info">
                <p><?php print ($user->name); ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control"
                       placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn"
                        class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header"><?php print (t('MAIN NAVIGATION')); ?></li>
          <?php echo winmap_admin_get_menu_left('winmap_admin_get_menu_left_winmap_admin_theme') ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
