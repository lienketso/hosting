<?php

$user_group = $variables['user_group'];
$winmap_user_group_form = drupal_get_form('winmap_user_group_form',$user_group);
$winmap_user_group_form = drupal_render($winmap_user_group_form);
print($winmap_user_group_form);

