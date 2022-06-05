<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
?>
<div class="wrap">
    <h2><?php _e('Import Demo Content','t888-core') ?></h2>
</div>
<?php if(tech888f_check_verify()){?>
    <div id="message" class="updated">
        <p>
        The Demo content is a replication of the Live Content. By importing it, you could get several sliders, sliders,
        pages, posts, theme options, widgets, sidebars and other settings.<br>
        To be able to get them, make sure that you have installed and activated these plugins:  Contact form 7 , Option Tree and Visual Composer<br> <span style="color:#f0ad4e">
    WARNING: By clicking Import Demo Content button, your current theme options, sliders and widgets will be replaced. It can also take a minute to complete. <br><span style="color:red"><b>Please back up your database before  it.</b></span>
    Reading config when import error <a href="http://web888.vn/">Click here?</a>
        </p>
        <p><strong>Apache config(php.ini)</strong>: <code>max_input_time = 6000</code>, <code>memory_limit = 128M</code>, <code>max_execution_time= 6000</code>, <code>post_max_size = 64M</code>, <code>upload_max_filesize = 32M</code></p>
        <p><strong>WordPress config(wp-config.php)</strong>: <code>set_time_limit (600);</code></p>
        <br>
    </div>

    <br>
        <a href="#" onclick="return false" data-url="<?php echo admin_url('?t888_do_import=1') ?>" class="btn_stp_do_import button button-primary"><?php _e('Import Now','t888-core')?></a>
        <a href="#" onclick="return false" data-url="<?php echo admin_url('?t888_do_import=1&media=0') ?>" class="btn_stp_do_import button button-primary"><?php _e('Import Without Media','t888-core')?></a>
        <a href="#" onclick="return false" data-url="<?php echo admin_url('?t888_do_import=1&media=2') ?>" class="btn_stp_do_import button button-primary"><?php _e('Import Media','t888-core')?></a>
    <div id="import_debug">
    </div>
    <?php
}
else{
    ?>
        <p id="message" class="vr-message message-info">
            <strong><?php esc_html_e('Please activate your theme to enable premium features.','t888-core') ?></strong>
            <a href="<?php menu_page_url('tech888f_verify')?>"><?php esc_html_e('Activate here.','t888-core') ?></a>
        </p>
    <?php
}
    ?>
<style>
    #import_debug{
        display:none;
        background: none repeat scroll 0 0 #eee;
        height: 300px;
        margin-top: 30px;
        overflow: scroll;
        padding: 20px;
        font-style: normal;
        border:1px solid #ccc;

    }
    #import_debug span{
        color:#0C0;
    }
    #import_debug .red{
        color: #ff0000;
    }

</style>