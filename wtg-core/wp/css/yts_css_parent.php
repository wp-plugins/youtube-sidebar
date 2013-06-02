<?php
// $side is already set as required parameter
if($side == 'admin' || $yts_css_side_override == true){

    /*
    * Do yts_css('admin',true); to run the admin lines but also trigger use of them on public side
    * Do yts_css('public',true); to use both public and admin lines, must ensure there is no double uses
    */

    // register our jquery style

    /**
    * @todo move this function to an appropriate function file and move add_action to the main file
    */
    
    function yts_register_admin_styles() {
        
         // are jQuery UI styles wanted 
        global $yts_guitheme;
        if(isset($yts_guitheme) && $yts_guitheme == 'jquery'){
            wp_deregister_style('yts_jquery_styles');# TODO:LOWPRIORITY, I don't think this line is needed
            wp_register_style('yts_jquery_styles',plugins_url(WTG_YTS_FOLDERNAME.'/wtg-core/wp/css/jquerythemes/start/jquery-ui-1.8.17.custom.css'), array(), '1.0.0', 'screen');
        }                                                                   
        
        // WebTechGlobal styles
        wp_register_style('yts_css_notification',plugins_url(WTG_YTS_FOLDERNAME.'/wtg-core/wp/css/notifications.css'), array(), '1.0.0', 'screen');
        wp_register_style('yts_css_admin',plugins_url(WTG_YTS_FOLDERNAME.'/wtg-core/wp/css/admin.css'), __FILE__);
        wp_register_style('yts_css_global',plugins_url(WTG_YTS_FOLDERNAME.'/wtg-core/wp/css/global.css'), __FILE__);

        // widgets
        wp_register_style('yts_css_jquerymultiselect',plugins_url(WTG_YTS_FOLDERNAME.'/wtg-core/wp/script/multiselect/jquery.multiselect.css'), __FILE__);
        wp_register_style('yts_css_jquerymultiselect_prettify',plugins_url(WTG_YTS_FOLDERNAME.'/wtg-core/wp/script/multiselect/assets/prettify.css'), __FILE__);
        wp_register_style('yts_css_jquerymultiselect_filter',plugins_url(WTG_YTS_FOLDERNAME.'/wtg-core/wp/script/multiselect/jquery.multiselect.filter.css'), __FILE__);
        wp_register_style('yts_css_jquerymulti-select',plugins_url(WTG_YTS_FOLDERNAME.'/wtg-core/wp/css/jquery.multi-select.css'), __FILE__);            
    }

    function yts_admin_styles_callback() {
        
        // are jQuery UI styles wanted 
        global $yts_guitheme;
        if(isset($yts_guitheme) && $yts_guitheme == 'jquery'){
            wp_enqueue_style('yts_jquery_styles');
        }
        
        wp_enqueue_style('yts_css_notification');
        wp_enqueue_style('yts_css_admin');
        wp_enqueue_style('yts_css_global');
        wp_enqueue_style('yts_css_jquerymultiselect');
        wp_enqueue_style('yts_css_jquerymultiselect_asset');
        wp_enqueue_style('yts_css_jquerymultiselect_prettify');
        wp_enqueue_style('yts_css_jquerymulti-select');
        wp_enqueue_style('yts_css_jqueryaccordion');                    
    }

    // print admin only styles (must be preregistered)
    add_action('admin_print_styles','yts_admin_styles_callback');
    add_action('init','yts_register_admin_styles');
}

// do not make this an else, this is to allow the admin override to be used AND apply public specific lines
if($side == 'public'){
    
}
?>
