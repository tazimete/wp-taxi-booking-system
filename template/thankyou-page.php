	<?php 

	/**
	Template Name: RDTS Thank You Page
	**/

		get_header();

	?> 
	
	<div class="container">
		<?php echo the_content(); ?>
		<input type="hidden" value="" id="wprdts-hidden-text-update-status"/>
	</div>
	
	<?php 
		 global $wpdb;
				$table_name = $wpdb->prefix.'wprdts_booking_list';
				$id = '';
				$result= $wpdb->query("UPDATE ".$table_name." SET status = 2 WHERE id = '".$id."'");
				if($result){
					wp_send_json( $wpdb->insert_id );
				}else{
					wp_send_json('Empty query');
				}
				
				print_r($result); exit;
	?>

	<?php 

		get_footer();


	?>