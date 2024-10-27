<?php

$customer = $variables['customer'];
$winmap_customer_form = drupal_get_form('winmap_customer_form',$customer);
$winmap_customer_form = drupal_render($winmap_customer_form);
print($winmap_customer_form);
