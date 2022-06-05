<?php
add_filter( 'vc_shortcodes_css_class', 'tech888f_filter_vc_class', 10, 3 );

function tech888f_filter_vc_class( $class_string, $tag, $atts = null ) {

	if ( ! in_array($tag, Tech888fResVCHelper::$shortcodes_active ) && Tech888fResVCHelper::$option_by_elements != 'all' ) {
		return $class_string;
	}

	$flag_show_hide = false;
	$class_show_hide = '';

	$css_typography = '';
	foreach (Tech888fResVCHelper::$devices_array as $id => $device) {
		if(isset($atts[ $id ]) && !empty($atts[ $id ])) {
			$class_string .= vc_shortcode_custom_css_class( $atts[ $id ], ' ' );
		}

		if(isset($atts[ $id . 'typo' ]) && !empty($atts[ $id . 'typo' ])) {
			$class_string .= vc_shortcode_custom_css_class( $atts[ $id . 'typo' ], ' ' );

			$css_typography .= $atts[ $id . 'typo' ];
		}

		if(isset($atts[ $id . 'show_hide' ]) && $atts[ $id . 'show_hide' ] == 'no') {
			$flag_show_hide = true;
			$class_show_hide .= ' ' . $id . '_hide ';
		} else {
			$class_show_hide .= ' ' . $id . '_show ';
		}
	}

	$class_typography = Tech888fResVCHelper::get_css($css_typography);
	if(!empty($class_typography)) {
		$class_string .= ' ' . $class_typography;
	}
	if($flag_show_hide) {
		$class_string .= $class_show_hide;
	}
	if(strpos($class_string, '{}')) $classes = str_replace('{}', ' ', $class_string);
    if(strpos($class_string, '.res')) $class_string = str_replace('.res', 'res', $class_string);
    $data = explode('res_', $class_string);
    foreach ($data as $key => $class) {
        if(!strpos($class, '::before')) $class_string = str_replace('res_'.$data[$key].'::before', '', $class_string);
    }
	return $class_string;
}
