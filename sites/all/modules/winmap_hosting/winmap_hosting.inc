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


function winmap_get_api_token_plesk(){
  $token = winmap_create_plesk_api_token('103.159.51.251','root','ixRj*v4NV#,3g_#');
  echo $token;
}

function winmap_create_subdomain(){
  $result = winmap_ssh_create_sub_domain('103.159.51.251','root','ixRj*v4NV#,3g_#','enterprise','phanmemdms.com.vn','/var/www/vhosts/phanmemdms.com.vn/httpdocs');
  print_r($result);
}

function winmap_get_webspace_id_by_plesk(){
  $result = winmap_get_webspace_by_domain('103.159.51.251','root','ixRj*v4NV#,3g_#','enterprise.phanmemdms.com.vn');
  print_r($result);
}
function winmap_create_dns(){
  $result = winmap_create_dns_domain('enterprise','103.159.51.251');
  print_r($result);
}

function winmap_create_database(){
  $result = winmap_create_database_by_plesk_api(
    '103.159.51.251',
    'root',
    'ixRj*v4NV#,3g_#',
    'winmap_test_data',
    'dmsadmin',
    '@Lks2024@',
    'phanmemdms.com.vn'
  );
  print_r($result);
}

function winmap_import_database(){
  $connect = winmap_ssh_connection('103.159.51.251','root','ixRj*v4NV#,3g_#');
  $result = winmap_ssh_sql_import_db($connect,'winmap_test_data','dmsadmin','@Lks2024@','/hosting.sql');
  print_r($result);
}


function winmap_create_folder(){
  $connect = winmap_ssh_connection('103.159.51.251','root','ixRj*v4NV#,3g_#');
  $result = winmap_ssh_create_folder($connect,'enterprise.winmap.com.vn','/var/www/vhosts/phanmemdms.com.vn/httpdocs');
  print_r($result);
}

function winmap_copy_file_folder(){
  $connect = winmap_ssh_connection('103.159.51.251','root','ixRj*v4NV#,3g_#');
  $result = winmap_clone_file_and_folder($connect,'/var/www/vhosts/phanmemdms.com.vn/httpdocs/init','/var/www/vhosts/phanmemdms.com.vn/httpdocs/enterprise.winmap.com.vn');
  print_r($result);
}


function winmap_edit_file_setting(){
  $connect = winmap_ssh_connection('103.159.51.251','root','ixRj*v4NV#,3g_#');
  $linesToEditString = "252 => 'database' => 'hosting_new', 253 => 'username' => 'new_username'";
  $result = winmap_edit_file($connect,'/var/www/vhosts/phanmemdms.com.vn/httpdocs/init/settings.php',[
    251 => "'database' => 'hosting_new',",
    776 => "'/files';",
    777 => "'/files/test';",
  ]);
  print_r($result);
}
