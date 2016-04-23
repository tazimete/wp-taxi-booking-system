	<?php 

	/**
	Template Name: RDTS Cancel Page
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
				$id = 1;
				$result= $wpdb->query("UPDATE '$table_name' SET status = 2 WHERE booking_id = '$id'");
				if($result){
					 echo $wpdb->insert_id ;
				}else{
					echo 'Empty query';
				}
				
				print_r($result); exit;
	?>

	<?php 

		get_footer();


	?>