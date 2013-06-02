<?php
/**
 * Tabs menu loader - calls function for css only menu or jquery tabs menu
 * 
 * @param string $thepagekey this is the screen being visited
 */
function yts_createmenu($thepagekey){           
    $yts_guitheme = yts_get_theme();
    if($yts_guitheme == 'wordpresscss'){  
        yts_navigation_css($thepagekey);
    }elseif($yts_guitheme == 'jquery'){
        yts_navigation_jquery($thepagekey);    
    }elseif($yts_guitheme == 'nonav'){
        echo '<div id="yts_maintabs">';
    }
} 

/**
* Secondary navigation builder - CSS only
* @todo MEDIUMPRIORITY, move the css in function to a .css file, double check no duplicate styles throughout plugin, also replace the paths to the overlay image
* @param mixed $thepagekey
*/
function yts_navigation_css($thepagekey){    
    global $yts_is_activated,$yts_is_installed,$yts_mpt_arr;?>   
            
    <div id="yts_maintabs">
        
        <?php
        $pageslug = $yts_mpt_arr['menu'][$thepagekey]['slug'];

        // begin building menu - controlled by jQuery
        echo '<div id="yts_cssmenu">
        <ul>';
              
            // loop through tabs - held in menu pages tabs array
            foreach($yts_mpt_arr['menu'][$thepagekey]['tabs'] as $tab => $values){

                $tabslug = $yts_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['slug'];
                $tablabel = $yts_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['label'];   
                
                if(yts_menu_should_tab_be_displayed($thepagekey,$tab)){
                    
                    $active = '';
                    if(isset($_GET['youtubesidebartabnumber']) && $_GET['youtubesidebartabnumber'] == $tab){
                        $active = 'class="active"';
                    }
                    // default menu build approach
                    echo '<li '.$active.'><a href="'.yts_create_adminurl($pageslug,'').'&youtubesidebartabnumber='.$tab.'&youtubesidebarpagename='.$thepagekey.'">' . $tablabel . '</a></li>';                                
                
                } 
            }// for each
            
        echo '</ul></div>';
}

function yts_navigation_jquery($thepagekey){    
    global $yts_is_activated,$yts_is_installed,$yts_mpt_arr,$yts_projectslist_array;?>

    <script>
    $(function() {
         $( "#yts_maintabs" ).tabs({
            cookie: {
                // store cookie for a day, without, it would be a session cookie
                expires: 1
            },
            select: function(event, ui){
              window.location = ui.tab.href;
            }
        });       
    });
    </script>

    <div id="yts_maintabs">

        <?php 
        ##########################################################
        #                                                        #
        #          ADD HEADERS FIRST not currently in use        #
        #                                                        #
        ##########################################################
        if($yts_mpt_arr['menu'][$thepagekey]['headers'] == true){

            foreach($yts_mpt_arr['menu'][$thepagekey]['tabs'] as $tab => $values){

                $pageslug = $yts_mpt_arr['menu'][$thepagekey]['slug'];
                $tabslug = $yts_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['slug'];
                $tablabel = $yts_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['label'];   

                if( yts_menu_should_tab_be_displayed($thepagekey,$tab) ){
          
                }
            }
        }?>       
    
    <?php         
    // begin building menu - controlled by jQuery
    $menu = '';
    $menu .= '<ul>'; 
         
    // loop through tabs - held in menu pages tabs array 
    foreach($yts_mpt_arr['menu'][$thepagekey]['tabs'] as $tab=>$values){
                    
        $pageslug = $yts_mpt_arr['menu'][$thepagekey]['slug'];
        $tabslug = $yts_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['slug'];
        $tablabel = $yts_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['label'];   
                                           
        if( yts_menu_should_tab_be_displayed($thepagekey,$tab) ){
        
            // change label for first time users on
            if($thepagekey == 'projects' && !isset($yts_projectslist_array) || $thepagekey == 'projects' && !is_array($yts_projectslist_array)){
                $tablabel = 'Please create your first Post Creation Project...';
            }   
                            
            // default menu build approach
            $menu .= '<li><a href="#tabs-'.$tab.'">' . $tablabel . '</a></li>';                                
        } 
      
        // discontinue loop if no projects exist so that only the first screen is displayed
        if($thepagekey == 'projects' && !isset($yts_projectslist_array) || $thepagekey == 'projects' && !is_array($yts_projectslist_array)){
            break;
        }    
                            
    }// for each
    
    $menu .= '</ul>'; 
    echo $menu;
}       

/**
* Used to determine if a screen is meant to be displayed or not, based on package and settings 
*/
function yts_menu_should_tab_be_displayed($page,$tab){
    global $yts_mpt_arr,$yts_is_free,$yts_beta_mode;

    // if screen not active
    if(isset($yts_mpt_arr['menu'][$page]['tabs'][$tab]['active']) && $yts_mpt_arr['menu'][$page]['tabs'][$tab]['active'] == false){
        return false;
    }    
    
    // if screen is not active at all (used to disable a screen in all packages and configurations)
    if(isset($yts_mpt_arr['menu'][$page]['tabs'][$tab]['active']) && $yts_mpt_arr['menu'][$page]['tabs'][$tab]['active'] == false){
        return false;
    }
                 
    // display screen if the package not set, just to be safe as the package value should also be set if menu array installed properly
    if(!isset($yts_mpt_arr['menu'][$page]['tabs'][$tab]['package'])){      
        return true;
    }
                                      
    // dont allow beta mode screens to be displayed if plugin build is not in beta mode
    if($yts_mpt_arr['menu'][$page]['tabs'][$tab]['package'] == 'beta' && $yts_beta_mode == false){  
        return false;    
    }    
                
    // if package is free and screen is free return true
    if($yts_is_free && $yts_mpt_arr['menu'][$page]['tabs'][$tab]['package'] == 'free'){   
        return true;
    }
    
    if($yts_is_free && $yts_mpt_arr['menu'][$page]['tabs'][$tab]['package'] == 'paid'){   
        return false;
    }  
                 
    return true;      
}

/**
* Returns value for displaying or hiding a page based on edition (free or full).
* These is no point bypassing this. The pages hidden require PHP that is only provided with
* the full edition. You may be able to use the forms, but the data saved won't do anything or might
* cause problems.
* 
* @param mixed $package_allowed, 0=free 1=full/paid 2=dont ever display
* @returns boolean true if screen is to be shown else false
* 
* @deprecated
*/
function yts_page_show_hide($package_allowed = 0){
    global $yts_is_free;
    
    if($package_allowed == 2){
        return false;// do not display in any package   
    }elseif($yts_is_free && $package_allowed == 0){
        return true;     
    }elseif($yts_is_free && $package_allowed == 1){
        return false;// paid edition page only, not be displayed in free edition
    }
    return true;
} 
?>
