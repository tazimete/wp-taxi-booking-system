<?php 
	/*
	Plugin Name: WP RD Taxi System
	Plugin URI: http://wordpress.org/plugins/hello-dolly/
	Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
	Author: NeshmediaBD
	Version: 1.0
	Author URI: http://ma.tt/
	*/
	
	//Including other files 
	require_once(ABSPATH .'/wp-content/plugins/wp_rd_taxi_system/function/functions-state.php');
	require_once(ABSPATH .'/wp-content/plugins/wp_rd_taxi_system/function/functions-city.php');
	require_once(ABSPATH .'/wp-content/plugins/wp_rd_taxi_system/function/widget.php');
	require_once(ABSPATH .'/wp-content/plugins/wp_rd_taxi_system/function/functions-booking-list.php');
	
	//Changes in php.ini 
	ini_set('max_execution_time', -1);
	ini_set('memory_limit', -1);
	ini_set('allow_url_fopen', 1);
	ini_set('allow_url_include', true);
	
	
	//Define and initialize variable and constant
	define('ACTION_ADD','action_add');
	define('ACTION_EDIT','action_edit');
	define('ACTION_DELETE','action_delete');
	define('ACTION_COPY','action_copy');
	define('ACTION_PUBLISH','action_publish');
	define('ACTION_UNPUBLISH','action_unpublish');
	define('ACTION_SEARCH','action_search');
	
	//For state
	define('ADD_STATE','add_state');
	define('EDIT_STATE','edit_state');
	define('DELETE_STATE','delete_state');
	define('COPY_STATE','copy_state');
	define('PUBLISH_STATE','publish_state');
	define('UNPUBLISH_STATE','unpublish_state');
	
	define('STATUS_PUBLISHED',1);
	define('STATUS_UNPUBLISHED',0);
	
	//Column name for state
	define('TABLE_WPRDTS_STATE_COL_STATE_NAME','state_name');
	define('TABLE_WPRDTS_STATE_COL_STATE_PRICE','state_price');
	define('TABLE_WPRDTS_STATE_COL_STATUS','status');
	define('TABLE_WPRDTS_STATE_COL_ID','id');
	
	define('WPRDTS_SORT_ASC','ASC');
	define('WPRDTS_SORT_DSC','DESC');
	
	//For city
	define('ADD_CITY','add_city');
	define('EDIT_CITY','edit_city');
	define('DELETE_CITY','delete_city');
	define('COPY_CITY','copy_city');
	define('PUBLISH_CITY','publish_city');
	define('UNPUBLISH_CITY','unpublish_city');
	
	//Column name for city
	define('TABLE_WPRDTS_CITY_COL_CITY_NAME','city_name');
	define('TABLE_WPRDTS_CITY_COL_CITY_STATE_ID','city_state_id');
	define('TABLE_WPRDTS_CITY_COL_CITY_PRICE','city_price');
	define('TABLE_WPRDTS_CITY_COL_CITY_ZIP_CODE','city_zip_code');
	define('TABLE_WPRDTS_CITY_COL_ID','id');
	define('TABLE_WPRDTS_CITY_COL_CITY_STATUS','city_status');
	
	//For general setting 
	define('WPRDTS_OPTION_ACTION_SETTING_SAVE','save_setting');
	define('WPRDTS_OPTION_MAIN_LOCATION','wprdts-setting-form-main-location');
	define('WPRDTS_OPTION_CURRENCY','wprdts-setting-form-currency');
	define('WPRDTS_OPTION_PRICE_PER_KM','wprdts-setting-form-price-per-km');
	define('WPRDTS_OPTION_DISCOUNT','wprdts-setting-form-discount');
	define('WPRDTS_OPTION_DISCOUNT_AMOUNT_PERCENT','wprdts-setting-form-discount-amount-percent');
	define('WPRDTS_OPTION_DISCOUNT_AMOUNT_FIXED','wprdts-setting-form-discount-amount-fixed');
	define('WPRDTS_OPTION_DISCOUNT_MESSAGE','wprdts-setting-form-discount-message');
	define('WPRDTS_OPTION_ADDITIONAL_PRICE_ONE','wprdts-setting-form-additional-price-one');
	define('WPRDTS_OPTION_ADDITIONAL_PRICE_TWO','wprdts-setting-form-additional-price-two');
	define('WPRDTS_OPTION_ENABLE_PAYPAL','wprdts-setting-form-enable-paypal');
	define('WPRDTS_OPTION_PAYPAL_EMAIL','wprdts-setting-form-paypal-email');
	define('WPRDTS_OPTION_PAYPAL_TEST_MODE','wprdts-setting-form-paypal-test-mode');
	define('WPRDTS_OPTION_PAYPAL_RETURN_PAGE','wprdts-setting-form-paypal-return-page');
	define('WPRDTS_OPTION_PAYPAL_CANCEL_PAGE','wprdts-setting-form-paypal-cancel-page');
	define('WPRDTS_OPTION_CONFIRM_EMAIL_ADMIN','wprdts-setting-form-confirm-email-admin');
	define('WPRDTS_OPTION_CONFIRM_SUBJECT_ADMIN','wprdts-setting-form-confirm-subject-admin');
	define('WPRDTS_OPTION_CONFIRM_EMAIL_USER','wprdts-setting-form-confirm-email-user');
	define('WPRDTS_OPTION_CONFIRM_SUBJECT_USER','wprdts-setting-form-confirm-subject-user');
	define('WPRDTS_OPTION_CONFIRM_MESSAGE_USER','wprdts-setting-form-confirm-message-user');
	define('WPRDTS_OPTION_ADMIN_NAME','wprdts-setting-form-admin-name');
	define('WPRDTS_OPTION_ADMIN_EMAIL','wprdts-setting-form-admin-email');
	define('WPRDTS_OPTION_ENABLE_STATUS_BAR','wprdts-setting-form-enable-status-bar');
	
	//Text for General Setting
	define('WPRDTS_SETTING_TEXT_RIDE_TO_AIRPORT','ride_to_airport');
	define('WPRDTS_SETTING_TEXT_RIDE_FROM_AIRPORT','ride_from_airport');
	
	//Colum name for quote
	define('TABLE_WPRDTS_BOOKING_LIST_COL_BOOKING_ID','booking_id');
	define('TABLE_WPRDTS_BOOKING_LIST_COL_NAME','name');
	define('TABLE_WPRDTS_BOOKING_LIST_COL_EMAIL','email');
	define('TABLE_WPRDTS_BOOKING_LIST_COL_PHONE','phone');
	define('TABLE_WPRDTS_BOOKING_LIST_COL_PASSENGER','passenger');
	define('TABLE_WPRDTS_BOOKING_LIST_COL_LUGGAGE','luggage');
	define('TABLE_WPRDTS_BOOKING_LIST_COL_TRIP_TIME_DATE','trip_time_date');
	define('TABLE_WPRDTS_BOOKING_LIST_COL_STATUS','status');
	
	
	//Creating  Database Table
    function wprdts_create_table(){
		
		global $wpdb;
		//$wpdb->prefix.
		$table_name = $wpdb->prefix.'wprdts_state';
		
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
		  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `state_name` varchar(150) NOT NULL,
		  `state_price` varchar(150) NOT NULL,
		  `status` int(11) NOT NULL,
		   PRIMARY KEY (`id`)
		 )  ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;";
		  $rs = $wpdb->query($sql);
		  
		$table_name = $wpdb->prefix.'wprdts_city';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
		  `id` int(32) NOT NULL AUTO_INCREMENT,
		  `city_name` varchar(64) NOT NULL,
		  `city_state_id` int(11) NOT NULL,
		  `city_price` double NOT NULL,
		  `city_zip_code` text NOT NULL,
		  `city_status` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;";
		
		 $rs = $wpdb->query($sql);
		 
		$table_name = $wpdb->prefix.'wprdts_booking_list';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
		  `booking_id` int(11) NOT NULL AUTO_INCREMENT,
		  `trip_type` varchar(64) NOT NULL,
		  `destination_state_id` int(11) DEFAULT NULL,
		  `destination_city` varchar(64) NOT NULL,
		  `pickup_state_id` int(11) DEFAULT NULL,
		  `pickup_city` varchar(64) NOT NULL,
		  `passenger` int(11) NOT NULL,
		  `luggage` int(11) NOT NULL,
		  `round_trip` int(11) NOT NULL,
		  `vehicle_type` int(11) NOT NULL,
		  `trip_date_time` varchar(64) NOT NULL,
		  `return_trip_date_time` varchar(64) NOT NULL,
		  `pickup_location` mediumtext NOT NULL,
		  `return_pickup_location` mediumtext NOT NULL,
		  `dropoff_location` mediumtext NOT NULL,
		  `return_dropoff_location` mediumtext NOT NULL,
		  `airline_details` varchar(128) NOT NULL,
		  `return_airline_details` mediumtext NOT NULL,
		  `flight_number` varchar(128) NOT NULL,
		  `return_flight_number` mediumtext NOT NULL,
		  `name` varchar(64) NOT NULL,
		  `email` varchar(64) NOT NULL,
		  `phone` varchar(64) NOT NULL,
		  `price` varchar(28) NOT NULL,
		  `additional_price` varchar(28) NOT NULL,
		  `total_price` varchar(28) NOT NULL,
		  `status` int(11) NOT NULL,
		  PRIMARY KEY (`booking_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;";
		
		//$rs = $wpdb->query("DROP TABLE IF EXISTS ".$table_name.";");
		
		$rs = $wpdb->query($sql);
		
		//Inserting city to database
		require_once(ABSPATH .'/wp-content/plugins/wp_rd_taxi_system/sql/city_list.php');
		require_once(ABSPATH .'/wp-content/plugins/wp_rd_taxi_system/sql/state_list.php');
		insert_city_to_database();
		insert_state_to_database();

    }
	
	//Creat database when activate plugin
	register_activation_hook(  __FILE__ , 'wprdts_create_table' );
	//add_action( 'init', 'wprdts_create_table' );
	
	
	//Delete database when deactivate plugin
	function wprdts_delete_table(){
		global $wpdb;
		
		//Table state 
		$table_name = $wpdb->prefix.'wprdts_state';
		$rs = $wpdb->query("DROP TABLE IF EXISTS ".$table_name.";");
		
		//Table city
		$table_name = $wpdb->prefix.'wprdts_city';
		$rs = $wpdb->query("DROP TABLE IF EXISTS ".$table_name.";");
		
		//Table quote list
		$table_name = $wpdb->prefix.'wprdts_booking_list';
		$rs = $wpdb->query("DROP TABLE IF EXISTS ".$table_name.";");
	}
	register_deactivation_hook(__FILE__, 'wprdts_delete_table');
	

	//Initiloize widget
	add_action( 'widgets_init', function(){
		register_widget( 'My_Widget' );
	});	
	
	
	//Loading css and js file to admin header
	function wprdts_load_css_and_js_to_admin_header() {
        wp_register_style( 'wprdts_main_style', plugins_url() . '/wp_rd_taxi_system/css/wprdts-style.css', false, '1.0.0' );
        wp_register_style( 'wprdts_main_style_responsive', plugins_url() . '/wp_rd_taxi_system/css/wprdts-style-responsive.css', false, '1.0.0' );
        wp_register_style( 'wprdts_style_jquery_ui', plugins_url() . '/wp_rd_taxi_system/js/jquery-ui/jquery-ui.min.css', false, '1.0.0' );
        wp_enqueue_style( 'wprdts_main_style' );
        wp_enqueue_style( 'wprdts_main_style_responsive' );
        wp_enqueue_style( 'wprdts_style_jquery_ui' );
		wp_register_style( 'wprdts_fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', false, '1.0.0' );
        wp_enqueue_style( 'wprdts_fa' );
		wp_enqueue_script( "jquery" );
		//wp_enqueue_script( 'wprdts_jquery', 'http://code.jquery.com/jquery-2.1.4.min.js' );
		wp_enqueue_script( 'wprdts_jquery_ui', plugins_url() . '/wp_rd_taxi_system/js/jquery-ui/jquery-ui.min.js' );
		wp_enqueue_script( 'wprdts_jquery_timepicker', plugins_url() . '/wp_rd_taxi_system/js/jquery-ui/jquery.ui.timepicker.js' );
		wp_enqueue_script( 'wprdts_nice_select_script', plugins_url() . '/wp_rd_taxi_system/js/jquery-nice-select/jquery.nice-select.js' );
		//wp_enqueue_script( 'wprdts_google_map_api', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true' );
		wp_enqueue_script( 'wprdts_google_map_api_distance_places', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAyaL7cWt6B82_0oNXz3R94awhRhqMpLos&libraries=places' );
		//wp_enqueue_script( 'wprdts_google_map_api_distance_matrix', 'http://maps.google.com/maps/api/js?sensor=true&libraries=geometry' );
		//wp_enqueue_script( 'wprdts_google_map_api_distance_geometry', "https://maps.googleapis.com/maps/api/js?key=AIzaSyAyaL7cWt6B82_0oNXz3R94awhRhqMpLos&sensor=false&libraries=geometry" );
		wp_enqueue_script( 'wprdts_main_script', plugins_url() . '/wp_rd_taxi_system/js/wprdts-script.js', array('jquery') );
		// make the ajaxurl var available to the above script
		wp_localize_script( 'wprdts_main_script', 'wprdts_ajax_script', array( 'wprdts_ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}
	
	//Loading css and js file to frontend header
	function wprdts_load_css_and_js_to_frontend() {
        wp_register_style( 'wprdts_nice_select_style', plugins_url() . '/wp_rd_taxi_system/css/jquery-nice-select/nice-select.css', false, '1.0.0' );         
        wp_enqueue_style( 'wprdts_nice_select_style' );
        //wp_enqueue_style( 'wprdts_style_jquery_timepicker' );
		wp_register_style( 'wprdts_fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', false, '1.0.0' );	
		wp_register_style( 'wprdts_bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css', false, '1.0.0' );	
        wp_enqueue_style( 'wprdts_fa' );               
		wp_enqueue_style( 'wprdts_bootstrap' );
		wp_register_style( 'wprdts_main_style', plugins_url() . '/wp_rd_taxi_system/css/wprdts-style.css', false, '1.0.0' );
        wp_register_style( 'wprdts_main_style_responsive', plugins_url() . '/wp_rd_taxi_system/css/wprdts-style-responsive.css', false, '1.0.0' );
		wp_enqueue_style( 'wprdts_main_style' );
        wp_enqueue_style( 'wprdts_main_style_responsive' );
		wp_register_style( 'wprdts_style_jquery_ui', plugins_url() . '/wp_rd_taxi_system/js/jquery-ui/jquery-ui.min.css', false, '1.0.0' ); 
		wp_register_style( 'wprdts_style_jquery_timepicker', plugins_url() . '/wp_rd_taxi_system/js/jquery-ui/jquery-ui-timepicker-addon.css', false, '1.0.0' );
		wp_enqueue_style( 'wprdts_style_jquery_ui' );
		wp_enqueue_script( "jquery" );
		//wp_enqueue_script( 'wprdts_jquery', 'http://code.jquery.com/jquery-2.1.4.min.js' );
		wp_enqueue_script( 'wprdts_nice_select_script', plugins_url() . '/wp_rd_taxi_system/js/jquery-nice-select/jquery.nice-select.js' );
		wp_enqueue_script( 'wprdts_jquery_ui', plugins_url() . '/wp_rd_taxi_system/js/jquery-ui/jquery-ui.min.js' );
		wp_enqueue_script( 'wprdts_jquery_timepicker', plugins_url() . '/wp_rd_taxi_system/js/jquery-ui/jquery-ui-timepicker-addon.js' );
		//wp_enqueue_script( 'wprdts_google_map_api', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true' );
		wp_enqueue_script( 'wprdts_google_map_api_distance_places', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAyaL7cWt6B82_0oNXz3R94awhRhqMpLos&libraries=places' );
		//wp_enqueue_script( 'wprdts_google_map_api_distance_matrix', 'http://maps.google.com/maps/api/js?sensor=true&libraries=geometry' );
		//wp_enqueue_script( 'wprdts_google_map_api_distance_geometry', "https://maps.googleapis.com/maps/api/js?key=AIzaSyAyaL7cWt6B82_0oNXz3R94awhRhqMpLos&sensor=false&libraries=geometry" );
		wp_enqueue_script( 'wprdts_main_script', plugins_url() . '/wp_rd_taxi_system/js/wprdts-script.js', array('jquery') );
		// make the ajaxurl var available to the above script
		wp_localize_script( 'wprdts_main_script', 'wprdts_ajax_script', array( 'wprdts_ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}
	add_action( 'admin_enqueue_scripts', 'wprdts_load_css_and_js_to_admin_header' );
	add_action( 'wp_enqueue_scripts', 'wprdts_load_css_and_js_to_frontend' );	
	
	//Add wprdts ajax function 
	wprdts_ajax_find_city();
	wprdts_ajax_get_distance();
	wprdts_ajax_booking_request();
	//wprdts_ajax_paypal_request();
	wprdts_ajax_chekout_page_request();
	wprdts_ajax_paypal_notify_request();
	wprdts_ajax_check_fixed_price_city();
	
	//Registering Arabic Tutor menu in Admin Page 
	add_action( 'admin_menu', 'register_wp_rd_taxi_system_menu' );

	function register_wp_rd_taxi_system_menu() {
		add_menu_page( 'rd-taxi-system', ' WP RD Taxi System', 'manage_options', 'rd_taxi_system','wp_rd_taxi_system_page' ); 	
		add_submenu_page( 'rd_taxi_system', 'Manage States', 'Manage States', 'manage_options', 'rd_taxi_system_manage_states', 'wp_rd_taxi_system_manage_states' );
		add_submenu_page( 'rd_taxi_system', 'Fixed Price City', 'Fixed Price City', 'manage_options', 'rd_taxi_system_manage_cities', 'wp_rd_taxi_system_manage_cities' );
		add_submenu_page( 'rd_taxi_system', 'Manage Quotes', 'Manage Quotes', 'manage_options', 'rd_taxi_system_manage_quotes', 'wp_rd_taxi_system_manage_quotes' );
		add_submenu_page( 'rd_taxi_system', 'Manage Languages', 'Manage Languages', 'manage_options', 'rd_taxi_system_manage_languages', 'wp_rd_taxi_system_manage_languages' );
		add_submenu_page( 'rd_taxi_system', 'General Settings', 'General Settings', 'manage_options', 'rd_taxi_system_general_settings', 'wp_rd_taxi_system_general_settings' );
    
	}
	
	//Add jQuery 
	function xlspi_enqueue_jquery(){
		wp_enqueue_script('jquery');
	}
	//add_action('admin_enqueue_scripts','xlspi_enqueue_jquery');
	
	//Page for Main menu  
	function wp_rd_taxi_system_page(){
		echo '<h2> WP RD Taxi System</h2>';
		echo '<h4><a href="?page=rd_taxi_system_manage_states"> Manage States </a></h4>';
		echo '<h4><a href="?page=rd_taxi_system_manage_cities"> Cities Excluded From Google Map</a></h4>';
		echo '<h4><a href="?page=rd_taxi_system_manage_quotes"> Manage Quotes </a></h4>';
		echo '<h4><a href="?page=rd_taxi_system_manage_languages"> Manage Languages </a></h4>';
		echo '<h4><a href="?page=rd_taxi_system_general_settings"> General Settings </a></h4>';
	}
	
	////////************ Page For Manage State ***********//////// 
	function wp_rd_taxi_system_manage_states(){ ?>
		<div class="container">
			<h2> Manage States</h2>
			<div class="wprdts-form-container">
			<?php 		
				if(isset($_GET['success_msg'])) {
					if($_GET['count_true'] > 0){
						echo '<p class="success-message"> ' . $_GET['success_msg'] . '</p>';
					}
				}
					
				 if(isset($_GET['failed_msg'])) {
					if($_GET['count_false'] > 0){
						echo '<p class="failed-message"> ' . $_GET['failed_msg'] . '</p>';
					}
				}
			?>
			<?php if(!isset($_GET['wprdts_action'])){ ?>
				<div class="wprdts-form-container-header">
					<div class="wprdts-btn-conaiter">
						<span><a href="?page=rd_taxi_system_manage_states&wprdts_action=<?php echo ACTION_ADD ;?>" class="button button-primary button-large" id="btn-add-state">Add</a></span>
						<span><a class="button button-primary button-large" id="btn-edit-state" onclick="getFormAction(this)" >Edit</a></span>
						<span><a class="button button-primary button-large" id="btn-delete-state" onclick="getFormAction(this)" >Delete</a></span>
						<span><a class="button button-primary button-large" id="btn-copy-state" onclick="getFormAction(this)" >Copy</a></span>
						<span><a class="button button-primary button-large" id="btn-publish-state" onclick="getFormAction(this)" >Publish</a></span>
						<span><a class="button button-primary button-large" id="btn-unpublish-state" onclick="getFormAction(this)" >Unpublish</a></span>
					</div>
					<div class="wprdts-search-box-container">
						<span>
							<form action="#" method="post" id="wprdts-state-search-form"><input type="search" name="wprdts-search-box" class="wprdts-search-box" id="wprdts-state-search-box" placeholder="Ex : Name or  Price or ID"/></form>
						</span>
						<span>
							<a  class="button" id="btn-search-state" onclick="validatedSearchForm(this)">Search</a>
						</span>
					</div>
				</div>
				<div class="wprdts-form-body">
				<form action="#" method="post" id="wprdts-state-form">					 
					<?php 
						if(isset($_GET['wprdts_action_search'])){
							if($_GET['wprdts_action_search'] == ACTION_SEARCH){
								//print_r($_GET['wprdts_action_search']); exit;
								?> 
								<div class="wprdts-form-body-header"> 
									<span>
										<input type="checkbox" class="wprdts-form-checkbox" onclick="$('#wprdts-state-form input[name*=\'states\']').attr('checked', this.checked);"/>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_states&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATE_NAME ;?>" class="wprdts-sortable-col">Name</a> 
										<?php if( isset($_GET['wprdts_action_sort_by_mame_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATE_NAME ;?>&wprdts_action_sort_by_mame_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php }else if(isset($_GET['wprdts_action_sort_by_mame_desc'])){ ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATE_NAME ;?>&wprdts_action_sort_by_mame_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATE_NAME ;?>&wprdts_action_sort_by_mame_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_states&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATE_PRICE ;?>" class="wprdts-sortable-col">Price</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_price_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATE_PRICE ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_price_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATE_PRICE ;?>&wprdts_action_sort_by_price_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATE_PRICE ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_states&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_ID ;?>" class="wprdts-sortable-col">ID</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_id_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_ID ;?>&wprdts_action_sort_by_id_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_id_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_ID ;?>&wprdts_action_sort_by_id_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_ID ;?>&wprdts_action_sort_by_id_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_states&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATUS ;?>" class="wprdts-sortable-col">Status</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_status_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATUS ;?>&wprdts_action_sort_by_status_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_status_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATUS ;?>&wprdts_action_sort_by_status_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATUS ;?>&wprdts_action_sort_by_status_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
								</div>
								<?php
								if(isset($_GET['wprdts_action_sorting_order'])){
									if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_STATE_COL_STATE_NAME){
										if(isset($_GET['wprdts_action_sort_by_mame_asc'])) {
											$data_order = TABLE_WPRDTS_STATE_COL_STATE_NAME." ".$_GET['wprdts_action_sort_by_mame_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_mame_desc'])) {
											$data_order = TABLE_WPRDTS_STATE_COL_STATE_NAME." ".$_GET['wprdts_action_sort_by_mame_desc'];
										} else{
											$data_order = TABLE_WPRDTS_STATE_COL_STATE_NAME." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_STATE_COL_STATE_PRICE){
										if(isset($_GET['wprdts_action_sort_by_price_asc'])) {
											$data_order = TABLE_WPRDTS_STATE_COL_STATE_PRICE." ".$_GET['wprdts_action_sort_by_price_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_price_desc'])) {
											$data_order = TABLE_WPRDTS_STATE_COL_STATE_PRICE." ".$_GET['wprdts_action_sort_by_price_desc'];
										} else{
											$data_order = TABLE_WPRDTS_STATE_COL_STATE_PRICE." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_STATE_COL_ID){
										if(isset($_GET['wprdts_action_sort_by_id_asc'])) {
											$data_order = TABLE_WPRDTS_STATE_COL_ID." ".$_GET['wprdts_action_sort_by_id_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_id_desc'])) {
											$data_order = TABLE_WPRDTS_STATE_COL_ID." ".$_GET['wprdts_action_sort_by_id_desc'];
										} else{
											$data_order = TABLE_WPRDTS_STATE_COL_ID." ".WPRDTS_SORT_ASC;
										}
									}else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_STATE_COL_STATUS){
										if(isset($_GET['wprdts_action_sort_by_status_asc'])) {
											$data_order = TABLE_WPRDTS_STATE_COL_STATUS." ".$_GET['wprdts_action_sort_by_status_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_status_desc'])) {
											$data_order = TABLE_WPRDTS_STATE_COL_STATUS." ".$_GET['wprdts_action_sort_by_status_desc'];
										} else{
											$data_order = TABLE_WPRDTS_STATE_COL_STATUS." ".WPRDTS_SORT_ASC;
										}
									}
								} else{
									$data_order = TABLE_WPRDTS_STATE_COL_STATE_NAME." ".WPRDTS_SORT_ASC;
								}
								
								$all_state = get_state_by_names($_POST['wprdts-search-box'], $data_order);
								if($all_state){
									foreach($all_state as $state){ ?>
										<div class="wprdts-form-data">
										<span><input type="checkbox" name="states[]" class="wprdts-form-checkbox" value="<?php echo $state->id; ?>" /></span>
										<span><a href="?page=rd_taxi_system_manage_states&wprdts_action=action_edit&editing_state_id=<?php echo $state->id; ?>" class="wprdts-sortable-col"><?php echo $state->state_name; ?></a></span>
										<span><?php echo $state->state_price; ?></span>
										<span><?php echo $state->id; ?></span>
										<span><?php 
											if($state->status == STATUS_PUBLISHED) {
												echo 'Published';
											} else {
												echo 'Unpublished'; 
											} ?>
										</span>
										</div>
								<?php }
								}else{
									echo '<h3 class="empty-message">Not found</h3>';
								}
							}
						} else{ 
							if(isset($_GET['wprdts_action_sorting_order'])){
									if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_STATE_COL_STATE_NAME){
										if(isset($_GET['wprdts_action_sort_by_mame_asc'])) {
											$data_order = TABLE_WPRDTS_STATE_COL_STATE_NAME." ".$_GET['wprdts_action_sort_by_mame_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_mame_desc'])) {
											$data_order = TABLE_WPRDTS_STATE_COL_STATE_NAME." ".$_GET['wprdts_action_sort_by_mame_desc'];
										} else{
											$data_order = TABLE_WPRDTS_STATE_COL_STATE_NAME." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_STATE_COL_STATE_PRICE){
										if(isset($_GET['wprdts_action_sort_by_price_asc'])) {
											$data_order = TABLE_WPRDTS_STATE_COL_STATE_PRICE." ".$_GET['wprdts_action_sort_by_price_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_price_desc'])) {
											$data_order = TABLE_WPRDTS_STATE_COL_STATE_PRICE." ".$_GET['wprdts_action_sort_by_price_desc'];
										} else{
											$data_order = TABLE_WPRDTS_STATE_COL_STATE_PRICE." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_STATE_COL_ID){
										if(isset($_GET['wprdts_action_sort_by_id_asc'])) {
											$data_order = TABLE_WPRDTS_STATE_COL_ID." ".$_GET['wprdts_action_sort_by_id_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_id_desc'])) {
											$data_order = TABLE_WPRDTS_STATE_COL_ID." ".$_GET['wprdts_action_sort_by_id_desc'];
										} else{
											$data_order = TABLE_WPRDTS_STATE_COL_ID." ".WPRDTS_SORT_ASC;
										}
									}else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_STATE_COL_STATUS){
										if(isset($_GET['wprdts_action_sort_by_status_asc'])) {
											$data_order = TABLE_WPRDTS_STATE_COL_STATUS." ".$_GET['wprdts_action_sort_by_status_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_status_desc'])) {
											$data_order = TABLE_WPRDTS_STATE_COL_STATUS." ".$_GET['wprdts_action_sort_by_status_desc'];
										} else{
											$data_order = TABLE_WPRDTS_STATE_COL_STATUS." ".WPRDTS_SORT_ASC;
										}
									}
								} else{
									$data_order = TABLE_WPRDTS_STATE_COL_ID." ".WPRDTS_SORT_DSC;
								}
								?> 
								<div class="wprdts-form-body-header"> 
									<span>
										<input type="checkbox" class="wprdts-form-checkbox" onclick="$('#wprdts-state-form input[name*=\'states\']').attr('checked', this.checked);"/>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_states&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATE_NAME ;?>" class="wprdts-sortable-col">Name</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_mame_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATE_NAME ;?>&wprdts_action_sort_by_mame_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_mame_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATE_NAME ;?>&wprdts_action_sort_by_mame_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATE_NAME ;?>&wprdts_action_sort_by_mame_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_states&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATE_PRICE ;?>" class="wprdts-sortable-col">Price</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_price_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATE_PRICE ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_price_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATE_PRICE ;?>&wprdts_action_sort_by_price_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATE_PRICE ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_states&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_ID ;?>" class="wprdts-sortable-col">ID</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_id_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_ID ;?>&wprdts_action_sort_by_id_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_id_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_ID ;?>&wprdts_action_sort_by_id_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_ID ;?>&wprdts_action_sort_by_id_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_states&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATUS ;?>" class="wprdts-sortable-col">Status</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_status_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATUS ;?>&wprdts_action_sort_by_status_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_status_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATUS ;?>&wprdts_action_sort_by_status_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_states&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_STATE_COL_STATUS ;?>&wprdts_action_sort_by_status_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
								</div>
						<?php 
							$all_state = get_all_state($data_order);
							if($all_state){
								foreach($all_state as $state){ ?>
									<div class="wprdts-form-data">
									<span><input type="checkbox" name="states[]" class="wprdts-form-checkbox" value="<?php echo $state->id; ?>" /></span>
									<span><a href="?page=rd_taxi_system_manage_states&wprdts_action=action_edit&editing_state_id=<?php echo $state->id; ?>" class="wprdts-sortable-col"><?php echo $state->state_name; ?></a></span>
									<span><?php echo $state->state_price; ?></span>
									<span><?php echo $state->id; ?></span>
									<span><?php 
										if($state->status == STATUS_PUBLISHED) {
											echo 'Published';
										} else {
											echo 'Unpublished'; 
										} ?>
									</span>
									</div>
							<?php }
							}else{
								echo '<h3 class="empty-message">No state yet on database currently</h3>';
							}
						}
					?>	
					</form>
				</div> 
			<?php //Showing add state form if add button is clicked 
			} else if(isset($_GET['wprdts_action'])){
						//Go to add state form
						if($_GET['wprdts_action'] == ACTION_ADD){
							get_add_state_form();
						}
						
						//Go to edit state form with state by id - Multi Edit
						if($_GET['wprdts_action'] == ACTION_EDIT && isset($_POST['states'])){
							//print_r($_POST['states']); 
							edit_state_by_id($_POST['states']);
						}
						
						//Go to edit state form with state by id -- Single Edit
						if($_GET['wprdts_action'] == ACTION_EDIT && isset($_GET['editing_state_id'])){
							//print_r($_GET['editing_state_id']);
							$editing_state_id[] = $_GET['editing_state_id'];
							edit_state_by_id($editing_state_id);
						}
						
						//Delete state by id
						if($_GET['wprdts_action'] == ACTION_DELETE && isset($_POST['states'])){
							//print_r($_POST['states']); 
							$query_results = delete_state_by_id($_POST['states']);
							$query_results_for_delete_state = count_true_false($query_results);
							
							if($query_results_for_delete_state['count_true'] > 0 || $query_results_for_delete_state['count_false'] > 0){
								//wp_redirect( admin_url( 'admin.php?page=rd_taxi_system_manage_states&message=success'));
								$success_msg = 'You have deleted ' . $query_results_for_delete_state['count_true'] . ' state  successfully';
								$failed_msg = 'Failed to  delete ' . $query_results_for_delete_state['count_false'] . ' state. Try again. ';
								echo '<script>window.location.href="?page=rd_taxi_system_manage_states&success_msg=' . $success_msg . '&failed_msg='.$failed_msg.'&count_true='.$query_results_for_delete_state['count_true'].'&count_false='.$query_results_for_delete_state['count_false'].'"</script>';
							}
						}
						
						//Copy state by id
						if($_GET['wprdts_action'] == ACTION_COPY && isset($_POST['states'])){
							//print_r($_POST['states']); 
							$query_results_copy = copy_state_by_id($_POST['states']);
							//print_r($query_results); exit;
							$query_results_for_copy_state = count_true_false($query_results_copy);
							
							if($query_results_for_copy_state['count_true'] > 0 || $query_results_for_copy_state['count_false'] > 0){
								//wp_redirect( admin_url( 'admin.php?page=rd_taxi_system_manage_states&message=success'));
								$success_msg = 'You have copied ' . $query_results_for_copy_state['count_true'] . ' state  successfully with new id';
								$failed_msg = 'Failed to  copy ' . $query_results_for_copy_state['count_false'] . ' state. Try again. ';
								echo '<script>window.location.href="?page=rd_taxi_system_manage_states&success_msg=' . $success_msg . '&failed_msg='.$failed_msg.'&count_true='.$query_results_for_copy_state['count_true'].'&count_false='.$query_results_for_copy_state['count_false'].'"</script>';
							}
						} 
						
						//Publish state by id
						if($_GET['wprdts_action'] == ACTION_PUBLISH && isset($_POST['states'])){
							//print_r($_POST['states']); 
							$query_results_publish = publish_state_by_id($_POST['states']);
							//print_r($query_results); exit;
							$query_results_for_publish_state = count_true_false($query_results_publish);
							
							if($query_results_for_publish_state['count_true'] > 0 || $query_results_for_publish_state['count_false'] > 0){
								//wp_redirect( admin_url( 'admin.php?page=rd_taxi_system_manage_states&message=success'));
								$success_msg = 'You have published ' . $query_results_for_publish_state['count_true'] . ' state  successfully';
								$failed_msg = 'Failed to  publish ' . $query_results_for_publish_state['count_false'] . ' state. Try again. ';
								echo '<script>window.location.href="?page=rd_taxi_system_manage_states&success_msg=' . $success_msg . '&failed_msg='.$failed_msg.'&count_true='.$query_results_for_publish_state['count_true'].'&count_false='.$query_results_for_publish_state['count_false'].'"</script>';
							}
						}

						//Unpublished state by id
						if($_GET['wprdts_action'] == ACTION_UNPUBLISH && isset($_POST['states'])){
							//print_r($_POST['states']); 
							$query_results_unpublish = unpublish_state_by_id($_POST['states']);
							//print_r($query_results); exit;
							$query_results_for_unpublish_state = count_true_false($query_results_unpublish);
							
							if($query_results_for_unpublish_state['count_true'] > 0 || $query_results_for_unpublish_state['count_false'] > 0){
								//wp_redirect( admin_url( 'admin.php?page=rd_taxi_system_manage_states&message=success'));
								$success_msg = 'You have unpublished ' . $query_results_for_unpublish_state['count_true'] . ' state  successfully';
								$failed_msg = 'Failed to  unpublished ' . $query_results_for_unpublish_state['count_false'] . ' state. Try again. ';
								echo '<script>window.location.href="?page=rd_taxi_system_manage_states&success_msg=' . $success_msg . '&failed_msg='.$failed_msg.'&count_true='.$query_results_for_unpublish_state['count_true'].'&count_false='.$query_results_for_unpublish_state['count_false'].'"</script>';
							}
						} 
						
						//Add state 
						if($_GET['wprdts_action'] == ADD_STATE){
							$query_results = add_state($_POST);
							$query_results_for_add_state = count_true_false($query_results);
							
							if($query_results_for_add_state['count_true'] > 0 || $query_results_for_add_state['count_false'] > 0){
								//wp_redirect( admin_url( 'admin.php?page=rd_taxi_system_manage_states&message=success'));
								$success_msg = 'You have added ' . $query_results_for_add_state['count_true'] . ' state  successfully';
								$failed_msg = 'Failed to  add ' . $query_results_for_add_state['count_false'] . ' state. Try again. ';
								echo '<script>window.location.href="?page=rd_taxi_system_manage_states&success_msg=' . $success_msg . '&failed_msg='.$failed_msg.'&count_true='.$query_results_for_add_state['count_true'].'&count_false='.$query_results_for_add_state['count_false'].'"</script>';
							}
							
							//print_r($query);
							/* if($query){
								//wp_redirect( admin_url( 'admin.php?page=rd_taxi_system_manage_states&message=success'));
								$success_msg = 'State is added successfully';
								print('<script>window.location.href="?page=rd_taxi_system_manage_states&success_msg="' . $success_msg . '</script>');
							}else{
								$failed_msg = 'Failed to add  state. Try again. ';
								print('<script>window.location.href="?page=rd_taxi_system_manage_states&failed_msg="' . $failed_msg . '</script>');
							} */
							
							//$wp_query = $wpdb->query("INSERT INTO ". $wpdb->prefix.'wprdts_state'."SET state_name = ".$state_name.", state_price = ".$state_price);
						}
						
						//Update states
						if($_GET['wprdts_action'] == EDIT_STATE){
							//echo '<pre>'; print_r($_POST); echo '</pre>'; exit;
							//print_r($_POST['id']);
							$results = update_states_by_id($_POST);
							$count_data = count_true_false($results);
							//echo var_dump($count_data); exit;
							 //print_r($count_data); //exit;
							
							if($count_data['count_true'] > 0 || $count_data['count_false'] > 0){
								//wp_redirect( admin_url( 'admin.php?page=rd_taxi_system_manage_states&message=success'));
								$success_msg = 'You have updated ' . $count_data['count_true'] . ' state  successfully';
								$failed_msg = 'Failed to  update ' . $count_data['count_false'] . ' state. Try again. ';
								echo '<script>window.location.href="?page=rd_taxi_system_manage_states&success_msg=' . $success_msg . '&failed_msg='.$failed_msg.'&count_true='.$count_data['count_true'].'&count_false='.$count_data['count_false'].'"</script>';
							}
							
						} //End of update state
						
					} //End of elseif ?>
			</div>
		</div>
	<?php }
	
	
	
		////////************ Page For Manage City ***********//////// 
	function wp_rd_taxi_system_manage_cities(){ ?>
		<div class="container">
			<h2> Fixed Price City</h2>
			<div class="wprdts-form-container">
			<?php 		
				if(isset($_GET['success_msg'])) {
					if($_GET['count_true'] > 0){
						echo '<p class="success-message"> ' . $_GET['success_msg'] . '</p>';
					}
				}
					
				 if(isset($_GET['failed_msg'])) {
					if($_GET['count_false'] > 0){
						echo '<p class="failed-message"> ' . $_GET['failed_msg'] . '</p>';
					}
				}
			?>
			<?php if(!isset($_GET['wprdts_action'])){ ?>
				<div class="wprdts-form-container-header">
					<div class="wprdts-btn-conaiter">
						<span><a href="?page=rd_taxi_system_manage_cities&wprdts_action=<?php echo ACTION_ADD ;?>" class="button button-primary button-large" id="btn-add-city">Add</a></span>
						<span><a class="button button-primary button-large" id="btn-edit-city" onclick="getFormActionForCity(this)" >Edit</a></span>
						<span><a class="button button-primary button-large" id="btn-delete-city" onclick="getFormActionForCity(this)" >Delete</a></span>
						<span><a class="button button-primary button-large" id="btn-copy-city" onclick="getFormActionForCity(this)" >Copy</a></span>
						<span><a class="button button-primary button-large" id="btn-publish-city" onclick="getFormActionForCity(this)" >Publish</a></span>
						<span><a class="button button-primary button-large" id="btn-unpublish-city" onclick="getFormActionForCity(this)" >Unpublish</a></span>
					</div>
					<div class="wprdts-search-box-container">
						<span>
							<form action="#" method="post" id="wprdts-city-search-form"><input type="search" name="wprdts-search-box" class="wprdts-search-box" id="wprdts-city-search-box" placeholder="Ex : Name or Price or ID or Status"/></form>
						</span>
						<span>
							<a  class="button" id="btn-search-city" onclick="validatedSearchForm(this)">Search</a>
						</span>
					</div>
				</div>
				<div class="wprdts-form-body"> 
				<form action="#" method="post" id="wprdts-city-form">					 
					<?php 
						if(isset($_GET['wprdts_action_search'])){
							if($_GET['wprdts_action_search'] == ACTION_SEARCH){
								//print_r($_GET['wprdts_action_search']); exit;
								?> 	
								<div class="wprdts-city-form-body-header"> 
									<span>
										<input type="checkbox" class="wprdts-form-checkbox" onclick="$('#wprdts-city-form input[name*=\'cities\']').attr('checked', this.checked);"/>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_NAME ;?>" class="wprdts-sortable-col">Name</a> 
										<?php if( isset($_GET['wprdts_action_sort_by_mame_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_NAME ;?>&wprdts_action_sort_by_mame_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php }else if(isset($_GET['wprdts_action_sort_by_mame_desc'])){ ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_NAME ;?>&wprdts_action_sort_by_mame_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_NAME ;?>&wprdts_action_sort_by_mame_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<!--<span>
										<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_STATE_ID ;?>" class="wprdts-sortable-col">State</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_state_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_STATE_ID ;?>&wprdts_action_sort_by_state_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_state_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_STATE_ID ;?>&wprdts_action_sort_by_state_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_STATE_ID ;?>&wprdts_action_sort_by_state_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span> -->
									<!-- <span>
										<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_ZIP_CODE ;?>" class="wprdts-sortable-col">ZIP Code</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_zip_code_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_ZIP_CODE ;?>&wprdts_action_sort_by_zip_code_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_zip_code_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_ZIP_CODE ;?>&wprdts_action_sort_by_zip_code_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_ZIP_CODE ;?>&wprdts_action_sort_by_zip_code_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span> -->
									<span>
										<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_PRICE ;?>" class="wprdts-sortable-col">Price</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_price_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_PRICE ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_price_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_PRICE ;?>&wprdts_action_sort_by_price_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_PRICE ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_ID ;?>" class="wprdts-sortable-col">ID</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_id_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_ID ;?>&wprdts_action_sort_by_id_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_id_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_ID ;?>&wprdts_action_sort_by_id_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_ID ;?>&wprdts_action_sort_by_id_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_STATUS ;?>" class="wprdts-sortable-col">Status</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_status_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_STATUS ;?>&wprdts_action_sort_by_status_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_status_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_STATUS ;?>&wprdts_action_sort_by_status_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_STATUS ;?>&wprdts_action_sort_by_status_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
								</div>
								<?php
								if(isset($_GET['wprdts_action_sorting_order'])){
									if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_CITY_COL_CITY_NAME){
										if(isset($_GET['wprdts_action_sort_by_mame_asc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_NAME." ".$_GET['wprdts_action_sort_by_mame_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_mame_desc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_NAME." ".$_GET['wprdts_action_sort_by_mame_desc'];
										} else{
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_NAME." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_CITY_COL_CITY_STATE_ID){
										if(isset($_GET['wprdts_action_sort_by_state_asc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_STATE_ID." ".$_GET['wprdts_action_sort_by_state_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_state_desc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_STATE_ID." ".$_GET['wprdts_action_sort_by_state_desc'];
										} else{
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_STATE_ID." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_CITY_COL_CITY_ZIP_CODE){
										if(isset($_GET['wprdts_action_sort_by_zip_code_asc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_ZIP_CODE." ".$_GET['wprdts_action_sort_by_zip_code_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_zip_code_desc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_ZIP_CODE." ".$_GET['wprdts_action_sort_by_zip_code_desc'];
										} else{
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_ZIP_CODE." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_CITY_COL_CITY_PRICE){
										if(isset($_GET['wprdts_action_sort_by_price_asc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_PRICE." ".$_GET['wprdts_action_sort_by_price_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_price_desc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_PRICE." ".$_GET['wprdts_action_sort_by_price_desc'];
										} else{
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_PRICE." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_CITY_COL_ID){
										if(isset($_GET['wprdts_action_sort_by_id_asc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_ID." ".$_GET['wprdts_action_sort_by_id_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_id_desc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_ID." ".$_GET['wprdts_action_sort_by_id_desc'];
										} else{
											$data_order = TABLE_WPRDTS_CITY_COL_ID." ".WPRDTS_SORT_ASC;
										}
									}else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_CITY_COL_CITY_STATUS){
										if(isset($_GET['wprdts_action_sort_by_status_asc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_STATUS." ".$_GET['wprdts_action_sort_by_status_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_status_desc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_STATUS." ".$_GET['wprdts_action_sort_by_status_desc'];
										} else{
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_STATUS." ".WPRDTS_SORT_ASC;
										}
									}
								} else{
									$data_order = TABLE_WPRDTS_CITY_COL_CITY_NAME." ".WPRDTS_SORT_ASC;
								}
								
								$all_city = get_city_by_names($_POST['wprdts-search-box'], $data_order);
								if($all_city){
									foreach($all_city as $city){ ?>
										<div class="wprdts-city-form-data">
											<span><input type="checkbox" name="cities[]" class="wprdts-form-checkbox" value="<?php echo $city->id; ?>" /></span>
											<span><a href="?page=rd_taxi_system_manage_cities&wprdts_action=action_edit&editing_city_id=<?php echo $city->id; ?>" class="wprdts-sortable-col"><?php echo $city->city_name; ?></a></span>
											<!--<span><?php $state = get_state_by_id($city->city_state_id); echo $state->state_name; ?></span> -->
											<!-- <span><?php echo $city->city_zip_code; ?></span> -->
											<span>
												<span class="wprdts-currency-symbol"><?php if($currency = get_option('wprdts-setting-form-currency')) echo $currency; ?></span>
												<?php echo $city->city_price; ?>
											</span>
											<span><?php echo $city->id; ?></span>
											<span><?php 
												if($city->city_status == STATUS_PUBLISHED) {
													echo 'Published';
												} else {
													echo 'Unpublished'; 
												} ?>
											</span>
										</div>
								<?php }
								}else{
									echo '<h3 class="empty-message">Not found</h3>';
								}
							}
						} else{ 
							if(isset($_GET['wprdts_action_sorting_order'])){
									if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_CITY_COL_CITY_NAME){
										if(isset($_GET['wprdts_action_sort_by_mame_asc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_NAME." ".$_GET['wprdts_action_sort_by_mame_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_mame_desc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_NAME." ".$_GET['wprdts_action_sort_by_mame_desc'];
										} else{
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_NAME." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_CITY_COL_CITY_STATE_ID){
										if(isset($_GET['wprdts_action_sort_by_state_asc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_STATE_ID." ".$_GET['wprdts_action_sort_by_state_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_state_desc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_STATE_ID." ".$_GET['wprdts_action_sort_by_state_desc'];
										} else{
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_STATE_ID." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_CITY_COL_CITY_ZIP_CODE){
										if(isset($_GET['wprdts_action_sort_by_zip_code_asc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_ZIP_CODE." ".$_GET['wprdts_action_sort_by_zip_code_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_zip_code_desc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_ZIP_CODE." ".$_GET['wprdts_action_sort_by_zip_code_desc'];
										} else{
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_ZIP_CODE." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_CITY_COL_CITY_PRICE){
										if(isset($_GET['wprdts_action_sort_by_price_asc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_PRICE." ".$_GET['wprdts_action_sort_by_price_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_price_desc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_PRICE." ".$_GET['wprdts_action_sort_by_price_desc'];
										} else{
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_PRICE." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_CITY_COL_ID){
										if(isset($_GET['wprdts_action_sort_by_id_asc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_ID." ".$_GET['wprdts_action_sort_by_id_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_id_desc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_ID." ".$_GET['wprdts_action_sort_by_id_desc'];
										} else{
											$data_order = TABLE_WPRDTS_CITY_COL_ID." ".WPRDTS_SORT_ASC;
										}
									}else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_CITY_COL_CITY_STATUS){
										if(isset($_GET['wprdts_action_sort_by_status_asc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_STATUS." ".$_GET['wprdts_action_sort_by_status_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_status_desc'])) {
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_STATUS." ".$_GET['wprdts_action_sort_by_status_desc'];
										} else{
											$data_order = TABLE_WPRDTS_CITY_COL_CITY_STATUS." ".WPRDTS_SORT_ASC;
										}
									}
								} else{
									$data_order = TABLE_WPRDTS_CITY_COL_ID." ".WPRDTS_SORT_DSC;
								}
								?> 
								<div class="wprdts-city-form-body-header"> 
									<span>
										<input type="checkbox" class="wprdts-form-checkbox" onclick="$('#wprdts-city-form input[name*=\'cities\']').attr('checked', this.checked);"/>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_NAME ;?>" class="wprdts-sortable-col">Name</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_mame_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_NAME ;?>&wprdts_action_sort_by_mame_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_mame_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_NAME ;?>&wprdts_action_sort_by_mame_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_NAME ;?>&wprdts_action_sort_by_mame_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<!-- <span>
										<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_STATE_ID ;?>" class="wprdts-sortable-col">State</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_state_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_STATE_ID ;?>&wprdts_action_sort_by_state_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_state_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_STATE_ID ;?>&wprdts_action_sort_by_state_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_STATE_ID ;?>&wprdts_action_sort_by_state_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span> -->
									<!-- <span>
										<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_ZIP_CODE ;?>" class="wprdts-sortable-col">Zip Code</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_zip_code_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_ZIP_CODE ;?>&wprdts_action_sort_by_zip_code_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_zip_code_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_ZIP_CODE ;?>&wprdts_action_sort_by_zip_code_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_ZIP_CODE ;?>&wprdts_action_sort_by_zip_code_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span> -->
									<span>
										<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_PRICE ;?>" class="wprdts-sortable-col">Price</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_price_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_PRICE ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_price_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_PRICE ;?>&wprdts_action_sort_by_price_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_PRICE ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_ID ;?>" class="wprdts-sortable-col">ID</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_id_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_ID ;?>&wprdts_action_sort_by_id_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_id_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_ID ;?>&wprdts_action_sort_by_id_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_ID ;?>&wprdts_action_sort_by_id_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_STATUS ;?>" class="wprdts-sortable-col">Status</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_status_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_STATUS ;?>&wprdts_action_sort_by_status_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_status_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_STATUS ;?>&wprdts_action_sort_by_status_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_cities&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_CITY_COL_CITY_STATUS ;?>&wprdts_action_sort_by_status_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
								</div>
						<?php 
							$all_city = get_all_city($data_order);
							if($all_city){
								foreach($all_city as $city){ ?>
									<div class="wprdts-city-form-data">
									<!-- <span><?php //print_r( $city->city_zip_code ); exit; ?></span> -->
									<span><input type="checkbox" name="cities[]" class="wprdts-form-checkbox" value="<?php echo $city->id; ?>" /></span>
									<span><a href="?page=rd_taxi_system_manage_cities&wprdts_action=action_edit&editing_city_id=<?php echo $city->id; ?>" class="wprdts-sortable-col"><?php echo $city->city_name; ?></a></span>
									<!-- <span><?php $state = get_state_by_id($city->city_state_id); echo $state->state_name; ?></span> -->
									<!-- <span><?php echo $city->city_zip_code; ?></span> -->
									<span>
										<span class="wprdts-currency-symbol"><?php if($currency = get_option('wprdts-setting-form-currency')) echo $currency; ?></span>
										<?php echo $city->city_price; ?>
									</span>
									<span><?php echo $city->id; ?></span>
									<span><?php 
										if($city->city_status == STATUS_PUBLISHED) {
											echo 'Published';
										} else {
											echo 'Unpublished'; 
										} ?>
									</span>
									</div>
							<?php }
							}else{
								echo '<h3 class="empty-message">No city on database currently</h3>';
							}
						}
					?>	
					</form>
				</div> 
			<?php //Showing add city form if add button is clicked 
			} else if(isset($_GET['wprdts_action'])){
						//Go to add city form
						if($_GET['wprdts_action'] == ACTION_ADD){
							get_add_city_form();
						}
						
						//Go to edit city form with state by id - Multi Edit
						if($_GET['wprdts_action'] == ACTION_EDIT && isset($_POST['cities'])){
							//print_r($_POST['states']); 
							get_edit_city_form_by_id($_POST['cities']);
						}
						
						//Go to edit city form with state by id -- Single Edit
						if($_GET['wprdts_action'] == ACTION_EDIT && isset($_GET['editing_city_id'])){
							//print_r($_GET['editing_city_id']);
							$editing_city_id[] = $_GET['editing_city_id'];
							get_edit_city_form_by_id($editing_city_id);
						}
						
						//Delete city by id
						if($_GET['wprdts_action'] == ACTION_DELETE && isset($_POST['cities'])){
							//print_r($_POST['cities']); 
							$query_results = delete_city_by_id($_POST['cities']);
							$query_results_for_delete_city = count_true_false($query_results);
							
							if($query_results_for_delete_city['count_true'] > 0 || $query_results_for_delete_city['count_false'] > 0){
								//wp_redirect( admin_url( 'admin.php?page=rd_taxi_system_manage_states&message=success'));
								$success_msg = 'You have deleted ' . $query_results_for_delete_city['count_true'] . ' city  successfully';
								$failed_msg = 'Failed to  delete ' . $query_results_for_delete_city['count_false'] . ' city. Try again. ';
								echo '<script>window.location.href="?page=rd_taxi_system_manage_cities&success_msg=' . $success_msg . '&failed_msg='.$failed_msg.'&count_true='.$query_results_for_delete_city['count_true'].'&count_false='.$query_results_for_delete_city['count_false'].'"</script>';
							}
						}
						
						//Copy city by id
						if($_GET['wprdts_action'] == ACTION_COPY && isset($_POST['cities'])){
							//print_r($_POST['cities']); 
							$query_results_copy = copy_city_by_id($_POST['cities']);
							//print_r($query_results); exit;
							$query_results_for_copy_city = count_true_false($query_results_copy);
							
							if($query_results_for_copy_city['count_true'] > 0 || $query_results_for_copy_city['count_false'] > 0){
								//wp_redirect( admin_url( 'admin.php?page=rd_taxi_system_manage_states&message=success'));
								$success_msg = 'You have copied ' . $query_results_for_copy_city['count_true'] . ' city  successfully with new ID';
								$failed_msg = 'Failed to  copy ' . $query_results_for_copy_city['count_false'] . ' city. Try again. ';
								echo '<script>window.location.href="?page=rd_taxi_system_manage_cities&success_msg=' . $success_msg . '&failed_msg='.$failed_msg.'&count_true='.$query_results_for_copy_city['count_true'].'&count_false='.$query_results_for_copy_city['count_false'].'"</script>';
							}
						} 
						
						//Publish city by id
						if($_GET['wprdts_action'] == ACTION_PUBLISH && isset($_POST['cities'])){
							//print_r($_POST['cities']); 
							$query_results_publish = publish_city_by_id($_POST['cities']);
							//print_r($query_results); exit;
							$query_results_for_publish_city = count_true_false($query_results_publish);
							
							if($query_results_for_publish_city['count_true'] > 0 || $query_results_for_publish_city['count_false'] > 0){
								//wp_redirect( admin_url( 'admin.php?page=rd_taxi_system_manage_states&message=success'));
								$success_msg = 'You have published ' . $query_results_for_publish_city['count_true'] . ' city  successfully';
								$failed_msg = 'Failed to  publish ' . $query_results_for_publish_city['count_false'] . ' city. Try again. ';
								echo '<script>window.location.href="?page=rd_taxi_system_manage_cities&success_msg=' . $success_msg . '&failed_msg='.$failed_msg.'&count_true='.$query_results_for_publish_city['count_true'].'&count_false='.$query_results_for_publish_city['count_false'].'"</script>';
							}
						}

						//Unpublished city by id
						if($_GET['wprdts_action'] == ACTION_UNPUBLISH && isset($_POST['cities'])){
							//print_r($_POST['cities']); 
							$query_results_unpublish = unpublish_city_by_id($_POST['cities']);
							//print_r($query_results); exit;
							$query_results_for_unpublish_city = count_true_false($query_results_unpublish);
							
							if($query_results_for_unpublish_city['count_true'] > 0 || $query_results_for_unpublish_city['count_false'] > 0){
								//wp_redirect( admin_url( 'admin.php?page=rd_taxi_system_manage_states&message=success'));
								$success_msg = 'You have unpublished ' . $query_results_for_unpublish_city['count_true'] . ' city  successfully';
								$failed_msg = 'Failed to  unpublished ' . $query_results_for_unpublish_city['count_false'] . ' city. Try again. ';
								echo '<script>window.location.href="?page=rd_taxi_system_manage_states&success_msg=' . $success_msg . '&failed_msg='.$failed_msg.'&count_true='.$query_results_for_unpublish_city['count_true'].'&count_false='.$query_results_for_unpublish_city['count_false'].'"</script>';
							}
						} 
						
						//Add City 
						if($_GET['wprdts_action'] == ADD_CITY){
							$query_result = add_city($_POST);
							$query_results_for_add_city = count_true_false($query_result);
							
							if($query_results_for_add_city['count_true'] > 0 || $query_results_for_add_city['count_false'] > 0){
								//wp_redirect( admin_url( 'admin.php?page=rd_taxi_system_manage_states&message=success'));
								$success_msg = 'You have added ' . $query_results_for_add_city['count_true'] . ' fixed price city  successfully';
								$failed_msg = 'Failed to  add ' . $query_results_for_add_city['count_false'] . ' fixed price city. Try again. ';
								echo '<script>window.location.href="?page=rd_taxi_system_manage_cities&success_msg=' . $success_msg . '&failed_msg='.$failed_msg.'&count_true='.$query_results_for_add_city['count_true'].'&count_false='.$query_results_for_add_city['count_false'].'"</script>';
							}
							
						}
						
						//Update cities
						if($_GET['wprdts_action'] == EDIT_CITY){
							//echo '<pre>'; print_r($_POST); echo '</pre>'; exit;
							//print_r($_POST['id']);
							$results = update_cities_by_id($_POST);
							$count_data = count_true_false($results);
							//echo var_dump($count_data); exit;
							 //print_r($count_data); //exit;
							
							if($count_data['count_true'] > 0 || $count_data['count_false'] > 0){
								//wp_redirect( admin_url( 'admin.php?page=rd_taxi_system_manage_states&message=success'));
								$success_msg = 'You have updated ' . $count_data['count_true'] . ' fixed price city  successfully';
								$failed_msg = 'Failed to  update ' . $count_data['count_false'] . 'fixed price city. Try again. ';
								echo '<script>window.location.href="?page=rd_taxi_system_manage_cities&success_msg=' . $success_msg . '&failed_msg='.$failed_msg.'&count_true='.$count_data['count_true'].'&count_false='.$count_data['count_false'].'"</script>';
							}
							
						} //End of update state
						
					} //End of elseif ?>
			</div>
		</div>
		
	<?php }  //End of Manage City
	
	
	
	
	//***************************Page for manage quotes **************************************//
	
	
	function wp_rd_taxi_system_manage_quotes(){ ?>
		<div class="container">
			<h2> Manage Quotes</h2>
			<div class="wprdts-form-container">
			<?php 		
				if(isset($_GET['success_msg'])) {
					if($_GET['count_true'] > 0){
						echo '<p class="success-message"> ' . $_GET['success_msg'] . '</p>';
					}
				}
					
				 if(isset($_GET['failed_msg'])) {
					if($_GET['count_false'] > 0){
						echo '<p class="failed-message"> ' . $_GET['failed_msg'] . '</p>';
					}
				}
			?>
			<?php if(!isset($_GET['wprdts_action'])){ ?>
				<div class="wprdts-form-container-header">
					<div class="wprdts-btn-conaiter">
						<!--<span><a href="?page=rd_taxi_system_manage_quotes&wprdts_action=<?php echo ACTION_ADD ;?>" class="button button-primary button-large" id="btn-add-quote">Add</a></span> -->
						<span><a class="button button-primary button-large" id="btn-edit-quote" onclick="getFormActionForQuote(this)" >Edit</a></span>
						<span><a class="button button-primary button-large" id="btn-delete-quote" onclick="getFormActionForQuote(this)" >Delete</a></span>
						<!-- <span><a class="button button-primary button-large" id="btn-copy-quote" onclick="getFormActionForQuote(this)" >Copy</a></span> -->
						<span><a class="button button-primary button-large" id="btn-publish-quote" onclick="getFormActionForQuote(this)" >Publish</a></span>
						<span><a class="button button-primary button-large" id="btn-unpublish-quote" onclick="getFormActionForQuote(this)" >Unpublish</a></span>
					</div>
					<div class="wprdts-search-box-container">
						<span>
							<form action="#" method="post" id="wprdts-quote-search-form"><input type="search" name="wprdts-search-box" class="wprdts-search-box" id="wprdts-quote-search-box" placeholder="Ex : ID or Name or Email"/></form>
						</span>
						<span>
							<a  class="button" id="btn-search-quote" onclick="validatedSearchForm(this)">Search</a>
						</span>
					</div>
				</div>
	
				<div class="wprdts-form-body"> 
				<form action="#" method="post" id="wprdts-quote-form">					 
					<?php 
						if(isset($_GET['wprdts_action_search'])){
							if($_GET['wprdts_action_search'] == ACTION_SEARCH){
								//print_r($_GET['wprdts_action_search']); exit;
								?> 	
								<div class="wprdts-quote-form-body-header"> 
									<span>
										<input type="checkbox" class="wprdts-form-checkbox" onclick="$('#wprdts-quote-form input[name*=\'quotes\']').attr('checked', this.checked);"/>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_BOOKING_ID ;?>" class="wprdts-sortable-col">ID</a> 
										<?php if( isset($_GET['wprdts_action_sort_by_mame_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_BOOKING_ID ;?>&wprdts_action_sort_by_mame_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php }else if(isset($_GET['wprdts_action_sort_by_mame_desc'])){ ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_BOOKING_ID ;?>&wprdts_action_sort_by_mame_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_BOOKING_ID ;?>&wprdts_action_sort_by_mame_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_NAME ;?>" class="wprdts-sortable-col">Name</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_state_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_NAME ;?>&wprdts_action_sort_by_state_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_state_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_NAME ;?>&wprdts_action_sort_by_state_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_NAME ;?>&wprdts_action_sort_by_state_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_EMAIL ;?>" class="wprdts-sortable-col">Email</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_zip_code_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_EMAIL ;?>&wprdts_action_sort_by_zip_code_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_zip_code_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_EMAIL ;?>&wprdts_action_sort_by_zip_code_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_EMAIL ;?>&wprdts_action_sort_by_zip_code_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_PHONE ;?>" class="wprdts-sortable-col">Phone</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_price_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_PHONE ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_price_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_PHONE ;?>&wprdts_action_sort_by_price_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_PHONE ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_PASSENGER ;?>" class="wprdts-sortable-col">Passenger</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_price_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_PASSENGER ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_price_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_PASSENGER ;?>&wprdts_action_sort_by_price_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_PASSENGER ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_LUGGAGE ;?>" class="wprdts-sortable-col">Luggage </a> 
										<?php if(isset($_GET['wprdts_action_sort_by_price_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_LUGGAGE ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_price_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_LUGGAGE ;?>&wprdts_action_sort_by_price_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_LUGGAGE ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_TRIP_TIME_DATE ;?>" class="wprdts-sortable-col">Date</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_id_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_TRIP_TIME_DATE ;?>&wprdts_action_sort_by_id_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_id_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_TRIP_TIME_DATE ;?>&wprdts_action_sort_by_id_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_TRIP_TIME_DATE ;?>&wprdts_action_sort_by_id_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_STATUS ;?>" class="wprdts-sortable-col">Status</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_status_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_STATUS ;?>&wprdts_action_sort_by_status_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_status_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_STATUS ;?>&wprdts_action_sort_by_status_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_search=<?php echo ACTION_SEARCH; ?>&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_STATUS ;?>&wprdts_action_sort_by_status_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
								</div>
								<?php
								if(isset($_GET['wprdts_action_sorting_order'])){
									if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_BOOKING_LIST_COL_NAME ){
										if(isset($_GET['wprdts_action_sort_by_mame_asc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_NAME." ".$_GET['wprdts_action_sort_by_mame_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_mame_desc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_NAME." ".$_GET['wprdts_action_sort_by_mame_desc'];
										} else{
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_NAME." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_BOOKING_LIST_COL_EMAIL){
										if(isset($_GET['wprdts_action_sort_by_state_asc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_EMAIL." ".$_GET['wprdts_action_sort_by_state_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_state_desc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_EMAIL." ".$_GET['wprdts_action_sort_by_state_desc'];
										} else{
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_EMAIL." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_BOOKING_LIST_COL_PHONE){
										if(isset($_GET['wprdts_action_sort_by_zip_code_asc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_PHONE." ".$_GET['wprdts_action_sort_by_zip_code_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_zip_code_desc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_PHONE." ".$_GET['wprdts_action_sort_by_zip_code_desc'];
										} else{
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_PHONE." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_BOOKING_LIST_COL_PASSENGER ){
										if(isset($_GET['wprdts_action_sort_by_price_asc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_PASSENGER." ".$_GET['wprdts_action_sort_by_price_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_price_desc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_PASSENGER." ".$_GET['wprdts_action_sort_by_price_desc'];
										} else{
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_PASSENGER." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_BOOKING_LIST_COL_LUGGAGE ){
										if(isset($_GET['wprdts_action_sort_by_id_asc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_LUGGAGE." ".$_GET['wprdts_action_sort_by_id_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_id_desc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_LUGGAGE." ".$_GET['wprdts_action_sort_by_id_desc'];
										} else{
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_LUGGAGE." ".WPRDTS_SORT_ASC;
										}
									}else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_BOOKING_LIST_COL_TRIP_TIME_DATE ){
										if(isset($_GET['wprdts_action_sort_by_status_asc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_TRIP_TIME_DATE." ".$_GET['wprdts_action_sort_by_status_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_status_desc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_TRIP_TIME_DATE." ".$_GET['wprdts_action_sort_by_status_desc'];
										} else{
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_TRIP_TIME_DATE." ".WPRDTS_SORT_ASC;
										}
									}else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_BOOKING_LIST_COL_BOOKING_ID ){
										if(isset($_GET['wprdts_action_sort_by_status_asc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_BOOKING_ID." ".$_GET['wprdts_action_sort_by_status_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_status_desc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_BOOKING_ID." ".$_GET['wprdts_action_sort_by_status_desc'];
										} else{
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_BOOKING_ID." ".WPRDTS_SORT_ASC;
										}
									}else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_BOOKING_LIST_COL_STATUS ){
										if(isset($_GET['wprdts_action_sort_by_status_asc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_STATUS." ".$_GET['wprdts_action_sort_by_status_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_status_desc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_STATUS." ".$_GET['wprdts_action_sort_by_status_desc'];
										} else{
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_STATUS." ".WPRDTS_SORT_ASC;
										}
									}
								} else{
									$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_BOOKING_ID." ".WPRDTS_SORT_ASC;
								}
								
								//Search booking request
								$booking_list = get_booking_list($data_order);
								if($booking_list){
									foreach($booking_list as $quote){ ?>
										<div class="wprdts-quote-form-data">
											<span><input type="checkbox" name="quotes[]" class="wprdts-form-checkbox" value="<?php echo $quote->booking_id; ?>" /></span>
											<span><a href="?page=rd_taxi_system_manage_quotes&wprdts_action=action_edit&editing_quote_id=<?php echo $quote->booking_id; ?>" class="wprdts-sortable-col"><?php echo $quote->booking_id; ?></a></span>
											<span><?php echo $quote->name; ?></span>
											<span><?php echo $quote->email; ?></span>
											<span><?php echo $quote->phone; ?></span>
											<span><?php echo $quote->passenger; ?></span>
											<span><?php echo $quote->luggage; ?></span>
											<span><?php echo $quote->trip_date_time; ?></span>
											<span><?php if($quote->status == 0){echo 'Cancelled';} 
														else if($quote->status == 1) {echo 'Pending';}
														else if($quote->status == 2) {echo 'Success';}
														else{ echo 'Invalid'; }
													?>
											</span>
										</div>
								<?php }
								}else{
									echo '<h3 class="empty-message">No quote on database currently</h3>';
								}
							}
						} else{
	
							if(isset($_GET['wprdts_action_sorting_order'])){
									if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_BOOKING_LIST_COL_BOOKING_ID ){
										if(isset($_GET['wprdts_action_sort_by_mame_asc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_BOOKING_ID." ".$_GET['wprdts_action_sort_by_mame_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_mame_desc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_BOOKING_ID." ".$_GET['wprdts_action_sort_by_mame_desc'];
										} else{
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_BOOKING_ID." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_BOOKING_LIST_COL_NAME){
										if(isset($_GET['wprdts_action_sort_by_state_asc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_NAME." ".$_GET['wprdts_action_sort_by_state_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_state_desc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_NAME." ".$_GET['wprdts_action_sort_by_state_desc'];
										} else{
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_NAME." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_BOOKING_LIST_COL_EMAIL){
										if(isset($_GET['wprdts_action_sort_by_zip_code_asc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_EMAIL." ".$_GET['wprdts_action_sort_by_zip_code_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_zip_code_desc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_EMAIL." ".$_GET['wprdts_action_sort_by_zip_code_desc'];
										} else{
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_EMAIL." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_BOOKING_LIST_COL_PHONE){
										if(isset($_GET['wprdts_action_sort_by_price_asc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_PHONE." ".$_GET['wprdts_action_sort_by_price_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_price_desc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_PHONE." ".$_GET['wprdts_action_sort_by_price_desc'];
										} else{
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_PHONE." ".WPRDTS_SORT_ASC;
										}
									} else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_BOOKING_LIST_COL_PASSENGER){
										if(isset($_GET['wprdts_action_sort_by_id_asc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_PASSENGER." ".$_GET['wprdts_action_sort_by_id_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_id_desc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_PASSENGER." ".$_GET['wprdts_action_sort_by_id_desc'];
										} else{
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_PASSENGER." ".WPRDTS_SORT_ASC;
										}
									}else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_BOOKING_LIST_COL_LUGGAGE){
										if(isset($_GET['wprdts_action_sort_by_status_asc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_LUGGAGE." ".$_GET['wprdts_action_sort_by_status_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_status_desc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_LUGGAGE." ".$_GET['wprdts_action_sort_by_status_desc'];
										} else{
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_LUGGAGE." ".WPRDTS_SORT_ASC;
										}
									}else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_BOOKING_LIST_COL_TRIP_TIME_DATE ){
										if(isset($_GET['wprdts_action_sort_by_status_asc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_TRIP_TIME_DATE." ".$_GET['wprdts_action_sort_by_status_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_status_desc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_TRIP_TIME_DATE." ".$_GET['wprdts_action_sort_by_status_desc'];
										} else{
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_TRIP_TIME_DATE." ".WPRDTS_SORT_ASC;
										}
									}else if($_GET['wprdts_action_sorting_order'] == TABLE_WPRDTS_BOOKING_LIST_COL_STATUS ){
										if(isset($_GET['wprdts_action_sort_by_status_asc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_STATUS." ".$_GET['wprdts_action_sort_by_status_asc'];
										} else if(isset($_GET['wprdts_action_sort_by_status_desc'])) {
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_STATUS." ".$_GET['wprdts_action_sort_by_status_desc'];
										} else{
											$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_STATUS." ".WPRDTS_SORT_ASC;
										}
									}
								} else{
									$data_order = TABLE_WPRDTS_BOOKING_LIST_COL_BOOKING_ID." ".WPRDTS_SORT_DSC;
								}
								?> 
								<div class="wprdts-quote-form-body-header"> 
									<span>
										<input type="checkbox" class="wprdts-form-checkbox" onclick="$('#wprdts-quote-form input[name*=\'quotes\']').attr('checked', this.checked);"/>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_BOOKING_ID ;?>" class="wprdts-sortable-col">ID</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_mame_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_BOOKING_ID ;?>&wprdts_action_sort_by_mame_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_mame_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_BOOKING_ID ;?>&wprdts_action_sort_by_mame_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_BOOKING_ID ;?>&wprdts_action_sort_by_mame_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_NAME ;?>" class="wprdts-sortable-col">Name</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_state_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_NAME ;?>&wprdts_action_sort_by_state_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_state_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_NAME ;?>&wprdts_action_sort_by_state_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_NAME ;?>&wprdts_action_sort_by_state_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_EMAIL ;?>" class="wprdts-sortable-col">Email </a> 
										<?php if(isset($_GET['wprdts_action_sort_by_zip_code_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_EMAIL ;?>&wprdts_action_sort_by_zip_code_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_zip_code_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_EMAIL ;?>&wprdts_action_sort_by_zip_code_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_EMAIL ;?>&wprdts_action_sort_by_zip_code_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_PHONE ;?>" class="wprdts-sortable-col">Phone </a> 
										<?php if(isset($_GET['wprdts_action_sort_by_price_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_PHONE ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_price_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_PHONE ;?>&wprdts_action_sort_by_price_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_PHONE ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_PASSENGER ;?>" class="wprdts-sortable-col"> Passenger </a> 
										<?php if(isset($_GET['wprdts_action_sort_by_price_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_PASSENGER ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_price_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_PASSENGER ;?>&wprdts_action_sort_by_price_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_PASSENGER ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_LUGGAGE ;?>" class="wprdts-sortable-col"> Luggage </a> 
										<?php if(isset($_GET['wprdts_action_sort_by_price_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_LUGGAGE ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_price_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_LUGGAGE ;?>&wprdts_action_sort_by_price_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_LUGGAGE ;?>&wprdts_action_sort_by_price_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_TRIP_TIME_DATE ;?>" class="wprdts-sortable-col">Date</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_id_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_TRIP_TIME_DATE ;?>&wprdts_action_sort_by_id_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_id_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_TRIP_TIME_DATE ;?>&wprdts_action_sort_by_id_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_TRIP_TIME_DATE ;?>&wprdts_action_sort_by_id_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
									<span>
										<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_STATUS ;?>" class="wprdts-sortable-col">Status</a> 
										<?php if(isset($_GET['wprdts_action_sort_by_status_asc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_STATUS ;?>&wprdts_action_sort_by_status_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } else if(isset($_GET['wprdts_action_sort_by_status_desc'])) { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_STATUS ;?>&wprdts_action_sort_by_status_asc=<?php echo WPRDTS_SORT_ASC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-down"></i></a>
										<?php } else { ?>
											<a href="?page=rd_taxi_system_manage_quotes&wprdts_action_sorting_order=<?php echo TABLE_WPRDTS_BOOKING_LIST_COL_STATUS ;?>&wprdts_action_sort_by_status_desc=<?php echo WPRDTS_SORT_DSC; ?>" class="wprdts-sortable-col_asc"><i class="fa fa-caret-square-o-up"></i></a>
										<?php } ?>
									</span>
								</div>
						<?php 
							$booking_list = get_booking_list($data_order);
							if($booking_list){
								foreach($booking_list as $quote){ ?>
									<div class="wprdts-quote-form-data">
										<span><input type="checkbox" name="quotes[]" class="wprdts-form-checkbox" value="<?php echo $quote->booking_id; ?>" /></span>
										<span><a href="?page=rd_taxi_system_manage_quotes&wprdts_action=action_edit&editing_quote_id=<?php echo $quote->booking_id; ?>" class="wprdts-sortable-col"><?php echo $quote->booking_id; ?></a></span>
										<span><?php echo $quote->name; ?></span>
										<span><?php echo $quote->email; ?></span>
										<span><?php echo $quote->phone; ?></span>
										<span><?php echo $quote->passenger; ?></span>
										<span><?php echo $quote->luggage; ?></span>
										<span><?php echo $quote->trip_date_time; ?></span>
										<span><?php if($quote->status == 0){echo 'Cancelled';} 
														else if($quote->status == 1) {echo 'Pending';}
														else if($quote->status == 2) {echo 'Success';}
														else{ echo 'Invalid'; }
												?>
										</span>
									</div>
							<?php }
							}else{
								echo '<h3 class="empty-message">No quote on database currently</h3>';
							}
						}
					?>	
					</form>
				</div> 
			<?php  
			} else if(isset($_GET['wprdts_action'])){
						//Go to add city form
						/* if($_GET['wprdts_action'] == ACTION_ADD){
							get_add_city_form();
						} */
						
						//Go to edit quote form  - Multi Edit
						if($_GET['wprdts_action'] == ACTION_EDIT && isset($_POST['quotes'])){
							//print_r($_POST['states']); 
							get_full_quote_edit_form_by_id($_POST['quotes']);
						}
						
						//Go to full quote data by id -- Single Edit
						if($_GET['wprdts_action'] == ACTION_EDIT && isset($_GET['editing_quote_id'])){
							//print_r($_GET['editing_city_id']);
							$editing_quote_id = $_GET['editing_quote_id'];
							get_full_quote_data_by_id($editing_quote_id);
						}
						
						//Delete quote by id
						if($_GET['wprdts_action'] == ACTION_DELETE && isset($_POST['quotes'])){
							//print_r($_POST['cities']); 
							$query_results = delete_quote_by_id($_POST['quotes']);
							$query_results_for_delete_quote = count_true_false($query_results);
							
							if($query_results_for_delete_quote['count_true'] > 0 || $query_results_for_delete_quote['count_false'] > 0){
								//wp_redirect( admin_url( 'admin.php?page=rd_taxi_system_manage_states&message=success'));
								$success_msg = 'You have deleted ' . $query_results_for_delete_quote['count_true'] . ' quote  successfully';
								$failed_msg = 'Failed to  delete ' . $query_results_for_delete_quote['count_false'] . ' quote. Try again. ';
								echo '<script>window.location.href="?page=rd_taxi_system_manage_quotes&success_msg=' . $success_msg . '&failed_msg='.$failed_msg.'&count_true='.$query_results_for_delete_quote['count_true'].'&count_false='.$query_results_for_delete_quote['count_false'].'"</script>';
							}
						}
						
						//Copy quote by id
						if($_GET['wprdts_action'] == ACTION_COPY && isset($_POST['quotes'])){
							//print_r($_POST['cities']); 
							$query_results_copy = copy_quote_by_id($_POST['quotes']);
							//print_r($query_results); exit;
							$query_results_for_copy_quote = count_true_false($query_results_copy);
							
							if($query_results_for_copy_quote['count_true'] > 0 || $query_results_for_copy_quote['count_false'] > 0){
								//wp_redirect( admin_url( 'admin.php?page=rd_taxi_system_manage_states&message=success'));
								$success_msg = 'You have copied ' . $query_results_for_copy_quote['count_true'] . ' quote  successfully with new ID';
								$failed_msg = 'Failed to  copy ' . $query_results_for_copy_quote['count_false'] . ' quote. Try again. ';
								echo '<script>window.location.href="?page=rd_taxi_system_manage_quotes&success_msg=' . $success_msg . '&failed_msg='.$failed_msg.'&count_true='.$query_results_for_copy_quote['count_true'].'&count_false='.$query_results_for_copy_quote['count_false'].'"</script>';
							}
						} 
						
						//Publish city by id
						if($_GET['wprdts_action'] == ACTION_PUBLISH && isset($_POST['quotes'])){
							//print_r($_POST['cities']); 
							$query_results_publish = publish_quote_by_id($_POST['quotes']);
							//print_r($query_results); exit;
							$query_results_for_publish_quote = count_true_false($query_results_publish);
							
							if($query_results_for_publish_quote['count_true'] > 0 || $query_results_for_publish_quote['count_false'] > 0){
								//wp_redirect( admin_url( 'admin.php?page=rd_taxi_system_manage_states&message=success'));
								$success_msg = 'You have published ' . $query_results_for_publish_quote['count_true'] . ' quote  successfully';
								$failed_msg = 'Failed to  publish ' . $query_results_for_publish_quote['count_false'] . ' quote. Try again. ';
								echo '<script>window.location.href="?page=rd_taxi_system_manage_quotes&success_msg=' . $success_msg . '&failed_msg='.$failed_msg.'&count_true='.$query_results_for_publish_quote['count_true'].'&count_false='.$query_results_for_publish_quote['count_false'].'"</script>';
							}
						}

						//Unpublished city by id
						if($_GET['wprdts_action'] == ACTION_UNPUBLISH && isset($_POST['quotes'])){
							//print_r($_POST['cities']); 
							$query_results_unpublish = unpublish_quote_by_id($_POST['quotes']);
							//print_r($query_results); exit;
							$query_results_for_unpublish_quote = count_true_false($query_results_unpublish);
							
							if($query_results_for_unpublish_quote['count_true'] > 0 || $query_results_for_unpublish_quote['count_false'] > 0){
								//wp_redirect( admin_url( 'admin.php?page=rd_taxi_system_manage_states&message=success'));
								$success_msg = 'You have unpublished ' . $query_results_for_unpublish_quote['count_true'] . ' quote  successfully';
								$failed_msg = 'Failed to  unpublished ' . $query_results_for_unpublish_quote['count_false'] . ' quote. Try again. ';
								echo '<script>window.location.href="?page=rd_taxi_system_manage_quotes&success_msg=' . $success_msg . '&failed_msg='.$failed_msg.'&count_true='.$query_results_for_unpublish_quote['count_true'].'&count_false='.$query_results_for_unpublish_quote['count_false'].'"</script>';
							}
						} 
						
						//Add City 
						if($_GET['wprdts_action'] == ADD_CITY){
							$query_result = add_city($_POST);
							$query_results_for_add_city = count_true_false($query_result);
							
							if($query_results_for_add_city['count_true'] > 0 || $query_results_for_add_city['count_false'] > 0){
								//wp_redirect( admin_url( 'admin.php?page=rd_taxi_system_manage_states&message=success'));
								$success_msg = 'You have added ' . $query_results_for_add_city['count_true'] . ' city  successfully';
								$failed_msg = 'Failed to  add ' . $query_results_for_add_city['count_false'] . ' city. Try again. ';
								echo '<script>window.location.href="?page=rd_taxi_system_manage_cities&success_msg=' . $success_msg . '&failed_msg='.$failed_msg.'&count_true='.$query_results_for_add_city['count_true'].'&count_false='.$query_results_for_add_city['count_false'].'"</script>';
							}
							
							}
						
						//Update cities
						if($_GET['wprdts_action'] == EDIT_CITY){
							//echo '<pre>'; print_r($_POST); echo '</pre>'; exit;
							//print_r($_POST['id']);
							$results = update_cities_by_id($_POST);
							$count_data = count_true_false($results);
							//echo var_dump($count_data); exit;
							 //print_r($count_data); //exit;
							
							if($count_data['count_true'] > 0 || $count_data['count_false'] > 0){
								//wp_redirect( admin_url( 'admin.php?page=rd_taxi_system_manage_states&message=success'));
								$success_msg = 'You have updated ' . $count_data['count_true'] . ' city  successfully';
								$failed_msg = 'Failed to  update ' . $count_data['count_false'] . ' city. Try again. ';
								echo '<script>window.location.href="?page=rd_taxi_system_manage_cities&success_msg=' . $success_msg . '&failed_msg='.$failed_msg.'&count_true='.$count_data['count_true'].'&count_false='.$count_data['count_false'].'"</script>';
							}
							
						} //End of update state
						
					} //End of elseif ?>
			</div>
		</div>
	<? }
	
	//Page for manage languages 
	function wp_rd_taxi_system_manage_languages(){ ?>
		<div class="container"> 
			<h2> Manage Language</h2>
			<?php if(isset($_GET['wprdts_action'])) { 
					if($_GET['wprdts_action'] == WPRDTS_OPTION_ACTION_SETTING_SAVE && isset($_POST)){
						//echo '<pre>'; print_r($_POST); echo '</pre>'; exit;
						foreach($_POST as $name => $value){ 
							if(get_option($name) || get_option($name) == 0){
								$option_updated = update_option($name, trim($value));
								/* if($option_updated){
									echo '<p class="success-message"> Setting changed</p>';
								}else{
									echo '<p class="failed-message"> Failed to change setting</p>';
								} */
							} else{
								$option_added = add_option($name, trim($value));
								/* if($option_added){
									echo '<p class="success-message"> Setting changed</p>';
								}else{
									echo '<p class="failed-message"> Failed to change setting</p>';
								} */
							}
						}
					} 
				} ?>
			<div class="wprdts-manage-language-container"> 
				<div class="wprdts-manage-language-form-container">
					<form action="?page=rd_taxi_system_manage_languages&wprdts_action=<?php echo WPRDTS_OPTION_ACTION_SETTING_SAVE; ?>" method="post">
						<div class="wprdts-manage-language-form-element"> 
							<span><input type="submit" class="button button-primary button-large wprdts-manage-language-submit" value="Save"/> </span> <span></span>
						</div>
						<div class="wprdts-manage-language-form-header"> 
							<span> Key </span>
							<span> Original </span>
							<span> Translation </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_PLUGIN_NAME </span>
							<span> WP RD Taxi System </span>
							<span> <input type="text" name="wprdts-label-plugin-name" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-plugin-name')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_STATE </span>
							<span> State </span>
							<span> <input type="text" name="wprdts-label-state" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-state')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_SELECT_STATE </span>
							<span> Select State </span>
							<span> <input type="text" name="wprdts-label-select-state" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-select-state')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_STATES </span>
							<span> States </span>
							<span> <input type="text" name="wprdts-label-states" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-states')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_CITY </span>
							<span> City </span>
							<span> <input type="text" name="wprdts-label-city" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-city')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_CITIES </span>
							<span> Cities </span>
							<span> <input type="text" name="wprdts-label-cities" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-cities')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_MANAGE_QUOTES </span>
							<span> Manage Quotes </span>
							<span> <input type="text" name="wprdts-label-manage-quotes" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-manage-quotes')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_MANAGE_LANGUAGE </span>
							<span> Manage Language </span>
							<span> <input type="text" name="wprdts-label-manage-language" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-manage-language')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_GENERAL_SETTINGS </span>
							<span> General Settings </span>
							<span> <input type="text" name="wprdts-label-general-settings" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-general-settings')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_BOOKING_SYSTEM </span>
							<span> RD Taxi Booking System </span>
							<span> <input type="text" name="wprdts-label-booking-system" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-booking-system')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_TRIP_TYPE</span>
							<span> Trip Type </span>
							<span> <input type="text" name="wprdts-label-trip-type" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-trip-type')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_SELECT_TRIP_TYPE</span>
							<span> Select Trip Type </span>
							<span> <input type="text" name="wprdts-label-select-trip-type" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-select-trip-type')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_RIDE_TO_AIRPORT</span>
							<span> Ride to Airport </span>
							<span> <input type="text" name="wprdts-label-ride-to-airport" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-ride-to-airport')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_RIDE_FROM_AIRPORT</span>
							<span> Ride from Airport </span>
							<span> <input type="text" name="wprdts-label-ride-from-airport" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-ride-from-airport')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_DESTINATION_STATE</span>
							<span> Your Destination Sate</span>
							<span> <input type="text" name="wprdts-label-destination-state" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-destination-state')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_DESTINATION_CITY_ZIP</span>
							<span> Your Destination CITY/ZIP</span>
							<span> <input type="text" name="wprdts-label-destination-city-zip" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-destination-city-zip')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_PASSENGER</span>
							<span> Passenger</span>
							<span> <input type="text" name="wprdts-label-passenger" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-passenger')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_SELECT_PASSENGER</span>
							<span> Select Passenger</span>
							<span> <input type="text" name="wprdts-label-select-passenger" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-select-passenger')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_NUMBER_OF_PASSENGER</span>
							<span> Number Of Passenger</span>
							<span> <input type="text" name="wprdts-label-number-of-passenger" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-number-of-passenger')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_LUGGAGE</span>
							<span> Luggage</span>
							<span> <input type="text" name="wprdts-label-luggage" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-luggage')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_NUMBER_OF_LUGGAGE</span>
							<span> Number Of Luggage</span>
							<span> <input type="text" name="wprdts-label-number-of-luggage" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-number-of-luggage')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_SELECT_LUGGAGE</span>
							<span> Select Luggage</span>
							<span> <input type="text" name="wprdts-label-select-luggage" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-select-luggage')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_ROUND_TRIP</span>
							<span> Round Trip</span>
							<span> <input type="text" name="wprdts-label-round-trip" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-round-trip')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_YES</span>
							<span> Yes</span>
							<span> <input type="text" name="wprdts-label-yes" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-yes')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_NO</span>
							<span> No</span>
							<span> <input type="text" name="wprdts-label-no" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-no')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_CONTINUE_BUTTON</span>
							<span> Continue</span>
							<span> <input type="text" name="wprdts-label-continue-button" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-continue-button')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_SUBMIT_BUTTON</span>
							<span> Continue</span>
							<span> <input type="text" name="wprdts-label-submit-button" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-submit-button')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_VEHICLE_TYPE</span>
							<span> Vehicle Type</span>
							<span> <input type="text" name="wprdts-label-vehicle-type" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-vehicle-type')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_SELECT_VEHICLE</span>
							<span> Select Vehicle</span>
							<span> <input type="text" name="wprdts-label-select-vehicle" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-select-vehicle')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_TRIP_DATE</span>
							<span> Trip Date</span>
							<span> <input type="text" name="wprdts-label-trip-date" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-trip-date')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_TRIP_TIME</span>
							<span> Trip Time</span>
							<span> <input type="text" name="wprdts-label-trip-time" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-trip-time')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_PICKUP_LOCATION</span>
							<span> Your Pickup Location</span>
							<span> <input type="text" name="wprdts-label-pickup-location" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-pickup-location')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_DROPOFF_LOCATION</span>
							<span> Your Dropoff Location</span>
							<span> <input type="text" name="wprdts-label-dropoff-location" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-dropoff-location')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_AIRLINE_DETAILS</span>
							<span> Airline Details</span>
							<span> <input type="text" name="wprdts-label-airline-details" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-airline-details')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_FILIGH_NUMBER</span>
							<span> Flight Number</span>
							<span> <input type="text" name="wprdts-label-flight-number" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-flight-number')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_RETURN_TRIP_DATE</span>
							<span> Return Trip Date</span>
							<span> <input type="text" name="wprdts-label-return-trip-date" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-return-trip-date')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_RETURN_TRIP_TIME</span>
							<span> Return Trip Time</span>
							<span> <input type="text" name="wprdts-label-return-trip-time" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-return-trip-time')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_RETURN_PICKUP_LOCATION</span>
							<span> Return Pickup Location</span>
							<span> <input type="text" name="wprdts-label-return-pickup-location" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-return-pickup-location')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_RETURN_DROPOFF_LOCATION</span>
							<span> Return Dropoff Location</span>
							<span> <input type="text" name="wprdts-label-return-dropoff-location" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-return-dropoff-location')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_RETURN_AIRLINE_DETAILS</span>
							<span> Return Airline Details</span>
							<span> <input type="text" name="wprdts-label-return-airline-details" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-return-airline-details')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_RETURN_FLIGHT_NUMBER</span>
							<span> Return Flight Number</span>
							<span> <input type="text" name="wprdts-label-return-flight-number" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-return-flight-number')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_NAME</span>
							<span> Your Name</span>
							<span> <input type="text" name="wprdts-label-name" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-name')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_EMAIL</span>
							<span> Your Email</span>
							<span> <input type="text" name="wprdts-label-email" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-email')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_PHONE</span>
							<span> Your Phone</span>
							<span> <input type="text" name="wprdts-label-phone" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-phone')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_PRICE</span>
							<span> Price</span>
							<span> <input type="text" name="wprdts-label-price" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-price')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_TOTAL_PRICE</span>
							<span> Total Price</span>
							<span> <input type="text" name="wprdts-label-total-price" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-total-price')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_CALL_FOR_PRICE</span>
							<span> Call For Price</span>
							<span> <input type="text" name="wprdts-label-call-for-price" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-call-for-price')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_STATUSBAR_STEP_ONE</span>
							<span> Book Your Trip</span>
							<span> <input type="text" name="wprdts-label-status-bar-step-one" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-status-bar-step-one')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_STATUSBAR_STEP_TWO</span>
							<span> Trip Date and Time</span>
							<span> <input type="text" name="wprdts-label-status-bar-step-two" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-status-bar-step-two')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span> WPRDTS_LABEL_STATUSBAR_STEP_THREE</span>
							<span> Checkout</span>
							<span> <input type="text" name="wprdts-label-status-bar-step-three" class="wprdts-manage-language-input-text" <?php if($value = get_option('wprdts-label-status-bar-step-three')) echo 'value="'.$value.'"'; ?> /> </span>
						</div>
						<div class="wprdts-manage-language-form-element"> 
							<span></span><span><input type="submit" class="button button-primary button-large wprdts-manage-language-submit" value="Save"/> </span> <span></span>
						</div>
					</form>
				</div>
			</div>
		</div>
	<? }
	
	//Page for general settings
	function wp_rd_taxi_system_general_settings(){ ?>
		<div class="container">
			<h2> General Setting</h2>
			<?php if(isset($_GET['wprdts_action'])) { 
					if($_GET['wprdts_action'] == WPRDTS_OPTION_ACTION_SETTING_SAVE && isset($_POST)){
						//echo '<pre>'; print_r($_POST); echo '</pre>'; exit;
						foreach($_POST as $name => $value){ 
							if(get_option($name) || get_option($name) == 0){
								$option_updated = update_option($name, trim($value));
								/* if($option_updated){
									echo '<p class="success-message"> Setting changed</p>';
								}else{
									echo '<p class="failed-message"> Failed to change setting</p>';
								} */
							} else{
								$option_added = add_option($name, trim($value));
								/* if($option_added){
									echo '<p class="success-message"> Setting changed</p>';
								}else{
									echo '<p class="failed-message"> Failed to change setting</p>';
								} */
							}
						}
					} 
				} ?>
			<div class="wprdts-general-setting-container"> 
				<form action="?page=rd_taxi_system_general_settings&wprdts_action=<?php echo WPRDTS_OPTION_ACTION_SETTING_SAVE; ?>" method="post">
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-main-location">Main Location</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element"> 
							<input type="text" name="wprdts-setting-form-main-location" class="wprdts-setting-form-text" id="wprdts-setting-form-main-location" <?php if($value = get_option('wprdts-setting-form-main-location')) echo 'value="'.$value.'"'; ?> required/>
						</div>
					</div>
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-currency">Currency</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element"> 
							<input type="text" name="wprdts-setting-form-currency" class="wprdts-setting-form-text" id="wprdts-setting-form-currency" <?php if($value = get_option('wprdts-setting-form-currency')) echo 'value="'.$value.'"'; ?> required/>
						</div>
					</div>
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-price-per-km">Price per Kilometre </label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element"> 
							<span class="wprdts-currency-symbol"><?php if($currency = get_option('wprdts-setting-form-currency')) echo $currency; ?></span>
							<input type="text" name="wprdts-setting-form-price-per-km" class="wprdts-setting-form-text" id="wprdts-setting-form-price-per-km" <?php if($value = get_option('wprdts-setting-form-price-per-km')) echo 'value="'.$value.'"'; ?> required/>
						</div>
					</div>
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-additional-price-one">Additional Price (For: Max 4 Passengers & Max 5 Luggages/Max 6 Passengers & Max 5 Luggages)</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element"> 
							<span class="wprdts-currency-symbol"><?php if($currency = get_option('wprdts-setting-form-currency')) echo $currency; ?></span>
							<input type="text" name="wprdts-setting-form-additional-price-one" class="wprdts-setting-form-text" id="wprdts-setting-form-additional-price-one" <?php if($value = get_option('wprdts-setting-form-additional-price-one')) echo 'value="'.$value.'"'; ?> required/>
						</div>
					</div>
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-additional-price-two">Additional Price (For: Max 4 Passengers & Max 6 Luggages/Max 6 Passengers & Max 6 Luggages)</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element"> 
							<span class="wprdts-currency-symbol"><?php if($currency = get_option('wprdts-setting-form-currency')) echo $currency; ?></span>
							<input type="text" name="wprdts-setting-form-additional-price-two" class="wprdts-setting-form-text" id="wprdts-setting-form-additional-price-two" <?php if($value = get_option('wprdts-setting-form-additional-price-two')) echo 'value="'.$value.'"'; ?> required/>
						</div>
					</div>
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-discount">Discount</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element"> 
							<select name="wprdts-setting-form-discount" id="wprdts-setting-form-discount" class="wprdts-setting-form-text">
								<option value="0" <?php $value = get_option('wprdts-setting-form-discount'); if($value == 0) echo 'selected="selected"'; ?> >No Discount</option>
								<option value="1" <?php $value = get_option('wprdts-setting-form-discount'); if($value == 1) echo 'selected="selected"'; ?> >In Percent (%)</option>
								<option value="2" <?php $value = get_option('wprdts-setting-form-discount'); if($value == 2) echo 'selected="selected"'; ?> >Fixed Amount</option>
							</select>
						</div>
					</div>
					<div class="wprdts-setting-form-element-container" id="wprdts-setting-form-discount-type-percent" style="display: none;"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-discount-message">Discount Amount</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element"> 
							<span class="wprdts-currency-symbol">%</span>
							<input type="text" name="wprdts-setting-form-discount-amount-percent" class="wprdts-setting-form-text" id="wprdts-setting-form-discount-amount-percent" <?php if($value = get_option('wprdts-setting-form-discount-amount-percent')) echo 'value="'.$value.'"'; ?> />
						</div>
					</div>
					<div class="wprdts-setting-form-element-container" id="wprdts-setting-form-discount-type-amount" style="display: none;"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-discount-message">Discount Amount</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element"> 
							<span class="wprdts-currency-symbol"><?php if($currency = get_option('wprdts-setting-form-currency')) echo $currency; ?></span>
							<input type="text" name="wprdts-setting-form-discount-amount-fixed" class="wprdts-setting-form-text" id="wprdts-setting-form-discount-amount-fixed" <?php if($value = get_option('wprdts-setting-form-discount-amount-fixed')) echo 'value="'.$value.'"'; ?> />
						</div>
					</div>
					<div class="wprdts-setting-form-element-container" id="wprdts-setting-form-field-discount-message" style="display: none;"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-discount-message">Discount Message</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element"> 
							<input type="text" name="wprdts-setting-form-discount-message" class="wprdts-setting-form-text" id="wprdts-setting-form-discount-message" <?php if($value = get_option('wprdts-setting-form-discount-message')) echo 'value="'.$value.'"'; ?> />
							<span class="wprdts-discount-message-tag" id="wprdts-discount-message-tag" >Discount Rate Tag = [DISCOUNT]</span>
						</div>
					</div>
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-enable-paypal">Enable Paypal</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element">
							<span class="wprdts-currency-symbol"> </span>
							<input type="radio" name="wprdts-setting-form-enable-paypal" class="wprdts-setting-form-radio" id="wprdts-setting-form-enable-paypal" value="1" <?php $value = get_option('wprdts-setting-form-enable-paypal'); if($value) {echo 'checked';} ?>/> Yes
							<input type="radio" name="wprdts-setting-form-enable-paypal" class="wprdts-setting-form-radio" id="wprdts-setting-form-enable-paypal" value="0" <?php $value = get_option('wprdts-setting-form-enable-paypal'); if(!$value) {echo 'checked';} ?>  /> No
						</div>
					</div>
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-paypal-email">Paypal Email</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element"> 
							<input type="email" name="wprdts-setting-form-paypal-email" class="wprdts-setting-form-text" id="wprdts-setting-form-paypal-email" <?php if($value = get_option('wprdts-setting-form-paypal-email')) echo 'value="'.$value.'"'; ?> required/> 	
						</div>
					</div>
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-paypal-test-mode">Paypal Test Mode</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element">
							<span class="wprdts-currency-symbol"> </span>
							<input type="radio" name="wprdts-setting-form-paypal-test-mode" class="wprdts-setting-form-radio" id="wprdts-setting-form-paypal-test-mode" value="1" <?php $value = get_option('wprdts-setting-form-paypal-test-mode'); if($value) {echo 'checked';} ?> /> Yes
							<input type="radio" name="wprdts-setting-form-paypal-test-mode" class="wprdts-setting-form-radio" id="wprdts-setting-form-paypal-test-mode" value="0" <?php $value = get_option('wprdts-setting-form-paypal-test-mode'); if(!$value) {echo 'checked';} ?> /> No
						</div>
					</div>
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-paypal-return-page">Paypal Return Page (Successfull payment)</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element">
							<select name="wprdts-setting-form-paypal-return-page" class="wprdts-setting-form-text" id="wprdts-setting-form-paypal-return-page">
								<option value="">--</option>
								<?php $pages = get_pages(array('post_type' => 'page', 'post_status' => 'publish')); 
									foreach($pages as $page){ ?>
										<option value="<?php echo $page->ID; ?>" <?php $value = get_option('wprdts-setting-form-paypal-return-page'); if($value == $page->ID) echo 'selected="selected"'; ?> ><?php echo $page->post_title; ?></option>
									<?php } ?>
							</select>
						</div>
					</div>
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-paypal-cancel-page">Paypal Cancel Page (Failed payment)</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element">
							<select name="wprdts-setting-form-paypal-cancel-page" class="wprdts-setting-form-text" id="wprdts-setting-form-paypal-cancel-page">
								<option value="">--</option>
								<?php $pages = get_pages(array('post_type' => 'page', 'post_status' => 'publish')); 
									foreach($pages as $page){ ?>
										<option value="<?php echo $page->ID; ?>" <?php $value = get_option('wprdts-setting-form-paypal-cancel-page'); if($value == $page->ID) echo 'selected="selected"'; ?> ><?php echo $page->post_title; ?></option>
									<?php } ?>
							</select>
						</div>
					</div>
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-confirm-subject-admin">Confirm Email Subject for Admin</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element">
							<input type="text" name="wprdts-setting-form-confirm-subject-admin" class="wprdts-setting-form-text" id="wprdts-setting-form-confirm-subject-admin" <?php if($value = get_option('wprdts-setting-form-confirm-subject-admin')) echo 'value="'.$value.'"'; ?> >								
						</div>
					</div>
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-confirm-message-admin">Confirm Email Content for Admin</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element">
							<?php $content = get_option('wprdts-setting-form-confirm-email-admin'); ?>
							<?php wp_editor( $content, 'wprdts-setting-form-confirm-email-admin', $settings = array('textarea_name' => 'wprdts-setting-form-confirm-email-admin') ); ?>
							<!-- <textarea rows="5" type="text" name="wprdts-setting-form-confirm-email-admin" class="wprdts-setting-form-text" id="wprdts-setting-form-confirm-email-admin" > <?php //if($value = get_option('wprdts-setting-form-confirm-email-admin')) echo $value; ?>	</textarea>	-->	 					
						</div>
					</div>
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-confirm-subject-user">Confirm Email Subject for User</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element">
							<input type="text" name="wprdts-setting-form-confirm-subject-user" class="wprdts-setting-form-text" id="wprdts-setting-form-confirm-subject-user" <?php if($value = get_option('wprdts-setting-form-confirm-subject-user')) echo 'value="'.$value.'"'; ?> >								
						</div>
					</div>
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-confirm-message-user">Confirm Email Content for User</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element">							<?php $content = get_option('wprdts-setting-form-confirm-email-user'); ?>							<?php wp_editor( $content, 'wprdts-setting-form-confirm-email-user', $settings = array('textarea_name' => 'wprdts-setting-form-confirm-email-user' ) ); ?>
							<!-- <textarea rows="5" type="text" name="wprdts-setting-form-confirm-email-user" class="wprdts-setting-form-text" id="wprdts-setting-form-confirm-email-user" >	<?php //if($value = get_option('wprdts-setting-form-confirm-email-user')) echo $value; ?></textarea> -->							
						</div>
					</div>
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-confirm-message-user">Confirm Message for User</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element">							<?php $content = get_option('wprdts-setting-form-confirm-message-user'); ?>							<?php wp_editor( $content, 'wprdts-setting-form-confirm-message-user', $settings = array('textarea_name' => 'wprdts-setting-form-confirm-message-user') ); ?>
							<!-- <textarea rows="5" type="text" name="wprdts-setting-form-confirm-message-user" class="wprdts-setting-form-text" id="wprdts-setting-form-confirm-message-user" >	<?php if($value = get_option('wprdts-setting-form-confirm-message-user')) echo $value; ?></textarea>	-->						
						</div>
					</div>
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-confirm-message-user">Admin Name</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element">
							<input type="text" name="wprdts-setting-form-admin-name" class="wprdts-setting-form-text" id="wprdts-setting-form-admin-name" <?php if($value = get_option('wprdts-setting-form-admin-name')) echo 'value="'.$value.'"'; ?> required>								
						</div>
					</div>
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-confirm-message-user">Admin Email</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element">
							<input type="text" name="wprdts-setting-form-admin-email" class="wprdts-setting-form-text" id="wprdts-setting-form-admin-email" <?php if($value = get_option('wprdts-setting-form-admin-email')) echo 'value="'.$value.'"'; ?> required>								
						</div>
					</div>
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-label">
							<label for="wprdts-setting-form-enable-status-bar">Enable Status Bar</label>
						</div>
						<div class="wprdts-setting-form-separator"> : </div>
						<div class="wprdts-setting-form-element">
							<span class="wprdts-currency-symbol"> </span>
							<input type="radio" name="wprdts-setting-form-enable-status-bar" class="wprdts-setting-form-radio" id="wprdts-setting-form-enable-status-bar" value="1" <?php $value = get_option('wprdts-setting-form-enable-status-bar'); if($value) {echo 'checked';} ?> /> Yes
							<input type="radio" name="wprdts-setting-form-enable-status-bar" class="wprdts-setting-form-radio" id="wprdts-setting-form-enable-status-bar" value="0" <?php $value = get_option('wprdts-setting-form-enable-status-bar'); if(!$value) {echo 'checked';} ?> /> No
						</div>
					</div>
					<div class="wprdts-setting-form-element-container"> 
						<div class="wprdts-setting-form-submit-container"> 
							<input type="submit" id="wprdts-setting-form-submit" class="wprdts-setting-form-submit button button-primary button-large" value="Save"/>
						</div>
					</div>
				</form>
			</div>
		</div>
	<? 

	}  //End of Page for general settings
	
	
	
	
?>