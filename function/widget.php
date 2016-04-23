<?php

	// Block direct requests
	if ( !defined('ABSPATH') )
		die('-1');

	//Including other files 
	require_once(ABSPATH .'/wp-content/plugins/wp_rd_taxi_system/function/functions-state.php');
	require_once(ABSPATH .'/wp-content/plugins/wp_rd_taxi_system/function/functions-city.php');
	require_once(ABSPATH .'/wp-content/plugins/wp_rd_taxi_system/function/functions-booking-list.php');
	

	class My_Widget extends WP_Widget {
		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'WPRDTS_Widget', // Base ID
				__('WPRDTS Widget', 'text_domain'), // Name
				array( 'description' => __( 'WPRDTS Widget', 'text_domain' ), ) // Args
			);
		}
		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
		
			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}
			 if($value = get_option('wprdts-label-trip-type')) {
				 echo $value; 
			} else { 
				echo 'Select Trip Type '; 
			}
			 
			echo $args['after_widget']; 
			
			//Paypal form information
			$paypalEmail = get_option(WPRDTS_OPTION_PAYPAL_EMAIL);
			$currencySymbol = get_option(WPRDTS_OPTION_CURRENCY);
			$testMode = get_option(WPRDTS_OPTION_PAYPAL_TEST_MODE);
			//$amount = $_POST['price'];
				
				/* add_action();
				function wprdts_custom_page_template(){
					//Custom page template
				$thankyou_page = array(
					'post_type' => 'page',
					'post_title' => 'Thank You',
					'post_content' => 'Thank you. Your payment was successful',
					'post_status' => 'publish',
					'post_author' => 1,
				);
				
				$id_thankyou_page = wp_insert_post($thankyou_page);
				
				$cancel_page = array(
					'post_type' => 'page',
					'post_title' => 'Request Cancelled',
					'post_content' => 'Request cancelled. Try again later with valid information',
					'post_status' => 'publish',
					'post_author' => 1,
				); 
				
				$id_cancel_page = wp_insert_post($cancel_page);
				
				$notify_page = array(
					'post_type' => 'page',
					'post_title' => 'Request Recieved',
					'post_content' => 'Request received',
					'post_status' => 'publish',
					'post_author' => 1,
				); 
				
				$id_notify_page = wp_insert_post($notify_page);
				
				//Addingh page template by page id
				add_filter( 'page_template', 'wprdts_add_custom_page_template' );
					function wprdts_add_custom_page_template( $page_template ) {
							global $post;

							switch ( $post->ID) {

								default :
								case $id_thankyou_page : 
									$page_template = plugins_url() . '/template/thankyou-page.php'; 
									return $single_template;
								break;

								case $id_cancel_page : 
									$page_template = plugins_url() . '/template/cancel-page.php';
									return $page_template;
								break;
								
								case $id_notify_page : 
									$page_template = plugins_url() . '/template/notify-page.php';
									return $page_template;
								break;

							} // end switch

					}
				} */ // End of fumction

				
				//$notifyUrl = admin_url('admin-ajax.php?action=wprdts_ajax_response_paypal_notify_request');
				$notifyUrl = admin_url('admin-ajax.php') .'?action=wprdts_ajax_response_paypal_notify_request';
				$returnUrl = get_permalink(get_option(WPRDTS_OPTION_PAYPAL_RETURN_PAGE));
				$cancelUrl = get_permalink(get_option(WPRDTS_OPTION_PAYPAL_CANCEL_PAGE));
				//$cancelUrl = $notifyUrl;
				
				
				if (!$testMode){
					$paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
				} else{
					$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
				}
			
			
				echo '<form action="'.$paypal_url.'" method="post" id="wprdts-paypal-form" name="wprdts-paypal-form" style="">
							<input type="hidden" name="item_name" value="Taxi Fair">
							<input type="hidden" name="item_number" value="">
							<input type="hidden" name="amount" id="amount" value="">
							<input type="hidden" name="currency_code" value="'.$currencySymbol.'">
							<input type="hidden" name="custom" id="custom" value="">
							<input type="hidden" name="return" value="'.$returnUrl.'">
							<input type="hidden" name="cancel_return" value="'.$cancelUrl.'">
							<input type="hidden" name="notify_url" value="'.$notifyUrl.'">
							<input type="hidden" name="cmd" value="_xclick">
							<input type="hidden" name="no_shipping" value="1">
							<input type="hidden" name="no_note" value="1">
							<input type="hidden" name="business" value="'.$paypalEmail.'">						
						</form>';
					//End of paypal form information
			?>
			
			<form action="#" method="post" id="wprdts-widget-form">
				<?php if(get_option(WPRDTS_OPTION_ENABLE_STATUS_BAR)){ ?>
					<div class="progressbar-container"> 
						<div class="progress-item">
							<span class="icon-container"><i class="fa fa-bookmark"></i></span>
							<span class="progress-title"><?php if($value = get_option('wprdts-label-status-bar-step-one')) echo $value; else { echo 'Book Your Trip '; } ?></span>
						</div>
						<div class="progress-item">
							<span class="icon-container"><i class="fa  fa-calendar"></i></span>
							<span class="progress-title"><?php if($value = get_option('wprdts-label-status-bar-step-two')) echo $value; else { echo 'Trip Date and Time '; } ?> </span>
						</div>
						<div class="progress-item">
							<span class="icon-container"><i class="fa  fa-calendar-check-o"></i></span>
							<span class="progress-title"><?php if($value = get_option('wprdts-label-status-bar-step-three')) echo $value; else { echo 'Checkout '; } ?> </span>
						</div>
						<div class="bar"></div>
					</div>
				<?php } ?>
				
				<div class="wprdts-widget-form-container" id="wprdts-widget-form-container">
					<div class="wprdts-widget-form-header"> 
						<p class="wprdts-widget-price-box" style="text-align: center;"><?php if($value = get_option('wprdts-label-price')) echo $value; else { echo 'Price '; } ?> : <span class="wprdts-price">  </span></p>						
					</div>
					<div class="wprdts-widget-form-body">
						<div class="wprdts-widget-form-element">
							<span class="wprdts-form-label"><label for="wprdts-widget-form-trip-type"> <?php if($value = get_option('wprdts-label-trip-type')) echo $value; else { echo 'Trip Type '; } ?> : </label></span>
							<span class="wprdts-widget-field">
							<select name="wprdts-widget-form-trip-type" id="wprdts-widget-form-trip-type" class="form-control wprdts-widget-form-field wprdts-widget-form-trip-type" required >
								<option value=""> <?php if($value = get_option('wprdts-label-select-trip-type')) echo $value; else { echo 'Select Trip Type '; } ?> </option>
								<option value="1"><?php if($value = get_option('wprdts-label-ride-to-airport')) echo $value; else { echo 'Ride to Airport'; } ?> </option>
								<option value="2"><?php if($value = get_option('wprdts-label-ride-from-airport')) echo $value; else { echo 'Ride from Airport'; } ?> </option>
							</select>
							</span>
						</div>
						<div class="wprdts-widget-form-element wprdts-widget-form-pickup-location-container" id="wprdts-widget-form-pickup-location-container">
							<span class="wprdts-form-label"><label for="wprdts-widget-form-pickup-location"> <?php if($value = get_option('wprdts-label-pickup-location')) echo $value; else { echo 'Pickup Location '; } ?>  : </label></span>
							<span class="wprdts-widget-field icon-place"><input type="text" name="wprdts-widget-form-pickup-location-pre" id="wprdts-widget-form-pickup-location-pre" class="form-control wprdts-widget-form-field wprdts-widget-form-pickup-location" onKeyUp="autoCompleteForPickupLocation(this)" value="" autocomplete="off" required /></span>
						</div>
						<div class="wprdts-widget-form-element wprdts-widget-form-dropoff-location-container" id="wprdts-widget-form-dropoff-location-container">
							<span class="wprdts-form-label"><label for="wprdts-widget-form-dropoff-location"><?php if($value = get_option('wprdts-label-dropoff-location')) echo $value; else { echo 'Dropoff Location '; } ?>  : </label></span>
							<span class="wprdts-widget-field icon-place"><input type="text" name="wprdts-widget-form-dropoff-location-pre" id="wprdts-widget-form-dropoff-location-pre" class="form-control wprdts-widget-form-field wprdts-widget-form-dropoff-location" onKeyUp="autoCompleteForPickupLocation(this)" value="" autocomplete="off" required /></span>
						</div>
						<!-- <div class="wprdts-widget-form-element">
							<span class="wprdts-form-label wprdts-change-label-state"><label for="wprdts-widget-form-state"><?php if($value = get_option('wprdts-label-destination-state')) echo $value; else { echo 'Your Destination State '; } ?>  : </label></span>
							<span class="wprdts-widget-field">
							<select name="wprdts-widget-form-state" id="wprdts-widget-form-state" class="form-control wprdts-widget-form-field wprdts-widget-form-state" disabled="disabled" required >
								<option value=""> <?php if($value = get_option('wprdts-label-select-state')) echo $value; else { echo '--Select State--'; } ?>  </option>
								<?php $states = get_all_state("state_name ASC"); 
								  foreach($states as $state) { ?>
								<option value="<?php echo $state->id; ?>"> <?php echo $state->state_name; ?> </option>
								  <?php } ?>
							</select>
							</span>
						</div> -->
						<!--<div class="wprdts-widget-form-element">
							<span class="wprdts-form-label wprdts-change-label-city"><label for="wprdts-widget-form-city"><?php if($value = get_option('wprdts-label-destination-city-zip')) echo $value; else { echo 'Your Destination City/Zip '; } ?>  : </label></span>
							<span class="wprdts-widget-field"><input type="text" name="wprdts-widget-form-city" id="wprdts-widget-form-city" class="form-control wprdts-widget-form-field wprdts-widget-form-city" disabled="disabled" autocomplete="off" required/></span>
							<div class="wprdts-input-dropdown-container">
								<ul></ul>
							</div>
						</div> -->
						<div class="wprdts-widget-form-element">
							<span class="wprdts-form-label"><label for="wprdts-widget-form-passenger"><?php if($value = get_option('wprdts-label-number-of-passenger')) echo $value; else { echo 'No Of Passengers '; } ?>  : </label></span>
							<span class="wprdts-widget-field">
								<select name="wprdts-widget-form-passenger" id="wprdts-widget-form-passenger" class="form-control wprdts-widget-form-field wprdts-widget-form-passenger" disabled="disabled" required >
									<option value=""> <?php if($value = get_option('wprdts-label-select-passenger')) echo $value; else { echo '--Select Passenger--'; } ?>  </option>
									<?php for($i=1; $i<14; $i++){ ?>
									<option value="<?php echo $i; ?>"><?php echo $i; ?> <?php if($value = get_option('wprdts-label-passenger')) echo $value; else { echo 'Passengers'; } ?> </option>
									<?php } ?>
								</select>
							</span>
						</div>
						<div class="wprdts-widget-form-element">
							<span class="wprdts-form-label"><label for="wprdts-widget-form-luggage"> <?php if($value = get_option('wprdts-label-number-of-luggage')) echo $value; else { echo 'No Of Luggages '; } ?>  : </label></span>
							<span class="wprdts-widget-field">
								<select name="wprdts-widget-form-luggage" id="wprdts-widget-form-luggage" class="form-control wprdts-widget-form-field wprdts-widget-form-luggage" disabled="disabled" required >
									<option value=""> <?php if($value = get_option('wprdts-label-select-luggage')) echo $value; else { echo '--Select Luggage--'; } ?>  </option>
									<?php for($i=1; $i<13; $i++){ ?>
									<option value="<?php echo $i; ?>"><?php echo $i; ?> <?php if($value = get_option('wprdts-label-luggage')) echo $value; else { echo 'Luggages'; } ?> </option>
									<?php } ?>
								</select>
							</span>
						</div>
						<div class="wprdts-widget-form-element">
							<span class="wprdts-form-label"><label for="wprdts-widget-form-round-trip"><?php if($value = get_option('wprdts-label-round-trip')) echo $value; else { echo 'Round Trip'; } ?>  : </label></span>
								<p class="field switch" disabled="disabled">
									<label class="cb-enable selected"><span>Yes</span></label>
									<label class="cb-disable"><span>No</span></label>
									<input type="checkbox" id="checkbox" class="checkbox" name="field2" checked="checked" />
								</p>
								<span class="wprdts-widget-field">
									<input type="radio" class="form-control wprdts-widget-form-round-trip" name="wprdts-widget-form-round-trip" id="wprdts-widget-form-round-trip" value="0" disabled="disabled"/> <!-- <?php if($value = get_option('wprdts-label-no')) echo $value; else { echo 'No'; } ?>  -->
									<input type="radio" class="form-control wprdts-widget-form-round-trip" name="wprdts-widget-form-round-trip" id="wprdts-widget-form-round-trip" value="1" checked="checked" disabled="disabled"/> <!-- <?php if($value = get_option('wprdts-label-yes')) echo $value; else { echo 'Yes'; } ?> -->
								</span>
						</div>
						<div class="wprdts-widget-form-element">
							<span class="wprdts-widget-field"> 
								<input type="button" name="wprdts-widget-form-continue" id="wprdts-widget-form-continue" class="wprdts-widget-form-field wprdts-widget-form-btn-continue" value="<?php if($value = get_option('wprdts-label-continue-button')) echo $value; else { echo 'Continue'; } ?>"/> 
							</span>
						</div>
					</div>
					<div class="wprdts-form-part-two">
						<div class="wprdts-widget-form-element">
							<span class="wprdts-form-label"><label for="wprdts-widget-form-vehicle-type"> <?php if($value = get_option('wprdts-label-vehicle-type')) echo $value; else { echo 'Vehicle Type '; } ?>  : </label></span>
							<span class="wprdts-widget-field">
								<select name="wprdts-widget-form-vehicle-type" id="wprdts-widget-form-vehicle-type" class="form-control wprdts-widget-form-field wprdts-widget-form-vehicle-type" required >
									<option value=""> <?php if($value = get_option('wprdts-label-select-vehicle')) echo $value; else { echo '--Select Vehicle Type--'; } ?>  </option>
									<option value="1"> Sedan (1-4 passengers) </option>
									<option value="2"> Minivan (1-6 passengers) </option>
									<option value="3"> SUV (1-6 passengers) </option>
									<option value="4"> VAN (up to 9 passengers) </option>
									<option value="5"> VAN (up to 13 passengers) </option>
								</select>
							</span>
						</div>
						<div class="wprdts-widget-form-element">
							<span class="wprdts-form-label"><label for="wprdts-widget-form-seat-infant"> <?php if($value = get_option('wprdts-label-seat-infant')) echo $value; else { echo 'Infant Seat '; } ?>  : </label></span>
							<span class="wprdts-widget-field">
								<select name="wprdts-widget-form-seat-infant" id="wprdts-widget-form-seat-infant" class="form-control wprdts-widget-form-field wprdts-widget-form-seat-infant" required >
									<option value=""> <?php if($value = get_option('wprdts-label-select-seat-infant')) echo $value; else { echo '--Select Seat--'; } ?>  </option>
									<option value="1"> 1 </option>
									<option value="2"> 2 </option>
									<option value="3"> 3 </option>
								</select>
							</span>
						</div>
						<div class="wprdts-widget-form-element">
							<span class="wprdts-form-label"><label for="wprdts-widget-form-seat-booster"> <?php if($value = get_option('wprdts-label-seat-booster')) echo $value; else { echo 'Booster Seat '; } ?>  : </label></span>
							<span class="wprdts-widget-field">
								<select name="wprdts-widget-form-seat-booster" id="wprdts-widget-form-seat-booster" class="form-control wprdts-widget-form-field wprdts-widget-form-seat-booster" required >
									<option value=""> <?php if($value = get_option('wprdts-label-select-seat-booster')) echo $value; else { echo '--Select Seat--'; } ?>  </option>
									<option value="1"> 1 </option>
									<option value="2"> 2 </option>
									<option value="3"> 3 </option>
								</select>
							</span>
						</div>
						<div class="wprdts-widget-form-element">
							<span class="wprdts-form-label"><label for="wprdts-widget-form-trip-date"> <?php if($value = get_option('wprdts-label-trip-date')) echo $value; else { echo 'Trip Date'; } ?>  : </label></span>
							<span class="wprdts-widget-field icon-calender"><input type="text" name="wprdts-widget-form-trip-date" id="wprdts-widget-form-trip-date" class="form-control wprdts-widget-form-field wprdts-widget-form-trip-date" autocomplete="off" required /></span>
						</div>
						<div class="wprdts-widget-form-element">
							<span class="wprdts-form-label"><label for="wprdts-widget-form-trip-time-hour"> <?php if($value = get_option('wprdts-label-trip-time')) echo $value; else { echo 'Trip Time '; } ?> : </label></span>
							<span class="wprdts-widget-field icon-clock">
								<!-- <select name="wprdts-widget-form-trip-time-hour" id="wprdts-widget-form-trip-time-hour" class="form-control wprdts-widget-form-field wprdts-widget-form-trip-time-hour" required >
									<option value="">HH</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
								</select>
								<select name="wprdts-widget-form-trip-time-minute" id="wprdts-widget-form-trip-time-minute" class="form-control wprdts-widget-form-field wprdts-widget-form-trip-time-minute" required >
									<option value="">MM</option>
									<option value="00">00</option>
									<option value="15">15</option>
									<option value="30">30</option>
									<option value="45">45</option>
								</select>
								<select name="wprdts-widget-form-trip-time-am-pm" id="wprdts-widget-form-trip-time-am-pm" class="form-control wprdts-widget-form-field wprdts-widget-form-trip-time-am-pm" required >
									<option value="">--</option>
									<option value="AM">AM</option>
									<option value="PM">PM</option>
								</select> -->
								<input type="text" name="wprdts-widget-form-trip-time" id="wprdts-widget-form-trip-time" class="form-control wprdts-widget-form-trip-time" autocomplete="off"/>
							</span>
						</div>
						<div class="wprdts-widget-form-element wprdts-widget-form-pickup-location-container">
							<span class="wprdts-form-label"><label for="wprdts-widget-form-pickup-location"> <?php if($value = get_option('wprdts-label-pickup-location')) echo $value; else { echo 'Pickup Location '; } ?>  : </label></span>
							<span class="wprdts-widget-field icon-place"><input type="text" name="wprdts-widget-form-pickup-location" id="wprdts-widget-form-pickup-location" class="form-control wprdts-widget-form-field wprdts-widget-form-pickup-location" onKeyUp="autoCompleteForPickupLocation(this)" value="" autocomplete="off" required /></span>
						</div>
						<div class="wprdts-widget-form-element wprdts-widget-form-dropoff-location-container">
							<span class="wprdts-form-label"><label for="wprdts-widget-form-dropoff-location"><?php if($value = get_option('wprdts-label-dropoff-location')) echo $value; else { echo 'Dropoff Location '; } ?>  : </label></span>
							<span class="wprdts-widget-field icon-place"><input type="text" name="wprdts-widget-form-dropoff-location" id="wprdts-widget-form-dropoff-location" class="form-control wprdts-widget-form-field wprdts-widget-form-dropoff-location" onKeyUp="autoCompleteForPickupLocation(this)" value="" autocomplete="off" required /></span>
						</div>
						<div class="wprdts-widget-form-element">
							<span class="wprdts-form-label"><label for="wprdts-widget-form-airline-details"> <?php if($value = get_option('wprdts-label-airline-details')) echo $value; else { echo 'Airline Details '; } ?>  : </label></span>
							<span class="wprdts-widget-field icon-plane"><input type="text" name="wprdts-widget-form-airline-details" id="wprdts-widget-form-airline-details" class="form-control wprdts-widget-form-field wprdts-widget-form-airline-details" autocomplete="off" required /></span>
						</div>
						<div class="wprdts-widget-form-element">
							<span class="wprdts-form-label"><label for="wprdts-widget-form-flight-number"> <?php if($value = get_option('wprdts-label-flight-number')) echo $value; else { echo 'Flight Number '; } ?>  : </label></span>
							<span class="wprdts-widget-field icon-plane"><input type="text" name="wprdts-widget-form-flight-number" id="wprdts-widget-form-flight-number" class="form-control wprdts-widget-form-field wprdts-widget-form-flight-number" autocomplete="off" required /></span>
						</div>
						
						<!-- Return Info Form-->
						<div class="wprdts-form-return-info" id="wprdts-form-return-info"> 
							<div class="wprdts-widget-form-element">
							<span class="wprdts-form-label"><label for="wprdts-widget-form-return-trip-date"><?php if($value = get_option('wprdts-label-return-trip-date')) echo $value; else { echo 'Return Trip Date '; } ?>  : </label></span>
							<span class="wprdts-widget-field icon-calender"><input type="text" name="wprdts-widget-form-return-trip-date" id="wprdts-widget-form-return-trip-date" class="form-control wprdts-widget-form-field wprdts-widget-form-return-trip-date" autocomplete="off" /></span>
							</div>
							<div class="wprdts-widget-form-element">
								<span class="wprdts-form-label"><label for="wprdts-widget-form-return-trip-time-hour"><?php if($value = get_option('wprdts-label-return-trip-time')) echo $value; else { echo 'Return Trip Time '; } ?>  : </label></span>
								<span class="wprdts-widget-field icon-clock">
									<!-- <select name="wprdts-widget-form-return-trip-time-hour" id="wprdts-widget-form-return-trip-time-hour" class="form-control wprdts-widget-form-field wprdts-widget-form-return-trip-time-hour" >
										<option value="">HH</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
									</select>
									<select name="wprdts-widget-form-return-trip-time-minute" id="wprdts-widget-form-return-trip-time-minute" class="form-control wprdts-widget-form-field wprdts-widget-form-return-trip-time-minute" >
										<option value="">MM</option>
										<option value="00">00</option>
										<option value="15">15</option>
										<option value="30">30</option>
										<option value="45">45</option>
									</select>
									<select name="wprdts-widget-form-return-trip-time-am-pm" id="wprdts-widget-form-return-trip-time-am-pm" class="form-control wprdts-widget-form-field wprdts-widget-form-return-trip-time-am-pm" >
										<option value="">--</option>
										<option value="AM">AM</option>
										<option value="PM">PM</option>
									</select> -->
									<input type="text" name="wprdts-widget-form-return-trip-time" id="wprdts-widget-form-return-trip-time" class="form-control wprdts-widget-form-return-trip-time" autocomplete="off"/>
								</span>
							</div>
							<div class="wprdts-widget-form-element wprdts-widget-form-return-pickup-location-container">
								<span class="wprdts-form-label"><label for="wprdts-widget-form-return-pickup-location"><?php if($value = get_option('wprdts-label-return-pickup-location')) echo $value; else { echo 'Return Pickup Location '; } ?>  : </label></span>
								<span class="wprdts-widget-field icon-place"><input type="text" name="wprdts-widget-form-return-pickup-location" id="wprdts-widget-form-return-pickup-location" class="form-control wprdts-widget-form-field wprdts-widget-form-return-pickup-location" onKeyUp="autoCompleteForPickupLocation(this)" autocomplete="off" /></span>
							</div>
							<div class="wprdts-widget-form-element wprdts-widget-form-return-dropoff-location-container">
								<span class="wprdts-form-label"><label for="wprdts-widget-form-return-dropoff-location"><?php if($value = get_option('wprdts-label-return-dropoff-location')) echo $value; else { echo 'Return Dropoff Location '; } ?>  : </label></span>
								<span class="wprdts-widget-field icon-place"><input type="text" name="wprdts-widget-form-return-dropoff-location" id="wprdts-widget-form-return-dropoff-location" class="form-control wprdts-widget-form-field wprdts-widget-form-return-dropoff-location" onKeyUp="autoCompleteForPickupLocation(this)" autocomplete="off" /></span>
							</div>
							<div class="wprdts-widget-form-element">
								<span class="wprdts-form-label"><label for="wprdts-widget-form-return-airline-details"><?php if($value = get_option('wprdts-label-return-airline-details')) echo $value; else { echo 'Return Airline Details '; } ?>  : </label></span>
								<span class="wprdts-widget-field icon-plane"><input type="text" name="wprdts-widget-form-return-airline-details" id="wprdts-widget-form-return-airline-details" class="form-control wprdts-widget-form-field wprdts-widget-form-return-airline-details" autocomplete="off" /></span>
							</div>
							<div class="wprdts-widget-form-element">
								<span class="wprdts-form-label"><label for="wprdts-widget-form-return-flight-number"><?php if($value = get_option('wprdts-label-return-flight-number')) echo $value; else { echo 'Return Flight Number '; } ?>  : </label></span>
								<span class="wprdts-widget-field icon-plane"><input type="text" name="wprdts-widget-form-return-flight-number" id="wprdts-widget-form-return-flight-number" class="form-control wprdts-widget-form-field wprdts-widget-form-return-flight-number" autocomplete="off" /></span>
							</div>
						</div> <!-- End of Return Info Form-->
						
						<div class="wprdts-widget-form-element">
							<span class="wprdts-form-label"><label for="wprdts-widget-form-your-name"><?php if($value = get_option('wprdts-label-name')) echo $value; else { echo 'Your Name '; } ?>  : </label></span>
							<span class="wprdts-widget-field icon-person"><input type="text" name="wprdts-widget-form-your-name" id="wprdts-widget-form-your-name" class="form-control wprdts-widget-form-field wprdts-widget-form-your-name" autocomplete="off" required /></span>
						</div>
						<div class="wprdts-widget-form-element">
							<span class="wprdts-form-label"><label for="wprdts-widget-form-your-email"> <?php if($value = get_option('wprdts-label-email')) echo $value; else { echo 'Your Email '; } ?>  : </label></span>
							<span class="wprdts-widget-field icon-email"><input type="email" name="wprdts-widget-form-your-email" id="wprdts-widget-form-your-email" class="form-control wprdts-widget-form-field wprdts-widget-form-your-email" autocomplete="off" required /></span>
						</div>
						<div class="wprdts-widget-form-element">
							<span class="wprdts-form-label"><label for="wprdts-widget-form-your-email"><?php if($value = get_option('wprdts-label-phone')) echo $value; else { echo 'Your Phone '; } ?>  : </label></span>
							<span class="wprdts-widget-field icon-phone"><input type="text" name="wprdts-widget-form-your-phone" id="wprdts-widget-form-your-phone" class="form-control wprdts-widget-form-field wprdts-widget-form-your-phone" autocomplete="off" required /></span>
						</div>
						<div class="wprdts-widget-form-element">
							<span class="wprdts-widget-field"> 
								<input type="submit" name="wprdts-widget-form-submit" id="wprdts-widget-form-submit" class="wprdts-widget-form-field wprdts-widget-form-btn-submit" value="<?php if($value = get_option('wprdts-label-submit-button')) echo $value; else { echo 'Continue '; } ?>"/>
							</span>
						</div>
					</div>
					<div class="wprdts-widget-form-footer"> 
						<p class="discount-message-box"> 
							<?php 
								if($value = (int) get_option(WPRDTS_OPTION_DISCOUNT)) {
									if($value == 1){
										$discountAmount = get_option(WPRDTS_OPTION_DISCOUNT_AMOUNT_PERCENT).'%';
									} else if($value == 2){
										$discountAmount = get_option(WPRDTS_OPTION_CURRENCY).' '.(int) get_option(WPRDTS_OPTION_DISCOUNT_AMOUNT_FIXED);
									}
									
									if($discountMessage = get_option(WPRDTS_OPTION_DISCOUNT_MESSAGE)){
										$discountMessage  = str_replace('[DISCOUNT]', $discountAmount, $discountMessage );
									}
									echo $discountMessage;
								}
							?> 
						</p>
						<p class="wprdts-widget-price-box"><?php if($value = get_option('wprdts-label-price')) echo $value; else { echo 'Price '; } ?> : <span class="wprdts-price">  </span></p>
						<?php if($value = (int) get_option(WPRDTS_OPTION_DISCOUNT)) { ?>
							<p class="wprdts-widget-discount-box"><?php if($value = get_option('wprdts-label-total-price')) echo $value; else { echo 'Total Price '; } ?> : <span class="wprdts-discount" id="wprdts-discount">  </span></p>
						<?php } ?>
					</div>
					<input type="hidden" name="wprdts-widget-form-main-location" id="wprdts-widget-form-main-location" class="wprdts-widget-form-field wprdts-widget-form-main-location" value="<?php if($value = get_option(WPRDTS_OPTION_MAIN_LOCATION)) echo $value; ?>" />
					<input type="hidden" name="wprdts-widget-form-currency" id="wprdts-widget-form-currency" class="wprdts-widget-form-field wprdts-widget-form-currency" value="<?php if($value = get_option(WPRDTS_OPTION_CURRENCY)) echo $value; ?>" />
					<input type="hidden" name="wprdts-widget-form-price-per-km" id="wprdts-widget-form-price-per-km" class="wprdts-widget-form-field wprdts-widget-form-price-per-km" value="<?php if($value = get_option(WPRDTS_OPTION_PRICE_PER_KM)) echo $value; ?>" />
					<input type="hidden" name="wprdts-widget-form-additional-price-one" id="wprdts-widget-form-additional-price-one" class="wprdts-widget-form-field wprdts-widget-form-additional-price-one" value="<?php if($value = get_option(WPRDTS_OPTION_ADDITIONAL_PRICE_ONE)) echo $value; ?>" />
					<input type="hidden" name="wprdts-widget-form-additional-price-two" id="wprdts-widget-form-additional-price-two" class="wprdts-widget-form-field wprdts-widget-form-additional-price-two" value="<?php if($value = get_option(WPRDTS_OPTION_ADDITIONAL_PRICE_TWO)) echo $value; ?>" />
					<input type="hidden" name="wprdts-widget-hidden-form-discount" id="wprdts-widget-hidden-form-discount" class="wprdts-widget-form-field wprdts-widget-hidden-form-discount" value="<?php if($value = get_option(WPRDTS_OPTION_DISCOUNT)) echo $value; ?>" />
					<input type="hidden" name="wprdts-widget-hidden-form-discount-amount-percent" id="wprdts-widget-hidden-form-discount-amount-percent" class="wprdts-widget-form-field wprdts-widget-hidden-form-discount-amount-percent" value="<?php if($value = get_option(WPRDTS_OPTION_DISCOUNT_AMOUNT_PERCENT)) echo $value; ?>" />
					<input type="hidden" name="wprdts-widget-hidden-form-discount-amount-fixed" id="wprdts-widget-hidden-form-discount-amount-fixed" class="wprdts-widget-form-field wprdts-widget-hidden-form-discount-amount-fixed" value="<?php if($value = get_option(WPRDTS_OPTION_DISCOUNT_AMOUNT_FIXED)) echo $value; ?>" />
					
					<input type="hidden" name="wprdts-widget-hidden-form-discount-message" id="wprdts-widget-hidden-form-discount-message" class="wprdts-widget-form-field wprdts-widget-hidden-form-discount-message" value="<?php if($value = get_option(WPRDTS_OPTION_DISCOUNT_AMOUNT_FIXED)) echo $value; ?>" />
					<input type="hidden" name="wprdts-widget-form-enable-paypal" id="wprdts-widget-form-enable-paypal" class="wprdts-widget-form-field wprdts-widget-form-enable-paypal" value="<?php if($value = get_option(WPRDTS_OPTION_ENABLE_PAYPAL)) echo $value; ?>" />
					<input type="hidden" name="wprdts-widget-form-return-url" id="wprdts-widget-form-return-url" class="wprdts-widget-form-field wprdts-widget-form-return-url" value="<?php echo $returnUrl ?>" />
					<input type="hidden" name="wprdts-widget-form-notify-url" id="wprdts-widget-form-notify-url" class="wprdts-widget-form-field wprdts-widget-form-notify-url" value="<?php echo $notifyUrl ?>" />
				</div>
				<div class="wprdts-checkout-form-container" id="wprdts-checkout-form-container"></div>
				<div class="wprdts-preloader-container" id="wprdts-preloader-container"> 
					<img src="<?php echo plugins_url(); ?>/wp_rd_taxi_system/img/preloader.GIF" alt="" class="wprdts-preloader-icon" />
				</div>
			</form>
			
			<?php 				
				
				
						
				?>
			
		<?php }
	
		
		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {
			if ( isset( $instance[ 'title' ] ) ) {
				$title = $instance[ 'title' ];
			}
			else {
				$title = __( 'New title', 'text_domain' );
			}
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<?php 
		}
		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			return $instance;
		}
	}
	
	//Ajax initializing
	function wprdts_ajax_find_city(){
		add_action('wp_ajax_wprdts_ajax_response', 'wprdts_ajax_find_city_process');
		add_action('wp_ajax_nopriv_wprdts_ajax_response', 'wprdts_ajax_find_city_process');
	}
	
	//Ajax request proccesing 
	function wprdts_ajax_find_city_process(){
		if(isset($_POST['keyword'])){
			$keyword = $_POST['keyword'];
			$stateId = (int) $_POST['stateId'];
			if(is_numeric($keyword)){
				$data_order = "city_zip_code ASC";
			} else{
				$data_order = "city_name DESC";
			}
			$cities = get_city_by_name_or_zipcode($keyword, $stateId, $data_order);
			//echo "<pre>"; print_r($cities); echo "</pre>"; exit;
			
			if($cities){
				wp_send_json($cities);
			}else{
				wp_send_json(0);
			}
			
		}
	}
	
	//Ajax initializing
	function wprdts_ajax_get_distance(){
		add_action('wp_ajax_wprdts_ajax_response_get_distance', 'wprdts_ajax_get_distance_proccess');
		add_action('wp_ajax_nopriv_wprdts_ajax_response_get_distance', 'wprdts_ajax_get_distance_proccess');
	}
	
	//Ajax request proccesing 
	function wprdts_ajax_get_distance_proccess(){
		if(isset($_POST['addressTo'])){
			$addressTo = $_POST['addressTo'];
			$addressFrom = $_POST['addressFrom'];
			$mainLocation = urlencode($_POST['mainLocation']);
			$from = urlencode($addressFrom);
			$to = urlencode($addressTo);
			$mode = 'driving';
			$units = 'imperial'; 
			//$lang = 'en-GB';
			$base_url = 'http://maps.googleapis.com/maps/api/directions/json?sensor=false';

			//$distnceFromMainLocation = simplexml_load_file($base_url."&origin=".$mainLocation."&destination=".$from."&mode=".$mode."&units=".$units);
			//$distnceFromPickupLocation = simplexml_load_file($base_url."&origin=".$from."&destination=".$to."&mode=".$mode."&units=".$units);
			
			//$distance = (float) $distnceFromMainLocation->route->leg->distance->text;
			//$distance = (float)$distnceFromPickupLocation->route->leg->distance->text;
			//$distance = (float) $distnceFromMainLocation->route->leg->distance->text + (float) $distnceFromPickupLocation->route->leg->distance->text;

			$locationsUrl = $base_url."&origin=".$to."&destination=".$from."&mode=".$mode."&units=".$units ;
			
			//Distance from pickup location
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $locationsUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$distanceData = curl_exec($ch);
			curl_close($ch);
			$distanceData = json_decode($distanceData, TRUE);
			$distance = (float) $distanceData['routes'][0]['legs'][0]['distance']['text'];
			
			//$totalDistance = $distnceFromMainLocation + $distnceFromPickupLocation;
			
			//echo "<pre>"; print_r($distnceFromMainLocation); echo "</pre>"; exit;
			wp_send_json($distance);
			//echo $distnceFromMainLocation;
		}
	}
	
	
	//Ajax initializing
	function wprdts_ajax_booking_request(){
		add_action('wp_ajax_wprdts_ajax_response_booking_request', 'wprdts_ajax_booking_request_proccess');
		add_action('wp_ajax_nopriv_wprdts_ajax_response_booking_request', 'wprdts_ajax_booking_request_proccess');
	}
	
	//Proccessing booking request
	function wprdts_ajax_booking_request_proccess(){
		if(isset($_POST['action'])){
			if($_POST['requestFor'] == 'wprdts_booking_request'){
				$trip_type = trim($_POST['tripType']);
				$passenger = trim($_POST['numberOfPassenger']);
				$luggage = trim($_POST['numberOfluggage']);
				$round_trip = trim($_POST['roundTrip']);
				$vehicle_type = trim($_POST['vehicleType']);
				$infant_seat = trim($_POST['seatInfant']);
				$booster_seat = trim($_POST['seatBooster']);
				$trip_date =  trim($_POST['tripDate']);
				$trip_time =  trim($_POST['tripTime']);
				$return_trip_date =  trim($_POST['returnTripDate']);
				$return_trip_time =  trim($_POST['returnTripTime']);
				$pickup_location =  trim($_POST['pickupLocation']);
				$return_pickup_location =  trim($_POST['returnPickupLocation']);
				$dropoff_location =  trim($_POST['dropoffLocation']);
				$return_dropoff_location =  trim($_POST['returnDropoffLocation']);
				$airline_details =  trim($_POST['arilineDetails']);
				$return_airline_details =  trim($_POST['returnArilineDetails']);
				$flight_number =  trim($_POST['flightNumber']);
				$return_flight_number =  trim($_POST['returnFlightNumber']);
				$name =  trim($_POST['yourName']);
				$email =  trim($_POST['yourEmail']);
				$phone =  trim($_POST['yourPhone']);
				$status =  trim($_POST['status']);
				$currency = get_option(WPRDTS_OPTION_CURRENCY);
				$total_price =  $currency." ".trim($_POST['price']);
				
				/* $trip_time = $timeHour.':'.$timeMinute.' '.$timeAmPm; */
				$timestmp = $trip_date." ".$trip_time;
				$dateTime = strtotime($timestmp);
				$trip_date_time = date('d-M-Y  l  h:i A', $dateTime);
				
				/* $return_trip_time = $returnTimeHour.':'.$returnTimeMinute.' '.$returnTimeAmPm; */
				$return_timestmp = $return_trip_date." ".$return_trip_time;
				$returnDateTime = strtotime($return_timestmp);
				$return_trip_date_time = date('d-M-Y  l  h:i A', $returnDateTime); 
				
				/* if($trip_type == 1){
					$pickup_state_id = trim($_POST['destinationState']);
					$pickup_city = trim($_POST['destinationCity']);
				} else if($trip_type == 2){
					$destination_state_id = trim($_POST['destinationState']);
					$destination_city = trim($_POST['destinationCity']);
				} */
	
				$data =  array(
					"trip_type" => (int) $trip_type,
					//"destination_state_id" => (int) $destination_state_id,
					//"destination_city" => $destination_city,
					//"pickup_state_id" => (int) $pickup_state_id,
					//"pickup_city" => $pickup_city,
					"passenger" => (int) $passenger,
					"luggage" => (int) $luggage,
					"round_trip" => (int) $round_trip,
					"vehicle_type" => (int) $vehicle_type,
					"infant_seat" => (int) $infant_seat,
					"booster_seat" => (int) $booster_seat,
					"trip_date_time" => $trip_date_time,
					"return_trip_date_time" => $return_trip_date_time,
					"pickup_location" => $pickup_location,
					"return_pickup_location" => $return_pickup_location,
					"dropoff_location" => $dropoff_location,
					"return_dropoff_location" => $return_dropoff_location,
					"airline_details" => $airline_details,
					"return_airline_details" => $return_airline_details,
					"flight_number" => $flight_number,
					"return_flight_number" => $return_flight_number,
					"name" => $name,
					"email" => $email,
					"phone" => $phone,
					"total_price" => $total_price,
					"status" => $status
				);
				//print_r($data);
				global $wpdb;
				$table_name = $wpdb->prefix.'wprdts_booking_list';
				$result= $wpdb->insert($table_name, $data);
				if($result){
					wp_send_json( $wpdb->insert_id );
				}else{
					wp_send_json('Empty query');
				}
				
			} else{
				wp_send_json("Invalid action");
			}
			
			} else {
			wp_send_json("Failed to add in database");
		}
	}
	
	//Ajax initializing
	 function wprdts_ajax_chekout_page_request(){
		add_action('wp_ajax_wprdts_ajax_response_checkout_form_request', 'wprdts_checkout_page_request_proccess');
		add_action('wp_ajax_nopriv_wprdts_ajax_response_checkout_form_request', 'wprdts_checkout_page_request_proccess');
	} 
	
	
	//Ajax for checkout information
 	function wprdts_checkout_page_request_proccess(){
		//Paypal form 
		if(isset($_POST['requestFor'])){
			if($_POST['requestFor'] == 'wprdts_checkout_form_request'){
				$trip_type = trim($_POST['tripType']);
				$passenger = trim($_POST['numberOfPassenger']);
				$luggage = trim($_POST['numberOfluggage']);
				$round_trip = trim($_POST['roundTrip']);
				$vehicle_type = trim($_POST['vehicleType']);
				$infant_seat = trim($_POST['seatInfant']);
				$booster_seat = trim($_POST['seatBooster']);
				$trip_date =  trim($_POST['tripDate']);
				$trip_time =  trim($_POST['tripTime']);
				$return_trip_date =  trim($_POST['returnTripDate']);
				$return_trip_time =  trim($_POST['returnTripTime']);
				$pickup_location =  trim($_POST['pickupLocation']);
				$return_pickup_location =  trim($_POST['returnPickupLocation']);
				$dropoff_location =  trim($_POST['dropoffLocation']);
				$return_dropoff_location =  trim($_POST['returnDropoffLocation']);
				$airline_details =  trim($_POST['arilineDetails']);
				$return_airline_details =  trim($_POST['returnArilineDetails']);
				$flight_number =  trim($_POST['flightNumber']);
				$return_flight_number =  trim($_POST['returnFlightNumber']);
				$name =  trim($_POST['yourName']);
				$email =  trim($_POST['yourEmail']);
				$phone =  trim($_POST['yourPhone']);
				$status =  trim($_POST['status']);
				$currency = get_option(WPRDTS_OPTION_CURRENCY);
				$total_price =  $currency." ".trim($_POST['price']);
				
				/* $trip_time = $timeHour.':'.$timeMinute.' '.$timeAmPm; */
				$timestmp = $trip_date." ".$trip_time;
				$dateTime = strtotime($timestmp);
				$trip_date_time = date('d-M-Y  l  h:i A', $dateTime);
				
				/* $return_trip_time = $returnTimeHour.':'.$returnTimeMinute.' '.$returnTimeAmPm; */
				$return_timestmp = $return_trip_date." ".$return_trip_time;
				$returnDateTime = strtotime($return_timestmp);
				$return_trip_date_time = date('d-M-Y  l  h:i A', $returnDateTime);
				
				if($trip_type == 1){
					//$pickup_state_id = trim($_POST['destinationState']);
					//$pickup_city = trim($_POST['destinationCity']);
					$tripTypeInText = 'Ride to Airport';
				} else if($trip_type == 2){
					//$destination_state_id = trim($_POST['destinationState']);
					//$destination_city = trim($_POST['destinationCity']);
					$tripTypeInText = 'Ride from Airport';
				}
				
				//Making email template from backend
				$emailSubjectForUser = get_option(WPRDTS_OPTION_CONFIRM_SUBJECT_USER);
				$emailSubjectForAdmin = get_option(WPRDTS_OPTION_CONFIRM_SUBJECT_ADMIN);
				
				$emailMessageForUser = get_option(WPRDTS_OPTION_CONFIRM_EMAIL_USER);
				$emailMessageForAdmin = get_option(WPRDTS_OPTION_CONFIRM_EMAIL_ADMIN);
				$confirmationMessageForUser = get_option(WPRDTS_OPTION_CONFIRM_MESSAGE_USER);
				
				$emailAdminName = get_option(WPRDTS_OPTION_ADMIN_NAME);
				$emailAdminEmail = get_option(WPRDTS_OPTION_ADMIN_EMAIL);
				
				$state= get_state_by_id(trim($_POST['destinationState']));
				$city = trim($_POST['destinationCity']);
				$vehicle_name = get_vehicle_type_id($vehicle_type);
				$round_trip_in_text = ($round_trip ? 'Yes' : 'No');
				
				//Making filtered template
				$replaceStr = array();
				$replaceStr['TRIPTYPE']= $tripTypeInText;
				$replaceStr['EMAIL']= $email;
				$replaceStr['USER']= $name;
				//$replaceStr['QUOTE_INFO']= $luggage;
				//$replaceStr['STATE']= $state->state_name;
				//$replaceStr['CITY']= $city;
				$replaceStr['PHONE']= $phone;
				$replaceStr['PASSENGERS']= $passenger;
				$replaceStr['LUGGAGE']= $luggage;
				$replaceStr['DATE']= $trip_date_time;
				$replaceStr['AIRLINE']= $airline_details;
				$replaceStr['FLIGHT_NUMBER']= $flight_number;
				$replaceStr['PICKUP']= $pickup_location;
				$replaceStr['DROPOFF']= $dropoff_location;
				$replaceStr['CAR_TYPE']= $vehicle_name;
				$replaceStr['SEAT_INFANT']= $infant_seat;
				$replaceStr['SEAT_BOOSTER']= $booster_seat;
				$replaceStr['ROUND_TRIP']= $round_trip_in_text;
				$replaceStr['RETURN_DATE']= $return_trip_date_time;
				$replaceStr['RETURN_PICKUP']= $return_pickup_location;
				$replaceStr['RETURN_DROPOFF']= $return_dropoff_location;
				$replaceStr['RETURN_AIRLINE']= $return_airline_details;
				$replaceStr['RETURN_FLIGHT']= $return_flight_number;
				$replaceStr['PRICE']= $total_price;
				
				//Filtering email template for customer
				foreach($replaceStr as $key => $val){
					$emailMessageForUser = str_replace('['.$key.']', $val.'<br /><br />', $emailMessageForUser);
				}
				
				//Filtering email template for customer
				foreach($replaceStr as $key => $val){
					$emailMessageForAdmin = str_replace('['.$key.']', $val.'<br /><br />', $emailMessageForAdmin);
				}
				
				//Filtering confirmation message template for customer
				foreach($replaceStr as $key => $val){
					$confirmationMessageForUser = str_replace('['.$key.']', $val.'<br /><br />', $confirmationMessageForUser);
				}
				
				//Confirmation message
				$printValue = "<div class='wprdts-confirmation-message-page' id='wprdts-confirmation-message-page'> 
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
					$printValue .= "<p class='wprdts-booking-info-field'>Return Date/Time : ".$return_trip_date_time."</p> <br />";
				}
				
				$printValue	.= "<hr /><p class='wprdts-booking-info-field'>Price : ".$total_price."</p>  
					<a class='paypal-buton' id='paypal-buton'>
					<img src='https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-large.png' alt='Check out with PayPal' /></a> </div> <br /> ";		
				
				
				//Send email to customer
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				//$headers .= 'From: Birthday Reminder <birthday@example.com>' . "\r\n";				
				$headers .= 'From: '.$emailAdminName.' '.$emailAdminEmail . "\r\n";      
				$emailMessageForUser = '<div>'.$emailMessageForUser.'</div>'; 
				wp_mail( $email, $emailSubjectForUser, $emailMessageForUser, $headers );	

				//Send email to admin
				$headersAdmin  = 'MIME-Version: 1.0' . "\r\n";
				$headersAdmin .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				//$headers .= 'From: Birthday Reminder <birthday@example.com>' . "\r\n";				
				$headersAdmin .= 'From: '.$name.' '.$email . "\r\n";      
				$emailMessageForAdmin = '<div>'.$emailMessageForAdmin.'</div>'; 
				wp_mail( $emailAdminEmail, $emailSubjectForAdmin, $emailMessageForAdmin, $headersAdmin );	
				
				//Confirmation message for customer 
				$confirmationMessageForUser = $confirmationMessageForUser . "<br /><a class='paypal-buton' id='paypal-buton'>
					<img src='https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-large.png' alt='Check out with PayPal' /></a>";
				$confirmationMessageForUser = "<div class='wprdts-confirmation-message-page' id='wprdts-confirmation-message-page'>" . $confirmationMessageForUser . "</div>";
				
				echo $confirmationMessageForUser; exit;	
				//echo $printValue; exit;	
			}
		}
	}
			
	
	//Ajax for paypal notify url
	function wprdts_ajax_paypal_notify_request(){
		add_action('wp_ajax_wprdts_ajax_response_paypal_notify_request', 'wprdts_paypal_notify_request_proccess');
		add_action('wp_ajax_nopriv_wprdts_ajax_response_paypal_notify_request', 'wprdts_paypal_notify_request_proccess');
	}
	
	function wprdts_paypal_notify_request_proccess(){
			$paypalEmail = get_option(WPRDTS_OPTION_PAYPAL_EMAIL);
			$currencySymbol = get_option(WPRDTS_OPTION_CURRENCY);
			$testMode = get_option(WPRDTS_OPTION_PAYPAL_TEST_MODE);
			
			//$paypal_url = "https://www.paypal.com/cgi-bin/webscr/";
			//$sandbox_url = "https://www.sandbox.paypal.com/cgi-bin/webscr/";
			
			if (!$testMode){
				$paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
			} else{
				$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
			}

			$_mode = $testMode;
			$_verified = 0;
			
			//using Curl
			
			$request = 'cmd=_notify-validate';

			foreach ($_POST as $key => $value) {
				$request .= '&' . $key . '=' . urlencode(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
			}
			$curl = curl_init($paypal_url);
			
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

			$response = curl_exec($curl);

			if (!$testMode) {
				if ((strcmp($response, 'VERIFIED') == 0 || strcmp($response, 'UNVERIFIED') == 0) && isset($_POST['payment_status'])) {
					switch($_POST['payment_status']) {
						case 'Completed':
							$_verified = 1;
							break;
						default:
							$_verified = 0;
							break;
					}
				}
			} else {
				//Always return true for test mode 
					$_verified = 1;       
			}

				if ($_verified==1)
				{	 
					$data_id = $_POST['custom'] ; 

					global $wpdb;
					$table_name = $wpdb->prefix.'wprdts_booking_list';
					//$query = "UPDATE wp_fsq_data SET paid='1' WHERE id=".$data_id;
					$result= $wpdb->query("UPDATE $table_name SET status = '2' WHERE booking_id = ".$data_id."");
					//$wpdb->query($query); 
						
				} else {
					$data_id = $_POST['custom'] ; 
					
					global $wpdb;
					$table_name = $wpdb->prefix.'wprdts_booking_list';
					//$query = "UPDATE wp_fsq_data SET paid='1' WHERE id=".$data_id;
					$result= $wpdb->query("UPDATE $table_name SET status = '111' WHERE booking_id = ".$data_id."");
					//$wpdb->query($query); 
				}
			
			curl_close($curl);
			die();
	} //End function
	
	
	//Ajax for check fixed price city
	function wprdts_ajax_check_fixed_price_city(){
		add_action('wp_ajax_wprdts_ajax_response_check_fixed_price_city_request', 'wprdts_check_fixed_price_city_proccess');
		add_action('wp_ajax_nopriv_wprdts_ajax_response_check_fixed_price_city_request', 'wprdts_check_fixed_price_city_proccess');
	}
	
	//Check fixed price city process
	function wprdts_check_fixed_price_city_proccess(){
		if(isset($_POST['action'])){
			if($_POST['action'] == 'wprdts_ajax_response_check_fixed_price_city_request'){
				$addressTo = $_POST['addressTo'];
				$addressFrom = $_POST['addressFrom'];
				
				$result = get_fixed_price_city($addressTo, $addressFrom);
				
				if($result){
					//print_r($result);exit;
					echo wp_send_json($result[0]);
				}else{
					echo wp_send_json(0);
				}
			}
			
		}
	}
	
	
	//Get car type by id
	function get_vehicle_type_id($vehicle_id){
		if($vehicle_id == 1){
			$vehicleName =  'Sedan (1-4 passengers)';
		}else if($vehicle_id == 2){
			$vehicleName =  'Minivan (1-6 passengers)';
		}else if($vehicle_id == 3){
			$vehicleName =  'SUV (1-6 passengers)';
		}else if($vehicle_id == 4){
			$vehicleName =  'VAN (up to 9 passengers)';
		}else if($vehicle_id == 5){
			$vehicleName =  'VAN (up to 13 passengers)';
		}
		
		return $vehicleName;
	}
	
	
	
	