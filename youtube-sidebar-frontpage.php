<h1>YouTube Sidebar - Home</h1>
<div id="poststuff" class="metabox-holder">
    <div id="post-body">
    
        <div id="post-body-content">
          <div class="postbox">
            
            <h3 class='hndle'><span>Support</span></h3>
            <ul>
              <li><a href="mailto:webmaster@webtechglobal.co.uk" title="Email for help on this plugin" target="_blank">Email</a>&nbsp;-  If you can't find answers on my website please email me.</li>
              <li><a href="http://forum.webtechglobal.co.uk/viewforum.php?f=36" title="Go to the WTG forum for support" target="_blank">Forum</a>&nbsp;- Central forum for all WebTechGlobal services and products.</li>
            </ul>
          </div>                    
        </div>
        
        <div id="post-body-content">
          <div class="postbox">
            
            <h3 class='hndle'><span>News</span></h3>
            
            <iframe name="FRAME2" src="http://www.webtechglobal.co.uk/public_includes/wtg_plugins.php" width="100%" height="300" frameborder="1" ></iframe> 
          </div>                    
        </div>

            
			<?php
            function csv2post_checkboxstatus1($v)
            {	// echo opposite value to current value
                if($v == 0){echo 1;}else{echo 1;}
            }
            
            function csv2post_checkboxstatus2($v)
            {	// echo checked or don't
                if($v == 0){}else{echo 'checked';}
            }
            ?>
            
            <form method="post" action="options.php" class="form-table">
            
                 <?php wp_nonce_field('update-options'); ?>
            
                <div class="wrap">
                    <div id="poststuff" class="meta-box-sortables" style="position: relative; margin-top:10px;">
                        <div class="postbox closed">
                            <div class="handlediv" title="Click to toggle"><br /></div>
                             <h3>Video Configuration </h3>
                                <div class="inside">
                                
                                    <p><a href="#" title="This will set the height of your video and indicate the height of the required ad when no video exists.">Object Height</a>:
                                    <input type="text" name="youtubesidebar_height" value="<?php echo get_option('youtubesidebar_height'); ?>" size="3" maxlength="3" /></p>
                
                                    <p><a href="#" title="This will set the width of your video and indicate the width of the required ad when no video exists">Object Width</a>:
                                    <input type="text" name="youtubesidebar_width" value="<?php echo get_option('youtubesidebar_width'); ?>" size="3" maxlength="3" /></p>
                                    
                                    <p><a href="#" title="Switch your YouTube videos full screen mode on by ticking the box">Full Screen Mode</a>:
                                    <input name="youtubesidebar_fullscreen" type="checkbox" value="<?php csv2post_checkboxstatus1(get_option('youtubesidebar_fullscreen')); ?>" <?php csv2post_checkboxstatus2(get_option('youtubesidebar_fullscreen')); ?> /></p>
                                    
                                    <p><a href="#" title="Tick to allow script access to YouTube videos on your blog">Allow Script Access</a>:
                                    <input name="youtubesidebar_scriptaccess" type="checkbox" value="<?php csv2post_checkboxstatus1(get_option('youtubesidebar_scriptaccess')); ?>" <?php csv2post_checkboxstatus2(get_option('youtubesidebar_scriptaccess')); ?> /></p>
                 
                                    <p><a href="#" title="Put a tick in the box if you want videos to automatically play when the page is loaded.">Autoplay Videos</a>:
                                    <input name="youtubesidebar_autoplay" type="checkbox" value="<?php csv2post_checkboxstatus1(get_option('youtubesidebar_autoplay')); ?>" <?php csv2post_checkboxstatus2(get_option('youtubesidebar_autoplay')); ?> /></p>
            
                                    <p class="submit"><input type="submit" class="button-primary" value="Save Changes" /></p>
            
                                </div>
                            </div>
                                   
                        <div class="postbox closed">
                            <div class="handlediv" title="Click to toggle"><br /></div>
                             <h3>Sidebar Configuration </h3>
                                <div class="inside">
                                
                                    <p><a href="#" title="Enter the number of videos you would like to display on a single post or page sidebar. Enter zero to display no videos. AdSense will be displayed by default if activated in the AdSense options.">Maximum Single Post/Page Videos</a>:
                                    <input type="text" name="youtubesidebar_singlepagevideos" value="<?php echo get_option('youtubesidebar_singlepagevideos'); ?>" size="3" maxlength="3" /></p>
                                    
                                    <p><a href="#" title="Enter the number of videos you would like to display on your front page/home sidebar. Enter zero to display no videos. AdSense will be displayed by default if activated in the AdSense options.">Maximum Front Page Videos</a>:
                                    <input type="text" name="youtubesidebar_frontpagevideos" value="<?php echo get_option('youtubesidebar_frontpagevideos'); ?>" size="3" maxlength="3" /></p>
                                    
                                    <p><a href="#" title="Enter the number of videos you would like to display on a category/archive page sidebar. Enter zero to display no videos. AdSense will be displayed by default if activated in the AdSense options.">Maximum Category Page Videos</a>:
                                    <input type="text" name="youtubesidebar_categorypagevideos" value="<?php echo get_option('youtubesidebar_categorypagevideos'); ?>" size="3" maxlength="3" /></p>
                
                                    <p class="submit"><input type="submit" class="button-primary" value="Save Changes" /></p>
            
                                </div>
                            </div>
                                            
                            
                        <div class="postbox closed">
                            <div class="handlediv" title="Click to toggle"><br /></div>
                             <h3>Google AdSense Setup </h3>
                          <div class="inside">
                
                            <p><a href="#" title="Tick the box to display adsense on category pages or leave unchecked if you do not want video space to be replaced with ads when there are no videos for a post.">AdSense For Category Pages</a>:
                            <input name="youtubesidebar_adsensecategoryonoff" type="checkbox" value="<?php csv2post_checkboxstatus1(get_option('youtubesidebar_adsensecategoryonoff')); ?>" <?php csv2post_checkboxstatus2(get_option('youtubesidebar_adsensecategoryonoff')); ?> /></p>
            
                            <p><a href="#" title="Tick the box to display adsense on single posts/pages or leave unchecked if you do not want video space to be replaced with ads when there are no videos for a post.">AdSense For Single Pages</a>:
                            <input name="youtubesidebar_adsensesingleonoff" type="checkbox" value="<?php csv2post_checkboxstatus1(get_option('youtubesidebar_adsensesingleonoff')); ?>" <?php csv2post_checkboxstatus2(get_option('youtubesidebar_adsensesingleonoff')); ?> /></p>
            
                            <p><a href="#" title="Tick the box to display adsense on the front page or leave unchecked if you do not want video space to be replaced with ads when there are no videos for a post.">AdSense For Front Page</a>:
                            <input name="youtubesidebar_adsensefrontpageonoff" type="checkbox" value="<?php csv2post_checkboxstatus1(get_option('youtubesidebar_adsensefrontpageonoff')); ?>" <?php csv2post_checkboxstatus2(get_option('youtubesidebar_adsensefrontpageonoff')); ?> /></p>
                
                
                            <p><a href="#" title="Tick to track visitor IP address and rotate videos with Google AdSense.">Rotation</a>:
                                    <input name="youtubesidebar_rotation" type="checkbox" value="<?php csv2post_checkboxstatus1(get_option('youtubesidebar_rotation')); ?>" <?php csv2post_checkboxstatus2(get_option('youtubesidebar_rotation')); ?> /></p>
                            <p>&nbsp;</p>
                                    
                                    <label><strong>125 x 125</strong>
                                      <br />
                                    <textarea name="youtubesidebar_adsense125x125" cols="60" rows="6"><?php echo get_option('youtubesidebar_adsense125x125');?></textarea></label>                    
                                    <br />
                                    <label><strong>180 x 150<br />
                                    </strong>
                                    <textarea name="youtubesidebar_adsense180x150" cols="60" rows="6"><?php echo get_option('youtubesidebar_adsense180x150');?></textarea></label>                    
                                    <br />
                                    <label><strong>200 x 200<br />
                                    </strong>
                                    <textarea name="youtubesidebar_adsense200x200" cols="60" rows="6"><?php echo get_option('youtubesidebar_adsense200x200');?></textarea></label>                    
                                    <br />
                                    <label><strong>250 x 250<br />
                                    </strong>
                                    <textarea name="youtubesidebar_adsense250x250" cols="60" rows="6"><?php echo get_option('youtubesidebar_adsense250x250');?></textarea></label>                    
                                    <br />
                                    <label><strong>300 x 250<br />
                                    </strong>
                                    <textarea name="youtubesidebar_adsense300x250" cols="60" rows="6"><?php echo get_option('youtubesidebar_adsense300x250');?></textarea></label>                    
                                    <br />
                                    <label><strong>336 x 280<br />
                                    </strong>
                                    <textarea name="youtubesidebar_adsense336x280" cols="60" rows="6"><?php echo get_option('youtubesidebar_adsense336x280');?></textarea></label>                    
                                    
                                    <p class="submit"><input type="submit" class="button-primary" value="Save Changes" /></p>
                           </div>
                        </div>
                    </div>        
                </div>
                      
                <input type="hidden" name="action" value="update" />    
                
                <input type="hidden" name="page_options" value="
                csv2post_debugmode,
                youtubesidebar_height,
                youtubesidebar_width,
                youtubesidebar_fullscreen,
                youtubesidebar_scriptaccess,
                youtubesidebar_rotation,
                youtubesidebar_adsense125x125,
                youtubesidebar_adsense180x150,
                youtubesidebar_adsense200x200,
                youtubesidebar_adsense250x250,
                youtubesidebar_adsense300x250,
                youtubesidebar_adsense336x280,
                youtubesidebar_autoplay,
                youtubesidebar_singlepagevideos,
                youtubesidebar_frontpagevideos,
                youtubesidebar_categorypagevideos,
                youtubesidebar_adsensecategoryonoff,
                youtubesidebar_adsensesingleonoff,
                youtubesidebar_adsensefrontpageonoff
                " />       
                 
            </form>
            
            <script type="text/javascript">
                // <![CDATA[
                jQuery('.postbox div.handlediv').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
                jQuery('.postbox h3').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
                jQuery('.postbox.close-me').each(function(){
                jQuery(this).addClass("closed");
                });
                //-->
            </script>
    </div>
</div>   