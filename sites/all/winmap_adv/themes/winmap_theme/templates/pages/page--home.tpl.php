<?php
/**
 * Created by PhpStorm.
 * User: VDP
 * Date: 16/05/2017
 * Time: 2:10 PM
 */

print render($page['content']['metatags']);

?>

<?php if (!empty($messages)): ?>
	<div id="console" class="clearfix"><?php print $messages; ?></div>
<?php endif; ?>

<?php include('header.inc'); ?>
<?php include(drupal_get_path('theme', 'winmap_theme') . '/templates/sliders/main-slider.inc'); ?>

<div class="page-home">
  <div class="page-home-container">
    <div class="page-home-inner">

    </div>
  </div>
</div>

<?php include('footer.inc'); ?>
