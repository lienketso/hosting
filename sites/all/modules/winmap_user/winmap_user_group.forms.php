<?php
function winmap_user_group_form($form, &$form_state, $user_group = NULL)
{
  $form = array();
  $form['#user_group'] = $form_state['#user_group'] = $user_group;
  $form['name'] = [
    '#type' => 'textfield',
    '#title' => t('Name'),
    '#default_value' => !empty($user_group->name)?$user_group->name:'',
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
    '#default_value' => !empty($user_group->status)?$user_group->status:'0',
    '#description' => t('Set this to <em>Yes</em> if you would like this category to be selected by default.'));

  $form['submit'] = array('#type' => 'submit', '#value' => t('Save'));
  return $form;
}

function winmap_user_group_form_validate($form, $form_state) {

}


function winmap_user_group_form_submit($form, &$form_state) {
  try {
    $user_group = $form_state['#user_group']??new stdClass();
    $user_group->name = $form_state['values']['name'];
    $user_group->status = $form_state['values']['status'];
    $user_group = user_group_save($user_group);

    if (!empty($user_group)) {
      $userGroupData = user_group_load($user_group);
      drupal_set_message(t('User group '.$userGroupData->name.' has bean created.'));
      drupal_goto('admin/user/groups');
    }else {
      drupal_set_message(t('System is busy.'));
    }
  } catch (Exception $e) {
    // Handle error.
    drupal_set_message(t('An error occurred: @message', array('@message' => $e->getMessage())), 'error');
  }
}
