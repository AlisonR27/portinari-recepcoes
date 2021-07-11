<?php 

function global_metabox_render() {
  add_meta_box(
      'global-notice',
      __( 'Cor da categoria', 'sitepoint' ),
      'global_notice_meta_box_callback',
      'servicos'
  );
}
add_action( 'add_meta_boxes', 'global_metabox_render' );

function global_notice_meta_box_callback( $post ) {
  // Add a nonce field so we can check for it later.
  wp_nonce_field( 'global_notice_nonce', 'global_notice_nonce' );
  $value = get_post_meta( $post->ID, '_global_notice', true );
  echo '<label> Cor: <input type="color" id="global_notice" name="global_notice" value="'.esc_attr( $value ).'"></label>';
}
/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id
 */
function save_global_notice_meta_box_data( $post_id ) {
    // Check if our nonce is set.
    if ( ! isset( $_POST['global_notice_nonce'] ) ) {
        return;
    }
    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['global_notice_nonce'], 'global_notice_nonce' ) ) {
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
    if ( ! isset( $_POST['global_notice'] ) ) {
        return;
    }
    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['global_notice'] );
    // Update the meta field in the database.
    update_post_meta( $post_id, '_global_notice', $my_data );
}
add_action( 'save_post', 'save_global_notice_meta_box_data' );

?>