<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'Tech888fResVCBuildCSS' ) ) {
	/**
	 * VC Tech888fResVCBuildCSS Class
	 *
	 * @since	1.0
	 */
	class Tech888fResVCBuildCSS {

		public $shortcodes;
		public $post_css;
		public $parent_id;
		public $screens;

		function __construct() {

			add_action( 'init', array( $this, 'init' ) );
			add_action( 'save_post', array( &$this, 'save_post' ), 11 );

		}

		public function init() {

			$this->shortcodes = Tech888fResVCHelper::$shortcodes_active;
			$this->screens = Tech888fResVCHelper::$devices_array;
		}

		public function save_post( $post_id ) {
			$post = get_post( $post_id );
			$this->post_css = get_post_meta( $post_id, '_wpb_shortcodes_custom_css', true );
			
			if ( ( isset( $_POST['wp-preview'] ) && 'dopreview' === $_POST['wp-preview'] ) ) {
				$parent_id = wp_get_post_parent_id( $post_id );
				$this->post_css = get_post_meta( $parent_id, '_wpb_shortcodes_custom_css', true );
			}

			$this->build_css( $post->post_content );
			$this->update_css($post_id);
		}

		public function build_css( $content ) {
			if( !class_exists('WPBMap') ) {
				return;
			}

			$css = '';
			if ( ! preg_match( '/\s*(\.[^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', $content ) ) {
				return;
			}
			WPBMap::addAllMappedShortcodes();
			preg_match_all( '/' . get_shortcode_regex() . '/', $content, $shortcodes );
			foreach ( $shortcodes[2] as $index => $tag ) {
				if( ! in_array($tag, $this->shortcodes) ) {
					continue;
				}

				$shortcode = WPBMap::getShortCode( $tag );
				$attr_array = shortcode_parse_atts( trim( $shortcodes[3][ $index ] ) );
				if ( isset( $shortcode['params'] ) && ! empty( $shortcode['params'] ) ) {
					foreach ( $shortcode['params'] as $param ) {

						if ( 'css_editor' === $param['type'] && isset( $attr_array[ $param['param_name'] ] ) && array_key_exists($param['param_name'], $this->screens) ) {

							$mediafeature = $this->screens[$param['param_name']]['mediafeature'];
							$breakpoint = $this->screens[$param['param_name']]['breakpoint'];

							if(empty($mediafeature) || empty($breakpoint)) {
								continue;
							}

							$responsive_css = ' @media ('.$mediafeature.': ';
							$responsive_css .= $breakpoint . 'px){ ';
							$responsive_css .= $attr_array[ $param['param_name'] ];
							$responsive_css .= '}';

							$this->post_css = str_replace($attr_array[ $param['param_name'] ], $responsive_css, $this->post_css);
						}
					}
				}
			}
			foreach ( $shortcodes[5] as $shortcode_content ) {
				$this->build_css( $shortcode_content );
			}

		}

		public function update_css($post_id) {
			update_post_meta($post_id, '_wpb_shortcodes_custom_css', $this->post_css);
		}

	}

	new Tech888fResVCBuildCSS();
}
