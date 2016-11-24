<?php

function load_face_posts($page_id, $page_name, $app_id, $app_secret, $limit) {
  $access_token = "https://graph.facebook.com/oauth/access_token?client_id=$app_id&client_secret=$app_secret&grant_type=client_credentials";
  $access_token = file_get_contents($access_token); // returns 'accesstoken=APP_TOKEN|APP_SECRET'
  $access_token = str_replace('access_token=', '', $access_token);
  $data  = file_get_contents("https://graph.facebook.com/$page_name/posts?limit=$limit&access_token=$access_token");
  $data = json_decode($data, true);
  $posts = $data['data'];

  for($i=0; $i<sizeof($posts); $i++) {
    $post_time = $posts[$i]['created_time'];
    $post_atactment = file_get_contents("https://graph.facebook.com/".$posts[$i]['id']."?fields=full_picture,source,link,attachments{type,subattachments}&access_token=$access_token");
    $post_atactment = json_decode($post_atactment, true);

    $media = array();
    $link_id = $post_atactment['link'];

    if (array_key_exists('message', $posts[$i])){
      $message = $posts[$i]['message'];
    } elseif (array_key_exists('story', $posts[$i])) {
      $message = $posts[$i]['story'];
    }

    if (array_key_exists('full_picture', $post_atactment)) {
      $media[] = "<img src='".$post_atactment['full_picture']."' >";
    }
    if (array_key_exists('source', $post_atactment)) {
      $media = array();
      $media[] = "<video controls='' name='media'><source src='".$post_atactment['source']."' type='video/mp4'></video>";
    } 
    if ((array_key_exists('source', $post_atactment)) && ($post_atactment['attachments']['data'][0]['type'] == "video_share_youtube")) {
      $media = array();
      $media[] = '<iframe width="560" height="315" src="'.str_replace('?autoplay=1', '', $post_atactment['source']).'" frameborder="0" allowfullscreen></iframe>';
    } 
    if (array_key_exists('subattachments', $post_atactment['attachments']['data'][0])) {
      $album = $post_atactment['attachments']['data'][0]['subattachments']['data'];
      $media = array();
      $media[] = "<ul>";
      foreach ($album as $item) {
        $media[] = "<li><img src='" . $item['media']['image']['src'] . "' ></li>";
      }
      $media[] = "</ul>";
    }

    $title = array(); 
    $args = array(
      'post_type' => 'facebook_post',
      'post_status' => 'any',
    );
    $facebook_post = new WP_Query($args);
    if($facebook_post->have_posts()) {
      while ( $facebook_post->have_posts() ) {
        $facebook_post->the_post();
        $post_title = get_the_title();
        array_push($title, $post_title);
      }
    }

    print_r($title);

    if(in_array($posts[$i]['id'], $title, false)){
      $new_post = array(
        'post_title'    => $message,
        'post_status'   => 'pending',
        'post_type'     => 'facebook_post'
      );

      //SAVE THE POST
      $pid = wp_insert_post($new_post);
      update_post_meta($pid, '_cmb2_facebook_post_id', $posts[$i]['id']);
    }
  }
    do_action('wp_insert_post', 'wp_insert_post');

}

function get_face_post() {
  $options = get_option('social_post_board_settings');
  $page_name = $options['facebook_name'];
  $page_id = $options['facebook_page_id'];
  $app_id = '115760638907583';
  $app_secret = '1e9f93bce8e2e6a5b7308d4651f5146f';
  $limit = 1;
  load_face_posts($page_id, $page_name, $app_id, $app_secret, $limit);
}