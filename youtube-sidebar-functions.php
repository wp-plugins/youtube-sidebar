<?php

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
	
	foreach( $video_results as $youtubevideo )
	{		
		$type = strstr($youtubevideo,'<object ');// if match found will return true, else returns false

		if( $videocount <= $maxvideos )
		{
			if( $type == true)// embed code found, no modification required 
			{
				echo $youtubevideo;
			}
			elseif( $type == false )// we assume that it is a basic youtube url, not embed code
			{
				$youtubeid = youtubesidebar_returnvideoid($youtubevideo);
				echo youtubesidebar_createembedsnippet($youtubeid);
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

// this function will build the embed code were going to use in the sidebar
function youtubesidebar_createembedsnippet($youtubeid)
{
	$autoplay = '&autoplay=1';
	
	// the empty youtube embed code for adding our values too
	$embedsnippet = '<object width="%-width-%" height="%-height-%">
	<param name="movie" value="http://www.youtube.com/v/%-youtubeid-%%-autoplay-%"></param>
	<param name="wmode" value="transparent"></param>
	<embed src="http://www.youtube.com/v/%-youtubeid-%%-autoplay-%" type="application/x-shockwave-flash" wmode="transparent" width="%-width-%" height="%-height-%"></embed>
	</object>';
	
	// replace embed code values with real values
	$embedresult = str_replace(
		array("%-youtubeid-%","%-width-%","%-height-%","%-autoplay-%"), 
		array($youtubeid,get_option('youtubesidebar_width'),get_option('youtubesidebar_height'),$autoplay), 
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
	
}
?>