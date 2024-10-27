<?php

$_winmap_hotline = variable_get('winmap_hotline');
$_winmap_title = variable_get('winmap_title');
$_winmap_content = variable_get('winmap_content');
if (!empty($_winmap_content['value'])) {
  $_winmap_content = $_winmap_content['value'];
}else {
  $_winmap_content = "";
}

$_winmap_copyright = variable_get('winmap_copyright');
if (!empty($_winmap_copyright['value'])) {
  $_winmap_copyright = $_winmap_copyright['value'];
}else {
  $_winmap_copyright = "";
}

?>

<div class="page-login">
  <div class="container page-login-container">
    <div class="page-login-container-inner">
      <div class="block-login-header">
        <div class="block-login-header-container">
          <div class="block-login-logo">
            <a href="/"><img class="img-responsive" style="max-width: 280px;" src="/sites/all/themes/winmap_admin_theme/images/login-logo.png"></a>
          </div>
          <div class="block-login-hotline">
            <i class="fa fa-phone-square"></i> Hotline: <span><?php print($_winmap_hotline); ?></span>
          </div>
        </div>
      </div>

      <div class="block-login-body">
        <div class="row block-login-body-container">
          <div class="col-sm-6 col-xs-12">
            <h3 class="block-login-site-name"><?php print($_winmap_title); ?></h3>
            <div class="block-login-intro"><?php print($_winmap_content); ?></div>
          </div>
          <div class="col-sm-6 col-xs-12">
            <div class="region region-content">
              <section id="block-system-main" class="block block-system clearfix">
                <?php print render($page['content']); ?>
              </section>
            </div>
          </div>
        </div>
      </div>

      <div class="block-login-footer">
        <div class="block-login-footer-container"><?php print ($_winmap_copyright);?></div>
      </div>
    </div>
  </div>
</div>
