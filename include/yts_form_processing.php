<?php 
###############################################################
#                                                             #
#     CALLS FORM PROCESSING FUNCTIONS IN PLUGIN PACKAGE       #
#                                                             #
###############################################################
global $yts_notice_result;
       
// Install
if($cont){
    // Create a data rule for replacing specific values after import      
    $cont = yts_form_uninstallplugin_partial(); 
    $cont = yts_form_reinstall_databasetables();
    $cont = yts_form_delete_flags();
    $cont = yts_form_drop_database_tables();    
}
     
if($cont){
    // Save easy configuration questions
    $cont = yts_form_save_easyconfigurationquestions();

    // Save global allowed days and hours
    $cont = yts_form_save_scheduletimes_global();
    
    // Save drip feed limits
    $cont = yts_form_save_schedulelimits();  
    
    // Save operation settings
    $cont = yts_form_save_settings_operation();

    // Save Data Panel One settings
    $cont = yts_form_save_settings_datapanelone();
        
    // Save interface settings
    $cont = yts_form_save_settings_interface();
    
    // folders    
    $cont = yts_form_createcontentfolder();
    $cont = yts_form_deletecontentfolder();
    
    // notices 
    $cont = yts_form_delete_persistentnotice();   
  
    // Update Page
    $cont = yts_form_plugin_update();
    
    // Save video ID for posts
    $cont = yts_form_add_videos_to_posts();
    
    // Save ad snippet
    $cont = yts_form_save_ad_snippet();
    
    // Save Video Options panel
    $cont = yts_form_save_video_options();
        
    // Edit ad panel
    $cont = yts_form_editads();
    
    // Save Ad Options panel
    $cont = yts_form_save_ad_options();
    
    // migrate from 1.2.3 to 2.0.0
    $cont = yts_form_migrate();
}
?>