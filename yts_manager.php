<?php yts_header('YouTube Sidebar -  Manager');

yts_addvideo_sidebar();
yts_addvideo_content();
yts_deletesidebarvideo();

$yts = get_option( 'yts_settings' );
?> 

<div class="postbox closed">
	<div class="handlediv" title="Click to toggle"><br /></div>
	<h3>Add Videos To Posts/Pages</h3>
	<div class="inside"> 
    <p>Select a post and enter your videos url to make it show in the sidebar or within the content of the selected post. Your customer settings
    for the video provider will be applied to all videos submitted.</p>
    <?php yts_postlist_addvideotosidebar( 50 ); ?>
	</div>
</div>  

<div class="postbox closed">
	<div class="handlediv" title="Click to toggle"><br /></div>
	<h3>Remove Sidebar Videos From Posts/Pages</h3>
	<div class="inside"> 
    <p>Posts listed here are those found with sidebar videos setup i.e. a video idea stored in the posts custom fields. You can 
    delete individual videos from posts, some posts may have many some maybe just have one. Posts with no videos will not be 
    displayed in this list.</p>
    <?php yts_postlist_sidebarvideos( 50 ); ?>
	</div>
</div>  

<?php yts_footer(); ?>
