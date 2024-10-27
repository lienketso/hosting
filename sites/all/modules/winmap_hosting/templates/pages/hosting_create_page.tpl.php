<?php
    $winmap_hosting_form = drupal_get_form('winmap_hosting_form');
    $winmap_hosting_form = drupal_render($winmap_hosting_form);
    print($winmap_hosting_form);
?>
