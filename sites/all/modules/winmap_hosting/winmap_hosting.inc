<?php

function winmap_admin_hosting_list_page() {
  $form_load = drupal_get_form('winmap_admin_administrator_hosting_block_load_all');
  return render($form_load);
}

function winmap_hosting_page() {
  $header = array(
    array('data' => t('Host Name')),
    array('data' => t('Host IPV4')),
    array('data' => t('Host IPV6')),
    array('data' => t('Actions')),
  );

  $rows = array();
  $query = db_select('winmap_hostings', 'h')
    ->fields('h', array('id', 'name', 'ipv4', 'ipv6'))
    ->execute();

  foreach ($query as $row) {
    $edit_url = url('admin/hostings/' . $row->id . '/edit');
    $delete_url = url('admin/hostings/' . $row->id . '/delete');
    $rows[] = array(
      $row->name,
      $row->ipv4,
      $row->ipv6,
      l(t('Edit'), $edit_url) . ' | ' . l(t('Delete'), $delete_url),
    );
  }

  return theme('table', array('header' => $header, 'rows' => $rows));
}
function winmap_hosting_page_callback() {
  return _winmap_render_theme("module","winmap_hosting","templates/pages/hosting_index_page.tpl.php");
}
//create hosting
function winmap_admin_hosting_create_page() {
  return _winmap_render_theme("module","winmap_hosting","templates/pages/hosting_create_page.tpl.php");
}

//edit hosting
function winmap_admin_hosting_edit_page($hosting) {
  return _winmap_render_theme("module","winmap_hosting","templates/pages/hosting_edit_page.tpl.php", array('hosting'=>$hosting));
}

function winmap_warning_limit_hosting($hostingId){
  $to = variable_get('site_mail','thanhan1507@gmail.com');
  $from = variable_get('smtp_from','thanhan1507@gmail.com');
  $hosting = hosting_load($hostingId);
  $subject = t("Cảnh báo: Hosting đạt giới hạn người dùng");
  $message = t("Hosting với Ip ".$hosting->ipv4." đã đạt đến giới hạn người dùng.\n");
  $message .= t("Giới hạn người dùng: ".$hosting->maxCcu." \n");
  $message .= t("Số lượng người dùng hiện tại: ".$hosting->usedCcu." \n");
  $message .= t("Vui lòng kiểm tra và nâng cấp nếu cần thiết.");
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
