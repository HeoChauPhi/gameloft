<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/template/pages/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$context['title_option'] = framework_page('title');
$context['main_option'] = framework_page('no_padding');
$context['page_layout'] = framework_page('layout_page');
$context['sidebar_left'] = framework_page('sidebar_left');
//$context['sidebar_right'] = framework_page('sidebar_right');

$post = new TimberPost();
$context['post'] = $post;

$sidebar_menu = framework_page('sidebar_menu');
$menu_obj = wp_get_nav_menu_object($sidebar_menu);
$context['sidebar_menu'] = $sidebar_menu;
//$context['menu_select'] = new TimberMenu($menu_obj->term_id);

Timber::render( array( 'page-' . $post->post_name . '.twig', 'page.twig'), $context );

/*//$data_face = file_get_contents("https://graph.facebook.com/216238295505/feed?access_token=EAABpSJZCC1L8BADLhlk4ElavvtyzOy6ndEZCjWymfe0W1aauWZABXDl7VR1fGjIpPfbpussC4mop7xxWjpcTszowfYNVOBFpOcZBZAKtWMVZBMCDpHpzn0ZBXSofejHXgMYAZAcAv9GAYfQMR7qZCl4z3XZAQ7ZBKx5ZBkepShiCdCzzS9GdhGmn3deh");
$data_face = file_get_contents("https://graph.facebook.com/1852387364995200/posts?access_token=EAABpSJZCC1L8BADLhlk4ElavvtyzOy6ndEZCjWymfe0W1aauWZABXDl7VR1fGjIpPfbpussC4mop7xxWjpcTszowfYNVOBFpOcZBZAKtWMVZBMCDpHpzn0ZBXSofejHXgMYAZAcAv9GAYfQMR7qZCl4z3XZAQ7ZBKx5ZBkepShiCdCzzS9GdhGmn3deh");
$data_face = json_decode($data_face, true);
print_r($data_face);*/

echo '<ul>';

$page_name = 'gameloft'; // Example: http://facebook.com/{PAGE_NAME}
$page_id = '216238295505'; // can get form Facebook page settings
$app_id = '115760638907583'; // can get form Developer Facebook Page
$app_secret = '1e9f93bce8e2e6a5b7308d4651f5146f'; // can get form Developer Facebook Page
$limit = 5;

function load_face_posts($page_id, $page_name, $app_id, $app_secret, $limit) {
  $access_token = "https://graph.facebook.com/oauth/access_token?client_id=$app_id&client_secret=$app_secret&grant_type=client_credentials";
  $access_token = file_get_contents($access_token); // returns 'accesstoken=APP_TOKEN|APP_SECRET'
  $access_token = str_replace('access_token=', '', $access_token);
  $limit = 5;
  $data  = file_get_contents("https://graph.facebook.com/$page_name/posts?limit=$limit&access_token=$access_token");
  $data = json_decode($data, true);

  //print_r($data);
  $posts = $data['data'];
  //print_r($posts);

  for($i=0; $i<sizeof($posts); $i++) {
    $post_time = $posts[$i]['created_time'];
    $link_id = str_replace($page_id."_", '', $posts[$i]['id']);
    $post_atactment = file_get_contents("https://graph.facebook.com/$page_id".'_'."$link_id?fields=full_picture,picture&access_token=$access_token");
    $post_atactment = json_decode($post_atactment, true);

    if (array_key_exists('message', $posts[$i])){
      $message = $posts[$i]['message'];
    } elseif (array_key_exists('story', $posts[$i])) {
      $message = $posts[$i]['story'];
    }

    echo "<li>";
    echo "<img src='" . $post_atactment['full_picture'] . "' >";
    echo "<a href='//www.facebook.com/" . $page_name . "/posts/" . $link_id . "' target='_blank'>" . $message . "</a> - " . $post_time . " - " . $posts[$i]['id'];
    echo "</li>";

  }
}

load_face_posts($page_id, $page_name, $app_id, $app_secret, $limit);
echo '</ul>';