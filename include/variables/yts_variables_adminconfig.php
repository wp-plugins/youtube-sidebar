<?php
# TODO:LOWPRIORITY, Move everything from this file and remove use of it then delete file
#################################################################
####                                                         ####
####          WP OPTIONS - Updated 22/11/2011 By RB1         ####
####                                                         ####
################################################################# 
$yts_apisession_array = false;
           
#############################################
####                                     ####
####          SET ADMIN THEME            ####
####                                     ####
############################################# 
// set theme variable from users own setting, set default if it has not been saved.
$yts_guitheme = yts_option('yts_theme','get');
if(!is_string($yts_guitheme) || $yts_guitheme == null || $yts_guitheme == false){
    $yts_guitheme = 'jquery';// jquery|wordpresscss
}       

###############################################################
####                                                       ####
####             LOAD STORED PUBLIC SETTINGS               ####
####                                                       ####
###############################################################
# NOT YET IN USE
$yts_pub_set = array();
$yts_pub_set['automation'] = 0;// 0 = off, 1 = on (controls automated background scripts, not CRON just page load triggered) 
?>
