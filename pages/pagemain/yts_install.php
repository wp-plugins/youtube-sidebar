<?php   
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = yts_WP_SETTINGS_panel_array($pageid,$panel_number,$yts_tab_number);
$panel_array['panel_name'] = 'partialuninstall';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Partial Un-Install');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_array['panel_number'];// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = 'This tool allows you to delete existing records, files and database tables so that there is no longer a trace of the installation. Settings are stored in the Wordpress options table and will be removed from there. You can leave some elements of the installation in your blog for using in future or possibly to support another plugin. Just ignore this ability if your not sure what it means or you want the most simple way to remove the plugin. Just remember if you do this and then attempt to install the blog in future you may get error type messages simply letting you know something was not installed but really indicating that it already exists.';
?>

<?php yts_panel_header( $panel_array );?>

        <?php
        // Form Settings - create the array that is passed to jQuery form functions
        $jsform_set_override = array();
        $jsform_set = yts_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);                    
        // make require alterations to form settings
        $jsform_set['has_options'] = true;// true or false (controls output of selected settings
        $jsform_set['dialogbox_title'] = 'Un-Installing YouTube Sidebar';
        // wtg notice box display
        $jsform_set['noticebox_content'] = 'Do you want to un-install the selected items?';
        ?>
        
        <?php // begin form and add hidden values
        yts_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','yts_form',$yts_form_action);
        yts_hidden_form_values($yts_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?> 
        
        <h4><?php c2p_tt('Core Plugin Tables','Delete the tables that the plugin adds to your database on installation. The plugin requires these tables to work 100% so do not delete without considering what feature it may disable');?></h4>
        <?php yts_list_plugintables();?>
               
        <h4><?php c2p_tt('Folders','Delete folders created by the plugin and are required for the plugin to work properly');?></h4>
        <?php yts_list_folders();?>
                                                
        <h4><?php c2p_tt('Option Records','Delete all option records created by the plugin. This includes core option records and any created by projects');?></h4>
        <?php yts_list_optionrecordtrace(true,'Tiny'); ?>                    
                                      
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
$panel_array['panel_name'] = 'reinstalldatabasetables';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Re-Install Database Tables');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['dialogdisplay'] = true;
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = yts_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialogbox_title'] = 'About To Delete Database Tables';
$jsform_set['noticebox_content'] = 'This action will delete all currently installed tables then install all tables. Any data in your existing tables will be lost. Do you wish to continue?';
?>

<?php yts_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    yts_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','yts_form','');
    yts_hidden_form_values($yts_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);

    global $yts_tables_array;
    if(is_array($yts_tables_array)){
        
        echo '<h2>Tables Already Installed</h2>';  
                
        yts_GUI_tablestart();
        
        echo '
        <thead>
            <tr>
                <th>Table Names</th>
                <th>Rows</th>
            </tr>
        </thead>';

        echo '
        <tfoot>
            <tr>
                <th>Table Names</th>
                <th>Rows</th>
            </tr>
        </tfoot>';
        
        echo '<tbody>';
               
        foreach($yts_tables_array['tables'] as $key => $table){
            if(yts_WP_SQL_does_table_exist($table['name'])){         
                echo '<tr><td>'.$table['name'].'</td><td>'.yts_WP_SQL_counttablerecords($table['name']).'</td></tr>';
            }                                                             
        }
                               
        echo '</tbody></table>';
        
        echo '<br /><br />';
        
        echo '<h2>Tables Not Installed</h2>';

        yts_GUI_tablestart();
        
        echo '
        <thead>
            <tr>
                <th>Table Names</th>
                <th>Required</th>
            </tr>
        </thead>';
  
        echo '
        <tfoot>
            <tr>
                <th>Table Names</th>
                <th>Required</th>
            </tr>
        </tfoot>';
          
        foreach($yts_tables_array['tables'] as $key => $table){
            if(!yts_WP_SQL_does_table_exist($table['name'])){         
                echo '<tr><td>'.$table['name'].'</td><td>'.$table['required'].'</td></tr>';
            }                                                             
        }
                               
        echo '</tbody></table>';               
    }
    
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
$panel_array['panel_name'] = 'optionrecordtrace';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Option Record Trace');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = 'This feature does a search for records that begin with "yts_". We can use it to fully cleanup the Wordpress option table.'; 
### TODO:MEDIUMPRIORITY, merge the critical options record panel with this sort of, display option record 
### notifications in a table, also add columns for displaying smaller notifications indicating important and status
?>
<?php yts_panel_header( $panel_array );?>
    <?php yts_list_optionrecordtrace(); ?>       
<?php yts_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = yts_WP_SETTINGS_panel_array($pageid,$panel_number,$yts_tab_number);
$panel_array['panel_name'] = 'contentfolderstatus';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Content Folder Status');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = 'It is important that CSV files are not stored within the plugins own folder, currently 
named '.WTG_YTS_FOLDERNAME.' in order to prevent deletion of files. The plugin allows you to store CSV files in 
custom file paths but the default path and folder is created when installing YouTube Sidebar. The 
folder should be named '.WTG_YTS_CONTENTFOLDER_DIR.' and you will find it in the wp-content folder. If it is 
missing for any reason, you may create it manually.'; ?>
<?php yts_panel_header( $panel_array );?>
    <?php yts_contentfolder_display_status(); ?>       
<?php yts_panel_footer();?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = yts_WP_SETTINGS_panel_array($pageid,$panel_number,$yts_tab_number);
$panel_array['panel_name'] = 'pluginconfigvalues';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Plugin Config Values');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('This show the status of what are actually called php directives. These are a type of setting that can be configured in the php.ini file used by your server. Your hosting will configure this to suit the service they are providing and the values may effect this plugin.'); ?>
<?php yts_panel_header( $panel_array );?>

    <?php 
    global $yts_php_version_tested,$yts_php_version_minimum,$yts_is_free_override,$yts_demo_mode,$yts_is_free;
    ?>

    <h2>Package Values</h2>
    <ul>
        <li><strong>Plugin Version:</strong> <?php echo $yts_currentversion;?></li>
        <li><strong>Tested PHP:</strong> <?php echo $yts_php_version_tested;?></li>
        <li><strong>Minimum PHP:</strong> <?php echo $yts_php_version_minimum;?></li>
        <li><strong>Free Override:</strong> <?php echo $yts_is_free_override;?></li>
        <li><strong>Demo Mode:</strong> <?php echo $yts_demo_mode;?></li>
        <li><strong>Is Free Edition:</strong> <?php echo $yts_is_free;?></li>        
        <li><strong>WTG_YTS_ABB:</strong> <?php echo WTG_YTS_ABB;?></li>        
        <li><strong>WTG_YTS_NAME:</strong> <?php echo WTG_YTS_NAME;?></li>
        <li><strong>WTG_YTS_ID:</strong> <?php echo WTG_YTS_ID;?></li>
        <li><strong>WTG_YTS_PHPVERSIONTESTED:</strong> <?php echo WTG_YTS_PHPVERSIONTESTED;?></li>
        <li><strong>WTG_YTS_PHPVERSIONMINIMUM:</strong> <?php echo WTG_YTS_PHPVERSIONMINIMUM;?></li>
        <li><strong>WTG_YTS_CHMOD:</strong> <?php echo WTG_YTS_CHMOD;?></li>
        <li><strong>WTG_YTS_DATEFORMAT:</strong> <?php echo WTG_YTS_DATEFORMAT;?></li>
    </ul> 
    
    <?php 
    global $yts_debug_mode,$yts_is_dev,$yts_plugintitle,$yts_pluginname,$yts_homeslug,$yts_isbeingactivated,$yts_is_event,$yts_installation_required,$yts_was_installed,$yts_is_emailauthorised,$yts_log_maindir;
    ?>
        
    <h2>Variables</h2>   
    <ul>    
        <li><strong>Debug Mode:</strong> <?php echo $yts_debug_mode;?></li>                                                             
        <li><strong>Developer Mode:</strong> <?php echo $yts_is_dev;?></li>                                                             
        <li><strong>Plugin Title:</strong> <?php echo $yts_plugintitle;?></li>                                                             
        <li><strong>Plugin Name:</strong> <?php echo $yts_pluginname;?></li>                                                             
        <li><strong>Home Slug:</strong> <?php echo $yts_homeslug;?></li>
        <li><strong>Being Activated:</strong> <?php echo $yts_isbeingactivated;?></li>
        <li><strong>Is Event:</strong> <?php echo $yts_is_event;?></li>
        <li><strong>Installation Drive:</strong> <?php echo $yts_installation_required;?></li>
        <li><strong>Is Installed:</strong> <?php echo $yts_is_installed;?></li>
        <li><strong>Was Installed:</strong> <?php echo $yts_was_installed;?></li>
        <li><strong>Email Authorised:</strong> <?php echo $yts_is_emailauthorised;?></li>
        <li><strong>Log Main Dir:</strong> <?php echo $yts_log_maindir;?></li>                                                       
    </ul>    
      
    <?php 
    global $yts_currentproject,$yts_extension_loaded,$yts_guitheme,$yts_currentjob_code,$yts_currentproject_code;
    ?>
    
    <h2>Users Configuration</h2>
    <ul>
        <li><strong>Current Project:</strong> <?php echo $yts_currentproject;?></li>
        <li><strong>Extension Loaded:</strong> <?php echo $yts_extension_loaded;?></li>
        <li><strong>GUI Theme:</strong> <?php echo $yts_guitheme;?></li>
        <li><strong>Current Job Code:</strong> <?php echo $yts_currentjob_code;?></li>
        <li><strong>Current Project Code:</strong> <?php echo $yts_currentproject_code;?></li>
    </ul>  
    
    <h2>File Paths</h2>
    <ul>
        <li><strong>Plug</strong> <?php echo WTG_YTS_ABB;?></li>
        <li><strong>WTG_YTS_URL</strong> <?php echo WTG_YTS_URL;?></li>
        <li><strong>WTG_YTS_DIR</strong> <?php echo WTG_YTS_DIR;?></li>
        <li><strong>WTG_YTS_FOLDERNAME</strong> <?php echo WTG_YTS_FOLDERNAME;?></li>
        <li><strong>WTG_YTS_BASENAME</strong> <?php echo WTG_YTS_BASENAME;?></li>                    
        <li><strong>WTG_YTS_PANELFOLDER_PATH</strong> <?php echo WTG_YTS_PANELFOLDER_PATH;?></li>
        <li><strong>WTG_YTS_CONTENTFOLDER_DIR</strong> <?php echo WTG_YTS_CONTENTFOLDER_DIR;?></li>
        <li><strong>WTG_YTS_IMAGEFOLDER_URL</strong> <?php echo WTG_YTS_IMAGEFOLDER_URL;?></li>
    <ul>  

<?php yts_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = yts_WP_SETTINGS_panel_array($pageid,$panel_number,$yts_tab_number);
$panel_array['panel_name'] = 'serverconfiguration';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Server Configuration');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('The list of information indicates configuration important to this software 
and in some cases will indicate the status of an item i.e. if a required extension is not installed on your 
server and required for YouTube Sidebar to operate properly this will be made clear.');?>
<?php yts_panel_header( $panel_array );?>
            
    <ul>
        <li><strong>PHP Version:</strong> <?php echo phpversion();?></li>
        <li><strong>MySQL Version:</strong> <?php echo yts_get_mysqlversion();?></li>                          
        <li><strong>HTTP_HOST:</strong> <?php echo $_SERVER['HTTP_HOST'];?></li>
        <li><strong>SERVER_NAME:</strong> <?php echo $_SERVER['SERVER_NAME'];?></li>           
    </ul>
             
    <hr>
    
    <h2>Common Functions (returned value)</h2>
    <ul>
        <li><strong>time():</strong> <?php echo time();?></li>
        <li><strong>date('Y-m-d H:i:s'):</strong> <?php echo date('Y-m-d H:i:s');?></li>
        <li><strong>date('e'):</strong> <?php echo date('e');?> (timezone identifier)</li>
        <li><strong>date('G'):</strong> <?php echo date('G');?> (24-hour format)</li>
        <li><strong>get_admin_url():</strong> <?php echo get_admin_url();?></li>
        <li><strong>yts_link_toadmin():</strong> <?php echo yts_link_toadmin('examplepage');?></li>                   
    </ul>

<?php yts_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = yts_WP_SETTINGS_panel_array($pageid,$panel_number,$yts_tab_number);
$panel_array['panel_name'] = 'wordpressconfiguration';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Wordpress Configuration');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('Please send this information to us when seeking support on very complex problems.'); ?>
<?php yts_panel_header( $panel_array );?>
    <ul>
        <li><strong>Wordpress Database Charset:</strong> <?php echo DB_CHARSET; ?></li>
        <li><strong>Wordpress Blog Charset:</strong> <?php echo get_option('blog_charset'); ?></li>
        <li><strong>WP_MEMORY_LIMIT:</strong> <?php echo WP_MEMORY_LIMIT;?></li>            
        <li><strong>WP_POST_REVISIONS:</strong> <?php echo WP_POST_REVISIONS;?></li>                                    
    </ul> 
<?php yts_panel_footer();?> 

