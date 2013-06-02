<?php                                  
function yts_form_delete_persistentnotice(){
    if(isset($_POST['yts_post_deletenotice']) && $_POST['yts_post_deletenotice'] == true){
         
        global $yts_persistent_array;

        foreach($yts_persistent_array['notifications'] as $key => $notice){
            if($notice['id'] == $_POST['yts_post_deletenotice_id']){
                unset($yts_persistent_array['notifications'][$key]);
            }            
        }
        
        yts_option('yts_notifications','update',$yts_persistent_array);        
                  
        return false;
    }else{
        return true;
    }     
}          

/**
* Deletes one or more database tables
*/
function yts_form_drop_database_tables(){
    if(isset( $_POST['yts_hidden_pageid'] ) && $_POST['yts_hidden_pageid'] == 'data' && isset($_POST['yts_hidden_panel_name']) && $_POST['yts_hidden_panel_name'] == 'createddatabasetableslist'){

        if(!isset($_POST["yts_table_array"])){
            yts_notice('You did not select any database tables. Check the boxes for the tables you want to delete.','warning','Large','No Tables Deleted','','echo');
            return false;
        }else{
            
            global $wpdb,$yts_jobtable_array,$yts_dataimportjobs_array;
   
            foreach($_POST["yts_table_array"] as $key => $table_name){
                
                // if table is in use by a data import job we do not delete it, the job must be deleted first
                $code = str_replace('yts_','',$table_name);   
                
                if(isset($yts_dataimportjobs_array[$code])){
                    yts_notice('Table named '.$table_name.' is still used by Data Import Job named '.$yts_dataimportjobs_array[$code]['name'].'. Please delete the job first then delete the database table.','warning','Large','Cannot Delete ' . $table_name,'','echo');
                }else{
                    
                    yts_SQL_drop_dataimportjob_table($table_name); 
                                            
                    yts_notice('','success','Small','Database Table Deleted: '.$table_name,'','echo');
                }  
            }
        }

        return false;
    }else{
        return true;
    }          
}
                                                    
/**
* Creates the csv file folder in the wp-content path
*/
function yts_form_deletecontentfolder(){
    if(isset($_POST['yts_contentfolder_delete'])){ 
        // this function does the output when set to true for 2nd parameter
        yts_delete_contentfolder(WTG_YTS_CONTENTFOLDER_DIR,true);    
        return false; 
    }else{
        return true;
    }    
} 

/**
* Creates the csv file folder in the wp-content path
*/
function yts_form_createcontentfolder(){
    if(isset($_POST['yts_contentfolder_create'])){ 
        // this function does the output when set to true for 2nd parameter
        yts_install_contentfolder_wpcsvimportercontent(WTG_YTS_CONTENTFOLDER_DIR,true);    
        return false;
    }else{
        return true;
    }    
}  

/**
* Saves easy configuration questions
*/
function yts_form_save_easyconfigurationquestions(){
    if(isset( $_POST['yts_hidden_pageid'] ) && $_POST['yts_hidden_pageid'] == 'main' && isset($_POST['yts_hidden_panel_name']) && $_POST['yts_hidden_panel_name'] == 'easyconfigurationquestions'){
        global $yts_adm_set,$yts_ecq_array;
        
        // save answers
        foreach($yts_ecq_array as $key => $q){
            // if $_POST value for this question
            if(isset($_POST['yts_'.$key])){
                $yts_adm_set['ecq'][$key] = $_POST['yts_'.$key];  
            }  
        }

        // 102 - Data Tables (all or youtubesidebar)
        if($yts_adm_set['ecq'][102] == 'yes'){$yts_adm_set['dbtablesscope'] = 'all';}else{$yts_adm_set['dbtablesscope'] = 'youtubesidebar';}
        // 103 - Schedule/Automation Trigger (admin also or public only)
        if($yts_adm_set['ecq'][103] == 'yes'){/* TODO:MEDIUMPRIORITY, was a setting but it was removed, we will apply this later */}
        // 104 - New version tweets
        if($yts_adm_set['ecq'][104] == 'yes'){/* return answer using User Experience Program when it is complete */}                                   
        // 105 - Use log system
        if($yts_adm_set['ecq'][105] == 'yes'){/* TODO:MEDIUMPRIORITY, complete when new log to database complete */}

        yts_update_option_adminsettings($yts_adm_set);
   
        yts_notice('Your answers for the Easy Configuration Questions have been saved. Please remember
        that this may hide features, display new features or change the way a feature operates.',
        'success','Large','Answers Saved','','echo');
           
        return false;
    }else{
        return true;
    }       
}  

/**
* Data panel one settings
*/
function yts_form_save_settings_datapanelone(){
    if(isset( $_POST['csv2post_hidden_pageid'] ) && $_POST['csv2post_hidden_pageid'] == 'main' && isset($_POST['csv2post_hidden_panel_name']) && $_POST['csv2post_hidden_panel_name'] == 'panelone'){
        
        global $yts_adm_set;

        $yts_adm_set['encoding']['type'] = $_POST['yts_radiogroup_encoding'];
        $yts_adm_set['admintriggers']['newcsvfiles']['status'] = $_POST['yts_radiogroup_detectnewcsvfiles'];
        $yts_adm_set['admintriggers']['newcsvfiles']['display'] = $_POST['yts_radiogroup_detectnewcsvfiles_display'];
        $yts_adm_set['postfilter']['status'] = $_POST['yts_radiogroup_postfilter'];          
        $yts_adm_set['postfilter']['tokenrespin']['status'] = $_POST['yts_radiogroup_spinnertokenrespin'];        
 
        yts_update_option_adminsettings($yts_adm_set);

        yts_n_postresult('success','Data Related Settings Saved','We
        recommend that you monitor the plugin for a short time and ensure
        your new settings are as expected.');
        
        return false;
    }else{
        return true;
    } 
}  

function yts_form_reinstall_databasetables(){
    if(isset($_POST[WTG_YTS_ABB.'hidden_pageid']) && $_POST[WTG_YTS_ABB.'hidden_pageid'] == 'main' && isset($_POST[WTG_YTS_ABB.'hidden_panel_name']) && $_POST[WTG_YTS_ABB.'hidden_panel_name'] == 'reinstalldatabasetables'){
        
        $tables = 0;
        $result = true;
        $result = yts_INSTALL_reinstall_databasetables();
        ++$tables;
        if($result){
            yts_n_postresult('success','Tables Re-Installed Successfully','A total of '.$tables.' tables were deleted then created. All data in the original tables is lost.');
        }else{   
            yts_n_postresult('error','Tables Re-Installation Failed','A total of '.$tables.' tables were meant to be deleted then installed again but a problem was detected. Please
            try again then investigate the issue. It may be a single table causing this issue. Please report it and we will be happy to help.');
        }
        
        return false;// must go inside $_POST validation, not at end of function         
    }else{
        return true;
    }      
} 

function yts_form_add_videos_to_posts(){
    if(isset($_POST['yts_hidden_pageid']) && $_POST['yts_hidden_pageid'] == 'main' && isset($_POST['yts_hidden_panel_name']) && $_POST['yts_hidden_panel_name'] == 'postsvideos'){
    
        foreach($_POST as $name => $value){
            
            if(strstr($name,'yts_videoid_')){
                
                $post_ID = str_replace('yts_videoid_','',$name);
                
                if($post_ID && is_numeric($post_ID)){
                    
                    if($value != ''){
                    
                        $exists_already = false;
                        $mykey_values = get_post_custom_values('my_key');
                        foreach ( $mykey_values as $key => $existing_value ) {
                            if($value == $existing_value){$exists_already = true;} 
                        }  
                        
                        if(!$exists_already){                      
                            add_post_meta($post_ID,'youtubesidebar',$value);# $value = video id at this point
                        }
                        
                        yts_notice_postresult('success','Posts Added Successfully','Video with ID '.$value.' was added to post with ID '.$post_ID.'');  
                    }  
                }
            }
        }    
        
        return false;// must go inside $_POST validation, not at end of function         
    }else{
        return true;
    }    
}

function yts_form_save_video_options(){
    if(isset($_POST['yts_hidden_pageid']) && $_POST['yts_hidden_pageid'] == 'main' && isset($_POST['yts_hidden_panel_name']) && $_POST['yts_hidden_panel_name'] == 'videooptions'){

        global $yts_adm_set;

        $yts_adm_set['videooptions']['maximumvideos'] = $_POST['yts_videooptions_maximum'];
        $yts_adm_set['videooptions']['color'] = $_POST['yts_videooptions_color'];
        $yts_adm_set['videooptions']['border'] = $_POST['yts_videooptions_border'];
        $yts_adm_set['videooptions']['autoplay'] = $_POST['yts_videooptions_autoplay'];
        $yts_adm_set['videooptions']['fullscreen'] = $_POST['yts_videooptions_fullscreen'];
        $yts_adm_set['videooptions']['scriptaccess'] = $_POST['yts_videooptions_scriptaccess'];
        
        yts_update_option_adminsettings($yts_adm_set);

        yts_n_postresult('success','Video Options Saved','Your video options have been saved and take effect immediately.');

        return false;// must go inside $_POST validation, not at end of function         
    }else{
        return true;
    }        
}

function yts_form_save_ad_snippet(){
    if(isset($_POST['yts_hidden_pageid']) && $_POST['yts_hidden_pageid'] == 'main' && isset($_POST['yts_hidden_panel_name']) && $_POST['yts_hidden_panel_name'] == 'submitadsnippet'){

        global $yts_adm_set;
        
        $key = yts_get_array_nextkey($yts_adm_set['adsnippets']);
        
        $yts_adm_set['adsnippets'][$key]['time'] = time();
        $yts_adm_set['adsnippets'][$key]['snippet'] = stripslashes_deep($_POST['yts_submitad_snippet']);
    
        $yts_adm_set['adsnippets'][$key]['source'] = 'other';
        if(strstr($_POST['yts_submitad_snippet'],'google_ad_client')){$yts_adm_set['adsnippets'][$key]['source'] = 'google';}
        
        yts_update_option_adminsettings($yts_adm_set);

        yts_n_postresult('success','Ad Snippet Saved','Your new Ad will be diplayed on applicable
        posts immediately. Some ads may not show for many minutes, including Google AdSense.');

        return false;// must go inside $_POST validation, not at end of function         
    }else{
        return true;
    }        
}

function yts_form_editads(){
    if(isset($_POST['yts_hidden_pageid']) && $_POST['yts_hidden_pageid'] == 'main' && isset($_POST['yts_hidden_panel_name']) && $_POST['yts_hidden_panel_name'] == 'editads'){
        global $yts_adm_set;
        
        // first perform deletions before we make further changes to the array
        // however at some point we will control ads by an AD ID not array key
        foreach($_POST as $name => $value){
            
            if(strstr($name,'yts_ad_delete_')){
                
                $arrayID = str_replace('yts_ad_delete_','',$name);    
                unset($yts_adm_set['adsnippets'][$arrayID]);
                
            }
        } 
        
        yts_update_option_adminsettings($yts_adm_set);

        yts_n_postresult('success','Ads Saved','Changes to your Ads have been saved and take effect immediately.');

        return false;// must go inside $_POST validation, not at end of function         
    }else{
        return true;
    }      
}

function yts_form_save_ad_options(){
    if(isset($_POST['yts_hidden_pageid']) && $_POST['yts_hidden_pageid'] == 'main' && isset($_POST['yts_hidden_panel_name']) && $_POST['yts_hidden_panel_name'] == 'adoptions'){

        global $yts_adm_set;

        $yts_adm_set['adoptions']['maximumads'] = $_POST['yts_adsenseoptions_maximum'];
  
        yts_update_option_adminsettings($yts_adm_set);

        yts_n_postresult('success','Ad Options Saved','Your ad options have been saved and take effect immediately.');

        return false;// must go inside $_POST validation, not at end of function         
    }else{
        return true;
    }        
}

function yts_form_migrate(){
    if(isset($_POST['yts_hidden_pageid']) && $_POST['yts_hidden_pageid'] == 'main' && isset($_POST['yts_hidden_panel_name']) && $_POST['yts_hidden_panel_name'] == 'migration'){

        global $yts_adm_set;
        
        $migration_results = yts_update_meta_key('youtubeid','youtubesidebar');
                
        yts_var_dump($migration_results);
        
        yts_n_postresult('success','YouTube ID Migration Complete','All custom field keys named "youtubeid" have
        been changed to "youtubesidebar".');

        return false;// must go inside $_POST validation, not at end of function         
    }else{
        return true;
    }     
}
?>