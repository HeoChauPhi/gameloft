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
}

include_once('init/shortcode.php');