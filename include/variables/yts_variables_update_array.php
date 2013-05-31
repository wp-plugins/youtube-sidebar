<?php
##############################################################
#                                                            #
#                      PLUGINS UPDATE ARRAY                  #
#                                                            #
##############################################################
# The values in this array can be used to create a summary
# of changes to be made during the plugin update process 
$yts_upgrade_array = array();

/*  MOVE OLD UPDATES TO HERE TO KEEP UPDATE HISTORY
######################
#   Version 6.8.8    #  Added 27th February 2013
######################
$yts_upgrade_array['6.8.8']['warning'] = 'No special warning.';
// change 0 
$yts_upgrade_array['6.8.8']['changes'][0]['function'] = 'yts_INSTALL_tabmenu_settings';// the method we will process the update: function
$yts_upgrade_array['6.8.8']['changes'][0]['title'] = 'Plugin Menu Settings';// short name to refer to what is being upgraded
$yts_upgrade_array['6.8.8']['changes'][0]['description'] = 'Initializes new theme related setting';    
$yts_upgrade_array['6.8.8']['changes'][0]['type'] = 'optionrecord';// optionrecord, replacefile, addfile, deletefile, modifyfile, creatable, altertable, deletetable, editrecord, addrecord, deleterecord
$yts_upgrade_array['6.8.8']['changes'][0]['name'] = 'yts_adminset';// specific name of file or the key for option record
$yts_upgrade_array['6.8.8']['changes'][0]['loc'] = 'wp_options';// file path or database table name
$yts_upgrade_array['6.8.8']['changes'][0]['backup'] = false;// does the existing record,file or table need backed up?
$yts_upgrade_array['6.8.8']['changes'][0]['element'] = 'record';// file,record,table    
$yts_upgrade_array['6.8.8']['changes'][0]['method'] = 'function';// the method we will process the update: function
$yts_upgrade_array['6.8.8']['changes'][0]['package'] = 'free';// free,paid - use free to display and apply for all installations else hide a change from free users by using paid
######################
#   Version 6.8.6    #  Added 27th February 2013
######################
$yts_upgrade_array['6.8.6']['warning'] = 'No special warning.';
// change 0 
$yts_upgrade_array['6.8.6']['changes'][0]['function'] = 'yts_INSTALL_tabmenu_settings';// the method we will process the update: function
$yts_upgrade_array['6.8.6']['changes'][0]['title'] = 'Plugin Menu Settings';// short name to refer to what is being upgraded
$yts_upgrade_array['6.8.6']['changes'][0]['description'] = 'The plugins tab menu is created using an array of settings. The array has been changed in a way that requires a new installation of the entire array. This will reverse any menu configuration you have done i.e. if you hid selected screens they may now appear again. Sorry for the inconvenience';    
$yts_upgrade_array['6.8.6']['changes'][0]['type'] = 'optionrecord';// optionrecord, replacefile, addfile, deletefile, modifyfile, creatable, altertable, deletetable, editrecord, addrecord, deleterecord
$yts_upgrade_array['6.8.6']['changes'][0]['name'] = 'yts_tabmenu';// specific name of file or the key for option record
$yts_upgrade_array['6.8.6']['changes'][0]['loc'] = 'wp_options';// file path or database table name
$yts_upgrade_array['6.8.6']['changes'][0]['backup'] = false;// does the existing record,file or table need backed up?
$yts_upgrade_array['6.8.6']['changes'][0]['element'] = 'record';// file,record,table    
$yts_upgrade_array['6.8.6']['changes'][0]['method'] = 'function';// the method we will process the update: function
$yts_upgrade_array['6.8.6']['changes'][0]['package'] = 'free';// free,paid - use free to display and apply for all installations else hide a change from free users by using paid
######################
#   Version 6.8.4    #  Added around 1st February 2013
######################
$yts_upgrade_array['6.8.4']['warning'] = 'No special warning.';
// change 0
$yts_upgrade_array['6.8.4']['changes'][0]['package'] = 'free';// free,paid - use free to display and apply for all installations else hide a change from free users by using paid   
$yts_upgrade_array['6.8.4']['changes'][0]['type'] = 'optionrecord';// optionrecord, replacefile, addfile, deletefile, modifyfile, creatable, altertable, deletetable, editrecord, addrecord, deleterecord
$yts_upgrade_array['6.8.4']['changes'][0]['name'] = 'yts_tabmenu';// specific name of file or the key for option record
$yts_upgrade_array['6.8.4']['changes'][0]['loc'] = 'wp_options';// file path or database table name
$yts_upgrade_array['6.8.4']['changes'][0]['backup'] = false;// does the existing record,file or table need backed up?
$yts_upgrade_array['6.8.4']['changes'][0]['element'] = 'record';// file,record,table    
$yts_upgrade_array['6.8.4']['changes'][0]['method'] = 'function';// the method we will process the update: function
$yts_upgrade_array['6.8.4']['changes'][0]['function'] = 'yts_INSTALL_tabmenu_settings';// the method we will process the update: function
$yts_upgrade_array['6.8.4']['changes'][0]['title'] = 'Plugin Menu Settings';// short name to refer to what is being upgraded
$yts_upgrade_array['6.8.4']['changes'][0]['description'] = 'The plugins tab menu is created using an array of settings. The array has been changed in a way that requires a new installation of the entire array. This will reverse any menu configuration you have done i.e. if you hid selected screens they may now appear again. Sorry for the inconvenience'; 
######################
#   Version 6.7.4    #  Added around 1st January 2013
######################
$yts_upgrade_array['6.7.4']['warning'] = 'This version delivers this new installation related system for updating the plugins installation status so that it suits changes in the latest version. Please do not rely on it for this plugin update. Please backup your database if your blog has YouTube Sidebar projects.';
// change 0
$yts_upgrade_array['6.7.4']['changes'][0]['package'] = 'free';// free,paid - use free to display and apply for all installations else hide a change from free users by using paid   
$yts_upgrade_array['6.7.4']['changes'][0]['type'] = 'optionrecord';// optionrecord, replacefile, addfile, deletefile, modifyfile, creatable, altertable, deletetable, editrecord, addrecord, deleterecord
$yts_upgrade_array['6.7.4']['changes'][0]['name'] = 'yts_tabmenu';// specific name of file or the key for option record
$yts_upgrade_array['6.7.4']['changes'][0]['loc'] = 'wp_options';// file path or database table name
$yts_upgrade_array['6.7.4']['changes'][0]['backup'] = false;// does the existing record,file or table need backed up?
$yts_upgrade_array['6.7.4']['changes'][0]['element'] = 'record';// file,record,table    
$yts_upgrade_array['6.7.4']['changes'][0]['method'] = 'function';// the method we will process the update: function
$yts_upgrade_array['6.7.4']['changes'][0]['function'] = 'yts_INSTALL_tabmenu_settings';// the method we will process the update: function
$yts_upgrade_array['6.7.4']['changes'][0]['title'] = 'Plugin Menu Settings';// short name to refer to what is being upgraded
$yts_upgrade_array['6.7.4']['changes'][0]['description'] = 'The plugins tab menu is created using an array of settings. The structure of the array has been changed. This version expects the new array structure when building the menu and so an update must be done. This will reverse any menu configuration you have done i.e. if you hid selected screens they may now appear again. Sorry for the inconvenience'; 
// change 1
$yts_upgrade_array['6.7.4']['changes'][1]['package'] = 'free';// free,paid - use free to display and apply for all installations else hide a change from free users by using paid   
$yts_upgrade_array['6.7.4']['changes'][1]['type'] = 'optionrecord';// optionrecord, replacefile, addfile, deletefile, modifyfile, creatable, altertable, deletetable, editrecord, addrecord, deleterecord
$yts_upgrade_array['6.7.4']['changes'][1]['name'] = 'yts_adminset';// specific name of file or the key for option record
$yts_upgrade_array['6.7.4']['changes'][1]['loc'] = 'wp_options';// file path or database table name
$yts_upgrade_array['6.7.4']['changes'][1]['backup'] = false;// does the existing record,file or table need backed up?
$yts_upgrade_array['6.7.4']['changes'][1]['element'] = 'record';// file,record,table    
$yts_upgrade_array['6.7.4']['changes'][1]['method'] = 'function';// the method we will process the update: function
$yts_upgrade_array['6.7.4']['changes'][1]['function'] = 'yts_INSTALL_admin_settings';// the method we will process the update: function
$yts_upgrade_array['6.7.4']['changes'][1]['title'] = 'Plugins General Settings';// short name to refer to what is being upgraded
$yts_upgrade_array['6.7.4']['changes'][1]['description'] = 'This will re-install the plugins general settings, mostly administration related at this time. Some settings are global settings related to data import or post creation and so there may be a change to current projects. Please review your settings and proejcts after this update.'; 
*/
    
/**
* Old entries can be removed after some months if this array becomes very large
*/
?>