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

    // Facebook Account First
    add_settings_section(
      'facebook_section_first', // ID
      'Facebook Account First', // Title
      array( $this, 'print_section_info' ), // Callback
      'social-post-setting-admin' // Page
    );

    add_settings_field(
      'facebook_name_first',
      'Facebook Name',
      array( $this, 'form_textfield' ), // Callback
      'social-post-setting-admin', // Page
      'facebook_section_first',
      'facebook_name_first'
    );

    add_settings_field(
      'facebook_page_id_first',
      'Facebook Page ID',
      array( $this, 'form_textfield' ), // Callback
      'social-post-setting-admin', // Page
      'facebook_section_first',
      'facebook_page_id_first'
    );

    // Facebook Account Seccond
    add_settings_section(
      'facebook_section_seccond', // ID
      'Facebook Account Seccond', // Title
      array( $this, 'print_section_info' ), // Callback
      'social-post-setting-admin' // Page
    );

    add_settings_field(
      'facebook_name_seccond',
      'Facebook Name',
      array( $this, 'form_textfield' ), // Callback
      'social-post-setting-admin', // Page
      'facebook_section_seccond',
      'facebook_name_seccond'
    );

    add_settings_field(
      'facebook_page_id_seccond',
      'Facebook Page ID',
      array( $this, 'form_textfield' ), // Callback
      'social-post-setting-admin', // Page
      'facebook_section_seccond',
      'facebook_page_id_seccond'
    );
  }

  /**
  * Print the Section text
  */
  public function print_section_info() {
    echo "Configure to your Facebook account.";
  }

  /**
  * Get the settings option array and print one of its values
  */
  public function form_textfield($name) {
    $value = isset($this->options[$name]) ? esc_attr($this->options[$name]) : '';
    printf('<input type="text" size=60 id="form-id-%s" name="social_post_board_settings[%s]" value="%s" />', $name, $name, $value);
  }
}