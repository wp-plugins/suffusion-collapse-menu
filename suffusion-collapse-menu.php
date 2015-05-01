<?php
/* 
Plugin Name: Suffusion Collapse Menu
Version: 0.6
Plugin URI: http://drafie-design.nl
Description: This Plugin improve the look of menu loaded by Suffusion on mobile devices.
Based on Responsive Nav - Copyright (c) 2013 Viljami Salminen, http://viljamis.com/
Author: Ciprian Dracea (Drake)
Requires at least: 3.4
Tested up to: 4.2.1
Stable tag: 0.6
Licence:  GPLv2 or later. (http://www.gnu.org/licenses/gpl-2.0.html)
*/ 

//////////////////////////////////////////////////
//    REGISTER & ENQUEUE JAVASCRIPTS
//////////////////////////////////////////////////

function register_suf_collapse() {                          		// FUNCTION FOR REGISTER SCRIPT
   wp_register_script(                              		    	// REGISTER SCRIPT "suf_collapse"
     'suf_collapse',                                        		// REQUIRED: NAME FOR CUSTOM SCRIPT
      plugins_url('/includes/responsive-nav.min.js', __FILE__),
      array('jquery'),                              		    	// DEPENDENCY (jQuery)
      true                                         		        	// OPTIONAL: LOAD SCRIPT IN FOOTER
    );
}
add_action('init', 'register_suf_collapse');                		// ADD "suf_collapse" SCRIPT REGISTRATION

function enqueue_suf_collapse_scripts(){                        	// FUNCTION FOR ENQUEUE SCRIPT
  wp_enqueue_script('suf_collapse');                            	// ENQUEUE SCRIPT "suf_collapse"
}
add_action('wp_enqueue_scripts', 'enqueue_suf_collapse_scripts');   // ADD "suf_collapse" TO "WP_ENQUEUE_SCRIPTS" to not break the admin area

function register_navtrigger() {                         			// FUNCTION FOR REGISTER SCRIPT
   wp_register_script(                                				// REGISTER SCRIPT "navtrigger"
     'navtrigger',                                       			// REQUIRED: NAME FOR CUSTOM SCRIPT
      plugins_url('/includes/nav-collapse-trigger.js', __FILE__),
      array('jquery'),                                				// DEPENDENCY (jQuery)
      true                                           				// OPTIONAL: LOAD SCRIPT IN FOOTER
    );
}
add_action('wp_enqueue_scripts', 'register_navtrigger');       		// ADD "navtrigger" JAVA SCRIPT REGISTRATION

function enqueue_navtrigger(){                           			// FUNCTION FOR ENQUEUE SCRIPT
  wp_enqueue_script('navtrigger');                       			// ENQUEUE SCRIPT
}
add_action('wp_enqueue_scripts', 'enqueue_navtrigger',20);    		// ADD SCRIPT "navtrigger" TO "WP_ENQUEUE_SCRIPTS"

//////////////////////////////////////////////////
// LOADING DEFAULT STYLESHEET
//////////////////////////////////////////////////

function suf_collapse_styles() {                               		// FUNCTION FOR CUSTOM STYLE
    wp_register_style( 'suf_collapse_style',                   		// REGISTER CUSTOM STYLE
      plugins_url('/includes/responsive-nav.css', __FILE__)   		// GET STYLESHEET URL
);                                                	
  wp_enqueue_style( 'suf_collapse_style' );             			// ENQUEING STYLE
}
add_action('wp_enqueue_scripts', 'suf_collapse_styles');   			// ADD CUSTOM STYLE

// RETRIEVE SUFFUSION BREAKPOINTS
global $suf_responsive_stops, $suf_responsive_nav_switch, $suf_collapse_ret; 
$options=get_option('suffusion_options');
$suf_responsive_nav_switch = $options['suf_responsive_nav_switch'];
$suf_responsive_stops = $options['suf_responsive_stops'];
$suf_collapse_ret='';

// GENERATE CSS FOR EACH BREAKPOINT
function suffusion_get_collapse_width_css() {
global $suf_responsive_stops, $suf_responsive_nav_switch, $suf_collapse_ret;
	$stops = explode(',', $suf_responsive_stops);
	$nav_switch = 10000;
	$collapse_nav = '';
	$no_collapse ='';
	$collapse_nav .= "#nav a.nav-toggle, #nav ul.tinynavNaN, #nav ul.nav-collapse, #nav-top a.nav-toggle, #nav-top ul.tinynavNaN, #nav-top ul.nav-collapse {display: none;}\n";
	$no_collapse .= "#nav ul, #nav-top ul {display:inline-block !important;}\n";

	if ($suf_responsive_nav_switch == 'always') {
		$suf_collapse_ret .= '';
	}
	else if ($suf_responsive_nav_switch == 'never') {
		$suf_collapse_ret .= $no_collapse;
		$suf_collapse_ret .= $collapse_nav;
	}
	else  {
		$nav_switch = rtrim($suf_responsive_nav_switch, 'px');
	}
	
	foreach ($stops as $stop) {
	$n_stop = rtrim($stop, 'px');
	$stop=($n_stop+1).'px';
		$suf_collapse_ret .= "@media screen and (min-width: $stop) {";
		if ($n_stop >= $nav_switch) {
			$suf_collapse_ret .= $collapse_nav;
		}
		$suf_collapse_ret .= "}";
	}
	return $suf_collapse_ret;
}

// ADD CSS INTO HEAD SECTION
function add_collapse_breakpoints() {
echo '<style>'.suffusion_get_collapse_width_css().'</style>';
}
add_action('wp_head','add_collapse_breakpoints');