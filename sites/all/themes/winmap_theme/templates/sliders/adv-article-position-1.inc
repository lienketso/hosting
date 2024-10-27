<?php

global $language;
$lang_name = $language->language;
$term = taxonomy_term_load(8);


if ( module_exists ('i18n')) {
  $translated_term = i18n_taxonomy_term_get_translation($term, $lang_name);

}else {
  $translated_term = $term;
}


$_adv = winmap_adv_view_adv($translated_term->tid);
?>

<?php if (!empty($_adv)): ?>
  <?php drupal_add_js(drupal_get_path('theme', 'winmap_theme') . '/js/slider-adv.js', array('weight' => 1000)); ?>
  <div class="winmap-adv">
    <div class="winmap-adv-container">
      <?php print($_adv); ?>
    </div>
  </div>
<?php endif; ?>

