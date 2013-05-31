<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = yts_WP_SETTINGS_panel_array($pageid,$panel_number,$yts_tab_number);
$panel_array['panel_name'] = 'submitadsnippet';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Submit Ad Snippet');// user seen panel header text  
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
    
    <P>Copy and paste ad snippets here then submit, they will become available for using in your widget when a post does not have a video to display.</p>
    <textarea name="yts_submitad_snippet" id="yts_submitad_snippet" cols="100" rows="10"></textarea>
    
    <?php 
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
$panel_array['panel_name'] = 'editads';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Edit Ads');// user seen panel header text  
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
    
    <p>How are you finding our plugin? It was re-developed May June 2013 and a few features are still to be added.
    You may use this form to delete ads but cannot delete them yet but that is coming.</p>
    
    <?php  
        yts_GUI_tablestart();
        
        // head
        echo '<thead>';
        echo '<tr>';
        echo '<th width="75">Delete</th>';
        echo '<th width="75">Array ID</th>'; 
        echo '<th width="200">Ad Provider</th>';
        echo '<th>Snippet</th>';
        echo '<th>Preview</th>';
        echo '<th>Actions</th>';
        echo '</tr>';
        echo '</thead>';
        
        // foot
        echo '<tfoot>';          
        echo '<tr>';
        echo '<th>Delete</th>';
        echo '<th>Array ID</th>'; 
        echo '<th>Ad Provider</th>';
        echo '<th>Snippet</th>';
        echo '<th>Preview</th>';
        echo '<th>Actions</th>';
        echo '</tr>';
        echo '</tfoot>';
    
            // body start
        echo '<tbody>';

        foreach($yts_adm_set['adsnippets'] as $arrayID => $snippet_array){
            
            echo '<tr>';
            echo '<th><input type="checkbox" name="yts_ad_delete_'.$arrayID.'"></th>';
            echo '<th>'.$arrayID.'</th>'; 
            echo '<th>'.$snippet_array['source'].'</th>';
            ### TODO:LOWPRIORITY, if we create an actual Ad ID value we should replace $arrayID in this line with that instead
            echo '<th><textarea name="yts_adsnippet_'.$arrayID.'">'.$snippet_array['snippet'].'</textarea></th>';
            echo '<th>'.$snippet_array['snippet'].'</th>';
            echo '<th></th>';# delete, view stats
            echo '</tr>';
    
        }
                  
        // body finish
        echo '</tbody></table>';
        
    echo '<p>PPC services have limits to the number of ads displayed per page. Some ads may not show a preview.</p>';
    
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
$panel_array['panel_name'] = 'adoptions';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Ads Options');// user seen panel header text  
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

    <h2>Google AdSense</h2>
    <p>Make use of your widget space when a post does not have a video by diplaying Google AdSense. Here you can configure
    what types of pages AdSense is displayed on. (Beta Note: the original
    plugin offered full range of settings but after re-developing the plugin we're releasing it with basic settings and will 
    gradually improve it)</p>

    <h4>Posts (or attachments, or custom Post Types)</h4>
    <table class="form-table">
    
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"> <label for="yts_adsenseoptions_maximum"><span class="givemesometips" title="Posts can have more than one video, we can cycle through them, pick them at random or just display many at once with a limit.">Maximum Videos</span></label></th>
            <td>
                <input type="text" name="yts_adsenseoptions_maximum" id="yts_adsenseoptions_maximum" value="1">
            </td>
        </tr>
        <!-- Option End -->     
    
        <!-- Option Start -->          
        <tr valign="top">
            <th scope="row"> <label for="yts_adsenseoptions_color"> <span class="givemesometips" title="Us">Color</span> </label> </th>
            <td>  

                <select name="yts_adsenseoptions_color" size="1">
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
                        $( "#yts_adsenseoptions_border_div" ).buttonset();
                    });
                </script>
 
                <div id="yts_adsenseoptions_border_div">
                    <input type="radio" id="yts_adsenseoptions_border_enable" name="yts_adsenseoptions_border" value="enable" checked />
                    <label for="yts_adsenseoptions_border_enable"> Enable</label>
                    <input type="radio" id="yts_adsenseoptions_border_disable" name="yts_adsenseoptions_border" value="disable"  />
                    <label for="yts_adsenseoptions_border_disable"> Disable</label>
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
                        $( "#yts_adsenseoptions_autoplay_div" ).buttonset();
                    });
                </script>
 
                <div id="yts_adsenseoptions_autoplay_div">
                    <input type="radio" id="yts_adsenseoptions_autoplay_enable" name="yts_adsenseoptions_autoplay" value="enable" checked />
                    <label for="yts_adsenseoptions_autoplay_enable"> Enable</label>
                    <input type="radio" id="yts_adsenseoptions_autoplay_disable" name="yts_adsenseoptions_autoplay" value="disable"  />
                    <label for="yts_adsenseoptions_autoplay_disable"> Disable</label>
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
                        $( "#yts_adsenseoptions_fullscreen_div" ).buttonset();
                    });
                </script>
 
                <div id="yts_adsenseoptions_fullscreen_div">
                    <input type="radio" id="yts_adsenseoptions_fullscreen_enable" name="yts_adsenseoptions_fullscreen" value="enable" checked />
                    <label for="yts_adsenseoptions_fullscreen_enable"> Enable</label>
                    <input type="radio" id="yts_adsenseoptions_fullscreen_disable" name="yts_adsenseoptions_fullscreen" value="disable"  />
                    <label for="yts_adsenseoptions_fullscreen_disable"> Disable</label>
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
                        $( "#yts_adsenseoptions_scriptaccess_div" ).buttonset();
                    });
                </script>
 
                <div id="yts_adsenseoptions_scriptaccess_div">
                    <input type="radio" id="yts_adsenseoptions_scriptaccess_enable" name="yts_adsenseoptions_scriptaccess" value="enable" checked />
                    <label for="yts_adsenseoptions_scriptaccess_enable"> Enable</label>
                    <input type="radio" id="yts_adsenseoptions_scriptaccess_disable" name="yts_adsenseoptions_scriptaccess" value="disable"  />
                    <label for="yts_adsenseoptions_scriptaccess_disable"> Disable</label>
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