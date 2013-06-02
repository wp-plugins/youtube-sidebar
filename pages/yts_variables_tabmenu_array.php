<?php
####################################################################
####                                                            ####
####           TABS NAVIGATION ARRAY ($yts_mpt_arr)             ####
####                                                            ####
####################################################################                                        
global $yts_homeslug,$yts_plugintitle;
$freepath = WTG_YTS_DIR.'pages/';
$paidpath = WTG_YTS_DIR.'fulledition/pages/';
$yts_mpt_arr = array();
// ARRAY INFORMATION FIRST
$yts_mpt_arr['arrayinfo']['version'] = '1.0.0';
// main page
$yts_mpt_arr['menu']['main']['active'] = true;// boolean -is this page in use
$yts_mpt_arr['menu']['main']['slug'] = 'youtubesidebar';// home page slug set in main file
$yts_mpt_arr['menu']['main']['menu'] = 'YouTube Sidebar';// main menu title
$yts_mpt_arr['menu']['main']['name'] = "mainpage";// name of page (slug) and unique
$yts_mpt_arr['menu']['main']['title'] = 'YouTube Sidebar';// page title seen once page is opened
$yts_mpt_arr['menu']['main']['headers'] = false;// boolean - display a content area above selected tabs i.e. introductions or status
$yts_mpt_arr['menu']['main']['vertical'] = false;// boolean - is the menu vertical rather than horizontal
$yts_mpt_arr['menu']['main']['statusicons'] = false;// boolean - instead of related icons we use cross & tick etc indicating completion or not
$yts_mpt_arr['menu']['main']['permissions']['defaultcapability'] = 'update_core';// our best guess on a suitable capability
$yts_mpt_arr['menu']['main']['permissions']['customcapability'] = 'update_core';// users requested capability which is giving priority over default
$yts_mpt_arr['menu']['main']['package'] = 'free';// free|paid|beta - free will add screen to all packages - beta requires $yts_beta_mode = true to display the screen, meaning beta can be hidden also, important for switching to a ready build before release 
$sub = 0; 
$yts_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'addremovevideos';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Add/Remove Videos';# developer information
$yts_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = true;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$yts_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/yts_addremovevideos.php';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins'; 
++$sub;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['active'] = false;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'managevideos';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Manage Videos';# developer information
$yts_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = true;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$yts_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/yts_managevideos.php';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
++$sub;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'manageads';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Manage Ads';# developer information
$yts_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = true;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$yts_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/yts_manageads.php';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
++$sub; 
$yts_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'generalsettings';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'General Settings';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = true;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$yts_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/yts_generalsettings.php';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'activate_plugins'; 
++$sub; 
$yts_mpt_arr['menu']['main']['tabs'][$sub]['active'] = false;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'datasettings';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Data Settings';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = false;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$yts_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/yts_datasettings.php';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'activate_plugins';  
++$sub; 
$yts_mpt_arr['menu']['main']['tabs'][$sub]['active'] = false;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'ecq';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Easy Configuration Questions';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = true; 
$yts_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens 
$yts_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/yts_ecq.php';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'activate_plugins';
++$sub;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['active'] = false;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'schedulesettings';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Schedule Settings';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$yts_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'paid';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$yts_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/yts_schedulesettings.php';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'activate_plugins';
++$sub;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'install';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Install';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = true;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$yts_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/yts_install.php';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
++$sub;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'log';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'Log';# developer information
$yts_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = true;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$yts_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/yts_log.php';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
++$sub; 
$yts_mpt_arr['menu']['main']['tabs'][$sub]['active'] = true;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['slug'] = 'about';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['label'] = 'About';  
$yts_mpt_arr['menu']['main']['tabs'][$sub]['allowhide'] = false;
$yts_mpt_arr['menu']['main']['tabs'][$sub]['package'] = 'free';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$yts_mpt_arr['menu']['main']['tabs'][$sub]['path'] = $freepath.'pagemain/yts_about.php';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'activate_plugins';
$yts_mpt_arr['menu']['main']['tabs'][$sub]['permissions']['customcapability'] = 'activate_plugins';  
?>