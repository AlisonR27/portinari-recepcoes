<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?php echo get_bloginfo('template_url')?>/assets/img/favicon.ico" type="image/x-icon">
  <title>Portinari</title>
  <?php wp_head(); ?> 
  <script>
  window.addEventListener("load", () => {
    const hamburguer = document.querySelector('#hamburguer');
    const naviNav = document.querySelector('ul.navigation-nav');
    hamburguer.addEventListener('click', () => {
      hamburguer.classList.toggle('open');
      naviNav.classList.toggle('show');
    })
  });  
  </script>
</head>
<body>
  <header class="navigation <?php echo is_front_page() ? '' : 'not-home'?>">
    <div class="navigation-control">
      <div></div>
      <a href="<?php echo get_site_url();?>" class="logo">
        <img src="<?php get_asset('img','Logo.png') ?>" alt="" srcset="">
      </a>
      <div id="hamburguer">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <ul class="navigation-nav">
      <li><a class="link" href="<?php echo get_site_url()?>">Home</a></li>
      <li><a class="link" href="<?php echo get_site_url()?>/sobre">Portinari</a></li>
      <li>
        <label for="nav-dropdown" class="link dropdown-toggler">Nossos Serviços <img src="<?php echo get_bloginfo('template_url')?>/assets/img/SETA.png">
          <input type="checkbox" id="nav-dropdown" class="dropdown-check">
          <ul class="dropdown">
            <?php 
            $the_query = new WP_Query( array('post_type' => 'servicos', 'posts_per_page' => -1) );
            if ($the_query->have_posts()) {
              while ($the_query->have_posts()) {
                $the_query->the_post();
            ?>
            <li><a class="link" href="<?php the_permalink();?>"><?php the_title();?></a></li>
            <?php
              }
              wp_reset_postdata();
            } 
            ?>
          </ul>
        </label>
      </li>
      <li><a class="link" href="<?php echo get_site_url()?>/blog">Blog</a></li>
      <li><a class="link" href="<?php echo get_site_url()?>/galeria">Galeria</a></li>
      <li><a class="link" href="<?php echo get_site_url()?>/contato">Contato</a></li>
      <ul class="social-media">
        <li><a href="#"><img src="<?php get_asset('img','INSTAGRAM.png') ?>" alt="" srcset=""></a></li>
        <li><a href="#"><img src="<?php get_asset('img','FACEBOOK.png') ?>" alt="" srcset=""></a></li>
        <li><a href="#"><img src="<?php get_asset('img','WHATSAPP.png') ?>" alt="" srcset=""></a></li>
      </ul>
    </ul>
  </header>
  <main <?php if (!is_front_page()) { ?>class="container"<?php }?>>