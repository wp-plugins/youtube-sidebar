<?php yts_header('Settings'); 

// processing functions
yts_saveglobalsettings();
yts_reinstallsettings();
yts_saveyoutubesettings();
yts_saveadsensettings();
	
// get options again before final output
$yts = get_option( 'yts_settings'); 
?>
<div class="postbox closed">
	<div class="handlediv" title="Click to toggle"><br /></div>
	<h3>Main Settings</h3>
	<div class="inside">
     <form method="post" name="yts_globalsettings_form" action="">                
        <a href="#" title="You can set the maximum area allowed for videos and ads. The plugin will avoid using up more than the allocated
        area. For example if you enter 500 for the heigh and your video size is set to 200, you can display 2 videos, not 3.">Maximum Sidebar Height</a>:
        <input type="text" name="yts_sidebarheight" value="<?php echo $yts['settings']['sidebarheight']; ?>" size="3" maxlength="3" />
        <br />        
        <a href="#" title="Set the maximum width for your sidebar, similiar to Maximum Sidebar Height but will actually resize all videos or ads
        to fit into your sidebar if their sizes are larger than this maximum width setting.">Maximum Sidebar Width</a>:
        <input type="text" name="yts_sidebarwidth" value="<?php echo $yts['settings']['sidebarwidth']; ?>" size="3" maxlength="3" />
        <br />        
        <a href="#" title="If a post or page has more videos connected to it than the number of videos set to display at any time time then
        rotation will avoid showing the same videos. For example if you associate 4 videos with a post and rotation is activated, 2 of the
        videos will be shown and then when refreshing the page the other 2 will be shown and it will continue like this.">Video Rotation</a>:
        <input type="text" name="yts_rotation" value="<?php echo $yts['settings']['rotation']; ?>" size="3" maxlength="3" />

        <input class="button-primary" type="submit" name="yts_globalsettings_submit" value="Save" />
      </form>
	</div>
</div> 

<div class="postbox closed">
    <div class="handlediv" title="Click to toggle"><br /></div>
    <h3>AdSense Settings</h3>
    <div class="inside">
    <p>Notice: AdSense does not display on a web page instantly, it may take serveral minutes.</p>
        <form method="post" name="yts_adsense_settings_form" action=""> 
     
            <a href="#" title="">Active Ad:</a>
            <select name="yts_active_adsense" size="1">
            	<?php yts_adsensemenu(); ?>
            </select>                     
            <br />           
             <a href="#" title="">Display AdSense On Home/Front Page:</a>
            <select name="yts_home_adsense" size="1">
                <option value="Yes" <?php yts_echoselected( $yts['adsense']['home'],'Yes' ); ?>>Yes</option>
                <option value="No" <?php yts_echoselected( $yts['adsense']['home'],'No' ); ?>>No</option>
            </select>                     
            <br />
            <a href="#" title="">Display AdSense On Single Pages:</a>
            <select name="yts_single_adsense" size="1">
                <option value="Yes" <?php yts_echoselected( $yts['adsense']['single'],'Yes' ); ?>>Yes</option>
                <option value="No" <?php yts_echoselected( $yts['adsense']['single'],'No' ); ?>>No</option>
            </select>                    
            <br />
            <a href="#" title="">Display AdSense On Single Pages:</a>
            <select name="yts_many_adsense" size="1">
                <option value="Yes" <?php yts_echoselected( $yts['adsense']['many'],'Yes' ); ?>>Yes</option>
                <option value="No" <?php yts_echoselected( $yts['adsense']['many'],'No' ); ?>>No</option>
            </select>         
            <br />               
            <input class="button-primary" type="submit" name="yts_adsense_settings_submit" value="Save" />
        </form>
    </div>
</div> 
             
<div class="postbox closed">
    <div class="handlediv" title="Click to toggle"><br /></div>
    <h3>YouTube Configuration</h3>
    <div class="inside">
     <form method="post" name="yts_youtube_form" action="">            
        				
            <br /><br /><br />
            <?php echo '<h4>Home/FrontPage YouTube Settings</h4>';?>
            
            <a href="#" title="">Maximum YouTube Videos</a>:
            <input type="text" name="yts_home_videos" value="<?php echo $yts['youtube']['styles']['home']['videos'];?>" size="3" maxlength="3" />
             <br />       
             <a href="#" title="">Allow Color:</a>
            <select name="yts_home_color" size="1">
                <option value="" <?php yts_echoselected( $yts['youtube']['styles']['home']['color'],'' ); ?>>Default</option>
                <option value="&color1=0x3a3a3a&color2=0x999999" <?php yts_echoselected( $yts['youtube']['styles']['home']['color'],'&color1=0x3a3a3a&color2=0x999999' ); ?>>Dark Grey &amp; Medium Grey</option>
                <option value="&color1=0x2b405b&color2=0x6b8ab6" <?php yts_echoselected( $yts['youtube']['styles']['home']['color'],'&color1=0x2b405b&color2=0x6b8ab6' ); ?>>Dark Blue &amp; Light Blue</option>
                <option value="&color1=0x006699&color2=0x54abd6" <?php yts_echoselected( $yts['youtube']['styles']['home']['color'],'&color1=0x006699&color2=0x54abd6' ); ?>>Dark Torq &amp; Light Torq</option>
                <option value="&color1=0x234900&color2=0x4e9e00" <?php yts_echoselected( $yts['youtube']['styles']['home']['color'],'&color1=0x234900&color2=0x4e9e00' ); ?>>Dark Green &amp; Light Green</option>
                <option value="&color1=0xe1600f&color2=0xfebd01" <?php yts_echoselected( $yts['youtube']['styles']['home']['color'],'&color1=0xe1600f&color2=0xfebd01' ); ?>>Dark Orange &amp; Light Orange</option>
                <option value="&color1=0xcc2550&color2=0xe87a9f" <?php yts_echoselected( $yts['youtube']['styles']['home']['color'],'&color1=0xcc2550&color2=0xe87a9f' ); ?>>Dark Pink &amp; Light Pink</option>
                <option value="&color1=0x402061&color2=0x9461ca" <?php yts_echoselected( $yts['youtube']['styles']['home']['color'],'&color1=0x402061&color2=0x9461ca' ); ?>>Dark Purple &amp; Light Purple</option>
                <option value="&color1=0x5d1719&color2=0xcd311b" <?php yts_echoselected( $yts['youtube']['styles']['home']['color'],'&color1=0x5d1719&color2=0xcd311b' ); ?>>Dark Red &amp; Light Red</option>
            </select>
            <br />              
             <a href="#" title="">Allow Border</a>
            <select name="yts_home_border" size="1">
                <option value="&border=1" <?php yts_echoselected( $yts['youtube']['styles']['home']['border'],'&border=1' ); ?>>Yes</option>
                <option value="&border=0" <?php yts_echoselected( $yts['youtube']['styles']['home']['border'],'&border=0' ); ?>>No</option>
            </select>
            <br />       
             <a href="#" title="">Allow Autoplay</a>
            <select name="yts_home_autoplay" size="1">
                <option value="Yes" <?php yts_echoselected( $yts['youtube']['styles']['home']['autoplay'],'Yes' ); ?>>Yes</option>
                <option value="No" <?php yts_echoselected( $yts['youtube']['styles']['home']['autoplay'],'No' ); ?>>No</option>
            </select>
            <br />       
             <a href="#" title="">Allow Fullscreen</a>
            <select name="yts_home_fullscreen" size="1">
                <option value="Yes" <?php yts_echoselected( $yts['youtube']['styles']['home']['fullscreen'],'Yes' ); ?>>Yes</option>
                <option value="No" <?php yts_echoselected( $yts['youtube']['styles']['home']['fullscreen'],'No' ); ?>>No</option>
            </select>
            <br />       
             <a href="#" title="">Allow scriptaccess Access</a>
            <select name="yts_home_scriptaccess" size="1">
                <option value="Yes" <?php yts_echoselected( $yts['youtube']['styles']['home']['scriptaccess'],'Yes' ); ?>>Yes</option>
                <option value="No" <?php yts_echoselected( $yts['youtube']['styles']['home']['scriptaccess'],'No' ); ?>>No</option>
            </select>
           
            <br /><br /><br />
            <?php echo '<h4>Apply Single Page YouTube Settings</h4>';?>
            
            <a href="#" title="">Maximum YouTube Videos</a>:
            <input type="text" name="yts_single_videos" value="<?php echo $yts['youtube']['styles']['single']['videos'];?>" size="3" maxlength="3" />
            <br />              
             <a href="#" title="">Allow Color:</a>
            <select name="yts_single_color" size="1">
                <option value="" <?php yts_echoselected( $yts['youtube']['styles']['single']['color'],'' ); ?>>Default</option>
                <option value="&color1=0x3a3a3a&color2=0x999999" <?php yts_echoselected( $yts['youtube']['styles']['single']['color'],'&color1=0x3a3a3a&color2=0x999999' ); ?>>Dark Grey &amp; Medium Grey</option>
                <option value="&color1=0x2b405b&color2=0x6b8ab6" <?php yts_echoselected( $yts['youtube']['styles']['single']['color'],'&color1=0x2b405b&color2=0x6b8ab6' ); ?>>Dark Blue &amp; Light Blue</option>
                <option value="&color1=0x006699&color2=0x54abd6" <?php yts_echoselected( $yts['youtube']['styles']['single']['color'],'&color1=0x006699&color2=0x54abd6' ); ?>>Dark Torq &amp; Light Torq</option>
                <option value="&color1=0x234900&color2=0x4e9e00" <?php yts_echoselected( $yts['youtube']['styles']['single']['color'],'&color1=0x234900&color2=0x4e9e00' ); ?>>Dark Green &amp; Light Green</option>
                <option value="&color1=0xe1600f&color2=0xfebd01" <?php yts_echoselected( $yts['youtube']['styles']['single']['color'],'&color1=0xe1600f&color2=0xfebd01' ); ?>>Dark Orange &amp; Light Orange</option>
                <option value="&color1=0xcc2550&color2=0xe87a9f" <?php yts_echoselected( $yts['youtube']['styles']['single']['color'],'&color1=0xcc2550&color2=0xe87a9f' ); ?>>Dark Pink &amp; Light Pink</option>
                <option value="&color1=0x402061&color2=0x9461ca" <?php yts_echoselected( $yts['youtube']['styles']['single']['color'],'&color1=0x402061&color2=0x9461ca' ); ?>>Dark Purple &amp; Light Purple</option>
                <option value="&color1=0x5d1719&color2=0xcd311b" <?php yts_echoselected( $yts['youtube']['styles']['single']['color'],'&color1=0x5d1719&color2=0xcd311b' ); ?>>Dark Red &amp; Light Red</option>
            </select>
            <br />              
             <a href="#" title="">Allow Border</a>
            <select name="yts_single_border" size="1">
                <option value="&border=1" <?php yts_echoselected( $yts['youtube']['styles']['single']['border'],'&border=1' ); ?>>Yes</option>
                <option value="&border=0" <?php yts_echoselected( $yts['youtube']['styles']['single']['border'],'&border=0' ); ?>>No</option>
            </select>
            <br />       
             <a href="#" title="">Allow Autoplay</a>
            <select name="yts_single_autoplay" size="1">
                <option value="Yes" <?php yts_echoselected( $yts['youtube']['styles']['single']['autoplay'],'Yes' ); ?>>Yes</option>
                <option value="No" <?php yts_echoselected( $yts['youtube']['styles']['single']['autoplay'],'No' ); ?>>No</option>
            </select>
            <br />       
             <a href="#" title="">Allow Fullscreen</a>
            <select name="yts_single_fullscreen" size="1">
                <option value="Yes" <?php yts_echoselected( $yts['youtube']['styles']['single']['fullscreen'],'Yes' ); ?>>Yes</option>
                <option value="No" <?php yts_echoselected( $yts['youtube']['styles']['single']['fullscreen'],'No' ); ?>>No</option>
            </select>
            <br />       
             <a href="#" title="">Allow scriptaccess Access</a>
            <select name="yts_single_scriptaccess" size="1">
                <option value="Yes" <?php yts_echoselected( $yts['youtube']['styles']['single']['scriptaccess'],'Yes' ); ?>>Yes</option>
                <option value="No" <?php yts_echoselected( $yts['youtube']['styles']['single']['scriptaccess'],'No' ); ?>>No</option>
            </select>
           
           <br /><br /><br />
            <?php echo '<h4>Apply Posts And Category YouTube Settings</h4>';?>
            
            <a href="#" title="">Maximum YouTube Videos</a>:
            <input type="text" name="yts_many_videos" value="<?php echo $yts['youtube']['styles']['many']['videos'];?>" size="3" maxlength="3" />
            <br />              
             <a href="#" title="">Allow Color:</a>
            <select name="yts_many_color" size="1">
                <option value="" <?php yts_echoselected( $yts['youtube']['styles']['many']['color'],'' ); ?>>Default</option>
                <option value="&color1=0x3a3a3a&color2=0x999999" <?php yts_echoselected( $yts['youtube']['styles']['many']['color'],'&color1=0x3a3a3a&color2=0x999999' ); ?>>Dark Grey &amp; Medium Grey</option>
                <option value="&color1=0x2b405b&color2=0x6b8ab6" <?php yts_echoselected( $yts['youtube']['styles']['many']['color'],'&color1=0x2b405b&color2=0x6b8ab6' ); ?>>Dark Blue &amp; Light Blue</option>
                <option value="&color1=0x006699&color2=0x54abd6" <?php yts_echoselected( $yts['youtube']['styles']['many']['color'],'&color1=0x006699&color2=0x54abd6' ); ?>>Dark Torq &amp; Light Torq</option>
                <option value="&color1=0x234900&color2=0x4e9e00" <?php yts_echoselected( $yts['youtube']['styles']['many']['color'],'&color1=0x234900&color2=0x4e9e00' ); ?>>Dark Green &amp; Light Green</option>
                <option value="&color1=0xe1600f&color2=0xfebd01" <?php yts_echoselected( $yts['youtube']['styles']['many']['color'],'&color1=0xe1600f&color2=0xfebd01' ); ?>>Dark Orange &amp; Light Orange</option>
                <option value="&color1=0xcc2550&color2=0xe87a9f" <?php yts_echoselected( $yts['youtube']['styles']['many']['color'],'&color1=0xcc2550&color2=0xe87a9f' ); ?>>Dark Pink &amp; Light Pink</option>
                <option value="&color1=0x402061&color2=0x9461ca" <?php yts_echoselected( $yts['youtube']['styles']['many']['color'],'&color1=0x402061&color2=0x9461ca' ); ?>>Dark Purple &amp; Light Purple</option>
                <option value="&color1=0x5d1719&color2=0xcd311b" <?php yts_echoselected( $yts['youtube']['styles']['many']['color'],'&color1=0x5d1719&color2=0xcd311b' ); ?>>Dark Red &amp; Light Red</option>
            </select>
            <br />              
             <a href="#" title="">Allow Border</a>
            <select name="yts_many_border" size="1">
                <option value="&border=1" <?php yts_echoselected( $yts['youtube']['styles']['many']['border'],'&border=1' ); ?>>Yes</option>
                <option value="&border=0" <?php yts_echoselected( $yts['youtube']['styles']['many']['border'],'&border=0' ); ?>>No</option>
            </select>
            <br />       
             <a href="#" title="">Allow Autoplay</a>
            <select name="yts_many_autoplay" size="1">
                <option value="Yes" <?php yts_echoselected( $yts['youtube']['styles']['many']['autoplay'],'Yes' ); ?>>Yes</option>
                <option value="No" <?php yts_echoselected( $yts['youtube']['styles']['many']['autoplay'],'No' ); ?>>No</option>
            </select>
            <br />       
             <a href="#" title="">Allow Fullscreen</a>
            <select name="yts_many_fullscreen" size="1">
                <option value="Yes" <?php yts_echoselected( $yts['youtube']['styles']['many']['fullscreen'],'Yes' ); ?>>Yes</option>
                <option value="No" <?php yts_echoselected( $yts['youtube']['styles']['many']['fullscreen'],'No' ); ?>>No</option>
            </select>
            <br />       
             <a href="#" title="">Allow scriptaccess Access</a>
            <select name="yts_many_scriptaccess" size="1">
                <option value="Yes" <?php yts_echoselected( $yts['youtube']['styles']['many']['scriptaccess'],'Yes' ); ?>>Yes</option>
                <option value="No" <?php yts_echoselected( $yts['youtube']['styles']['many']['scriptaccess'],'No' ); ?>>No</option>
            </select>

        <input class="button-primary" type="submit" name="yts_youtube_submit" value="Save" />
      </form>
    </div>
</div> 

<div class="postbox closed">
	<div class="handlediv" title="Click to toggle"><br /></div>
	<h3>Reset Plugin Settings</h3>
	<div class="inside">
	 <p>This will not only reset general settings but also delete data import and campaign history. It should never be used when you have
	 running campaigns as the action cannot be reversed.</p>
	 <form method="post" name="yts_reinstallsettings_form" action="">            
		  <input class="button-primary" type="submit" name="yts_reinstallsettings_submit" value="Reinstall Settings" />
	  </form>
	</div>
</div> 
        
<?php yts_footer(); ?>


