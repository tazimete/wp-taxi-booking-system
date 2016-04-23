<?php 

	//Including other files 
	require_once(ABSPATH .'/wp-content/plugins/wp_rd_taxi_system/function/functions-city.php');
	
	//Define constant and variable
	//define('ACTION_ADD_STATE','');
	
	
	////////************ Manage State ***********////////
	
	//Get add state form
	function get_add_state_form(){ ?>
		<div class="add-state-form-container">
		<fieldset class="field_set">
						<legend><h2> &nbsp  Add State &nbsp </h2></legend>
			<form action="?page=rd_taxi_system_manage_states&wprdts_action=<?php echo ADD_STATE; ?>" method="post" enctype='multipart/form-data'>
				<p class="form-element">
					<span class="wprdts-label"><label for="wprdts-state-name">State Name</label>  : </span>
					<span><input type="text" name="wprdts-state-name" class="wprdts-state-input-text" required/></span>
				</p>
				<p class="form-element">
					<span class="wprdts-label"><label for="wprdts-state-name">Price</label>  : </span>
					<span><input type="text" name="wprdts-state-price" class="wprdts-state-input-text"/></span>
				</p>
				<p class="form-element">
					<span class="wprdts-label"><label for="wprdts-state-name">Status</label>  : </span>
					<span>
						<select name="wprdts-state-status" class="wprdts-state-input-text">
							<option value="<?php echo STATUS_PUBLISHED; ?>" >Published</option>
							<option value="<?php echo STATUS_UNPUBLISHED; ?>" selected="selected">Unpublished</option>
						</select>
					</span>
				</p>
				<p class="form-element">
					<span><input type="submit" name="wprdts-state-submit" class="wprdts-state-submit button button-primary button-large" value="Add"/></span>
				</p>
			</form>
		</fieldset>
		</div>
	<?php }
	
	//Add state
	function add_state($form_data){
		$state_name = trim($form_data['wprdts-state-name']);
		$state_price = (float) trim($form_data['wprdts-state-price']);
		$status = trim($form_data['wprdts-state-status']);
		$results = array();
		$data =  array(
			"state_name" => $state_name,
			"state_price" => $state_price,
			"status" => $status
		);
		//print_r($data);
		global $wpdb;
		$table_name = $wpdb->prefix.'wprdts_state';
		$results[]= $wpdb->insert($table_name, $data);
		return $results;
	}
	
	//Get all state list
	function get_all_state($data_order){
		global $wpdb;
		$table_name = $wpdb->prefix.'wprdts_state';
		$query = $wpdb->get_results("SELECT * FROM ".$table_name." ORDER BY ".$data_order."");
		//print_r($query);
		if($query){
			return $query;
		}else{
			return false;
		}
	}
	
	//Get single state by ID
	function get_state_by_id($id){
		global $wpdb;
		$table_name = $wpdb->prefix.'wprdts_state';
		$query = $wpdb->get_row("SELECT * FROM ".$table_name." WHERE id = '".$id."'");
		//print_r($query);
		if($query){
			return $query;
		}else{
			return false;
		}
	}
	
	//Update state ny ID
	function update_states_by_id($form_data){
		$results = array();
		foreach( $form_data['id'] as $i => $id){
			$state_name = mysql_real_escape_string( trim($form_data['wprdts-state-name-'.$i]) );
			$state_price = mysql_real_escape_string( trim($form_data['wprdts-state-price-'.$i]) );
			$status = trim($form_data['wprdts-state-status-'.$i]);
			$data =  array(
				"state_name" => $state_name,
				"state_price" => $state_price,
				"status" => $status
			);
			
			$where = array("id", $id);
			//print_r($data);
			
			global $wpdb;
			$table_name = $wpdb->prefix.'wprdts_state';
			//$result = $wpdb->update( $table_name, $data, $where );
			$results[] = $wpdb->query("UPDATE $table_name SET  state_name = '".$state_name."' , state_price = '".$state_price."' , status = '".$status."' WHERE id =".$id."");
			//echo "fdg"; print_r($result); exit;	
		}
		return $results;
	}
	
	//Delete State by ID
	function delete_state_by_id( $states ){
		$results = array();
		global $wpdb;
		$table_name = $wpdb->prefix.'wprdts_state';
		
		foreach($states as $id){
			$results[] = $wpdb->delete( $table_name, array( 'id' => $id ) );
		}
		return $results;
	}
	
	//Copy State by ID
	function copy_state_by_id( $states ){
		$results = array();
				
		foreach($states as $id){
			$state = get_state_by_id($id);
			//print_r($state); exit;
			global $wpdb;
			$table_name = $wpdb->prefix.'wprdts_state';
			$data =  array(
				"state_name" => $state->state_name,
				"state_price" => $state->state_price,
				"status" => $state->status
			);
			//print_r($data); exit;
			$results[] = $wpdb->insert($table_name, $data);
		}
		return $results;
	}
	
	
	//Publish State by ID
	function publish_state_by_id( $states ){
		$results = array();
				
		foreach($states as $id){
			//$state = get_state_by_id($id);
			//print_r($state); exit;
			global $wpdb;
			$table_name = $wpdb->prefix.'wprdts_state';
			//$result = $wpdb->update( $table_name, $data, $where );
			$results[] = $wpdb->query("UPDATE $table_name SET status = '".STATUS_PUBLISHED."' WHERE id =".$id."");
			//echo "fdg"; print_r($result); exit;	
		}
		return $results;
	}
	
	
	//Unpublish State by ID
	function unpublish_state_by_id( $states ){
		$results = array();
				
		foreach($states as $id){
			//$state = get_state_by_id($id);
			//print_r($state); exit;
			global $wpdb;
			$table_name = $wpdb->prefix.'wprdts_state';
			//$result = $wpdb->update( $table_name, $data, $where );
			$results[] = $wpdb->query("UPDATE $table_name SET status = '".STATUS_UNPUBLISHED."' WHERE id =".$id."");
			//echo "fdg"; print_r($result); exit;	
		}
		return $results;
	}
	
	//Get state by name - Search function 
	function get_state_by_names($item, $data_order){
		$status = $item;
		global $wpdb;
		$table_name = $wpdb->prefix.'wprdts_state';
		if (substr($item, 0, 1) == 'p') { 
			$status = 1;
		} else if(substr($item, 0, 1) == 'u'){
			$status = 0;
		}
		$query = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE (state_name LIKE '".$item."%' OR state_price LIKE '".$item."%' OR status LIKE '".$status."%' OR id LIKE '".$item."%') ORDER BY ".$data_order."");
		//print_r($query); exit;
		if($query){
			return $query;
		}else{
			return false;
		}
	}
	
	//Count True False
	function count_true_false($data_array){
		$count_true =0;
		$count_false =0;
		
		foreach($data_array as $data){
			if($data == true){
				$count_true = $count_true + 1;
			}
			
			if($data == false){
				$count_false = $count_false + 1;
			}
		}
		
		return $returned_data = array("count_true" => $count_true, "count_false" => $count_false);
	}
	
	//Edit State by ID
	function edit_state_by_id($state_id){ 
			//echo '<pre>'; print_r($state_id); echo '</pre>';?>
		<div class="edit-state-form-container">
		<h2>Edit State</h2>
			<form action="?page=rd_taxi_system_manage_states&wprdts_action=<?php echo EDIT_STATE; ?>" method="post" enctype='multipart/form-data'>
				<?php foreach ($state_id as $key => $id) { 
					$state = get_state_by_id($id);
					//echo '<pre>'; print_r($state); echo '</pre>'; exit;
					//echo '<pre>'; var_dump($state); echo '</pre>'; exit;
				?>
				<div class="edit-state-form"> 
					<fieldset class="field_set">
						<legend><p class="form-title"> &nbsp State ID # <?php echo $state->id; ?> &nbsp </p></legend>
						<p class="form-element">
							<span class="wprdts-label"><label for="wprdts-state-name">Changte State Name</label>  : </span>
							<span><input type="text" name="wprdts-state-name-<?php echo $key; ?>" class="wprdts-state-input-text" value="<?php echo $state->state_name; ?>" required/></span>
						</p>
						<p class="form-element">
							<span class="wprdts-label"><label for="wprdts-state-name">Change Price</label>  : </span>
							<span><input type="text" name="wprdts-state-price-<?php echo $key; ?>" class="wprdts-state-input-text" value="<?php echo $state->state_price; ?>"/></span>
						</p>
						<p class="form-element">
							<span class="wprdts-label"><label for="wprdts-state-name">Change Status</label>  : </span>
							<span>
								<select type="text" name="wprdts-state-status-<?php echo $key; ?>" class="wprdts-state-input-text">
									<option value="<?php echo STATUS_PUBLISHED; ?>" <?php if($state->status == STATUS_PUBLISHED) { echo 'selected="selected"'; } ?> >Published</option>
									<option value="<?php echo STATUS_UNPUBLISHED; ?>" <?php if($state->status == STATUS_UNPUBLISHED) { echo 'selected="selected"'; } ?> >Unpublished</option>
								</select>
							</span>
						</p>
						<p class="form-element">
							<span><input type="hidden" name="id[]" class="wprdts-state-input-text" value="<?php echo $state->id; ?>"/></span>
						</p>
					</fieldset>
				</div>
				<?php } ?>
				<p class="form-element">
					<span><input type="submit" name="wprdts-state-submit" class="wprdts-state-submit button button-primary button-large" value="Update"/></span>
				</p>
			</form>
		</div>
	<?php }
	
	
	

	
	
	
	

?>