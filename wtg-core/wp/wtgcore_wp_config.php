<?php
######################################################################
#                                                                    #
#              WORDPRESS CORE CONFIG FILE (loading file)             #
#                                                                    #
######################################################################  
/**
* Loads scripts for plugin not core
* 
* @param string $side, admin, public
* @param mixed $yts_script_side_override, makes use of admin lines in front-end of blog 
*/
function yts_script_core($side = 'admin',$yts_script_side_override = false){
    global $yts_mpt_arr;### TODO: LOWPRIORITY, is this variable used in this function/files included in function?
    include_once(WTG_YTS_DIR . 'wtg-core/wp/script/yts_script_parent.php');
}

/**
* Loads CSS for plugin not core
* 
* @param string $side, admin, public
* @param mixed $yts_css_side_override, makes use of admin lines in front-end of blog
*/
function yts_css_core($side = 'admin',$yts_css_side_override = false){        
    include_once(WTG_YTS_DIR . 'wtg-core/wp/css/yts_css_parent.php');
}

function yts_process(){
    // establish if form processing is permitted to continue
    $permission_granted = false;
                  
    // form submission
    if(isset($_POST['yts_post_processing_required']) && $_POST['yts_post_processing_required'] == true){  
        if(isset($_POST['yts_admin_referer'])){  
            // a few forms have the yts_admin_referer where the default hidden values are not in use
            check_admin_referer( $_POST['yts_admin_referer'] );         
        }else{                                       
            // 99% of forms will use this method
            check_admin_referer( $_POST['yts_hidden_panel_name'] );
        } 
                             
        yts_log_adminform(__FUNCTION__,1,'Form Submitted','form submission about to be processed','general','low',$_GET);       
    }
                        
    // url submission
    if(isset($_GET['youtubesidebarprocsub']) && isset($_GET['action'])){           
        check_admin_referer( $_GET['action'] );  
        yts_log_urlaction(__FUNCTION__,1,'URL Action Submitted','url action submission about to be processed','general','low',$_GET);       
    }     
            
    // arriving here means check_admin_referer() security is positive       
    global $yts_debug_mode,$cont,$yts_is_free;
                                  
    // if $yts_debug_mode set to true or 1 on CSV2POST.php we dump $_POST
    if($yts_debug_mode){
        echo '<h1>$_POST</h1>';
        yts_var_dump($_POST);           
        echo '<h1>$_GET</h1>';
        yts_var_dump($_GET);    
    }

    // set a variable used to skip further processing
    // we can use this to allow more than one part of the
    // installation to process $_POST values
    // i.e. plugin or extension can re-process core form submissions
    $cont = true;# change to false and it ends $_POST processing

    /**
    * I named plugin, core and extension processing files 
    * different to help avoid confusion between each.
    * 
    * Core: core settings, main installation procedures
    * Plugin: all custom settings
    * Extension: again more custom settings for extension only 
    */
        
    // include file that checkes $_POST values and takes required actions    
    require_once(WTG_YTS_DIR.'include/yts_form_processing.php');

    // include core processing
    require_once(WTG_YTS_WPCORE_PATH.'wtgcore_wp_formsubmit.php');       

    // include paid processing
    if(!$yts_is_free){
        require_once(WTG_YTS_PAID_PATH.'yts_paid_formsubmit.php');        
    }         
    
    # we will need to loop through all extensions, including all of their form processing files
    # this allows multiple extensions to intercept the same submission which could be very good for integration
    
    // include extension processing file, allowing us to keep post processing all together 
    if(!$yts_is_free){   
        if(WTG_YTS_EXTENSIONS != 'disable'){        
            if(yts_extension_activation_status('df1')){          
                require_once(WP_CONTENT_DIR . '/youtubesidebarextensions/df1/formprocessing.php');
            }
        }      
    }
}                     

/**
* When request will display maximum php errors including Wordpress errors 
*/
function yts_debugmode(){
    global $yts_debug_mode;
    if($yts_debug_mode){
        global $wpdb;
        ini_set('display_errors',1);
        error_reporting(E_ALL);      
        if(!defined("WP_DEBUG_DISPLAY")){define("WP_DEBUG_DISPLAY",true);}
        if(!defined("WP_DEBUG_LOG")){define("WP_DEBUG_LOG",true);}
        //add_action( 'all', create_function( '', 'var_dump( current_filter() );' ) );
        //define( 'SAVEQUERIES', true );
        //define( 'SCRIPT_DEBUG', true );
        $wpdb->show_errors();
        $wpdb->print_error();
    }
}

/**
* Gets option value for youtubesidebar _adminset or defaults to the file version of the array if option returns invalid.
* 1. Called in the main youtubesidebar.php file.
* 2. Installs the admin settings option record if it is currently missing due to the settings being required by all screens, this is to begin applying and configuring settings straighta away for a per user experience 
*/
function yts_get_option_adminsettings(){
    $result = yts_option('yts_adminset','get');
    $result = maybe_unserialize($result); 
    if(is_array($result)){
        return $result; 
    }else{     
        return yts_INSTALL_admin_settings();
    }  
} 

/**
* Determine if post exists using any giving method
*/
function yts_does_post_exist($method,$value) {
    
    if($method == 'id'){
        return yts_WP_SQL_does_post_exist_byid($value);
    }
    return false;
} 

/**
 * Standard HTTP forwarding
 * @param array $attributes_array
 * @property string status (standard http code i.e. 301 Moved Permanently)
 * @property url location (must begin with http)#
 * 
 * @todo add log recording and possibly statistical storing
 * @todo validate passed url before forwarding, provide option to not apply validation also
 * @todo ensure url validation includes forward slash at end
 * @todo validate status to expected values
 */
function yts_header_forward($atts){
    extract( shortcode_atts( array(
            'status' => '301 Moved Permanently',
            'location' => 'http://www.webtechglobal.co.uk',
    ), $atts ) );

    // clear cache then return result
    $wpdb->flush();
    
    // TODO: LOWPRIORITY, confirm this is the best way to do this in Wordpress (is there possibly a Wordpress method)
    header("HTTP/1.1 ".$status."");
    header("Status: ".$status."");
    header("Location: ".$location."");
    header("Connection: close");
    exit(0); // Optional, prevents any accidental output
}

/**
 * Starts A Timer - Used To Time Scripts
 * @return the current time in micro
 * 
 * @todo microtime function has caused problems with some users, research alternatives if any
 * @todo put error reporting in this to handle problems better
 */
function yts_microtimer_start(){
    list($utime, $time) = explode(" ", microtime());
    return ((float)$utime + (float)$time);
}

/**
* Checks if a domain exists by ensuring a site is online
* 
* @return boolean, false if domain does not exist or site is not online, true otherwise
* 
* @param string $domain
*/
function yts_domain_online($domain){
    // @todo look into these 2 lines, benefits they have when used in Wordpress if any
   //ini_set("default_socket_timeout","05");
   //set_time_limit(5);
   $f = @fopen($domain,"r");
   if($f == false){
       return false;
   }else{
       $r=fread($f,1000);
       fclose($f);
       if(strlen($r)>1) {
           return true;
       }
       else {
           return false;
       }      
   }  
}

/**
* Returns a value for Tab Number, if $_GET[WTG_##_ABB . 'tabnumber'] not set returns 0 
*/
function yts_get_tabnumber(){                      
    if(!isset($_GET['youtubesidebartabnumber'])){
        return 0;
    }else{
        return $_GET['youtubesidebartabnumber'];                   
    }                                                      
}  

/**
* Called when plugin is being activated in Wordpress.
* I am avoiding anything actually being installed during this process. * 
*/
function yts_register_activation_hook(){
    global $yts_isbeingactivated;
    $yts_isbeingactivated = true;// used to avoid loading files not required during activation (minimise errors during activation related to none activation related)
}

/**
* Update admin theme
* 
* @param mixed $theme_name
*/
function yts_update_theme($theme_name){
    update_option('yts_theme',$theme_name);  
}

/**
* Delets plugin main navigation 
*/
function yts_delete_tabmenu(){
    return delete_option('yts_tabmenu');
}

/**
 * Exit on error or use misconfiguration but offer help information, links etc
 * The information will be based on keywords related to the area of the plugin that the user is experiencing problems with
 * @param array $keywords (an array of keywords that will be used to determine extra help content)
 * @param url $url (link from a big button to the related page for the feature the exit is used in connection with)
 * 
 * @todo display notice box that will hold the help button
 * @todo design or have designed a suitable help button
 * @todo display further possible help options crawled on the plugins site
 * @todo display Google AdWords search lastly
 */
function yts_exit($url,$keywords){
    // call a function here that displays a notice box of helpful information including links and a humerous image
    // in relation to any sort of problem

    // we'll use the keywords to retrieve the information using RSS or API, not 100% sure at this time
    exit;
}

/**
* Determines if giving varaible is WP_Error or not
* Logs error if boolean true result determined
* 
* @uses class WP_Error($code, $message, $data)
* @uses is_wp_error(),$wpval->get_error_data(),$wpval->get_error_message() 
* @param mixed $v is the value being checked as possible Wordpress error
* @param boolean $returnv, default is false, true causes $v to be returned instead of boolean when value is NOT an error
* @returns boolean true if giving value is WP_Error and false if not
*/
function yts_is_WP_Error($wpval,$returnv = false){
    if(is_wp_error($wpval)){

        $atts = array();
        $atts['projectname'] = 'NA';// TODO:LOWPRIORITY, get current project name from global
        //$atts['date'] = yts_date();// yts_date()   
        $atts['logtype'] = 'error';
        $atts['dump'] = 'Data Value: ' . $wpval->get_error_data();
        $atts['comment'] = 'Created by yts_is_WP_Error, Wordpress message is: ' . $wpval->get_error_message();
        $atts['style'] = 'error';

        yts_log($atts);  
        
        $result = true;   
    }else{
        $result = false;
    }

    if($result == false && $returnv == true){
        // not an error and value to be returned
        return $wpval;
    } elseif($result == true){
        // is an error or request needs boolean returned
        return true;
    }elseif($result == false && $returnv == false){
        // not an error but request wants boolean returned, false to indicate not WP_Error
        return false;
    }
}

/**
* Uses error_log to record an error to servers main error log.
* Use when loggin to our own database table is not viable
*  
* @param string $m, the message to be recorded
*/
function yts_error_log($m){ 
   error_log($m);
}

/**
 * Checks if the cores minimum requirements are met and displays notices if not
 * Checks: Internet Connection (required for jQuery), PHP version, Soap Extension
 * 
 * @todo HIGH PRIORITY check the status of all external files mainly jquery then display warnings i.e.  http://hotlink.jquery.com/jqueryui/jquery-1.6.2.js?ver=3.2.1
 * @todo HIGH PRIORITY begin a system to deal with missing jquery if even possible so that the interface is not unusable
 */
function yts_check_requirements($display){
    // variable indicates message being displayed, we will only show 1 message at a time
    $requirement_missing = false;

    // php version
    if(defined("WTG_YTS_PHPVERSIONMINIMUM")){
        if(WTG_YTS_PHPVERSIONMINIMUM > phpversion()){
            $requirement_missing = true;
            if($display == true){
                global $yts_plugintitle;
                # TODO:LOWPRIORITY, change this to a persistent notice once system in place to track notices already displayed
                yts_notice('The plugin detected an older php version than the minimum requirement which 
                is '.WTG_YTS_PHPVERSIONMINIMUM.'. Wordpress itself also operates better with a later version 
                of php than you are using. Most features will work fine but some important ones will not.',
                'warning','Large',$yts_plugintitle . ' Requires PHP '.WTG_YTS_PHPVERSIONMINIMUM);
            }
        }
    }
    
    return $requirement_missing;
}

/**
* Returns the admin theme 
*/
function yts_get_theme(){ 
    $theme = get_option('yts_theme');
    if(!$theme || $theme == NULL){return 'jquery';}
    return $theme;
}
?>