<?php
/*
	Plugin Name: YouTube Sidebar
	Version: 0.5
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
	add_options_page('YouTube Sidebar', 'YouTube Sidebar', 8, __FILE__, 'youtubesidebarpage1');
}

function youtubesidebarpage1(){require('youtube-sidebar-frontpage.php');}

function youtubesidebar_loaded()
{
	$widget_ops = array('classname' => 'youtubesidebar_widget', 'description' => "Display YouTube videos in the sidebar from custom fields" );
	wp_register_sidebar_widget('youtubesidebar_widget', 'YouTube Sidebar', 'youtubesidebar_widget', $widget_ops);
}

function youtubesidebar_widget($args)
{
	extract($args); // extracts before_widget,before_title,after_title,after_widget all required and cannot be deleted
	echo $before_widget . $before_title . $after_title;
	
	if (have_posts())
	{
		$videocount = 0;// number of videos applied to sidebar - including adsense or other content

		if( is_front_page() || is_home() && get_option('youtubesidebar_frontpagevideos') != 0 )
		{
			// first check if there are any videos at all from all the posts being displayed, if so we can use the result as an adsense switch
			$videosfound = 0;
			while ( have_posts() )
			{
				the_post();
				$video_results = get_post_meta(get_the_ID(), 'youtube');
				
				if( !empty ($video_results) )// videos returned
				{				
					$videosfound++;
				}
			}	
			
			// go on to display videos or adsense
			while ( have_posts() && $videocount <= get_option('youtubesidebar_frontpagevideos') )
			{
				the_post();
				$video_results = get_post_meta(get_the_ID(), 'youtube');
				
				// display the results
				if( !empty ($video_results) )// videos returned
				{
					$videocount = youtubesidebar_echovideos($video_results, 'frontpage', $videocount);// final output of videos
				}
				elseif( empty ($video_results) && $videosfound == 0 )// no videos returned so display adsense content
				{
					$videocount = youtubesidebar_displayadsense('frontpage');
				}
			}				
		}
		elseif( is_single() || is_page() && get_option('youtubesidebar_singlepagevideos') != 0 )
		{
			the_post();
			$video_results = get_post_meta(get_the_ID(), 'youtube');
			
			// display the results
			if( !empty ($video_results) )// videos returned
			{
				$videocount = youtubesidebar_echovideos($video_results, 'single', $videocount);// final output of videos
			}
			elseif( empty ($video_results) )// no videos returned so display adsense content
			{
				$videocount = youtubesidebar_displayadsense('single');
			}
		}
		elseif( is_category() || is_archive() && get_option('youtubesidebar_categorypagevideos') != 0 )
		{

			// first check if there are any videos at all from all the posts being displayed, if so we can use the result as an adsense switch
			$videosfound = 0;
			while ( have_posts() )
			{
				the_post();
				$video_results = get_post_meta(get_the_ID(), 'youtube');
				
				if( !empty ($video_results) )// videos returned
				{				
					$videosfound++;
				}
			}
			
			while ( have_posts() )
			{
				the_post();
				$video_results = get_post_meta(get_the_ID(), 'youtube');
				
				// display the results
				if( !empty ($video_results) )// videos returned
				{
					$videocount =  youtubesidebar_echovideos($video_results, 'category', $videocount);// final output of videos
				}
				elseif( empty ($video_results) && $videosfound == 0 )// no videos returned so display adsense content
				{
					$videocount = youtubesidebar_displayadsense('category');
				}
			}		
		}
	}
		
	echo $after_widget;// required
}

// do hooks and actions
add_action('admin_menu', 'youtubesidebar_adminmenu',0);
register_activation_hook(__FILE__,'youtubesidebar_installation');
add_action('plugins_loaded','youtubesidebar_loaded');
?>