<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'Tech888fResVCOptions' ) ) {
	/**
	 * VC Tech888fResVCOptions Class
	 *
	 * @since	1.0
	 */
	class Tech888fResVCOptions {

		public $devices;

		public $option_by_elements;
		public $custom_elements;
		public $menu_tab_position;

		public $idEdit;

		public $idSlug;
		public $label;
		public $mediafeature;
		public $breakpoint;
		public $icon;
		public $class_icon;
		public $image_icon;
		public $order;

		public $orders = array();

		public $tech888fResIdDeviceDel;

		public $editMode = false;

		public $notice;

		public $mediaFeatures = array(
			'max-width',
			'min-width',
			'height',
			'width',
			'max-height',
			'min-height',
			'device-height',
			'device-width',
			'max-device-height',
			'max-device-width',
			'min-device-width',
			'min-device-height',
		);

		function __construct($option_by_elements, $custom_elements, $menu_tab_position) {

			$this->option_by_elements = $option_by_elements;
			$this->custom_elements = $custom_elements;
			$this->menu_tab_position = $menu_tab_position;

			add_action( 'init', array( &$this, 'init' ) );
			add_action( 'admin_menu', array( &$this, 'admin_menu' ) );


		}

		public function init() {
			$this->devices = Tech888fResVCHelper::$devices;
		}

		public function admin_menu(){
			if ( ! defined( 'WPB_VC_VERSION' ) ) {
                return;
            }

			add_menu_page(
		        esc_html('Responsive Settings', 't888-core'),
		        esc_html('Responsive Settings', 't888-core'),
		        'manage_options',
		        'tech888f_res_options',
		        array( &$this, 'generalSettings') ,
		        'dashicons-laptop',
		        76
		    );

			add_submenu_page(
				'tech888f_res_options',
				esc_html('General Settings', 't888-core'),
				esc_html('General Settings', 't888-core'),
				'manage_options',
				'tech888f_res_options',
				array(&$this, 'generalSettings' )
			);

			add_submenu_page(
				'tech888f_res_options',
				esc_html('All Devices', 't888-core'),
				esc_html('All Devices', 't888-core'),
				'manage_options',
				'tech888f_res_all_devices',
				array(&$this, 'allDevices' )
			);

			add_submenu_page(
				'tech888f_res_options',
				esc_html('Add New Device', 't888-core'),
				esc_html('Add New Device', 't888-core'),
				'manage_options',
				'tech888f_res_addnewdevice',
				array(&$this, 'addNewDevice' )
			);

			if( isset( $_POST['tech888f_res_update_general'] ) && ( '1' === $_POST['tech888f_res_update_general'] || 'true' === $_POST['tech888f_res_update_general'] ) ) {
				$this->update_general();
			}

			if( isset( $_POST['tech888f_res_addnewdevice'] ) && ( '1' === $_POST['tech888f_res_addnewdevice'] || 'true' === $_POST['tech888f_res_addnewdevice'] ) ) {
				$this->request_addnewdevice();
			}

			if( isset( $_POST['tech888fResIdDeviceDel'] ) && '' != $_POST['tech888fResIdDeviceDel'] ) {
				$this->delete_device();
			}

			if( isset( $_POST['tech888f_res_update_order'] ) && '1' === $_POST['tech888f_res_update_order'] ) {
				$this->update_order_device();
			}

			if( isset( $_GET['idEdit'] ) && '' != $_GET['idEdit'] ) {
				$this->idEdit = $_GET['idEdit'];

				if( isset( $_POST['tech888f_res_updatedevice'] ) && ( '1' === $_POST['tech888f_res_updatedevice'] || 'true' === $_POST['tech888f_res_updatedevice'] ) ) {
					$this->update_device();
				}
			}

		}

		public function enqueueScript(){
			wp_enqueue_script( 'bb_vcedo', CORET888_PLUGIN_URL . '/libs/assets/admin/js/admin.js', array( 'jquery' ), '1.0', true );
			wp_enqueue_style( 'bb_vcedo', CORET888_PLUGIN_URL . '/libs/assets/admin/css/admin.css' );
		}

		public function generalSettings(){

			$this->enqueueScript();
			include_once ('templates/res_vcedo_general.tpl.php');
		}

		public function allDevices(){

			$this->enqueueScript();
			include_once ('templates/res_vcedo_all_devices.tpl.php');
		}

		public function addNewDevice(){

			wp_enqueue_media();
			$this->enqueueScript();

			if( $this->idEdit != '' && array_key_exists($this->idEdit, $this->devices) ) {
				$device = $this->devices[$this->idEdit];
				$this->idSlug = $this->idEdit;
				$this->label = $device['label'];
				$this->mediafeature = $device['mediafeature'];
				$this->breakpoint = $device['breakpoint'];
				$this->icon = $device['icon'];
				$this->class_icon = $device['class_icon'];
				$this->image_icon = $device['image_icon'];
				$this->order = $device['order'];

				$this->editMode = true;
			}

			include_once ('templates/res_vcedo_addnew.tpl.php');
		}

		public function update_device(){

			if( $this->idEdit != '' && array_key_exists($this->idEdit, $this->devices) ) {

				$dataDevice = array();
				foreach ($_POST as $key => $value) {
					$dataDevice[$key] = $value;
				}

				//if($dataDevice['idSlug'] == $this->idEdit) {
					unset($dataDevice['idSlug']);
					$this->devices[$this->idEdit] = $dataDevice;
				// } else {
				// 	if($dataDevice['idSlug'] == '' || array_key_exists($dataDevice['idSlug'], $this->devices)) {
				// 		$this->notice = esc_html__( 'ID must not empty or duplicate!', 't888-core' );
				// 		add_action( 'admin_notices', array( $this, 'error_notice' ) );
				// 		return;
				// 	}
				//
				// 	$id = $dataDevice['idSlug'];
				// 	unset($dataDevice['idSlug']);
				// 	unset($this->devices[$this->idEdit]);
				// 	$this->idEdit = $id;
				// 	$this->devices = Tech888fResVCHelper::array_unshift_assoc($this->devices, $id, $dataDevice);
				//
				// }

				$this->sort_devices();

				if( self::update_option(CORET888_DEVICES, $this->devices) ) {
					$this->build_css_show_hide();
					$this->notice = esc_html__( 'Updated device!', 't888-core' );
					add_action( 'admin_notices', array( $this, 'update_notice' ) );
				} else {
					$this->notice = esc_html__( 'Irks! An error has occurred.', 't888-core' );
					add_action( 'admin_notices', array( $this, 'error_notice' ) );
				}

			}

		}

		public function delete_device(){
			foreach ($_POST as $key => $value) {
				$this->$key = esc_attr($value);
			}

			if($this->tech888fResIdDeviceDel == '' || !array_key_exists($this->tech888fResIdDeviceDel, $this->devices)) {
				$this->notice = esc_html__( 'Not found any Devices have this ID', 't888-core' );
				add_action( 'admin_notices', array( $this, 'error_notice' ) );
				return;
			}

			unset($this->devices[$this->tech888fResIdDeviceDel]);

			if( self::update_option(CORET888_DEVICES, $this->devices) ) {
				$this->resetDeviceDetail();
				$this->notice = esc_html__( 'Deleted device!', 't888-core' );
				add_action( 'admin_notices', array( $this, 'update_notice' ) );
			} else {
				$this->notice = esc_html__( 'Irks! An error has occurred.', 't888-core' );
				add_action( 'admin_notices', array( $this, 'error_notice' ) );
			}
		}

		public function update_general(){
			foreach ($_POST as $key => $value) {
				$this->$key = esc_attr($value);
			}
			if( self::update_option(CORET888_OPTIONS_BY_ELEMENTS, $this->option_by_elements) ||
			self::update_option(CORET888_CUSTOM_ELEMENTS, $this->custom_elements) ||
			self::update_option(CORET888_MENU_TAB_POSITION, $this->menu_tab_position) ) {
				$this->notice = esc_html__( 'Updated', 't888-core' );
				add_action( 'admin_notices', array( $this, 'update_notice' ) );
			} else {
				$this->notice = esc_html__( 'Irks! An error has occurred.', 't888-core' );
				add_action( 'admin_notices', array( $this, 'error_notice' ) );
			}
		}

		public function update_order_device(){
			if(!isset($_POST['orders']) || $_POST['orders'] == '') {
				return;
			}

			$this->orders = $_POST['orders'];

			foreach ($this->orders as $id => $order) {
				$this->devices[$id]['order'] = $order;
			}

			$this->sort_devices();

			if( self::update_option(CORET888_DEVICES, $this->devices) ) {
				$this->build_css_show_hide();
				$this->notice = esc_html__( 'Updated devices!', 't888-core' );
				add_action( 'admin_notices', array( $this, 'update_notice' ) );
			} else {
				$this->notice = esc_html__( 'Irks! An error has occurred.', 't888-core' );
				add_action( 'admin_notices', array( $this, 'error_notice' ) );
			}
		}

		public function request_addnewdevice(){
			$newDevice = array();
			foreach ($_POST as $key => $value) {
				$this->$key = esc_attr($value);
				$newDevice[$key] = $this->$key;
			}

			if($this->idSlug == '') {
				$this->notice = esc_html__( 'ID must not empty!', 't888-core' );
				add_action( 'admin_notices', array( $this, 'error_notice' ) );
				return;
			}
			if(array_key_exists($this->idSlug, $this->devices) ) {
				$this->notice = esc_html__( 'ID exists, ID must not duplicate!', 't888-core' );
				add_action( 'admin_notices', array( $this, 'error_notice' ) );
				return;
			}

			unset($newDevice['idSlug']);
			$this->devices[$this->idSlug] = $newDevice;

			$this->sort_devices();

			if( self::update_option(CORET888_DEVICES, $this->devices) ) {
				$this->resetDeviceDetail();
				$this->build_css_show_hide();
				$this->notice = esc_html__( 'Added device!', 't888-core' );
				add_action( 'admin_notices', array( $this, 'update_notice' ) );
			} else {
				$this->notice = esc_html__( 'Irks! An error has occurred.', 't888-core' );
				add_action( 'admin_notices', array( $this, 'error_notice' ) );
			}
		}

		public function sort_devices(){
			$tmpSlugs = array();
			foreach ($this->devices as $slug => $device) {
				$tmpSlugs[] = array(
					'order' => $device['order'],
					'slug' => $slug,
				);
			}
			usort($tmpSlugs, array($this, "cmp"));
			$tmpDevices = array();
			foreach ($tmpSlugs as $key => $tmp) {
				$tmpDevices[$tmp['slug']] = $this->devices[$tmp['slug']];
			}

			$this->devices = $tmpDevices;
		}

		function cmp($a, $b)
		{
		    return ($a["order"] < $b["order"]) ? -1 : 1;
		}


		public function build_css_show_hide(){

			if(!is_array($this->devices) || empty($this->devices)) {
				return;
			}

			$css = '';
			foreach ($this->devices as $id => $device) {
				$mediafeature = $device['mediafeature'];
				$breakpoint = $device['breakpoint'];

				if(empty($mediafeature) || empty($breakpoint)) {
					$css .= ' .' . CORET888_PARAM_PREFIX . $id . '_hide {display:none!important}';
					$css .= ' .' . CORET888_PARAM_PREFIX . $id . '_show {display:block!important}';
					continue;
				}

				$css .= ' @media ('.$mediafeature.': ';
				$css .= $breakpoint . 'px) { ';
				$css .= ' .' . CORET888_PARAM_PREFIX . $id . '_hide {display:none!important}';
				$css .= ' .' . CORET888_PARAM_PREFIX . $id . '_show {display:block!important}';
				$css .= '} ';
			}
			self::update_option(CORET888_SHOWHIDE, $css);
		}

		public function update_option( $option_name, $option_value ){
			$option_exists = (get_option( $option_name, null) !== null);
			if($option_exists != null) {
				return update_option($option_name, $option_value);
			} else {
				return add_option($option_name, $option_value);
			}
		}

		public function error_notice() {
			$class = 'notice notice-error';
			printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $this->notice );
		}
		public function update_notice() {
			$class = 'notice notice-updated updated';
			printf( '<div class="%1$s"><p>%2$s</p></div>', $class,  $this->notice );
		}

		public function resetDeviceDetail(){
			$this->idSlug = '';
			$this->label = '';
			$this->mediafeature = '';
			$this->breakpoint = '';
			$this->icon = '';
			$this->class_icon = '';
			$this->image_icon = '';
			$this->order = '';
			return;
		}

	}

	new Tech888fResVCOptions(
		Tech888fResVCHelper::$option_by_elements,
		Tech888fResVCHelper::$custom_elements,
		Tech888fResVCHelper::$menu_tab_position
	);
}
