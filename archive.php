<?php
  get_header();
  $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
  $sticky = get_option( 'sticky_posts' );
  $args = array(
    'post_type'           => 'post',
    'posts_per_page'      => 4,
    'ignore_sticky_posts' => 1,
    'paged'               => $paged,
  );
  $the_query = new WP_Query( $args );
?>
<section id="Blog" class="container">
  <h1 class="archive-title">Blog</h1>
  <?php if ($the_query->have_posts()) {
      while ($the_query->have_posts()) {
        $the_query->the_post();?>
        <div class="blog-post">
          <img src="<?php the_post_thumbnail_url();?>" alt="" width="200px">
          <div class="blog-post-content">
            <h2><?php  the_title();?></h2>
            <p><?php echo get_the_excerpt();?></p>
            <a href="<?php echo the_permalink();?>">Saiba mais</a>
          </div>
        </div>
      <?php
      }
      wp_reset_postdata();
    }
  ?>
<div class="pagination">
    <?php 
        echo paginate_links( array(
            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
            'total'        => $the_query->max_num_pages,
            'current'      => max( 1, get_query_var( 'paged' ) ),
            'format'       => '?page=%#%',
            'show_all'     => false,
            'type'         => 'plain',
            'end_size'     => 2,
            'mid_size'     => 1,
            'add_args'     => false,
            'add_fragment' => '',
      ));?>
</div>
</section>
<?php
    get_footer();?>