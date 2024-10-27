<?php



function winmap_watermark_config_form() {

  $form = array();

  $form['winmap_watermark_config_site']['winmap_hotline'] = array(
    '#type' => "textfield",
    '#title' => t('Hotline'),
    "#default_value" => variable_get('winmap_hotline', ''),
  );

  $form['winmap_watermark_config_site']['winmap_title'] = array(
    '#type' => "textfield",
    '#title' => t('Title'),
    "#default_value" => variable_get('winmap_title', ''),
  );

  $_body = variable_get('winmap_content', array(
    'value' => '',
    'format' => 'full_html'
  ));

  $form['winmap_config_footer']['winmap_content'] = array(
    '#type' => "text_format",
    '#title' => 'Content',
    '#resizable' => TRUE,
    '#format' => 'full_html',
    "#default_value" => $_body['value'],
  );


  $_footer = variable_get('winmap_copyright', array(
    'value' => '',
    'format' => 'full_html'
  ));

  $form['winmap_config_footer']['winmap_copyright'] = array(
    '#type' => "text_format",
    '#title' => 'Copyright',
    '#resizable' => TRUE,
    '#format' => 'full_html',
    "#default_value" => $_footer['value'],
  );


  $form['#submit'][] = 'winmap_watermark_config_settings_submit';

  return system_settings_form($form);

}


function winmap_watermark_config_settings_submit ($form, &$form_state) {

}


