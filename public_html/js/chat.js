$(document).ready(function(){
	var message_count_url 		= $('#message_count_url').val();
	var notification_count_url 	= $('#notification_count_url').val();
	var all_count_url 			= $('#all_count_url').val();

	if($('.front-messages').length){
		var conversation_url = $('#conversation_url').val();

		setInterval(function(){
			$.ajax({
				url 		: conversation_url,
				method		: 'GET',
				dataType 	: 'JSON',
				success		: function(data){
					if(parseInt(data.status) == 200){
						if(parseInt(data.count) > 0){
							var messages = '';

							$.each(data.messages, function(index, value){
								var cls;
								var cls1;

								if(parseInt(value.mine) == 1){
									cls = "msg-right";	
									cls1 = "";	
								}else{
									cls = "msg-left";
									cls1 = "text-muted";
								}

								messages += '<div class="' + cls + ' msg">' +
							        '<p class="mb-0">' +
							        	'<small><b>' + value.from + '</b></small> <br>' +
							        	'<small>' + value.message + '</small> <br>' +
							        	'<small class="pull-right ' + cls1 +  '">' + value.time + '</small>' +
							        '</p>' +
							    '</div>';
							});

							$('#messages').html(messages);

							$('#messages').scrollTop($('#messages')[0].scrollHeight);
						}
					}



					
				},
				error: function(xhr, status, error){

				},
				complete: function(){

				}
			});
		},10000);
	}

	if($('.admin-messages').length){
		var conversation_url = $('#conversation_url').val();

		setInterval(function(){
			$.ajax({
				url 		: conversation_url,
				method		: 'GET',
				dataType 	: 'JSON',
				success		: function(data){
					if(parseInt(data.status) == 200){
						if(parseInt(data.count) > 0){
							var messages = '';

							$.each(data.messages, function(index, value){
								var cls;
								var cls1;

								if(parseInt(value.mine) == 1){
									cls = "msg-right";	
									cls1 = "";	
								}else{
									cls = "msg-left";
									cls1 = "text-muted";
								}

								messages += '<div class="' + cls + ' msg">' +
							        '<p class="mb-0">' +
							        	'<small><b>' + value.from + '</b></small> <br>' +
							        	'<small>' + value.message + '</small> <br>' +
							        	'<small class="pull-right ' + cls1 +  '">' + value.time + '</small>' +
							        '</p>' +
							    '</div>';
							});

							$('#messages').html(messages);

							$('#messages').scrollTop($('#messages')[0].scrollHeight);
						}
					}



					
				},
				error: function(xhr, status, error){

				},
				complete: function(){

				}
			});
		},10000);
	}

	if($('.user-messages').length){
		setInterval(function(){
			$.ajax({
				url 		: all_count_url,
				method		: 'GET',
				dataType 	: 'JSON',
				success		: function(data){
					if(parseInt(data.notifications.count) > 0){
						$('.user-notifications').find('.badge').html((data.notifications.count));
					}else{
						$('.user-notifications').find('.badge').html('');
					}

					if(parseInt(data.messages.count) > 0){
						$('.user-messages').find('.badge').html((data.messages.count));
					}else{
						$('.user-messages').find('.badge').html('');	
					}
				},
				error: function(xhr, status, error){

				},
				complete: function(){

				}
			});
		},10000);
	}

	$('#compose-message-form').on('submit', function(e){
		e.preventDefault();

		var that = $(this);

		that.find('button').prop('disabled', true);

		$.ajax({
			url: that.action,
			method: 'POST',
			data: that.serialize(),
			dataType: 'JSON',
			success: function(data){
				$('.response').html(data);
				that.find('textarea').val('');
			},
			error: function(xhr, status, error){
				console.log(xhr.responseText);
			},
			complete: function(){
				that.find('button').prop('disabled', false);
			}
		});
	});

});