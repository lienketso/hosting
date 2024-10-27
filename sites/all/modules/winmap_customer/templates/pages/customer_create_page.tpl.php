<?php
$winmap_customer_form = drupal_get_form('winmap_customer_form');
$winmap_customer_form = drupal_render($winmap_customer_form);
print($winmap_customer_form);
?>
