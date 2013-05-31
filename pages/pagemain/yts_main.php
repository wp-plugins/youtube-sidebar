<?php 
global $yts_guitheme,$yts_adm_set,$yts_currentversion,$yts_file_profiles,$yts_mpt_arr,$wpdb,$wtgtp_pluginforum,$wtgtp_pluginblog,$yts_options_array,$yts_is_free,$yts_projectslist_array,$yts_schedule_array;
// global boolean
global $yts_beta_mode,$yts_is_installed,$yts_extension_loaded,$yts_demo_mode;
                        
$installing_software_name = WTG_YTS_NAME;
$installing_software_name_plus = '';
$installing_message = 'Thank you for choosing YouTube Sidebar, we look forward to working with you and reading your feedback.';

// load extension globals
if($yts_extension_loaded){
    $installing_software_name = WTG_YTS_RYANAIR_NAME;
    $installing_software_name_plus = ' and ' . WTG_YTS_RYANAIR_NAME;
    $installing_message .= '<br><br>You are using the <strong>' . $installing_software_name . '</strong> extension files.
    This extension will also be installed. Remove the extension files to install YouTube Sidebar on its own.';
}

// notify user if in beta mode
if($yts_beta_mode){
    $installing_message .= '<br><br>You are in <strong>Beta Mode</strong> which is a setting coded near the top of the file
    named youtube-sidebar.php, please disable it if you are using a live blog. Disable before installing as beta related settings
    and configuration will be added to your blog if you do not.';   
}

// set the installation software name, YouTube Sidebar or extension name
$installed_version = yts_WP_SETTINGS_get_version();
            
// this switch is set to false when we detect first time install or update is required
$display_main_screens = true;
                             
########################################################
#                                                      #
#     REQUEST USER TO INITIATE FIRST TIME INSTALL      #
#                                                      #
########################################################
if(!$yts_is_installed && !isset($_POST['yts_plugin_install_now'])){# we do not enter here if installation was submitted, this allows the resulting notices to be displayed under page header else they come before all admin content

    // hide the main screens until update complete
    $display_main_screens = false;
    
    yts_n_incontent($installing_message,'info','Large','Welcome To YouTube Sidebar');

    yts_jquery_button();?>

    <form class="yts_form" method="post" name="yts_plugin_install" action="">
        
        <!-- nonce -->
        <input type="hidden" name="yts_admin_referer" value="installform">
        <?php wp_nonce_field('installform');?> 
        <!-- nonce -->
        
        <input type="hidden" name="yts_post_processing_required" value="true">
        <input type="hidden" name="yts_plugin_install_now" value="z3sx4bhik970">
        <input type="hidden" name="yts_hidden_pageid" value="main">
        <input type="hidden" name="yts_hidden_panel_name" value="installationscreen">
        <input type="hidden" name="yts_hidden_panel_title" value="Welcome To YouTube Sidebar">
        <input type="hidden" name="yts_hidden_tabnumber" value="0">
        <div class="jquerybutton">
            <button id="yts_install_plugin_button">Install YouTube Sidebar <?php echo $installing_software_name_plus;?></button>
        </div>
    </form>
    
<?php  
}elseif($yts_currentversion > $installed_version){         
########################################################
#                                                      #
#  REQUEST USER TO INITIATE PLUGIN UPDATE IF REQUIRED  #
#                                                      #
######################################################## 
    
    // hide the main screens until update complete
    $display_main_screens = false;
    
    yts_n_incontent('You have updated the plugins core
    files but changes may be required to values in database or in files outside of the plugin folder. 
    All required changes will be laid out below. Please scroll down and confirm that you accept the changes
    to be made in your blog by clicking the "Update YouTube Sidebar Installation" button.',
    'warning','Large','YouTube Sidebar Plugin Update Required');

    // include the upgrade array
    require_once(WTG_YTS_DIR.'include/variables/yts_variables_update_array.php');
        
    $installed_version = yts_WP_SETTINGS_get_version();
        
    // build a message for displaying in notice box
    $notice_box_message = '';
    $total_changes_to_be_made = 0;
    foreach($yts_upgrade_array as $version => $change){
        
        if($version > $installed_version){
            $notice_box_message .= '<h2>Version '.$version.'</h2>';
            
            $notice_box_message .= '<strong>WARNING: '.$change['warning'].'</strong>';
            
            $notice_box_message .= '<ol>'; 
            foreach($change['changes'] as $id => $info){
                
                // do not show changes that apply to the paid edition only
                if($info['package'] == 'free' || !$yts_is_free && $info['package'] == 'paid'){
                    $notice_box_message .= '<li><strong>'.$info['title'].':</strong> '.$info['description'].'</li>';
                    
                    // count number of changes 
                    ++$total_changes_to_be_made;
                }    
                
            }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
            $notice_box_message .= '</ol>'; 
        }
        
    }

    if($total_changes_to_be_made == 0){
        $notice_box_message = 'No key changes are required for this update but you must still click "Update YouTube Sidebar Installation"
        and the plugin will store the latest version in your blogs database. This is how we track the versions and once
        the new version number is added to your database you will no longer see this page.';
    }

    yts_n_incontent($notice_box_message,'info','Extra','Required Changes');

    yts_jquery_button();?>

    <form class="yts_form" method="post" name="yts_plugin_update" action="">
    
        <!-- nonce -->
        <input type="hidden" name="yts_admin_referer" value="updateform">
        <?php wp_nonce_field('updateform');?> 
        <!-- nonce -->
            
        <input type="hidden" id="yts_post_processing_required" name="yts_post_processing_required" value="true">
        <input type="hidden" id="yts_plugin_update_now" name="yts_plugin_update_now" value="a43bt7695c34">
        <input type="hidden" name="yts_hidden_pageid" value="<?php echo $pageid;?>">
        <input type="hidden" name="yts_hidden_panel_name" value="pluginupdatescreen">
        <input type="hidden" name="yts_hidden_panel_title" value="Update YouTube Sidebar">
        <input type="hidden" name="yts_hidden_tabnumber" value="0">       
        <div class="jquerybutton">
            <button id="yts_update_plugin_button">Update YouTube Sidebar Installation</button>
        </div>
    </form>
    
<?php   
}

########################################################
#                                                      #
#               DISPLAY MAIN SCREENS                   #
#                                                      #
########################################################
// the plugin update process is complete above and that decides if we should show the main screens
if($display_main_screens){

    $pageid = 'main';// used to access variable.php configuration
    $pagefolder = 'pagemain';

    // main page header
    $a = 'Premium Edition';
    if($yts_is_free){$a = 'Free Edition';}elseif($yts_demo_mode){$a = 'Demo';}
    yts_header_page($yts_mpt_arr['menu'][$pageid]['title'].' '.$a,0);
                
    // create tab menu for the giving page
    yts_createmenu($pageid);
              
    // count number of panels, variable used as in code ID to pass to functions, not the TAB number users can see in url
    $panel_number = 0;

    // set tab number variable, a common use is in form hidden values
    $yts_tab_number = yts_get_tabnumber();

    if($yts_guitheme == 'wordpresscss' ){

        yts_GUI_wordpresscss_screen_include($pageid,$panel_number,$yts_tab_number);

    }elseif($yts_guitheme == 'jquery'){
        
        // loop through tabs - held in menu pages tabs array
        foreach($yts_mpt_arr['menu'][$pageid]['tabs'] as $tab => $values){
            
            // chekc if tab is to be displayed, if not, we do not add the div for it    
            if(yts_menu_should_tab_be_displayed($pageid,$tab)){
                
                // build form action value, will be appended            
                $yts_form_action = '';
     
                echo '<div id="tabs-'.$tab.'">';
                
                // check users permissions for this screen
                if(current_user_can( yts_WP_SETTINGS_get_tab_capability($pageid,$tab) )){
                    // display persistent notices for the current screen
                    yts_persistentnotice_output('screen',$tab,$pageid);
                    // create screen content                
                    include($yts_mpt_arr['menu'][$pageid]['tabs'][$tab]['path']);    
                }else{
                    yts_n_incontent('Your Wordpress user account does not have permission to access this screen.','info','Small','No Permission: ');    
                }
                
                echo '</div>';
            }
        } 
        
    }elseif($yts_guitheme == 'nonav'){# results in all accordions listed on one screen
        
        ### TODO:CRITICAL, complete no navigation view 
        
        // loop through tabs - held in menu pages tabs array
        foreach($yts_mpt_arr['menu'][$pageid]['tabs'] as $tab=>$values){
            
            // chekc if tab is to be displayed, if not, we do not add the div for it    
            if( yts_menu_should_tab_be_displayed($pageid,$tab) ){
                
                $yts_form_action = yts_link_toadmin($_GET['page'],'#tabs-' . $tab);            

                include(WTG_YTS_DIR.'pages/'.$pagefolder.'/yts_tab'.$tab.'_page'.$pageid.'.php');
            
            }
        }    
        
    }?>

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
}?>
