<?php
// free pages
function yts_page_toppage(){require_once( WTG_YTS_DIR.'pages/pagemain/yts_main.php' );}

/**
* Wordpress navigation menu
*/
function yts_admin_menu(){
    global $yts_currentversion,$yts_mpt_arr,$wtgtp_homeslug,$yts_pluginname,$yts_is_installed,$yts_is_free;
                    
    $n = $yts_pluginname;

    // if file version is newer than install we display the main page only but re-label it as an update screen
    // the main page itself will also change to offer plugin update details. This approach prevent the problem with 
    // visiting a page without permission between installation
    $installed_version = yts_WP_SETTINGS_get_version();                
                          
    // installation is not done on activation, we display an installation screen if not fully installed
    if(!$yts_is_installed && !isset($_POST['yts_plugin_install_now'])){   
                           
        // if URL user is attempting to visit any screen other than page=youtubesidebar then redirect to it
        if(isset($_GET['page']) && strstr($_GET['page'],'yts_')){             
            wp_redirect( get_bloginfo('url') . '/wp-admin/admin.php?page=youtubesidebar' );           
            exit;    
        }
           
        // if plugin not installed
        add_menu_page(__('Install',$n.'install'), __('YouTube Sidebar Install','home'), 'administrator', 'youtubesidebar', 'yts_page_toppage' );
                   
    }elseif(isset($yts_currentversion) 
    && isset($installed_version) 
    && $installed_version != false
    && $yts_currentversion > $installed_version 
    && !isset($_POST['yts_plugin_update_now'])){
        
        // if URL user is attempting to visit any screen other than page=youtubesidebar then redirect to it
        if(isset($_GET['page']) && strstr($_GET['page'],'yts_')){
            wp_redirect( get_bloginfo('url') . '/wp-admin/admin.php?page=youtubesidebar' );
            exit;    
        }
                
        // if $installed_version = false it indicates no installation so we should not be displaying an update screen
        // update screen will be displayed after installation submission if this is not in place
        add_menu_page(__('Update',$n.'update'), __('YouTube Sidebar Update','home'), 'administrator', 'youtubesidebar', 'yts_page_toppage' );
        
    }else{

        add_management_page(__('YouTube Sidebar',$n.'ytsmain'), __('YouTube Sidebar','home'), 'administrator', 'youtubesidebar', 'yts_page_toppage' );

        /*   
                                    this loop is only required if more pages are added to our own top level menu
            
        // main is always set in menu, even in extensions main must exist
        //add_menu_page(__($yts_mpt_arr['menu']['main']['title'],$n.$yts_mpt_arr['menu']['main']['slug']),__($yts_mpt_arr['menu']['main']['menu'],'home'), yts_WP_SETTINGS_get_page_capability('main'), $n, 'yts_page_toppage' ); 
                                            
        // loop through sub-pages
        foreach($yts_mpt_arr['menu'] as $k => $a){
                       echo __LINE__;
            // skip none page values such as ['arrayinfo']
            if($k != 'arrayinfo'){               echo __LINE__;
                // skip main page (even extensions use the same main page file but the tab screens may be customised
                if($yts_is_free && $a == 'beta' || $k == 'main'){            echo __LINE__;
                    // page is either for paid edition only or is added to the menu elsewhere    
                }else{                                            echo __LINE__;
                    // if ['active'] is set and not equal to false, if not set we assume true   
                    if(!isset($yts_mpt_arr['menu'][$k]['active']) || isset($yts_mpt_arr['menu'][$k]['active']) && $yts_mpt_arr['menu'][$k]['active'] != false){     echo __LINE__;
                        // if is free package, only show page if package value set (added 29th April 2013) and the value == free
                        if(!$yts_is_free || $yts_is_free && isset($yts_mpt_arr['menu'][$k]['package']) && $yts_mpt_arr['menu'][$k]['package'] == 'free'){     echo __LINE__;
                            $required_capability = yts_WP_SETTINGS_get_page_capability($k);            echo __LINE__;
                            add_submenu_page($n, __($yts_mpt_arr['menu'][$k]['title'],$n.$yts_mpt_arr['menu'][$k]['slug']), __($yts_mpt_arr['menu'][$k]['menu'],$n.$yts_mpt_arr['menu'][$k]['slug']), $required_capability, $yts_mpt_arr['menu'][$k]['slug'], 'yts_page_' . $k);
                        }
                    }
                }
            }             

        }// end page loop
        */
    }
}

/**
* Checks if content folder has been created or not
* 
* @return boolean false if folder does not exist, true if it does 
*/
function yts_contentfolder_exist(){
    return file_exists(WTG_YTS_CONTENTFOLDER_DIR);    
}

/**
* Adds option items to a menu for data import tables. A YouTube Sidebar 
* exclusive function because it uses yts_get_dataimportjob_name_by_table()
* 
* @uses yts_get_dataimportjob_name_by_table()
* 
* ### TODO:LOWPRIORITY, add results to an array first, then reverse the array, so that job tables are at the top of list
*/
function yts_option_items_databasetables($append_job_names = false){
    global $wpdb,$yts_is_free;
    $result = mysql_query("SHOW TABLES FROM `".$wpdb->dbname."`");
    while ($row_table = mysql_fetch_row($result)) {
        
        // if $append_job_names is true, we check if a tablename belongs to a job name then append the job name for easier recognition
        $append_string = '';
        if($append_job_names){

            // ensure yts_ exists in tablename, otherwise it is not an applicable tablename
            if(strstr( $row_table[0] , 'yts_' )){
                $append_string = '(' . yts_get_dataimportjob_name_by_table($row_table[0]) . ')';    
            }                                 

        }

        // only allow YouTube Sidebar data job tables to be displayed in menu
        if($yts_is_free && strstr( $row_table[0] , 'yts_' )){
            echo '<option value="'.$row_table[0].'">'.$row_table[0].' '.$append_string.'</option>';            
        }elseif(!$yts_is_free){
            echo '<option value="'.$row_table[0].'">'.$row_table[0].' '.$append_string.'</option>';
        }

    }
}

/**
* Displays post types as radio buttons on form with jQuery styling of a button.
*/
function yts_display_defaultposttype_radiobuttons(){ 
    global $yts_currentproject_code;
    $project_array = yts_get_project_array($yts_currentproject_code);?> 
    
    <script>
    $(function() {
        $( "#yts_defaultposttype_radios_objectid" ).buttonset();
    });
    </script>

    <div id="yts_defaultposttype_radios_objectid">
        
        <?php
        // get current projects default post type
        $defaultposttype = yts_get_project_defaultposttype($yts_currentproject_code);
        
        $post_types = get_post_types('','names');
        $defaultapplied = false;        
        $i = 0; 
        foreach( $post_types as $post_type ){
            
            // dont add "post" as it is added last so that it can be displayed as current default when required
            if($post_type != 'post'){
                $checked = '';
                if($post_type == $defaultposttype){
                    $checked = 'checked="checked"';
                    $defaultapplied = true;    
                }
                echo '<input type="radio" id="yts_radio'.$i.'_posttype_objectid" name="yts_radio_defaultpostype" value="'.$post_type.'" '.$checked.' />
                <label for="yts_radio'.$i.'_posttype_objectid"> '.$post_type.'</label>';
                
                yts_GUI_br();
                    
                ++$i;
            }
        }
        
        // add post last, if none of the previous post types are the default, then we display this as default as it would be in Wordpress
        $post_default = '';
        if(!$defaultapplied){
            $post_default = 'checked="checked"';            
        }
        echo '<input type="radio" id="yts_radio'.$i.'_posttype_objectid" name="yts_radio_defaultpostype" value="post" '.$post_default.' />
        <label for="yts_radio'.$i.'_posttype_objectid">post</label>';?>
        
    </div><?php 
}

/**
* Outputs form objects: post statuses as form radio buttons
* 
* @param mixed $i
*/
function yts_FORMOBJECT_poststatus_radios($i){ 
    foreach(get_post_statuses() as $status_name => $status_title){

        if(isset($yts_project_array['poststatus']) && $yts_project_array['poststatus'] == $status_name){
            $statuschecked = 'checked';
        }else{
            $statuschecked = '';
        }
        
        // apply default
        if($status_name == 'publish' && $statuschecked == ''){
            $statuschecked = 'checked';
        }                              
              
        echo '<input type="radio" id="yts_radio'.$status_name.'_poststatus_objectid_'.$i.'" name="yts_radio_poststatus" value="'.$status_name.'" '.$statuschecked.' />
        <label for="yts_radio'.$status_name.'_poststatus_objectid_'.$i.'"> '.$status_title.'</label>';  
        
        yts_GUI_br();                               
    }  
} 

/**
* Outputs post formats as form radio objects 
* 
* @param mixed $i
*/
function yts_FORMOBJECT_postformat_radios($i){ 
    if ( current_theme_supports( 'post-formats' ) ) {
        $post_formats = get_theme_support( 'post-formats' );

        if ( is_array( $post_formats[0] ) ) {
            
            foreach($post_formats[0] as $key => $format){

                if(isset($yts_project_array['postformat']['default']) && $yts_project_array['postformat']['default'] == $format){
                    $statuschecked = 'checked="checked"';
                }else{
                    $statuschecked = '';
                }
                                                    
                echo '<input type="radio" id="yts_radio'.$format.'_postformat_objectid_'.$i.'" name="yts_radio_postformat" value="'.$format.'" '.$statuschecked.' />
                <label for="yts_radio'.$format.'_postformat_objectid_'.$i.'"> '.$format.'</label>';
                
                yts_GUI_br();                                 
            }
            
            if($statuschecked == ''){$statuschecked = 'checked="checked"';}
            
            echo '<input type="radio" id="yts_radiostandard_postformat_objectid_'.$i.'" name="yts_radio_postformat" value="standard" '.$statuschecked.' />
            <label for="yts_radiostandard_postformat_objectid_'.$i.'"> standard (default)</label>';
            
            yts_GUI_br();               
                
        }    
      
    }else{
        echo '<input type="radio" id="yts_radiostandard_postformat_objectid_'.$i.'" name="yts_radio_postformat" value="standard" checked="checked" />
        <label for="yts_radiostandard_postformat_objectid_'.$i.'"> Your Theme Does Not Support Post Formats</label>';        
    }
}  

/**
* Outputs the option items for form menu, adding column names from giving database table
* 
* @param mixed $table_name
* @param mixed $current_value, default boolean false, pass the current value to make it selected="selected"
*/
function yts_options_tablecolumns($table_name,$current_value = false){
    
    $column_array = yts_WP_SQL_get_tablecolumns($table_name,true,true);
     
    if(!$column_array || !is_array($column_array)){
        
        echo '<option value="error">Problem Detected</option>';
            
    }else{
        
        echo '<option value="notrequired">Not Required</option>';
        
        foreach($column_array as $key => $column_name){
            
            $selected = '';
            if($current_value != false && $current_value == $column_name ){
                $selected = 'selected="selected"';     
            }

            echo '<option value="'.$table_name.'_'.$column_name.'" '.$selected.'>'.$column_name.'</option>';    
        }
    }
    
}

/**
* Menu of giving database tables columns
* 
* @param mixed $table_name
* @param mixed $current_value
*/
function yts_options_columns($table_name,$current_value = false){
    
    $column_array = yts_WP_SQL_get_tablecolumns($table_name,true,true);
     
    if(!$column_array || !is_array($column_array)){
        
        echo '<option value="error">Problem Detected</option>';
            
    }else{
        
        echo '<option value="notrequired">Not Required</option>';
        
        foreach($column_array as $key => $column_name){
            
            $selected = '';
            if($current_value != false && $current_value == $column_name ){
                $selected = 'selected="selected"';     
            }

            echo '<option value="'.$column_name.'" '.$selected.'>'.$column_name.'</option>';    
        }
    }
    
}       

/**
* Builds a list of posts with fields for adding video ID to each
* 
* @param mixed $limit
* 
* @todo lets use ajax to add a new form field when the first is used and keep doing it, that will make it easy to add multiple videos to a post
*/
function yts_postlist_addvideotosidebar( $limit ){
    
    // check if paging has been clicked
    if (isset($_GET['product_page'])){
        $page = $_GET['product_page'];
    }else{
        $page = 1;
    }
    
    // calculate paging starting record
    $start = ( $page - 1 ) * $limit;

    global $wpdb;
    $tablename = $wpdb->prefix . "posts";
    
    // get records from pagings start and the per page limit passed to function
    $post_results = $wpdb->get_results(
        "
            SELECT ID,post_title 
            FROM $tablename
            WHERE post_status = 'publish'
            AND post_type = 'post' 
            ORDER BY ID DESC 
            LIMIT $start, $limit
        "
    , OBJECT);
    
    //get total rows
    $totalrows = $wpdb->get_var("SELECT COUNT(*) FROM $tablename;");
 
    if (!$post_results){
        echo '<p>You do not have any posts, please create your posts then return to here.</p>';
    }else{    
        yts_GUI_tablestart();
        
        // head
        echo '<thead>';
        echo '<tr>';
        echo '<th width="75">Post ID</th>'; 
        echo '<th width="200">Post Title</th>';
        echo '<th>YouTube Video ID</th>';
        echo '</tr>';
        echo '</thead>';
        
        // foot
        echo '<tfoot>';
        echo '<tr>';
        echo '<th>Post ID</th>'; 
        echo '<th>Post Title</th>';
        echo '<th>YouTube Video ID</th>';
        echo '</tr>';
        echo '</tfoot>';
        
        // body start
        echo '<tbody>';

        foreach ($post_results as $post){
            
            $video_code = get_post_meta($post->ID,'youtubesidebar');
            
            if(isset($video_code[0])){$vc1 = $video_code[0];}else{$vc1 = '';}
            
            echo '<tr>';
            echo '<td>'. $post->ID .'</td>';
            echo '<td><strong>'. $post->post_title .'</strong></td>';
            echo '<td><input type="text" name="yts_videoid_'.$post->ID.'" id="yts_videoid_'.$post->ID.'" value="'.$vc1.'" size="50"></td>';
            echo '</tr>';
        }
    
        // body finish
        echo '</tbody></table>';
        
        //Number of pages setup
        $pagination = '';
        $pages = ceil($totalrows / $limit) + 1;
        for($r = 1;$r<$pages;$r++){
           $pagination .= "<a href='admin.php?page=". $_GET['page'] ."&product_page=".$r."' class=\"button rbutton\">".$r."</a>&nbsp;";
        }
        echo $pagination;
    }
}                                                                           
?>