<?php

function winmap_user_group_page(){
  return _winmap_render_theme("module","winmap_user","templates/pages/user_group_index_page.tpl.php");
}
function winmap_user_group_create_page(){
  return _winmap_render_theme("module","winmap_user","templates/pages/user_group_create_page.tpl.php");
}

function winmap_user_group_edit_page($user_group){
  return _winmap_render_theme("module","winmap_user","templates/pages/user_group_edit_page.tpl.php",array('user_group'=>$user_group));
}
