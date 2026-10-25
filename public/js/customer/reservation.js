$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    showBookingPerUser();
    // showAcceptBookingPerUser();
    // showDeclineBookingPerUser();
});

// SHOW PENDING RESERVATION PER USER
    function showBookingPerUser(){
        $.ajax({
            url: "/getBookPerUser",
            method: 'GET',
            success : function(data) {
                $("#showPendingReservation").html(data);
            }
        })
    }
// SHOW PENDING RESERVATION PER USER

// SHOW ACCEPT RESERVATION PER USER 
    // function showAcceptBookingPerUser(){
    //     $.ajax({
    //         url: "/getAcceptBookPerUser",
    //         method: 'GET',
    //         success : function(data) {
    //             $("#showAcceptReservation").html(data);
    //         }
    //     })
    // }
// SHOW ACCEPT RESERVATION PER USER 

// SHOW DECLINED RESERVATION PER USER
    // function showDeclineBookingPerUser(){
    //     $.ajax({
    //         url: "/getDeclineBookPerUser",
    //         method: 'GET',
    //         success : function(data) {
    //             $("#showDeclineReservation").html(data);
    //         }
    //     })
    // }
// SHOW DECLINED RESERVATION PER USER

    function cancelReservation(id) {
        $.getJSON('/cancelPreview', { reservationId: id }).done(function (p) {
            if (!p.allowed) { Swal.fire('Cannot cancel', p.message, 'info'); return; }
            var needReason = p.status === 'Pending';
            Swal.fire({
                title: 'Cancel this reservation?',
                text: p.message,
                icon: 'warning',
                input: 'textarea',
                inputLabel: needReason ? 'Reason (required)' : 'Reason (optional)',
                inputAttributes: { maxlength: 255 },
                inputValidator: function (v) { return needReason && !v.trim() ? 'Please give a reason' : null; },
                showCancelButton: true,
                confirmButtonText: 'Yes, cancel it',
                showLoaderOnConfirm: true,
                allowOutsideClick: function () { return !Swal.isLoading(); },
                preConfirm: function (reason) {
                    return $.ajax({
                        url: '/cancelReservation', type: 'POST',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        data: { reservationId: id, reason: reason }
                    }).catch(function (xhr) {
                        Swal.showValidationMessage((xhr.responseJSON && xhr.responseJSON.message) || 'Cancel failed. Try again.');
                    });
                }
            }).then(function (r) {
                if (r.isConfirmed && r.value) {
                    Swal.fire({ icon: 'success', title: 'Reservation cancelled', text: r.value.message, timer: 3000, showConfirmButton: false })
                        .then(function () { showBookingPerUser(); });
                }
            });
        }).fail(function () { Swal.fire('Error', 'Please try again.', 'error'); });
    }

// BACK OUT RESERVATION
    function backOutReservation(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to BACK OUT this BOOKING?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d72323',
            confirmButtonText: 'Yes, Continue'
            }).then((result) => {
            if (result.isConfirmed) {
            (async () => {
                const { value: reason } = await Swal.fire({
                    input: 'textarea',
                    title: 'Reason of Back Out?',
                    text: "once you submit, You won't be able to revert this",
                    inputPlaceholder: 'Type your reason here...',
                    inputAttributes: {
                    'aria-label': 'Type your message here'
                    },
                    showCancelButton: true
                })
                if(reason){
                    $.ajax({
                        url: '/backOutReservation',
                        type: 'GET',
                        dataType: 'text',
                        data: {reason: reason, reservationId: id},
                        success: function(response) {
                            if(response == 1){
                                Swal.fire({
                                    title: 'BACK OUT SUCCESSFULLY',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1000,
                                }).then((result) => {
                                // if (result) {
                                //     showAcceptBookingPerUser();                                
                                // }
                                });
                            }else if(response == 0){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Back Out Failed',
                                    text: 'Something wrong at the backend',
                                })
                            }
                        }
                    });
                }
            })()
            }
        });
    } 
// BACK OUT RESERVATION