<?php
function youtubesidebar_pagetype()
{
	if( is_front_page() || is_home() )
	{
		update_option('youtubesidebar_realpagetype','frontpage');
	}
	elseif( is_single() || is_page() || is_singular() )
	{
		update_option('youtubesidebar_realpagetype','single');
	}
	elseif( is_category() || is_archive() )
	{
		update_option('youtubesidebar_realpagetype','category');
	}
}

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
	
	if (have_posts())
	{
		$videocount = 0;// number of videos applied to sidebar - including adsense or other content

		if( get_option('youtubesidebar_realpagetype') == 'frontpage' && get_option('youtubesidebar_frontpagevideos') != 0 )
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
		elseif( get_option('youtubesidebar_realpagetype') == 'single' && get_option('youtubesidebar_singlepagevideos') != 0 )
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
		elseif( get_option('youtubesidebar_realpagetype') == 'category' && get_option('youtubesidebar_categorypagevideos') != 0 )
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

function youtubesidebar_displayadsense($pagetype)
{
	// first get page types own setting for displaying adsense or not
	if( $pagetype == 'frontpage' )
	{
		$onoff = get_option( 'youtubesidebar_adsensefrontpageonoff' );
	}
	elseif( $pagetype == 'single' )
	{
		$onoff = get_option( 'youtubesidebar_adsensesingleonoff' );
	}
	elseif( $pagetype == 'category' )
	{
		$onoff = get_option( 'youtubesidebar_adsensecategoryonoff' );
	}
	
	if( $onoff == 1 )// if set to 1 then adsense is switched on for the current page
	{
		// build option name to match adsense ad options name - ad only displayed when a size match is found
		$ad_option = 'youtubesidebar_adsense' . get_option('youtubesidebar_height') . 'x' . get_option('youtubesidebar_width');
		// display ad 
		echo get_option($ad_option);
	}
}

function youtubesidebar_echovideos($video_results, $pagetype, $videocount)
{	
	if( $pagetype = 'frontpage' )
	{
		$maxvideos = get_option('youtubesidebar_frontpagevideos');
	}
	elseif( $pagetype = 'single' )
	{
		$maxvideos = get_option('youtubesidebar_singlepagevideos');
	}
	elseif( $pagetype = 'category' )
	{
		$maxvideos = get_option('youtubesidebar_categorypagevideos');
	}
	
	$exactvideo = 0;// counter for applying spaces

	foreach( $video_results as $youtubevideo )
	{	
		$exactvideo++;// counter for applying spaces
		
		if( $videocount < $maxvideos && $maxvideos != 0 )
		{
			$type1 = strstr($youtubevideo,'<object ');// if embed object match will return 1 else 0
			$type2 = strstr($youtubevideo,'youtube.com/watch?v=');// if youtube url match will return 1 else 0		

			if( $type1 == true)// embed code found, no modification required 
			{
				echo $youtubevideo;
			}
			elseif( $type2 == true )// we assume that it is a basic youtube url, not embed code
			{
				$youtubeid = youtubesidebar_returnvideoid($youtubevideo);
				echo youtubesidebar_createembedsnippet($youtubeid, $videocount);
				if( $exactvideo != 0 ) { echo '<br />'; }
			}
			else// not a youtube video must be some other content
			{
				echo $youtubevideo;
			}
		}
		$videocount++;
	}
	return $videocount;
}		

// this function will strip a standard youtube url (not embed code) to return the video id
function youtubesidebar_returnvideoid($youtube_url)
{
	$url_array = array("http://www.youtube.com/watch?v=", 
		"http:/youtube.com/watch?v=",
		"http://br.youtube.com/watch?v=",
		"http://uk.youtube.com/watch?v=",
		"http://fr.youtube.com/watch?v=",
		"http://ie.youtube.com/watch?v=",
		"http://it.youtube.com/watch?v=",
		"http://jp.youtube.com/watch?v=",
		"http://nl.youtube.com/watch?v=",
		"http://pl.youtube.com/watch?v=",
		"http://es.youtube.com/watch?v=");
	
	$youtubeid =  str_ireplace($url_array, "",	$youtube_url);
			
	// detect and remove url variables
	$variable_location = strpos($youtubeid, "&");
	if($variable_location != FALSE AND $variable_location > 0)
	{
		$youtubeid = substr($youtubeid, 0, $variable_location);
	}
	
	$youtubeid = strip_tags(stripslashes($youtubeid));
	return $youtubeid;
}// end of returnvideoid function

function youtubesidebar_videocolour1()
{
	if( get_option('youtubesidebar_colour') == 1 ){ $colour1 = ''; }//Default
	elseif( get_option('youtubesidebar_colour') == 2 ){ $colour1 = '&color1=0x3a3a3a'; }//Dark Grey
	elseif( get_option('youtubesidebar_colour') == 3 ){ $colour1 = '&color1=0x2b405b'; }//Navy Blue
	elseif( get_option('youtubesidebar_colour') == 4 ){ $colour1 = '&color1=0x006699'; }//Sky Blue
	elseif( get_option('youtubesidebar_colour') == 5 ){ $colour1 = '&color1=0x234900'; }//Green
	elseif( get_option('youtubesidebar_colour') == 6 ){ $colour1 = '&color1=0xe1600f'; }//Orange
	elseif( get_option('youtubesidebar_colour') == 7 ){ $colour1 = '&color1=0xcc2550'; }//Pink
	elseif( get_option('youtubesidebar_colour') == 8 ){ $colour1 = '&color1=0x402061'; }//Purple
	elseif( get_option('youtubesidebar_colour') == 9 ){ $colour1 = '&color1=0x5d1719'; }//Red
	return $colour1;
}

function youtubesidebar_videocolour2()
{
	if( get_option('youtubesidebar_colour') == 1 ){ $colour2 = ''; }//Default
	elseif( get_option('youtubesidebar_colour') == 2 ){ $colour2 = '&color2=0x999999'; }//Dark Grey
	elseif( get_option('youtubesidebar_colour') == 3 ){ $colour2 = '&color2=0x6b8ab6'; }//Navy Blue
	elseif( get_option('youtubesidebar_colour') == 4 ){ $colour2 = '&color2=0x54abd6'; }//Sky Blue
	elseif( get_option('youtubesidebar_colour') == 5 ){ $colour2 = '&color2=0x4e9e00'; }//Green
	elseif( get_option('youtubesidebar_colour') == 6 ){ $colour2 = '&color2=0xfebd01'; }//Orange
	elseif( get_option('youtubesidebar_colour') == 7 ){ $colour2 = '&color2=0xe87a9f'; }//Pink
	elseif( get_option('youtubesidebar_colour') == 8 ){ $colour2 = '&color2=0x9461ca'; }//Purple
	elseif( get_option('youtubesidebar_colour') == 9 ){ $colour2 = '&color2=0xcd311b'; }//Red
	return $colour2;
}

// this function will build the embed code were going to use in the sidebar
function youtubesidebar_createembedsnippet($youtubeid, $videocount)
{
	if( get_option('youtubesidebar_autoplay') == 1 && $videocount == 0)// first video and auto play on for it, but not the 2nd, 3rd etc
	{
		$autoplay = '&autoplay=1';
	}
	else{$autoplay = '';}
	
	if( get_option('youtubesidebar_border') == 1)
	{
		$border = '&border=1';
	}
	else{$border = '';}
	    
	// the empty youtube embed code for adding our values too
	$embedsnippet = '<object width="%-width-%" height="%-height-%">
	<param name="movie" value="http://www.youtube.com/v/%-youtubeid-%%-autoplay-%%-color1-%%-color2-%%-border-%"></param>
	<param name="allowFullScreen" value="true"></param>
	<param name="allowscriptaccess" value="always"></param>
	<embed src="http://www.youtube.com/v/%-youtubeid-%%-autoplay-%%-color1-%%-color2-%%-border-%" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="%-width-%" height="%-height-%"></embed>
	</object>';
	
	$colour1 = youtubesidebar_videocolour1();
	$colour2 = youtubesidebar_videocolour2();

	// replace embed code values with real values
	$embedresult = str_replace(
		array("%-youtubeid-%","%-width-%","%-height-%","%-autoplay-%","%-color1-%","%-color2-%","%-border-%"), 
		array($youtubeid,get_option('youtubesidebar_width'),get_option('youtubesidebar_height'),$autoplay,$colour1,$colour2,$border), 
		$embedsnippet
	);		

	return $embedresult;
}

function youtubesidebar_installation($state)
{
	// demo mode setting - manually edited by WebTechGlobal for demo blogs only, please ignore
	add_option('youtubesidebar_demomode',0);// 0 = off 1 = on

	$ad125x125 = '<script type="text/javascript"><!--
				google_ad_client = "pub-4923567693678329";
				/* 125x125, created 12/18/09 */
				google_ad_slot = "0509601881";
				google_ad_width = 125;
				google_ad_height = 125;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>';
				
	$ad180x150 = '<script type="text/javascript"><!--
				google_ad_client = "pub-4923567693678329";
				/* 180x150, created 12/18/09 */
				google_ad_slot = "7693841311";
				google_ad_width = 180;
				google_ad_height = 150;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>';	
	
	$ad200x200 = '<script type="text/javascript"><!--
				google_ad_client = "pub-4923567693678329";
				/* 200x200, created 12/18/09 */
				google_ad_slot = "8656642919";
				google_ad_width = 200;
				google_ad_height = 200;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>';	
	
	$ad250x250 = '<script type="text/javascript"><!--
				google_ad_client = "pub-4923567693678329";
				/* 250x250, created 12/18/09 */
				google_ad_slot = "1660801882";
				google_ad_width = 250;
				google_ad_height = 250;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>';
				
	$ad300x350 = '<script type="text/javascript"><!--
				google_ad_client = "pub-4923567693678329";
				/* 300x250, created 12/18/09 */
				google_ad_slot = "7071012952";
				google_ad_width = 300;
				google_ad_height = 250;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>';
	
	$ad336x280 = '<script type="text/javascript"><!--
				google_ad_client = "pub-4923567693678329";
				/* 336x280, created 12/18/09 */
				google_ad_slot = "6055085333";
				google_ad_width = 336;
				google_ad_height = 280;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>';		

	
	
	// set default adsense
	if($state == 1)// delete options before attempted re-adding them
	{
		delete_option('youtubesidebar_debugmode');// 0 = off 1 = on
		delete_option('youtubesidebar_height');// height of youtube video in sidebar
		delete_option('youtubesidebar_width');// width of youtube video in sidebar
		delete_option('youtubesidebar_width');
		delete_option('youtubesidebar_rotation');
		delete_option('youtubesidebar_scriptaccess');
		delete_option('youtubesidebar_autoplay');
		delete_option('youtubesidebar_singlepagevideos');
		delete_option('youtubesidebar_frontpagevideos');
		delete_option('youtubesidebar_categorypagevideos');
		delete_option('youtubesidebar_adsensecategoryonoff');
		delete_option('youtubesidebar_adsensesingleonoff');
		delete_option('youtubesidebar_adsensefrontpageonoff');
		delete_option('youtubesidebar_colour');
		delete_option('youtubesidebar_border');
	}
		
	add_option('youtubesidebar_debugmode',0);// 0 = off 1 = on
	add_option('youtubesidebar_height',200);// height of youtube video in sidebar
	add_option('youtubesidebar_width',200);// width of youtube video in sidebar
	add_option('youtubesidebar_fullscreen',1);// 1 = full screen mode allowed 0 = not allowed
	add_option('youtubesidebar_rotation',1);// track visitor ip and rotate videos with ads
	add_option('youtubesidebar_adsense125x125',$ad125x125);// google adsense ad 125 x 125
	add_option('youtubesidebar_adsense180x150',$ad180x150);// google adsense ad 180x150
	add_option('youtubesidebar_adsense200x200',$ad200x200);// google adsense ad 200 x 200
	add_option('youtubesidebar_adsense250x250',$ad250x250);// google adsense ad 250 x 250
	add_option('youtubesidebar_adsense300x250',$ad300x250);// google adsense ad 300 x 250
	add_option('youtubesidebar_adsense336x280',$ad336x280);// google adsense ad 336 x 280
	add_option('youtubesidebar_scriptaccess',1);// 1 = allow script access to videos 0 = do not allow
	add_option('youtubesidebar_autoplay',0);// auto play videos or not 0 = no and 1 = yes
	add_option('youtubesidebar_singlepagevideos',1);// number of videos to allow on a single page/post
	add_option('youtubesidebar_frontpagevideos',1);// number of videos to allow on the front page/home
	add_option('youtubesidebar_categorypagevideos',3);// number of videos to allow on a category page/archive
	add_option('youtubesidebar_adsensecategoryonoff',1);// 1 = on and 0 = off for adsense on category pages
	add_option('youtubesidebar_adsensesingleonoff',1);// 1 = on and 0 = off for adsense on single pages
	add_option('youtubesidebar_adsensefrontpageonoff',1);// 1 = on and 0 = off for adsense on the front page
	add_option('youtubesidebar_colour','1');// default is 1 and is no applied style in terms of code
	add_option('youtubesidebar_border',0);// border on or off 1 = on and 0 = off
	add_option('youtubesidebar_realpagetype','');// initial setup of the real page option, set in wp_head by action function
}
?>