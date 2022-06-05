<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}
if(!class_exists('Tech888f_VcParam_Typography'))
{
	class Tech888f_VcParam_Typography
	{
		function __construct()
		{
			if ( class_exists( 'WpbakeryShortcodeParams' ) && is_admin() )
			{
				// Add the color picker css file
        		wp_enqueue_style( 'wp-color-picker' );

				WpbakeryShortcodeParams::addField('tech888f_typography' , array($this, 'tech888f_typography'), CORET888_PLUGIN_URL . 'libs/assets/admin/js/res-vcparam-typography.js');

				wp_enqueue_style( 'tech888f_admin_responsive', CORET888_PLUGIN_URL . '/libs/assets/admin/css/admin.css' );
			}
		}

		function tech888f_typography($settings, $value){

			$output = $checked = '';
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			if(empty($value)) {
				$value = isset($settings['value']) ? $settings['value'] : '';
			}

			$output = '<div class="tech888f-typography vc_edit_form_elements res-layout">';

			$html_info_icon = ' <span class="dashicons dashicons-info"></span> ';	
			$output .= 	'<div class="tab-title-settings">
							<ul>
								<li><a class="active res-title-tab" href="res-block">Block Settings</a></li>
								<li><a class="res-title-tab" href="res-background">Background</a></li>
								<li><a class="res-title-tab" href="res-shadow">Shadow</a></li>
								<li><a class="res-title-tab" href="res-overlay">Overlay</a></li>
								<li><a class="res-title-tab" href="res-typography">Typography</a></li>
							</ul>
						</div>';		
			// Block settings
			//$output .= '<div class="wpb_element_label block-start-title">Block Settings</div>';
			$output .= '<div class="block-wrap-content" data-res="res-block" style="display:block">';
				$output .= '<div class="row">';
					$output .= '<div class="col-md-6">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px or %', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Width', 't888-core').'</label> <input type="text" class="res-typo-width" placeholder="1200px or 100%" />';
					$output .= '</div>';
					$output .= '<div class="col-md-6">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px or %', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Max width', 't888-core').'</label> <input type="text" class="res-typo-max-width" placeholder="800px or 80%" />';
					$output .= '</div>';
					$output .= '<div class="col-md-6">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px or %', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Height', 't888-core').'</label> <input type="text" class="res-typo-height" placeholder="800px" />';
					$output .= '</div>';
					$output .= '<div class="col-md-6">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px or %', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Max height', 't888-core').'</label> <input type="text" class="res-typo-max-height" placeholder="800px" />';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label bbhelp-label="'.esc_attr__('from 1 to 99999', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Z-index', 't888-core').'</label> <input type="text" class="res-typo-z-index" placeholder="10" />';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label>'.esc_html__('Margin left', 't888-core').'</label>';
						$output .= '<select class="res-typo-margin-left">
										<option value="">Default</option>
										<option value="auto">Auto</option>
									</select>';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label>'.esc_html__('Margin right', 't888-core').'</label>';
						$output .= '<select class="res-typo-margin-right">
										<option value="">Default</option>
										<option value="auto">Auto</option>
									</select>';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label>'.esc_html__('Display', 't888-core').'</label>';
						$output .= '<select class="res-typo-display">
										<option value="">Default</option>
										<option value="inline">Inline</option>
										<option value="block">Block</option>
										<option value="flex">Flex</option>
										<option value="inline-block">Inline Block</option>
										<option value="table">Table</option>
										<option value="table-cell">Table Cell</option>
										<option value="table-column">Table Column</option>
										<option value="table-row">Table Row</option>
										<option value="none">None</option>
										<option value="initial">Initial</option>
										<option value="inherit">Inherit</option>
									</select>';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label>'.esc_html__('Float', 't888-core').'</label>';
						$output .= '<select class="res-typo-float">
										<option value="">Default</option>
										<option value="none">None</option>
										<option value="left">Left</option>
										<option value="right">Right</option>
										<option value="initial">Initial</option>
										<option value="inherit">Inherit</option>
									</select>';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label>'.esc_html__('Position', 't888-core').'</label>';
						$output .= '<select class="res-typo-position">
										<option value="">Default</option>
										<option value="static">Static</option>
										<option value="absolute">Absolute</option>
										<option value="fixed">Fixed</option>
										<option value="relative">Relative</option>
										<option value="initial">Initial</option>
									</select>';
					$output .= '</div>';
				$output .= '</div>';
				// Position
				$output .= '<div class="row">';
					$output .= '<div class="col-md-3">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px or %', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Top', 't888-core').'</label> <input type="text" class="res-typo-top" placeholder="10px" />';
					$output .= '</div>';
					$output .= '<div class="col-md-3">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px or %', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Right', 't888-core').'</label> <input type="text" class="res-typo-right" placeholder="10px" />';
					$output .= '</div>';
					$output .= '<div class="col-md-3">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px or %', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Bottom', 't888-core').'</label> <input type="text" class="res-typo-bottom" placeholder="10px" />';
					$output .= '</div>';
					$output .= '<div class="col-md-3">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px or %', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Left', 't888-core').'</label> <input type="text" class="res-typo-left" placeholder="10px" />';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';

			// Background
			//$output .= '<div class="wpb_element_label block-start-title">Background Settings</div>';
			$output .= '<div class="block-wrap-content" data-res="res-background">';
				$output .= '<div class="row">';
					$output .= '<div class="col-md-8">';
						$output .= '<label bbhelp-label="'.esc_attr__('Enter URL', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Background image', 't888-core').'</label> <input type="text" class="res-typo-background-image" />';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label>&nbsp;</label><button type="button" class="bbbtn-typo-uploadimage">'.esc_html__('Upload Image', 't888-core').'</button>';
					$output .= '</div>';
				$output .= '</div>';
				$output .= '<div class="row">';
					$output .= '<div class="col-md-4">';
						$output .= '<label>'.esc_html__('Background Attachment', 't888-core').'</label>';
						$output .= '<select class="res-typo-background-attachment">
										<option value="">Default</option>
										<option value="scroll">Scroll</option>
										<option value="fixed">Fixed</option>
										<option value="local">Local</option>
										<option value="initial">Initial</option>
										<option value="inherit">Inherit</option>
									</select>';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px em or rem', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Position-x', 't888-core').'</label> <input type="text" class="res-typo-background-position-x" placeholder="10px" />';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px em or rem', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Position-y', 't888-core').'</label> <input type="text" class="res-typo-background-position-y" placeholder="10px" />';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';

			// Shadow
			//$output .= '<div class="wpb_element_label block-start-title">Shadow Settings</div>';
			$output .= '<div class="block-wrap-content" data-res="res-shadow">';
				$output .= '<div class="row">';
					$output .= '<div class="col-md-3">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px em or rem', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Horizontal', 't888-core').'</label> <input type="text" class="res-typo-box-shadow-horizontal" placeholder="0px" />';
					$output .= '</div>';
					$output .= '<div class="col-md-3">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px em or rem', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Vertical', 't888-core').'</label> <input type="text" class="res-typo-box-shadow-vertical" placeholder="0px" />';
					$output .= '</div>';
					$output .= '<div class="col-md-3">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px em or rem', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Blur', 't888-core').'</label> <input type="text" class="res-typo-box-shadow-blur" placeholder="10px" />';
					$output .= '</div>';
					$output .= '<div class="col-md-3">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px em or rem', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Spread', 't888-core').'</label> <input type="text" class="res-typo-box-shadow-spread" placeholder="0px" />';
					$output .= '</div>';
					$output .= '<div class="col-md-6">';
						$output .= '<label>'.esc_html__('Color', 't888-core').'</label><br/> <input type="text" class="hide-color-picker tech888f-colorpicker-opacity res-typo-box-shadow-color" />';
					$output .= '</div>';
					$output .= '<div class="col-md-6">';
						$output .= '<label>'.esc_html__('Box Sizing', 't888-core').'</label>';
						$output .= '<select class="res-typo-box-sizing">
										<option value="">Outline</option>
										<option value="inset">Inset</option>
									</select>';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';

			// Overlay
			//$output .= '<div class="wpb_element_label block-start-title">Overlay Settings</div>';
			$output .= '<div class="block-wrap-content" data-res="res-overlay">';
				$output .= '<div class="row">';				
					$output .= '<div class="col-md-3">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px or %', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Top', 't888-core').'</label> <input type="text" class="res-typo-box-overlay-top" placeholder="10px" />';
					$output .= '</div>';
					$output .= '<div class="col-md-3">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px or %', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Right', 't888-core').'</label> <input type="text" class="res-typo-box-overlay-right" placeholder="10px" />';
					$output .= '</div>';
					$output .= '<div class="col-md-3">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px or %', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Bottom', 't888-core').'</label> <input type="text" class="res-typo-box-overlay-bottom" placeholder="10px" />';
					$output .= '</div>';
					$output .= '<div class="col-md-3">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px or %', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Left', 't888-core').'</label> <input type="text" class="res-typo-box-overlay-left" placeholder="10px" />';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px or %', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Width', 't888-core').'</label> <input type="text" class="res-typo-box-overlay-width" placeholder="1200px or 100%" />';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px or %', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Height', 't888-core').'</label> <input type="text" class="res-typo-box-overlay-height" placeholder="1200px or 100%" />';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label>'.esc_html__('Background Color', 't888-core').'</label><br/> <input type="text" class="hide-color-picker tech888f-colorpicker-opacity res-typo-box-overlay-background-color" />';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';

			// Typography
			//$output .= '<div class="wpb_element_label block-start-title">Typography Settings</div>';
			$output .= '<div class="block-wrap-content" data-res="res-typography">';
				$output .= '<div class="row">';
					$output .= '<div class="col-md-4">';
						$output .= '<label>'.esc_html__('Color', 't888-core').'</label><br/> <input type="text" class="hide-color-picker tech888f-colorpicker-opacity res-typo-color" />';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px, em or rem', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Line-height', 't888-core').'</label> <input type="text" class="res-typo-line-height" />';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px, em or rem', 't888-core').'" class="bbhelp--left">'.$html_info_icon.esc_html__('Letter-spacing', 't888-core').'</label> <input type="text" class="res-typo-letter-spacing" />';
					$output .= '</div>';
				$output .= '</div>';

				$output .= '<div class="row">';
					$output .= '<div class="col-md-4">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px, em or rem', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Word-spacing', 't888-core').'</label> <input type="text" class="res-typo-word-spacing" />';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px, em or rem', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Font-size', 't888-core').'</label> <input type="text" class="res-typo-font-size" />';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label>'.esc_html__('Font-weight', 't888-core').'</label>';
						$output .= '<select class="res-typo-font-weight">
										<option value="">Default</option>
										<option value="100">Thin (Hairline) - 100</option>
										<option value="200">Extra Light (Ultra Light) - 200</option>
										<option value="300">Light - 300</option>
										<option value="400">Normal - 400</option>
										<option value="500">Medium - 500</option>
										<option value="600">Semi Bold (Demi Bold) - 600</option>
										<option value="700">Bold - 700</option>
										<option value="800">Extra Bold (Ultra Bold) - 800</option>
										<option value="900">Black (Heavy) - 900</option>
									</select>';
					$output .= '</div>';
				$output .= '</div>';

				$output .= '<div class="row">';
					$output .= '<div class="col-md-4">';
						$output .= '<label>'.esc_html__('Font-style', 't888-core').'</label>';
						$output .= '<select class="res-typo-font-style">
										<option value="">Default</option>
										<option value="normal">normal</option>
										<option value="italic">italic</option>
										<option value="oblique">oblique</option>
										<option value="initial">initial</option>
										<option value="inherit">inherit</option>
									</select>';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label>'.esc_html__('White-space', 't888-core').'</label>';
						$output .= '<select class="res-typo-white-space">
										<option value="">Default</option>
										<option value="normal">normal</option>
										<option value="nowrap">nowrap</option>
										<option value="pre">pre</option>
										<option value="pre-line">pre-line</option>
										<option value="pre-wrap">pre-wrap</option>
										<option value="initial">initial</option>
										<option value="inherit">inherit</option>
									</select>';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label>'.esc_html__('Text-overflow', 't888-core').'</label>';
						$output .= '<select class="res-typo-text-overflow">
										<option value="">Default</option>
										<option value="clip">clip</option>
										<option value="ellipsis">ellipsis</option>
										<option value="string">string</option>
										<option value="initial">initial</option>
										<option value="inherit">inherit</option>
									</select>';
					$output .= '</div>';
				$output .= '</div>';

				$output .= '<div class="row">';
					$output .= '<div class="col-md-4">';
						$output .= '<label>'.esc_html__('Text-align', 't888-core').'</label>';
						$output .= '<select class="res-typo-text-align">
										<option value="">Default</option>
										<option value="left">left</option>
										<option value="right">right</option>
										<option value="center">center</option>
										<option value="justify">justify</option>
										<option value="initial">initial</option>
										<option value="inherit">inherit</option>
									</select>';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label>'.esc_html__('Text-transform', 't888-core').'</label>';
						$output .= '<select class="res-typo-text-transform">
										<option value="">Default</option>
										<option value="none">none</option>
										<option value="capitalize">capitalize</option>
										<option value="uppercase">uppercase</option>
										<option value="lowercase">lowercase</option>
										<option value="initial">initial</option>
										<option value="inherit">inherit</option>
									</select>';
					$output .= '</div>';
					$output .= '<div class="col-md-4">';
						$output .= '<label>'.esc_html__('Text-decoration', 't888-core').'</label>';
						$output .= '<select class="res-typo-text-decoration">
										<option value="">Default</option>
										<option value="none">none</option>
										<option value="underline">underline</option>
										<option value="overline">overline</option>
										<option value="line-through">line-through</option>
										<option value="initial">initial</option>
										<option value="inherit">inherit</option>
									</select>';
					$output .= '</div>';
					// Text shadow
					$output .= '<div class="col-md-3">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px em or rem', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Shadow - Blur', 't888-core').'</label> <input type="text" class="res-typo-text-shadow-blur" placeholder="5px"  />';
					$output .= '</div>';
					$output .= '<div class="col-md-3">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px em or rem', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Shadow - Horizontal', 't888-core').'</label> <input type="text" class="res-typo-text-shadow-horizontal" placeholder="0px" />';
					$output .= '</div>';
					$output .= '<div class="col-md-3">';
						$output .= '<label bbhelp-label="'.esc_attr__('unit px em or rem', 't888-core').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Shadow - Vertical', 't888-core').'</label> <input type="text" class="res-typo-text-shadow-vertical" placeholder="0px" />';
					$output .= '</div>';
					$output .= '<div class="col-md-3">';
						$output .= '<label>'.esc_html__('Text shadow - Color', 't888-core').'</label><br/> <input type="text" class="hide-color-picker tech888f-colorpicker-opacity res-typo-text-shadow-color" />';
					$output .= '</div>';

				$output .= '</div>';
			$output .= '</div>';

			$output .= '<input class="tech888f-typography-value wpb_vc_param_value" name="'.$param_name.'" type="hidden" value="'.$value.'" />';

			$output .= '</div>';

			return $output;

		}

	}

	new Tech888f_VcParam_Typography();
}
