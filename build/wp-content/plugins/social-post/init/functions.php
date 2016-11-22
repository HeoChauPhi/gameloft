<?php

/*$page_name = 'gameloft'; // Example: http://facebook.com/{PAGE_NAME}
$page_id = '216238295505'; // can get form Facebook page settings
$app_id = '115760638907583'; // can get form Developer Facebook Page
$app_secret = '1e9f93bce8e2e6a5b7308d4651f5146f'; // can get form Developer Facebook Page
$limit = 5;*/

function load_face_posts($page_id, $page_name, $app_id, $app_secret, $limit) {
  $access_token = "https://graph.facebook.com/oauth/access_token?client_id=$app_id&client_secret=$app_secret&grant_type=client_credentials";
  $access_token = file_get_contents($access_token); // returns 'accesstoken=APP_TOKEN|APP_SECRET'
  $access_token = str_replace('access_token=', '', $access_token);
  $data  = file_get_contents("https://graph.facebook.com/$page_name/posts?limit=$limit&access_token=$access_token");
  $data = json_decode($data, true);
  $posts = $data['data'];

  //echo $access_token . "<br>";
  //print_r($data);
  //print_r($posts);

  echo '<ul>';

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
    if (array_key_exists('subattachments', $post_atactment['attachments']['data'][0])) {
      $album = $post_atactment['attachments']['data'][0]['subattachments']['data'];
      $media = array();
      $media[] = "<ul>";
      foreach ($album as $item) {
        $media[] = "<li><img src='" . $item['media']['image']['src'] . "' ></li>";
      }
      $media[] = "</ul>";
    }

    echo "<li>";
    echo implode("\n", $media);
    echo "<div><span>" . nl2br($message) . "</span> - " . $posts[$i]['id'] . "</div>";
    echo "<div>" . $post_time . " - <a href='" . $link_id . "' target='_blank'>Read more</a></div>";
    echo "</li><hr>";
  }

  echo '</ul>';
}