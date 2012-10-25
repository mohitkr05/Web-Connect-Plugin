<?php
/*
Plugin Name: Web Connect
Plugin URI: http://webconnect.co.in
Description: Web Connect Default Plugin
Version: 1.0
Author: Mohit Kumar
Author URI: http://kumarmohit.com
License: GPL2
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }
define( 'MYPLUGINNAME_PATH', plugin_dir_path(__FILE__) );
show_admin_bar( false );

// Use your own external URL logo link
function wpc_url_login(){
	return "http://webconnect.co.in/"; // your URL here


}
add_filter('login_headerurl', 'wpc_url_login');
add_action( 'admin_init', 'adjust_the_wp_menu' );
function adjust_the_wp_menu()
{
	remove_submenu_page( 'themes.php', 'theme-editor.php' );
        remove_submenu_page( 'themes.php', 'themes.php' );
remove_submenu_page( 'plugins.php', 'plugin-install.php' );
remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
remove_menu_page('link-manager.php');
		remove_menu_page('tools.php');	
remove_menu_page('plugins.php');	
remove_menu_page('users.php');	
remove_menu_page('options-general.php');	
remove_submenu_page( 'index.php', 'update-core.php' );
}

function remove_dashboard_widgets() {
    // Globalize the metaboxes array, this holds all the widgets for wp-admin

    global $wp_meta_boxes;
    //remove all default dashboard apps
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);



}

add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
 
function my_custom_dashboard_widgets() {
global $wp_meta_boxes;

wp_add_dashboard_widget('custom_help_widget', 'Web Connect Support', 'custom_dashboard_help');

}

function custom_dashboard_help() {
echo '<p>Welcome to your website powered by Web Connect! Need help? <a href="mailto:info@webconnect.co.in">Contact Us</a>.  
or <a href="http://webconnect.co.in" target="_blank">visit our website</a></p>';
}

// Hoook into the 'wp_dashboard_setup' action to register our function

add_action('wp_dashboard_setup', 'remove_dashboard_widgets');
//Add webconnect dashboard widget

//Remove update notifications
add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );

//Change posts name
// hook the translation filters
add_filter( 'gettext', 'change_post_to_article' );
add_filter( 'ngettext', 'change_post_to_article' );

function change_post_to_article( $translated ) {
$translated = str_ireplace( 'Post', 'Blog Post', $translated ); // ireplace is PHP5 only
return $translated;
}

// Do not display the admin bar
function wps_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('wporg');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
    $wp_admin_bar->remove_menu('feedback');
    $wp_admin_bar->remove_menu('view-site');
 $wp_admin_bar->remove_menu('updates');

}
add_action( 'wp_before_admin_bar_render', 'wps_admin_bar' );

//Custom colours

//Remove 
remove_action('wp_head', 'wp_generator');

// Custom WordPress Login Logo
function login_css() {
	wp_enqueue_style( 'login_css', plugins_url( 'login.css' , __FILE__ ));
}
add_action('login_head', 'login_css');

// Custom WordPress Footer
function remove_footer_admin () {
	echo '<strong>&copy; 2012 - <a href="http://webconnect.co.in">Web Connect Digital Services</a> - For Support please contact  - Support at <a href="mailto:info@webconnect.co.in">info@webconnect.co.in</a></strong>';
}
add_filter('admin_footer_text', 'remove_footer_admin');


