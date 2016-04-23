<?php 

	//Including other files 
	require_once(ABSPATH .'/wp-content/plugins/wp_rd_taxi_system/function/functions-state.php');
	
	
	////////************ Manage City ***********////////
	
	//Get add city form
	function get_add_city_form(){ ?>
		<div class="add-state-form-container add-city-form-container">
		<fieldset class="field_set">
						<legend><h2> &nbsp  Add City Fixed Price City &nbsp </h2></legend>
			<form action="?page=rd_taxi_system_manage_cities&wprdts_action=<?php echo ADD_CITY; ?>" method="post" enctype='multipart/form-data'>
				<!-- <p class="form-element">
					<span class="wprdts-label"><label for="wprdts-city-state">State</label>  : </span>
					<span>
						<select name="wprdts-city-state-id" class="wprdts-state-input-text wprdts-city-input-text" >
							<?php $states = get_all_state("state_name ASC"); 
								  foreach($states as $state) { ?>
							<option value="<?php echo $state->id; ?>"> <?php echo $state->state_name; ?> </option>
								  <?php } ?>
						</select>
					</span>
				</p> -->
				<p class="form-element">
					<span class="wprdts-label"><label for="wprdts-city-name">City Name</label>  : </span>
					<span><input type="text" name="wprdts-city-name" id="wprdts-input-add-fixed-price-city" class="wprdts-state-input-text" onKeyUp="autoCompleteForPickupLocation(this)" required/></span>
				</p>
				<p class="form-element">
					<span class="wprdts-label"><label for="wprdts-city-price">Price <?php if($currency = get_option('wprdts-setting-form-currency')) echo '('.$currency.')'; ?></label>  : </span>
					<span>						<input type="text" name="wprdts-city-price" class="wprdts-state-input-text wprdts-add-city-price"/>					</span>
				</p>
				<!-- <p class="form-element">
					<span class="wprdts-label"><label for="wprdts-city-zip-code">ZIP Code</label>  : </span>
					<span><input type="text" name="wprdts-city-zip-code" class="wprdts-state-input-text"/></span>
				</p> -->
				<p class="form-element">
					<span class="wprdts-label"><label for="wprdts-city-status">Status</label>  : </span>
					<span>
						<select name="wprdts-city-status" class="wprdts-state-input-text">
							<option value="<?php echo STATUS_PUBLISHED; ?>" >Published</option>
							<option value="<?php echo STATUS_UNPUBLISHED; ?>" selected="selected">Unpublished</option>
						</select>
					</span>
				</p>
				<p class="form-element">
					<span><input type="submit" name="wprdts-city-submit" class="wprdts-state-submit button button-primary button-large" value="Add"/></span>
				</p>
			</form>
		</fieldset>
		</div>
	<?php } 
	
	
	//Add city 
	function add_city($form_data){
		/* $city_state_id = (int) trim($form_data['wprdts-city-state-id']); */
		$city_name = trim($form_data['wprdts-city-name']);
		$city_price = (float) trim($form_data['wprdts-city-price']);
		/* $city_zip_code = (int) trim($form_data['wprdts-city-zip-code']); */
		$city_status = trim($form_data['wprdts-city-status']);
		$results = array();
		$data =  array(
			"city_name" => $city_name,
			/* "city_state_id" => $city_state_id, */
			"city_price" => $city_price,
			/* "city_zip_code" => $city_zip_code, */
			"city_status" => $city_status
		);
		//print_r($data);
		global $wpdb;
		$table_name = $wpdb->prefix.'wprdts_city';
		$results[]= $wpdb->insert($table_name, $data);
		return $results;
	}
	
	//get all city
	function get_all_city($data_order){
		global $wpdb;
		$table_name = $wpdb->prefix.'wprdts_city';
		$query = $wpdb->get_results("SELECT * FROM ".$table_name." ORDER BY ".$data_order."");
		//print_r($query);
		if($query){
			return $query;
		}else{
			return false;
		}
	}
	
	//Get city by names 
	function get_city_by_names($item, $data_order){
		$status = $item;
		global $wpdb;
		$table_name = $wpdb->prefix.'wprdts_city';
		if (substr($item, 0, 1) == 'p') { 
			$status = 1;
		} else if(substr($item, 0, 1) == 'u'){
			$status = 0;
		}
		$query = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE (city_name LIKE '".$item."%' OR city_price LIKE '".$item."%' OR city_status LIKE '".$status."%' OR id LIKE '".$item."%') ORDER BY ".$data_order."");
		//print_r($query); exit;
		if($query){
			return $query;
		}else{
			return false;
		}
	}
	
	//Get city by names 
	function get_city_by_name_or_zipcode($item, $stateId, $data_order){
		$stateId = (int) $stateId;
		global $wpdb;
		$table_name = $wpdb->prefix.'wprdts_city';
		$query = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE (city_name LIKE '".$item."%') ORDER BY ".$data_order." LIMIT 20");
		//print_r($query); exit;
		if($query){
			return $query;
		}else{
			return false;
		}
	}
	
	//Get city by ID 
	function get_city_with_state_by_id($id){
		global $wpdb;
		$table_name = $wpdb->prefix.'wprdts_city';
		//$query = $wpdb->get_results("SELECT * FROM ".$table_city." WHERE id='".$id."'");
		$query = $wpdb->get_row("SELECT * FROM ".$table_name." WHERE id = '".$id."'");
		//print_r($query);
		if($query){
			return $query;
		}else{
			return false;
		}
	}
	
	//Update city by id 
	function update_cities_by_id($form_data){
		$results = array();
		foreach( $form_data['id'] as $i => $id){
			$city_name = mysql_real_escape_string( trim($form_data['wprdts-city-name-'.$i]) );
			$city_price = mysql_real_escape_string( trim($form_data['wprdts-city-price-'.$i]) );
			/* $city_state_id = mysql_real_escape_string( trim($form_data['wprdts-city-state-id-'.$i]) ); */
			/* $city_zip_code = mysql_real_escape_string( trim($form_data['wprdts-city-zip-code-'.$i]) ); */
			$city_status = trim($form_data['wprdts-city-status-'.$i]);
			$data =  array(
				"city_name" => $state_name,
				"city_price" => $state_price,
				/* "city_state_id" => $status, */
				/* "city_zip_code" => $city_zip_code, */
				"city_status" => $city_status
			);
			
			$where = array("id", $id);
			//print_r($data);
			
			global $wpdb;
			$table_name = $wpdb->prefix.'wprdts_city';
			//$result = $wpdb->update( $table_name, $data, $where );
			$results[] = $wpdb->query("UPDATE $table_name SET  city_name = '".$city_name."' , city_price = '".$city_price."' , city_status = '".$city_status."' WHERE id =".$id."");
			//echo "fdg"; print_r($result); exit;	
		}
		return $results;
	}
	
	//Edit city by ID's
	function get_edit_city_form_by_id($city_id){ 
		//echo '<pre>'; print_r($state_id); echo '</pre>';?>
		<div class="edit-state-form-container">
		<h2>Edit Fixed Price City</h2>
			<form action="?page=rd_taxi_system_manage_cities&wprdts_action=<?php echo EDIT_CITY; ?>" method="post" enctype='multipart/form-data'>
				<?php foreach ($city_id as $key => $id) { 
						$city = get_city_with_state_by_id($id);
						//$state = get_state_by_id($city->city_state_id);
						//echo '<pre>'; print_r($cities); echo '</pre>'; exit;
						//echo '<pre>'; var_dump($state); echo '</pre>'; exit;
				?>
				<div class="edit-state-form edit-city-form-container"> 
					<fieldset class="field_set">
						<legend><p class="form-title"> &nbsp City ID # <?php echo $city->id; ?> &nbsp </p></legend>
						<!-- <p class="form-element">
							<span class="wprdts-label"><label for="wprdts-city-state-id">Change State</label>  : </span>
							<span>
								<select type="text" name="wprdts-city-state-id-<?php echo $key; ?>" class="wprdts-state-input-text wprdts-city-input-text" >
									<?php $states = get_all_state("state_name ASC"); 
										  foreach($states as $state) { ?>
									<option value="<?php echo $state->id; ?>" <?php if($state->id == $city->city_state_id){ echo 'selected=selected'; } ?> > <?php echo $state->state_name; ?> </option>
										  <?php } ?>
								</select>
							</span>
						</p> -->
						<p class="form-element">
							<span class="wprdts-label"><label for="wprdts-state-name">Change City Name</label>  : </span>
							<span><input type="text" name="wprdts-city-name-<?php echo $key; ?>" id="wprdts-input-edit-fixed-price-city" class="wprdts-state-input-text" value="<?php echo $city->city_name; ?>" onKeyUp="autoCompleteForPickupLocation(this)" required/></span>
						</p>
						<p class="form-element">
							<span class="wprdts-label"><label for="wprdts-state-name">Change Price <?php if($currency = get_option('wprdts-setting-form-currency')) echo '('.$currency.')'; ?></label>  : </span>
							<span>								<span class="wprdts-currency-symbol"></span>								<input type="text" name="wprdts-city-price-<?php echo $key; ?>" class="wprdts-state-input-text" value="<?php echo $city->city_price; ?>"/>							</span>
						</p>
						<!-- <p class="form-element">
							<span class="wprdts-label"><label for="wprdts-state-name">Change Zip Code</label>  : </span>
							<span><input type="text" name="wprdts-city-zip-code-<?php echo $key; ?>" class="wprdts-state-input-text" value="<?php echo $city->city_zip_code; ?>"/></span>
						</p> -->
						<p class="form-element">
							<span class="wprdts-label"><label for="wprdts-state-name">Change Status</label>  : </span>
							<span>
								<select type="text" name="wprdts-city-status-<?php echo $key; ?>" class="wprdts-state-input-text">
									<option value="<?php echo STATUS_PUBLISHED; ?>" <?php if($city->city_status == STATUS_PUBLISHED) { echo 'selected="selected"'; } ?> >Published</option>
									<option value="<?php echo STATUS_UNPUBLISHED; ?>" <?php if($city->city_status == STATUS_UNPUBLISHED) { echo 'selected="selected"'; } ?> >Unpublished</option>
								</select>
							</span>
						</p>
						<p class="form-element">
							<span><input type="hidden" name="id[]" class="wprdts-city-input-text" value="<?php echo $city->id; ?>"/></span>
						</p>
					</fieldset>
				</div>
				<?php } ?>
				<p class="form-element">
					<span><input type="submit" name="wprdts-city-submit" class="wprdts-state-submit button button-primary button-large" value="Update"/></span>
				</p>
			</form>
		</div>
	<?php }
	
	//Delete city by ID
	function delete_city_by_id($cities){
		$results = array();
		global $wpdb;
		$table_name = $wpdb->prefix.'wprdts_city';
		
		foreach($cities as $id){
			$results[] = $wpdb->delete( $table_name, array( 'id' => $id ) );
		}
		return $results;
	}
	
	//Copy city by ID
	function copy_city_by_id($cities){
		$results = array();
				
		foreach($cities as $id){
			$city = get_city_with_state_by_id($id);
			//print_r($city); exit;
			global $wpdb;
			$table_name = $wpdb->prefix.'wprdts_city';
			$data =  array(
				"city_name" => $city->city_name,
				/* "city_state_id" => $city->city_state_id, */
				"city_price" => $city->city_price,
				/* "city_zip_code" => $city->city_zip_code, */
				"city_status" => $city->city_status
			);
			//print_r($data); exit;
			$results[] = $wpdb->insert($table_name, $data);
		}
		return $results;
	}
	
	//Publish city by id 
	function publish_city_by_id($cities){
		$results = array();
				
		foreach($cities as $id){
			//print_r($cities); exit;
			global $wpdb;
			$table_name = $wpdb->prefix.'wprdts_city';
			//$result = $wpdb->update( $table_name, $data, $where );
			$results[] = $wpdb->query("UPDATE $table_name SET city_status = '".STATUS_PUBLISHED."' WHERE id =".$id."");
			// print_r($result); exit;	
		}
		return $results;
	}
	
	//Unpublish city by id
	function unpublish_city_by_id($cities){
		$results = array();
				
		foreach($cities as $id){
			//print_r($cities); exit;
			global $wpdb;
			$table_name = $wpdb->prefix.'wprdts_city';
			//$result = $wpdb->update( $table_name, $data, $where );
			$results[] = $wpdb->query("UPDATE $table_name SET city_status = '".STATUS_UNPUBLISHED."' WHERE id =".$id."");
			//echo "fdg"; print_r($result); exit;	
		}
		return $results;
	}			//Check fixed price city	function get_fixed_price_city($addressTo, $addressFrom){		global $wpdb;		$table_name = $wpdb->prefix.'wprdts_city';		$query = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE (city_name='".$addressTo."' OR city_name='".$addressFrom."' AND city_status=1) LIMIT 1");				if($query){			return $query;		}else{			return false;		}	}




?>