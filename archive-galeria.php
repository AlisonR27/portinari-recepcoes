<?php 

get_header();
?>
  <h1 class="archive-title">Galeria</h1>
  <script>
    function openGallery(ev) { 
      document.getElementById('sobreposicao').classList.add('show');
      fetch(`<?php echo get_site_url()?>/wp-json/portinari-api/gallery/${ev.target.dataset.id}`, { 
        method: 'GET',
        mode: 'cors',
        cache: 'default' 
      }).then((response) => {
        response.json().then((data) => {
          document.querySelector('#sobreposicao .content').innerHTML = data.post_content;
          organizeImages();
        });
      })
    }
    function closeGallery(){
      document.querySelector('.content').innerHTML = '';
      document.querySelector('#sobreposicao').classList.remove('show');
    }
    function organizeImages() {
      const gallery = document.querySelectorAll('figure.wp-block-gallery .blocks-gallery-grid li figure img');
      const imageArray = [];
      gallery.forEach(el => {
        imageArray.push(el);
      })
      document.querySelector('.content').innerHTML = '';
      imageArray.forEach((img,index) => {
        if (index == 0) img.classList.add('active');
        img.classList.add('slide-image');
        img.dataset.index = parseInt(index);
        document.querySelector('.content').appendChild(img);
      })
    }
    function goBack(){
      const activeImage = document.querySelector('.slide-image.active');
      const allImages = document.querySelectorAll('.slide-image');
      console.log(allImages.length + 1);
      if ( activeImage.dataset.index == 0 ) allImages[allImages.length - 1].classList.add('active');
      else document.querySelector(`img[data-index="${parseInt(activeImage.dataset.index) - 1}"]`).classList.add('active')
      activeImage.classList.remove('active')
    }
    function goAhead(){
      const activeImage = document.querySelector('.slide-image.active');
      const allImages = document.querySelectorAll('.slide-image');
      console.log(activeImage.dataset.index);
      if ( activeImage.dataset.index == allImages.length - 1 ) allImages[0].classList.add('active');
      else document.querySelector(`img[data-index="${parseInt(activeImage.dataset.index) + 1}"]`).classList.add('active')
      activeImage.classList.remove('active')
    }
  </script>
  <a style="background-image: url(https://i.ibb.co/RvTJC4r/whatsapp.png); border-radius: 34px;width: 60px; font-size: 0; height: 60px;position: fixed;right: 10px;z-index: 999;display: block;bottom: 10px;background-size: 73%;background-repeat: no-repeat;background-color: #1bd741;background-position: center;" target="_blank" href="https://wa.me/5584987984008?text=Alisu%20Xang%C3%B4%20Xang%C3%B4">link whatsapp</a>

  <div id="sobreposicao">
    <div id="close-btn" onclick="closeGallery()">&times;</div>
    <div class="content-holder">
      <div>
        <button onclick="goBack()" id="go-back"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22"><defs><clipPath><path fill="#00f" fill-opacity=".514" d="m-7 1024.36h34v34h-34z"/></clipPath><clipPath><path fill="#aade87" fill-opacity=".472" d="m-6 1028.36h32v32h-32z"/></clipPath></defs><path d="m345.44 248.29l-194.29 194.28c-12.359 12.365-32.397 12.365-44.75 0-12.354-12.354-12.354-32.391 0-44.744l171.91-171.91-171.91-171.9c-12.354-12.359-12.354-32.394 0-44.748 12.354-12.359 32.391-12.359 44.75 0l194.29 194.28c6.177 6.18 9.262 14.271 9.262 22.366 0 8.099-3.091 16.196-9.267 22.373" fill="#fff" transform="matrix(-.03541-.00013-.00013.03541 19.02 3.02)"/></svg></button>
      </div>
      <div class="content"></div>
      <div>
        <button onclick="goAhead()" id="go-ahead">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22"><defs><clipPath><path fill="#00f" fill-opacity=".514" d="m-7 1024.36h34v34h-34z"/></clipPath><clipPath><path fill="#aade87" fill-opacity=".472" d="m-6 1028.36h32v32h-32z"/></clipPath></defs><path d="m345.44 248.29l-194.29 194.28c-12.359 12.365-32.397 12.365-44.75 0-12.354-12.354-12.354-32.391 0-44.744l171.91-171.91-171.91-171.9c-12.354-12.359-12.354-32.394 0-44.748 12.354-12.359 32.391-12.359 44.75 0l194.29 194.28c6.177 6.18 9.262 14.271 9.262 22.366 0 8.099-3.091 16.196-9.267 22.373" transform="matrix(.03541-.00013.00013.03541 2.98 3.02)" fill="#fff"/></svg>
        </button>
      </div>
    </div>
    <div class="modal-backdrop" onclick="closeGallery()">
    </div>
  </div>
  <section id="galeria" name="galeria">
    <?php
      $the_query = new WP_Query( array('post_type' => 'galeria', 'posts_per_page' => 9) );
      if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
          $the_query->the_post();?>
          <div class="gallery-card">
            <div class="overlay" style="background-color: <?php echo get_post_meta( get_post_meta(get_the_id(),'_servicos', true), '_global_notice', TRUE );?>"></div>
            <a href="#" onclick="openGallery(event)" class="gallery-content" data-id="<?php the_id();?>"> <?php the_title();?> </a>
            <img src="<?php the_post_thumbnail_url();?>" alt="">
          </div>
        <?php
        }
        wp_reset_postdata();
      } else {
        include $_SERVER["DOCUMENT_ROOT"].'/wp-content/themes/portinari/template-parts/content/no-content.php';
      }
    ?>
  </section>
<style>
  #close-btn {
    position:absolute;
    color:white;
    font-size:5em;
    z-index:100000;
    right:10vh;
    top:5vw;
    cursor:pointer;
  }
  #close-btn:hover{
    filter:drop-shadow(0 0 5px rgba(255,255,255,.3))
  }
  #sobreposicao{
    display:none;
    position:absolute;
    width:100%;
    height:100%;
    justify-content:center;
    align-items:center;
    top:0;
    left:0;
  }
  #sobreposicao.show {
    display:flex;
  }
  #sobreposicao .content-holder {
    height:80%;
    width:100%;
    display:grid;
    grid-template-columns: 1fr 1130px 1fr;
  }
  .content-holder div:not(.content) {
    display:flex;
    justify-content:center;
    align-items:center;
  }
  #sobreposicao .content {
    position:relative;
    width:100%;
    height:100%;
    display:flex;
    justify-content:center;
    align-items:center;
    background:transparent;
    z-index:9999;
  }
  #sobreposicao .modal-backdrop {
    position:absolute;
    width:100%;
    height:100%;
    z-index:100;
    background:rgba(0,0,0,.9);
  }
  .slide-image.active{
    display:block;
  }
  .slide-image {
    display:none;
    width:100%;
    height:620px;
    object-fit:contain;
  }
  #sobreposicao button{
    position: relative;
    z-index:10000;
    font-size:5em;
    width: 70px;
    height:50px;
    border: none;
    color:white;
    background:transparent;
    cursor:pointer;
  }
  #sobreposicao button:hover svg{
    filter:drop-shadow(0 0 3px rgba(255,255,255,.3))
  }
  #sobreposicao button:focus svg{
    filter:drop-shadow(0 0 5px rgba(255,255,255,.6))
  }
  #sobreposicao button:first-of-type{
    left:0;
  }
  #sobreposicao button:last-of-type{
    right:0;
  }
  @media screen and (max-width:900px) {
    section#galeria {
      display:flex;
      flex-direction:column;
    }
    section#galeria .gallery-card {
      height:250px;
    }
  }
</style>
<?php
get_footer();

?>