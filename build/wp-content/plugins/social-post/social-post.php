<?php
/**
 * Plugin Name: Social Get Post
 * Plugin URI: http://heochaua.tk
 * Description: Get post from Social
 * Version: 1.0
 * Author: HeoChauA
 * Author URI: http://heochaua.tk
 * License: GPLv2
 */

include_once('init/social_post.admin.php');
require_once('init/social-posttype.php');
require_once('init/functions.php');

// Admin settings.
if(is_admin()) {
  $settings = new SocialPostSettingsPage();
}

include_once('init/shortcode.php');
include_once('options/options.php');

/* Runs when plugin is activated */
register_activation_hook(__FILE__, 'my_activation');
function my_activation() {
  if (! wp_next_scheduled ( 'my_hourly_event' )) {
    wp_schedule_event(time(), 'every_three_minutes', 'my_hourly_event');
  }
}
add_action('my_hourly_event', 'get_face_post');

/* Runs when plugin is deactivation */
register_deactivation_hook(__FILE__, 'my_deactivation');
function my_deactivation() {
  wp_clear_scheduled_hook('my_hourly_event');
}

/* Add Stylesheet and Scripts */
add_action('admin_init', 'social_post_plugin_scripts');
function social_post_plugin_scripts() {  
  wp_register_script('social-post-script', plugin_dir_url( __FILE__ ) . 'dist/js/scripts.js', array('jquery'), FALSE, '1.0.0', TRUE); // Custom scripts
  wp_enqueue_script('social-post-script'); // Enqueue it!
}