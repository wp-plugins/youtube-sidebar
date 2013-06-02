<?php
/**
* Not to be confused with yts_install_core()
* 1. use this to install elements related to the build, not the core
* 2. this function does not belong in wtgcore_wp_install.php which is where yts_install_core() is  
*/
function yts_install_plugin(){
    
    $overall_install_result = true;
    
    #################################################
    #                                               #
    #                INSTALL ECI ARRAY              #
    #                                               #
    #################################################
    $yts_qs_array = array();
    $yts_qs_array['arrayupdated'] = time();
    $yts_qs_array['nextstep'] = 1;  
    if( !yts_option('yts_ecqsession','add',serialize($yts_qs_array)) ){
        // should never happen - yts_uninstall() used at the beginning of yts_install_core()
        yts_notice('Easy Configuration Questions are already installed, no changes were made to those settings.','warning','Tiny',false,'','echo');          
    }else{
        yts_notice('Installed the data for Easy Configuration Question settings','success','Tiny',false,'','echo');
    }    

    // create or confirm content folder for storing main uploads - false means no folder wanted, otherwise a valid path is expected
    if( defined("WTG_YTS_CONTENTFOLDER_DIR")){$overall_install_result = yts_install_contentfolder_wpcsvimportercontent(WTG_YTS_CONTENTFOLDER_DIR);}        

    return $overall_install_result;
}

/**
* Call this function to check everything that can be checked.
* Add functions to this function that create notice output only. The idea is that the user
* gets a very descriptive status of the plugin and for troubleshooting we can browse a long list
* of notifications for anything unusual.* 
* 
* @todo complete this function
*/
function yts_diagnostic_core(){
    
    # Update the options array with core options and use it to detect the installation status or use existing fuction that does that
    
    ######################################
    #                                    #
    #     CUSTOM PLUGIN DIAGNOSTICS      #
    #                                    #
    ######################################
    yts_diagnostic_custom();
}

/**
* This diagnostic is specific to the custom plugin i.e. YouTube Sidebar or Quick Start.
* 1. Call this function in yts_diagnostic_core
*/
function yts_diagnostic_custom(){
    
    # Check YouTube Sidebar option records, not core options records such as menu or installation status records
    
    # check status of all projects database table, if any missing alert, if any still do not have records alert
    
    # MAYBE query posts not updated since project change 
    
    # MAYBE query posts not updated since thier record was changed (a way to idendify updating not frequent enough)
} 

/**
 * NOT IN USE
 * @todo LOWPRIORITY, make this function perform a 100% uninstallation including CSV files, tables, option records the whole lot. This should be offered clearly as a destructive process for anyone who wants to continue using the plugin.
 */
function yts_uninstall(){
    $uninstall_outcome = true;

    // delete administration only settings
    delete_option('yts_adminset');
    
    // delete public related settings
    delete_option('yts_publicset');

    // delete tab navigation array settings
    delete_option('yts_tabmenu');

    return $uninstall_outcome;
}  
?>