$(document).ready(function() {

	$('.replyTriggerBtn').on('click', function() {
		var message_id = $(this).data('id');
		$('#hiddenGetMessageId').val(message_id);

		$.ajax({
			method: 'POST',
			url: './controller/MessageController.php',
			data: {
				message_id: message_id,
				show_message: 1
			},
			dataType: 'html',
			success: function(response) {
				$('#message_container').html(response);
			}
		});

	});

	$('.sendReplyMessage').on('click', function() {

		// var message_id = $('hiddenGetMessageId').val();
		var message_reply = $('#message_reply').val();

		if (message_reply == "") {
			Swal.fire({
	            title: 'Your reply cannot be empty.',
	            type: 'error'
	        });	
		} else {
			Swal.fire({
                title: 'Message sent!',
                type: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then((result) => {
                if(result.value) {
                  window.location = './messages.php';
                }
            });

		}

		return false;

	});

	$('.archiveMessageBtn').on('click', function() {
		var message_id = $(this).data('id');

		Swal.fire({
            title: 'Delete message?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
          }).then((result) => {
            if(result.value) {
                $.ajax({
                  method: 'POST',
                  url: './controller/MessageController.php',
                  data: {
                    message_id: message_id,
                    archive_message: 1
                  },
                  dataType: 'json',
                  success: function(response) {
                  	if(response.success) {
	                	Swal.fire({
	                        title: response.success,
	                        type: 'success',
	                        confirmButtonColor: '#3085d6',
	                        confirmButtonText: 'OK'
	                    }).then((result) => {
	                        if(result.value) {
	                  			window.location = './messages.php';
	                  		}
	                  	});
                  	}
                  }
                });
            }
        });

	});


});