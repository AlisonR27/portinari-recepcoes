<?php 
function gallery_metabox() {
  add_meta_box(
      'gallery',
      __( 'Galeria', 'sitepoint' ),
      'gallery_meta_box_callback',
      'galeria'
  );
}
add_action( 'add_meta_boxes', 'gallery_metabox' );

function gallery_meta_box_callback( $post ) {
  // Add a nonce field so we can check for it later.
  wp_nonce_field( 'gallery', 'gallery' );
  $value = get_post_meta( $post->ID, '_gallery', true );
  ?>
   <div id="dragfiles">Drop your files here</div>
  <div id="filebutton"> Or upload a file </div>
  <div id="gallery-preview"></div>
  <input type="file" multiple id="gallery-files" name="gallery-files">
  <a class="components-button is-primary" id="save-gallery" role="button"> Salvar Galeria </a>
  <style>
    #filearea {
      display:grid;
      grid-template-columns: repeat(2,40%);
      column-gap: 10%;
    }
    #dragfiles{
      height:250px;
      width:100%;
      display:grid;
      align-items:center;
      justify-items:center;
    }
    #dragfiles.drag{
      border: 2px dotted gray;
      box-sizing:border-box;
    }
    #save-gallery{
      margin-top:10px;
      background: green;
      color:white;
      border: none;
      border-radius:5px;
      padding: 10px 20px;
      display:block;
      width:40%;
      margin:10px auto;
      text-align:center;
    }
    #filebutton {
      cursor:pointer;
    }
    #filebutton:hover{
      text-decoration:underline;
    }
    #gallery-files {
      display:none;
    }
    #save-gallery:hover{
      background:rgb(0,100,30);
    }
    #save-gallery:focus {
      background:rgb(0,70,30);
    }
    #gallery-preview {
      margin-top:20px;
      display: flex;
    }
    .gallery-image-preview {
      height: 200px;
      width:  200px;
      position: relative;
      object-fit: cover;
    }
    .gallery-image-preview img {
      width:100%;
      height:100%;
      object-fit: cover;
    }
    .gallery-image-preview span {
      width:20px;
      height:20px;
      display: block;
      position: absolute;
      top: 5px;
      right: 5px;
      text-align: center;
      font-weight: bold;
      background-color: red;
      color:white;
      cursor:pointer;
    }
    .gallery-image-preview {
      margin-right:15px;
    }
  </style>
  <script>
    window.onload = function(){
      sessionStorage.clear();
    }
    let dragContainer = document.getElementById('dragfiles');
    let fileButton = document.getElementById('filebutton');
    dragContainer.addEventListener('dragover', (e) => {
      e.preventDefault();
      e.target.classList.add('drag');
    });
    dragContainer.addEventListener('dragleave', (e) => {
      e.target.classList.remove('drag');
    });
    fileButton.addEventListener('click', (e) => {
      document.getElementById('gallery-files').click();
    });
    dragContainer.addEventListener('drop', (ev) => {
      ev.preventDefault();
      if (ev.dataTransfer.items) {  
      // Use a interface DataTransferItemList para acessar o (s) arquivo (s)
      for (var i = 0; i < ev.dataTransfer.items.length; i++) {
      // Se os itens soltos não forem arquivos, rejeite-os
          if (ev.dataTransfer.items[i].kind === 'file') {
            var file = ev.dataTransfer.items[i].getAsFile();
            storeFiles(file);
          }
        }
      } else {
        // Use a interface DataTransfer para acessar o (s) arquivo (s)
        for (var i = 0; i < ev.dataTransfer.files.length; i++) {
          console.log('... file[' + i + '].name = ' + [i].name);
        }
      }
      ev.target.classList.remove('drag');
    });


    function storeFiles(file) {
      var files = sessionStorage.getItem('gallery-files') === null ? [] : JSON.parse(sessionStorage.getItem('gallery-files'));
      if (files.filter( item => { return item.name == file.name }).length > 0) return;
      var uploading = {
        name: file.name,
      }
      convertFiles(file).then((base64)=> {
        uploading.base64 = base64;
        files.push(uploading);
        generateImages(uploading);
        sessionStorage.setItem('gallery-files', JSON.stringify(files));
      })
    }
    function convertFiles(file) {
      return new Promise((resolve,reject) => {
        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function () {
          resolve(reader.result);
        };
        reader.onerror = function (error) {
          reject('Error: ', error);
        };  
      });
    }
    function generateImages(file) {
      let imgHolder = document.createElement('div');
      let deleteImage = document.createElement('span');
      let imgEl = document.createElement('img');
      imgEl.src = file.base64;
      imgHolder.classList.add('gallery-image-preview');
      imgHolder.appendChild(imgEl);
      deleteImage.innerText = '×';
      deleteImage.classList.add('excluiFoto');
      deleteImage.dataset.fileName = file.name; 
      deleteImage.onclick = deletaFoto;
      imgHolder.appendChild(deleteImage);
      document.getElementById('gallery-preview').appendChild(imgHolder);
    }
    function deletaFoto(event) {
      let fileName = event.target.dataset.fileName;
      var files = JSON.parse(sessionStorage.getItem('gallery-files'));
      files.forEach((item,index) => {
        if (item.name == fileName) {
          files.splice(index,1);
        }
      });
      var elem = document.querySelector('[data-file-name="'+fileName+'"]');
      elem.parentElement.parentElement.removeChild(elem.parentElement);
      sessionStorage.setItem('gallery-files', JSON.stringify(files));
    }
    window.addEventListener('load', () => {
      const gallery = document.getElementById('gallery-files')
      gallery.addEventListener("change", (e) => {
        for (const file of e.target.files) {
          storeFiles(file);
        }
      })
      document.getElementById('post').addEventListener('submit', (e) => {
        //Run submit code here;
        e.preventDefault();
        let files = JSON.parse(sessionStorage.getItem('gallery-files'));
        console.log('Running before submit');
        fetch('<?php echo get_site_url()?>/wp-json/portinari-api/gallery/', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(files)
        }).then((response) => {
          console.log(response)
        })
        return false;
      })
    })
  </script>
<?php
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id
 */
function save_gallery_meta_box_data( $post_id ) {
    $urls = '';
    if ( !empty($_FILES['gallery-files'] )) {
      error_log(print_r($_FILES,true));
      foreach ($_FILES['gallery-files']['tmp_name'] as $file){
        //$upload = wp_upload_bits($file['name'], null, file_get_contents($file['tmp_name']));
        //$urls += $upload.';';
      }
    }
    echo $urls;
    // Update the meta field in the database.
    update_post_meta( $post_id, '_gallery', $urls);
}
  add_action( 'save_post', 'save_gallery_meta_box_data' );

?>