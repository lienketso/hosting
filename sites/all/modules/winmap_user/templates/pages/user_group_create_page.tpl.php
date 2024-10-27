<?php
$winmap_user_group_form = drupal_get_form('winmap_user_group_form');
$winmap_user_group_form = drupal_render($winmap_user_group_form);
print($winmap_user_group_form);
?>
