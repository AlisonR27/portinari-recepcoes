<?php 
/* Template Name: Initial Page*/
the_post();
get_header();
?>
    <section name="apresentacao" id="cover" style="background: url('<?php get_asset('img', 'cover-bg.png')?>');">
      <div class="presentation-carousel">
        <img src="<?php get_asset('img','Simple-logo-white.png') ?>" alt="" width="200px">
        <span class="title">
          A arte de eternizar momentos
        </span>
      </div>
    </section>
    <section name="a-portinari" class="text-gray container">
      <div class="text-center portinari-quote">
        <h2 class="title uppercase"><?php echo the_title();?></h2>
        <?php the_content();?>
      </div>
    </section>
    <section name="eventos" class="container">
      <div class="event-grid">
        <?php require_once $_SERVER["DOCUMENT_ROOT"].'/portinari/wp-content/themes/portinari/template-parts/content/home/events.php'?>
      </div>
      <a id="event-button" href="<?php echo get_site_url()?>/contato">
        <img src="<?php get_asset('img','./agenda.png') ?>" alt="">
        agende seu evento conosco!
      </a>
    </section>
    <section class="blog-bg">
      <div class="blog-grid container">
        <?php require_once $_SERVER["DOCUMENT_ROOT"].'/portinari/wp-content/themes/portinari/template-parts/content/home/blog.php'?>
      </div>
      <a href="<?php echo get_site_url()?>/blog" class="outline-white button block-centering">
        Visitar o blog
      </a>
    </section>
    <section name="instagram" class="bg-red">
      <div class="container">
        <div class="insta-feed">
          <?php echo do_shortcode('[instagram-feed]'); ?>
        </div>
        <div class="insta-desc">
          <h1>INSTAGRAM</h1>
          <h3>Confira nossas fotos</h3>
        </div>
      </div>
    </section>
<?php
get_footer();
?>