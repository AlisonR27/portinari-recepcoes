<?php 
$the_query = new WP_Query( array('post_type' => 'cat_evento', 'posts_per_page' => 4) );
if ($the_query->have_posts()) {
  while ($the_query->have_posts()) {
    $the_query->the_post();
    ?>
    <div class="event-card" style="background-color: <?php echo get_post_meta( get_the_ID(), '_global_notice', TRUE );?>">
      <div class="card-overlay uppercase">
        <?php the_title();?>
      </div>
      <img class="noselec" src="<?php echo get_the_post_thumbnail_url();?>" alt="">
    </div>
    <?php
  }
  wp_reset_postdata();
}