<?php

function mf_value($element, $input = FALSE, &$form_state) {
  if ($input) {
    // Checkboxes lose their value when empty.
    // If the display field is present make sure its unchecked value is saved.
    $input['display'] =1;
  }
  $return = mf_managed_file_value($element, $input, $form_state);
  // Ensure that all the required properties are returned even if empty.
  $return += array(
    'fid' => 0,
    'display' => 1,
    'description' => '',
  );
  if (empty($form_state['values'][$element['#field_name']])) {
    $form_state['values'][$element['#field_name']] = array();
  }
  $last_parent = $element['#parents'][count($element['#parents']) - 1];
  $form_state['values'][$element['#field_name']][$last_parent] = $return;
  return $return;
}
