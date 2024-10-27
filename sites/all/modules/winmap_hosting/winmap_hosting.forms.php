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
    '#required' => TRUE,
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
    '#type' => 'password',
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
    '#default_value' => !empty($hosting->sshUser)?$hosting->sshUser:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  ];
  $form['mysqlPass'] = [
    '#type' => 'password',
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
    '#type' => 'password',
    '#title' => t('Ftp password'),
    '#default_value' => !empty($hosting->ftpPass)?$hosting->ftpPass:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
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

function winmap_hosting_form_validate($form, $form_state) {
//  form_set_error('name', t('Weight value must be numeric.'));
  $hosting = $form_state['#hosting'];
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
    $hosting->mysqlPass = $form_state['values']['mysqlPass'];
    $hosting->maxCcu = $form_state['values']['maxCcu'];
    $hosting->usedCcu = $form_state['values']['usedCcu'];
    $hosting->domainName = $form_state['values']['domainName'];
    $hosting->domainPath = $form_state['values']['domainPath'];
    $hosting->ftpUser = $form_state['values']['ftpUser'];
    $hosting->ftpPass = $form_state['values']['ftpPass'];
    $hosting->status = $form_state['values']['status'];
    $hosting = hosting_save($hosting);
    if (!empty($hosting)) {
      drupal_set_message(t('Hosting '.$hosting->name.' has bean created.'));
      drupal_goto('admin/hostings');
    }else {
      drupal_set_message(t('System is busy.'));
    }
  } catch (Exception $e) {
    // Handle error.
    drupal_set_message(t('An error occurred: @message', array('@message' => $e->getMessage())), 'error');
  }
}
