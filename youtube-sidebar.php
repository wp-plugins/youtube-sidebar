<?php         
/*
Plugin Name: YouTube Sidebar by WebTechGlobal
Version: 2.0.0
Plugin URI: http://youtubesidebar.webtechglobal.co.uk
Description: Display YouTube video for individual post and pages in the sidebar
Author: WebTechGlobal
Author URI: http://www.webtechglobal.co.uk

YouTube Sidebar GPL v3 (free edition license, ignore for any other edition not downloaded from Wordpress.org)

This program is free software downloaded from Wordpress.org: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. This means
it can be provided for the sole purpose of being developed further
and we do not promise it is ready for any one persons specific needs.
See the GNU General Public License for more details.

See <http://www.gnu.org/licenses/>.

This license does not apply to the paid edition which comes with premium
services not just software. License and agreement is seperate.
*/         
                            
// package variables (frequently changed)
$yts_currentversion = '2.0.0';
$yts_php_version_tested = '5.4.12';// current version the plugin is being developed on
$yts_php_version_minimum = '5.3.0';// minimum version required for plugin to operate
$yts_is_free_override = false;// change to true for free edition setup when fulledition folder present 
$yts_demo_mode = false;// we do not want error display on demos on www.csvtopost.com
$yts_debug_mode = false;// www.csvtopost.com will override this but only if demo mode not active
$yts_beta_mode = false;// must be set to true prior to installation to ensure beta features are configured properly
$yts_is_dev = false;// false|true  - true will display more information i.e. array dumps using var_dump() 

// activate debug by url or based on the domain - you can change this to your own test domains                   
if($yts_demo_mode != true){# we ensure no error output on demos    
    if(isset($_GET['ytsdebug']) || ABSPATH == '/home/sites/webtechglobal.co.uk/public_html/testing/wordpress/youtubesidebar/' ){
        $yts_debug_mode = true; 
        $yts_beta_mode = true;
        $yts_is_dev = true;      
    }                
}
    
// error output should never be on during AJAX requests               
if(defined('DOING_AJAX') && DOING_AJAX){
    $yts_debug_mode = false;    
}
         
// other variables required on installation or loading
### TODO:HIGHPRIORITY, some these should be constants 
$yts_plugintitle = 'YouTube Sidebar';// requires so that extensions can re-brand the plugin
$yts_pluginname = 'youtube-sidebar';// should not be used to make up paths
$yts_homeslug = $yts_pluginname;// @todo page slug for plugin main page used in building menus
$yts_isbeingactivated = false;// changed to true during activation, used to avoid certain processing especially the schedule and automation system
$yts_is_event = false;// when true, an event is running or has ran, used to avoid over processing         
$yts_installation_required = true;                                                     
$yts_is_installed = false;        
$yts_was_installed = false;
$yts_log_maindir = 'unknown';
$yts_currentproject = 'No Project Set';
$yts_notice_array = array();// set notice array for storing new notices in (not persistent notices)
                                   
##########################################################################################
#                                                                                        #
#                                     DEFINE CONSTANTS                                   #
#                                                                                        #
##########################################################################################
### TODO:LOWPRIORITY, add forward slash to the end of WTG_YTS_CONTENTFOLDER_DIR, we want all constants to hold a slash at the end as standard
### TODO:LOWPRIORITY, change WTG_YTS_DIR to WTG_YTS_PATH                
if(!defined("WTG_YTS_ABB")){define("WTG_YTS_ABB","yts_");}
if(!defined("WTG_YTS_NAME")){define("WTG_YTS_NAME",'YouTube Sidebar');} 
if(!defined("WTG_YTS_URL")){define("WTG_YTS_URL", plugin_dir_url(__FILE__) );}//http://localhost/wordpress-testing/wtgplugintemplate/wp-content/plugins/wtgplugintemplate/
if(!defined("WTG_YTS_DIR")){define("WTG_YTS_DIR", plugin_dir_path(__FILE__) );}//C:\AppServ\www\wordpress-testing\wtgplugintemplate\wp-content\plugins\wtgplugintemplate/
if(!defined("WTG_YTS_FOLDERNAME")){define("WTG_YTS_FOLDERNAME",'youtube-sidebar');}// The plugins main folder name in the wordpress plugins directory  
if(!defined("WTG_YTS_BASENAME")){define("WTG_YTS_BASENAME", plugin_basename( __FILE__ ) );}// wtgplugintemplate/wtgtemplateplugin.php
if(!defined("WTG_YTS_PHPVERSIONTESTED")){define("WTG_YTS_PHPVERSIONTESTED",$yts_php_version_tested);}// The latest version of php the plugin has been tested on and certified to be working 
if(!defined("WTG_YTS_PHPVERSIONMINIMUM")){define("WTG_YTS_PHPVERSIONMINIMUM",$yts_php_version_minimum);}// The minimum php version that will allow the plugin to work     
if(!defined("WTG_YTS_CHMOD")){define("WTG_YTS_CHMOD",'0755');}###TODO:CRITICALPRIORITY,should this not be 0700? // File permission default CHMOD for any folders or files created by plugin  
if(!defined("WTG_YTS_CORE_PATH")){define("WTG_YTS_CORE_PATH",WP_PLUGIN_DIR.'/'.WTG_YTS_FOLDERNAME.'/wtg-core/');}
if(!defined("WTG_YTS_WPCORE_PATH")){define("WTG_YTS_WPCORE_PATH",WP_PLUGIN_DIR.'/'.WTG_YTS_FOLDERNAME.'/wtg-core/wp/');}
if(!defined("WTG_YTS_PAID_PATH")){define("WTG_YTS_PAID_PATH",WP_PLUGIN_DIR.'/'.WTG_YTS_FOLDERNAME.'/fulledition/');}
if(!defined("WTG_YTS_PANELFOLDER_PATH")){define("WTG_YTS_PANELFOLDER_PATH",WP_PLUGIN_DIR.'/'.WTG_YTS_FOLDERNAME.'/panels/');}// directory path to storage folder inside the wp_content folder                            
if(!defined("WTG_YTS_CONTENTFOLDER_DIR")){define("WTG_YTS_CONTENTFOLDER_DIR",WP_CONTENT_DIR.'/'.'youtubesidebarcontent');}// directory path to storage folder inside the wp_content folder  
if(!defined("WTG_YTS_IMAGEFOLDER_URL")){define("WTG_YTS_IMAGEFOLDER_URL",WP_PLUGIN_URL.'/'.WTG_YTS_FOLDERNAME.'/images/');} 
if(!defined("WTG_YTS_DATEFORMAT")){define("WTG_YTS_DATEFORMAT",'Y-m-d H:i:s');}
if(!defined("WTG_YTS_ID")){define("WTG_YTS_ID","27");}// used by SOAP web services, this ID allows specific web services to be made available for this plugin. Change the ID and things will simply go very wrong
               
// decide if package is free or full edition - apply the over-ride variable to use as free edition when full edition files present
if(file_exists(WTG_YTS_DIR . 'fulledition') && $yts_is_free_override == false){
    $yts_is_free = false;
}else{
    $yts_is_free = true;
}  
              
##########################################################################################
#                          INCLUDE WEBTECHGLOBAL PHP CORE                                #
##########################################################################################
foreach (scandir( WTG_YTS_DIR . 'wtg-core/php/' ) as $wtgcore_filename) {   
    if ($wtgcore_filename != '.' && $wtgcore_filename != '..' && is_file(WTG_YTS_DIR . 'wtg-core/php/' . $wtgcore_filename)) { 
        if($wtgcore_filename != 'license.html' && $wtgcore_filename != 'index.php'){
            require_once( WTG_YTS_DIR . 'wtg-core/php/' . $wtgcore_filename );
        }                            
    }                        
} 
                        
##########################################################################################
#                           INCLUDE WEBTECHGLOBAL WORDPRESS CORE                         #
########################################################################################## 
$core_exclusions_array = array('wtgcore_wp_formsubmit.php');
foreach (scandir( WTG_YTS_DIR . 'wtg-core/wp/' ) as $wtgcore_filename) {   
    if (!in_array($wtgcore_filename,$core_exclusions_array) && $wtgcore_filename != '.' && $wtgcore_filename != '..' && is_file(WTG_YTS_DIR . 'wtg-core/wp/' . $wtgcore_filename)) { 
        if($wtgcore_filename != 'license.html' && $wtgcore_filename != 'index.php'){
            require_once( WTG_YTS_DIR . 'wtg-core/wp/' . $wtgcore_filename );
        }                            
    }                        
}  
             
##########################################################################################
#                       INCLUDE FREE EDITION FUNCTIONS AND ARRAYS                        #
##########################################################################################
require_once(WTG_YTS_DIR.'include/yts_public_functions.php');
require_once(WTG_YTS_DIR.'include/yts_core_functions.php'); 
require_once(WTG_YTS_DIR.'include/yts_ajax_admin_functions.php');  
require_once(WTG_YTS_DIR.'include/yts_install_functions.php');
require_once(WTG_YTS_DIR.'include/yts_sql_functions.php');             
require_once(WTG_YTS_DIR.'include/variables/yts_wordpressoptionrecords_array.php'); 
require_once(WTG_YTS_DIR.'wtg-core/wp/wparrays/wtgcore_wp_tables_array.php');
if(is_admin()){
    require_once(WTG_YTS_DIR.'include/yts_admin_functions.php');
    require_once(WTG_YTS_DIR.'include/yts_admininterface_functions.php'); 
    require_once(WTG_YTS_DIR.'include/yts_formsubmit_functions.php');       
}
                               
##########################################################################################
#                             INCLUDE PAID EDITION FUNCTIONS                             #
##########################################################################################
if(!$yts_is_free){ 
    $paid_exclusions_array = array('yts_paid_formsubmit.php');
    foreach (scandir( WTG_YTS_PAID_PATH ) as $fulledition_filename) {     
        if (!in_array($fulledition_filename,$paid_exclusions_array) && $fulledition_filename != '.' && $fulledition_filename != '..' && is_file( WTG_YTS_PAID_PATH . $fulledition_filename)) { 
            if($fulledition_filename != 'license.html' && $fulledition_filename != 'index.php'){
                require_once( WTG_YTS_PAID_PATH . $fulledition_filename);
            }
        }
    } 

    // include specific files that are for admin side only (reduces number of files loaded on front end)
    if(is_admin()){require_once(WTG_YTS_DIR.'fulledition/admin/yts_paid_adminforms.php');}    
} 

// error display variables, variable that displays maximum errors is set in main file 
if($yts_demo_mode != true){yts_debugmode();}  
           
###############################################################################
#                     PUBLIC SIDE (APPLIES TO ADMIN ALSO)                     #
###############################################################################
// we require the main admin settings array for continuing the loading of the plugin                                                                       
$yts_adm_set = yts_get_option_adminsettings();# installs admin settings record if not yet installed, this will happen on plugin being activated
                   
// get all other admin variables    
$yts_was_installed = yts_was_installed();// boolean - indicates if a trace of previous installation found       
$yts_schedule_array = yts_get_option_schedule_array();// holds permitted hours and limits
         
// admin only values (these are arrays that contain data that should never be displayed on public side, load them admin side only reduces a fault causing display of the information)
if(is_admin()){
    $yts_persistent_array = yts_get_option_persistentnotifications_array();// holds interface notices/messages, some temporary, some are persistent 
    $yts_mpt_arr = yts_get_option_tabmenu('file');
}   

if(!$yts_is_free){# if you hack this, you will need to write the required functions
    add_action('init', 'yts_event_check');// part of schedule system in paid edition, run auto post and data updating events if any are due
    add_action('init','yts_cloak_forward');
}   
 
// sidebar widget 1 load
add_action('plugins_loaded','yts_basic_widget');      
add_action('plugins_loaded','yts_advanced_widget');
           
####################################################################################################
####                   ADMIN ACTIONS, SCRIPTS, CSS - GLOBAL (ENTIRE WP DASHBOARD)               ####
####################################################################################################  
if(is_admin()){ 

    $yts_guitheme = yts_get_theme();
                       
    register_activation_hook( __FILE__ ,'yts_register_activation_hook');
    
    // flag post type 
    if(!$yts_is_free){
        add_action( 'init', 'yts_register_customposttype_flags' );
        add_action( 'add_meta_boxes', 'yts_add_meta_boxes_flags' );
        add_action( 'save_post', 'yts_save_meta_boxes_flags',10,2 );
    }
    
    $yts_is_installed = yts_is_installed();// boolean - if false either plugin has never been installed or installation has been tampered with 
}   

add_action('admin_menu','yts_admin_menu');// main navigation 
  
####################################################################################################
####                           ADMIN ACTIONS, SCRIPTS, CSS - PLUGIN ONLY                        ####
####################################################################################################
if(is_admin() && isset($_GET['page']) && yts_is_plugin_page($_GET['page'])){

    // register scripts during admin initial loading
    add_action( 'admin_init', 'yts_ADDACTION_admin_init_registered_scripts' );
    
    // script and css admin side          
    yts_script_core('admin');           
    yts_script_plugin('admin');
    yts_css_core('admin');  
    yts_css_plugin('admin');

    // enqueue scripts on admin side      
    if(isset($yts_guitheme) && $yts_guitheme == 'jquery' || $yts_guitheme == false){  
        add_action( 'admin_enqueue_scripts', 'yts_print_admin_scripts' );
    }

    // process form submission (nonce is checked for all form submissions, all forms submissions are logged also)
    add_action('admin_init','yts_process');
    
    // add admin page scripts to footer
    add_action('admin_footer', 'yts_WP_adminpage_script');
    
}elseif(!is_admin()){// default to public side script and css      
    yts_script_core('public');          
    yts_script_plugin('public');
    yts_css_core('public');  
    yts_css_plugin('public');   
}
?>