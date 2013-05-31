<?php
###############################################################
#                                                             #
#      SCHEDULE ARRAY - MUST BE INSTALLED AND RECORD USED     #
#                                                             #
###############################################################
$yts_schedule_array = array();
// history
$yts_schedule_array['history']['lastreturnreason'] = 'None';
$yts_schedule_array['history']['lasteventtime'] = time();
$yts_schedule_array['history']['lasteventtype'] = 'None';
$yts_schedule_array['history']['day_lastreset'] = time();
$yts_schedule_array['history']['hour_lastreset'] = time();
$yts_schedule_array['history']['hourcounter'] = 1;
$yts_schedule_array['history']['daycounter'] = 1;
$yts_schedule_array['history']['lasteventaction'] = 'None';
// times/days
$yts_schedule_array['days']['monday'] = true;
$yts_schedule_array['days']['tuesday'] = true;
$yts_schedule_array['days']['wednesday'] = true;
$yts_schedule_array['days']['thursday'] = true;
$yts_schedule_array['days']['friday'] = true;
$yts_schedule_array['days']['saturday'] = true;
$yts_schedule_array['days']['sunday'] = true;
// times/hours
$yts_schedule_array['hours'][0] = true;
$yts_schedule_array['hours'][1] = true;
$yts_schedule_array['hours'][2] = true;
$yts_schedule_array['hours'][3] = true;
$yts_schedule_array['hours'][4] = true;
$yts_schedule_array['hours'][5] = true;
$yts_schedule_array['hours'][6] = true;
$yts_schedule_array['hours'][7] = true;
$yts_schedule_array['hours'][8] = true;
$yts_schedule_array['hours'][9] = true;
$yts_schedule_array['hours'][10] = true;
$yts_schedule_array['hours'][11] = true;
$yts_schedule_array['hours'][12] = true;
$yts_schedule_array['hours'][13] = true;
$yts_schedule_array['hours'][14] = true;
$yts_schedule_array['hours'][15] = true;
$yts_schedule_array['hours'][16] = true;
$yts_schedule_array['hours'][17] = true;
$yts_schedule_array['hours'][18] = true;
$yts_schedule_array['hours'][19] = true;
$yts_schedule_array['hours'][20] = true;
$yts_schedule_array['hours'][21] = true;
$yts_schedule_array['hours'][22] = true;
$yts_schedule_array['hours'][23] = true;
// limits
$yts_schedule_array['limits']['hour'] = '1000';
$yts_schedule_array['limits']['day'] = '5000';
$yts_schedule_array['limits']['session'] = '300';
// event types (update yts_event_action() if adding more eventtypes)
$yts_schedule_array['eventtypes']['postcreation']['name'] = 'Post Creation'; 
$yts_schedule_array['eventtypes']['postcreation']['switch'] = 0;
$yts_schedule_array['eventtypes']['postupdate']['name'] = 'Post Update'; 
$yts_schedule_array['eventtypes']['postupdate']['switch'] = 1;
$yts_schedule_array['eventtypes']['dataimport']['name'] = 'Data Import';  
$yts_schedule_array['eventtypes']['dataimport']['switch'] = 0;
$yts_schedule_array['eventtypes']['dataupdate']['name'] = 'Data Update'; 
$yts_schedule_array['eventtypes']['dataupdate']['switch'] = 0;
$yts_schedule_array['eventtypes']['twittersend']['name'] = 'Twitter Send'; 
$yts_schedule_array['eventtypes']['twittersend']['switch'] = 0;
$yts_schedule_array['eventtypes']['twitterupdate']['name'] = 'Twitter Update'; 
$yts_schedule_array['eventtypes']['twitterupdate']['switch'] = 0;
$yts_schedule_array['eventtypes']['twitterget']['name'] = 'Twitter Get'; 
$yts_schedule_array['eventtypes']['twitterget']['switch'] = 0;   
?>