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

/**
 * Envia e-mail
 *
 * @param array $data Options for the function.
 * @return array.
 */
function send_email( $data ) {
  try {
    //$to = 'portinari@portinarirecepcoes.com.br';
    $to = 'alisonranier@gmail.com';
    $subject = 'Contato do Site - '.$data['nome'];
    $body = '
    <table style="border:0; font-family: sans-serif; text-align:center;">
      <tbody style="border:0;">
        <tr style="text-align:left;">
          <td>
            '.$data['msg'].'
          </td>
        </tr>
        <tr style="text-align: center; font-weight:bold">
          <td>'.$data['nome'].'</td>
        </tr>
        <tr>
          <td>'.$data['email'].'</td>
        </tr>
        <tr></tr>
          <td>'.$data['tel'].'</td>
        </tr>
        <tr>
          <td>Contato fornecido por: <a target="blank" href="https://agenciagaragem.com.br"><b>Agência Garagem</b></a> </td>
        </tr>
      </tbody>
    </table>';
    $headers = array('Content-Type: text/html; charset=UTF-8','From: '.$data['nome'].' <'.$data['email'].'>');
    wp_mail( $to, $subject, $body, $headers );
    return json_encode(array(
      'code' => 200,
      'message' => 'Your email was sent successfully!'
    ));
  } catch (exc) {
    return json_encode(exc);
  }
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'portinari-api', '/sendMail', array(
    'methods' => 'POST',
    'callback' => 'send_email',
  ) );
} );