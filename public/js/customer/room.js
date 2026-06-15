$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    showTotalRoom();
});

// SHOW TOTAL ROOM
    function showTotalRoom(){
        $.ajax({
            url: "/getCustomerRoom",
            method: 'GET',
            success : function(data) {
                $("#showTotalRoom").html(data);
            }
        })
    }
// SHOW TOTAL ROOM

// FUNCTION FOR BOOKING
    function bookReservation(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to BOOK this room?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d72323',
            confirmButtonText: 'Yes, Continue!'
            }).then((result) => {
            if (result.isConfirmed) {
                $('#reservationModal').modal('show')
                $('#submitDateBooking').click(function(){
                    var checkInDateTime = $("#checkInDate").val();
                    var checkOutDateTime = $("#checkOutDate").val();
                    $.ajax({
                        url: "/bookReservation",
                        type:"POST",
                        method:"POST",
                        dataType: "json",
                        data: {roomId: id, checkInDateTime:checkInDateTime, checkOutDateTime:checkOutDateTime},
                        success: function(response) {
                            if (response.status == 1) {
                                showTotalRoom();
                                $("#bookReservationForm").trigger("reset");
                                $('#reservationModal').modal('hide')
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'RESERVATION HAS BEEN SUBMITTED',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }else if(response.status == 0){
                                Swal.fire(
                                'Added Failed',
                                'Sorry operation has not stored',
                                'error'
                                )
                            }else if(response.status == 4){
                                Swal.fire(
                                'Invalid Check In',
                                'Please check the date and time of the CHECK IN',
                                'error'
                                )
                            }else if(response.status == 3){
                                Swal.fire(
                                'Invalid Check Out',
                                'Please check the date and time of the CHECK OUT',
                                'error'
                                )
                            }else if(response.status == 2){
                                Swal.fire(
                                'Invalid Date and Time',
                                'The date of both CHECK IN and CHECK OUT must not be the same',
                                'error'
                                )
                            }
                            else if(response.status == 5){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'BOOK FAILED',
                                    text: 'Please complete all of your information.',
                                    footer: '<a href="/customerAccount">DIRECT ME TO MANAGE ACCOUNT</a>'
                                })
                            }
                            else if (response.status == 7) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'DUPLICATE BOOKING',
                                    text: 'You already have a reservation for this room on the selected dates.',
                                });
                            }
                        },
                        error:function(error){
                            console.log(error)
                        }
                    }) 
                });
            }
        });
    }

    function cancelReservation(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to CANCEL this RESERVATION?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d72323',
            confirmButtonText: 'Yes, Cancel it'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                url: '/cancelReservation',
                type: 'GET',
                dataType: 'json',
                data: {reservationID: id},
            });
            Swal.fire({
                title: 'CANCEL SUCCESSFULLY',
                icon: 'success',
                showConfirmButton: false,
                timer: 1000,
            }).then((result) => {
            if (result) {
                showTotalRoom();            
            }
            });
            }
        });
    }
// FUNCTION FOR BOOKING



