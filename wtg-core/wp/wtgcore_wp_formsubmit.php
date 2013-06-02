<?php   
###########################################################
#                                                         #
#   CALLS REQUIRED FUNCTION TO PROCESS FORM SUBMISSION    #
#                                                         #
###########################################################
$cont = true;

if($cont){
    $cont = yts_form_installpackage(); 
    
    $cont = yts_form_savelogcriteria();
}
?>