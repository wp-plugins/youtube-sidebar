<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = yts_WP_SETTINGS_panel_array($pageid,$panel_number,$yts_tab_number);
$panel_array['panel_name'] = 'postsvideos';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Posts');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = yts_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
?>
<?php yts_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    yts_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','yts_form','');
    yts_hidden_form_values($yts_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);  
    
    yts_postlist_addvideotosidebar( 500 );   
    
    // add js for dialog on form submission and the dialog <div> itself
    if(yts_WP_SETTINGS_form_submit_dialog($panel_array)){
        yts_jqueryform_singleaction_middle($jsform_set,$yts_options_array);
        yts_jquery_form_promptdiv($jsform_set);
    }
    ?>
        
    <?php yts_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>
   
<?php yts_panel_footer();?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = yts_WP_SETTINGS_panel_array($pageid,$panel_number,$yts_tab_number);
$panel_array['panel_name'] = 'videooptions';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Video Options');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = yts_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
?>
<?php yts_panel_header( $panel_array );?>

    <?php                                                           
    // begin form and add hidden values
    yts_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','yts_form','');
    yts_hidden_form_values($yts_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);  
    ?>
    
    <h2>YouTube Page Type Display</h2>
    <p>Use these settings to configure which type of posts videos and ads are allowed to be displayed on. (Beta Note: the original
    plugin offered full range of settings but after re-developing the plugin we're releasing it with basic settings and will 
    gradually improve it)</p>
                         
    <h4>Posts (or attachments, or custom Post Types)</h4>
    <table class="form-table">
    
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"> <label for="yts_videooptions_maximum"><span class="givemesometips" title="Posts can have more than one video, we can cycle through them, pick them at random or just display many at once with a limit.">Maximum Videos</span></label></th>
            <td>
                <input type="text" name="yts_videooptions_maximum" id="yts_videooptions_maximum" value="1">
            </td>
        </tr>
        <!-- Option End -->     
    
        <!-- Option Start -->          
        <tr valign="top">
            <th scope="row"> <label for="yts_videooptions_color"> <span class="givemesometips" title="Us">Color</span> </label> </th>
            <td>  

                <select name="yts_videooptions_color" size="1">
                    <option value="notselected" <?php yts_echoselected( 'TODO','' ); ?>>Default</option>
                    <option value="&color1=0x3a3a3a&color2=0x999999" <?php yts_echoselected( 'TODO','&color1=0x3a3a3a&color2=0x999999' ); ?>>Dark Grey &amp; Medium Grey</option>
                    <option value="&color1=0x2b405b&color2=0x6b8ab6" <?php yts_echoselected( 'TODO','&color1=0x2b405b&color2=0x6b8ab6' ); ?>>Dark Blue &amp; Light Blue</option>
                    <option value="&color1=0x006699&color2=0x54abd6" <?php yts_echoselected( 'TODO','&color1=0x006699&color2=0x54abd6' ); ?>>Dark Torq &amp; Light Torq</option>
                    <option value="&color1=0x234900&color2=0x4e9e00" <?php yts_echoselected( 'TODO','&color1=0x234900&color2=0x4e9e00' ); ?>>Dark Green &amp; Light Green</option>
                    <option value="&color1=0xe1600f&color2=0xfebd01" <?php yts_echoselected( 'TODO','&color1=0xe1600f&color2=0xfebd01' ); ?>>Dark Orange &amp; Light Orange</option>
                    <option value="&color1=0xcc2550&color2=0xe87a9f" <?php yts_echoselected( 'TODO','&color1=0xcc2550&color2=0xe87a9f' ); ?>>Dark Pink &amp; Light Pink</option>
                    <option value="&color1=0x402061&color2=0x9461ca" <?php yts_echoselected( 'TODO','&color1=0x402061&color2=0x9461ca' ); ?>>Dark Purple &amp; Light Purple</option>
                    <option value="&color1=0x5d1719&color2=0xcd311b" <?php yts_echoselected( 'TODO','&color1=0x5d1719&color2=0xcd311b' ); ?>>Dark Red &amp; Light Red</option>
                </select> 
                               
            </td>
        </tr>
        <!-- Option End -->

        <!-- Option Start -->
        <tr valign="top">
            <th scope="row"><span class="givemesometips" title="TODO">Border</span></th>
            <td>
            
                <script>
                    $(function() {
                        $( "#yts_videooptions_border_div" ).buttonset();
                    });
                </script>
 
                <div id="yts_videooptions_border_div">
                    <input type="radio" id="yts_videooptions_border_enable" name="yts_videooptions_border" value="enable" checked />
                    <label for="yts_videooptions_border_enable"> Enable</label>
                    <input type="radio" id="yts_videooptions_border_disable" name="yts_videooptions_border" value="disable"  />
                    <label for="yts_videooptions_border_disable"> Disable</label>
                </div>    
  
            </td>
        </tr>
        <!-- Option End -->
        
        <!-- Option Start -->
        <tr valign="top">
            <th scope="row"><span class="givemesometips" title="TODO">Auto-play</span></th>
            <td>
            
                <script>
                    $(function() {
                        $( "#yts_videooptions_autoplay_div" ).buttonset();
                    });
                </script>
 
                <div id="yts_videooptions_autoplay_div">
                    <input type="radio" id="yts_videooptions_autoplay_enable" name="yts_videooptions_autoplay" value="enable" checked />
                    <label for="yts_videooptions_autoplay_enable"> Enable</label>
                    <input type="radio" id="yts_videooptions_autoplay_disable" name="yts_videooptions_autoplay" value="disable"  />
                    <label for="yts_videooptions_autoplay_disable"> Disable</label>
                </div>    
  
            </td>
        </tr>
        <!-- Option End -->
        
        <!-- Option Start -->
        <tr valign="top">
            <th scope="row"><span class="givemesometips" title="TODO">Full-screen</span></th>
            <td>
            
                <script>
                    $(function() {
                        $( "#yts_videooptions_fullscreen_div" ).buttonset();
                    });
                </script>
 
                <div id="yts_videooptions_fullscreen_div">
                    <input type="radio" id="yts_videooptions_fullscreen_enable" name="yts_videooptions_fullscreen" value="enable" checked />
                    <label for="yts_videooptions_fullscreen_enable"> Enable</label>
                    <input type="radio" id="yts_videooptions_fullscreen_disable" name="yts_videooptions_fullscreen" value="disable"  />
                    <label for="yts_videooptions_fullscreen_disable"> Disable</label>
                </div>    
  
            </td>
        </tr>
        <!-- Option End -->
     
        <!-- Option Start -->
        <tr valign="top">
            <th scope="row"><span class="givemesometips" title="TODO">Script Access</span></th>
            <td>
            
                <script>
                    $(function() {
                        $( "#yts_videooptions_scriptaccess_div" ).buttonset();
                    });
                </script>
 
                <div id="yts_videooptions_scriptaccess_div">
                    <input type="radio" id="yts_videooptions_scriptaccess_enable" name="yts_videooptions_scriptaccess" value="enable" checked />
                    <label for="yts_videooptions_scriptaccess_enable"> Enable</label>
                    <input type="radio" id="yts_videooptions_scriptaccess_disable" name="yts_videooptions_scriptaccess" value="disable"  />
                    <label for="yts_videooptions_scriptaccess_disable"> Disable</label>
                </div>    
  
            </td>
        </tr>
        <!-- Option End -->
           
    </table>
    
    <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(yts_WP_SETTINGS_form_submit_dialog($panel_array)){
        yts_jqueryform_singleaction_middle($jsform_set,$yts_options_array);
        yts_jquery_form_promptdiv($jsform_set);
    }
    ?>
        
    <?php yts_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>
   
<?php yts_panel_footer();?>