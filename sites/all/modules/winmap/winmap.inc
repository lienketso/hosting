<?php


function winmap_dashboard_page_callback () {
  return _winmap_render_theme("module","winmap","templates/dashboard.tpl.php");
}
function winmap_home_page_callback() {
    return 'aaaa';
}

function winmap_config_form() {
  $form = array();
  // Site inforemation
  $form['winmap_config_site'] = array(
    '#type' => "fieldset",
    '#title' => t('Website information'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['winmap_config_site']['site_name'] = array(
    '#type' => "textfield",
    '#title' => t('Website name'),
    "#default_value" => variable_get('site_name', ''),
  );

  $form['winmap_config_site']['site_mail'] = array(
    '#type' => "textfield",
    '#title' => t('Website Email'),
    "#default_value" => variable_get('site_mail', ''),
  );

  $form['winmap_config_site']['hotline'] = array(
    '#type' => "textfield",
    '#title' => t('Hotline'),
    "#default_value" => variable_get('hotline', ''),
  );

  $form['winmap_config_social'] = array(
    '#type' => "fieldset",
    '#title' => 'Social',
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  $form['winmap_config_social']['youtobe_url'] = array(
    '#type' => "textfield",
    "#title" => t('Youtobe ') . ' ' . t('link'),
    "#default_value" => variable_get('youtobe_url', ''),
  );

  $form['winmap_config_social']['facebook_url'] = array(
    '#type' => "textfield",
    "#title" => t('Facebook') . ' ' . t('link'),
    "#default_value" => variable_get('facebook_url', ''),
  );

  $form['winmap_config_social']['twitter_url'] = array(
    '#type' => "textfield",
    "#title" => t('Twitter ') . ' ' . t('link'),
    "#default_value" => variable_get('twitter_url', ''),
  );

  $form['winmap_config_social']['google_plus_url'] = array(
    '#type' => "textfield",
    "#title" => t('Google Plus ') . ' ' . t('link'),
    "#default_value" => variable_get('google_plus_url', ''),
  );

  $form['winmap_config_social']['instagram_url'] = array(
    '#type' => "textfield",
    "#title" => t('Instagram') . ' ' . t('link'),
    "#default_value" => variable_get('instagram_url', ''),
  );

  $form['winmap_config_social']['pinterest_url'] = array(
    '#type' => "textfield",
    "#title" => 'Instagram' . ' ' . t('link'),
    "#default_value" => variable_get('pinterest_url', ''),
  );


  $form['winmap_config_social']['facebook_page'] = array(
    '#type' => "textarea",
    '#title' => 'Facebook page',
    '#resizable' => TRUE,
    "#default_value" => variable_get('facebook_page', ''),
  );


  $form['winmap_config_footer'] = array(
    '#type' => "fieldset",
    '#title' => 'Footer',
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  $_footer = variable_get('footer', array(
    'value' => '',
    'format' => 'full_html'
  ));
  $form['winmap_config_footer']['footer'] = array(
    '#type' => "text_format",
    '#title' => 'Footer',
    '#resizable' => TRUE,
    '#format' => 'full_html',
    "#default_value" => $_footer['value'],
  );


  $form['winmap_config_copyright'] = array(
    '#type' => "fieldset",
    '#title' => t('Copyright'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  $_copyright = variable_get('copyright', array(
    'value' => '',
    'format' => 'full_html'
  ));
  $form['winmap_config_copyright']['copyright'] = array(
    '#type' => "text_format",
    '#title' => t('Copyright'),
    '#format' => 'full_html',
    "#default_value" => $_copyright['value'],
  );


  $form['winmap_config_script'] = array(
    '#type' => "fieldset",
    '#title' => 'Scripts',
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  $form['winmap_config_script']['header_script'] = array(
    '#type' => "textarea",
    '#title' => t('Page header'),
    '#resizable' => TRUE,
    "#default_value" => variable_get('header_script', ''),
  );
  $form['winmap_config_script']['footer_script'] = array(
    '#type' => "textarea",
    '#title' => t('Page footer'),
    '#resizable' => TRUE,
    "#default_value" => variable_get('footer_script', ''),
  );

  $form['#submit'][] = 'winmap_config_settings_submit';

  return system_settings_form($form);
}


function winmap_config_settings_submit ($form, &$form_state) {

}

function winmap_ajax_page() {
  global  $user;
  global  $base_url;
  $data = array();
  $data['message'] = '';
  $data['success'] = 0;
  if (isset($_POST['cmd'])) {
    switch ($_POST['cmd']) {

    }
  }
  return $data;
}



