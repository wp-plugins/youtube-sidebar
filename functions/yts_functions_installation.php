<?php
function yts_insert_pluginsettings()
{
	global $wpdb;
	
	$yts = array();
		
	// blog global conditions and settings - sidebar limits
	$yts['settings']['sidebarheight'] = 200;
	$yts['settings']['sidebarwidth'] = 200;
	$yts['settings']['rotation'] = 'No';// Yes allows rotation of many videos where only 1 displayed

	// home only video styles
	$yts['youtube']['styles']['home']['color'] = 'color1=0x006699&color2=0x54abd6';
	$yts['youtube']['styles']['home']['border'] = '&border=1';
	$yts['youtube']['styles']['home']['autoplay'] = 'No';
	$yts['youtube']['styles']['home']['fullscreen'] = 'Yes';
	$yts['youtube']['styles']['home']['scriptaccess'] = 'Yes';
	$yts['youtube']['styles']['home']['videos'] = 2;
	// single page only video styles
	$yts['youtube']['styles']['single']['color'] = 'color1=0x006699&color2=0x54abd6';
	$yts['youtube']['styles']['single']['border'] = '&border=1';
	$yts['youtube']['styles']['single']['autoplay'] = 'No';
	$yts['youtube']['styles']['single']['fullscreen'] = 'Yes';
	$yts['youtube']['styles']['single']['scriptaccess'] = 'Yes';
	$yts['youtube']['styles']['single']['videos'] = 2;
	// many posts/archive/category only video styles
	$yts['youtube']['styles']['many']['color'] = 'color1=0x006699&color2=0x54abd6';
	$yts['youtube']['styles']['many']['border'] = '&border=1';
	$yts['youtube']['styles']['many']['autoplay'] = 'No';
	$yts['youtube']['styles']['many']['fullscreen'] = 'Yes';
	$yts['youtube']['styles']['many']['scriptaccess'] = 'Yes';
	$yts['youtube']['styles']['many']['videos'] = 2;
		
	// adsense on and off per area - default is global switch, the rest is for area configuration
	$yts['adsense']['activead'] = '8656642919';
	$yts['adsense']['home'] = 'Yes';
	$yts['adsense']['single'] = 'Yes';
	$yts['adsense']['many'] = 'Yes';	

	// default Google AdSense - user will be able to add as much as they want with full customisation
	$yts['adsense']['ads'][0]['w'] = '125';
	$yts['adsense']['ads'][0]['h'] = '125';
	$yts['adsense']['ads'][0]['adslot'] = '0509601881';
	$yts['adsense']['ads'][0]['script'] = '<script type="text/javascript"><!--
				google_ad_client = "pub-4923567693678329";
				google_ad_slot = "0509601881";
				google_ad_width = 125;
				google_ad_height = 125;
				//--></script><script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>';
			
	$yts['adsense']['ads'][1]['w'] = '180';
	$yts['adsense']['ads'][1]['h'] = '150';
	$yts['adsense']['ads'][1]['adslot'] = '7693841311';
	$yts['adsense']['ads'][1]['script'] = '<script type="text/javascript"><!--
				google_ad_client = "pub-4923567693678329";
				google_ad_slot = "7693841311";
				google_ad_width = 180;
				google_ad_height = 150;
				//-->
				</script><script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>';	
	
	$yts['adsense']['ads'][2]['w'] = '200';
	$yts['adsense']['ads'][2]['h'] = '200';
	$yts['adsense']['ads'][2]['adslot'] = '8656642919';
	$yts['adsense']['ads'][2]['script'] = '<script type="text/javascript"><!--
				google_ad_client = "pub-4923567693678329";
				google_ad_slot = "8656642919";
				google_ad_width = 200;
				google_ad_height = 200;
				//-->
		        </script><script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>';
				
	$yts['adsense']['ads'][3]['w'] = '250';
	$yts['adsense']['ads'][3]['h'] = '250';
	$yts['adsense']['ads'][3]['adslot'] = '1660801882';
	$yts['adsense']['ads'][3]['script'] = '<script type="text/javascript"><!--
				google_ad_client = "pub-4923567693678329";
				google_ad_slot = "1660801882";
				google_ad_width = 250;
				google_ad_height = 250;
				//-->
				</script><script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>';	
	
	$yts['adsense']['ads'][4]['w'] = '300';
	$yts['adsense']['ads'][4]['h'] = '250';
	$yts['adsense']['ads'][4]['adslot'] = '7071012952';
	$yts['adsense']['ads'][4]['script'] = '<script type="text/javascript"><!--
				google_ad_client = "pub-4923567693678329";
				google_ad_slot = "7071012952";
				google_ad_width = 300;
				google_ad_height = 250;
				//-->
				</script><script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>';
		
	$yts['adsense']['ads'][5]['w'] = '336';
	$yts['adsense']['ads'][5]['h'] = '280';
	$yts['adsense']['ads'][5]['adslot'] = '6055085333';
	$yts['adsense']['ads'][5]['script'] = '<script type="text/javascript"><!--
				google_ad_client = "pub-4923567693678329";
				google_ad_slot = "6055085333";
				google_ad_width = 336;
				google_ad_height = 280;
				//-->
				</script><script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>';
	
	return add_option( 'yts_settings', $yts );	// will initially create option - then function can be used to reset
}
?>