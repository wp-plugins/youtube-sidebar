<?php
/*
	Plugin Name: YouTube Sidebar
	Version: 0.8
	Plugin URI: http://www.webtechglobal.co.uk/blog/wordpress/youtube-sidebar-plugin
	Description: Add a video to each post or page using the admin and see it appear in the sidebar only when you visit that post or page. This is the pro edition.
	Author: Ryan Bayne
	Author URI: http://www.webtechglobal.co.uk
*/  
	
global $wpdb;

include_once('youtube-sidebar-functions.php');

// global plugin variables
$mypluginname_users = 'YouTube Sidebar';
$mypluginname_code = 'youtubesidebar';

// do hooks and actions
add_action('admin_menu', 'youtubesidebar_adminmenu',0);
register_activation_hook(__FILE__,'youtubesidebar_installation');
add_action('wp_head','youtubesidebar_pagetype');
add_action('plugins_loaded','youtubesidebar_loaded');
?>