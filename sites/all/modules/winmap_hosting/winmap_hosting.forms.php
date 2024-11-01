<?php

function winmap_hosting_form($form, &$form_state, $hosting = NULL) {
  $form = array();
  $form['#hosting'] = $form_state['#hosting'] = $hosting;

  $form['name'] = [
    '#type' => 'textfield',
    '#title' => t('Name'),
    '#default_value' => !empty($hosting->name)?$hosting->name:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
    '#attributes' => array('class'=> array('t1', 't2'))
  ];
  $form['ipv4'] = [
    '#type' => 'textfield',
    '#title' => t('IPV4'),
    '#default_value' => !empty($hosting->ipv4)?$hosting->ipv4:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  ];
  $form['ipv6'] = [
    '#type' => 'textfield',
    '#title' => t('IPV6'),
    '#default_value' => !empty($hosting->ipv6)?$hosting->ipv6:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => FALSE,
  ];
  $form['sshUser'] = [
    '#type' => 'textfield',
    '#title' => t('SSH User'),
    '#default_value' => !empty($hosting->sshUser)?$hosting->sshUser:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  ];
  $form['sshPass'] = [
    '#type' => 'textfield',
    '#title' => t('SSH Password'),
    '#default_value' => !empty($hosting->sshPass)?$hosting->sshPass:'',
    '#size' => 60,
    '#maxlength' => 80,
    '#required' => TRUE,
  ];
  $form['mysqlPort'] = [
    '#type' => 'textfield',
    '#title' => t('Mysql Port'),
    '#default_value' => !empty($hosting->mysqlPort)?$hosting->mysqlPort:'3306',
    '#size' => 60,
    '#maxlength' => 80,
    '#required' => TRUE,
    '#attributes' => array(' type'=>'number')
  ];
  $form['mysqlUser'] = [
    '#type' => 'textfield',
    '#title' => t('Mysql User'),
    '#default_value' => !empty($hosting->mysqlUser)?$hosting->mysqlUser:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  ];
  $form['mysqlPass'] = [
    '#type' => 'textfield',
    '#title' => t('Mysql password'),
    '#default_value' => !empty($hosting->mysqlPass)?$hosting->mysqlPass:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  ];
  $form['maxCcu'] = [
    '#type' => 'textfield',
    '#title' => t('Max CCU'),
    '#default_value' => !empty($hosting->maxCcu)?$hosting->maxCcu:'0',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
    '#attributes' => array(' type'=>'number')
  ];
  $form['usedCcu'] = [
    '#type' => 'textfield',
    '#title' => t('Used CCU'),
    '#default_value' => !empty($hosting->usedCcu)?$hosting->usedCcu:'0',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
    '#attributes' => array(' type'=>'number')
  ];
  $form['domainName'] = [
    '#type' => 'textfield',
    '#title' => t('Domain name'),
    '#default_value' => !empty($hosting->domainName)?$hosting->domainName:'',
    '#size' => 60,
    '#maxlength' => 255,
    '#required' => TRUE,
  ];
  $form['domainPath'] = [
    '#type' => 'textfield',
    '#title' => t('Domain path'),
    '#default_value' => !empty($hosting->domainPath)?$hosting->domainPath:'',
    '#size' => 60,
    '#maxlength' => 255,
    '#required' => TRUE,
  ];
  $form['ftpUser'] = [
    '#type' => 'textfield',
    '#title' => t('Ftp username'),
    '#default_value' => !empty($hosting->ftpUser)?$hosting->ftpUser:'',
    '#size' => 60,
    '#maxlength' => 255,
    '#required' => TRUE,
  ];
  $form['ftpPass'] = [
    '#type' => 'textfield',
    '#title' => t('Ftp password'),
    '#default_value' => !empty($hosting->ftpPass)?$hosting->ftpPass:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => FALSE,
  ];
  $form['pleskUser'] = [
    '#type' => 'textfield',
    '#title' => t('Plesk Username'),
    '#default_value' => !empty($hosting->pleskUser)?$hosting->pleskUser:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  ];
  $form['pleskPass'] = [
    '#type' => 'textfield',
    '#title' => t('Plesk password'),
    '#default_value' => !empty($hosting->pleskPass)?$hosting->pleskPass:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  ];
  $form['pleskApiToken'] = [
    '#type' => 'textfield',
    '#title' => t('Plesk Api Token'),
    '#default_value' => !empty($hosting->pleskApiToken)?$hosting->pleskApiToken:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => FALSE,
  ];
  $form['cloudflareToken'] = [
    '#type' => 'textfield',
    '#title' => t('Cloudflare token api'),
    '#default_value' => !empty($hosting->cloudflareToken)?$hosting->cloudflareToken:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
    '#attributes' => array(' placeholder'=>'Token api của nền tảng cloudflare')
  ];
  $form['cloudflareZoneId'] = [
    '#type' => 'textfield',
    '#title' => t('Cloudflare Zone Id'),
    '#default_value' => !empty($hosting->cloudflareZoneId)?$hosting->cloudflareZoneId:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
    '#attributes' => array(' placeholder'=>'Mã Zone id theo tên miền mà nền tảng cloudeflare cấp')
  ];
  $form['status'] = array(
    '#type' => 'select',
    '#title' => t('Status'),
    '#options' => array(
      0 => t('No'),
      1 => t('Yes'),
    ),
    '#default_value' => !empty($hosting->status)?$hosting->status:'0',
    '#description' => t('Set this to <em>Yes</em> if you would like this category to be selected by default.'),
  );


  $form['submit'] = array('#type' => 'submit', '#value' => t('Save'));

  return $form;
}


function validate_ip_address($ip) {
  $pattern = '/^((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])\.){3}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])$/';
  return preg_match($pattern, $ip) === 1;
}
function winmap_hosting_form_validate($form, $form_state) {
  $hosting = $form_state['#hosting'];
  $domain = $form_state['values']['domainName'];
  $ip = $form_state['values']['ipv4'];
  if(!validate_ip_address($ip)){
    form_set_error('ipv4', 'Địa chỉ ip không hợp lệ');
  }
  // Kiểm tra tính duy nhất của domain
  $query = db_select('winmap_hostings', 'we')
    ->fields('we', array('domainName'))
    ->condition('domainName', $domain);
  // Bỏ qua bản ghi hiện tại nếu đang chỉnh sửa
  if (!empty($form_state['#hosting']->id)) {
    $query->condition('id', $form_state['#hosting']->id, '<>');
  }
  $existing_domain = $query->execute()->fetchField();
  if ($existing_domain) {
    form_set_error('domain', t('The domain "@domain" already exists. Please choose a unique domain.', array('@domain' => $domain)));
    return;
  }

  if (!empty($hosting->id)) {
    $last_changed = winmap_hosting_last_changed($hosting->id);
    if ($last_changed != $hosting->changed) {
      form_set_error('', 'Có người dùng khác đang cập nhật, vui lòng thử lại sau');
    }
  }


}

function winmap_hosting_form_submit($form, &$form_state) {
  try {
    $hosting = $form_state['#hosting']??new stdClass();
    $hosting->name = $form_state['values']['name'];
    $hosting->ipv4 = $form_state['values']['ipv4'];
    $hosting->ipv6 = $form_state['values']['ipv6'];
    $hosting->sshPass = $form_state['values']['sshPass'];
    $hosting->sshUser = $form_state['values']['sshUser'];
    $hosting->mysqlPort = $form_state['values']['mysqlPort'];
    $hosting->mysqlUser = $form_state['values']['mysqlUser'];
    $hosting->mysqlPass = $form_state['values']['mysqlPass'];
    $hosting->maxCcu = $form_state['values']['maxCcu'];
    $hosting->usedCcu = $form_state['values']['usedCcu'];
    $hosting->domainName = $form_state['values']['domainName'];
    $hosting->domainPath = $form_state['values']['domainPath'];
    $hosting->ftpUser = $form_state['values']['ftpUser'];
    $hosting->ftpPass = $form_state['values']['ftpPass'];
    $hosting->pleskUser = $form_state['values']['pleskUser'];
    $hosting->pleskPass = $form_state['values']['pleskPass'];
    $hosting->pleskApiToken = $form_state['values']['pleskApiToken'];
    $hosting->cloudflareToken = $form_state['values']['cloudflareToken'];
    $hosting->cloudflareZoneId = $form_state['values']['cloudflareZoneId'];
    $hosting->status = $form_state['values']['status'];
    $hosting = hosting_save($hosting);
    if (!empty($hosting)) {
      $hostingData = winmap_hosting_load($hosting);
      drupal_set_message(t('Hosting '.$hostingData->name.' has bean created.'));
      drupal_goto('admin/hostings');
    }else {
      drupal_set_message(t('System is busy.'));
    }
  } catch (Exception $e) {
    // Handle error.
    drupal_set_message(t('An error occurred: @message', array('@message' => $e->getMessage())), 'error');
  }
}
