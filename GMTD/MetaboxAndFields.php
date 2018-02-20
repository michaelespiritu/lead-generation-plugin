<?php

/*
*
* @package Give me that data 
* Text Domain: GMTD 
*
*/

namespace GMTD;

if ( ! class_exists( 'MetaboxAndFields' ) ) {
	return null;
}

class MetaboxAndFields {


	function __construct(){

		add_action( 'add_meta_boxes', [$this, 'client_add_metabox'] );
		add_action( 'save_post', [$this, 'client_meta_save' ] );
		add_action( 'admin_enqueue_scripts', [ $this , 'meta_style' ] );

	}


	function meta_style()
	{
		wp_enqueue_style( 'client-admin-css', plugins_url( 'assets/dist/css/admin.min.css', __DIR__ ), '', '1.0' );
	}

	function client_add_metabox() {

		add_meta_box(
			'casa_meta',
			__( 'Client Info' , 'GMTD'),
			[ $this, 'client_meta_callback'],
			'client',
			'normal',
			'core'
		);

	}


	function client_meta_callback( $post ) {
		wp_nonce_field( basename( __FILE__ ), 'client_nonce' );
		$client_stored_meta = get_post_meta( $post->ID ); ?>

		<div class="client-meta-fields">


			<div class="client-row" id="client_name" >

				<div class="client-th">

					<label for="client-name" class="client-row-title"><?php _e( 'Name', 'GMTD' ); ?></label>

				</div>

				<div class="client-td">

					<input type="text" class="client-row-content" name="client_name" id="client-name"
					value="<?php if ( ! empty ( $client_stored_meta['client_name'] ) ) {
						echo esc_attr( $client_stored_meta['client_name'][0] );
					} ?>"/>

				</div>

			</div><!-- /.client-row -->

			<div class="client-row" id="client_email" >

				<div class="client-th">

					<label for="client-email" class="client-row-title"><?php _e( 'Email', 'GMTD' ); ?></label>

				</div>

				<div class="client-td">

					<input type="text" class="client-row-content" name="client_email" id="client-email"
					value="<?php if ( ! empty ( $client_stored_meta['client_email'] ) ) {
						echo esc_attr( $client_stored_meta['client_email'][0] );
					} ?>"/>

				</div>

			</div><!-- /.client-row -->

			<div class="client-row" id="client_phonenumber" >

				<div class="client-th">

					<label for="client-phonenumber" class="client-row-title"><?php _e( 'Phone Number', 'GMTD' ); ?></label>

				</div>

				<div class="client-td">

					<input type="text" class="client-row-content" name="client_phonenumber" id="client-phonenumber"
					value="<?php if ( ! empty ( $client_stored_meta['client_phonenumber'] ) ) {
						echo esc_attr( $client_stored_meta['client_phonenumber'][0] );
					} ?>"/>

				</div>

			</div><!-- /.client-row -->

			<div class="client-row" id="client_budget" >

				<div class="client-th">

					<label for="client-budget" class="client-row-title"><?php _e( 'Desired Budget', 'GMTD' ); ?></label>

				</div>

				<div class="client-td">

					<input type="text" class="client-row-content" name="client_budget" id="client-budget"
					value="<?php if ( ! empty ( $client_stored_meta['client_budget'] ) ) {
						echo esc_attr( $client_stored_meta['client_budget'][0] );
					} ?>"/>

				</div>

			</div><!-- /.client-row -->


			<br>
			<div class="client-row" >

				<div class="client-th">

					<label for="client_note" class="client-row-title"><?php _e( 'Note', 'GMTD' ); ?></label>

				</div>

			</div>

			<div class="client-editor"></div>
			<?php
			$content = get_post_meta( $post->ID, 'client_note', true );
			$editor = 'client_note';
			$settings = array(
				'textarea_rows' => 8,
				'media_buttons' => false,
			);
			wp_editor( $content, $editor, $settings); ?>



			<div class="client-row" id="client_timedate" >

				<div class="client-th">

					<label for="client-budget" class="client-row-title"><?php _e( 'Time and Date', 'GMTD' ); ?></label>

				</div>

				<div class="client-td">

					<input type="text" class="client-row-content" name="client_timedate" id="client-timedate"
					value="<?php if ( ! empty ( $client_stored_meta['client_timedate'] ) ) {
						echo esc_attr( $client_stored_meta['client_timedate'][0] );
					} ?>"/>

				</div>

			</div><!-- /.client-row -->

		</div><!-- /.client-meta-fields -->
		<?php
	}



	function client_meta_save( $post_id ) {
		

		$is_autosave = wp_is_post_autosave( $post_id );
	    $is_revision = wp_is_post_revision( $post_id );
	    $is_valid_nonce = ( isset( $_POST[ 'client_nonce' ] ) && wp_verify_nonce( $_POST[ 'client_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

	    // Exits script depending on save status
	    if ( $is_autosave || $is_revision || !$is_valid_nonce ) 
	    {
	        return;
	    }

	    if ( isset( $_POST[ 'client_name' ] ) ) 
	    {
				update_post_meta( $post_id, 'client_name', sanitize_text_field( $_POST[ 'client_name' ] ) );
		}

	    if ( isset( $_POST[ 'client_email' ] ) ) 
	    {
				update_post_meta( $post_id, 'client_email', sanitize_text_field( $_POST[ 'client_email' ] ) );
		}

	    if ( isset( $_POST[ 'client_phonenumber' ] ) ) 
	    {
				update_post_meta( $post_id, 'client_phonenumber', sanitize_text_field( $_POST[ 'client_phonenumber' ] ) );
		}
		
	    if ( isset( $_POST[ 'client_budget' ] ) ) 
	    {
				update_post_meta( $post_id, 'client_budget', sanitize_text_field( $_POST[ 'client_budget' ] ) );
		}

	    if ( isset( $_POST[ 'client_note' ] ) ) 
	    {
				update_post_meta( $post_id, 'client_note', sanitize_text_field( $_POST[ 'client_note' ] ) );
		}


	}





}
