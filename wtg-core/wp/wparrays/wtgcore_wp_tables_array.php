<?php
$yts_tables_array =  array();
// yts_log
$yts_tables_array['tables'][1]['name'] = 'yts_log';
$yts_tables_array['tables'][1]['required'] = false;// required for all installations or not (boolean)
$yts_tables_array['tables'][1]['usercreated'] = false;// if the table is created as a result of user actions rather than core installation put true
$yts_tables_array['tables'][1]['version'] = '6.9.6';// used to trigger updates
// yts_flag
$yts_tables_array['tables'][2]['name'] = 'yts_flag';
$yts_tables_array['tables'][2]['required'] = false;
$yts_tables_array['tables'][2]['usercreated'] = false;
$yts_tables_array['tables'][2]['version'] = '6.9.6';
?>