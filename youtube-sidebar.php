<?php
/*
	Plugin Name: YouTube Sidebar
	Version: 0.1
	Plugin URI: http://www.webtechglobal.co.uk/blog/wordpress/youtube-sidebar-plugin
	Description: Add a video to each post or page using the admin and see it appear in the sidebar only when you visit that post or page.
	Author: Ryan Bayne
	Author URI: http://www.webtechglobal.co.uk
*/

global $wpdb;

include_once('youtube-sidebar-functions.php');

// global plugin variables
$mypluginname_users = 'YouTube Sidebar';
$mypluginname_code = 'youtubesidebar';

// plugin admin pages
function youtubesidebar_adminmenu() 
{
	add_menu_page('YouTube Sidebar', 'YouTube Sidebar', 8, __FILE__, 'youtubesidebarpage1');
    add_submenu_page(__FILE__, 'Settings', 'Settings', 8, 'youtubesidebar_settings', 'youtubesidebarpage2');
    add_submenu_page(__FILE__, 'Video Management', 'Video Management', 8, 'youtubesidebar_video_management', 'youtubesidebarpage3');
}

function youtubesidebarpage1(){require('youtube-sidebar-frontpage.php');}
function youtubesidebarpage2(){require('youtube-sidebar-settings.php');}
function youtubesidebarpage3(){require('youtube-sidebar-videomanagement.php');}

function youtubesidebar_loaded()
{
	$widget_ops = array('classname' => 'youtubesidebar_widget', 'description' => "Display YouTube videos in the sidebar from custom fields" );
	wp_register_sidebar_widget('youtubesidebar_widget', 'YouTube Sidebar', 'youtubesidebar_widget', $widget_ops);
}

function youtubesidebar_widget($args)
{
	extract($args); // extracts before_widget,before_title,after_title,after_widget all required and cannot be deleted
	echo $before_widget . $before_title . $after_title;

	$video_results = get_post_meta(get_the_ID(), 'youtube', true);
	
	if( $video_results )
	{
		// display one of the videos found
		echo $video_results;
	}
	else
	{
		// no video - display ads if settings require it
		if( get_option('youtubesidebar_spacereplace') == 1 )
		{
			// build option name to match adsense ad options name - ad only displayed when a size match is found
			$ad_option = 'youtubesidebar_adsense' . get_option('youtubesidebar_height') . 'x' . get_option('youtubesidebar_width');
			// display ad 
			echo get_option($ad_option);
		}
	}
	
	echo $after_widget;// required
}

// do hooks and actions
add_action('admin_menu', 'youtubesidebar_adminmenu',0);
register_activation_hook(__FILE__,'youtubesidebar_installation');
add_action('plugins_loaded','youtubesidebar_loaded');
?>