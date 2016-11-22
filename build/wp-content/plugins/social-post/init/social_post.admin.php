<?php
/**
 * Admin settings page.
 */

class SocialPostSettingsPage {
  /**
  * Holds the values to be used in the fields callbacks
  */
  private $options;

  /**
  * Start up
  */
  public function __construct() {
    add_action('admin_menu', array($this, 'add_plugin_page' ));
    add_action('admin_init', array($this, 'page_init'));
  }

  /**
  * Add options page
  */
  public function add_plugin_page() {
    // This page will be under "Settings"
    add_options_page(
      'Social Post Settings',
      'Social Post',
      'manage_options',
      'social-post-setting-admin',
      array($this, 'create_admin_page')
    );
  }

  /**
  * Options page callback
  */
  public function create_admin_page() {
    // Set class property
    $this->options = get_option('social_post_board_settings');

    ?>
    <div class="wrap">
      <h1>Social Post Settings</h1>
      <form method="post" action="options.php">
      <?php
        // This prints out all hidden setting fields
        settings_fields('social_post_option_config');
        do_settings_sections('social-post-setting-admin');
        submit_button();
      ?>
      </form>
    </div>
    <?php
  }

  /**
  * Register and add settings
  */
  public function page_init() {
    register_setting('social_post_option_config', 'social_post_board_settings');

    // Facebook Account
    add_settings_section(
      'facebook_section_id', // ID
      'Facebook Account', // Title
      array( $this, 'print_section_info' ), // Callback
      'social-post-setting-admin' // Page
    );

    add_settings_field(
      'facebook_name',
      'Facebook Name',
      array( $this, 'form_textfield' ), // Callback
      'social-post-setting-admin', // Page
      'facebook_section_id',
      'facebook_name'
    );

    add_settings_field(
      'facebook_page_id',
      'Facebook Page ID',
      array( $this, 'form_textfield' ), // Callback
      'social-post-setting-admin', // Page
      'facebook_section_id',
      'facebook_page_id'
    );

    // Twitter Account
    add_settings_section(
      'twitter_section_id', // ID
      'Twitter Account', // Title
      array( $this, 'print_section_info' ), // Callback
      'social-post-setting-admin' // Page
    );

    add_settings_field(
      'twitter_name',
      'Twitter Name',
      array( $this, 'form_textfield' ), // Callback
      'social-post-setting-admin', // Page
      'twitter_section_id',
      'twitter_name'
    );

    add_settings_field(
      'twitter_page_id',
      'Twitter Page ID',
      array( $this, 'form_textfield' ), // Callback
      'social-post-setting-admin', // Page
      'twitter_section_id',
      'twitter_page_id'
    );

    // Youtube Account
    add_settings_section(
      'youtube_section_id', // ID
      'Youtube Account', // Title
      array( $this, 'print_section_info' ), // Callback
      'social-post-setting-admin' // Page
    );

    add_settings_field(
      'youtube_name',
      'Youtube Name',
      array( $this, 'form_textfield' ), // Callback
      'social-post-setting-admin', // Page
      'youtube_section_id',
      'youtube_name'
    );

    add_settings_field(
      'youtube_page_id',
      'Youtube Page ID',
      array( $this, 'form_textfield' ), // Callback
      'social-post-setting-admin', // Page
      'youtube_section_id',
      'youtube_page_id'
    );
  }

  /**
  * Print the Section text
  */
  public function print_section_info() {
    //echo "Configure to your Social account.";
  }

  /**
  * Get the settings option array and print one of its values
  */
  public function form_textfield($name) {
    $value = isset($this->options[$name]) ? esc_attr($this->options[$name]) : '';
    printf('<input type="text" size=60 id="form-id-%s" name="social_post_board_settings[%s]" value="%s" />', $name, $name, $value);
  }
}