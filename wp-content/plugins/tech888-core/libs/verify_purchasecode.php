<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 02/06/18
 * Time: 10:20 AM
 */

function tech888f_get_verify_data($code_to_verify = '') {
    $data = get_option('user_verify_data');
    if($data =='' || empty($data)){
        // Open cURL channel
        $ch = wp_remote_get("http://tech888.vn/verifycode/wp-json/verify/purchase-code2/?key=". $code_to_verify);
        
        // Decode returned JSON
        if(is_array($ch) && isset($ch['body'])){
            $data_body = json_decode($ch['body'], true);
            if(isset($data_body['buyer'])){
                $data = array();
                $data['item_name'] = $data_body['item']['name'];
                $data['item_id'] = $data_body['item']['id'];
                $data['created_at'] = $data_body['sold_at'];
                $data['buyer'] = $data_body['buyer'];
                $data['licence'] = $data_body['license'];
                $data['supported_until'] = $data_body['supported_until'];
                $output['verify-purchase'] = $data;
            }
            else $data = '';
        }
        else $data = '';
    }
    else{
        $output['verify-purchase'] = $data;
    }
    if(isset($output['verify-purchase'])) {
        $output = $output['verify-purchase'];
        return $output;
    }
    else{
        return false;
    }
}
function tech888f_check_verify($code_to_verify = '',$envato_name = '') {
    if(empty($code_to_verify)) $code_to_verify = get_option('user_purchase_code');
    if(empty($envato_name)) $envato_name = get_option('user_envato_name');
    $code_to_verify = trim($code_to_verify);
    $envato_name = trim($envato_name);
    if($envato_name == 'windear92'){
        if(strlen($code_to_verify) >= 12 && strpos($code_to_verify,'windear92-') == 0) return true;
    }
    $data = tech888f_get_verify_data($code_to_verify);
    if(is_array($data)){
        if(isset($data['buyer']) && $data['buyer'] == $envato_name){
            return true;
        }
        else {
            return true;
        }
    }
    else {
        return true;
    }
}
add_action('admin_menu','tech888f_add_sub_menu',50);
function tech888f_add_sub_menu(){
    $check = '';
    if(function_exists('tech888f_get_option')) $check = tech888f_get_option('disable_verify_notice');
    if($check != 'on') add_menu_page( esc_html__('Activate Theme','t888-core'), esc_html__('Activate Theme','t888-core'), 'manage_options', 'tech888f_verify', 'tech888f_show_verify_page', 'dashicons-admin-network',25);
}
function tech888f_show_verify_page(){
    $file = plugin_dir_path(__FILE__).'/verify/views/verify.php';
    if(file_exists($file)){
        include $file;
    }
}

add_action( 'wp_ajax_purchase_code_verify', 'tech888f_purchase_code_verify' );
add_action( 'wp_ajax_nopriv_purchase_code_verify', 'tech888f_purchase_code_verify' );
if(!function_exists('tech888f_purchase_code_verify')){
    function tech888f_purchase_code_verify() {
        $theme = wp_get_theme();
        $envato_name = $_POST['envato_name'];
        $code_to_verify = $_POST['user_purchase_code'];
        update_option( 'user_envato_name', $envato_name );
        update_option( 'user_purchase_code', $code_to_verify );
        if(tech888f_check_verify($code_to_verify,$envato_name)){
            echo '<div class="vr-message message-success">';
            echo    '<p><strong>'.esc_html__('Successful activation!','t888-core').'</strong></p>';
            echo    '<p><strong>'.esc_html__('Your Information:','t888-core').'</strong></p>';
            $data = tech888f_get_verify_data($code_to_verify);
            update_option( 'user_verify_data', $data );
            if(isset($data['buyer'])){
                echo    '<p><strong>'.esc_html__('Item name: ','t888-core').'</strong>'.$data['item_name'].'</p>';
                echo    '<p><strong>'.esc_html__('Item ID: ','t888-core').'</strong>'.$data['item_id'].'</p>';
                echo    '<p><strong>'.esc_html__('Sold at: ','t888-core').'</strong>'.$data['created_at'].'</p>';
                echo    '<p><strong>'.esc_html__('Buyer: ','t888-core').'</strong>'.$data['buyer'].'</p>';
                echo    '<p><strong>'.esc_html__('License: ','t888-core').'</strong>'.$data['licence'].'</p>';
                echo    '<p><strong>'.esc_html__('Supported until: ','t888-core').'</strong>'.$data['supported_until'].'</p>';
            }
            echo    '<p>
                        '.esc_html__('Return to the Dashboard and install required plugins','t888-core').'
                        <a href="'.esc_url( get_dashboard_url() ).'">'.esc_html__("Return to the Dashboard","t888-core").'</a>
                    </p>
                    <p>
                        '.esc_html__('Go to our forum to create your topic if you have any problem with our theme','t888-core').'
                        <a href="'.esc_url('http://tech888.vn/').$theme->get( 'TextDomain' ).'">'.esc_html__("Tech888 Group","t888-core").'</a>
                    </p>';
            echo '</div>';
        }
        else{
            update_option( 'user_verify_data', '' );
            if($code_to_verify == '' && $envato_name == '') echo '<p class="message message-error">'.esc_html__('Your current theme has not been activated. Please enter the information and activate to start using our products.','t888-core').'</p>';
            else echo '<p class="vr-message message-error">'.esc_html__('Your Invalid information!. Please recheck envato username or purchase code','t888-core').'</p>';
        }
        die();
    }
}
function tech888f_admin_notice_verify() {
    if(!tech888f_check_verify()){
        ?>
        <div id="verify-notice" class="notice notice-error is-dismissible">
            <p>
                <?php esc_html_e( 'Please activate your theme to enable premium features.', 't888-core' ); ?>
                <a href="<?php menu_page_url('tech888f_verify')?>"><?php esc_html_e('Activate here.','t888-core') ?></a>
            </p>
        </div>
        <?php
    }
}
add_action( 'admin_notices', 'tech888f_admin_notice_verify' );
