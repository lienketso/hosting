<?php
function winmap_enterprise_register_form($form, &$form_state, $customer = NULL){
  $form = array();
  $form['#customer'] = $form_state['#customer'] = $customer;
  $form['domain'] = [
    '#type' => 'textfield',
    '#title' => t('Domain name'),
    '#default_value' => !empty($customer->domain)?$customer->domain:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
    '#attributes' => array('placeholder'=> 'Ex:enterprise')
  ];
  $form['name'] = [
    '#type' => 'textfield',
    '#title' => t('Full name'),
    '#default_value' => !empty($customer->name)?$customer->name:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  ];
  $form['email'] = [
    '#type' => 'textfield',
    '#title' => t('Email address'),
    '#default_value' => !empty($customer->email)?$customer->email:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  ];
  $form['phone'] = [
    '#type' => 'textfield',
    '#title' => t('Phone number'),
    '#default_value' => !empty($customer->phone)?$customer->phone:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  ];
  $form['username'] = [
    '#type' => 'textfield',
    '#title' => t('User name'),
    '#default_value' => !empty($customer->username)?$customer->username:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  ];
  $form['password'] = [
    '#type' => 'password',
    '#title' => t('Password'),
    '#default_value' => !empty($customer->password)?$customer->password:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  ];
  $form['confirm_password'] = [
    '#type' => 'password',
    '#title' => t('Confirm password'),
    '#default_value' => '',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  ];
  $form['companyName'] = [
    '#type' => 'textfield',
    '#title' => t('Company Name'),
    '#default_value' => !empty($customer->companyName)?$customer->companyName:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => FALSE,
  ];
  $form['companyPhone'] = [
    '#type' => 'textfield',
    '#title' => t('Company Phone'),
    '#default_value' => !empty($customer->companyPhone)?$customer->companyPhone:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => FALSE,
  ];
  $form['companyAddress'] = [
    '#type' => 'textfield',
    '#title' => t('Company Address'),
    '#default_value' => !empty($customer->companyAddress)?$customer->companyAddress:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => FALSE,
  ];
  $form['ownerName'] = [
    '#type' => 'textfield',
    '#title' => t('Owner Name'),
    '#default_value' => !empty($customer->ownerName)?$customer->ownerName:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => FALSE,
  ];
  $form['ownerPhone'] = [
    '#type' => 'textfield',
    '#title' => t('Owner Phone'),
    '#default_value' => !empty($customer->ownerPhone)?$customer->ownerPhone:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => FALSE,
  ];
  $form['ownerAddress'] = [
    '#type' => 'textfield',
    '#title' => t('Owner Address'),
    '#default_value' => !empty($customer->ownerAddress)?$customer->ownerAddress:'',
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => FALSE,
  ];
  $form['#validate'][] = 'winmap_enterprise_register_form_validate';
  $form['submit'] = array('#type' => 'submit', '#value' => t('Register now'));
  return $form;
}

function validate_confirm_password($password, $confirmPassword) {
  return $password === $confirmPassword;
}

function winmap_enterprise_register_form_validate($form, &$form_state) {
  $domain = $form_state['values']['domain'];
  $password = $form_state['values']['password'];
  $confirmPassword = $form_state['values']['confirm_password'];
  if (!preg_match('/^[a-z0-9\-]+$/', $domain)) {
    form_set_error('domain', t('The domain "@domain" contains invalid characters. Only lowercase letters (a-z), numbers (0-9), and hyphens (-) are allowed.', array('@domain' => $domain)));
  }
  //kiểm tra unique các trường dữ liệu
  $fields = ['phone', 'email', 'domain','username'];
  foreach ($fields as $field) {
    $value = $form_state['values'][$field];
    if (db_query("SELECT COUNT(*) FROM {winmap_enterprises} WHERE $field = :value", [':value' => $value])->fetchField() > 0) {
      form_set_error($field, t('@field này đã được sử dụng.', ['@field' => ucfirst($field)]));
    }
  }
  //Check mật khẩu
  if(!validate_confirm_password($password,$confirmPassword)){
    form_set_error('confirm_password', t('The confirm password does not macth.'));
  }
}

function winmap_enterprise_register_form_submit($form, &$form_state) {
  try {
    $customer = $form_state['#customer'] ?? new stdClass();
    $customer->name = $form_state['values']['name'];
    $customer->domain = $form_state['values']['domain'];
    $customer->email = $form_state['values']['email'];
    $customer->phone = $form_state['values']['phone'];
    $customer->username = $form_state['values']['username'];
    $customer->password = password_hash($form_state['values']['password'], PASSWORD_DEFAULT);
    $customer->companyName = $form_state['values']['companyName'];
    $customer->companyPhone = $form_state['values']['companyPhone'];
    $customer->companyAddress = $form_state['values']['companyAddress'];
    $customer->ownerName = $form_state['values']['ownerName'];
    $customer->ownerPhone = $form_state['values']['ownerPhone'];
    $customer->ownerAddress = $form_state['values']['ownerAddress'];
    $customer->status = 0;
    $customer = customer_save($customer);
    if(!empty($customer)){

      //get hosting have usedCcu > 40
      $hosting = db_select('winmap_hostings', 't')
        ->fields('t')
        ->condition('usedCCu', 40, '<')
        ->range(0, 1)
        ->execute()
        ->fetchObject();

      if(!empty($hosting)){
        $customerLoad = customer_load($customer);
        $fullSubDomain = $customerLoad->domain.'.'.$hosting->domainName;
        $databaseName = 'winmapdms_'.$customerLoad->domain;
        $localDirectory = '/var/www/vhosts/'.$hosting->domainName.'/httpdocs/init';
        $remoteDirectory = '/var/www/vhosts/'.$hosting->domainName.'/httpdocs/'.$fullSubDomain;
        //conect ssh
        $connect = winmap_ssh_connection($hosting->ipv4,$hosting->sshUser,$hosting->sshPass);
        //create subdomain in hosting
        winmap_ssh_create_sub_domain($hosting->ipv4,$hosting->pleskUser,$hosting->pleskPass,$customerLoad->domain,$hosting->domainName,$hosting->domainPath);
        //create dns record by cloud flare
        winmap_create_dns_domain($customerLoad->domain,$hosting->ipv4,$hosting->cloudflareToken,$hosting->cloudflareZoneId);
        //create database
        winmap_create_database_by_plesk_api($hosting->ipv4,$hosting->sshUser,$hosting->sshPass,$databaseName,$hosting->mysqlUser,$hosting->mysqlPass,$customerLoad->domain);
        //import database
        winmap_ssh_sql_import_db($connect,$databaseName,$hosting->myslqUser,$hosting->myslqPass,'/hosting.sql');
        //create folder
        winmap_ssh_create_folder($connect,$fullSubDomain,$hosting->domainPath);
        //clone file and folder in init folder
        winmap_clone_file_and_folder($connect,$localDirectory,$remoteDirectory);
        //edit file setting
        winmap_edit_file($connect,'',[
          251 => "'database' => 'hosting_new',",
          776 => "'/files';",
          777 => "'/files/test';",
        ]);
        //Đóng connect ssh
        winmap_ssh_close($connect);
      }else{
        drupal_set_message(t('Server busy, please try again later'));
      }
      drupal_set_message(t('Customer '.$customerLoad->name.' has bean created.'));
      drupal_goto('enterprise/register');
    }else{
      drupal_set_message(t('System is busy.'));
    }
  }catch (Exception $e){
    drupal_set_message(t('An error occurred: @message', array('@message' => $e->getMessage())), 'error');
  }

}
