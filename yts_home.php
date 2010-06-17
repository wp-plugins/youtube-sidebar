<?php yts_header('Home Page');?>

    <div class="postbox closed">
        <div class="handlediv" title="Click to toggle"><br /></div>
        <h3>yts Widget</h3>
        <div class="inside">
         <p>First thing you need to do is get familiar with the settings available to you and configure Video Blog Builder's 
         video display settings to suit your blog. Activate AdSense, switch videos of for certain page types, you can switch your
         YouTube or BlipTV videos off seperate incase you stop using one of the services and more. Once your happy with the settings
         simply go to the widget administration page and put yts in one of your sidebars. More instructions will come later.</p>
        </div>
    </div>
    
    <div class="postbox closed">
        <div class="handlediv" title="Click to toggle"><br /></div>
        <h3>yts Auto-Blogging</h3>
        <div class="inside">
        To be confirmed
        </div>
    </div>
    
    <div class="postbox closed">
        <div class="handlediv" title="Click to toggle"><br /></div>
        <h3>Notifications</h3>
        <div class="inside">
         <?php
		 	yts_listnotifications('100','video-blog-builder/easy-csv-importer.php');
		 ?>
        </div>
    </div>
    
<?php yts_footer(); ?>
