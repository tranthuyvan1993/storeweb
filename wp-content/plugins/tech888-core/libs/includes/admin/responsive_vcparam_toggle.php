<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if(!class_exists('Tech888f_VcParam_Toggle'))
{
	class Tech888f_VcParam_Toggle
	{
		function __construct()
		{
			if ( class_exists( 'WpbakeryShortcodeParams' ) )
			{
				WpbakeryShortcodeParams::addField('tech888f_toggle' , array($this, 'tech888f_toggle'), CORET888_PLUGIN_URL . 'libs/assets/admin/js/res-vcparam-toggle.js');
			}
		}

		function tech888f_toggle($settings, $value){

			$output = $checked = '';
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			if(empty($value)) {
				$value = isset($settings['value']) ? $settings['value'] : '';
			}

			$output = '<label class="bestbug-switch">';

			$output .= '<input class="switch-checkbox" type="checkbox" '.(($value == "yes")?'checked':"").'><div class="bestbug-slider round"></div>';

			$output .= '<input class="switch-value wpb_vc_param_value" name="'.$param_name.'" type="text" value="'.$value.'" />';

			$output .= '</label>';

			return $output;
		}

	}

	new Tech888f_VcParam_Toggle();
}
