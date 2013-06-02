<?php
#################################################################
####                                                         ####
####            ADMIN ONLY SETTINGS ($yts_adm_set)      ####
####                                                         ####
################################################################# 

// install main admin settings option record
$yts_adm_set = array();
// interface
$yts_adm_set['interface']['forms']['dialog']['status'] = 'hide';
// encoding
$yts_adm_set['encoding']['type'] = 'utf8';
// admin user interface settings start
$yts_adm_set['ui_advancedinfo'] = false;// hide advanced user interface information by default
$yts_adm_set['ui_helpdialog_width'] = 800;
$yts_adm_set['ui_helpdialog_height'] = 500;
// log
$yts_adm_set['reporting']['uselog'] = 1;
$yts_adm_set['reporting']['loglimit'] = 1000;
// video options
$yts_adm_set['videooptions']['maximumvideos'] = 1;
$yts_adm_set['videooptions']['color'] = '&color1=0x2b405b&color2=0x6b8ab6';
$yts_adm_set['videooptions']['border'] = 'enable';
$yts_adm_set['videooptions']['autoplay'] = 'enable';
$yts_adm_set['videooptions']['fullscreen'] = 'enable';
$yts_adm_set['videooptions']['scriptaccess'] = 'always';
// ad options
$yts_adm_set['adoptions']['maximumads'] = 1;
// other
$yts_adm_set['ecq'] = array();
$yts_adm_set['chmod'] = '0750';
// ads - 250 x 250 example
$yts_adm_set['adsnippets'][0]['time'] = time();
$yts_adm_set['adsnippets'][0]['source'] = 'google';
$yts_adm_set['adsnippets'][0]['snippet'] = '<script type="text/javascript"><!--
google_ad_client = "ca-pub-4923567693678329";
/* YouTubeSidebar250250 */
google_ad_slot = "5814814678";
google_ad_width = 250;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';
// ads - 200 x 200 example
$yts_adm_set['adsnippets'][1]['time'] = time();
$yts_adm_set['adsnippets'][1]['source'] = 'google';
$yts_adm_set['adsnippets'][1]['snippet'] = '<script type="text/javascript"><!--
google_ad_client = "ca-pub-4923567693678329";
/* YouTubeSidebar200200 */
google_ad_slot = "7291547875";
google_ad_width = 200;
google_ad_height = 200;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';
// ads - 125 x 125 example
$yts_adm_set['adsnippets'][2]['time'] = time();
$yts_adm_set['adsnippets'][2]['source'] = 'google';
$yts_adm_set['adsnippets'][2]['snippet'] = '<script type="text/javascript"><!--
google_ad_client = "ca-pub-4923567693678329";
/* YouTubeSidebar125125 */
google_ad_slot = "8768281070";
google_ad_width = 125;
google_ad_height = 125;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';
?>


