<?php
function yts_adsensemenu()
{
	$yts = get_option( 'yts_settings' );
	
	if( !isset( $yts['adsense']['ads'] ) )
	{
		echo '<option value="TBC">No Ads Saved - Please Use Tools</option>';
	}
	else
	{	
		$counter = 0;

		foreach( $yts['adsense']['ads'] as $key=>$value )
		{ 
			echo '<option value="'.$value['adslot'].'" '.yts_echoselected( $yts['adsense']['adslot'],'Yes' ).'>'.$value['adslot'].' Width:'.$value['w'].' Height:'.$value['h'].'</option>';
		
			++$counter; 
		}	
	}
}
                
// lists post with sidebar videos only - also list videos under each post 
function yts_postlist_sidebarvideos( $limit )
{
	// begin building table
	$output = '
	<table class="widefat post fixed">
			<tr>
				<th width="50" scope="col">Post ID</th>
				<th width="250" scope="col">Post Title</th>
				<th scope="col"></th>
				<th scope="col"></th>
				<th scope="col"></th>
				<th scope="col"></th>
			</tr>';
	
	// check if paging has been clicked
    if (isset($_GET['product_page']))
	{
        $page = $_GET['product_page'];
    }
    else
    {
        $page = 1;
    }
	
	// calculate paging starting record
    $start = ( $page - 1 ) * $limit;

	global $wpdb;
	$tablename = $wpdb->prefix . "posts";
	
	// get records from pagings start and the per page limit passed to function
	$results = $wpdb->get_results("SELECT ID,post_title FROM $tablename ORDER BY ID DESC LIMIT $start, $limit", OBJECT);
	
    //get total rows
    $totalrows = $wpdb->get_var("SELECT COUNT(*) FROM $tablename;");
	
	// if records retrieved list them
	if ($results)
	{
		foreach ($results as $post)
		{
			$youtubevids = get_post_meta( $post->ID, 'youtubeid' );

			// if post meta with videos found for current post then add to list
			if( $youtubevids )
			{	
				// establish number of videos in total - use to build table row span
				$youtubecount = 0;
				
				if( $youtubevids )
				{
					foreach( $youtubevids as $youtube )
					{
						++$youtubecount;
					}
				}
				
				$totalvids = $youtubecount;	
				
				// build start of table - display post information
				$output .= '<tr>';
				$output .= '<td>'. $post->ID .'</td>';
				$output .= '<td><strong>'. $post->post_title .'</strong></td>';
				$output .= '<td><strong>Video Link</strong></td>';
				$output .= '<td><strong>Video ID</strong></td>';
				$output .= '<td><strong>Video Source</strong></td>';
				$output .= '<td><strong>Delete Video</strong></td>';
				$output .= '</tr>';			
				
				// start listing posts videos - count progress - if first apply table spans
				$vidslisted = 0;
								
				// list any youtube ads found
				if( $youtubevids )
				{
					foreach( $youtubevids as $youtube )
					{
						// if this is the first apply spans else apply normal row start
						if( $vidslisted == 0 )
						{
							$output .= '<tr> <td colspan="2" rowspan="'.$totalvids.'"></td>';
						}
						else
						{
							$output .= '<tr><td></td>';
						}
						
						$output .= '<td><a href="requires user setup'. $youtube .'" title="Open the video in a new window"  target="_blank">View Video</a></td>';
						$output .= '<td>'. $youtube .'</td>';
						$output .= '<td>YouTube</td>';
						$output .= '<td><a href="admin.php?page='. $_GET['page'] .'&vididdelete='. $youtube .'&postid='.$post->ID.'&vidtype=youtubeid" title="Delete this video">Delete</a></td>';
						$output .= '</tr>';	
						
						++$vidslisted;
					}
				}				
			}
		}
	}
	else
	{
	}

	$output .= '</table>';
    
    //Number of pages setup
	$pages = ceil($totalrows / $limit)+1;
    for($r = 1;$r<$pages;$r++) 
    {
        $output .= "<a href='admin.php?page=". $_GET['page'] ."&product_page=".$r."' class=\"button rbutton\">".$r."</a>&nbsp;";
    }
	
	// dislplay resulting list
    echo $output;
}

function yts_postlist_addvideotosidebar( $limit )
{
	// begin building table
	$output = '
	<table class="widefat post fixed">
			<tr>
				<th width="50" scope="col">Post ID</th>
				<th width="250" scope="col">Title</th>
				<th scope="col"></th>
			</tr>';
	
	// check if paging has been clicked
    if (isset($_GET['product_page']))
	{
        $page = $_GET['product_page'];
    }
    else
    {
        $page = 1;
    }
	
	// calculate paging starting record
    $start = ( $page - 1 ) * $limit;

	global $wpdb;
	$tablename = $wpdb->prefix . "posts";
	
	// get records from pagings start and the per page limit passed to function
	$results = $wpdb->get_results("SELECT ID,post_title FROM $tablename ORDER BY ID DESC LIMIT $start, $limit", OBJECT);
	
    //get total rows
    $totalrows = $wpdb->get_var("SELECT COUNT(*) FROM $tablename;");
	
	// if records retrieved list them
	if ($results)
	{
		foreach ($results as $record)
		{
			$output .= '<tr>';
			$output .= '<td>'. $record->ID .'</td>';
			$output .= '<td><strong>'. $record->post_title .'</strong></td>';
			$output .= '<td>
			
			<form method="post" name="yts_addvideo_postsidebar_form" action="">            
				<input name="yts_postid" type="hidden" value="'. $record->ID .'" />
                <input name="yts_videourl" type="text" size="50" maxlength="250" value="Enter URL Here" />
                <input class="button-primary" type="submit" name="yts_videotopost_sidebar" value="Sidebar" />
                <input class="button-primary" type="submit" name="yts_videotopost_content" value="Content" disabled="disabled" />
			</form>
			
			</td>';
			$output .= '</tr>';
		}
	}
	else
	{
	}

	$output .= '</table>';
    
    //Number of pages setup
	$pages = ceil($totalrows / $limit)+1;
    for($r = 1;$r<$pages;$r++) 
    {
        $output .= "<a href='admin.php?page=". $_GET['page'] ."&product_page=".$r."' class=\"button rbutton\">".$r."</a>&nbsp;";
    }
	
	// dislplay resulting list
    echo $output;
}
	
	
// displays list of adsense submitted by user	
function yts_adsense_list()
{
	$yts = get_option( 'yts_settings' );
	
	if( !isset( $yts['adsense']['ads'] ) )
	{
		echo '<strong>Notification Removed</strong><p>The plugin has delete the submitted notification.</p>';
	}
	else
	{
		echo '<table class="widefat post fixed">';

		echo '
		<tr>
			<td><strong>Array ID</strong></td>
			<td><strong>Ad Slot ID</strong></td>
			<td><strong>Width</strong></td>
			<td><strong>Height</strong></td>
			<td><strong>Delete</strong></td>
		</tr>';
	
		$counter = 0;

		foreach( $yts['adsense']['ads'] as $key=>$value )
		{ 
			echo '
			<tr>
				<td>'.$key.'</td>
				<td>'.$value['adslot'].'</td>
				<td>'.$value['w'].'</td>
				<td>'.$value['h'].'</td>
				<td><a href="admin.php?page=yts_tools&ytsdeleteadsense='.$value['adslot'].'" title="Delete this AdSense ad" class="button-primary">Delete</a></td>
			</tr>';

			++$counter; 
		}	
	}
	
	echo '</table>';
}

// creates a tabled list of nofications with links to action them
function yts_listnotifications( $nots, $page )
{
	$nots = get_option( 'yts_notifications' );
	
	// do any delete passed by url
	if( isset( $_GET['notiddelete'] ) && is_numeric( $_GET['notiddelete'] ) )
	{
		unset( $nots['notifications'][ $_GET['notiddelete'] ] );
		yts_message('<strong>Notification Removed</strong><p>The plugin has delete the submitted notification.</p>');
	}
	
	echo '<table class="widefat post fixed">';
		
	echo '
	<tr>
		<td><strong>CSV File</strong></td>
		<td><strong>Description</strong></td>
		<td><strong>PHP File</strong></td>
		<td><strong>PHP Line</strong></td>
		<td><strong>Delete</strong></td>
	</tr>';
	
	$counter = 0;
	
	if( isset( $nots['notifications'] ) )
	{
		foreach( $nots['notifications'] as $not=>$notifications )
		{
			//  $not  this gets the id i.e. [0]
			
			echo '
			<tr>
				<td>'.$notifications['csvfile'].'</td>
				<td>'.$notifications['message'].'</td>
				<td>'.$notifications['phpfile'].'</td>
				<td>'.$notifications['phpline'].'</td>
				<td><a href="admin.php?page='. $page .'&notiddelete='. $not .'" title="Delete this notification" class="button-primary">Delete</a></td>
			</tr>';
					
			++$counter; 
		
			if( $counter == $nots ){ break; }
		}				
	}
	
	if( $counter == 0 )
	{
		echo '<tr><td colspan="9">No notifications were found, this would indicate that no data import or post creation events have been running</td></tr>';
	}
	
	echo '</table>';
}
?>