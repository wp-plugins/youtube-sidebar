<?php
####################################################################################
#                                                                                  #
#         MISC FUNCTIONS AND FUNCTIONS USED FOR BOTH PUBLIC AND ADMIN SIDE         #
#                                                                                  #
####################################################################################

/**
* Loads scripts for plugin not core
* 
* @param string $side, admin, public
* @param mixed $yts_script_side_override, makes use of admin lines in front-end of blog 
*/
function yts_script_plugin($side = 'admin',$yts_script_side_override = false){
    ### if plugin package requires custom script, include a parent script file here which establishes which script to queue
}

// echos selected in form items - pass two items for condition - current value and the option value in menu
function yts_echoselected( $value,$argument){if( $value == $argument ){echo 'selected="selected"';}}

/**
* Loads CSS for plugin not core
* 
* @param string $side, admin, public
* @param mixed $yts_css_side_override, makes use of admin lines in front-end of blog
*/
function yts_css_plugin($side = 'admin',$yts_css_side_override = false){        
    ### if plugin requires custom CSS include parent CSS file here
}

/**
 * Checks existing plugins and displays notices with advice or informaton
 * This is not only for code conflicts but operational conflicts also especially automated processes
 *
 * $return $critical_conflict_result true or false (true indicatesd a critical conflict found, prevents installation, this should be very rare)
 * 
 * @todo make this function available to process manually so user can check notices again
 * @todo re-enable warnings for none activated plugins is_plugin_inactive, do so when Notice Boxes have closure button
 */
function yts_plugin_conflict_prevention(){
    global $yts_plugintitle;
    // track critical conflicts, return the result and use to prevent installation
    // only change $conflict_found to true if the conflict is critical, if it only effects partial use
    // then allow installation but warn user
    $conflict_found = false;
        
    // we create an array of profiles for plugins we want to check
    $plugin_profiles = array();

    
    /*     
                             NO CONFLICTS FOUND
    
    // Tweet My Post (javascript conflict and a critical one that breaks entire interface)
    $plugin_profiles[0]['switch'] = 1;//used to use or not use this profile, 0 is no and 1 is use
    $plugin_profiles[0]['title'] = 'Tweet My Post';
    $plugin_profiles[0]['slug'] = 'tweet-my-post/tweet-my-post.php';
    $plugin_profiles[0]['author'] = 'ksg91';
    $plugin_profiles[0]['title_active'] = 'Tweet My Post Conflict';
    $plugin_profiles[0]['message_active'] = __('On 16th August 2012 a critical and persistent conflict was found 
    between Tweet My Post 
    and '.$yts_plugintitle.'. It breaks the plugins dialog boxes (jQuery UI Dialogue) while the plugin is active,
    you may not be able to install '.$yts_plugintitle.' due to this. After some searching we found many others to be having
    JavaScript related conflicts with this plugin, which the author responded too. Please ensure you have the latest
    version installed.
    The closest cause I found in terms of code was line 40 where a .js file (jquery-latest) is registered. This
    file is not used in '.$yts_plugintitle.' so at this time we are not sure why the conflict happens. Please let us know
    if your urgently need this conflict fixed. We will investigate but due to the type of plugin, it is not urgent.
    Auto-tweeting is not recommended during auto blogging due to the risk of spamming Twitter. If you know the plugin
    well you can avoid spamming however and so let us know if this conflict is a problem for you.');
    $plugin_profiles[0]['title_inactive'] = 'title inactive';
    $plugin_profiles[0]['message_inactive'] = __('message inactive');
    $plugin_profiles[0]['type'] = 'info';//passed to the message function to apply styling and set type of notice displayed
    $plugin_profiles[0]['criticalconflict'] = true;// true indicates that the conflict will happen if plugin active i.e. not specific settings only, simply being active has an effect
                   
    // loop through the profiles now
    if(isset($plugin_profiles) && $plugin_profiles != false){
        foreach($plugin_profiles as $key=>$plugin){   
            if( is_plugin_active( $plugin['slug']) ){ 
               
                // recommend that the user does not use the plugin
                yts_notice($plugin['message_active'],'warning','Large',$plugin['title_active'],'','echo');

                // if the conflict is critical, we will prevent installation
                if($plugin['criticalconflict'] == true){
                    $conflict_found = true;// indicates critical conflict found
                }
                
            }elseif(is_plugin_inactive($plugin['slug'])){
                // warn user about potential problems if they active the plugin
                // yts_notice($plugin['message_inactive'],'info','Tiny',false);
            }
        }
    }
    
    */
    return $conflict_found;
} 

/**
* Returns specified part of array resulting from explode on string.
* Can only be used properly when the number of values in resulting array is known
* and when the returned parts type is known.
* 
* @param mixed $delimeter
* @param mixed $returnpart
* @param mixed $string
*/
function yts_explode_tablecolumn_returnnode($delimeter,$returnpart,$string){
    $explode_array = explode($delimeter,$string);
    return $explode_array[$returnpart];    
}

/**
* Returns last key from giving array. Sorts the array by key also (only works if not mixed numeric alpha).
* Use before adding new entry to array. This approach allows the key to be displayed to user for reference or returned for other use.
* 
* @uses ksort, sorts array key order should the keys be random order
* @uses end, moves internal pointer to end of array
* @uses key, returns the key for giving array element
* @returns mixed, key value could be string or numeric depending on giving array
*/
function yts_get_array_lastkey($array){
    ksort($array);
    end($array);
    return key($array);
}   

/**
* Extract YouTube video ID from URL
* 1. Breaks the URL down, could easily be adapted to extract and return array of video settings
* 
* @param mixed $url
*/
function yts_validatevideourl( $url )
{
    // create array - we will return type,id and url itself
    $videourlarray = array();
    $videourlarray['url'] = $url;
    
    // first detect url source - youtube or bliptv
    $videourlarray['type'] = 'TBC';
    
    // does the url contain youtube.com with in it
    $youtube = strpos( $videourlarray['url'],'youtube.com' );
    if( $youtube == true ) 
    {
        $videourlarray['type'] = 'youtube';
    }
    
    // if $urltype is still TBC return false
    if( $videourlarray['type'] == 'TBC' )
    {
        return false;
    }
    else
    {
        // extract video id from url
        if( $videourlarray['type'] == 'youtube' )
        {
            // we need a list of possible youtube urls from different subdomanis
            $youtube_urlarray = array("http://www.youtube.com/watch?v=", 
            "http:/youtube.com/watch?v=",
            "http://br.youtube.com/watch?v=",
            "http://uk.youtube.com/watch?v=",
            "http://fr.youtube.com/watch?v=",
            "http://ie.youtube.com/watch?v=",
            "http://it.youtube.com/watch?v=",
            "http://jp.youtube.com/watch?v=",
            "http://nl.youtube.com/watch?v=",
            "http://pl.youtube.com/watch?v=",
            "http://es.youtube.com/watch?v=");
            
            // replace values from array over the full url
            $youtubeid = str_replace($youtube_urlarray, "",$videourlarray['url']);
                                
            // detect the first variable and extract it as video id
            $variable_location = strpos($youtubeid, "&");
            if($variable_location != false && $variable_location > 0)
            {
                $youtubeid = substr($youtubeid, 0, $variable_location);
            }
            
            // remove slashes from final value
            $videourlarray['id'] = strip_tags( stripslashes( $youtubeid ) );
            
            // if there is a youtube id value then return it
            if( $youtubeid )
            {
                return $videourlarray;
            }
            else
            {
                return false;
            }            
        }
    }
}

/**
* Determine if a URL exists on the web 
* 
* @returns boolean
*/
function yts_valide_url_online($url){
    $file_headers = get_headers($url);
    if($file_headers[0] == 'HTTP/1.1 404 Not Found') {    
        return false;
    }else {             
        return true;
    }    
}
?>