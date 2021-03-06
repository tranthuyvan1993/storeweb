<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'Tech888fResVCHelper' ) ) {
	/**
	 * VC Tech888fResVCHelper Class
	 *
	 * @since	1.0
	 */
	class Tech888fResVCHelper {
		public static $shortcodes;

		public static $option_by_elements;
		public static $custom_elements;
		public static $menu_tab_position;

		public static $devices;

		public static $devices_array;
		public static $custom_elements_array;
		public static $shortcodes_active;

		public static $tab_option;
		public static $tab_active;
		public static $typo_label;

		public static $show_hide_css;

		function __construct() {

			if ( ! defined( 'WPB_VC_VERSION' ) ) {
                return;
            }

			self::$tab_option = esc_html('Responsive Design Options', 't888-core');
			self::$typo_label = esc_html('Block Settings', 't888-core');
			self::$tab_active = CORET888_PARAM_PREFIX . 'x_large_css';

			self::$option_by_elements = get_option(CORET888_OPTIONS_BY_ELEMENTS, apply_filters( 'tech888f_options_by_elements_default', '' ) );
			self::$custom_elements = get_option(CORET888_CUSTOM_ELEMENTS, apply_filters( 'tech888f_custom_elements_default', 'vc_row,vc_column' ) );
			self::$menu_tab_position = get_option(CORET888_MENU_TAB_POSITION, apply_filters( 'tech888f_menu_tab_position_default', 'right' ) );

			self::$show_hide_css = get_option(CORET888_SHOWHIDE, apply_filters( 'tech888f_css_show_hide_default', ' .tech888f_x_large_css_hide {display:none!important} .tech888f_x_large_css_show {display:block!important} @media (max-width: 1199px) {  .tech888f_large_css_hide {display:none!important} .tech888f_large_css_show {display:block!important}}  @media (max-width: 991px) {  .tech888f_medium_css_hide {display:none!important} .tech888f_medium_css_show {display:block!important}}  @media (max-width: 767px) {  .tech888f_small_css_hide {display:none!important} .tech888f_small_css_show {display:block!important}} ' ) );

			add_action( 'init', array( $this, 'init' ) );

		}

		public function init(){
			if(self::$option_by_elements == 'all') {
				$this->generateData();
				self::$shortcodes_active = self::$shortcodes;
			} elseif(self::$option_by_elements == 'custom') {
				self::$custom_elements_array = explode(',', self::$custom_elements);
				self::$shortcodes_active = self::$custom_elements_array;
			}

			if( !is_array(self::$shortcodes_active) ) {
				self::$shortcodes_active = array();
			}
			array_push(self::$shortcodes_active, '');

			self::$devices = get_option(CORET888_DEVICES,
			apply_filters( 'bbvcedo_devices_default', array(
				'x_large_css' => array(
					'label' => 'Default devices',
					'mediafeature' => '',
					'breakpoint' => '',
					'icon' => 'class_icon',
					'class_icon' => 'dashicons dashicons-desktop',
					'image_icon' => '',
					'order' => 1,
				),
				'large_css' => array(
					'label' => 'Large devices',
					'mediafeature' => 'max-width',
					'breakpoint' => '1199',
					'icon' => 'class_icon',
					'class_icon' => 'dashicons dashicons-laptop',
					'image_icon' => '',
					'order' => 2,
				),
				'medium_css' => array(
					'label' => 'Medium devices',
					'mediafeature' => 'max-width',
					'breakpoint' => '991',
					'icon' => 'class_icon',
					'class_icon' => 'dashicons dashicons-tablet',
					'image_icon' => '',
					'order' => 3,
				),
				'small_css' => array(
					'label' => 'Small devices (Landscape)',
					'mediafeature' => 'max-width',
					'breakpoint' => '767',
					'icon' => 'class_icon',
					'class_icon' => 'dashicons dashicons-smartphone',
					'image_icon' => '',
					'order' => 4,
				),
				's_small_css' => array(
					'label' => 'Small devices',
					'mediafeature' => 'max-width',
					'breakpoint' => '480',
					'icon' => 'class_icon',
					'class_icon' => 'dashicons dashicons-smartphone',
					'image_icon' => '',
					'order' => 5,
				),
			)) );

			if(!is_array(self::$devices)) {
				self::$devices = array();
			}

			foreach (self::$devices as $id => $device) {
				self::$devices_array[ CORET888_PARAM_PREFIX . $id] = $device;
			}
		}

		public static function array_unshift_assoc($arr, $key, $val) {
		    $arr = array_reverse($arr, true);
		    $arr[$key] = $val;
		    return array_reverse($arr, true);
		}

		public static function generateData() {
			if( !class_exists('WPBMap') ) {
				return;
			}

			$allShortcodes = WPBMap::getAllShortCodes();
			self::$shortcodes = array();
			foreach ( $allShortcodes as $tag => $shortcode ) {
				if( !isset($shortcode['params']) ) {
					continue;
				}

				foreach ($shortcode['params'] as $key => $param) {
					if( $key != 'css_editor' ) {
						continue;
					} else {
						array_push( self::$shortcodes, $tag);
						break;
					}
				}
			}
		}

		public static function shortcodes(){
			self::generateData();
			return self::$shortcodes;
		}

		public static function get_class( $param_value, $prefix = '' ) {
			$css_class = preg_match( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', $param_value ) ? $prefix . preg_replace( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', '$1', $param_value ) : '';

			return $css_class;
		}

		public static function get_css($css){
			$class = '';
			if (preg_match("/color:/i", $css)) {
				$class .= ' resvcedo-ci';
			}
			if (preg_match("/line-height:/i", $css)) {
				$class .= ' resvcedo-lhi';
			}
			if (preg_match("/letter-spacing:/i", $css)) {
				$class .= ' resvcedo-lsi';
			}

			if (preg_match("/word-spacing:/i", $css)) {
				$class .= ' resvcedo-wsi';
			}
			if (preg_match("/font-size:/i", $css)) {
				$class .= ' resvcedo-fsi';
			}
			if (preg_match("/font-weight:/i", $css)) {
				$class .= ' resvcedo-fwi';
			}

			if (preg_match("/font-style:/i", $css)) {
				$class .= ' resvcedo-fsti';
			}
			if (preg_match("/white-space:/i", $css)) {
				$class .= ' resvcedo-whsi';
			}
			if (preg_match("/text-overflow:/i", $css)) {
				$class .= ' resvcedo-toi';
			}

			if (preg_match("/text-align:/i", $css)) {
				$class .= ' resvcedo-tai';
			}
			if (preg_match("/text-transform:/i", $css)) {
				$class .= ' resvcedo-tti';
			}
			if (preg_match("/text-decoration:/i", $css)) {
				$class .= ' resvcedo-tdi';
			}

			return $class;
		}

	}

	new Tech888fResVCHelper();
}
