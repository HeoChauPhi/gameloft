<?php
add_action( 'cmb2_admin_init', 'social_post_metaboxes' );
function social_post_metaboxes() {

  $prefix = '_cmb2_';

  $cmb = new_cmb2_box( array(
    'id'            => 'facebook_post_options',
    'title'         => __( 'Facebook Post Options', 'cmb2' ),
    'object_types'  => array('facebook_post'), // Post type or any post type use: cat_list_posttype()
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true,
  ) );

  // Fields option
  $cmb->add_field( array(
    'name'             => __( 'Facebook Post ID', 'cmb2' ),
    'desc'             => __( 'Facebook Post ID', 'cmb2' ),
    'id'               => $prefix . 'facebook_post_id',
    'type'             => 'text',
  ) );

  $cmb->add_field( array(
    'name'             => __( 'Facebook Page', 'cmb2' ),
    'desc'             => __( 'Facebook Page', 'cmb2' ),
    'id'               => $prefix . 'facebook_page',
    'type'             => 'text',
  ) );

  $cmb->add_field( array(
    'name'             => __( 'Facebook Media Link', 'cmb2' ),
    'desc'             => __( '', 'cmb2' ),
    'id'               => $prefix . 'facebook_media',
    'type'             => 'text',
    'before_field'      => __( '<div class="demo-field"></div>', 'cmb2' ),
    'after_field'      => __( '<div class="download-files"><a href="#" target="_blank" download>Download</a></div>', 'cmb2' ),
  ) );

  $cmb->add_field( array(
    'id'   => $prefix . 'facebook_type',
    'type' => 'hidden',
  ) );
}

function social_post_option($name = '') {
  global $post;
  $value = get_post_meta( $post->ID, '_cmb2_' . $name, true );
  return $value;
}
