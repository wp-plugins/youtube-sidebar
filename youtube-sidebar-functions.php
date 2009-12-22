<?php
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
		delete_option('youtubesidebar_spacereplace');
		delete_option('youtubesidebar_rotation');
		delete_option('youtubesidebar_adsense125x125');
		delete_option('youtubesidebar_adsense180x150');
		delete_option('youtubesidebar_adsense200x200');
		delete_option('youtubesidebar_adsense250x250');
		delete_option('youtubesidebar_adsense300x250');
		delete_option('youtubesidebar_adsense336x280');
		delete_option('youtubesidebar_scriptaccess');
	}
	
	add_option('youtubesidebar_debugmode',0);// 0 = off 1 = on
	add_option('youtubesidebar_height',200);// height of youtube video in sidebar
	add_option('youtubesidebar_width',200);// width of youtube video in sidebar
	add_option('youtubesidebar_fullscreen',1);// 1 = full screen mode allowed 0 = not allowed
	add_option('youtubesidebar_spacereplace',1);// makes google adsense replace empty video space
	add_option('youtubesidebar_rotation',1);// track visitor ip and rotate videos with ads
	add_option('youtubesidebar_adsense125x125',$ad125x125);// google adsense ad 125 x 125
	add_option('youtubesidebar_adsense180x150',$ad180x150);// google adsense ad 180x150
	add_option('youtubesidebar_adsense200x200',$ad200x200);// google adsense ad 200 x 200
	add_option('youtubesidebar_adsense250x250',$ad250x250);// google adsense ad 250 x 250
	add_option('youtubesidebar_adsense300x250',$ad300x250);// google adsense ad 300 x 250
	add_option('youtubesidebar_adsense336x280',$ad336x280);// google adsense ad 336 x 280
	add_option('youtubesidebar_scriptaccess',1);// 1 = allow script access to videos 0 = do not allow
}
?>