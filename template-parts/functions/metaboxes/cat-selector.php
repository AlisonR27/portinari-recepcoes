<?php 
function servicos_metabox() {
  add_meta_box(
      'servicos',
      __( 'Categoria de evento', 'sitepoint' ),
      'servicos_meta_box_callback',
      'galeria'
  );
}
add_action( 'add_meta_boxes', 'servicos_metabox' );


function servicos_meta_box_callback( $post ) {
  // Add a nonce field so we can check for it later.
  wp_nonce_field( 'servicos_nonce', 'servicos_nonce' );
  $value = get_post_meta( $post->ID, '_servicos', true );
  // The Query
  $the_query = new WP_Query( array('post_type' => 'servicos') );
  // The Loop
  if ($the_query->have_posts()) {
    ?>
    <select name="cat_select">
    <option value="null">Sem categoria</option>
    <?php
    while ($the_query->have_posts()) {
      $the_query->the_post();
      ?><option value="<?php echo the_id()?>" <?php if(get_the_id() == $value) { echo "selected";}?>><?php echo the_title()?></option>
    <?php
    }
    ?>
    </select>
    <?php
    /* Restore original Post Data */
    wp_reset_postdata();
  }
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id
 */
function save_servicos_meta_box_data( $post_id ) {
    // Check if our nonce is set.
    if ( ! isset( $_POST['servicos_nonce'] ) ) {
        return;
    }
    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['servicos_nonce'], 'servicos_nonce' ) ) {
        return;
    }
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    }
    else {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }
    /* OK, it's safe for us to save the data now. */
    // Make sure that it is set.
    if ( ! isset( $_POST['cat_select'] ) ) {
        return;
    }
    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['cat_select'] );
    // Update the meta field in the database.
    update_post_meta( $post_id, '_servicos', $my_data);
}
    add_action( 'save_post', 'save_servicos_meta_box_data' );



?>