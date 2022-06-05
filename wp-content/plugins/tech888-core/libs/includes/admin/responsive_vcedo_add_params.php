<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'Tech888fResVCAddParams' ) ) {
	/**
	 * VC Tech888fResVCAddParams Class
	 *
	 * @since	1.0
	 */
	class Tech888fResVCAddParams {

		function __construct() {
			add_action( 'init', array( $this, 'init' ) );
		}

		public function init(){
			if ( ! defined( 'WPB_VC_VERSION' ) ) {
                return;
            }

			$group = Tech888fResVCHelper::$tab_option;
			$devices = Tech888fResVCHelper::$devices_array;

			$tabs = array();
			foreach ($devices as $id => $device) {
				$tabs[$id] = $device;
			}

			$shortcodes = Tech888fResVCHelper::$shortcodes_active;

			foreach ($shortcodes as $key => $shortcode) {
				$shortcode = trim($shortcode);
				vc_add_param( $shortcode, array(
					'type' => 'device_tab',
					'param_name' => 'bb_tab_container',
					'active' => Tech888fResVCHelper::$tab_active,
					'tabs' => $tabs,
					'suffix' => array('typo', 'show_hide'),
					'class' => Tech888fResVCHelper::$menu_tab_position,
					'group' => $group,
				));

				foreach ($devices as $id => $device) {
					vc_add_param( $shortcode, array(
						'type' => 'css_editor',
						'heading' => $device['label'],
						'param_name' => $id,
						'group' => $group,
					));

					vc_add_param( $shortcode, array(
						'type' => 'tech888f_toggle',
						'heading' => esc_html__('Show/Hide on ', 't888-core') . $device['label'],
						'param_name' => $id. 'show_hide',
						'group' => $group,
						'value' => 'yes',
					));

					vc_add_param( $shortcode, array(
						'type' => 'tech888f_typography',
						'heading' => Tech888fResVCHelper::$typo_label . ' - ' . $device['label'],
						'param_name' => $id . 'typo',
						'group' => $group,
					));					

				}

			}
		}

	}

	new Tech888fResVCAddParams();
}
