<?php


function winmap_admin_theme_preprocess_html(&$variables) {
  $variables['classes_array'][] = 'hold-transition skin-blue sidebar-mini admin-menu sidebar-collapse';
}


function winmap_admin_theme_preprocess_page(&$variables) {
  $_arg = arg();
  $variables['primary_local_tasks'] = menu_primary_local_tasks();
  $variables['secondary_local_tasks'] = menu_secondary_local_tasks();

// Set winmap admin theme
  if ($_arg[0] == 'admin') {
      if (count($_arg) >= 2 ) {
          if ($_arg[1] == 'winmap') {
            $variables['theme_hook_suggestions'][] = 'page__winmap';
          }
      }
  }
}


function winmap_admin_theme_preprocess_admin_block(&$vars) {
  // Add icon and classes to admin block titles.
  if (isset($vars['block']['href'])) {
    $vars['block']['localized_options']['attributes']['class'] = _winmap_admin_theme_icon_classes($vars['block']['href']);
  }
  $vars['block']['localized_options']['html'] = TRUE;
  if (isset($vars['block']['link_title'])) {
    $vars['block']['title'] = l('<span class="icon"></span>' . filter_xss_admin($vars['block']['link_title']), $vars['block']['href'], $vars['block']['localized_options']);
  }

  if (empty($vars['block']['content'])) {
    $vars['block']['content'] = "<div class='admin-block-description description'>{$vars['block']['description']}</div>";
  }
}


function winmap_admin_theme_admin_block($variables) {
  $block = $variables['block'];
  $output = '';

  // Don't display the block if it has no content to display.
  if (empty($block['show'])) {
    return $output;
  }

  $output .= '<div class="admin-panel panel panel-default">';
  if (!empty($block['title'])) {
    $output .= '<div class="panel-heading"><h3 class="panel-title fieldset-legend">' . $block['title'] . '</h3></div>';
  }
  if (!empty($block['content'])) {
    $output .= '<div class="body panel-body">' . $block['content'] . '</div>';
  }
  else {
    $output .= '<div class="description">' . $block['description'] . '</div>';
  }
  $output .= '</div>';

  return $output;
}

function winmap_admin_theme_admin_block_content($vars) {

  $content = $vars['content'];

  $output = '';
  if (!empty($content)) {

    foreach ($content as $k => $item) {

      //-- Safety check for invalid clients of the function
      if (empty($content[$k]['localized_options']['attributes']['class'])) {
        $content[$k]['localized_options']['attributes']['class'] = array();
      }
      if (!is_array($content[$k]['localized_options']['attributes']['class'])) {
        $content[$k]['localized_options']['attributes']['class'] = array($content[$k]['localized_options']['attributes']['class']);
      }

      $content[$k]['title'] = '<span class="icon"></span>' . filter_xss_admin($item['title']);


      $content[$k]['localized_options']['html'] = TRUE;
      if (!empty($content[$k]['localized_options']['attributes']['class'])) {
        $content[$k]['localized_options']['attributes']['class'] += _winmap_admin_theme_icon_classes($item['href']);
      }
      else {
        $content[$k]['localized_options']['attributes']['class'] = _winmap_admin_theme_icon_classes($item['href']);
      }
    }
    $output = system_admin_compact_mode() ? '<ul class="admin-list admin-list-compact">' : '<ul class="admin-list">';
    foreach ($content as $item) {
      $output .= '<li class="leaf">';
      $output .= l($item['title'], $item['href'], $item['localized_options']);
      if (isset($item['description']) && !system_admin_compact_mode()) {
        $output .= "<div class='description'>{$item['description']}</div>";
      }
      $output .= '</li>';
    }
    $output .= '</ul>';
  }

  if (!empty($vars['theme-type']) && $vars['theme-type']== 'box') {
    $output = '<div class="box box-primary"><div class="box-body">' . $output .'</div></div>';
  }

  return $output;
}

function _winmap_admin_theme_icon_classes($path) {
  $classes = array();
  $args = explode('/', $path);
  if ($args[0] === 'admin' || (count($args) > 1 && $args[0] === 'node' && $args[1] === 'add')) {
    // Add a class specifically for the current path that allows non-cascading
    // style targeting.
    $classes[] = 'path-' . str_replace('/', '-', implode('/', $args)) . '-';
    while (count($args)) {
      $classes[] = drupal_html_class('path-' . str_replace('/', '-', implode('/', $args)));
      array_pop($args);
    }
    return $classes;
  }
  return array();
}



function winmap_admin_theme_form_element_label(array &$variables) {
  $element = $variables['element'];

  // Extract variables.
  $output = '';

  $title = !empty($element['#title']) ? filter_xss_admin($element['#title']) : '';

  // Only show the required marker if there is an actual title to display.
  $marker = array('#theme' => 'form_required_marker', '#element' => $element);
  if ($title && $required = !empty($element['#required']) ? drupal_render($marker) : '') {
    $title .= ' ' . $required;
  }

  $display = isset($element['#title_display']) ? $element['#title_display'] : 'before';
  $type = !empty($element['#type']) ? $element['#type'] : FALSE;
  $checkbox = $type && $type === 'checkbox';
  $radio = $type && $type === 'radio';

  // Immediately return if the element is not a checkbox or radio and there is
  // no label to be rendered.
  if (!$checkbox && !$radio && ($display === 'none' || !$title)) {
    return '';
  }

  // Retrieve the label attributes array.
  $attributes = &_bootstrap_get_attributes($element, 'label_attributes');

  // Add Bootstrap label class.
  $attributes['class'][] = 'control-label';

  // Add the necessary 'for' attribute if the element ID exists.
  if (!empty($element['#id'])) {
    $attributes['for'] = $element['#id'];
  }

  // Checkboxes and radios must construct the label differently.
  if ($checkbox || $radio) {
    if ($display === 'before') {
      $output .= $title;
    }elseif ($display === 'none' || $display === 'invisible') {
      $output .= '<span class="element-invisible">' . $title . '</span>';
    }
    // Inject the rendered checkbox or radio element inside the label.
    if(!empty($element['#children'])) {
      $output .= $element['#children'];
    }
    if ($display === 'after') {
      $output .= $title;
    }

    if ( !empty($variables['element']['#id']) && (
        $variables['element']['#id'] == 'edit-sex-1' ||
        $variables['element']['#id'] == 'edit-sex-2' ||
        $variables['element']['#id'] == 'edit-payment-method-1' ||
        $variables['element']['#id'] == 'edit-payment-method-2' ||
        $variables['element']['#id'] == 'edit-payment-method-3' ||
        $variables['element']['#id'] == 'edit-payment-method-4' ||
        $variables['element']['#id'] == 'edit-hours-0000'||
        $variables['element']['#id'] == 'edit-hours-0100'||
        $variables['element']['#id'] == 'edit-hours-0200'||
        $variables['element']['#id'] == 'edit-hours-0300'||
        $variables['element']['#id'] == 'edit-hours-0400'||
        $variables['element']['#id'] == 'edit-hours-0500'||
        $variables['element']['#id'] == 'edit-hours-0600'||
        $variables['element']['#id'] == 'edit-hours-0700'||
        $variables['element']['#id'] == 'edit-hours-0800'||
        $variables['element']['#id'] == 'edit-hours-0900'||
        $variables['element']['#id'] == 'edit-hours-1000'||
        $variables['element']['#id'] == 'edit-hours-1100'||
        $variables['element']['#id'] == 'edit-hours-1200'||
        $variables['element']['#id'] == 'edit-hours-1300'||
        $variables['element']['#id'] == 'edit-hours-1400'||
        $variables['element']['#id'] == 'edit-hours-1500'||
        $variables['element']['#id'] == 'edit-hours-1600'||
        $variables['element']['#id'] == 'edit-hours-1700'||
        $variables['element']['#id'] == 'edit-hours-1800'||
        $variables['element']['#id'] == 'edit-hours-1900'||
        $variables['element']['#id'] == 'edit-hours-2000'||
        $variables['element']['#id'] == 'edit-hours-2100'||
        $variables['element']['#id'] == 'edit-hours-2200'||
        $variables['element']['#id'] == 'edit-hours-2300'
      )
    ) {
      $output .= '<span class="checkmark"></span>';
    }

  }

  // Otherwise, just render the title as the label.
  else {
    // Show label only to screen readers to avoid disruption in visual flows.
    if ($display === 'invisible') {
      $attributes['class'][] = 'element-invisible';
    }
    $output .= $title;
  }

  // The leading whitespace helps visually separate fields from inline labels.
  return ' <label' . drupal_attributes($attributes) . '>' . $output . "</label>\n";
}


