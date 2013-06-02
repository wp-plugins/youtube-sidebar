<?php
/**
 * Add hidden form fields, to help with processing and debugging
 * Adds the _form_processing_required value, required to call the form validation file
 *
 * @param integer $pageid (the id used in page menu array)
 * @param slug $panel_name (panel name form is in)
 * @param string $panel_title (panel title form is in)
 * @param integer $panel_number (the panel number form is in),(tab number passed instead when this function called for support button row)
 * @param integer $step (1 = confirm form, 2 = process request, 3+ alternative processing)
 */
function yts_hidden_form_values($tabnumber,$pageid,$panel_name,$panel_title,$panel_number,$step = 1){

    wp_nonce_field($panel_name); 
    
    // multiple steps - use this to state a step - argument within form validation will process accordingly
    echo '<input type="hidden" id="yts_hidden_tabnumber" name="yts_hidden_tabnumber" value="'.$tabnumber.'">';

    // multiple steps - use this to state a step - argument within form validation will process accordingly
    echo '<input type="hidden" id="yts_hidden_step" name="yts_hidden_step" value="'.$step.'">';

    // Main Page ID - mainly used to aid troubleshooting
    echo '<input type="hidden" id="yts_hidden_pageid" name="yts_hidden_pageid" value="'.$pageid.'">';

    // Panel Name (slug) - mainly used to aid troubleshooting
    echo '<input type="hidden" id="yts_hidden_panel_name" name="yts_hidden_panel_name" value="'.$panel_name.'">';

    // Panel Title - used to in output and to aid troubleshooting
    echo '<input type="hidden" id="yts_hidden_panel_title" name="yts_hidden_panel_title" value="'.$panel_title.'">';

    // Panel Number On Tab File - mainly used to aid troubleshooting
    // also used to pass tab number when being included in support button row
    echo '<input type="hidden" id="yts_hidden_panels" name="yts_hidden_panels" value="'.$panel_number.'">';
}

/**
 * Builds form middle with jquery dialog, flexible options allow a single action with or without many form objects
 * @link http://www.webtechglobal.co.uk/blog/wordpress/wtg-plugin-template/wtg-pt-jquery-dialogue-form
 * @param array $jqueryform_settings (configuration see: )
 * @param array $formobjects_array (list of form object ID for looping through and adding to dialog)
 * 
 * @todo this function requires the form
 */
function yts_jqueryform_singleaction_middle($jsform_set,$formobjects_array){
  if(isset($jsform_set['dialogbox_title']) && isset($jsform_set['noticebox_content'])){     
        extract( shortcode_atts( array(
        'has_options' => false,
        'pageid' => 0,
        'panel_number' => 0,
        'panel_name' => 'nopanelname',
        'panel_title' => 'No Panel Name',    
        'tab_number' => 'error no tab number passed to yts_jqueryform_singleaction_middle()',
        'form_id' => 'yts_form_id_default',
        'form_name' => 'yts_form_name_default',
        ), $jsform_set ) );

        // add the javascript
        yts_jquery_opendialog_confirmformaction($jsform_set,$formobjects_array);
    }
}

/**
* Builds text link, also validates it to ensure it still exists else reports it as broken
* 
* The idea of this function is to ensure links used throughout the plugins interface
* are not broken. Over time links may no longer point to a page that exists, we want to 
* know about this quickly then replace the url.
* 
* @return $link, return or echo using $response parameter
* 
* @param mixed $text
* @param mixed $url
* @param mixed $htmlentities, optional (string of url passed variables)
* @param string $target, _blank _self etc
* @param string $class, css class name (common: button)
* @param strong $response [echo][return]
* 
* @todo prepare function to accept the htmlentities string
* @todo check url type, ensure http etc in place
* @todo capture statistcs on links being clicked to establish how often they are actually used
* @todo can we do a check to ensure the html entities as a valid join to the domain? even just ensuring ? exists in url or apply it using $middle
*/
function yts_link($text,$url,$htmlentities = '',$target = '_blank',$class = '',$response = 'echo',$title = ''){
    
    // add ? to $middle if there is no proper join after the domain
    $middle = '';
                             
    // decide class
    if($class != ''){$class = 'class="'.$class.'"';}
    
    // build final url
    $finalurl = $url.$middle.htmlentities($htmlentities);
    
    // check the final result is valid else use a default fault page
    $valid_result = yts_validate_url($finalurl);
    
    if($valid_result){

        $link = '<a href="'.$finalurl.'" '.$class.' target="'.$target.'" title="'.$title.'">'.$text.'</a>';

    }else{
        ### @todo log this event
        ### @todo send variables for WTG to log and raise the issue in the admin
        $link = '<a href="http://www.webtechglobal.co.uk/blog/help/invalid-application-link" target="_blank">Invalid Link Please Click Here To Report This</a>';        
    }
    
    if($response == 'echo'){
        echo $link;
    }else{
        return $link;
    }     
} 

/**
* Builds link to google search or WTG AdSense search - Used in help content
* 
* @param mixed $text
* @param mixed $subscription
* @param mixed $string
* 
* @todo make use of adsense for none gold users
*/
function yts_google_searchlink($text,$package,$string){
                                            
    if($package == 'paid'){
        // standard google
        $url = 'http://www.google.co.uk/search?q='.$text;    
    }else{
        // adsense google
        ### @todo LOWPRIORITY, consider a method that puts the search through our own search page instead
        $url = 'http://www.google.co.uk/search?q='.$text;   
    }
    
    return yts_link($text,$url,'_blank',$string);   
}

/**
* Returns array with common values required for forms that need jQuery dialog etc.
* The default values can be overridden by populating the $jsform_set_override array. 
* 
* @param mixed $pageid
* @param mixed $yts_tab_number
* @param mixed $panel_number
* @param mixed $panel_name
* @param mixed $panel_title
* @param array $jsform_set_override, (not yet in use) use to customise the return value, not required in most uses
*/
function yts_jqueryform_commonarrayvalues($pageid,$yts_tab_number,$panel_number,$panel_name,$panel_title,$jsform_set_override = ''){
    ### TODO:MEDIUMPRIORITY  extract the override values after callign global values
    // $jsform_set_override
    // this is so we can pass the override array for custom settings rather than the default
    $jsform_set = array();
    // http://www.webtechglobal.co.uk/blog/wordpress/wtg-plugin-template/wtg-pt-jquery-dialogue-form 
    $jsform_set['pageid'] = $pageid;
    $jsform_set['tab_number'] = $yts_tab_number; 
    $jsform_set['panel_number'] = $panel_number;
    $jsform_set['panel_name'] = $panel_name;
    $jsform_set['panel_title'] = $panel_title;                
    // dialog box, javascript
    $jsform_set['dialogbox_id'] = $panel_name.$panel_number;
    $jsform_set['dialogbox_height'] = 300;// false will remove the height entry from the script
    $jsform_set['dialogbox_width'] = 800;// false will remove the width entry from the script
    $jsform_set['dialogbox_autoresize'] = false;// true or false, overrides width and height 
    // form related
    $jsform_set['form_id'] = yts_create_formid($panel_name);
    $jsform_set['form_name'] = yts_create_formname($panel_name);                                   
    return $jsform_set;
}

/**
* Adds the opening divs for panels and help button
* 
* @param array $panel_array
*/
function yts_panel_header( $panel_array, $boxintro_div = true ){
    global $yts_adm_set,$yts_guitheme;
                         
    // establish global panel state for all panels in plugin, done prior 
    $panel_state = ''; 
    if($panel_state){
        $panel_state = 'closed';    
    }    
          
    // override panel state if $panel_array includes specific state
    if(isset($panel_array['panel_state']) && ($panel_array['panel_state'] == 1 || $panel_array['panel_state'] == 'open')){
        $panel_state = 'open';    
    }elseif(isset($panel_array['panel_state']) && ($panel_array['panel_state'] == 0 || $panel_array['panel_state'] == 'closed')){
        $panel_state = 'closed';
    }?>

    <!-- two column accordion, we use this to position the support buttons to the right -->
    <style type='text/css'>
    #Top_A_Left 
    {
       width:90%;
    }

    #Top_A_Right
    {  clear:both;
       width:auto;
       float:right;
    }
    </style>

    <div id="titles" class="postbox <?php echo $panel_state;?>">
        <div class="handlediv" title="Click to toggle"><br /></div>
        <h3 class="hndle"><span><?php echo $panel_array['panel_title'];?></span></h3>
        <div class="inside">

            <?php // row of panel support buttons
            if($yts_guitheme == 'jquery'){
                if(!isset($yts_adm_set['interface']['panels']['supportbuttons']['status']) || $yts_adm_set['interface']['panels']['supportbuttons']['status'] == 'display'){?>

                <?php
                // two column accordion 
                if($boxintro_div && $yts_guitheme == 'jquery'){      
                    echo '<div id="Top_A_right">';
                }
                ?>
                       
                <?php yts_panel_support_buttons($panel_array);?>

                <?php 
                // two column accordion
                if($yts_guitheme == 'jquery'){        
                    echo '</div>';
                }?>
                    
                <?php 
                }
            }?>
            
            <?php
            // display persistent notices for the current panel
            yts_persistentnotice_output('panel',$panel_array['panel_id']);
        
            // two column accordion 
            if($yts_guitheme == 'jquery'){
                echo '<div id="Top_A_left">';
            }
}

/**
* Adds closing divs for panels 
*/
function yts_panel_footer(){
    global $yts_guitheme;
    
    // two column accordion
    if($yts_guitheme == 'jquery'){
        echo '</div>';
    }
     
    echo '</div></div>';
}

/**
* Standard form submission prompt 
*/
function yts_jquery_form_promptdiv($jsform_set){
    if(isset($jsform_set['dialogbox_title']) && isset($jsform_set['noticebox_content'])){?>
        <!-- dialog box start -->
        <div id="<?php echo $jsform_set['dialogbox_id'];?>" title="<?php echo $jsform_set['dialogbox_title'];?>">
            <?php echo yts_notice($jsform_set['noticebox_content'],'question','Small',false,'','return');?>
        </div>
        <!-- dialog box end --> <?php 
    }     
} 

/**
* Includes screen as requested through CSS menu
* 1. Calls all globals for screen file to access, saves us putting them on all screens
* 
* @param mixed $pageid
* @param mixed $panel_number
* @param mixed $yts_tab_number
*/     
function yts_GUI_wordpresscss_screen_include($pageid,$panel_number,$yts_tab_number){
    global $yts_textspin_array,$yts_jobtable_array,$yts_job_array,$yts_dataimportjobs_array,$yts_project_array,$yts_currentproject_code,$yts_is_dev,$yts_guitheme,$yts_extension_loaded,$yts_adm_set,$yts_is_installed,$yts_currentversion,$yts_file_profiles,$yts_mpt_arr,$wpdb,$wtgtp_pluginforum,$wtgtp_pluginblog,$yts_options_array,$yts_is_free,$yts_projectslist_array,$yts_schedule_array;
    $yts_form_action = '';         
    include($yts_mpt_arr['menu'][$pageid]['tabs'][$yts_tab_number]['path']);        
}

/**
* Lists all DISTINCT custom field keys (it actually queries meta-keys).
* There is not a currently any measures that hide none custom field keys.  
*/
function yts_list_customfields(){
    $result = yts_WP_SQL_get_customfield_keys_distinct();
    foreach ($result as $customfield) {
        echo $customfield->meta_key .'<br />';
    }    
}

/**
* Uses yts_WP_SQL_get_customfield_keys_distinct() to get DISTINCT meta-keys then loops and prints them.
* Can be used for custom field related features however there is yts_list_customfields() for that also. 
*/
function yts_list_metakeys(){
    $result = yts_WP_SQL_get_customfield_keys_distinct();
    foreach ($result as $customfield) {
        echo $customfield->meta_key .'<br />';
    }   
}

/**
* Used to build post type form. Echos option items, use function inside select object.
*/
function yts_display_posttypes_menu_options(){

    $post_types = get_post_types('','names');
    
    foreach ( $post_types as $post_type ) {
        
        // do not display post types that wont be used
        if( $post_type != "revision" && $post_type != "nav_menu_item" ){
            echo '<option value="'.$post_type.'">'.$post_type.'</option>';
        }
    }
}

/**
* Echos options for a form menu.
* 
* @param string $current_value, pass the current saved value or the form setting or pass null
* @todo LOWPRIORITY, change this function to display heirarchy properly 
*/
function yts_display_categories_options($current_value){

    $cats = get_categories('hide_empty=0&echo=0&show_option_none=&style=none&title_li=');

    foreach( $cats as $c ){ 
        
        // apply selected value to current save
        $selected = '';
        if( $current_value == $c->term_id ) {
            $selected = 'selected="selected"';
        }
        
        echo '<option value="'.$c->term_id.'" '.$selected.'>'. $c->term_id . ' - ' . $c->name .'</option>'; 
    }            
}

function yts_display_users_options($current_value){

    $blogusers = get_users('blog_id=1&orderby=nicename');

    foreach ($blogusers as $user){ 
        
        // apply selected value to current save
        $selected = '';
        if( $current_value == $user->ID ) {
            $selected = 'selected="selected"';
        }
        
        echo '<option value="'.$user->ID.'" '.$selected.'>'. $user->ID . ' - ' . $user->display_name .'</option>'; 
    }            
    
}

/**
* Outputs a form menu of the giving database tables columns for single selection
* 
* @param string $table_name
* @param mixed $id used to make ID attribute unique, recommend that it not be a number only if the menu is to be used many times
*/
function yts_menu_tablecolumns($table_name,$id = ''){?>  
    <select name="yts_table_columns_<?php echo $table_name;?><?php echo $id;?>" id="yts_table_columns_<?php echo $table_name;?><?php echo $id;?>_id" >
        <?php yts_options_tablecolumns($table_name);?>                                                                                                                     
    </select><?php    
}

/**
* Creates url to an admin page
*  
* @param mixed $page, registered page slug i.e. yts_install which results in wp-admin/admin.php?page=yts_install   
* @param mixed $values, pass a string beginning with & followed by url values
*/
function yts_link_toadmin($page,$values = ''){
    return get_admin_url() . 'admin.php?page=' . $page . $values;
}              

/**
 * jQuery script for styling button with roll over effect
 * @see function yts_header_page()
 * 
 * @todo rename this function to yts_JQUERY_javascript_button() and move it to applicable file which also needs to be created
 */
function yts_jquery_button(){?>
    <script>
        $(function() {
            $( "button, input:submit, a", ".jquerybutton" ).button();
            $( "a", ".jquerybutton" ).click(function() { return false; });
        });
    </script><?php
}

/**
 * Adds <button> with jquerybutton class and </form>, for using after a function that outputs a form
 * Add all parameteres or add none for defaults
 * @param string $buttontitle
 * @param string $buttonid
 */
function yts_formend_standard($buttontitle = 'Submit',$buttonid = 'notrequired'){
    global $yts_guitheme;
        
        if($buttonid == 'notrequired'){
            $buttonid = 'yts_notrequired'.rand(1000,1000000);# added during debug
        }else{
            $buttonid = $buttonid.'_formbutton';
        }?>

        <p class="submit">
            <input type="submit" name="yts_wpsubmit" id="<?php echo $buttonid;?>" class="button button-primary" value="<?php echo $buttontitle;?>">
        </p>
        
        <?php /*  change to Wordpress styling however there may be or were scripts that require <button i.e. dialog content that updates
        <div class="jquerybutton"> 
            <button id="<?php echo $buttonid;?>"><?php echo $buttontitle;?></button>
        </div>  */ 
        ?>

    </form><?php
} 

/**
 * Echos the html beginning of a form and beginning of widefat post fixed table
 * 
 * @param string $name (a unique value to identify the form)
 * @param string $method (optional, default is post, post or get)
 * @param string $action (optional, default is null for self submission - can give url)
 * @param string $enctype (pass enctype="multipart/form-data" to create a file upload form)
 */
function yts_formstart_standard($name,$id = 'none', $method = 'post',$class,$action = '',$enctype = ''){
    if($class){
        $class = 'class="'.$class.'"';
    }else{
        $class = '';         
    }
    echo '<form '.$class.' '.$enctype.' id="'.$id.'" method="'.$method.'" name="'.$name.'" action="'.$action.'">
    <input type="hidden" id="yts_post_processing_required" name="yts_post_processing_required" value="true">';
}

/**
* Script, jQuery buttonset
* Outputs a basic <script> for buttonset, used for radio and checkboxes.
*/
function yts_JQUERY_buttonset($id){?>
    <script>
    $(function(){
        $( "#<?php echo $id;?>" ).buttonset();
    });
    </script><?php    
}

/**
 * Calls wtgtp_jquery_opendialog (with close button)
 * 
 * Intended use is to display information, tutorial video etc
 *
 * @param array
 * 
 * @deprecated 16th February 2013 use yts_display_accordianpanel_buttons()
 */
function yts_panel_support_buttons($panel_array){
    yts_display_accordianpanel_buttons($panel_array);  
}

/**
* Displays the status of the content folder with buttons to delete or create the folder
* 
* @param mixed $logtype
*/
function yts_contentfolder_display_status(){
    
    $contentfolder_exists = yts_contentfolder_exist();
    
    if($contentfolder_exists){

        echo yts_notice('Content folder exists'.
        yts_formstart_standard('yts_deletecontentfolder_form','none','post','').'
            <button class="button" name="yts_contentfolder_delete">Delete</button>                        
        </form>', 'success', 'Small', false,'','return');

    }elseif(!$contentfolder_exists){
        echo yts_notice('Content folder does not exist please create it'.
        yts_formstart_standard('yts_createcontentfolder_form','none','post','').'
            <button class="button" name="yts_contentfolder_create">Create</button>        
        </form>', 'error', 'Small', false,'','return');
    }
}

/**
 * Adds Script Start and Stylesheets to the beginning of pages
 */
function yts_header_page($pagetitle,$layout){
    global $yts_mpt_arr,$yts_adm_set,$yts_pub_set,$yts_currentproject_code,$yts_is_free;

    $yts_adm_set = yts_get_option_adminsettings();  
    
    yts_jquery_button();?> 

    <!-- Checkbox Hide Show Content Script -->
    <script language="javascript">
    function toggle(divId) {
        var divArray = document.getElementsByTagName("div");
        for(i = 0; i < divArray.length; i++){
            if(divArray[i].className == divId){
                if(divArray[i].style.display != 'none'){
                    divArray[i].style.display = 'none';
                }else{
                    divArray[i].style.display = '';
                }
            }
        }
    }
    </script>

    <div class="wrap">

        <?php      
        // display persistent notices for all pages
        yts_persistentnotice_output('global');
        ?>
    
        <div id="icon-options-general" class="icon32"><br /></div>
        <h2><?php echo $pagetitle;?></h2>

        <?php 
        // run specific admin triggered automation tasks, this way an output can be created for admin to see
        //yts_admin_triggered_automation();  

        // check existing plugins and give advice or warnings
        yts_plugin_conflict_prevention();
                 
        // display form submission result notices
        yts_notice_output();
        
        // display persistent notices for current page
        yts_persistentnotice_output('page',$_GET['page']);?>
        
        <?php     
        // process global security and any other types of checks here such such check systems requirements, also checks installation status
        $yts_requirements_missing = yts_check_requirements(true);?>

        <div class="postbox-container" style="width:99%">
            <div class="metabox-holder">
                <div class="meta-box-sortables"><?php
}

/**
* Adds the accordian panel buttons
*                   
* @param mixed $panel_array
* 
* @todo LOWPRIORITY, the help_button is now the Info button, change the help_button value on all panels and in this function
*/
function yts_display_accordianpanel_buttons($panel_array){

     extract( shortcode_atts( array(
    'panel_name' => 'invalidpanelname',
    'panel_number' => 'invalidpanelnumber',
    'panel_title' => 'Title Not Found',
    'pageid' => 'invalidpageid',
    'tabnumber' => 'invalidtabnumber',
    'panel_id' => 'invalidpanelid',    
    'panel_help' => false,// default of false hides the Info button
    'panel_icon' => 'invalid-image-or-image-not-yet-created-notice.png',
    'panel_url' => 'http://www.youtubesidebar.com/support',
    'video' => false,// example: http://www.youtube.com/embed/lYL0YE8Ps8w 
    'help_button' => 'Info'// TODO:LOWPRIORITY, remove this val  
    ), $panel_array ) );
    
    // we count how many buttons are to be displayed, if zero we do not output the wrapping div
    $b = 0; 
               
    // jquery for dialog on button press
    yts_jquery_opendialog_accordianpanel_button('_info',$panel_number,$panel_title,$panel_help,$panel_icon,$panel_name,$panel_url);
    
    if($video){
        yts_jquery_opendialog_accordianpanel_button('_video',$panel_number,$panel_title,$panel_help,$panel_icon,$panel_name,$panel_url);
    }?>  
                          
    <!-- info div -->
    <?php if(isset($panel_help) && is_string($panel_help) && $panel_help != false){?> 
    <div id="yts_accordianpanelbutton_<?php echo $panel_number;?>_info" title="<?php echo $panel_title;?>">
        <p style="font-size: 16px;"><?php echo $panel_help;?></p>
    </div><?php ++$b;}?> 

    <!-- video div -->
    <?php if($video){?>
    <div id="yts_accordianpanelbutton_<?php echo $panel_number;?>_video" title="<?php echo $panel_title;?> Video">
        <iframe width="780" height="475" src="<?php echo $video; ?>?rel=0&amp;hd=1" frameborder="0" allowfullscreen></iframe>
    </div><?php ++$b;}?>
    
    <?php if($b != 0){?>
        <div class="yts_boxintro_div"> 
            <!-- help button -->
            <div float="right" class="jquerybutton">
                
                <?php if(isset($panel_help) && is_string($panel_help) && $panel_help != false){?>
                <button id="yts_opener<?php echo $panel_number;?>_info">Info</button> 
                <?php }?>
                
                <?php if($video){?>
                <button id="yts_opener<?php echo $panel_number;?>_video">Video</button> 
                <?php }?>
                
            </div>
        </div><?php
    }  
}

function yts_GUI_br(){
    global $yts_guitheme;
    if($yts_guitheme != 'jquery'){echo '<br />';}
}

function yts_GUI_nbsp(){
    global $yts_guitheme;
    if($yts_guitheme != 'jquery'){echo '&nbsp;';}
}

/**
 * Displays author and adds some required scripts
 */
function yts_footer(){?>
 
                    </div><!-- end of tabs - all content must be displayed before this div -->   
                </div><!-- end of post boxes -->
            </div><!-- end of post boxes -->
        </div><!-- end of post boxes -->
    </div><!-- end of wrap - started in header -->

    <script type="text/javascript">
        // <![CDATA[
        jQuery('.postbox div.handlediv').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
        jQuery('.postbox h3').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
        jQuery('.postbox.close-me').each(function(){
        jQuery(this).addClass("closed");
        });
        //-->
     </script><?php
}

/**
* Gets tab menu array
* 
* @todo LOWPRIORITY, rename function, it gets array from file not just option record. Possible yts_WP_SETTINGS_tabmenu()
* 
* @param mixed $storage file|option (file is used when we do not need to store the array, use for a simple plugin)
*/
function yts_get_option_tabmenu($storage = 'option'){
    global $yts_adm_set;# this is coming from the loaded array file
    // if load method not set and global is an array return the global
    if(isset($yts_adm_set['tabmenu']['loadmethod']) && $yts_adm_set['tabmenu']['loadmethod'] == 'file' || $storage == 'file'){
        
        require_once(WTG_YTS_DIR.'pages/yts_variables_tabmenu_array.php');
        return $yts_mpt_arr;
                      
    }else{

        // load from option array but only return value if its a valid array else we install the admin settings array now        
        $result = yts_option('yts_tabmenu','get');
        if(is_array($result) && isset($result['menu'])){# if the new ['menu'] is not in array we re-install
            return $result;
        }else{
            // users wants menu to load from stored option value but it returned an invald value
            return yts_INSTALL_tabmenu_settings();# returns the tabmenu array
        }
    }        
} 

/**
 * Display a notice box per option record. Where possible defaults are used. So a failure
 * in these checks does not mean a failure in the plugin, it could indicate that the user wants to
 * use the file version of an array and not store it locally.
 * 
 * @todo HIGHPRIORITY, generate this list based on options array. Make outcome more complex. Indicate if option record or not.
 */
function yts_install_optionstatus_list(){

    $admin_settings_array = get_option('yts_adminset');
    if(is_array($admin_settings_array)){
        echo yts_notice('yts_adminset is installed', 'success', 'Small', false,'','return');
    }else{
        echo yts_notice('yts_adminset not installed properly <a class="button" href="'.yts_currenturl().'&test=test">Install Now</a>', 'error', 'Small', false,'','return');
    }

    $public_settings_array = get_option('yts_publicset');
    if(is_array($public_settings_array)){
        echo yts_notice('yts_publicset is installed', 'success', 'Small', false,'','return');
    }else{
        echo yts_notice('yts_publicset not installed properly <a class="button" href="'.yts_currenturl().'&test=test">Install Now</a>', 'error', 'Small', false,'','return');
    } 
}

/**
 * Calls wtgtp_jquery_opendialog (no buttons) to apply jQuery to button and display dialog box
 * @param integer $used (number of times function used equals number of buttons and $used acts as an ID)
 * @param string $title (title of the dialog box)
 * @param string $content (content in the dialog box)
 * 
 * @todo check if this function is in use, if not remove it. It should be an depreciated function
 */
function yts_helpbutton($used,$intro,$title,$content){
    // call jquery for dialog on button press
    yts_jquery_opendialog($used);?>

    <div id="yts_dialog<?php echo $used;?>" title="<?php echo $title;?>">
        <p><?php echo $content;?></p>
    </div>

    <!--<div class="jquerybutton">-->
    <div class="jquerybutton">
        <button id="yts_opener<?php echo $used;?>">Video Tutorial</button> <?php echo $intro;?>
    </div>

    <?php
    // keep count of number of help buttons used on page
    ++$used;
    return $used;
}

/**
 * Displays RSS feed from Google Feedburner
 * @param unknown_type $feed_slug
 */
function yts_feedburner_widget($feed_slug) {
    echo '<script src="http://feeds.feedburner.com/'.$feed_slug.'?format=sigpro" type="text/javascript" ></script><noscript><p>Subscribe to RSS headline updates from: <a href="http://feeds.feedburner.com/'.$feed_slug.'"></a><br/>Powered by FeedBurner</p> </noscript>';
}

/**
 * Echos file size formatted to suit size and ensures file exists before using formatting function
 * @uses eci_csvfileexists
 * @param path $file_path
 *
 * @todo add function to check file_path exists
 */
function yts_displayfilesize($file_path){
   //$exists = eci_csvfileexists(basename($filepath), $pro);
   $exists = true;
   if($exists == true){
      echo yts_format_file_size(filesize($file_path));
   }else{
      echo 0;
   }
}

/**
* Returns standard formatted form name
* 
* @param string $panel_name
* @param string $specificpurpose, used to append a value, important when multiple forms used in a single panel
*/
function yts_create_formname($panel_name,$specificpurpose = ''){
    return 'yts_form_name_' . $panel_name . $specificpurpose;    
} 

/**
* Returns a standard formatted form ID
* 
* @param string $panel_name
* @param string $specificpurpose, used to append a value, important when multiple forms used in a single panel 
*/
function yts_create_formid($panel_name,$specificpurpose = ''){
    return 'yts_form_id_' . $panel_name . $specificpurpose;
}

/**
* Displays various notice boxes to help users get a quick idea of the current schedule and auto events setup 
*/
function yts_schedulescreen_notices(){
    global $yts_schedule_array,$yts_projectslist_array;

    // if not allowed today display
    $day = strtolower( date('l') );
    if(!isset($yts_schedule_array['days'][$day])){
        echo yts_notice('Scheduled events have not been permitted for ' . date('l'),'info','Tiny','','','return');     
    }
    
    // if not allowed this hour display
    $hour = strtolower(date('G'));
    if(!isset($yts_schedule_array['hours'][$hour])){
        echo yts_notice('Scheduled events have not been permitted for the current hour: ' . date('G'),'info','Tiny','','','return');    
    }
    
    // if no hours array set OR if no boolean true exists for any hours
    if( !isset($yts_schedule_array['hours']) ){
        echo yts_notice('Schedule is not ready as no hours have been permitted','info','Tiny','','','return');    
    }else{
        // if no hours are boolean true
        $hour_permitted = false;
        foreach( $yts_schedule_array['hours'] as $key => $hour ){
            if($hour == true){
                $hour_permitted = true;
                break;    
            }    
        }    
        
        if(!$hour_permitted){
            echo yts_notice('Schedule paused because no hours are permitted','info','Tiny','','','return');    
        }
    }
    
    // if no days array set OR if no boolean true exists for any days
    if( !isset($yts_schedule_array['days']) ){
        echo yts_notice('Schedule is not ready as no days have been permitted','info','Tiny','','','return');    
    }else{
        // if no hours are boolean true
        $days_permitted = false;
        foreach( $yts_schedule_array['days'] as $key => $day ){
            if($day == true){
                $days_permitted = true;
                break;    
            }    
        }    
        
        if(!$days_permitted){
            echo yts_notice('Schedule has been disabled because no days are permitted','info','Tiny','','','return');    
        }
    }
    
    // if no event types set display this
    if(!isset($yts_schedule_array['eventtypes'])){
        echo yts_notice('Schedule is not setup, no event types have been activated yet','info','Tiny','','','return');    
    }else{
        // have event types been disabled
        $event_type_set = false;
        foreach($yts_schedule_array['eventtypes'] as $event_type){
            if($event_type['switch'] == true){
                $event_type_set = true;
                break;    
            }    
        }
        
        if(!$event_type_set){
            echo yts_notice('Schedule has been stopped because all event types are disabled','info','Tiny','','','return');    
        }
    }

    // if current 24 hour period limit reached display this
    if(isset($yts_schedule_array['history']['daycounter']) && isset($yts_schedule_array['limits']['day']) && $yts_schedule_array['history']['daycounter'] >= $yts_schedule_array['limits']['day']){
        echo yts_notice('The maximum events number for the current 24 hour period has been reached','info','Tiny','','','return');        
    }
    
    // if current 60 minute period limit reached display this
    if(isset($yts_schedule_array['history']['hourcounter']) && isset($yts_schedule_array['limits']['hour']) && $yts_schedule_array['history']['hourcounter'] >= $yts_schedule_array['limits']['hour']){
        echo yts_notice('The maximum events number for the current 60 minute period has been reached','info','Tiny','','','return');        
    }

    // if no projects are on drip feeding display
    $project_dripfeeding = false;
    if(isset($yts_projectslist_array) && is_array($yts_projectslist_array)){
        foreach($yts_projectslist_array as $project_code => $project_array){
            if($project_code != 'arrayinfo'){
                if(isset($project_array['dripfeeding']) && $project_array['dripfeeding'] == 'on'){
                    $project_dripfeeding = true;
                    break;
                }   
            }     
        }
    }
    
    if(!$project_dripfeeding){
        echo yts_notice('You do not have any Post Creation Projects activated for drip-feeding through the plugins schedule','info','Tiny','','','return');    
    } 
} 

/**
* <table class="widefat">
* Allows control over all table
* 
*/
function yts_GUI_tablestart($class = false){
    if(!$class){$class = 'widefat';}
    echo '<table class="'.$class.'">';    
}


/**
 * Adds a jquery effect submit button, for using in form
 * 
 * @param string $panel_name (original use for in panels,panel name acts as an identifier)
 * @uses csvip_helpbutton function uses jquery script required by this button to have any jquery effect
 */
function yts_formsubmitbutton_jquery($form_name){?>
    <p class="submit">
        <input type="submit" name="<?php echo WTG_YTS_ABB;?><?php echo $form_name;?>_submit" value="Submit" />
    </p><?php
} 

/**
* List of notification boxes displaying folders created by YouTube Sidebar.
*/
function yts_list_folders(){
    global $yts_dataimportjobs_array,$yts_jobtable_array;

    $contentfolder_exists = yts_contentfolder_exist();
    
    if($contentfolder_exists){?>
        <script language="JavaScript">
        function yts_deletefolders_checkboxtoggle(source) {
          checkboxes = document.getElementsByName('yts_deletefolders_array[]');
          for(var i in checkboxes)
            checkboxes[i].checked = source.checked;
        }
        </script>
        <input type="checkbox" onClick="yts_deletefolders_checkboxtoggle(this)" /> Select All Folders<br/>
        <?php echo yts_notice('<input type="checkbox" name="yts_deletefolders_array[]" value="wpcsvimportercontent" /> 1. wpcsvimportercontent','success','Tiny','','','return');                    
    }
}

/**
* List of notification boxes displaying core plugin tables
*/
function yts_list_plugintables(){
    global $yts_tables_array;?>

    <script language="JavaScript">
    function yts_deletecoretables_checkboxtoggle(source) {
      checkboxes = document.getElementsByName('yts_deletecoretables_array[]');
      for(var i in checkboxes)
        checkboxes[i].checked = source.checked;
    }
    </script>

    <input type="checkbox" onClick="yts_deletecoretables_checkboxtoggle(this)" /> Select All Tables<br/>

    <?php 
    $count = 0;
    foreach($yts_tables_array['tables'] as $key => $table){
        if(yts_WP_SQL_does_table_exist($table['name'])){
            ++$count;
            echo yts_notice('<input type="checkbox" name="yts_deletecoretables_array[]" value="'.$table['name'].'" /> ' . $count . '. ' . $table['name'],
            'success','Tiny','','','return');               
        }
    }
    
    if($count == 0){echo '<p>There are no core tables installed right now</p>';}
}    

/**
* Tool Tip
* 2. the javascript for this is added to the footer
*/
function c2p_tt($label ='?',$title = 'Please visit www.youtubesidebar.com for help'){
    echo '<span class="yts-tips" title="'.$title.'">'.$label.'</span>';
}     

/**
* Displays a table of yts_option records with ability to view their value or delete them

* @todo LOWPRIORITY, allow output of specific types of options then make use of this on the Un-Install screen
* @param boolean $form true adds checkbox object to each option record (currently used on uninstall panel) 
*/
function yts_list_optionrecordtrace($form = false,$size = 'Small',$optiontype = 'all'){
    
    // first get all records that begin with yts_
    $youtubesidebarrecords_result = yts_WP_SQL_options_beginning_with('yts_');
    $counter = 1;?>
        
        <script language="JavaScript">
        function yts_deleteoptions_checkboxtoggle(source) {
          checkboxes = document.getElementsByName('yts_deleteoptions_array[]');
          for(var i in checkboxes)
            checkboxes[i].checked = source.checked;
        }
        </script>

        <input type="checkbox" onClick="yts_deleteoptions_checkboxtoggle(this)" /> Select All Options<br/>
    
    <?php       
    foreach($youtubesidebarrecords_result as $key => $option ){
        
        if($form){
            $form = '<input type="checkbox" name="yts_deleteoptions_array[]" value="'.$option.'" />';
        }
        
        echo yts_notice($form . ' ' . $counter . '. ' . $option,'success',$size,'','','return');
        
        ++$counter;
    }
} 

function yts_GUI_plugin_screens_menuoptions($current){
    global $yts_mpt_arr;
    foreach($yts_mpt_arr['menu'] as $page_slug => $page_array){ 
        foreach($yts_mpt_arr['menu'][$page_slug]['tabs'] as $whichvalue => $screen_array){
            $selected = '';
            if($screen_array['slug'] == $current){
                $selected = 'selected="selected"';    
            }             
            echo '<option value="'.$screen_array['slug'].'" '.$selected.'>'.$screen_array['label'].'</option>'; 
        }
    }    
}

function yts_GUI_plugin_page_menuoptions($current){
    global $yts_mpt_arr;
    foreach($yts_mpt_arr['menu'] as $page_slug => $page_array){ 
        $selected = '';
        if($page_slug == $current){
            $selected = 'selected="selected"';    
        } 
        echo '<option value="'.$page_slug.'" '.$selected.'>'.$yts_mpt_arr['menu'][$page_slug]['title'].'</option>';
    }    
}           
?>