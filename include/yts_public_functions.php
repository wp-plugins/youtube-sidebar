<?php 
/**
* Simple Widget
* 1. Applies 1 video or 1 AdSense, nothing more and no options are applied
* 2. Good function for starting a new custom function rather than any other we plan to write
* 3. See yts_widget_advanced() for full abilities
* 
* @todo validate video, ensure we do have a valid video code then exit loop, right now more than one video can be displayed but multiple videos are for advanced function not this one
* 
* @param mixed $args
*/
function yts_widget_simple($args){
    global $yts_adm_set;
    
    if(is_single() || is_page() || is_singular()){
     
        // extracts before_widget,before_title,after_title,after_widget all required and cannot be deleted
        extract($args); 
        echo $before_widget . $before_title . ' Videos ' . $after_title;
        
        if ( have_posts() ){   
   
            $video_count = 0;
            $ad_count = 0;
            $combined_count = 0;
                    
            // loop through posts being viewed until we have enough videos
            while ( have_posts() ){
     
                // get the post data
                the_post();
                        
                // get youtube videos
                $video_codes = get_post_meta( get_the_ID(), 'youtubesidebar' );
                
                if( $video_codes ){
                    foreach( $video_codes as $youtubeid ){
                        
                        yts_video_object( $youtubeid );                        
                        
                        ++$video_count;
                        ++$combined_count;
                    }  
                }            

                // display adsense if no videos shown and it is active
                if( $video_count == 0  ){
                    
                    // get active ad id
                    $counter = 0;

                    foreach( $yts_adm_set['adsnippets'] as $key => $ad ){ 
 
                        echo $ad['snippet'];
         
                        ++$ad_count;
                        ++$combined_count;
                        
                        break; 
                    }                    
                }
            }
        }
        
        // display after widget
        echo $after_widget;
    }
}

/**
* Simple Widget
* 1. Applies 1 video or 1 AdSense, nothing more and no options are applied
* 2. Good function for starting a new custom function rather than any other we plan to write
* 3. See yts_widget_advanced() for full abilities
* 
* @todo validate video, ensure we do have a valid video code then exit loop, right now more than one video can be displayed but multiple videos are for advanced function not this one
* 
* @param mixed $args
*/
function yts_widget_advanced($args){
    global $yts_adm_set;
              
    if( is_single() || is_page() || is_singular() ){
     
        // extracts before_widget,before_title,after_title,after_widget all required and cannot be deleted
        extract($args); 
        echo $before_widget . $before_title . ' Videos ' . $after_title;
        
        if ( have_posts() ){   
   
            $video_count = 0;
            $ad_count = 0;
            $combined_count = 0;
                    
            // loop through posts being viewed until we have enough videos
            while ( have_posts() ){
     
                // get the post data
                the_post();
                        
                // get youtube videos
                $video_codes = get_post_meta( get_the_ID(), 'youtubesidebar' );
                
                if( $video_codes ){
                    foreach( $video_codes as $youtubeid ){
                        
                        $args = array();
                        $args['color'] = $yts_adm_set['videooptions']['color'];
                        $args['border'] = $yts_adm_set['videooptions']['border'];
                        $args['autoplay'] = $yts_adm_set['videooptions']['autoplay'];
                        $args['fullscreen'] = $yts_adm_set['videooptions']['fullscreen'];
                        yts_video_object( $youtubeid );                        
                        
                        ++$video_count;
                        ++$combined_count;
                    }  
                }  

                // display adsense if no videos shown and it is active
                if( $video_count == 0  ){
                    
                    // get active ad id
                    $counter = 0;

                    foreach( $yts_adm_set['adsnippets'] as $key => $ad ){ 
 
                        echo $ad['snippet'];
         
                        ++$ad_count;
                        ++$combined_count;
                        
                        break; 
                    }                    
                }
            }
        }
        
        // display after widget
        echo $after_widget;
    }
}

function yts_video_object($videoid, $args = array() ){  
        
    $args = array (
         'width' => '',
         'height' => '',
         'color' => '',
         'border' => '',
         'fullscreen' => 'true',
         'scriptaccess' => 'always',
    );

    extract( $args );
  
    echo '<object width="'.$width.'" height="'.$height.'">
    <param name="movie" value="http://www.youtube.com/v/'.$videoid.$color.$border.'"></param>
    <param name="allowFullScreen" value="'.$fullscreen.'"></param>
    <param name="allowscriptaccess" value="always"></param>
    <embed src="http://www.youtube.com/v/'.$videoid.$color.$border.'" type="application/x-shockwave-flash" 
    allowscriptaccess="always" allowfullscreen="'.$fullscreen.'" width="'.$width.'" height="'.$height.'"></embed>
    </object>';
}    

// register basic widget - makes it available for use in admin

/**
* Basic Widget
* 1. Options are not applied
* 2. Limited to one video or one ad
* 3. Acts as a good starting point to create new widgets
*/
function yts_basic_widget(){
    $widget_ops = array('classname' => 'ytswidgetbasic', 'description' => "Display one video or one ad with default options from video or ad sources" );
    wp_register_sidebar_widget('ytswidgetbasic', 'YouTube Sidebar: Basic', 'yts_widget_simple', $widget_ops);
}

/**
* Advanced Widget
* 1. Full Options applied
* 2. Multiple videos and/or ads
*/
function yts_advanced_widget(){
    $widget_ops = array('classname' => 'ytswidgetadvanced', 'description' => "Display multiple videos and/or ads with all options applied" );
    wp_register_sidebar_widget('ytswidgetadvanced', 'YouTube Sidebar: Advanced', 'yts_widget_advanced', $widget_ops);
}

/**
* Premium Widget
* @todo work in progress
*/
function yts_premium_widget(){
    $widget_ops = array('classname' => 'ytswidgetpremium', 'description' => "Statistic building, IP tracking and Smart Video Cycle" );
    wp_register_sidebar_widget('ytswidgetpremium', 'YouTube Sidebar: Premium', 'yts_widget_premium', $widget_ops);
}
?>