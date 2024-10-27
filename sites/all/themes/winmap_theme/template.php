<?php
/**
 * Created by PhpStorm.
 * User: VDP
 * Date: 28/04/2017
 * Time: 9:22 AM
 */


function winmap_theme_preprocess_page(&$variables) {

	drupal_add_css(drupal_get_path('module', 'winmap_adv') . '/swiper/css/swiper.min.css', ['weight' => 5]);
	drupal_add_js(drupal_get_path('module', 'winmap_adv') . '/swiper/js/swiper.min.js', ['weight' => 5]);

	drupal_add_css('sites/all/libraries/fancybox/source/jquery.fancybox.css', ['weight' => 5]);
	drupal_add_js('sites/all/libraries/fancybox/source/jquery.fancybox.pack.js', ['weight' => 5]);

    drupal_add_css(drupal_get_path('theme', 'winmap_theme') . '/js/lib/owl/owl.carousel.css', array('weight' => 5));
    drupal_add_js(drupal_get_path('theme', 'winmap_theme') . '/js/lib/owl/owl.carousel.min.js', array('weight' => 5));



	global $user;
	$arg = arg();

	// Add information about the number of sidebars.
	if (!empty($variables['page']['sidebar_first']) && !empty($variables['page']['sidebar_second'])) {
		$variables['content_column_class'] = ' class="col-sm-6"';
	}
	elseif (!empty($variables['page']['sidebar_first']) || !empty($variables['page']['sidebar_second'])) {
		$variables['content_column_class'] = ' class="col-sm-9"';
	}
	else {
		$variables['content_column_class'] = ' class="col-sm-12"';
	}

	if (bootstrap_setting('fluid_container') == 1) {
		$variables['container_class'] = 'container-fluid';
	}
	else {
		$variables['container_class'] = 'container';
	}

	// Primary nav.
	$variables['primary_nav'] = FALSE;
	if ($variables['main_menu']) {
		// Build links.
		$variables['primary_nav'] = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
		// Provide default theme wrapper function.
		$variables['primary_nav']['#theme_wrappers'] = ['menu_tree__primary'];
	}

	// Secondary nav.
	$variables['secondary_nav'] = FALSE;
	if ($variables['secondary_menu']) {
		// Build links.
		$variables['secondary_nav'] = menu_tree(variable_get('menu_secondary_links_source', 'user-menu'));
		// Provide default theme wrapper function.
		$variables['secondary_nav']['#theme_wrappers'] = ['menu_tree__secondary'];
	}

	$variables['navbar_classes_array'] = ['navbar'];

	if (bootstrap_setting('navbar_position') !== '') {
		$variables['navbar_classes_array'][] = 'navbar-' . bootstrap_setting('navbar_position');
	}
	elseif (bootstrap_setting('fluid_container') == 1) {
		$variables['navbar_classes_array'][] = 'container-fluid';
	}
	else {
		$variables['navbar_classes_array'][] = 'container';
	}
	if (bootstrap_setting('navbar_inverse')) {
		$variables['navbar_classes_array'][] = 'navbar-inverse';
	}
	else {
		$variables['navbar_classes_array'][] = 'navbar-default';
	}

	// --------- Set temp plate  -------------
	if ($arg[0] == 'node') {
		if (count($arg) == 2) {
			if (is_numeric($arg[1])) {
				$_node = node_load($arg[1]);
				switch ($_node->type) {
					case 'ctype_service':
//						$variables['theme_hook_suggestions'][] = 'page__landing';
						break;
				}
			}
		}
	}
	elseif ($arg[0] == 'taxonomy') {
		if (count($arg) == 3 && $arg[1] == "term" && is_numeric($arg[2])) {
			$_taxonomy = taxonomy_term_load($arg[2]);
			switch ($_taxonomy->vocabulary_machine_name) {
				case 'tx_article':
//					$variables['theme_hook_suggestions'][] = 'page__landing_with_breadcrumb';
					break;
			}
		}
	}
	elseif ($arg[0] == 'user') {
		if (count($arg) == 1) {
			$variables['theme_hook_suggestions'][] = 'page__login';
		}elseif (count($arg) == 2) {
		  if (!is_numeric($arg[1])) {
            if($arg[1] == 'register') {
              $variables['theme_hook_suggestions'][] = 'page__register';
            }
            if($arg[1] == 'login') {
              $variables['theme_hook_suggestions'][] = 'page__login';
            }
            if ($arg[1] == 'password') {
              $variables['theme_hook_suggestions'][] = 'page__login';
            }
          }else {
            if (!empty($user->uid) && $user->uid >=1) {
              $variables['theme_hook_suggestions'][] = 'page__user';
            }
          }
		}
    }
}

function winmap_theme_render_social($socials, $classname = NULL) {
	$output = "";
	if (empty($socials) || count($socials) <= 0) {
		return $output;
	}

	$arr_social = [];
	foreach ($socials as $social) {
		$arr_social[$social]['name'] = $social;
		$arr_social[$social]['url'] = variable_get($social . '_url');
	};
	if (!$classname) {
		$output .= '<ul>';
	}
	else {
		$output .= '<ul class="' . $classname . '">';
	}
	foreach ($arr_social as $social) {
		$output .= '<li><a class="' . $social['name'] . '" href="' . $social['url'] . '">' . $social['name'] . '</a></li>';
	}
	$output .= '</ul>';

	return $output;
}


function winmap_theme_menu_link__menu_footer($variables) {

	$element = $variables['element'];
	$sub_menu = '';
	$options = !empty($element['#localized_options']) ? $element['#localized_options'] : [];

	// Check plain title if "html" is not set, otherwise, filter for XSS attacks.
	$title = empty($options['html']) ? check_plain($element['#title']) : filter_xss_admin($element['#title']);

	// Ensure "html" is now enabled so l() doesn't double encode. This is now
	// safe to do since both check_plain() and filter_xss_admin() encode HTML
	// entities. See: https://www.drupal.org/node/2854978
	$options['html'] = TRUE;

	$href = $element['#href'];
	$attributes = !empty($element['#attributes']) ? $element['#attributes'] : [];

	if ($element['#below']) {
		// Prevent dropdown functions from being added to management menu so it
		// does not affect the navbar module.
		if (($element['#original_link']['menu_name'] == 'management') && (module_exists('navbar'))) {
			$sub_menu = drupal_render($element['#below']);
		}
		elseif ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] == 1)) {
			// Add our own wrapper.
			unset($element['#below']['#theme_wrappers']);
			$sub_menu = '<ul class="sub-menu">' . drupal_render($element['#below']) . '</ul>';
		}
	}

	return '<li' . drupal_attributes($attributes) . '>' . l($title, $href, $options) . $sub_menu . "</li>\n";
}

function winmap_theme_menu_link__main_menu(array $variables) {
	$element = $variables['element'];
	$sub_menu = '';

	$options = !empty($element['#localized_options']) ? $element['#localized_options'] : [];

	// Check plain title if "html" is not set, otherwise, filter for XSS attacks.
	$title = empty($options['html']) ? check_plain($element['#title']) : filter_xss_admin($element['#title']);

	// Ensure "html" is now enabled so l() doesn't double encode. This is now
	// safe to do since both check_plain() and filter_xss_admin() encode HTML
	// entities. See: https://www.drupal.org/node/2854978
	$options['html'] = TRUE;

	$href = $element['#href'];
	$attributes = !empty($element['#attributes']) ? $element['#attributes'] : [];


	if ($element['#below']) {
		// Prevent dropdown functions from being added to management menu so it
		// does not affect the navbar module.
		if (($element['#original_link']['menu_name'] == 'management')) {
			$sub_menu = drupal_render($element['#below']);
		}
		elseif ((!empty($element['#original_link']['depth']))) {

			if ($element['#original_link']['depth'] == 1) {
				// Add our own wrapper.
				unset($element['#below']['#theme_wrappers']);
				$sub_menu = '<ul>' . drupal_render($element['#below']) . '</ul>';

				// Generate as standard dropdown.
				$title .= ' <span class="fa fa-angle-down dropdown"></span>';

			}
			else {
				unset($element['#below']['#theme_wrappers']);
				$sub_menu = '<ul>' . drupal_render($element['#below']) . '</ul>';

				// Generate as standard dropdown.
				$title .= ' <span class="fa fa-angle-right dropdown"></span>';
			}
		}
	}


	if (strpos($sub_menu, "active") > 0) {
		if (!empty($attributes['class'])) {
			$attributes['class'][] = "active";
		}
	}
	return '<li' . drupal_attributes($attributes) . '>' . l($title, $href, $options) . $sub_menu . "</li>\n";
}


function winmap_theme_menu_tree(&$variables) {
	if (!empty($variables['theme_hook_original']) && ($variables['theme_hook_original'] == 'menu_tree__main_menu' ||  $variables['theme_hook_original'] == 'menu_tree__menu_footer_menu') ) {
		return '<ul class="menu">' . $variables['tree'] . '</ul>';
	}
	else {
		return '<ul class="menu nav">' . $variables['tree'] . '</ul>';
	}

}


function winmap_theme_status_messages($variables) {
	$display = $variables['display'];
	$output = '';

	$status_heading = [
		'status' => t('Status message'),
		'error' => t('Error message'),
		'warning' => t('Warning message'),
		'info' => t('Informative message'),
	];

	// Map Drupal message types to their corresponding Bootstrap classes.
	// @see http://twitter.github.com/bootstrap/components.html#alerts
	$status_class = [
		'status' => 'success',
		'error' => 'danger',
		'warning' => 'warning',
		// Not supported, but in theory a module could send any type of message.
		// @see drupal_set_message()
		// @see theme_status_messages()
		'info' => 'info',
	];

	// Retrieve messages.
	$message_list = drupal_get_messages($display);

	// Allow the disabled_messages module to filter the messages, if enabled.
	if (module_exists('disable_messages') && variable_get('disable_messages_enable', '1')) {
		$message_list = disable_messages_apply_filters($message_list);
	}

	if (count($message_list) > 0) {
		$output .= '<div class="modal fade" id="message-model" tabindex="-1" role="dialog" aria-labelledby="message-model-label">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      ';
	}


	foreach ($message_list as $type => $messages) {
		$class = (isset($status_class[$type])) ? ' alert-' . $status_class[$type] : '';
		$output .= "<div class=\"alert alert-block messages $type\">\n";
		//		$output .= "  <a class=\"close\" data-dismiss=\"alert\" href=\"#\">&times;</a>\n";

		//		if (!empty($status_heading[$type])) {
		//			$output .= '<h4 class="element-invisible">' . filter_xss_admin($status_heading[$type]) . "</h4>\n";
		//		}

		if (count($messages) > 1) {
			$output .= " <ul>\n";
			foreach ($messages as $message) {
				$output .= '  <li>' . filter_xss_admin($message) . "</li>\n";
			}
			$output .= " </ul>\n";
		}
		else {
			$output .= filter_xss_admin($messages[0]);
		}

		$output .= "</div>\n";
	}

	if (count($message_list) > 0) {
		$output .= '
        </div>
        </div>
      </div>
    </div>';
	}

	return $output;
}



function winmap_theme_breadcrumb ($variables) {
  if (_bootstrap_use_path_breadcrumbs()) {
    return path_breadcrumbs_breadcrumb($variables);
  }

  $output = '';
  $breadcrumb = $variables['breadcrumb'];

  // Determine if we are to display the breadcrumb.
  $bootstrap_breadcrumb = bootstrap_setting('breadcrumb');
  if (($bootstrap_breadcrumb == 1 || ($bootstrap_breadcrumb == 2 && arg(0) == 'admin')) && !empty($breadcrumb)) {
    $build = array(
      '#theme' => 'item_list__breadcrumb',
      '#attributes' => array(
        'class' => array('breadcrumb'),
      ),
      '#items' => $breadcrumb,
      '#type' => 'ol',
    );
    $output = drupal_render($build);
  }
  return $output;
}




