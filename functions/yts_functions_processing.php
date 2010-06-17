<?php

// save a new google adsense ad - we extract dimensions and id
function yts_newadsensead()
{
	if( isset( $_POST['yts_adsense_newad_submit'] ) )
	{
		$yts = get_option( 'yts_settings'); 
		
		if( !isset( $_POST['yts_adsensead'] ) || empty( $_POST['yts_adsensead'] ) )
		{
			yts_error('<strong>No AdSense Detected</strong><p>Please try again and ensure the adsense script has not been modified and is copied
						  from Google.</p>');		
		}
		else
		{		
			// remove spaces - cannot assume they exist or are correct
			$code = str_replace  (  ' '  ,  ''  , $_POST['yts_adsensead'] );
			// remove double quotes
			$code = str_replace  (  '"'  ,  ''  , $code );
			
			// split the google script code up using attributes
			$heightstring = stristr  (  $code , 'google_ad_height' );
			$widthstring = stristr  (  $code , 'google_ad_width' );
			$adslot = stristr  (  $code , 'google_ad_slot' );
			
			# size attributes #
			// remove the heightstring value in the widthstring to get width only
			$widthstring = str_replace  (  $heightstring  ,  ''  , $widthstring );
			// we now have google_ad_height=200; //-->  google_ad_width=200; - remove attribute values
			$heightstring = str_replace  (  'google_ad_height='  ,  ''  , $heightstring );
			$widthstring = str_replace  (  'google_ad_width='  ,  ''  , $widthstring );
			// use stristr to return everything after the ; that itself
			$heend = stristr  (  $heightstring , ';' );
			// replace the value of $heend in $heightstring with nothing to delete and ; in width string
			$height = str_replace  (  $heend  ,  ''  , $heightstring );
			$width = str_replace  (  ';'  ,  ''  , $widthstring );
			
			# ad_slot attribute #
			// use stristr to return everything after the ;
			$codeend = stristr  (  $adslot , ';' );		
			// remove the same result in the original code
			$adslot = str_replace  (  $codeend  ,  ''  , $adslot );
			// remove attribute itself plus equal sign
			$adslot = str_replace  (  'google_ad_slot='  ,  ''  , $adslot );
			// remove slashes
			$finaladslotid = stripslashes_deep( $adslot );

			if( empty( $height ) || empty( $width ) || empty( $finaladslotid ) )
			{
				yts_error('<strong>Invalid AdSense Detected</strong><p>The plugin could not determine required values with the
						  adsense script. Please try again and ensure the adsense script has not been modified and is copied
						  from Google.</p>');
			}
			else
			{
				$counter = 0;
			
				foreach( $yts['adsense']['ads'] as $key=>$value )
				{ 
					$yts['adsense']['ads'][$counter]['w'] = $value['w'];
					$yts['adsense']['ads'][$counter]['h'] = $value['h'];
					$yts['adsense']['ads'][$counter]['adslot'] = $value['adslot'];
					$yts['adsense']['ads'][$counter]['script'] = $value['script'];	
					++$counter; 
				}		
				
				$yts['adsense']['ads'][$counter]['w'] = $width;
				$yts['adsense']['ads'][$counter]['h'] = $height;
				$yts['adsense']['ads'][$counter]['adslot'] = $finaladslotid;
				$yts['adsense']['ads'][$counter]['script'] =  stripslashes_deep($_POST['yts_adsensead']);	
								
				if( update_option( 'yts_settings', $yts) )
				{
					yts_message('<strong>New AdSense Ad Saved</strong>');
				}
			}
		}
	}
}

// deletes sidebar video
function yts_deletesidebarvideo()
{
	if( isset( $_GET['vididdelete'] ) )
	{			
		if( delete_post_meta( $_GET['postid'], $_GET['vidtype'], $_GET['vididdelete'] ) )
		{
			yts_message('<strong>Video Deleted</strong><p>The video with id '. $_GET['vididdelete'] .' for the post id '. $_GET['postid'] .' has been deleted.</p>');
		}
		else
		{
			yts_error('<strong>Failed To Delete Video</strong><p>Video id is '. $_GET['vididdelete'] .' and post id '. $_GET['postid'] .'. The video could not be deleted from the posts custom fields. Please try again then contact webmaster@webtechglobal.co.uk for support.');
		}
	}
}

// adds a video to the content of the submitted post
function yts_addvideo_content()
{				
	if( isset( $_POST['yts_videotopost_content'] ) )
	{
		// first validate the video url
		$videourlarray = yts_validatevideourl( $_POST['yts_videourl'] );
		
		if( $videourlarray['id'] === false || $videourlarray === false )
		{
			
		}
		else
		{
			// id returned - build embed code
		}
		
		$_POST['yts_postid'];
	}
}

// assigns submitted video to a post in custom field for display in sidebar
function yts_addvideo_sidebar()
{
	if( isset( $_POST['yts_videotopost_sidebar'] ) )
	{
		// first validate the video url
		$videourlarray = yts_validatevideourl( $_POST['yts_videourl'] );
		
		if( $videourlarray['id'] === false || $videourlarray === false )
		{
			yts_error('<strong>Invalid URL Submitted</strong><p>The plugin searched for "youtube.com" or "blip.tv" within your url. It did not find these values or
					  it did not find a video id value at the end of the url. Please ensure you have the correct url and try again.</p>');
		}
		else
		{			
			// add video id to custom field for giving post id
			$metaresult = add_post_meta( $_POST['yts_postid'], $videourlarray['type'].'id' , $videourlarray['id'] );
			
			if( $metaresult )
			{
				yts_message('<strong>Video Saved For Sidebar</strong><p>Your video with the id '. $videourlarray['id'] .' was saved as a custom field for displaying in your sidebar
							when viewing the post with id '. $_POST['yts_postid'] .'.');
			}
			else
			{
				yts_error('<strong>Video Failed To Save</strong><p>Your video with the id '. $videourlarray['id'] .' failed to be added as a custom field, please try again
																										   or contact webmaster@webtechglobal.co.uk for support.');
			}
		}
	}
}

// establishes valid url - url type - returns array valid false on invalid
function yts_validatevideourl( $url )
{
	// create array - we will return type,id and url itself
	$videourlarray = array();
	$videourlarray['url'] = $url;
	
	// first detect url source - youtube or bliptv
	$videourlarray['type'] = 'TBC';
	
	// does the url contain youtube.com with in it
	$youtube = strpos( $videourlarray['url'],'youtube.com' );
	if( $youtube == true ) 
	{
	    $videourlarray['type'] = 'youtube';
	}
	
	// if $urltype is still TBC return false
	if( $videourlarray['type'] == 'TBC' )
	{
		return false;
	}
	else
	{
		// extract video id from url
		if( $videourlarray['type'] == 'youtube' )
		{
			// we need a list of possible youtube urls from different subdomanis
			$youtube_urlarray = array("http://www.youtube.com/watch?v=", 
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
			
			// replace values from array over the full url
			$youtubeid = str_replace($youtube_urlarray, "",$videourlarray['url']);
								
			// detect the first variable and extract it as video id
			$variable_location = strpos($youtubeid, "&");
			if($variable_location != false && $variable_location > 0)
			{
				$youtubeid = substr($youtubeid, 0, $variable_location);
			}
			
			// remove slashes from final value
			$videourlarray['id'] = strip_tags( stripslashes( $youtubeid ) );
			
			// if there is a youtube id value then return it
			if( $youtubeid )
			{
				return $videourlarray;
			}
			else
			{
				return false;
			}			
		}
	}
}

// remove adsense ad from plugin array
function yts_deleteadsensead()
{
	if( isset( $_GET['ytsdeleteadsense'] ) && is_numeric( $_GET['ytsdeleteadsense'] ) )
	{
		$yts = get_option( 'yts_settings'); 
		
		$counter = 0;
		
		foreach( $yts['adsense']['ads'] as $key=>$value )
		{ 
			if( $value['adslot'] == $_GET['ytsdeleteadsense'] )
			{	
				// get adslot id for interface message
				$adslot = $value['adslot'];
				
				// delete adsense ad by array key
				unset($yts['adsense']['ads'][$key]);
				
				if( update_option( 'yts_settings', $yts) )
				{
					yts_message('<strong>AdSense Ad Deleted</strong><p>The AdSense ad with Ad-Slot ID '. $adslot .' has been remove from the plugins settings.</p>');
				}
			}
		}
	}
}

// save global default settings
function yts_saveadsensettings()
{
	if( isset( $_POST['yts_adsense_settings_submit'] ) )
	{
		$yts = get_option( 'yts_settings');
		
        $yts['adsense']['activead'] = $_POST['yts_active_adsense'];		
        $yts['adsense']['home'] = $_POST['yts_home_adsense'];
        $yts['adsense']['single'] = $_POST['yts_single_adsense'];
        $yts['adsense']['many'] = $_POST['yts_many_adsense'];	
		
		if( update_option( 'yts_settings', $yts) )
		{
			yts_message('<strong>Main Settings Saved</strong>');
		}
	}	
}		
	
// save global default settings
function yts_saveglobalsettings()
{
	if( isset( $_POST['yts_globalsettings_submit'] ) )
	{
		$yts = get_option( 'yts_settings');
		
		$yts['settings']['sidebarheight'] = $_POST['yts_sidebarheight'];
		$yts['settings']['sidebarwidth'] = $_POST['yts_sidebarwidth'];
		$yts['settings']['rotation'] = $_POST['yts_rotation'];
		
		if( update_option( 'yts_settings', $yts) )
		{
			yts_message('<strong>Main Settings Saved</strong>');
		}
	}	
}	

// save youtube settings
function yts_saveyoutubesettings()
{
	if( isset( $_POST['yts_youtube_submit'] ) )
	{
		$yts = get_option( 'yts_settings'); 

		// YOUTUBE video display styles - default video styles
		// home only video styles
		$yts['youtube']['styles']['home']['color'] = $_POST['yts_home_color'];
		$yts['youtube']['styles']['home']['border'] = $_POST['yts_home_border'];
		$yts['youtube']['styles']['home']['autoplay'] = $_POST['yts_home_autoplay'];
		$yts['youtube']['styles']['home']['fullscreen'] = $_POST['yts_home_fullscreen'];
		$yts['youtube']['styles']['home']['scriptaccess'] = $_POST['yts_home_scriptaccess'];
		$yts['youtube']['styles']['home']['videos'] = $_POST['yts_home_videos'];
		// single page only video styles
		$yts['youtube']['styles']['single']['color'] = $_POST['yts_single_color'];
		$yts['youtube']['styles']['single']['border'] = $_POST['yts_single_border'];
		$yts['youtube']['styles']['single']['autoplay'] = $_POST['yts_single_autoplay'];
		$yts['youtube']['styles']['single']['fullscreen'] = $_POST['yts_single_fullscreen'];
		$yts['youtube']['styles']['single']['scriptaccess'] = $_POST['yts_single_scriptaccess'];
		$yts['youtube']['styles']['single']['videos'] = $_POST['yts_single_videos'];
		// many posts/archive/category only video styles
		$yts['youtube']['styles']['many']['color'] = $_POST['yts_many_color'];
		$yts['youtube']['styles']['many']['border'] = $_POST['yts_many_border'];
		$yts['youtube']['styles']['many']['autoplay'] = $_POST['yts_many_autoplay'];
		$yts['youtube']['styles']['many']['fullscreen'] = $_POST['yts_many_fullscreen'];
		$yts['youtube']['styles']['many']['scriptaccess'] = $_POST['yts_many_scriptaccess'];
		$yts['youtube']['styles']['many']['videos'] = $_POST['yts_many_videos'];
	
		if( update_option( 'yts_settings', $yts) )
		{
			yts_message('<strong>YouTube Settings Saved</strong>');
		}
	}
}

// reinstall all plugin settings
function yts_reinstallsettings()
{
	if( isset( $_POST['yts_reinstallsettings_submit'] ) )
	{
		delete_option( 'yts_settings' );
		
		require_once('yts_functions_installation.php');

		if( yts_insert_pluginsettings() )
		{
			yts_message('<strong>Settings Reinstalled</strong>');
		}
	}
}

?>