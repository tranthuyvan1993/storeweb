<?php
if(!function_exists('tech888f_admin_banner')){
	function tech888f_admin_banner() {
		$ch = wp_remote_get("http://web888.vn/verifycode/wp-json/get-content/banner");
        // Decode returned JSON
        $data_body = array();
        if(is_array($ch) && isset($ch['body'])){
            $data_body = json_decode($ch['body'], true);
            $data_body = str_replace('&lt;', '<', $data_body);
            $data_body = str_replace('&quot;', '"', $data_body);
            $data_body = str_replace('&gt;', '>', $data_body);
        }
        if(is_array($data_body)){
        	extract($data_body);  
        	$this_theme = true;
        	if(!empty($filter_banner)){
		        $theme_info = wp_get_theme();
		        $theme_info = wp_get_theme($theme_info['template']);
		        $theme_name = $theme_info->display('Name');
		        $block_list = explode(',',$filter_banner);
		        if(in_array( $theme_name,$block_list )) $this_theme = false;
		    }
            if(isset($enable_banner)){
            	if($enable_banner == '1' && $this_theme){
    				echo $content_banner;
                }
    		}
		}
	}
}
add_action( 'admin_notices', 'tech888f_admin_banner',99 );
?>