<?php 

//general support
add_theme_support( 'post-thumbnails' );

function get_asset($type, $file) {
  switch ($type) {
    case 'img':
      echo get_template_directory_uri().'/assets/img/'.$file;
      break;
    case 'style':
      echo get_template_directory_uri().'/assets/style/'.$file;
      break;
  }
}
add_action( 'wp_enqueue_scripts', 'theme_assets' );
function theme_assets() {
  wp_enqueue_style('main', get_template_directory_uri().'/assets/style/main.css',false,'1.1','all');
  if (is_page_template( 'contato.php' )) {
    wp_enqueue_script('mail', get_template_directory_uri().'/assets/scripts/mail.js',false);
    wp_enqueue_script('sweetalert', get_template_directory_uri().'/assets/sweetalert/sweetalert2.all.min.js',false);
  }
}

if (!is_admin()):

  include $_SERVER["DOCUMENT_ROOT"].'/wp-content/themes/portinari/template-parts/functions/api.php';
  
  function my_js_variables(){ ?>
    <script type="text/javascript">
      var apiURL = '<?php echo get_site_url() ?>/wp-json/portinari-api/';
    </script><?php
  }
  add_action ( 'wp_head', 'my_js_variables' );


  function replace_content($content) {
    $content = htmlentities($content, null, 'utf-8');
    $content = str_replace("&nbsp;", " ", $content);
    $content = html_entity_decode($content);
  return $content;
  }
  add_filter('the_content','replace_content', 999999999);
  add_filter( 'excerpt_length', function($length) { return 20; }, PHP_INT_MAX );


else:
  add_action( 'admin_menu', 'my_remove_admin_menus' );
  function my_remove_admin_menus() {
      remove_menu_page( 'edit-comments.php' );
  }
  // Removes from post and pages
  add_action('init', 'remove_comment_support', 100);
  
  function remove_comment_support() {
      remove_post_type_support( 'post', 'comments' );
      remove_post_type_support( 'page', 'comments' );
  }
  // Removes from admin bar
  function mytheme_admin_bar_render() {
      global $wp_admin_bar;
      $wp_admin_bar->remove_menu('comments');
  }
  add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );
  include $_SERVER["DOCUMENT_ROOT"].'/wp-content/themes/portinari/template-parts/functions/metaboxes.php';
  include $_SERVER["DOCUMENT_ROOT"].'/wp-content/themes/portinari/template-parts/functions/custom-posts.php';

endif;
?>