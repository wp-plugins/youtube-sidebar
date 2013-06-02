<?php 
##############################################################################################
####                                                                                      ####
####                          WORDPRESS OPTIONS RECORD ARRAY                              ####
####                                                                                      ####
##############################################################################################

# TODO:HIGHPRIORITY, add all option records to the array and modify them on following rules
# 1. New value for value source i.e URL to file holding array
# 2. Value to indicate if option should be added on installation or not
# 3. Make use of the ['public'] value on the re-install screen but also change ['public'] 

$total_option_records = 0;// used to count total options and assign count to label
$yts_options_array = array();
++$total_option_records;
# is_installed, result of last installation status check
$yts_options_array['yts_is_installed']['datatype'] = 'boolean';// array,boolean,string etc
$yts_options_array['yts_is_installed']['purpose'] = 'Indicates result of last installation status check, should hold value true for normal operation else an element of installation is missing.';
$yts_options_array['yts_is_installed']['label'] = 'Option Record '.$total_option_records;
$yts_options_array['yts_is_installed']['name'] = 'Installation Switch';
$yts_options_array['yts_is_installed']['inputtype'] = 'hidden';
$yts_options_array['yts_is_installed']['defaultvalue'] = 'false';// NA if not applicable i.e. the default value is generated in the script
$yts_options_array['yts_is_installed']['public'] = 'false';// boolean, false indicates users are not to be made aware of this option because it is more for development use
$yts_options_array['yts_is_installed']['required'] = 'false';// some option arrays may be optional, if that is the case true will avoid installation status checks returning false
# is_installed, result of last installation status check
$yts_options_array['yts_was_installed']['datatype'] = 'boolean';// array,boolean,string etc
$yts_options_array['yts_was_installed']['purpose'] = 'Ins but not all.';
$yts_options_array['yts_was_installed']['label'] = 'Option Record '.$total_option_records;
$yts_options_array['yts_was_installed']['name'] = 'Installation Switch';
$yts_options_array['yts_was_installed']['inputtype'] = 'hidden';
$yts_options_array['yts_was_installed']['defaultvalue'] = 'false';// NA if not applicable i.e. the default value is generated in the script
$yts_options_array['yts_was_installed']['public'] = 'false';// boolean, false indicates users are not to be made aware of this option because it is more for development use
$yts_options_array['yts_was_installed']['required'] = 'false';// some option arrays may be optional, if that is the case true will avoid installation status checks returning false
# admin settings
++$total_option_records;
$yts_options_array['yts_adminset']['datatype'] = 'array';// array,boolean,string etc
$yts_options_array['yts_adminset']['purpose'] = 'Settings for the administrator/backend only. These settings effect things that are to do with the backend only. They configure manual actions, tools and operations triggered by backend use.';
$yts_options_array['yts_adminset']['label'] = 'Option Record '.$total_option_records;
$yts_options_array['yts_adminset']['name'] = 'Administration Settings';
$yts_options_array['yts_adminset']['inputtype'] = 'hidden';
$yts_options_array['yts_adminset']['defaultvalue'] = 'NA';// NA if not applicable i.e. the default value is generated in the script
$yts_options_array['yts_adminset']['public'] = 'true';// boolean, false indicates users are not to be made aware of this option because it is more for development use
$yts_options_array['yts_adminset']['required'] = 'true';// some option arrays may be optional, if that is the case true will avoid installation status checks returning false
# last known installed version, used to track the gap between old and new versions ($yts_currentversion)
++$total_option_records;
$yts_options_array['yts_installedversion']['datatype'] = 'string';
$yts_options_array['yts_installedversion']['purpose'] = 'Used to determine gap between old and new version.';
$yts_options_array['yts_installedversion']['label'] = 'Option Record '.$total_option_records;
$yts_options_array['yts_installedversion']['name'] = 'Latest Version';
$yts_options_array['yts_installedversion']['inputtype'] = 'hidden';
$yts_options_array['yts_installedversion']['defaultvalue'] = '0.0.0';
$yts_options_array['yts_installedversion']['public'] = 'false';
$yts_options_array['yts_installedversion']['required'] = 'true';
# installation date (time()), currently has no use other than knowing the last time user done a new installation
++$total_option_records;
$yts_options_array['yts_installeddate']['datatype'] = 'integer';
$yts_options_array['yts_installeddate']['purpose'] = 'Date last full installation was run';
$yts_options_array['yts_installeddate']['label'] = 'Option Record '.$total_option_records;
$yts_options_array['yts_installeddate']['name'] = 'Install Date';
$yts_options_array['yts_installeddate']['inputtype'] = 'hidden';
$yts_options_array['yts_installeddate']['defaultvalue'] = time();
$yts_options_array['yts_installeddate']['public'] = 'false';
$yts_options_array['yts_installeddate']['required'] = 'true';
# wordpress activation date (time()), only use is to determine when user first added plugin to Wordpress
++$total_option_records;
$yts_options_array['yts_activationdate']['datatype'] = 'integer';
$yts_options_array['yts_activationdate']['purpose'] = 'Date last full installation was run';
$yts_options_array['yts_activationdate']['label'] = 'Option Record '.$total_option_records;
$yts_options_array['yts_activationdate']['name'] = 'Install Date';
$yts_options_array['yts_activationdate']['inputtype'] = 'hidden';
$yts_options_array['yts_activationdate']['defaultvalue'] = time();
$yts_options_array['yts_activationdate']['public'] = 'false';
$yts_options_array['yts_activationdate']['required'] = 'true';   
?>
