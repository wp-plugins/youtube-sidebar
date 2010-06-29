<?php yts_header('YouTube Sidebar - Tools');

yts_newadsensead();
yts_deleteadsensead();

$yts = get_option( 'yts_settings' );
?> 

<div class="postbox">
	<div class="handlediv" title="Click to toggle"><br /></div>
	<h3>Google AdSense</h3>
	<div class="inside">
	 <p>Manage your AdSense ads here. You can setup any number of ads, use none, one or all of them. You can target specific pages or posts
     with specific ads.</p>
            <p>Notice: AdSense does not display on a web page instantly, it may take serveral minutes.</p>

        <div class="postbox">
            <div class="handlediv" title="Click to toggle"><br /></div>
            <h3>New Ad</h3>
            <div class="inside">
             <form method="post" name="yts_adsense_newad_form" action="">            
                <textarea name="yts_adsensead" cols="60" rows="6"></textarea></label>
                <input class="button-primary" type="submit" name="yts_adsense_newad_submit" value="Save" />
              </form>
            </div>
        </div> 

        <div class="postbox">
            <div class="handlediv" title="Click to toggle"><br /></div>
            <h3>List Ads</h3>
            <div class="inside">
            <p>This list shows the default ads as submitted, not with the plugins custom ad syles.</p>
             <?php yts_adsense_list(); ?>
            </div>
        </div>
                
	</div>
</div>  

        
<?php yts_footer(); ?>
