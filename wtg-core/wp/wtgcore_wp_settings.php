<?php
/**
* Determines if dialog should be displayed or not for the giving panel when user submits form
* 
* @todo currently only works with global setting and not individual panel configuration 
*/
function yts_WP_SETTINGS_form_submit_dialog($panel_array){
    
    global $yts_guitheme,$yts_adm_set;

    if($yts_guitheme != 'jquery'){
        return false;
    }
    
    // coded ['dialoguedisplay'] over-rides users settings to hide all dialog to ensure critical actions are always giving attention
    // i.e. Re-Install Database Tables panel
    if(isset($panel_array['dialogdisplay'])){ 
        if($panel_array['dialogdisplay'] == 'yes'){ 
            return true;
        }
        
        // changing to boolean 4th March 2013    
        if($panel_array['dialogdisplay'] == true){ 
            return true;
        }          
    }
   
    if(isset($yts_adm_set['interface']['forms']['dialog']['status']) && $yts_adm_set['interface']['forms']['dialog']['status'] == 'display' || !isset($yts_adm_set['interface']['forms']['dialog']['status'])){
        return true;
    } 
    
    return false;       
}

/**
* Decides a tab screens required capability in order for dashboard visitor to view it
* 
* @param mixed $page_name the array key for pages
* @param mixed $tab_key the array key for tabs within a page
*/
function yts_WP_SETTINGS_get_tab_capability($page_name,$tab_key,$default = false){
    global $yts_mpt_arr,$yts_demo_mode;
    $codedefault = 'activate_plugins';
    if($yts_demo_mode){
        
        if(isset($yts_mpt_arr['menu'][$page_name]['tabs'][$tab_key]['permissions']['demoallowed']) && $yts_mpt_arr['menu'][$page_name]['tabs'][$tab_key]['permissions']['demoallowed'] == false){
            // the page is not permitted to be used during demo mode
        }elseif(!isset($yts_mpt_arr['menu'][$page_name]['tabs'][$tab_key]['permissions']['demoallowed']) || $yts_mpt_arr['menu'][$page_name]['tabs'][$tab_key]['permissions']['demoallowed'] == true){
            // page permits demo use in demo mode and we are in demo mode (otherwise all arguments passed and $thisdefault)
            return 'publish_pages';# publish_pages is an Editor capability
        }        
        
    }elseif(isset($yts_mpt_arr['menu'][$page_name]['tabs'][$tab_key]['permissions']['customcapability']) && !$default){
        return $yts_mpt_arr['menu'][$page_name]['tabs'][$tab_key]['permissions']['customcapability'];    
    }else{ 
        if(isset($yts_mpt_arr['menu'][$page_name]['tabs'][$tab_key]['permissions']['defaultcapability'])){
            return $yts_mpt_arr['menu'][$page_name]['tabs'][$tab_key]['permissions']['defaultcapability'];    
        }else{
            return $codedefault;    
        }                    
    }
    return $codedefault;   
}

function yts_WP_SETTINGS_get_page_capability($page_name,$default = false){
    global $yts_mpt_arr,$yts_demo_mode;
    
    $thisdefault = 'update_core';// script default for all outcomes
         
    if($yts_demo_mode){
 
        if(isset($yts_mpt_arr['menu'][$page_name]['permissions']['demoallowed']) && $yts_mpt_arr['menu'][$page_name]['permissions']['demoallowed'] == false){
            // the page is not permitted to be used during demo mode
        }elseif(!isset($yts_mpt_arr['menu'][$page_name]['permissions']['demoallowed']) || $yts_mpt_arr['menu'][$page_name]['permissions']['demoallowed'] == true){
            // page permits demo use in demo mode and we are in demo mode (otherwise all arguments passed and $thisdefault)
            return 'publish_pages';# publish_pages is an Editor capability
        }
        
    }elseif(!isset($yts_mpt_arr['menu'][$page_name]['permissions']['customcapability']) || $default == true){
          
        // there is no customcapability (setup by users settings), so we check for the defaultcapability we have already hard coded as most suitable
        if(!isset($yts_mpt_arr['menu'][$page_name]['permissions']['defaultcapability'])){
            return $thisdefault;    
        }else{
            return $yts_mpt_arr['menu'][$page_name]['permissions']['defaultcapability'];// our decided default    
        }
        
    }elseif(isset($yts_mpt_arr['menu'][$page_name]['permissions']['customcapability'])){
        return $yts_mpt_arr['menu'][$page_name]['permissions']['customcapability'];  
    }
                 
    return $thisdefault;   
}

function yts_WP_SETTINGS_get_eciarray(){
    return maybe_unserialize(yts_option('yts_ecisession','get'));
}

function yts_WP_SETTINGS_get_version(){
    return get_option('yts_installedversion');    
}
         
/**
* Initiates panel array values, some of which are also values changed by settings within this function and later in panel script
*/
function yts_WP_SETTINGS_panel_array($pageid,$panel_number,$yts_tab_number){
    $panel_array = array();                             
    $panel_array['panel_name'] = 'defaultpanelnamepleasechange';// slug to act as a name and part of the panel ID 
    $panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
    $panel_array['panel_title'] = __('Default Panel Title Please Change');// user seen panel header text 
    $panel_array['pageid'] = $pageid;// must be set on panels lines
    $panel_array['tabnumber'] = $yts_tab_number; 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_help'] = false;// default of false causes Info button to be hidden
    $panel_array['form_button'] = 'Submit';
    $panel_array['dialogdisplay'] = false; // yes or no - this value when used over-rides the global setting for hiding all dialogue
    return $panel_array;   
}

/**
* Updates locally stored copy of tab menu array
* 
* @uses serialize 
* @param mixed $yts_mpt_arr
* @return bool
*/
function yts_update_tabmenu(){
    global $yts_mpt_arr;
    return update_option('yts_tabmenu',serialize($yts_mpt_arr)); 
}

/**
* Use to start a new array.
* 1. Adds our standard ['arrayinfo'] which helps us to determine how much an array has changed since being created
* 2. Adds description also
* 
* @uses yts_ARRAY_arrayinfo_set()
* @param mixed $description use to explain what array is used for
* @param mixed $line __LINE__
* @param mixed $function __FUNCTION__
* @param mixed $file __FILE__
* @param mixed $reason use to explain why the array was updated (rather than what the array is used for)
* @return string
*/
function yts_ARRAY_init($description,$line,$function,$file,$reason,$result_array = false){
    global $yts_currentversion;
    $array = array();
    $array['arrayinfo'] = yts_ARRAY_arrayinfo_set($line,$function,$file,$reason,$yts_currentversion);
    $array['arrayinfo']['description'] = $description;
    
    if($result_array){
        // array is being used for a result_array meaning it has a short life, is not stored unless for debugging and the returned array values are used to build a report
        $array['outcome'] = true;// boolean
        $array['failreason'] = false;// string - our own typed reason for the failure
        $array['error'] = false;// string - add php mysql wordpress error 
        $array['parameters'] = array();// an array of the parameters passed to the function using result_array, really only required if there is a fault
        $array['result'] = array();// the result values, if result is too large not needed do not use
    }
    return $array;
}

/**
* Get arrays next key (only works with numeric key)
*/
function yts_get_array_nextkey($array){
    if(!is_array($array)){
        return 1;   
    }
    
    ksort($array);
    end($array);
    return key($array) + 1;
}

/**
* Gets the schedule array from wordpress option table.
* Array [times] holds permitted days and hours.
* Array [limits] holds the maximum post creation numbers 
*/
function yts_get_option_schedule_array(){
    $yts_schedule_array = get_option( 'yts_schedule');
    return maybe_unserialize($yts_schedule_array);    
}

/**
* Updates the schedule array from wordpress option table.
* Array [times] holds permitted days and hours.
* Array [limits] holds the maximum post creation numbers 
*/
function yts_update_option_schedule_array($schedule_array){
    $schedule_array_serialized = maybe_serialize($schedule_array);
    return update_option('yts_schedule',$schedule_array_serialized);    
}

/**
* Updates notifications array in Wordpress options table
* 
* @param array $notifications_array
* @return bool
*/
function yts_update_option_persistentnotifications_array($notifications_array){
    return update_option('yts_notifications',maybe_serialize($notifications_array));    
}

function yts_update_option_adminsettings($yts_adm_set){
    $admin_settings_array_serialized = maybe_serialize($yts_adm_set);
    return update_option('yts_adminset',$admin_settings_array_serialized);    
}

/**
* Returns Wordpress version in short
* 1. Default returned example by get_bloginfo('version') is 3.6-beta1-24041
* 2. We remove everything after the first hyphen
*/
function yts_get_wp_version(){
    $longversion = get_bloginfo('version');
    return strstr( $longversion , '-', true );
}
?>