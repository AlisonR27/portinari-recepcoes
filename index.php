<?php 


if (is_archive()) {
  echo 'Archive';
}
elseif( is_singular()){
  echo 'Singlepage';
}
else {
  get_header();
  if ( have_posts() ) {

    // Load posts loop.
    while ( have_posts() ) {
      the_post();
    }
  
  } else {
  
    // If no content, include the "No posts found" template.
    get_template_part( 'template-parts/content/content-none' );
  
  }
  get_footer();  
}

