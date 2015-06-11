<?php
/**
* Used for testing/debugging. Dumps the giving __LINE__ with a string of text to help locate
* the use of the function if not removed. 
* 1. Does not print anything if debug_mode not on, this helps to keep the interface clean if these are left in functions 
* 
* @param mixed $line
* @param mixed $string
*/
function yts_line_dump($line,$string){
    global $yts_debug_mode;
    if($yts_debug_mode){
        print $string .' '. $line .'<br>';
    }
}
?>