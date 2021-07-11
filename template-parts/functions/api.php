<?php 
/**
 * Pega todas as galerias
 *
 * @param array $data Options for the function.
 * @return array.
 */
function api_gallery( $data ) {
  $posts = get_posts( array(
    'post_type' => 'galeria',
  ));
  $f_page_size = 9;
  if ($data['page'] == 1){
    return array_slice($posts,0,9);
  } elseif ($data['page'] > 1) {
    return array_slice($posts,9+(3*$data['page']),3);
  }
  return $posts;
}
add_action( 'rest_api_init', function () {
  register_rest_route( 'portinari-api', '/galleries/page=(?P<page>\d+)', array(
    'methods' => 'GET',
    'callback' => 'api_gallery',
  ) );
} );



/**
 * Pega todas as imagens de uma galeria
 *
 * @param array $data Options for the function.
 * @return array.
 */
function api_images( $data ) {
  $post = get_post($data['id']);
  return $post;
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'portinari-api', '/gallery/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'api_images',
  ) );
} );