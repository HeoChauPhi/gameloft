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
require_once('init/functions.php');

// Admin settings.
if(is_admin()) {
  $settings = new SocialPostSettingsPage();
  echo 'HeoChauA';
  
  // Auto reload page
  //add_action('wp_head','auto_reload_admin_page');
}

include_once('init/shortcode.php');
include_once('options/options.php');

function social_post_types() {
  register_post_type( 'facebook_post',
    array(
      'labels' => array(
        'name' => __( 'Facebook Post' ),
        'singular_name' => __( 'Facebook Post' )
      ),
      'supports' => array(
        'title',
        'editor'
      ),
      'public' => true,
      'has_archive' => true,
    )
  );

  register_post_type( 'twitter_post',
    array(
      'labels' => array(
        'name' => __( 'Twitter Post' ),
        'singular_name' => __( 'Twitter Post' )
      ),
      'supports' => array(
        'title',
        'editor'
      ),
      'public' => true,
      'has_archive' => true,
    )
  );

  register_post_type( 'youtube_post',
    array(
      'labels' => array(
        'name' => __( 'Youtube Post' ),
        'singular_name' => __( 'Youtube Post' )
      ),
      'supports' => array(
        'title',
        'editor'
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}
add_action( 'init', 'social_post_types' );