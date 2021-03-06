<?php
/** 
 * WordPress close to core class and functions i.e. WP functions slightly adapted or
 * functions which take global WP values and change them before using them
 * 
 * @package Opus
 * @author Ryan Bayne   
 * @since 3.0.0
 * @version 1.0 
 */

// load in WordPress only
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

class YOUTUBESIDEBAR_WPCore {  
    /**
    * About
    * 
    * @author Ryan R. Bayne
    * @package YouTube Sidebar
    * @since 3.0.0
    * @version 1.0
    */
    public function capabilities() {
        global $wp_roles; 
        $capabilities_array = array();
        foreach( $wp_roles->roles as $role => $role_array ) { 
            $capabilities_array = array_merge( $capabilities_array, $role_array['capabilities'] );    
        }
        return $capabilities_array;
    }    
}
?>