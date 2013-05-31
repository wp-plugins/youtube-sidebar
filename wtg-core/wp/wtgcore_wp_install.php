<?php
/**
 * Installs the main elements for all packages
 */
function yts_install_core(){
    
    // settings arrays are includes by 
    global $yts_extension_loaded,$yts_pub_set,$yts_mpt_arr,$yts_currentversion,$yts_is_free;

    $minor_fails = 0;// count minor number of failures, if 3 or more then we'll call it a failed install
    $overall_install_result = true;// used to indicate overall result

    #################################################
    #                                               #
    #         INSTALL DATABASE TABLES FIRST         #
    #                                               #
    #################################################    
    yts_INSTALL_table_log();
        
    #################################################
    #                                               #
    #       INSTALL SCHEDULE ARRAY NOTICE ARRAY     #
    #                                               #
    #################################################
    if(!$yts_is_free){
        require(WTG_YTS_DIR.'include/variables/yts_schedule_array.php');
        if(!yts_option('yts_schedule','add',serialize($yts_schedule_array)) ){
             
            // should never happen - _uninstall() used at the beginning of _install_core()
            yts_notice('Schedule settings are already installed, no changes were made to those settings.','warning','Tiny',false,'','echo');
            yts_n('Schedule Settings Already Installed','Schedule settings are already installed, no changes were made to those settings.','warning','Tiny');
            $overall_install_result = false;          
       
        }else{
            yts_notice('Installed the schedule settings','success','Tiny',false,'','echo');
            yts_n('Schedule Settings Already Installed','Schedule settings are already installed, no changes were made to those settings.','warning','Tiny');
        }
    }
    yts_n('Schedule Settings Already Installed','Schedule settings are already installed, no changes were made to those settings.','warning','Tiny');
    
    #################################################
    #                                               #
    #         INSTALL PERSISTENT NOTICE ARRAY       #
    #                                               #
    #################################################
    $yts_persistent_array = array();
    if( !yts_option('yts_notifications','add',serialize($yts_persistent_array)) ){
        // should never happen - _uninstall() used at the beginning of _install_core()
        yts_notice('Notification settings are already installed, no changes were made to those settings.','warning','Tiny',false,'','echo');
        $overall_install_result = false;          
    }else{
        yts_notice('Installed the notification settings','success','Tiny',false,'','echo');
    }    

    // theme - only change the theme value when it is not set  
    if(!yts_option('yts_theme','get')){
        yts_option('yts_theme','add','jquery');# jquery or wordpresscss
    }         
                             
    // extension switch option record
    if(!yts_option('yts_extensions','get')){
        yts_option('yts_extensions','add','disable');    
    }
      
    // installation state values
    update_option('yts_is_installed',true);
    update_option('yts_was_installed',true); 
    update_option('yts_installedversion',$yts_currentversion);# will only be updated when user prompted to upgrade rather than activation
    update_option('yts_installeddate',time());# update the installed date, this includes the installed date of new versions
    yts_option('yts_activationdate','add',time());# this date never changes, we also want to avoid user deleted it

    return $overall_install_result;
}

/**
* Creates yts_log
* @link http://www.youtubesidebar.com/hacking/log-table
*/
function yts_INSTALL_table_log(){
    $table_name = 'yts_log';

    if(yts_WP_SQL_does_table_exist($table_name)){
        yts_notice('Database table named yts_log already exists.','warning','Tiny','','','echo');    
    }else{ 
        global $wpdb;
        
        // table name 
        $create = 'CREATE TABLE `'.$table_name.'` (';

        // columns - please update http://www.youtubesidebar.com/hacking/log-table   
        $create .= '`rowid` int(11) NOT NULL AUTO_INCREMENT,
        `outcome` tinyint(1) NOT NULL DEFAULT 1,
        `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `line` int(11) DEFAULT NULL,
        `file` varchar(250) DEFAULT NULL,
        `function` varchar(250) DEFAULT NULL,
        `sqlresult` blob,
        `sqlquery` varchar(45) DEFAULT NULL,
        `sqlerror` mediumtext,
        `wordpresserror` mediumtext,
        `screenshoturl` varchar(500) DEFAULT NULL,
        `userscomment` mediumtext,
        `page` varchar(45) DEFAULT NULL,
        `version` varchar(45) DEFAULT NULL,
        `panelid` varchar(45) DEFAULT NULL,
        `panelname` varchar(45) DEFAULT NULL,
        `tabscreenid` varchar(45) DEFAULT NULL,
        `tabscreenname` varchar(45) DEFAULT NULL,
        `dump` longblob,
        `ipaddress` varchar(45) DEFAULT NULL,
        `userid` int(11) DEFAULT NULL,
        `comment` mediumtext,
        `type` varchar(45) DEFAULT NULL,
        `category` varchar(45) DEFAULT NULL,
        `action` varchar(45) DEFAULT NULL,
        `priority` varchar(45) DEFAULT NULL,        
        PRIMARY KEY (`rowid`),
        UNIQUE KEY `rowid` (`rowid`)';

        // table config  
        $create .= ') ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8';
        
        $result = $wpdb->query( $create ); 
         
        if( $result ){
            yts_notice('Database table named '.$table_name.' has been created.','success','Tiny','','','echo');
            return true;
        }else{
            yts_notice('Database table named '.$table_name.' could not be created. This must be investigated before using the plugin','error','Tiny','','','echo');
            return false;
        }
    }  
}

/**
* Quick way to delete then install all core database tables                             
*/
function yts_INSTALL_reinstall_databasetables(){
    global $yts_tables_array,$wpdb;
    $result_array = yts_ARRAY_init('result array for database table re-installation',__LINE__,__FUNCTION__,__FILE__,'result array',true);
    $result_array['droppedtables'] = array();
    
    if(is_array($yts_tables_array)){
        
        // delete all tables
        foreach($yts_tables_array['tables'] as $key => $table){
           
            if(yts_WP_SQL_does_table_exist($table['name'])){         
                $wpdb->query( 'DROP TABLE '. $table['name'] );
                ### TODO:LOWPRIORITY, we can check DROP outcome and change outcome to false with details
                $result_array['droppedtables'][] = $table['name'];
            }                                                             
        }
        
        // now install tables
        yts_INSTALL_table_log();
  
    }else{
        $result_array['outcome'] = false;
        $result_array['failreason'] = 'tables array is not an array';
    }   
    
    return $result_array;
}

/**
* DO NOT CALL DURING FULL PLUGIN INSTALL
* This function uses update. Do not call it during full install because user may be re-installing but
* wishing to keep some existing option records.
* 
* Use this function when installing admin settings during use of the plugin. 
*/
function yts_INSTALL_admin_settings(){
    require_once(WTG_YTS_DIR.'include/variables/yts_variables_adminset_array.php');
    return yts_option('yts_adminset','update',$yts_adm_set);# update creates record if it does not exist   
}

/**
* DO NOT CALL DURING FULL PLUGIN INSTALL
* This function uses update. Users may want their installation to retain old values, we cannot assume the
* installation is 100% fresh.
* 
* Use this function when the tab menu option array is missing or invalid or when user actions a re-install of everything 
*/
function yts_INSTALL_tabmenu_settings(){
    require_once(WTG_YTS_DIR.'pages/yts_variables_tabmenu_array.php');    
    $result = yts_option('yts_tabmenu','update',$yts_mpt_arr);   
} 

/**
* Installs the Quick Start by using update.
* This function should not be used during plugin installation because it
* would destroy values that the user may be trying to retain for a new
* installation. 
*/
function yts_INSTALL_ecisession(){
    $yts_qs_array = array();
    $yts_qs_array['arrayupdated'] = time();
    $yts_qs_array['nextstep'] = 1;  
    yts_option('yts_ecisession','update',serialize($yts_qs_array));
}

/**
* Checks if plugin IS FULLY INSTALLED (all required options arrays,folders,path files etc)
* Another function and variable establishes if the plugin WAS installed in the past by finding a trace
* 
* @see yts_variables_admin.php
* @todo MEDIUMPRIORITY, return a result array so we can make use of negative installation state reason
*/
function yts_is_installed(){
    
    global $yts_options_array;
       
    if(!isset($yts_options_array) || !is_array($yts_options_array)){
        ### TODO:HIGHPRIORITY, log this event
        return false;
    }
             
    // currently this value is returned, if changed to false
    $returnresult = true;
    $failcause = 'Not Known';// only used for debugging to determine what causes indication of not fully installed
    
    // function only returns boolean but if required we will add results array to the log
    $is_installed_result = array();
    $is_installed_result['finalresult'] = false;
    $is_installed_result['options'] = null;
                
    foreach($yts_options_array as $id => $optionrecord){
            
        if($optionrecord['required'] == true){
                    
            $currentresult = get_option($id);    
            
            $is_installed_result['options'][$id]['result'] = $currentresult;
                        
            // change return switch to false if option not found
            if($currentresult == false || $currentresult == null){ 
              
                $returnresult = false;
                $failcause = 'Option RecordMissing:'.$id;    
            }
        } 
    }
     
    return $returnresult;
}   

/**
* NOT YET IN USE - WILL CHECK IF PLUGIN HAS BEEN ACTIVATED WITH SECURITY VIA SERVER
* Determines if the plugin is activated and validates credentials to ensure ongoing use.
* Once done, less SOAP calls will be required and the aim is to reduce traffic.
*/
function yts_is_activated(){ 
   global $yts_activationcode;
   return false;
}

/**
 * Removes the plugins main wp-content folder, used in yts_install_core() for failed install
 * @todo function to be complete
 */
function yts_remove_contentfolder(){

}

/**
 * Checks if plugin has been installed before (not security and not indication of full existing installation)
 */
function yts_was_installed(){
    global $yts_options_array;
    
    $result = false;
    
    if(isset($yts_options_array) && is_array($yts_options_array)){
        // check possible option records
        foreach($yts_options_array as $id => $optionrecord){
     
            // avoid checking tab menu as that is added to blow on Wordpress plugin activation, we do not want to use it as an indication of install
            if($id != WTG_YTS_ABB.'tabmenu' 
            && $id != WTG_YTS_ABB.'installedversion' 
            && $id != WTG_YTS_ABB.'installeddate' 
            && $id != WTG_YTS_ABB.'activationdate'){
                                        
                $currentresult = get_option($id);    

                // change return switch to false if option not found
                if(isset($currentresult) && $currentresult != null){

                    // we return on first detection of previous installation to avoid going through entire loop
                    return true;    
                }
            }
        } 
        
        return $result; 
    }
     
    return $result;
}  

/**
* Deletes the plugins main content folder
* 
* @param mixed $pathdir (the path to be deleted)
* @param mixed $output (boolean true means that the file was found and deleted)
*/
function yts_delete_contentfolder($pathdir,$output = false){
    if(!is_dir($pathdir)){
        global $yts_plugintitle;
        yts_notice($yts_plugintitle . ' could not find the main content folder, it
        may have already been deleted or moved.', 'warning', 'Tiny','Content Folder Not Found');
        return false;
    }else{
    
        if (yts_dir_is_empty($pathdir)) {
            rmdir($pathdir);
            yts_notice('Content folder has been deleted after confirming it did not contain any files.', 'success', 'Tiny','Content Folder Removed');                
            return true; 
        }else{
            yts_notice('Content folder cannot be deleted as it contains files.', 'warning', 'Tiny','Content Folder Not Removed');                      
        }
    }
}

/**
 * Install main content folder in wp-content directory for holding uploaded items
 * Called from install function in install.php if constant is not equal to false WTG_YTS_CONTENTFOLDER_DIR
 *
 * @return boolean true if folder installed or already exists false if failed
 */
function yts_install_contentfolder_wpcsvimportercontent($pathdir,$output = false){
    $contentfolder_outcome = true;

    // does folder already exist
    if(!is_dir($pathdir)){
        $contentfolder_outcome = yts_createfolder($pathdir);
    }else{
        return true;
    }

    if(!$contentfolder_outcome){
        $contentfolder_outcome = false;
        if($output){
            yts_notice('Plugins content folder could be not created:'.$pathdir, 'error', 'Tiny');
        }
    }elseif($contentfolder_outcome){
         if($output){
            yts_notice('Plugin content folder has been created here: '.$pathdir, 'success', 'Tiny');
         }
    }

    return $contentfolder_outcome;
}
?>
