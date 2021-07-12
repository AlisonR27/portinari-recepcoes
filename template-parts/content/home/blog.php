<?php 
$the_query = new WP_Query( array('post_type' => 'post', 'posts_per_page' => 3) );
if ($the_query->have_posts()) {
  ?>
  <div class="blog-grid container">
<?php
  while ($the_query->have_posts()) {
    $the_query->the_post();
    ?>
    <article>
      <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
      <h4><?php the_title()?></h4>
      <a href="<?php the_permalink();?>" class="bg-orange">Saiba mais</a>
    </article>
    <?php
  }
  wp_reset_postdata();
  ?>
  </div>
  <?php
} else {
  include $_SERVER["DOCUMENT_ROOT"].'/portinari/wp-content/themes/portinari/template-parts/content/no-content.php';
}