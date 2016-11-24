<?php
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