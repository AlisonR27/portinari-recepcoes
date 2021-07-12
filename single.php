<?php 
get_header();
?>
<article class="container">
<h1 class="archive-title"><?php the_title()?></h1>
<img src="<?php the_post_thumbnail_url();?>" class="post-banner">
<?php the_content();?>
<div class="share">
  Compartilhe isso:
  <ul class="post-social-media-list">
    <li>
      <a href="whatsapp://send?text=<?php the_permalink();?>">
        <img src="<?php echo get_bloginfo('template_url')?>/assets/img/social-whatsapp.png" alt="Icone do whatsapp">
      </a>
    </li>
    <li>
      <a data-href="<?php the_permalink();?>" href="https://www.facebook.com/sharer.php?u=<?php the_permalink();?>">
        <img src="<?php echo get_bloginfo('template_url')?>/assets/img/social-facebook.png" alt="Icone do facebook">
      </a>
    </li>
    <li>
      <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink();?>&title=<?php the_title();?>">
        <img src="<?php echo get_bloginfo('template_url')?>/assets/img/social-linkedin.png" alt="Icone do facebook">
      </a>
    </li>
    <li>
      <a href="javascript:window.print()">
        <img src="<?php echo get_bloginfo('template_url')?>/assets/img/social-print.png" alt="Icone do facebook">
      </a>
    </li>
  </ul>
</div>
</article>
<?php 
get_footer();
?>