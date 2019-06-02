$(document).ready(function() {
	$('#table-reservation').DataTable({
		'scrollX': true,
		 dom: 'Bfrtip',
          buttons: [
              'copyHtml5',
              'excelHtml5',
              'csvHtml5',
              'pdfHtml5',
              'print'
          ]
	});

	$('.approveReservationBtn').on('click', function() {

		var reservation_id = $(this).data('id');
		var reservation_date = $(this).data('reservation');
		var employee_id = $(this).data('name');

		// console.log(reservation_id)
		// console.log(reservation_date);

		Swal.fire({
            title: 'Approve reservation for ' + reservation_date + '?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
          }).then((result) => {
            if(result.value) {
            	$.ajax({
            		method: 'POST',
					url: './controller/ReservationController.php',
					data: {
						employee_id: employee_id,
						reservation_id: reservation_id,
						approve_reservation: 1
					},
					dataType: 'json',
					success: function(response) {
						Swal.fire({
				            title: response.success,
				            type: 'success',
				            confirmButtonColor: '#3085d6',
				            confirmButtonText: 'Yes!',
				        }).then((result) => {
				            if(result.value) {
				            	window.location = './reservations.php';
				          	}
				        });
					}
            	});
            }
        });

	});


	$('.rejectReservationBtn').on('click', function() {

		var reservation_id = $(this).data('id');
		var reservation_date = $(this).data('reservation');
		var employee_id = $(this).data('name');

		// console.log(reservation_id)
		// console.log(reservation_date);

		Swal.fire({
            title: 'Reject reservation for ' + reservation_date + '?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
          }).then((result) => {
            if(result.value) {
            	$.ajax({
            		method: 'POST',
					url: './controller/ReservationController.php',
					data: {
						employee_id: employee_id,
						reservation_id: reservation_id,
						reject_reservation: 1
					},
					dataType: 'json',
					success: function(response) {
						Swal.fire({
				            title: response.success,
				            type: 'success',
				            confirmButtonColor: '#3085d6',
				            confirmButtonText: 'Yes!',
				        }).then((result) => {
				            if(result.value) {
				            	window.location = './reservations.php';
				          	}
				        });
					}
            	});
            }
        });

	});
});