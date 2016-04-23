
	jQuery(document).ready(function($){
		//Declaration 		
		var cityList = [];
		
		//jQuery UI
		$( ".wprdts-widget-form-trip-date" ).datepicker();
		$( "#wprdts-widget-form-return-trip-date" ).datepicker();
		
		//Justify trip type
		$('#wprdts-widget-form-trip-type option').click(function(){
			var tripType = $('.wprdts-widget-form-trip-type').val().trim();
			if(tripType == 1){
				$('.wprdts-change-label-state label').html('Your Pickup State : ');
				$('.wprdts-change-label-city label').html('Your Pickup City/ZIP : ');
			} else if(tripType == 2){
				$('.wprdts-change-label-state label').html('Your Destination State :  ');
				$('.wprdts-change-label-city label').html('Your Destination City/Zip : ');
			}
		});
			 //Calculate price when changing number of passenger			$("#wprdts-widget-form-passenger option").click(function(){				var currencySymbol = $("#wprdts-widget-form-currency").val();				var price = getPrice();				$('.wprdts-price').html(currencySymbol+" "+ price);			});						//Calculate price when changing number of luggage			 $("#wprdts-widget-form-luggage option").click(function(){				var currencySymbol = $("#wprdts-widget-form-currency").val();				var price = getPrice();				$('.wprdts-price').html(currencySymbol+" "+ price);			}); 

		
		//Validate form top section when continue button is clicked
		$('form#wprdts-widget-form .wprdts-widget-form-btn-continue').click(function(){
			//Hide form part two
			$('.wprdts-widget-form-container .wprdts-form-part-two').fadeOut(200);
			
			var tripType = $('.wprdts-widget-form-trip-type').val().trim();
			var state = $('.wprdts-widget-form-state').val().trim();
			var city = $('.wprdts-widget-form-city').val().trim();
			var passenger = $('.wprdts-widget-form-passenger').val().trim();
			var luggage = $('.wprdts-widget-form-luggage').val().trim();
			
			if( tripType == ''  || state == '' || city == '' || passenger == '' || luggage == ''){
				alert("Please full-fill required field");
				return false;
			} else{
				$('.wprdts-widget-form-container .wprdts-form-part-two').fadeIn(200);
				return true;
			}

		});
		
		//Calculate price when changing number of luggage
			$("input[name='wprdts-widget-form-round-trip']").change(function(){
				var currencySymbol = $("#wprdts-widget-form-currency").val();
				var roundTrip = parseInt($("input[name='wprdts-widget-form-round-trip']:checked").val(), 10);
				
				var price = getPrice();
				
				if(isNaN(price)){
					currencySymbol = '';
				}
				
				$('.wprdts-price').html(currencySymbol+" "+price);
				
				if(roundTrip){
					$('#wprdts-form-return-info').css('display','block');
				}else{
					$('#wprdts-form-return-info').css('display','none');
				}
			});
		
		//Calculate price when on Blur dropoff location
		$('#wprdts-widget-form-dropoff-location').blur(function (){
			var currencySymbol = $("#wprdts-widget-form-currency").val();
			var price = getPrice();
			console.log("First price : "+ price);
			
			if(isNaN(price)){
				currencySymbol = '';
			}
				
			$('.wprdts-price').html(currencySymbol+" "+ price);
			//alert(response+" km");
			
			//Calculate price when changing number of passenger
			$("[name='wprdts-widget-form-passenger']").change(function(){
				var currencySymbol = $("#wprdts-widget-form-currency").val();
				var price = getPrice();
				$('.wprdts-price').html(currencySymbol+" "+price);
			});
			
			//Calculate price when changing number of luggage
			 $("[name='wprdts-widget-form-luggage']").change(function(){
				var currencySymbol = $("#wprdts-widget-form-currency").val();
				var price = getPrice();
				$('.wprdts-price').html(currencySymbol+" "+price);
			});
			
			//Calculate price when changing number of luggage
			$("input[name='wprdts-widget-form-round-trip']").change(function(){
				var currencySymbol = $("#wprdts-widget-form-currency").val();
				var roundTrip = parseInt($("input[name='wprdts-widget-form-round-trip']:checked").val(), 10);
				
				var price = getPrice();
				$('.wprdts-price').html(currencySymbol+" "+price);
				
				if(roundTrip){
					$('#wprdts-form-return-info').css('display','block');
				}else{
					$('#wprdts-form-return-info').css('display','none');
				}
			});
			
		}); // End of Blur method
		
		//When form is submitted
		$('form#wprdts-widget-form').submit(function(){
			var tripType = $("[name='wprdts-widget-form-trip-type']").val();
			var destinationState = $("[name='wprdts-widget-form-state']").val();
			var destinationCity = $("[name='wprdts-widget-form-city']").val();
			var numberOfPassenger = $("[name='wprdts-widget-form-passenger']").val();
			var numberOfluggage = $("[name='wprdts-widget-form-luggage']").val();
			var roundTrip = $("input[name='wprdts-widget-form-round-trip']:checked").val();
			var vehicleType = $("[name='wprdts-widget-form-vehicle-type']").val();
			var tripDate = $("[name='wprdts-widget-form-trip-date']").val();
			var returnTripDate = $("[name='wprdts-widget-form-return-trip-date']").val();
			var timeHour = $("[name='wprdts-widget-form-trip-time-hour']").val();
			var returnTimeHour = $("[name='wprdts-widget-form-return-trip-time-hour']").val();
			var timeMinute = $("[name='wprdts-widget-form-trip-time-minute']").val();
			var returnTimeMinute = $("[name='wprdts-widget-form-return-trip-time-minute']").val();
			var timeAmPm = $("[name='wprdts-widget-form-trip-time-am-pm']").val();
			var returnTimeAmPm = $("[name='wprdts-widget-form-return-trip-time-am-pm']").val();
			var pickupLocation = $("[name='wprdts-widget-form-pickup-location']").val();
			var returnPickupLocation = $("[name='wprdts-widget-form-return-pickup-location']").val();
			var dropoffLocation = $("[name='wprdts-widget-form-dropoff-location']").val();
			var returnDropoffLocation = $("[name='wprdts-widget-form-return-dropoff-location']").val();
			var arilineDetails = $("[name='wprdts-widget-form-airline-details']").val();
			var returnArilineDetails = $("[name='wprdts-widget-form-return-airline-details']").val();
			var flightNumber = $("[name='wprdts-widget-form-flight-number']").val();
			var returnFlightNumber = $("[name='wprdts-widget-form-return-flight-number']").val();
			var yourName = $("[name='wprdts-widget-form-your-name']").val();
			var yourEmail = $("[name='wprdts-widget-form-your-email']").val();
			var yourPhone = $("[name='wprdts-widget-form-your-phone']").val();
			var price;
			
			//console.log(roundTrip);
			
			//Get price 
			price = getPrice();
			$('.wprdts-price').html(price);
			alert("Are you sure to continue with price of "+price+" ?");
			
			var data = {
					action: 'wprdts_ajax_response_booking_request',
					requestFor: 'wprdts_booking_request',
					tripType: tripType,
					destinationState: destinationState,
					destinationCity: destinationCity,
					numberOfPassenger: numberOfPassenger,
					numberOfluggage: numberOfluggage,
					roundTrip: roundTrip,
					vehicleType: vehicleType,
					tripDate: tripDate,
					returnTripDate: returnTripDate,
					timeHour: timeHour,
					returnTimeHour: returnTimeHour,
					timeMinute: timeMinute,
					returnTimeMinute: returnTimeMinute,
					timeAmPm: timeAmPm,
					returnTimeAmPm: returnTimeAmPm,
					pickupLocation: pickupLocation,
					returnPickupLocation: returnPickupLocation,
					dropoffLocation: dropoffLocation,
					returnDropoffLocation: returnDropoffLocation,
					arilineDetails: arilineDetails,
					returnArilineDetails: returnArilineDetails,
					flightNumber: flightNumber,
					returnFlightNumber: returnFlightNumber,
					yourName: yourName,
					yourEmail: yourEmail,
					yourPhone: yourPhone,
					price: price
				};

				//console.log("Main Location : "+mainLocation);
				$.ajax({
						url: wprdts_ajax_script.wprdts_ajaxurl,
						type: 'POST',
						data: data,
						async: false,
						success:function(result){
							//console.log(result);
							//var result;
							try{
								if(result){
									console.log("Result : "+result);
								}
							}catch(e){
								console.log(e); //error in the above string(in this case,yes)!
								return false;
							}
							
						}
				}); //End of ajax request
			
			return false;
			//return false;
			
		});
		
		//When click on trip type
		$('.wprdts-widget-form-element .wprdts-widget-form-trip-type option').click(function(){
			if($(this).val() != 0){
				$('.wprdts-widget-field .wprdts-widget-form-state').removeAttr("disabled");
			}else{
				$('.wprdts-widget-field .wprdts-widget-form-state').attr("disabled","disabled");
				$('.wprdts-widget-field .wprdts-widget-form-city').attr("disabled","disabled");
			}
		});
		
		//When click on select state
		$('.wprdts-widget-form-element .wprdts-widget-form-state option').click(function(){
			if($(this).val() != 0){
				$('.wprdts-widget-field .wprdts-widget-form-city').removeAttr("disabled");
			}else{
				$('.wprdts-widget-field .wprdts-widget-form-city').attr("disabled","disabled");
			}
		});
		
		
		//When any key press on location field
		$('.wprdts-widget-form-element .wprdts-widget-form-city').keyup(function(){ 
			//Dsiable these elements when pressing key on input text. enable after selecting a city from dropdown
			$('.wprdts-widget-field .wprdts-widget-form-passenger').attr("disabled","disabled");
			$('.wprdts-widget-field .wprdts-widget-form-luggage').attr("disabled","disabled");
			$('.wprdts-widget-field .wprdts-widget-form-round-trip').attr("disabled","disabled");
			if($(this).val().trim().length > 0 ){
				$('.wprdts-input-dropdown-container').fadeOut(200);
				$('.wprdts-input-dropdown-container ul').empty();
				//alert("key pressed");
				var location = $(this).val().trim();
				var stateId = parseInt($('.wprdts-widget-form-state').val().trim(), 10);
				var data = {
					action: 'wprdts_ajax_response',
					keyword: location,
					stateId: stateId,
				};

				$.ajax({
						url: wprdts_ajax_script.wprdts_ajaxurl,
						type: 'POST',
						data: data,
						beforeSend: function(){				
							//$(".auto-loader").fadeIn('200');
						},
						success:function(result){
							
							//console.log(result);
							//var result;
							try{
								//var response = JSON.parse(JSON.stringify(result));
								var response = JSON.parse(result);
								//console.log(response);
								if(response){
									$('.wprdts-input-dropdown-container').fadeIn(200);
									$('.wprdts-input-dropdown-container ul').empty();
									 $.each(response, function(key, value){
										//$('.wprdts-input-dropdown-container ul').empty();
										$('.wprdts-input-dropdown-container ul').append('<li class="wprdts-city-list">'+value.city_name+'</li>');
										//cityList.push(value.city_name);
										//console.log(value.city_name);
									}); 
								} else{
									$('.wprdts-input-dropdown-container ul').empty();
								}
							}catch(e){
								console.log(e); //error in the above string(in this case,yes)!
							}
							
						}
				}); //End of ajax request	
		
			} else{
				$('.wprdts-input-dropdown-container ul').empty();
			}
		}); //End of onKeyUp
		
		//Show dropdown container when click in input text box
				$('.wprdts-widget-form-city').blur(function(){
					$('.wprdts-input-dropdown-container').fadeOut(200);
					
					//When click on city list from dropdown
					$('.wprdts-city-list').click(function(){	
						var indexOfCityList = $('.wprdts-city-list').index(this);
						$('.wprdts-widget-form-city').val($(this).text());
						var cityName = $('.wprdts-widget-form-city').val().trim();
						
						if(cityName != null && cityName != ''){
							$('.wprdts-widget-field .wprdts-widget-form-passenger').removeAttr("disabled");
							$('.wprdts-widget-field .wprdts-widget-form-luggage').removeAttr("disabled");
							$('.wprdts-widget-field .wprdts-widget-form-round-trip').removeAttr("disabled");
						}else{
							$('.wprdts-widget-field .wprdts-widget-form-passenger').attr("disabled","disabled");
							$('.wprdts-widget-field .wprdts-widget-form-luggage').attr("disabled","disabled");
							$('.wprdts-widget-field .wprdts-widget-form-round-trip').attr("disabled","disabled");
						}
						//cityList.length = 0;
						console.log(indexOfCityList);	
					});
				}).focus(function(){
					$('.wprdts-input-dropdown-container').fadeIn(200);
					//cityList.length = 0;
				});	
		
	}); //End of document
	
	//get distance 
	function getDistanceinKm(addressTo, addressFrom){
			var mainLocation = jQuery('#wprdts-widget-form-main-location').val().trim();
			var response = 0;
			var data = {
					action: 'wprdts_ajax_response_get_distance',
					addressTo: addressTo,
					addressFrom: addressFrom,
					mainLocation: mainLocation
				};

				console.log("Main Location : "+mainLocation);
				jQuery.ajax({
						url: wprdts_ajax_script.wprdts_ajaxurl,
						type: 'POST',
						data: data,
						async: false,
						success:function(result){
							console.log('result : '+result);
							//var result;
							try{
								//response = parseFloat(JSON.parse(JSON.stringify(result)));
								response = parseFloat(JSON.parse(result));
								//response = parseFloat(result.trim());
								response = response*1.60934;								//response =  result * 1.6;
								//var response = JSON.parse(result);
								console.log("response : "+response);
							}catch(e){
								console.log(e); //error in the above string(in this case,yes)!
							}
							
						}
				}); //End of ajax request
				
				if(response){
					//jQuery('.wprdts-price').html(response);
					//alert(response+" km");
					return response;
				} else{
					//alert(response+" km");
					return false;
				}
	}
	
	//Get price 
	function getPrice(){
			var dropOffLocation = jQuery('#wprdts-widget-form-dropoff-location').val();
			var destinationState = jQuery("[name='wprdts-widget-form-state']").val();
			var destinationCity = jQuery("[name='wprdts-widget-form-city']").val();
			var pickupLocation = jQuery("[name='wprdts-widget-form-pickup-location']").val();
			var passenger = parseInt( jQuery('.wprdts-widget-form-passenger').val().trim(), 10 );
			var luggage = parseInt( jQuery('.wprdts-widget-form-luggage').val().trim(), 10 );
			var roundTrip = parseInt(jQuery("input[name='wprdts-widget-form-round-trip']:checked").val(), 10);
			var pricePerKM = parseFloat(jQuery("#wprdts-widget-form-price-per-km").val(), 10);
			var additionalPriceOne = parseFloat(jQuery("#wprdts-widget-form-additional-price-one").val());
			var additionalPriceTwo = parseFloat(jQuery("#wprdts-widget-form-additional-price-two").val());
			var currencySymbol = jQuery("#wprdts-widget-form-currency").val();
			var distanceInKm, additionalPrice, price, callForPrice, result=[];
			
			console.log("Price per km : "+pricePerKM);
			console.log("additionalPriceOne : "+additionalPriceOne);
			console.log("additionalPriceTwo : "+additionalPriceTwo);
			
			//Map
			//var addressTo = destinationState+' '+destinationCity;
			var addressTo = dropOffLocation;
			var addressFrom = pickupLocation;
			var addressToLat, addressToLng, addressToLoc, addressFromLat, addressFromLng, addressFromLoc, distance, duration, distanceInKm;

			/* //Getting LatLng for destination address
			jQuery.ajax({ url: "http://maps.googleapis.com/maps/api/geocode/json?address="+addressTo+"&sensor=false",
				type: "POST",
				success: function(res){
					//console.log(res.results[0].geometry.location.lat);
					//console.log(res.results[0].geometry.location.lng);
					addressToLat = res.results[0].geometry.location.lat;
					addressToLng = res.results[0].geometry.location.lng;
					addressToLoc = new google.maps.LatLng(addressToLat, addressToLng);
					console.log("Address To : "+addressToLat+" "+addressToLng);
					alert(addressToLoc);
				}
			});
			
			//Getting LatLng for pickup address
			jQuery.ajax({ url: "http://maps.googleapis.com/maps/api/geocode/json?address="+addressFrom+"&sensor=false",
				type: "POST",
				success: function(res){
					//console.log(res.results[0].geometry.location.lat);
					//console.log(res.results[0].geometry.location.lng);
					addressFromLat = res.results[0].geometry.location.lat;
					addressFromLng = res.results[0].geometry.location.lng;
					addressFromLoc = new google.maps.LatLng(addressFromLat, addressFromLng);
					console.log("Address From : "+addressFromLat+" "+addressFromLng);
					alert(addressFromLoc);
				}
			}); */ 
			
			//Calculating price
			distanceInKm = getDistanceinKm(addressTo, addressFrom);
			
			console.log("distanceInKm : "+distanceInKm);
			if(distanceInKm){
				price = pricePerKM*distanceInKm;
				result['price'] = price;
				//console.log("price : "+price);
			} else{
				price = 0;
			}
			
			console.log("Price : "+price);
			console.log("Distance after ajax : "+distanceInKm);
			
			//Get price rate
			if ((passenger >= 1 && passenger <= 4) && (luggage >= 1 && luggage <= 3)){
				additionalPrice = 0;				jQuery('#wprdts-widget-form-vehicle-type').val(1);
			} else if (((passenger >= 5 && passenger <= 6) && (luggage >= 4 && luggage <= 5)) || ((passenger >= 1 && passenger <= 4) && (luggage >= 4 && luggage <= 5)) || ((passenger >= 5 && passenger <= 6) && (luggage >= 1 && luggage <= 3))){
				additionalPrice = additionalPriceOne;				jQuery('#wprdts-widget-form-vehicle-type').val(2);
			} else if(((passenger >= 5 && passenger <= 6) && (luggage == 6)) || ((passenger >= 1 && passenger <= 4) && (luggage == 6)) || ((passenger >= 5 && passenger <= 6) && (luggage == 6))){
				additionalPrice = additionalPriceTwo;				jQuery('#wprdts-widget-form-vehicle-type').val(3);
			} else if (((passenger >= 7 && passenger <= 9) && (luggage == 6)) || ((passenger >= 7 && passenger <= 9) && (luggage >= 1 && luggage <= 3)) || ((passenger >= 7 && passenger <= 9) && (luggage >= 4 && luggage <= 5))){
				callForPrice = true;				jQuery('#wprdts-widget-form-vehicle-type').val(4);
			} else if (((passenger >= 7 && passenger <= 9) && (luggage >= 7 && luggage <= 12)) || ((passenger >= 5 && passenger <= 6) && (luggage >= 7 && luggage <= 12)) || ((passenger >= 7 && passenger <= 9) && (luggage >= 7 && luggage <= 12)) || ((passenger >= 10 && passenger <= 13) && (luggage >= 1 && luggage <= 3)) || ((passenger >= 10 && passenger <= 13) && (luggage >= 4 && luggage <= 5)) || ((passenger >= 10 && passenger <= 13) && (luggage == 6)) || ((passenger >= 1 && passenger <= 4) && (luggage >= 7 && luggage <= 12))){
				callForPrice = true;				jQuery('#wprdts-widget-form-vehicle-type').val(5);
			} else {
				callForPrice = true;				jQuery('#wprdts-widget-form-vehicle-type').val('');
				//jQuery('#vehicle_type').val(0);
			}
			
			//Setting additional price
			if(additionalPrice){
				price = price + additionalPrice;
			} else{
				price = price;
				//additionalPrice = '--';
			}
			
			console.log("additionalPrice : "+additionalPrice);
			
			//Check if round trip or not
			if(roundTrip){
				price = price*2;
			} 
			
			//Set call for price message
			if(callForPrice){
				price = 'Call for price';
			}else{
				price = price;
			}
			
			result['currencySymbol'] = currencySymbol;
			result['additionalPrice'] = additionalPrice;
			result['totalprice'] = price;
			console.log("Price returned : "+price);
			
			//return result;
			
			 if(jQuery.isNumeric(price)){				
				return parseFloat(price).toFixed(2);			
			} else{				
				return price;				
			}  
			
			//return parseFloat( price).toFixed(2);			
			//return  price;
	}

	/////////////////******************Manage State**************************//////////////
	
	//Get form action for state
	function getFormAction( element ){
		if(jQuery("input[name='states[]']:checked").length == 0){
			//console.log(checkdValues.length);
			alert("Make a selection from the list first");
			//window.location("?page=rd_taxi_system_manage_states");
			jQuery(element).attr("href", "");
		}else{
			//alert("Have value");
			var id = jQuery(element).attr("id");
			if (id == 'btn-edit-state'){ 	//Edit state button
				jQuery("form#wprdts-state-form").attr("action","?page=rd_taxi_system_manage_states&wprdts_action=action_edit").submit();
				//jQuery("form#wprdts-state-form").submit();
			} else if (id == 'btn-delete-state'){	//Delete state button
				if(confirm("Are you sure to delete permanently ?")){
					jQuery("form#wprdts-state-form").attr("action","?page=rd_taxi_system_manage_states&wprdts_action=action_delete").submit();
				}else{
					//alert("Not deleted");
				}
				//jQuery("form#wprdts-state-form").submit();
			} else if (id == 'btn-copy-state'){		//Copy state button
				//jQuery("form#wprdts-state-form").attr("action","?page=rd_taxi_system_manage_states&wprdts_action=action_copy").submit();
				if(confirm("Are you sure to copy ?")){
					//alert("copied");
					jQuery("form#wprdts-state-form").attr("action","?page=rd_taxi_system_manage_states&wprdts_action=action_copy").submit();
				}else{
					//alert("Not copied");
				}
				//jQuery("form#wprdts-state-form").submit();
			} else if (id == 'btn-publish-state'){		//Publish state button
				if(confirm("Are you sure to publish ?")){
					//alert("copied");
					jQuery("form#wprdts-state-form").attr("action","?page=rd_taxi_system_manage_states&wprdts_action=action_publish").submit();
				}else{
					//alert("Not copied");
				}
				//jQuery("form#wprdts-state-form").submit();
			} else if (id == 'btn-unpublish-state'){		//Unpublish state button
				if(confirm("Are you sure to unpublished ?")){
					//alert("copied");
					jQuery("form#wprdts-state-form").attr("action","?page=rd_taxi_system_manage_states&wprdts_action=action_unpublish").submit();
				}else{
					//alert("Not copied");
				}
				//jQuery("form#wprdts-state-form").submit();
			}
			
			
		}
	}
	
	//Validate search state form
	function validatedSearchForm(element){
		var id = jQuery(element).attr("id");
		if (id == 'btn-search-state'){
			if (jQuery.trim(jQuery("#wprdts-state-search-box").val()) == null || jQuery.trim(jQuery("#wprdts-state-search-box").val()) == ''){
				alert("Enter search item correctly");
			} else{
				jQuery("form#wprdts-state-search-form").attr("action","?page=rd_taxi_system_manage_states&wprdts_action_search=action_search").submit();	
			}
		} else if(id == 'btn-search-city'){
			if (jQuery.trim(jQuery("#wprdts-city-search-box").val()) == null || jQuery.trim(jQuery("#wprdts-city-search-box").val()) == ''){
				alert("Enter search item correctly");
			} else{
				jQuery("form#wprdts-city-search-form").attr("action","?page=rd_taxi_system_manage_cities&wprdts_action_search=action_search").submit();	
			}
		}
	}
	
	
	
	/////////////////******************Manage City**************************//////////////
	function getFormActionForCity(element){
		if(jQuery("input[name='cities[]']:checked").length == 0){
			//console.log(checkdValues.length);
			alert("Make a selection from the list first");
			//window.location("?page=rd_taxi_system_manage_cities");
			jQuery(element).attr("href", "");
		}else{
			//alert("Have value");
			var id = jQuery(element).attr("id");
			if (id == 'btn-edit-city'){ 	//Edit state button
				jQuery("form#wprdts-city-form").attr("action","?page=rd_taxi_system_manage_cities&wprdts_action=action_edit").submit();
				//jQuery("form#wprdts-city-form").submit();
			} else if (id == 'btn-delete-city'){	//Delete state button
				if(confirm("Are you sure to delete permanently ?")){
					jQuery("form#wprdts-city-form").attr("action","?page=rd_taxi_system_manage_cities&wprdts_action=action_delete").submit();
				}else{
					//alert("Not deleted");
				}
				//jQuery("form#wprdts-city-form").submit();
			} else if (id == 'btn-copy-city'){		//Copy state button
				//jQuery("form#wprdts-state-form").attr("action","?page=rd_taxi_system_manage_cities&wprdts_action=action_copy").submit();
				if(confirm("Are you sure to copy ?")){
					//alert("copied");
					jQuery("form#wprdts-city-form").attr("action","?page=rd_taxi_system_manage_cities&wprdts_action=action_copy").submit();
				}else{
					//alert("Not copied");
				}
				//jQuery("form#wprdts-city-form").submit();
			} else if (id == 'btn-publish-city'){		//Publish state button
				if(confirm("Are you sure to publish ?")){
					//alert("copied");
					jQuery("form#wprdts-city-form").attr("action","?page=rd_taxi_system_manage_cities&wprdts_action=action_publish").submit();
				}else{
					//alert("Not copied");
				}
				//jQuery("form#wprdts-state-form").submit();
			} else if (id == 'btn-unpublish-city'){		//Unpublish state button
				if(confirm("Are you sure to unpublished ?")){
					//alert("copied");
					jQuery("form#wprdts-city-form").attr("action","?page=rd_taxi_system_manage_cities&wprdts_action=action_unpublish").submit();
				}else{
					//alert("Not copied");
				}
				//jQuery("form#wprdts-state-form").submit();
			}
			
			
		}
	}
	
	
	