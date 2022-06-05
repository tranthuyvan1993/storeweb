<?php

/**
 * Plugin Name: Tech888 Core
 * Plugin URI: #
 * Description: Required with themes of Tech888-Theme. Contains all helper functions.
 * Version: 1.0
 * Author: Tech888
 * Author URI: #
 * Requires at least: 3.8
 * Tested up to: 4.3
 *
 * Text Domain: t888-core
 *
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if(!defined('TECH8888F_TEXTDOMAIN')){
    define('TECH8888F_TEXTDOMAIN','t888-core');
}

defined( 'CORET888_PLUGIN_URL' ) or define('CORET888_PLUGIN_URL', plugins_url( '/', __FILE__ )) ;

defined( 'CORET888_OPTIONS_BY_ELEMENTS' ) or define('CORET888_OPTIONS_BY_ELEMENTS', '_tech888f_options_by_elements') ;

defined( 'CORET888_CUSTOM_ELEMENTS' ) or define('CORET888_CUSTOM_ELEMENTS', '_tech888f_custom_elements') ;

defined( 'CORET888_MENU_TAB_POSITION' ) or define('CORET888_MENU_TAB_POSITION', '_tech888f_menu_tab_position') ;

defined( 'CORET888_PARAM_PREFIX' ) or define('CORET888_PARAM_PREFIX', 'tech888f_');
defined( 'CORET888_DEVICES' ) or define('CORET888_DEVICES', '_tech888f_devices');
defined( 'CORET888_SHOWHIDE' ) or define('CORET888_SHOWHIDE', '_tech888f_showhide');

if(!class_exists('PluginCore'))
{
    class PluginCore
    {
        static protected $_dir='';
        static protected $_uri='';
        static $plugins_data;

        static function init()
        {

            add_action( 'plugins_loaded', array(__CLASS__,'_load_text_domain') );

            self::$_dir=plugin_dir_path(__FILE__);
            self::$_uri=plugin_dir_url(__FILE__);

            global $this_file;
            $this_file=__FILE__;

            self::load_core_class();

            self::load_required_class();


            require_once self::dir('libs/menu.exporter.php');
            require_once self::dir('libs/importer/importer.php');
       //     require_once self::dir('libs/verify_purchasecode.php');
          //  require_once self::dir('libs/adv.php');
            require_once self::dir('libs/reduxframe/reduxframe.php');
            require_once self::dir('libs/reduxframe/metaboxes-config.php');
            // require_once self::dir('ot-loader.php');
           // if(tech888f_check_verify()) require_once self::dir('libs/vc_responsive.php');

            add_filter( 'user_contactmethods', array(__CLASS__,'_add_author_profile'), 10, 1);
            add_action( 'admin_init', array(__CLASS__,'tech888f_disable_vc_update'), 9 );
            add_filter( 'style_loader_src',array(__CLASS__,'_remove_enqueue_ver'), 10, 2 );
            add_filter( 'script_loader_src',array(__CLASS__,'_remove_enqueue_ver'), 10, 2 );
        }
        static function  _load_auto_update()
        {
            self::$plugins_data=get_plugin_data(__FILE__);
            self::$plugins_data['plugin_basename']=plugin_basename(__FILE__);

            require_once self::dir('libs/class.autoupdater.php');

        }
        static function _load_text_domain()
        {
            load_plugin_textdomain( 't888-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

        static function load_core_class()
        {
            $array=glob(self::dir().'core/*');

            if(!is_array($array)) return false;

            $dirs = array_filter($array, 'is_file');

            if(!empty($dirs))
            {
                foreach($dirs as $key=>$value)
                {
                    require_once $value;

                }
            }
        }


        static function load_required_class()
        {
            // Fix array_filter argument should be an array
            $class=glob(self::dir().'class/*');
            if(!is_array($class)) return false;

            $dirs = array_filter($class, 'is_file');

            if(!empty($dirs))
            {
                foreach($dirs as $key=>$value)
                {
                    require_once $value;

                }
            }
        }



        // Helper functions
        static function dir($file=false)
        {
            return self::$_dir.$file;
        }


        static function uri($file=false)
        {
            return self::$_uri.$file;
        }

        static function _add_author_profile( $contactmethods ){       
            $contactmethods['googleplus']   = esc_html__('Google Profile URL','t888-core');
            $contactmethods['twitter']      = esc_html__('Twitter Profile URL','t888-core');
            $contactmethods['facebook']     = esc_html__('Facebook Profile URL','t888-core');
            $contactmethods['linkedin']     = esc_html__('Linkedin Profile URL','t888-core');
            $contactmethods['pinterest']    = esc_html__('Pinterest Profile URL','t888-core');
            $contactmethods['github']       = esc_html__('Github Profile URL','t888-core');
            $contactmethods['instagram']    = esc_html__('Instagram Profile URL','t888-core');
            $contactmethods['vimeo']        = esc_html__('Vimeo Profile URL','t888-core');
            $contactmethods['youtube']      = esc_html__('Youtube Profile URL','t888-core');
            return $contactmethods;
        }        

        static function tech888f_disable_vc_update() {
            if (function_exists('vc_license') && function_exists('vc_updater') && ! vc_license()->isActivated()) {

                remove_filter( 'upgrader_pre_download', array( vc_updater(), 'preUpgradeFilter' ), 10);
                remove_filter( 'pre_set_site_transient_update_plugins', array(
                    vc_updater()->updateManager(),
                    'check_update'
                ) );

            }
        }

        static function _remove_enqueue_ver($src)    {
            if (strpos($src, '?ver='))
                $src = remove_query_arg('ver', $src);
            return $src;
        }

    }
    PluginCore::init();
}
