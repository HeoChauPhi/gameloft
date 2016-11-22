<?php
add_shortcode( 'social_post', 'create_social_post' );
function create_social_post($attrs) {
  $options = get_option('social_post_board_settings');
  //print_r($options);

  extract(shortcode_atts (array(
    'page_name' => $options['facebook_name'],
    'page_id' => $options['facebook_page_id'],
    'app_id' => '115760638907583',
    'app_secret' => '1e9f93bce8e2e6a5b7308d4651f5146f',
    'limit' => 1
  ), $attrs));

  ob_start();

    load_face_posts($page_id, $page_name, $app_id, $app_secret, $limit);

    $content = ob_get_contents();
  ob_end_clean();
  return $content;
  wp_reset_postdata();
}