
	jQuery(document).ready(function($){ 				//jquery Nice select 		$('#wprdts-widget-form-trip-type').addClass('wide').niceSelect();		$('#wprdts-widget-form-passenger').removeAttr('disabled').addClass('wide').niceSelect();		$('#wprdts-widget-form-luggage').removeAttr('disabled').addClass('wide').niceSelect();		$('.wprdts-widget-form-round-trip').removeAttr('disabled');				$('#wprdts-widget-form-vehicle-type').addClass('wide').niceSelect();		$('#wprdts-widget-form-seat-infant').addClass('wide').niceSelect();		$('#wprdts-widget-form-seat-booster').addClass('wide').niceSelect();				//jQuery Nice radio 		//$('.wprdts-widget-form-round-trip').radiobutton();		
		//Declaration 		
		var cityList = [], bookingRequestId, isPickupLocationEnable = false, progressBarSelection = false;
		//jQuery UI
		$( "#wprdts-widget-form-trip-date" ).datetimepicker({			timeFormat: 'hh:mm tt',			showHour: true,			showMinute: true		});
		$( "#wprdts-widget-form-return-trip-date" ).datetimepicker({			timeFormat: 'hh:mm tt',			showHour: true,			showMinute: true		});				//.jQuery status bar 		var progressBarStatus = 1;		$('.progress-item').removeClass('step-active');		$('.progress-item:nth-of-type('+progressBarStatus+')').addClass('step-active');				//RC Switcher 		//$('#rcswicther').iphoneStyle();		$(".cb-disable").click(function(){			var parent = $(this).parents('.switch');			$('.cb-enable',parent).removeClass('selected');			$(this).addClass('selected');			$('.checkbox',parent).attr('checked', true);						$("input[name='wprdts-widget-form-round-trip']:first-child").attr('checked','checked');			$("input[name='wprdts-widget-form-round-trip']:last-child").removeAttr('checked');			console.log('Round Trip On : '+ $("input[name='wprdts-widget-form-round-trip']:first-child").val());			$("input[name='wprdts-widget-form-round-trip'], .wprdts-widget-form-trip-type").trigger('change');					});				$(".cb-enable").click(function(){			var parent = $(this).parents('.switch');			$('.cb-disable',parent).removeClass('selected');			$(this).addClass('selected');			$('.checkbox',parent).attr('checked', false);							$("input[name='wprdts-widget-form-round-trip']:first-child").removeAttr('checked');			$("input[name='wprdts-widget-form-round-trip']:last-child").attr('checked','checked');			console.log('Round Trip On : '+ $("input[name='wprdts-widget-form-round-trip']:last-child").val());			$("input[name='wprdts-widget-form-round-trip'], .wprdts-widget-form-trip-type").trigger('change');		});		
		//Justify trip type
		/* $('#wprdts-widget-form-trip-type option').click(function(){
			var tripType = $('.wprdts-widget-form-trip-type').val().trim();
			if(tripType == 1){
				$('.wprdts-change-label-state label').html('Your Pickup State : ');
				$('.wprdts-change-label-city label').html('Your Pickup City/ZIP : ');
			} else if(tripType == 2){
				$('.wprdts-change-label-state label').html('Your Destination State :  ');
				$('.wprdts-change-label-city label').html('Your Destination City/Zip : ');
			}
		}); */
		
		 //Calculate price when changing number of passenger	
		$("#wprdts-widget-form-passenger option").click(function(){
			var currencySymbol = $("#wprdts-widget-form-currency").val();				var discountType = parseInt( $("#wprdts-widget-hidden-form-discount").val().trim(), 10 );	
			var price = getPrice();				var priceWithDiscount = getPriceWithDiscount(price);			var totalPriceHtml = '<del>'+currencySymbol+' '+price+'</del>'+' '+currencySymbol+' '+priceWithDiscount;			
			if(isNaN(price)){
				currencySymbol = '';				totalPriceHtml = price;
			}
			$('.wprdts-price').html(currencySymbol+" "+ price);			if(discountType == 1 || discountType== 2){				$('#wprdts-discount').html(totalPriceHtml);			}					
		});						
			 
		//Calculate price when changing number of luggage			
		$("#wprdts-widget-form-luggage option").click(function(){	
			var currencySymbol = $("#wprdts-widget-form-currency").val();		
			var price = getPrice();				var discountType = parseInt( $("#wprdts-widget-hidden-form-discount").val().trim(), 10 );				var priceWithDiscount = getPriceWithDiscount(price);			var totalPriceHtml = '<del>'+currencySymbol+' '+price+'</del>'+' '+currencySymbol+' '+priceWithDiscount;
			if(isNaN(price)){
				currencySymbol = '';				totalPriceHtml = price;
			}			
			$('.wprdts-price').html(currencySymbol+" "+ price);				if(discountType == 1 || discountType== 2){				$('#wprdts-discount').html(totalPriceHtml);			}
		}); 	
		//Validate form top section when continue button is clicked
		$('form#wprdts-widget-form .wprdts-widget-form-btn-continue').click(function(){
			//Hide form part two
			$('.wprdts-widget-form-container .wprdts-form-part-two').fadeOut(200);
			var tripType = $('.wprdts-widget-form-trip-type').val().trim();
			//var state = $('.wprdts-widget-form-state').val().trim();
			//var city = $('.wprdts-widget-form-city').val().trim();
			var passenger = $('.wprdts-widget-form-passenger').val().trim();
			var luggage = $('.wprdts-widget-form-luggage').val().trim();			var roundTrip = parseInt($("input[name='wprdts-widget-form-round-trip']:checked").val(), 10);
			
			if( tripType == '' || passenger == '' || luggage == ''){
				alert("Please full-fill required field");
				return false;
			} else{
				$('.wprdts-widget-form-container .wprdts-form-part-two').fadeIn(200);
				//return true;
			}			//Check round trip			if(roundTrip){					$('#wprdts-form-return-info').css('display','block');				}else{					$('#wprdts-form-return-info').css('display','none');				}							//Select location second stage 			if(isPickupLocationEnable){				$('.wprdts-widget-form-pickup-location-container').show();				$('.wprdts-widget-form-dropoff-location-container').hide();			} else{				$('.wprdts-widget-form-dropoff-location-container').show();				$('.wprdts-widget-form-pickup-location-container').hide();			}						//Select location when round trip			if(isPickupLocationEnable && roundTrip){				$('.wprdts-widget-form-return-dropoff-location-container').show();				$('.wprdts-widget-form-return-pickup-location-container').hide();			} else if(!isPickupLocationEnable && roundTrip){				$('.wprdts-widget-form-return-pickup-location-container').show();				$('.wprdts-widget-form-return-dropoff-location-container').hide();			}						var valuePrePickupLocation = $('#wprdts-widget-form-pickup-location-pre').val();			var valuePreDropoffLocation = $('#wprdts-widget-form-dropoff-location-pre').val();						$('#wprdts-widget-form-pickup-location').val(valuePrePickupLocation);			$('#wprdts-widget-form-dropoff-location').val(valuePreDropoffLocation);						console.log(valuePrePickupLocation);			console.log(valuePreDropoffLocation);						//Change progressbar status			//$('.progress-item').click(function(){				//progressBarStatus = $('.progress-item').index(this) + 1;			$('.progress-item').removeClass('step-active');			$('.progress-item:nth-of-type('+2+')').prev().find('span i').removeClass().addClass('fa fa-check');			$('.progress-item:nth-of-type('+2+')').addClass('step-active');						//Statusbar navigation			$('.progress-item').click(function(){				progressBarStatus = $('.progress-item').index(this) + 1;								if(progressBarStatus == 1){					$('#wprdts-widget-form').show();					$('.wprdts-form-part-two').hide();						$('.progress-item').removeClass('step-active');					$('.progress-item:nth-of-type('+progressBarStatus+')').addClass('step-active');					console.log('progressBarStatus : '+progressBarStatus);				} else if(progressBarStatus == 2){					//console.log('progressBarStatus : '+progressBarStatus);					//$('.wprdts-widget-form-btn-continue').trigger('click');					$('#wprdts-widget-form').show();					$('.wprdts-form-part-two').show();						$('.progress-item').removeClass('step-active');					$('.progress-item:nth-of-type('+progressBarStatus+')').addClass('step-active');					console.log('progressBarStatus : '+progressBarStatus);				}				/* else if(progressBarStatus == 3){					$('#wprdts-widget-form-submit').triggerHandler('click');				} */							});			//});			
		});
		
		//Calculate price when changing number of luggage
			$("input[name='wprdts-widget-form-round-trip']").change(function(){
				var currencySymbol = $("#wprdts-widget-form-currency").val();
				var roundTrip = parseInt($("input[name='wprdts-widget-form-round-trip']:checked").val(), 10);
				var price = getPrice();				var discountType = parseInt( $("#wprdts-widget-hidden-form-discount").val().trim(), 10 );				var priceWithDiscount = getPriceWithDiscount(price);				var totalPriceHtml = '<del>'+currencySymbol+' '+price+'</del>'+' '+currencySymbol+' '+priceWithDiscount;								if(isNaN(price)){					currencySymbol = '';					totalPriceHtml = price;				}							$('.wprdts-price').html(currencySymbol+" "+ price);					if(discountType == 1 || discountType== 2){					$('#wprdts-discount').html(totalPriceHtml);				}
				//$('.wprdts-price').html(currencySymbol+" "+price);
				
				if(roundTrip){
					$('#wprdts-form-return-info').css('display','block');
				}else{
					$('#wprdts-form-return-info').css('display','none');
				}
			});
		
		//Calculate price when on Blur dropoff location
		$('#wprdts-widget-form-dropoff-location, #wprdts-widget-form-pickup-location, #wprdts-widget-form-return-dropoff-location, #wprdts-widget-form-return-pickup-location').blur(function (){
			var currencySymbol = $("#wprdts-widget-form-currency").val();
			var price = getPrice();			var discountType = parseInt( $("#wprdts-widget-hidden-form-discount").val().trim(), 10 );			var priceWithDiscount = getPriceWithDiscount(price);			var totalPriceHtml = '<del>'+currencySymbol+' '+price+'</del>'+' '+currencySymbol+' '+priceWithDiscount;			
			console.log("First price : "+ price);
			
			if(isNaN(price)){
				currencySymbol = '';				totalPriceHtml = price;
			}
			$('.wprdts-price').html(currencySymbol+" "+ price);			if(discountType == 1 || discountType== 2){				$('#wprdts-discount').html(totalPriceHtml);			}
			//alert(response+" km");
			
			//Calculate price when changing number of passenger
			$("[name='wprdts-widget-form-passenger']").change(function(){
				var currencySymbol = $("#wprdts-widget-form-currency").val();
				var price = getPrice();				var discountType = parseInt( $("#wprdts-widget-hidden-form-discount").val().trim(), 10 );				var priceWithDiscount = getPriceWithDiscount(price);				var totalPriceHtml = '<del>'+currencySymbol+' '+price+'</del>'+' '+currencySymbol+' '+priceWithDiscount;
				if(isNaN(price)){
					currencySymbol = '';					totalPriceHtml = price;
				}
				
				$('.wprdts-price').html(currencySymbol+" "+price);				if(discountType == 1 || discountType== 2){					$('#wprdts-discount').html(totalPriceHtml);				}
			});
			
			//Calculate price when changing number of luggage
			 $("[name='wprdts-widget-form-luggage']").change(function(){
				var currencySymbol = $("#wprdts-widget-form-currency").val();
				var price = getPrice();				var discountType = parseInt( $("#wprdts-widget-hidden-form-discount").val().trim(), 10 );				var priceWithDiscount = getPriceWithDiscount(price);				var totalPriceHtml = '<del>'+currencySymbol+' '+price+'</del>'+' '+currencySymbol+' '+priceWithDiscount;				
				if(isNaN(price)){
					currencySymbol = '';					totalPriceHtml = price;
				}		
				$('.wprdts-price').html(currencySymbol+" "+price);				if(discountType == 1 || discountType== 2){					$('#wprdts-discount').html(totalPriceHtml);				}
			});
			
			//Calculate price when changing number of luggage
			$("input[name='wprdts-widget-form-round-trip']").change(function(){
				var currencySymbol = $("#wprdts-widget-form-currency").val();
				var roundTrip = parseInt($("input[name='wprdts-widget-form-round-trip']:checked").val(), 10);
				var price = getPrice();				var discountType = parseInt( $("#wprdts-widget-hidden-form-discount").val().trim(), 10 );				var priceWithDiscount = getPriceWithDiscount(price);				var totalPriceHtml = '<del>'+currencySymbol+' '+price+'</del>'+' '+currencySymbol+' '+priceWithDiscount;
				
				if(isNaN(price)){
					currencySymbol = '';					totalPriceHtml = price;
				}		
				$('.wprdts-price').html(currencySymbol+" "+price);				if(discountType == 1 || discountType== 2){					$('#wprdts-discount').html(totalPriceHtml);				}
				if(roundTrip){
					$('#wprdts-form-return-info').css('display','block');
				}else{
					$('#wprdts-form-return-info').css('display','none');
				}
			});
			
		}); // End of Blur method
		
		//When form is submitted
		$('form#wprdts-widget-form #wprdts-widget-form-submit').click(function(e){		//$('form#wprdts-widget-form').submit(function(){			e.preventDefault();	
			var tripType = $("[name='wprdts-widget-form-trip-type']").val();
			//var destinationState = $("[name='wprdts-widget-form-state']").val();
			//var destinationCity = $("[name='wprdts-widget-form-city']").val();
			var numberOfPassenger = $("[name='wprdts-widget-form-passenger']").val();
			var numberOfluggage = $("[name='wprdts-widget-form-luggage']").val();
			var roundTrip = $("input[name='wprdts-widget-form-round-trip']:checked").val();
			var vehicleType = $("[name='wprdts-widget-form-vehicle-type']").val();			var seatInfant = $("[name='wprdts-widget-form-seat-infant']").val();			var seatBooster = $("[name='wprdts-widget-form-seat-booster']").val();
			var tripDate = $("[name='wprdts-widget-form-trip-date']").val();			var tripTime = $("[name='wprdts-widget-form-trip-time']").val().trim();			var returnTripDate = $("[name='wprdts-widget-form-return-trip-date']").val().trim();			var returnTripTime = $("[name='wprdts-widget-form-return-trip-time']").val().trim();
			//var timeHour = $("[name='wprdts-widget-form-trip-time-hour']").val();
			//var returnTimeHour = $("[name='wprdts-widget-form-return-trip-time-hour']").val();
			//var timeMinute = $("[name='wprdts-widget-form-trip-time-minute']").val();
			//var returnTimeMinute = $("[name='wprdts-widget-form-return-trip-time-minute']").val();
			//var timeAmPm = $("[name='wprdts-widget-form-trip-time-am-pm']").val();
			//var returnTimeAmPm = $("[name='wprdts-widget-form-return-trip-time-am-pm']").val();
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
			var currencySymbol = $("#wprdts-widget-form-currency").val();
			var price;		
			//console.log(roundTrip);					//Change progressbar status			$('.progress-item').removeClass('step-active');			$('.progress-item:nth-of-type('+3+')').prev().find('span i').removeClass().addClass('fa fa-check');			$('.progress-item:nth-of-type('+3+')').addClass('step-active');						//Statusbar navigation			$('.progress-item').click(function(){				progressBarStatus = $('.progress-item').index(this) + 1;								if(progressBarStatus == 1){					$('#wprdts-checkout-form-container').hide();					$('#wprdts-widget-form #wprdts-widget-form-container').show();					$('.wprdts-form-part-two').hide();						$('.progress-item').removeClass('step-active');					$('.progress-item:nth-of-type('+progressBarStatus+')').addClass('step-active');					console.log('progressBarStatus : '+progressBarStatus);				} else if(progressBarStatus == 2){					//console.log('progressBarStatus : '+progressBarStatus);					//$('.wprdts-widget-form-btn-continue').trigger('click');					$('#wprdts-checkout-form-container').hide();					$('#wprdts-widget-form #wprdts-widget-form-container').show();					$('.wprdts-form-part-two').show();						$('.progress-item').removeClass('step-active');					$('.progress-item:nth-of-type('+progressBarStatus+')').addClass('step-active');					console.log('progressBarStatus : '+progressBarStatus);				}else if(progressBarStatus == 3){					//$( "#wprdts-widget-form-submit").off( "click" );					$('#wprdts-widget-form-submit').triggerHandler('click');					$('#wprdts-checkout-form-container').show();					//$('#wprdts-checkout-form-container').append(result);				} 							});				
			//Get price 
			price = getPrice();			var discountType = parseInt( $("#wprdts-widget-hidden-form-discount").val().trim(), 10 );			var priceWithDiscount = getPriceWithDiscount(price);			var totalPriceHtml = '<del>'+currencySymbol+' '+price+'</del>'+' '+currencySymbol+' '+priceWithDiscount;			
			if(isNaN(price)){
				currencySymbol = '';				totalPriceHtml = price;
			}
			$('.wprdts-price').html(price);			if(discountType == 1 || discountType == 2){				$('#wprdts-discount').html(totalPriceHtml);			}
			//if(confirm("Are you sure to continue with  "+currencySymbol+" "+price+" ?")){
				var data = {
					action: 'wprdts_ajax_response_booking_request',
					requestFor: 'wprdts_booking_request',
					tripType: tripType,
					/*destinationState: destinationState, */
					/*destinationCity: destinationCity,*/
					numberOfPassenger: numberOfPassenger,
					numberOfluggage: numberOfluggage,
					roundTrip: roundTrip,
					vehicleType: vehicleType,										seatInfant: seatInfant,										seatBooster: seatBooster,
					tripDate: tripDate,
					returnTripDate: returnTripDate,										tripTime: tripTime,										returnTripTime: returnTripTime,
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
					price: price,
					status: 1
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
									bookingRequestId = result;
									console.log("Result : "+result);
								}
							}catch(e){
								console.log(e); //error in the above string(in this case,yes)!
								return false;
							}
							
						}
				}); //End of ajax request
				
				
				//Checkout form
				dataForCheckout = {
					action: 'wprdts_ajax_response_checkout_form_request',
					requestFor: 'wprdts_checkout_form_request',
					tripType: tripType,
				/*  destinationState: destinationState,*/
				/*  destinationCity: destinationCity, */
					numberOfPassenger: numberOfPassenger,
					numberOfluggage: numberOfluggage,
					roundTrip: roundTrip,
					vehicleType: vehicleType,										seatInfant: seatInfant,										seatBooster: seatBooster,
					tripDate: tripDate,					returnTripDate: returnTripDate,										tripTime: tripTime,										returnTripTime: returnTripTime,
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
					price: price,
					status: 1
				};
				
				$.ajax({
						url: wprdts_ajax_script.wprdts_ajaxurl,
						type: 'POST',
						data: dataForCheckout,
						async: false,
						dataType : "html",
						success:function(result){
							//console.log(result);
							//var result;
							try{
								if(result){
									$('#wprdts-widget-form #wprdts-widget-form-container').hide();
									$('#wprdts-checkout-form-container').empty();									$('#wprdts-checkout-form-container').show();									$('#wprdts-checkout-form-container').append(result);
									console.log("HTMl : "+result);
								}
							}catch(e){
								console.log(e); //error in the above string(in this case,yes)!
								return false;							}	
						}
				}); //End of ajax request				
				$('#paypal-buton').click(function(){						//Change progressbar status					$('.progress-item').removeClass('step-active');					//$('.progress-item:nth-of-type('+4+')').prev().find('span i').removeClass().addClass('fa fa-check');					$('.progress-item:nth-of-type('+3+')').find('span i').removeClass().addClass('fa fa-check');			
					//Paypal request
					var paypalStatus = $('#wprdts-widget-form-enable-paypal').val().trim();
					var paypalDisableUrl = $('#wprdts-widget-form-return-url').val().trim();
					var paypalNotifyUrl = $('#wprdts-widget-form-notify-url').val().trim();				
					if(paypalStatus){
						//$('#wprdts-confirmation-message-page').append(confirmationMessage);
						$('form#wprdts-paypal-form #amount').val(price);
						$('form#wprdts-paypal-form #custom').val(bookingRequestId);
						//console.log('Booking id '+bookingRequestId);
						//alert('Booking id '+bookingRequestId);
						$('form#wprdts-paypal-form').submit();
					}else{
						console.log("paypal disabled");
						window.location = paypalNotifyUrl;
					}
				});
			//} //end of if (confirm()			
			return false;	
		});
		
		//When click on trip type
		$('.wprdts-widget-form-element .wprdts-widget-form-trip-type').change(function(){						//Check trup type			if($(this).val() == 1){				$('.wprdts-widget-form-pickup-location-container').show();				$('.wprdts-widget-form-dropoff-location-container').hide();				isPickupLocationEnable = true;			}else if($(this).val() == 2){				$('.wprdts-widget-form-pickup-location-container').hide();				$('.wprdts-widget-form-dropoff-location-container').show();				isPickupLocationEnable = false;			}else{				$('.wprdts-widget-form-pickup-location-container').hide();				$('.wprdts-widget-form-dropoff-location-container').hide();			}					//enable other element 
			if($(this).val() != 0){
				//$('.wprdts-widget-field .wprdts-widget-form-state').removeAttr("disabled");				$('.wprdts-widget-field .wprdts-widget-form-passenger').removeAttr("disabled");				$('.wprdts-widget-field .wprdts-widget-form-luggage').removeAttr("disabled");				$('.wprdts-widget-field .wprdts-widget-form-round-trip').removeAttr("disabled");
			}else{
				//$('.wprdts-widget-field .wprdts-widget-form-state').attr("disabled","disabled");
				//$('.wprdts-widget-field .wprdts-widget-form-city').attr("disabled","disabled");				$('.wprdts-widget-field .wprdts-widget-form-passenger').attr("disabled","disabled");				$('.wprdts-widget-field .wprdts-widget-form-luggage').attr("disabled","disabled");				$('.wprdts-widget-field .wprdts-widget-form-round-trip').attr("disabled","disabled");
			}
		});
		
		//When click on select state
		/* $('.wprdts-widget-form-element .wprdts-widget-form-state option').click(function(){
			if($(this).val() != 0){
				$('.wprdts-widget-field .wprdts-widget-form-city').removeAttr("disabled");
			}else{
				$('.wprdts-widget-field .wprdts-widget-form-city').attr("disabled","disabled");
			}
		}); */	
		//When any key press on location field
		/* $('.wprdts-widget-form-element .wprdts-widget-form-city').keyup(function(){ 
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
								var response = JSON.parse(JSON.stringify(result));
								//var response = JSON.parse(result);
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
									$('.wprdts-input-dropdown-container ul').empty();									$('.wprdts-input-dropdown-container ul').append('<li class="wprdts-city-list">No City Found </li>');
								}
							}catch(e){
								console.log(e); //error in the above string(in this case,yes)!
							}
							
						}
				}); //End of ajax request	
		
			} else{
				$('.wprdts-input-dropdown-container ul').empty();
			}
		}); */ //End of onKeyUp
		
		//Show dropdown container when click in input text box
				/* $('.wprdts-widget-form-city').blur(function(){
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
				});  */					
		//SHow/hide wprdts-setting-form-amount-type field  		var amountType = parseInt( $('#wprdts-setting-form-discount option:selected').val(), 10 );			//console.log("Amount type : "+amountType);						if(amountType == 0){				$('#wprdts-setting-form-discount-type-amount').hide();				$('#wprdts-setting-form-discount-type-percent').hide();				$('#wprdts-setting-form-field-discount-message').hide();			} else if(amountType == 1){				$('#wprdts-setting-form-discount-type-amount').hide();				$('#wprdts-setting-form-discount-type-percent').show();				$('#wprdts-setting-form-field-discount-message').show();			} else if(amountType == 2){				$('#wprdts-setting-form-discount-type-amount').show();				$('#wprdts-setting-form-discount-type-percent').hide();				$('#wprdts-setting-form-field-discount-message').show();			}					$('#wprdts-setting-form-discount option').click(function(){			var amountType = parseInt( $(this).val(), 10 );						if(amountType == 0){				$('#wprdts-setting-form-discount-type-amount').hide();				$('#wprdts-setting-form-discount-type-percent').hide();				$('#wprdts-setting-form-field-discount-message').hide();			} else if(amountType == 1){				$('#wprdts-setting-form-discount-type-amount').hide();				$('#wprdts-setting-form-discount-type-percent').show();				$('#wprdts-setting-form-field-discount-message').show();			} else if(amountType == 2){				$('#wprdts-setting-form-discount-type-amount').show();				$('#wprdts-setting-form-discount-type-percent').hide();				$('#wprdts-setting-form-field-discount-message').show();			}						});						//Autocomplete location dropdown list 		var inputMainLocation = document.getElementById('wprdts-setting-form-main-location');		//console.log(input);		/* var searchBox = new google.maps.places.SearchBox(inputMainLocation, {			types: ['(cities)'],			componentRestrictions: {country: "us"}		}); */					/* new google.maps.places.Autocomplete(inputMainLocation, {			types: ['(cities)'],			componentRestrictions: {country: "us"}		});  */				//Autocomplete for Mainlocation 		var mapForMainLocation = new google.maps.Map(inputMainLocation, {			center: {lat: 37.1, lng: -95.7},			zoom: 13		});		var autoCompleteForMainLocation = new google.maps.places.Autocomplete(inputMainLocation);		autoCompleteForMainLocation.bindTo('bounds', mapForMainLocation);		autoCompleteForMainLocation.setComponentRestrictions({country: "us"});						//Autocomplete for pickup location 		//$('#wprdts-widget-form-pickup-location').keyup(function(e){			//e.preventDefault();			var inputPickupLocation = document.getElementById('wprdts-widget-form-pickup-location');						var mapForPickupLocation = new google.maps.Map(inputPickupLocation, {				center: {lat: 37.1, lng: -95.7},				zoom: 13			});			var autoCompleteForPickupLocation = new google.maps.places.Autocomplete(inputPickupLocation);			autoCompleteForPickupLocation.bindTo('bounds', mapForPickupLocation);			autoCompleteForPickupLocation.setComponentRestrictions({country: "us"});		//});				//Autocomplete for Dropoff location 		//$('#wprdts-widget-form-dropoff-location').keyup(function(e){			//e.preventDefault();			var inputDropoffLocation = document.getElementById('wprdts-widget-form-dropoff-location');						var mapForDropoffLocation = new google.maps.Map(inputDropoffLocation, {				center: {lat: 37.1, lng: -95.7},				zoom: 13			});			var autoCompleteForDropoffLocation = new google.maps.places.Autocomplete(inputDropoffLocation);			autoCompleteForDropoffLocation.bindTo('bounds', mapForDropoffLocation);			autoCompleteForDropoffLocation.setComponentRestrictions({country: "us"});		//});		//Autocomplete for Add fixed price city 		//$('#wprdts-widget-form-dropoff-location').keyup(function(e){			//e.preventDefault();			var inputAddFixedPriceCity = document.getElementById('wprdts-input-add-fixed-price-city');						var mapForAddFixedPriceCity = new google.maps.Map(inputAddFixedPriceCity, {				center: {lat: 37.1, lng: -95.7},				zoom: 13			});			var autoCompleteForAddFixedPriceCity = new google.maps.places.Autocomplete(inputAddFixedPriceCity);			autoCompleteForAddFixedPriceCity.bindTo('bounds', mapForAddFixedPriceCity);			autoCompleteForAddFixedPriceCity.setComponentRestrictions({country: "us"});		//}); 				//Autocomplete for Edit fixed price city 		//$('#wprdts-widget-form-dropoff-location').keyup(function(e){			//e.preventDefault();			var inputEditFixedPriceCity = document.getElementById('wprdts-input-edit-fixed-price-city');						var mapForEditFixedPriceCity = new google.maps.Map(inputEditFixedPriceCity, {				center: {lat: 37.1, lng: -95.7},				zoom: 13			});			var autoCompleteForEditFixedPriceCity = new google.maps.places.Autocomplete(inputEditFixedPriceCity);			autoCompleteForEditFixedPriceCity.bindTo('bounds', mapForEditFixedPriceCity);			autoCompleteForEditFixedPriceCity.setComponentRestrictions({country: "us"});		//}); 						
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
						async: false,						beforeSend: function() {							jQuery('#wprdts-preloader-container').show();						},
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
							}														jQuery('#wprdts-preloader-container').hide();
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
	} //End of getDistancInKm function
	
	//Get price 
	function getPrice(){
			var dropOffLocation = jQuery('#wprdts-widget-form-dropoff-location').val();			var returnDropOffLocation = jQuery('#wprdts-widget-form-return-dropoff-location').val();
			//var destinationState = jQuery("[name='wprdts-widget-form-state']").val();
			//var destinationCity = jQuery("[name='wprdts-widget-form-city']").val();
			var pickupLocation = jQuery("[name='wprdts-widget-form-pickup-location']").val();					var returnPickupLocation = jQuery("#wprdts-widget-form-return-pickup-location").val();								var mainLocation = jQuery('#wprdts-widget-form-main-location').val().trim();					var tripType = parseInt ( jQuery("[name='wprdts-widget-form-trip-type']").val(), 10);
			var passenger = parseInt( jQuery('.wprdts-widget-form-passenger').val().trim(), 10 );
			var luggage = parseInt( jQuery('.wprdts-widget-form-luggage').val().trim(), 10 );
			var roundTrip = parseInt(jQuery("input[name='wprdts-widget-form-round-trip']:checked").val(), 10);
			var pricePerKM = parseFloat(jQuery("#wprdts-widget-form-price-per-km").val());
			var additionalPriceOne = parseFloat(jQuery("#wprdts-widget-form-additional-price-one").val());
			var additionalPriceTwo = parseFloat(jQuery("#wprdts-widget-form-additional-price-two").val());
			var currencySymbol = jQuery("#wprdts-widget-form-currency").val();			
			var distanceInKm, distanceInKmForSecondTrip, distanceInKmForFirstTrip, PriceForFirstTrip = 0, PriceForSecondTrip = 0, 				price, OldPrice = 0;			var addressTo, addressFrom, additionalPrice, priceForFixedPriceCity = 0, 				priceForFixedPriceCityReturn = 0, callForPrice, result=[];
			console.log("Price per km : "+pricePerKM);
			console.log("additionalPriceOne : "+additionalPriceOne);
			console.log("additionalPriceTwo : "+additionalPriceTwo);
			
			//Map
			//var addressTo = destinationState+' '+destinationCity;			//Determine address from and address to			if(tripType == 1){				addressFrom = pickupLocation;				addressTo = mainLocation;			}else if (tripType == 2){				addressFrom = mainLocation;				addressTo = dropOffLocation;			}
						priceForFixedPriceCity = parseFloat(checkFixedPriceCity(addressTo, addressFrom));								//addressTo = dropOffLocation;
			//addressFrom = pickupLocation;
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
			distanceInKmForFirstTrip = getDistanceinKm(addressTo, addressFrom);				PriceForFirstTrip = pricePerKM*distanceInKmForFirstTrip;			distanceInKm = distanceInKmForFirstTrip;						//Check if round trip or not 			if(roundTrip == 1){				if(tripType == 1){					addressFrom = mainLocation;					addressTo = returnDropOffLocation;				}else if (tripType == 2){					addressFrom = returnPickupLocation;					addressTo = mainLocation;				}								distanceInKmForSecondTrip = getDistanceinKm(addressTo, addressFrom);				PriceForSecondTrip = pricePerKM*distanceInKmForSecondTrip;				distanceInKm = distanceInKmForFirstTrip + distanceInKmForSecondTrip;								priceForFixedPriceCityReturn = parseFloat(checkFixedPriceCity(addressTo, addressFrom));			}			
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
				additionalPrice = 0;								jQuery('#wprdts-widget-form-vehicle-type').val(1);
			} else if (((passenger >= 5 && passenger <= 6) && (luggage >= 4 && luggage <= 5)) || ((passenger >= 1 && passenger <= 4) && (luggage >= 4 && luggage <= 5)) || ((passenger >= 5 && passenger <= 6) && (luggage >= 1 && luggage <= 3))){
				additionalPrice = additionalPriceOne;							jQuery('#wprdts-widget-form-vehicle-type').val(2);
			} else if(((passenger >= 5 && passenger <= 6) && (luggage == 6)) || ((passenger >= 1 && passenger <= 4) && (luggage == 6)) || ((passenger >= 5 && passenger <= 6) && (luggage == 6))){
				additionalPrice = additionalPriceTwo;						jQuery('#wprdts-widget-form-vehicle-type').val(3);
			} else if (((passenger >= 7 && passenger <= 9) && (luggage == 6)) || ((passenger >= 7 && passenger <= 9) && (luggage >= 1 && luggage <= 3)) || ((passenger >= 7 && passenger <= 9) && (luggage >= 4 && luggage <= 5))){
				callForPrice = true;								jQuery('#wprdts-widget-form-vehicle-type').val(4);
			} else if (((passenger >= 7 && passenger <= 9) && (luggage >= 7 && luggage <= 12)) || ((passenger >= 5 && passenger <= 6) && (luggage >= 7 && luggage <= 12)) || ((passenger >= 7 && passenger <= 9) && (luggage >= 7 && luggage <= 12)) || ((passenger >= 10 && passenger <= 13) && (luggage >= 1 && luggage <= 3)) || ((passenger >= 10 && passenger <= 13) && (luggage >= 4 && luggage <= 5)) || ((passenger >= 10 && passenger <= 13) && (luggage == 6)) || ((passenger >= 1 && passenger <= 4) && (luggage >= 7 && luggage <= 12))){
				callForPrice = true;							jQuery('#wprdts-widget-form-vehicle-type').val(5);
			} else {
				callForPrice = true;							jQuery('#wprdts-widget-form-vehicle-type').val('');
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
			/* if(roundTrip){
				price = price*2;
			}  */		
			//Set call for price message
			if(callForPrice){
				price = 'Call for price';
			}else{
				price = price;								//check fixed price city or not 				if(priceForFixedPriceCityReturn && priceForFixedPriceCity){					price = priceForFixedPriceCity + priceForFixedPriceCityReturn;				}else if(priceForFixedPriceCity){					price = priceForFixedPriceCity + PriceForSecondTrip;				}else if(priceForFixedPriceCityReturn){					price = PriceForFirstTrip + priceForFixedPriceCityReturn;				}
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
	}			//Get price with discount 	function getPriceWithDiscount( price ){		var discountType = parseInt( jQuery('#wprdts-widget-hidden-form-discount').val().trim(), 10 );		var discountInPercent = parseInt( jQuery('#wprdts-widget-hidden-form-discount-amount-percent').val().trim(), 10);		var discountInFixed = parseInt( jQuery('#wprdts-widget-hidden-form-discount-amount-fixed').val().trim(), 10);		var discountMessage = jQuery('#wprdts-widget-hidden-form-discount-message').val().trim();		var discountAmount, priceWithDiscount;				console.log('discountInPercent : '+discountInPercent);				if(discountType == 1){			discountAmount = (discountInPercent*price)/100;			priceWithDiscount = price - discountAmount;		} else if(discountType == 2){			discountAmount = discountInFixed;			priceWithDiscount = price - discountAmount;		} else if(discountType == 0){			return false;		}				if(isNaN(price)){			priceWithDiscount = price;		}				if(jQuery.isNumeric(priceWithDiscount)){							return parseFloat(priceWithDiscount).toFixed(2);					} else{							return priceWithDiscount;						} 					//return priceWithDiscount;	}			//Check fixed price price city or not	function checkFixedPriceCity(addressTo, addressFrom){		var mainLocation = jQuery('#wprdts-widget-form-main-location').val().trim();			var response = 0;			var data = {					action: 'wprdts_ajax_response_check_fixed_price_city_request',					addressTo: addressTo,					addressFrom: addressFrom				};				console.log("Main Location : "+mainLocation);				jQuery.ajax({						url: wprdts_ajax_script.wprdts_ajaxurl,						type: 'POST',						data: data,						async: false,						beforeSend: function() {							jQuery('#wprdts-preloader-container').show();						},						success:function(result){							//console.log('result : '+result);							//var result;							try{								response = JSON.parse(JSON.stringify(result));								//response = parseFloat(JSON.parse(result));								 //response = JSON.parse(result);								console.log("Result of CheckFixedPriceCity : "+response.city_name);							}catch(e){								console.log(e); //error in the above string(in this case,yes)!							}														jQuery('#wprdts-preloader-container').hide();						}				}); //End of ajax request								if(response){					//jQuery('.wprdts-price').html(response);					//alert(response+" km");					console.log('City Price Response : '+response.city_price);					return response.city_price;				} else{					//alert(response+" km");					console.log('City Price Response : false');					return 0;				}	} //checkFixedPriceCity

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
	
	
	/////////////////****************** Manage Quote **************************//////////////
	
	function getFormActionForQuote(element){
		if(jQuery("input[name='quotes[]']:checked").length == 0){
			//console.log(checkdValues.length);
			alert("Make a selection from the list first");
			//window.location("?page=rd_taxi_system_manage_quotes");
			jQuery(element).attr("href", "");
		}else{
			//alert("Have value");
			var id = jQuery(element).attr("id");
			if (id == 'btn-edit-quote'){ 	//Edit state button
				jQuery("form#wprdts-quote-form").attr("action","?page=rd_taxi_system_manage_quotes&wprdts_action=action_edit").submit();
				//jQuery("form#wprdts-city-form").submit();
			} else if (id == 'btn-delete-quote'){	//Delete state button
				if(confirm("Are you sure to delete permanently ?")){
					jQuery("form#wprdts-quote-form").attr("action","?page=rd_taxi_system_manage_quotes&wprdts_action=action_delete").submit();
				}else{
					//alert("Not deleted");
				}
				//jQuery("form#wprdts-city-form").submit();
			} else if (id == 'btn-copy-quote'){		//Copy state button
				//jQuery("form#wprdts-state-form").attr("action","?page=rd_taxi_system_manage_cities&wprdts_action=action_copy").submit();
				if(confirm("Are you sure to copy ?")){
					//alert("copied");
					jQuery("form#wprdts-quote-form").attr("action","?page=rd_taxi_system_manage_quotes&wprdts_action=action_copy").submit();
				}else{
					//alert("Not copied");
				}
				//jQuery("form#wprdts-city-form").submit();
			} else if (id == 'btn-publish-quote'){		//Publish state button
				if(confirm("Are you sure to publish ?")){
					//alert("copied");
					jQuery("form#wprdts-quote-form").attr("action","?page=rd_taxi_system_manage_quotes&wprdts_action=action_publish").submit();
				}else{
					//alert("Not copied");
				}
				//jQuery("form#wprdts-state-form").submit();
			} else if (id == 'btn-unpublish-quote'){		//Unpublish state button
				if(confirm("Are you sure to unpublished ?")){
					//alert("copied");
					jQuery("form#wprdts-quote-form").attr("action","?page=rd_taxi_system_manage_quotes&wprdts_action=action_unpublish").submit();
				}else{
					//alert("Not copied");
				}
				//jQuery("form#wprdts-state-form").submit();
			}
			
			
		}
	}			
	//Autocomplete for pickup and dropoof location	function autoCompleteForPickupLocation(element){		var inputPickupLocation = element;		//var inputDropoffLocation = element;				//Autocomplete for pickup location 		var mapForPickupLocation = new google.maps.Map(inputPickupLocation, {			center: {lat: 37.1, lng: -95.7},			zoom: 13		});		var autoCompleteForPickupLocation = new google.maps.places.Autocomplete(inputPickupLocation);		autoCompleteForPickupLocation.bindTo('bounds', mapForPickupLocation);		autoCompleteForPickupLocation.setComponentRestrictions({country: "us"});						//Autocomplete for Dropoff location 		/* var mapForDropoffLocation = new google.maps.Map(inputDropoffLocation, {			center: {lat: 37.1, lng: -95.7},			zoom: 13		});		var autoCompleteForDropoffLocation = new google.maps.places.Autocomplete(inputDropoffLocation);		autoCompleteForDropoffLocation.bindTo('bounds', mapForDropoffLocation);		autoCompleteForDropoffLocation.setComponentRestrictions({country: "us"}); */	}
		//Timepicker	function OnHourShowCallback(hour) {		if ((hour > 20) || (hour < 6)) {			return false; // not valid		}		return true; // valid	}		function OnMinuteShowCallback(hour, minute) {		if ((hour == 20) && (minute >= 30)) { return false; } // not valid		if ((hour == 6) && (minute < 30)) { return false; }   // not valid		return true;  // valid	}
	