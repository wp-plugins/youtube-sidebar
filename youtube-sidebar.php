<?php
/*
	Plugin Name: YouTube Sidebar
	Version: 1.1
	Plugin URI:http://www.webtechglobal.co.uk/blog/wordpress/youtube-sidebar-plugin
	Description: Add YouTube or Blip TV videos to any post to make them show in your sidebar 
	Author: Ryan Bayne
	Author URI: http://www.webtechglobal.co.uk
*/

### developer configuration start
$easycsvimporterdebugmode = 0;
if( $easycsvimporterdebugmode == 1 )
{
	ini_set('display_errors',1);
	error_reporting(E_ALL);
}
### developer configuration end

function yts_commonincludes()
{
	require_once('functions/yts_functions_global.php');
	require_once('functions/yts_functions_interface.php');
	require_once('functions/yts_functions_processing.php');
}

// wysiwyg editor used to style widget boxes
function yts_wysiwygeditor() 
{
	wp_enqueue_script( 'common' );
	wp_enqueue_script( 'jquery-color' );
	wp_print_scripts('editor');
	if (function_exists('add_thickbox')) add_thickbox();
	wp_print_scripts('media-upload');
	if (function_exists('wp_tiny_mce')) wp_tiny_mce();
	wp_admin_css();
	wp_enqueue_script('utils');
	do_action("admin_print_styles-post-php");
	do_action('admin_print_styles');
}	

// plugin installation
function yts_installation() 
{	
	global $wordpressmu;
	yts_commonincludes();
	require_once('functions/yts_functions_installation.php');
	yts_insert_pluginsettings();	
}					
	
// plugin admin pages
function yts_createmenu() 
{
	require_once('functions/yts_functions_global.php');
	
 	$yts = get_option( 'yts_settings' );
	
	$per = 10;
	
	add_menu_page('YouTube Sidebar', 'YouTube Sidebar', $per, __FILE__, 'yts_toppage1');
    add_submenu_page(__FILE__, 'Manager', 'Manager', $per, 'yts_manager', 'yts_subpage2');
    add_submenu_page(__FILE__, 'Settings', 'Settings', $per, 'yts_settings', 'yts_subpage12');
    add_submenu_page(__FILE__, 'Tools', 'Tools', $per, 'yts_tools', 'yts_subpage13');
    add_submenu_page(__FILE__, 'Developer Notes', 'Developer Notes', $per, 'yts_developer', 'yts_subpage15');
}

function yts_toppage1(){yts_commonincludes();require_once('yts_home.php');}
function yts_subpage2(){yts_commonincludes();require_once('yts_manager.php');}
function yts_subpage12(){yts_commonincludes();require_once('yts_settings.php');}
function yts_subpage13(){yts_commonincludes();require_once('yts_tools.php');}
function yts_subpage15(){yts_commonincludes();require_once('yts_developernotes.php');}

// register widget - makes it available for use in admin
function yts_registerwidget1()
{
	yts_commonincludes();
	$widget_ops = array('classname' => 'yts_widget', 'description' => "Display videos in the sidebar" );
	wp_register_sidebar_widget('yts_widget', 'Video Blog Builder', 'yts_widget', $widget_ops);
}

// admin menu action
add_action('admin_menu', 'yts_createmenu');

// wordpress wysiwyg editor load
add_action('admin_head', 'yts_wysiwygeditor');

// sidebar widget 1 load
add_action('plugins_loaded','yts_registerwidget1');

// installation trigger
register_activation_hook(__FILE__,'yts_installation');
?>