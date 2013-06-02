<?php
############################################################
#                                                          #
#      FORMS FOR USE IN WORDPRESS, WORDPRESS STYLING       #
#                                                          #
############################################################ 
/**
* Builds menu for selecting screen permission.
* 
* @todo LOWPRIORITY, currently uses multiselect drop down filter menu...
* consider changing to multiSelect selectables menu and adapting to allow multiple
* captabilities to be selected
* 
* @param mixed $yts_ARRAY_capabilities
* @param mixed $page_name
* @param mixed $key
* @param mixed $current
*/
function yts_FORM_menu_capabilities($yts_ARRAY_capabilities,$page_name,$key,$current){?>
    <select name="yts_capabilitiesmenu_<?php echo $page_name;?>_<?php echo $key;?>" id="yts_capabilitiesmenu_<?php echo $page_name;?>_<?php echo $key;?>" >
        <?php 
           foreach($yts_ARRAY_capabilities as $cap){
               $selected = '';
               if($cap == $current){
                   $selected = 'selected="selected"';
               }
               echo '<option value="'.$cap.'" '.$selected.'>'.$cap.'</option>';
           }
        ?>                                                                                                                     
    </select><?php
} 
?>
