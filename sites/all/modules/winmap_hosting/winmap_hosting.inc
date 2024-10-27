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

function winmap_connect_ssh_api(){
  $result = winmap_ssh_connect('103.179.190.104');
  print_r($result);
}

function winmap_api_ssh_connect(){
  $ip = '103.179.190.104';
  $username = 'ftp_winmap.vn';
  $password = 'cafZ40_0';
  $connect = winmap_ssh_connection($ip, $username, $password);
if (is_string($connect)) {
  // Xử lý lỗi kết nối.
  print_r(array('message'=>'Lỗi kết nối','connect'=>$connect));
} else {
  // Kết nối thành công.
  print_r(array('message'=>'Kết nối thành công','connect'=>$connect));
}
}

function winmap_connect_ftp_api(){
  $ip = '103.179.190.104';
  $username = 'ftp_winmap.vn';
  $password = 'cafZ40_0';

  $connect = winmap_ftp_connect($ip,21,$username,$password);
  if ($connect === false) {
    // Xử lý lỗi kết nối FTP, ví dụ: ghi lại thông báo lỗi
    watchdog('winmap_hosting', 'Unable to connect to FTP server.', [], WATCHDOG_ERROR);
  } else {
    // Thực hiện các thao tác với kết nối FTP ở đây.
    if (ftp_mkdir($connect, winmap_ftp_create_folder($connect,'testFolder','/')))
    {
      echo "Successfully created folder";
    }
    else
    {
      echo "Error while creating folder";
    }
    // Đóng kết nối khi hoàn thành.
    ftp_close($connect);
  }

}
