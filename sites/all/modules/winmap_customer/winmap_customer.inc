<?php
function winmap_customer_page_callback() {
  return _winmap_render_theme("module","winmap_customer","templates/pages/customer_index_page.tpl.php");
}

function winmap_admin_customer_create_page() {
  return _winmap_render_theme("module","winmap_customer","templates/pages/customer_create_page.tpl.php");
}

function winmap_admin_customer_edit_page($customer) {
  return _winmap_render_theme("module","winmap_customer","templates/pages/customer_edit_page.tpl.php",array('customer'=>$customer));
}

//register
function winmap_enterprise_register_page_callback(){
  return _winmap_render_theme("module","winmap_customer","templates/pages/front/enterprise_register.tpl.php");
}


function winmap_send_mail_register_success($customerId){
  $customer = customer_load($customerId);
  $to = $customer->email;
  $from = variable_get('smtp_from','thanhan1507@gmail.com');

  $subject = t("Thông báo: Dịch vụ đã được đăng ký thành công");
  $message = t("Cảm ơn ".$customer->name." đã đăng ký dịch vụ\n");
  $message .= t("Tài khoản của quý khách hàng đã được đăng ký thành công, quý khách vui lòng đợi trong ít phút để hoàn tất quá trình cài đặt\n");
  $message .= t("Tên tài khoản : @username \n",array('@username'=>$customer->username));
  $message .= t("Mật khẩu : @password \n",array('@password'=>password_get_info($customer->password)));
  $params = array(
    'subject' => $subject,
    'body' => $message,
  );
  $sendMail = drupal_mail('hosting_module','user_warning',$to,language_default(),$params,$from,TRUE);
  if ($sendMail['result'] == TRUE) {
    drupal_set_message(t('Your message has been sent.'));
    return TRUE;
  }
  else {
    drupal_set_message(t('There was a problem sending your message and it was not sent.'), 'error');
    return FALSE;
  }
}
