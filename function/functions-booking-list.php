<?php 

	//Get all booking list
	function get_booking_list($data_order){
		global $wpdb;
		$table_name = $wpdb->prefix.'wprdts_booking_list';
		$query = $wpdb->get_results("SELECT * FROM ".$table_name." ORDER BY ".$data_order."");
		//print_r($query);
		if($query){
			return $query;
		}else{
			return false;
		}
	}		//Get edit quote form by id 	function get_edit_quote_form_by_id($quotes){			}		//Delete quote by id	function delete_quote_by_id($quotes){		$results = array();		global $wpdb;		$table_name = $wpdb->prefix.'wprdts_booking_list';				foreach($quotes as $id){			$results[] = $wpdb->delete( $table_name, array( 'booking_id' => $id ) );		}		return $results;	}	//Copy quote by id	 function copy_quote_by_id($quotes){		/*$results = array();						foreach($quotes as $id){			$city = get_city_with_state_by_id($id);			//print_r($city); exit;			global $wpdb;			$table_name = $wpdb->prefix.'wprdts_booking_list';			$data =  array(				"city_name" => $city->city_name,				"city_state_id" => $city->city_state_id,				"city_price" => $city->city_price,				"city_zip_code" => $city->city_zip_code,				"city_status" => $city->city_status			);			//print_r($data); exit;			$results[] = $wpdb->insert($table_name, $data);		}		return $results; */	} 		//Publish quote by id 	function publish_quote_by_id($quotes){		$results = array();						foreach($quotes as $id){			//print_r($cities); exit;			global $wpdb;			$table_name = $wpdb->prefix.'wprdts_booking_list';			//$result = $wpdb->update( $table_name, $data, $where );			$results[] = $wpdb->query("UPDATE $table_name SET status = '2' WHERE booking_id =".$id."");			// print_r($result); exit;			}		return $results;	}		//Unpublish quote by id 	function unpublish_quote_by_id($quotes){		$results = array();				foreach($quotes as $id){			//print_r($cities); exit;			global $wpdb;			$table_name = $wpdb->prefix.'wprdts_booking_list';			//$result = $wpdb->update( $table_name, $data, $where );			$results[] = $wpdb->query("UPDATE $table_name SET status = '1' WHERE booking_id =".$id."");			//echo "fdg"; print_r($result); exit;			}		return $results;	}		//Get single quote bt id 	function get_quote_by_id($id){		global $wpdb;		$table_name = $wpdb->prefix.'wprdts_booking_list';		$query = $wpdb->get_row("SELECT * FROM ".$table_name." WHERE booking_id='".$id."'", ARRAY_A);		//print_r($query);		if($query){			return $query;		}else{			return false;		}	}		//Get full edit  quote form 	function get_full_quote_data_by_id($id){ ?>		<div class="container">			<h2>Quote Details</h2>			<div class="wprdts-quote-details-container"> 			<?php $quote = get_quote_by_id($id);  			//print_r($quote); exit; 			foreach($quote as $key => $value){				$label = str_replace('_',' ', $key);				$label = ucwords(strtolower($label));			?>				<p class="wprdts-quote-item">					<span class="wprdts-quote-label"><?php echo $label; ?> </span>					<span class="wprdts-quote-separator"> : </span>					<span class="wprdts-quote-value"> <?php echo $value; ?> </span>				</p>			<?php } //End of foreach ?>			</div>		</div>	<? }  //End of full quote edit form

	//Making user email template from backend
	function get_user_email_template(){
		//Making email template from backend
				$emailSubject = get_option(WPRDTS_OPTION_CONFIRM_MESSAGE_ADMIN);
				//Email template 
				$emailTemplate = "<div class='wprdts-confirmation-message-page' id='wprdts-confirmation-message-page'> 
					<p class='wprdts-confirmation-name'>Dear ".$name.", Thank you for your order. </p>
					What to do next? <br /> <p class='wprdts-confirmation-message'>Your reservation has been successfully processd. 
					you will be receiving an email comfirmation  of your reservation shortly.  <br /><br> please go over the 
					information you submitted and reply CONFIRM to  complete your reservation. If you have any special 
					request as a: carseat, booster itc,  please indicate that in your email respond. </p> 
					<br> <p class='wprdts-booking-info-title'><u>Booking Info : </u></p> 
					<p class='wprdts-booking-info-field'>Name : ".$name."</p> <p class='wprdts-booking-info-field'>Email : ".$email."</p>
					<p class='wprdts-booking-info-field'>Phone : ".$phone."</p> <p class='wprdts-booking-info-field'>No of passenger : ".$passenger."</p>
					<p class='wprdts-booking-info-field'>No of luggage : ".$luggage."</p> <p class='wprdts-booking-info-field'>Trip Type : ".$tripTypeInText."</p>
					<p class='wprdts-booking-info-field'>Date/Time : ".$trip_date_time."</p> <p class='wprdts-booking-info-field'>Trip Type : ".$tripTypeInText."</p>";
					
				if($round_trip){
					$emailTemplate .= "<p class='wprdts-booking-info-field'>Return Date/Time : ".$return_trip_date_time."</p> <br />";
				}
				
				$emailTemplate	.= "<hr /><p class='wprdts-booking-info-field'>Price : ".$total_price."</p></div> <br /> ";		
				
	}
	

?>