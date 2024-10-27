<?php

$_3s_hotline = variable_get('3s_hotline');
$_3s_title = variable_get('3s_title');
$_3s_content = variable_get('3s_content');
if (!empty($_3s_content['value'])) {
    $_3s_content = $_3s_content['value'];
}else {
    $_3s_content = "";
}

$_3s_copyright = variable_get('3s_copyright');
if (!empty($_3s_copyright['value'])) {
    $_3s_copyright = $_3s_copyright['value'];
}else {
    $_3s_copyright = "";
}

?>

<div class="page-login">
    <div class="container page-login-container">
        <div class="page-login-container-inner">
            <div class="block-login-header">
                <div class="block-login-header-container">
                    <div class="block-login-logo">
                        <a href="/"><img class="img-responsive" src="/sites/all/themes/winmap_admin_theme/images/login-logo.png"></a>
                    </div>
                    <div class="block-login-hotline">
                        <i class="fa fa-phone-square"></i> Hotline: <span><?php print($_3s_hotline); ?></span>
                    </div>
                </div>
            </div>

            <div class="block-login-body">
                <div class="row block-login-body-container">
                    <div class="col-sm-6 col-xs-12">
                        <h3 class="block-login-site-name"><?php print($_3s_title); ?></h3>
                        <div class="block-login-intro"><?php print($_3s_content); ?></div>
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
                <div class="block-login-footer-container"><?php print ($_3s_copyright);?></div>
            </div>
        </div>
    </div>
</div>
