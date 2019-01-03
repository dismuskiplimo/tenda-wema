$(document).ready(function(){
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$('.ajax-form').on('submit', function(e){
		e.preventDefault();

		var that = $(this);

		$.ajax({
			url		: that.attr('action'),
			method	: that.attr('method'),
			data	: that.serialize(),
			datatype : 'JSON',
			success	: function(data){
				console.log(data);
			},

			error : function(xhr, status, error){
				console.log(xhr);
			},

			complete : function(){

			}
		});
	});


	$('.auth-form').on('submit', function(e){
		e.preventDefault();

		var that = $(this);

		that.find('.feedback').html('');

		$.ajax({
			url		: that.attr('action'),
			method	: that.attr('method'),
			data	: that.serialize(),
			datatype : 'JSON',
			success	: function(data){
				window.location.reload();
			},

			error : function(xhr, status, error){
				if(xhr.status == 422){
					var response = xhr.responseJSON;

					var message = '<strong>' + response.message + '</strong><br>';

					var cnt = 1;

					$.each(response.errors,function(index, value){
						message += '<strong>' + index.toUpperCase() + '</strong> : ';

						cnt = 1;

						length = value.length;

						$.each(value, function(index, value){
							
							message +=  value;

							if(cnt == length){
								message += '</br>';
								return false;
							}

							message += ', ';

							cnt += 1;
						});
					});

					message = '<span class = "text-danger">' + message + '</span> <br>';

					that.find('.feedback').html(message);

				}
				else if(xhr.status == 419){
					window.location.reload();
				}else{
					console.log(xhr);
				}
				
			},

			complete : function(){

			}
		});
	});

	$('.custom-auth-form').on('submit', function(e){
		e.preventDefault();

		var that = $(this);

		that.find('.feedback').html('');

		that.find('button.submit').attr('disabled', true);

		$.ajax({
			url		: that.attr('action'),
			method	: that.attr('method'),
			data	: that.serialize(),
			datatype : 'JSON',
			success	: function(data){
				if(data.status == 200){
					window.location.reload();
				}else{
					var feedback = '<p><span class = "text-danger">' + data.message + '</span> </p>';
					that.find('.feedback').html(feedback);
				}
			},

			error : function(xhr, status, error){
				if(xhr.status == 422){
					var response = xhr.responseJSON;

					// var message = '<strong>' + response.message + '</strong><br>';
					var message = '';

					var cnt = 1;

					$.each(response.errors,function(index, value){
						// message += '<strong>' + index.toUpperCase() + '</strong> : ';

						cnt = 1;

						length = value.length;

						$.each(value, function(index, value){
							
							message +=  value;

							if(cnt == length){
								message += '</br>';
								return false;
							}

							message += ', ';

							cnt += 1;
						});
					});

					message = '<span class = "text-danger">' + message + '</span> <br>';

					that.find('.feedback').html(message);

				}
				else if(xhr.status == 419){
					window.location.reload();
				}else{
					console.log(xhr);
				}
				
			},

			complete : function(){
				that.find('button.submit').attr('disabled', false);
			}
		});
	});

	$('.profile-picture').on('click', function(e){
		$('.profile-picture-file').click();
	});	

	$('.profile-picture-file').on('change', function(){
		$('.profile-picture-form').submit();
	});

	$('.buttons').on('click', '.browse-file-button' , function(e){
		e.preventDefault();
		
		var that = $(this);

		that.siblings('input[type=file]')[0].click();
	});

	$('.buttons').on('click', '.add-file-button' , function(){
		var button = 
			'<div class="button-wrapper file-button">' +
                '<div class="row">' +
                    '<div class="col-xs-4">' +
                        '<button class="btn btn-info browse-file-button" type="button"><i class = "fa fa-folder"></i> Browse</button>' +

                        '<input type="file" name="images[]" class="file-input hidden" accept="image/*">' +
                    '</div>' +
                    '<div class="col-xs-7">' +
                        '<p class="file-label">No File Selected</p>' +
                    '</div>' +
                    '<div class="col-xs-1 text-right"><i class="fa fa-times remove-file"></i></div>' +
                '</div>' +
            '</div>';
		$('.file-button:last').after(button);
	});

	$('.buttons').on('click','.remove-file', function(){
		$(this).closest('.button-wrapper').remove();
	});

	$('.buttons').on('change','.file-input', function(){
		var that = $(this);

		var file = that.val();

		that.closest('.row').find('.file-label').text(file.match(/[-_\w]+[.][\w]+$/i)[0]);

	});

	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd',
	});

	$('.dob').datepicker({
		format: 'yyyy-mm-dd',
		endDate: '-18y',
	});

	$('.confirm').on('submit', function(e){
		var status = confirm('Are you sure?');

		if(confirm == false){
			e.preventDefault();
		}
	});

	$('.purchase-coins').on('click', function(e){
		$('#purchase-coins').modal('hide');
	});

	if($('#messages').length){
		$('#messages').scrollTop($('#messages')[0].scrollHeight);
	}

	$('#about-me-form').on('submit', function(e){
		var about_me 	= $.trim($('#about-me-control').val());
		var length 		= about_me.split(" ").length;

		if(length < 200){
			$('#about-me-control').focus();
			Swal('Sorry','Bio must be at least 200 words long', 'error');
			e.preventDefault();
			
		}
	});

	if($('#about-me-form').length){
		var about_me 	= $.trim($('#about-me-control').val());
		var length 		= about_me.split(" ").length;

		if(about_me == ""){
			length = 0;
		}

		$('#word-count').html(length);

		$('#about-me').on('keyup keydown paste', function(){
			about_me 	= $.trim($('#about-me-control').val());
			length 		= $.trim(about_me.split(" ").length);

			if(about_me == ""){
				length = 0;
			}

			$('#word-count').html(length);
		});
	}

	if($('.crop-it-container').length){
		var $croppie = $('#image-cropper').cropit({
			width : 400,
			height: 400,
			initialZoom: 'image',
			imageBackground: false,
			freeMove: false,
			maxZoom:10,
		});

		$('.rotate-cw-btn').click(function() {
		  $('#image-cropper').cropit('rotateCW');
		});
		$('.rotate-ccw-btn').click(function() {
		  $('#image-cropper').cropit('rotateCCW');
		});

		$('.cropit-image-button').on('click', function(){
			$('.cropit-image-input').click();
		});
	}

	if($('.paypal-input').length){

		$('.paypal-input').on('change keyup keydown', function(e){
			var coins = $(this).val();

			if(coins > 0){
				var amount = coins / 10;

				$('.paypal-amount').html(amount);

				$('.paypal-coins').html(coins);
			}else{
				$('.paypal-amount').html('0');

				$('.paypal-coins').html('0');
			}
			
		});

		$('.mpesa-input').on('change keyup keydown', function(e){
			var coins = $(this).val();

			if(coins > 0){
				var amount = coins * 10;

				$('.mpesa-amount').html(amount);

				$('.mpesa-coins').html(coins);
			}else{
				$('.mpesa-amount').html('0');

				$('.mpesa-coins').html('0');
			}
			
		});

	}

});