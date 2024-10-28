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
