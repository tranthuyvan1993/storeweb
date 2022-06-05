<div class="wrap">
    <h2><?php esc_html_e('Verify Purchase Code','t888-core') ?></h2>
</div>
<?php 
$checkvr = tech888f_check_verify();
if(!$checkvr) $ms_class = 'd-block';
else $ms_class = 'd-hidden';
?>
<p id="message" class="vr-message message-info <?php echo esc_attr($ms_class)?>">
    <strong><?php esc_html_e('Please activate your theme to enable premium features.','t888-core') ?></strong>
</p>
<div id="user-form">
	<?php
	$code_to_verify = get_option('user_purchase_code','');
    $envato_name = get_option('user_envato_name','');
	?>
	<p><?php esc_html_e('Your Envato username*','t888-core') ?></p>
	<p><input class="regular-text" name="user_envato_name" value="<?php echo esc_attr($envato_name)?>"></p>
	<p><?php esc_html_e('Your Purchase code*','t888-core') ?></p>
	<p><input type="password" class="regular-text" name="user_purchase_code" value="<?php echo esc_attr($code_to_verify)?>"></p>
	<p class="submit">
		<a href="#" class="button button-primary check-verify"><?php esc_html_e("Save Changes","t888-core")?></a>
	</p>
</div>
<div id="check-result">
	<?php
	$theme = wp_get_theme();
	if($checkvr){
		echo '<div class="vr-message message-success">';
		echo 	'<p><strong>'.esc_html__('Successful activation!','t888-core').'</strong></p>';
		echo 	'<p><strong>'.esc_html__('Your Information:','t888-core').'</strong></p>';
		$data = tech888f_get_verify_data($code_to_verify);
		if(isset($data['buyer'])){
			echo 	'<p><strong>'.esc_html__('Item name: ','t888-core').'</strong>'.$data['item_name'].'</p>';
			echo 	'<p><strong>'.esc_html__('Item ID: ','t888-core').'</strong>'.$data['item_id'].'</p>';
			echo 	'<p><strong>'.esc_html__('Created at: ','t888-core').'</strong>'.$data['created_at'].'</p>';
			echo 	'<p><strong>'.esc_html__('Buyer: ','t888-core').'</strong>'.$data['buyer'].'</p>';
			echo 	'<p><strong>'.esc_html__('Licence: ','t888-core').'</strong>'.$data['licence'].'</p>';
			echo 	'<p><strong>'.esc_html__('Supported until: ','t888-core').'</strong>'.$data['supported_until'].'</p>';
		}
		echo 	'<p>
					'.esc_html__('Go to our website to create your topic if you have any problem with our theme','t888-core').'
					<a href="'.esc_url('http://web888.vn/').$theme->get( 'TextDomain' ).'">'.esc_html__("Tech888 Group","t888-core").'</a>
				</p>';
		echo '</div>';
	}
	else{
		if($code_to_verify == '' && $envato_name == '') echo '<p class="vr-message message-error">'.esc_html__('Your current theme has not been activated. Please enter the information and activate to start using our products.','t888-core').'</p>';
		else echo '<p class="vr-message message-error">'.esc_html__('Your Invalid information!. Please recheck envato username or purchase code','t888-core').'</p>';
	}
	?>
</div>
<style>
#verify-notice{
	display: none;
}
</style>