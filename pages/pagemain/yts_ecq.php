<?php global $yts_options_array;?> 
                                 
<?php
if(!$yts_is_free){
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = yts_WP_SETTINGS_panel_array($pageid,$panel_number,$yts_tab_number);
    $panel_array['panel_name'] = 'easyconfigurationquestions';// slug to act as a name and part of the panel ID 
    $panel_array['panel_title'] = __('Easy Configuration Questions');// user seen panel header text 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_help'] = __('Easy Configuration Questions act like settings and your answers 
    will allow the plugins interface to adapt. The objective is to make the plugin easier to use 
    by hiding features you will never need. The main thing to remember is just that, features may be hidden. 
    You can reset your answers should you find something is missing and you need it. These questions are 
    nothing to do with individual projects, they are global and apply to the entire plugin including all projects, all
    data import jobs and all extensions.There are different questions on another screen for quick project configuration.'); 
    $panel_array['video'] = 'http://www.youtube.com/embed/z8S8ArOiVaw';    
    // Form Settings - create the array that is passed to jQuery form functions
    $jsform_set_override = array();
    $jsform_set = yts_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
    $jsform_set['dialogbox_title'] = 'Save Easy Configuration Questions';
    $jsform_set['noticebox_content'] = 'Some features may be hidden when you save your answers. Please remember that you can reset the answers. Do you wish to save your answers now?';?>
    <?php yts_panel_header( $panel_array );?>

        <?php 
        // begin form and add hidden values
        yts_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','yts_form',$yts_form_action);
        yts_hidden_form_values($yts_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        
        echo '<p>None of these questions are mandatory and you may answer any that suit your needs.</p>';
        
        yts_easy_configuration_questionlist();

        echo '<h4>Key</h4>';
        yts_n_incontent('Not yet answered','question','Tiny');
        yts_n_incontent('Yes answer giving','success','Tiny');           
        yts_n_incontent('No answer giving','error','Tiny');         
        yts_n_incontent('Unsure answer giving','warning','Tiny');
          
        // add js for dialog on form submission and the dialog <div> itself
        if(yts_WP_SETTINGS_form_submit_dialog($panel_array)){
            yts_jqueryform_singleaction_middle($jsform_set,$yts_options_array);
            yts_jquery_form_promptdiv($jsform_set);
        }
        ?>
            
        <?php yts_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

    <?php yts_panel_footer();
}?>