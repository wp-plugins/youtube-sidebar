<?php 	
// returns the current page type
function yts_returnpagetype()
{
	global $post;

	if( is_front_page() || is_home() )
	{
		return 'home';
	}
	elseif( is_single() || is_page() || is_singular() )
	{
		return 'single';
	}
	elseif( is_category() || is_archive() )
	{
		return 'many';
	}
}

// widget code - executed in the sidebar if widget in use
function yts_widget($args)
{
	$yts = get_option( 'yts_settings' );
	
	$pagetype = yts_returnpagetype();

	// first establish if user has videos or ads activated
	if( $yts['youtube']['styles'][$pagetype]['videos'] != 0 || $yts['adsense']['home'] == 'Yes' || $yts['adsense']['single'] == 'Yes' || $yts['adsense']['many'] == 'Yes' )
	{
		$yts = get_option( 'yts_settings' );
		
		// extracts before_widget,before_title,after_title,after_widget all required and cannot be deleted
		extract($args); 
		echo $before_widget . $before_title . ' Videos ' . $after_title;
		
		if ( have_posts() )
		{			
			// count videos or ads displayed
			$videocount = 0;

			// ensure settings allow 1 more videos - used later for individual video types also
			$maxyoutubevids = $yts['youtube']['styles'][$pagetype]['videos'];
			$maxvids = $maxyoutubevids;	
	
			// if total is above 0 then videos on home page are allowed else they are not - is adsense ?
			if( $maxvids != 0 )
			{
				// keep count of videos displayed
				$videosdisplayed = 0;
				
				// loop through posts being viewed until we have enough videos
				while ( have_posts() && $videosdisplayed < $maxvids )
				{
					// get the post data
					the_post();
					
					// get youtube videos
					$youtubevideos = get_post_meta( get_the_ID(), 'youtubeid' );
					
					// list any youtube found
					if( $youtubevideos && $maxyoutubevids != 0 )
					{
						foreach( $youtubevideos as $youtubeid )
						{						
							$youtube_videosdisplayed = 0;
							if( $youtube_videosdisplayed >= $maxyoutubevids || $videosdisplayed >= $maxvids)
							{
								break;
							}
							else
							{
								yts_buildembedcode_youtube( $youtubeid, 
														   $videosdisplayed, 
														   $yts['youtube']['styles'][$pagetype]['color'],
														   $yts['youtube']['styles'][$pagetype]['border'],
														   $yts['settings']['sidebarwidth'],
														   $yts['settings']['sidebarheight']);
								++$videosdisplayed;
								++$youtube_videosdisplayed;
							}
						}
					}	
				}
			}// end if max vids not zero
			
			// display adsense if no videos shown and it is active
			if( $videosdisplayed == 0 && $yts['adsense'][$pagetype] == 'Yes')
			{
				// get active ad id
				$counter = 0;

				foreach( $yts['adsense']['ads'] as $key=>$value )
				{ 
					if( $yts['adsense']['activead'] == $value['adslot'] )
					{
						$adslotid = $value['adslot'];
						$adwidth = $value['w'];
						$adheight = $value['h'];
						
					    echo $value['script'];
					}
					
					++$counter; 
				}					
				
			}// end if no vids listed
				
		}// end if have posts
		
		// display after widget
		echo $after_widget;
		
	}// end if videos or adsense active
}

// this function will strip a standard youtube url (not embed code) to return the video id
function yts_returnvideoid($youtube_url)
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
	
	$youtubeid =  str_ireplace( $url_array, "",	$youtube_url );
			
	// detect and remove url variables
	$variable_location = strpos( $youtubeid, "&" );
	if($variable_location != FALSE && $variable_location > 0)
	{
		$youtubeid = substr( $youtubeid, 0, $variable_location );
	}
	
	$youtubeid = strip_tags( stripslashes( $youtubeid ) );
	return $youtubeid;
}// end of returnvideoid function

// builds youtube embed code - requires video id, current video count, autoplay setting, border setting
function yts_buildembedcode_youtube($videoid, $videocount, $color, $border, $width, $height )
{	
	// the empty youtube embed code for adding our values too
	echo '<object width="'.$width.'" height="'.$height.'">
	<param name="movie" value="http://www.youtube.com/v/'.$videoid.$color.$border.'"></param>
	<param name="allowFullScreen" value="true"></param>
	<param name="allowscriptaccess" value="always"></param>
	<embed src="http://www.youtube.com/v/'.$videoid.$color.$border.'" type="application/x-shockwave-flash" 
	allowscriptaccess="always" allowfullscreen="true" width="'.$width.'" height="'.$height.'"></embed>
	</object>';
}													   

// adds a new notification message 
function yts_addnotification( $message, $file, $line )
{
	$counter = 0;
	
	// get notification data from options table
	$nots = get_option( 'yts_notifications' );
	
	// loop through existing notifications - the count acts as an id within the array itself
	foreach( $nots['notifications'] as $key=>$schedule )
	{ 
		// installation example
		$nots['notifications'][$counter]['csvfile'] = $schedule['csvfile'];
		$nots['notifications'][$counter]['message'] = $schedule['message'];
		$nots['notifications'][$counter]['phpfile'] = $schedule['phpfile'];
		$nots['notifications'][$counter]['phpline'] = $schedule['phpline'];
		$nots['notifications'][$counter]['notid'] = $schedule['notid'];
		
		++$counter; 
	}				

	// installation example
	$nots['notifications'][$counter]['csvfile'] = yts_currentfile_return();// project csv file
	$nots['notifications'][$counter]['message'] = $message;
	$nots['notifications'][$counter]['phpfile'] = $file;// when applicable, for debugging, add current file
	$nots['notifications'][$counter]['phpline'] = $line ;// when applicable, for debugging, add line error occured
	$nots['notifications'][$counter]['notid'] = time() . rand(1000, 9999);// when applicable, for debugging, add line error occured
	
	update_option( 'yts_notifications', $nots);
}

// used to display a yellow message
function yts_message( $message )// wordpress styled UI message
{
	echo '<div id="message" class="updated fade"><p>'. $message .'</p></div>';
}

// used to display a red message
function yts_error( $message )// wordpress styled UI message
{
	echo '<div id="error" class="error"><p>'. $message .'</p></div>';
}

// used on all pages for header - requires page title
function yts_header( $title )
{
	$yts = get_option('yts_settings');
	echo '<div class="wrap">';
	echo '<div id="poststuff" class="meta-box-sortables" style="position: relative; margin-top:10px;">';
	echo '<h1>'. $title .'</h1>';
}

// echos selected in form items - pass two items for condition - current value and the option value in menu
function yts_echoselected( $value,$argument){if( $value == $argument ){echo 'selected="selected"';}}

// footer for all pages - includes display of plugins options for debugging
function yts_footer()
{
	$yts = get_option( 'yts_settings' );?>
    
	<p>Copyright &copy; 2010 - WebTechGlobal Ltd</p> 
    
	</div><!-- end of post stuff met box sortables -->
	</div><!-- end of wrap -->

   <script type="text/javascript">
        // <![CDATA[
        jQuery('.postbox div.handlediv').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
        jQuery('.postbox h3').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
        jQuery('.postbox.close-me').each(function(){
        jQuery(this).addClass("closed");
        });
        //-->
    </script> <?php
	$debugmode = 1;

	if( $debugmode == 1 )
	{
		echo '<h2>Settings Array For Testing/Debugging</h2>';
		print "<pre>";
		print_r($yts);
		print "</pre>";			
	}
	
	$debugmode = 0;
	
	if( $debugmode == 1 )
	{
		echo '<h1>Debugging - All Current Variables</h1>';
		
		function getDefinedVars($varList, $excludeList)
		{
			$temp1 = array_values( array_diff( array_keys($varList), $excludeList ) );
			$temp2 = array();
			while (list($key, $value) = each($temp1)) 
			{
				global $$value;
				$temp2[$value] = $$value;
			}
			return $temp2;
		}
		
		$excludeList = array('');
		
		//get all variables defined in current scope
		$varList = get_defined_vars();
		
		//Time to call the function
		print "<pre>";
		print_r(getDefinedVars($varList, $excludeList));
		print "</pre>";
	}
}
?>
