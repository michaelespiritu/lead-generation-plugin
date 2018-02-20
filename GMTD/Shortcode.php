<?php

/*
*
* @package Give me that data 
* Text Domain: GMTD 
*
*/

namespace GMTD;

if ( ! class_exists( 'Shortcode' ) ) {
	return null;
}

class Shortcode
{
	
	function __construct()
	{
		
		add_shortcode( 'form', array( $this, 'html' ));
		add_action( 'wp_enqueue_scripts', [ $this , 'style' ] );
		add_action( 'wp_ajax_process_client_post', [ $this, 'process_client_post' ] );
		add_action( 'wp_ajax_nopriv_process_client_post', [ $this, 'process_client_post' ] );

	}

	function style()
	{
		wp_enqueue_style( 'gmtd-front-end', plugins_url( 'assets/dist/css/frontend.min.css', __DIR__ ), '', '1.0' );

		wp_register_script( 'gmtd-validation',  plugins_url( 'node_modules/jquery-validation/dist/jquery.validate.min.js', __DIR__ ), array( 'jquery' ), '1.0' );
		wp_enqueue_script( 'gmtd-validation' );

		wp_register_script( 'gmtd-front-end', plugins_url( 'assets/dist/js/frontend.js', __DIR__ ), array( 'jquery' ), '1.0' );
		wp_enqueue_script( 'gmtd-front-end' );
		wp_localize_script( 'gmtd-front-end', 'ajax_data', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'security' => wp_nonce_field( 'client-data-submit' ) ) );
	}

	function html($atts)
	{
		$atts = shortcode_atts( 
			        array(
			            'name'   => 'Name',
			            'max_name'   => '',
			            'email'   => 'Email',
			            'max_email'   => '',
			            'phonenumber'   => 'Phone Number',
			            'max_phonenumber'   => '',
			            'desiredbudget'   => 'Desired Budget',
			            'max_desiredbudget'   => '',
			            'message'   => 'Message',
			            'max_message'   => '',
			            'row_message'   => '2',
			            'col_message'   => '50',
			        ), $atts );

		ob_start();
		?>
			
			<form id="gmtd-form" method="post" name="client-data" action="">

				<?php  wp_nonce_field( basename( __FILE__ ), 'client-data-submit' ) ?>
				<?php 
					$ip_address = getenv('HTTP_CLIENT_IP') ?: getenv('HTTP_X_FORWARDED_FOR') ?: getenv('HTTP_X_FORWARDED') ?: getenv('HTTP_FORWARDED_FOR') ?: getenv('HTTP_FORWARDED') ?: getenv('REMOTE_ADDR');
					
					// API URL : https://timezoneapi.io/developers/ip-address


					// Get JSON object
					$jsondata = file_get_contents("http://timezoneapi.io/api/ip/?" . $ip_address);

					$response = wp_remote_get( $ip_address  );

					$data = json_decode($jsondata, true);


					// Request OK?
					if($data['meta']['code'] == '200'){

					    // Example: Get the users time
					    echo "<input type='hidden' id='timedate' name='timedate'  value=' " . $data['data']['datetime']['date_time_txt'] . " '>";

					}else{

						date_default_timezone_get();
						echo "<input type='hidden' id='timedate' name='timedate'  value=' " . date('m/d/Y h:i:s a', time()) . " '>";

					}

					
				?>

				<div class="gmtd-fields" >
					<label><?php echo $atts['name']; ?></label>
					<input type="text" id="name" name="name" class="input" placeholder="<?php echo $atts['name']; ?>" maxlength="<?php echo $atts['max_name']; ?>" required>
				</div>

				<div class="gmtd-fields" >
					<label><?php echo $atts['email']; ?></label>
					<input type="email" id="email" name="email" class="input required email" placeholder="<?php echo $atts['email']; ?>" maxlength="<?php echo $atts['max_email']; ?>">
				</div>

				<div class="gmtd-fields" >
					<label><?php echo $atts['phonenumber']; ?></label>
					<input type="text" id="phonenumber" name="phonenumber" class="input required" placeholder="<?php echo $atts['phonenumber']; ?>" maxlength="<?php echo $atts['max_phonenumber']; ?>">
				</div>

				<div class="gmtd-fields" >
					<label><?php echo $atts['desiredbudget']; ?></label>
					<input type="text" id="desiredbudget" name="desiredbudget" class="input required" placeholder="<?php echo $atts['desiredbudget']; ?>" maxlength="<?php echo $atts['max_desiredbudget']; ?>">
				</div>

				<div class="gmtd-fields" >
					<label><?php echo $atts['message']; ?></label>
					<textarea maxlength="<?php echo $atts['max_message']; ?>" id="message" class="input required" rows="<?php echo $atts['row_message']; ?>" cols="<?php echo $atts['col_message']; ?>"></textarea>
				</div>


				<input id="submit_button" type="submit" value="Submit" />
			</form>
			<br>
			<div class="output" ></div>

		<?php

		return ob_get_clean();
		
	}


	function process_client_post()
	{
		

		$client_data = array(
			'post_title' => wp_strip_all_tags( $_POST[ 'data' ][ 'name' ] ),
			'post_status' => 'draft',
			'post_type' => 'client'
		);

		$post_id = wp_insert_post( $client_data, true );
		
		add_post_meta( $post_id, 'client_name', $_POST[ 'data' ][ 'name' ] );
		add_post_meta( $post_id, 'client_email', $_POST[ 'data' ][ 'email' ] );
		add_post_meta( $post_id, 'client_phonenumber', $_POST[ 'data' ][ 'phonenumber' ] );
		add_post_meta( $post_id, 'client_budget', $_POST[ 'data' ][ 'desiredbudget' ] );
		add_post_meta( $post_id, 'client_note', $_POST[ 'data' ][ 'message' ] );
		add_post_meta( $post_id, 'client_timedate', $_POST[ 'data' ][ 'timedate' ] );
		//wp_send_json_success( $post_id );
	}
}


