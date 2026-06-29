function wireSearch(table) {
    $('#searchInput').off('keyup').on('keyup', function () {
        var col = $('#searchColumn').val();
        table.column(col).search(this.value).draw();
    });
    $('#searchColumn').off('change').on('change', function () {
        table.columns().search('');
        $('#searchInput').val('');
        table.draw();
    });
}

$(document).ready(function(){
    pendingReservationTable();
    acceptReservationTable();
    declineReservationTable();
    ongoingReservationTable();
    completedReservationTable();
    backOutReservationTable();
    cancelledReservationTable();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }); 
});

function pendingReservationTable(){
    if ($('#pendingReservationTable').length === 0) return;
    var table = $('#pendingReservationTable').DataTable({
        "language": { "emptyTable": "No Reservation Found" },
        "lengthChange": true,
        "scrollCollapse": true,
        "paging": true,
        "info": true,
        "responsive": true,
        "ordering": false,
        "dom": '<"top"l>rt<"bottom"ip>',   // removes default search
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        "iDisplayLength": 5,
        "ajax": { "url": "/getAllPendingReservation", "dataSrc": "" },
        "columns": [
            { "data": null, "render": function (data) { return data.reservation_id; }},
            { "data": null, "render": function (data) {
                return data.extention
                    ? `${data.firstname} ${data.lastname} ${data.extention}`
                    : `${data.firstname} ${data.lastname}`;
            }},
            { "data": null, "render": function (data) {
                return `${data.floor} - Room ${data.room_number}`;
            }},
            { "data": "start_dataTime", "render": function (data) {
                return moment(data).format('MMM DD, YYYY | hh:mm A');
            }},
            { "data": "end_dateTime", "render": function (data) {
                return moment(data).format('MMM DD, YYYY | hh:mm A');
            }},
            { "data": "totalPayment", "render": function (data) {
                return '₱' + Number(data).toLocaleString('en-PH', { minimumFractionDigits: 2 });
            }},
            { "data": null, "render": function (data) {
                return '<button type="button" class="btn-res btn-res--pay btn-res--icon" onclick="acceptReservation(' + data.reservation_id + ')"><i class="bi bi-check2-square"></i></button> ' +
                       '<button type="button" class="btn-res btn-res--cancel btn-res--icon" onclick="declineReservation(' + data.reservation_id + ', ' + data.user_id + ')"><i class="bi bi-x-square"></i></button>';
            }}
        ],
        order: [[3, 'asc']]
    });

    wireSearch(table);

    table.on('order.dt search.dt', function () {
        let i = 1;
        table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
        });
    }).draw();
}

// FETCH ALL ACCEPT RESERVATION FOR TABLE
    function acceptReservationTable(){
        if ($('#acceptReservationTable').length === 0) return;
        var table = $('#acceptReservationTable').DataTable({
            "language": {
                "emptyTable": "No Reservation Found"
            },
            "lengthChange": true,
            "scrollCollapse": true,
            "paging": true,
            "info": true,
            "responsive": true,
            "ordering": false,
            "dom": '<"top"l>rt<"bottom"ip>',   // removes default search
            "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
            "iDisplayLength": 5,
            "ajax":{
                "url":"/getAllAcceptReservation",
                "dataSrc": "",
            },
            "columns":[
                {"data":"reservation_id"},
                { "mData": function (data, type, row) {
                    if(data.extention != null){
                        return data.firstname+ " " +data.lastname+ " " +data.extention;
                    }else{
                        return data.firstname+ " " +data.lastname;
                    }
                }},
                { "mData": function (data, type, row) {
                        return data.floor+ " - Room " +data.room_number;
                }},
                {"data": "start_dataTime",
                    "render": function(data) {
                    return moment(data).format('MMM DD, YYYY | hh:mm A');
                },
                "targets": 1
                },
                {"data": "end_dateTime",
                    "render": function(data) {
                    return moment(data).format('MMM DD, YYYY | hh:mm A');
                },
                "targets": 1
                },
                { "mData": function (data, type, row) {
                    return '<button type="button" data-title="Set Reservation?" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top" onclick="ongoingReservation('+data.reservation_id+', '+data.room_id+')" class="btn rounded-0 btn-outline-success btn-sm py-2 px-3"><i class="bi bi-check2-square"></i></button> <button type="button" onclick="backOutReservation('+data.reservation_id+', '+data.user_id+')" class="btn rounded-0 ROUNDED-0 btn-outline-danger btn-sm py-2 px-3" data-title="Back Out Reservation?"><i class="bi bi-x-square"></i></button>'
                }},
            ],
            order: [[1, 'asc']],
        });

        wireSearch(table);

        table.on('order.dt search.dt', function () {
            let i = 1;
            table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                this.data(i++);
            });
        }).draw();
    }
// FETCH ALL ACCEPT RESERVATION FOR TABLE

// FETCH ALL ACCEPT RESERVATION FOR TABLE
    function ongoingReservationTable(){
        if ($('#ongoingReservationTable').length === 0) return;
        var table = $('#ongoingReservationTable').DataTable({
            "language": {
                "emptyTable": "No Reservation Found"
            },
            "lengthChange": true,
            "scrollCollapse": true,
            "paging": true,
            "info": true,
            "responsive": true,
            "ordering": false,
            "dom": '<"top"l>rt<"bottom"ip>',   // removes default search
            "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
            "iDisplayLength": 5,
            "ajax":{
                "url":"/getAllOnGoingReservation",
                "dataSrc": "",
            },
            "columns":[
                {"data":"reservation_id"},
                { "mData": function (data, type, row) {
                    if(data.extention != null){
                        return data.firstname+ " " +data.lastname+ " " +data.extention;
                    }else{
                        return data.firstname+ " " +data.lastname;
                    }
                }},
                { "mData": function (data, type, row) {
                        return data.floor+ " - Room " +data.room_number;
                }},
                {"data": "start_dataTime",
                    "render": function(data) {
                    return moment(data).format('MMM DD, YYYY | hh:mm A');
                },
                "targets": 1
                },
                {"data": "end_dateTime",
                    "render": function(data) {
                    return moment(data).format('MMM DD, YYYY | hh:mm A');
                },
                "targets": 1
                },
                { "mData": function (data, type, row) {
                    return '<button type="button" data-title="Complete Transaction?" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top" onclick="completeTransaction('+data.reservation_id+' , '+data.roomId+')" class="btn rounded-0 btn-outline-success btn-sm py-2 px-3"><i class="bi bi-check2-square"></i></button>'
                }},
            ],
            order: [[1, 'asc']],
        });

        wireSearch(table);

        table.on('order.dt search.dt', function () {
            let i = 1;
            table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                this.data(i++);
            });
        }).draw();
    }
// FETCH ALL ACCEPT RESERVATION FOR TABLE

// FETCH ALL DECLINE RESERVATION FOR TABLE
    function declineReservationTable(){
        if ($('#declineReservationTable').length === 0) return;
        var table = $('#declineReservationTable').DataTable({
            "language": {
                "emptyTable": "No Reservation Found"
            },
            "lengthChange": true,
            "scrollCollapse": true,
            "paging": true,
            "info": true,
            "responsive": true,
            "ordering": false,
            "dom": '<"top"l>rt<"bottom"ip>',
            "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
            "iDisplayLength": 5,
            "ajax":{
                "url":"/getAllDeclineReservation",
                "dataSrc": "",
            },
            "columns":[
                {"data":"reservation_id"},
                { "mData": function (data, type, row) {
                    if(data.extention != null){
                        return data.firstname+ " " +data.lastname+ " " +data.extention;
                    }else{
                        return data.firstname+ " " +data.lastname;
                    }
                }},
                { "mData": function (data, type, row) {
                        return data.floor+ " - Room " +data.room_number;
                }},
                {"data": "start_dataTime",
                    "render": function(data) {
                    return moment(data).format('MMM DD, YYYY | hh:mm A');
                },
                "targets": 1
                },
                {"data": "end_dateTime",
                    "render": function(data) {
                    return moment(data).format('MMM DD, YYYY | hh:mm A');
                },
                "targets": 1
                },
                {"data": "reservation_id",
                    mRender: function (data, type, row) {
                    return '<button type="button" data-title="View Reason?" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top" onclick=viewReasonOfDecline('+data+') class="btn rounded-0 btn-outline-secondary btn-sm py-2 px-3"><i class="bi bi-check2-square"></i></button>'
                }
                }
            ],
            order: [[1, 'asc']],
        });

        wireSearch(table);

        table.on('order.dt search.dt', function () {
            let i = 1;
            table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                this.data(i++);
            });
        }).draw();
    }
// FETCH ALL DECLINE RESERVATION FOR TABLE

// FETCH ALL COMPLETED TRANSACTION
    function completedReservationTable(){
        if ($('#completedReservationTable').length === 0) return;
    var table = $('#completedReservationTable').DataTable({
        "language": {
            "emptyTable": "No Reservation Found"
        },
        "lengthChange": true,
        "scrollCollapse": true,
        "paging": true,
        "info": true,
        "responsive": true,
        "ordering": false,
        "dom": '<"top"l>rt<"bottom"ip>',   // removes default search
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        "iDisplayLength": 5,
        "ajax":{
            "url":"/getAllCompletedReservation",
            "dataSrc": "",
        },
        "columns":[
            {"data":"reservation_id"},
            { "mData": function (data, type, row) {
                if(data.extention != null){
                    return data.firstname+ " " +data.lastname+ " " +data.extention;
                }else{
                    return data.firstname+ " " +data.lastname;
                }
            }},
            { "mData": function (data, type, row) {
                    return data.floor+ " - Room " +data.room_number;
            }},
            {"data": "start_dataTime",
                "render": function(data) {
                return moment(data).format('MMM DD, YYYY | hh:mm A');
            },
            "targets": 1
            },
            {"data": "end_dateTime",
                "render": function(data) {
                return moment(data).format('MMM DD, YYYY | hh:mm A');
            },
            "targets": 1
            },
        ],
        order: [[1, 'asc']],
    });

    wireSearch(table);

    table.on('order.dt search.dt', function () {
        let i = 1;
        table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
        });
    }).draw();
    }
// FETCH ALL COMPLETED TRANSACTION

// FETCH ALL COMPLETED TRANSACTION
    function backOutReservationTable(){
        if ($('#backOutReservationTable').length === 0) return;
        var table = $('#backOutReservationTable').DataTable({
            "language": {
                "emptyTable": "No Reservation Found"
            },
            "lengthChange": true,
            "scrollCollapse": true,
            "paging": true,
            "info": true,
            "responsive": true,
            "ordering": false,
            "dom": '<"top"l>rt<"bottom"ip>',
            "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
            "iDisplayLength": 5,
            "ajax":{
                "url":"/getAllBackOutReservation",
                "dataSrc": "",
            },
            "columns":[
                {"data":"reservation_id"},
                { "mData": function (data, type, row) {
                    if(data.extention != null){
                        return data.firstname+ " " +data.lastname+ " " +data.extention;
                    }else{
                        return data.firstname+ " " +data.lastname;
                    }
                }},
                { "mData": function (data, type, row) {
                        return data.floor+ " - Room " +data.room_number;
                }},
                {"data": "start_dataTime",
                    "render": function(data) {
                    return moment(data).format('MMM DD, YYYY | hh:mm A');
                },
                "targets": 1
                },
                {"data": "end_dateTime",
                    "render": function(data) {
                    return moment(data).format('MMM DD, YYYY | hh:mm A');
                },
                "targets": 1
                },
                { "mData": function (data, type, row) {
                    return '<button type="button" data-title="View Reason?" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top" onclick=viewReasonOfBackOut('+data.reservation_id+') class="btn rounded-0 btn-outline-secondary btn-sm py-2 px-3"><i class="bi bi-check2-square"></i></button>'
                }},
            ],
            order: [[1, 'asc']],
        });

        wireSearch(table);

        table.on('order.dt search.dt', function () {
            let i = 1;
            table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                this.data(i++);
            });
        }).draw();
    }
// FETCH ALL COMPLETED TRANSACTION

function cancelledReservationTable(){
    if ($('#cancelledReservationTable').length === 0) return;
    var table = $('#cancelledReservationTable').DataTable({
        "language": { "emptyTable": "No Reservation Found" },
        "lengthChange": true,
        "scrollCollapse": true,
        "paging": true,
        "info": true,
        "responsive": true,
        "ordering": false,
        "dom": '<"top"l>rt<"bottom"ip>',
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        "iDisplayLength": 5,
        "ajax": { "url": "/getAllCancelledReservation", "dataSrc": "" },
        "columns":[
            {"data":"reservation_id"},
            { "mData": function (data) {
                return data.extention ? `${data.firstname} ${data.lastname} ${data.extention}` : `${data.firstname} ${data.lastname}`;
            }},
            { "mData": function (data) { return `${data.floor} - Room ${data.room_number}`; }},
            { "data": "start_dataTime", "render": function(data){ return moment(data).format('MMM DD, YYYY | hh:mm A'); }},
            { "data": "end_dateTime", "render": function(data){ return moment(data).format('MMM DD, YYYY | hh:mm A'); }},
            { "data": "totalPayment", "render": function(data){ return '₱' + Number(data).toLocaleString('en-PH', { minimumFractionDigits: 2 }); }},
            { "mData": function (data) {
                return '<button type="button" data-bs-toggle="tooltip" onclick="viewReasonOfCancelled('+data.reservation_id+')" class="btn rounded-0 btn-outline-secondary btn-sm py-2 px-3"><i class="bi bi-eye"></i></button>';
            }},
        ],
        order: [[1, 'asc']],
    });

    wireSearch(table);

    table.on('order.dt search.dt', function () {
        let i = 1;
        table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
        });
    }).draw();
}

// DECLINE RESERVATION
    function declineReservation(reservationId, userId){
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to DECLINE this BOOKING?",
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
                    title: 'Reason of Decline?',
                    text: "Once you submit, You won't be able to revert this",
                    inputPlaceholder: 'Type your reason here...',
                    inputAttributes: {
                    'aria-label': 'Type your message here'
                    },
                    showCancelButton: true
                })
                if(reason){
                    $.ajax({
                        url: '/declineReservation',
                        type: 'GET',
                        dataType: 'text',
                        data: {reason: reason, reservationId: reservationId,  userId: userId},
                        success: function(response) {
                            if(response == 1){
                                Swal.fire({
                                    title: 'DECLINE SUCCESSFULLY',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1000,
                                }).then((result) => {
                                if (result) {
                                    $('#pendingReservationTable').DataTable().ajax.reload();
                                }
                                });
                            }else if(response == 0){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Decline Failed',
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
// DECLINE RESERVATION

// ACCEPT RESERVATION
    function acceptReservation(id){
        Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to ACCEPT this BOOKING?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Accept it'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
            url: '/acceptReservation',
            type: 'GET',
            dataType: 'json',
            data: {reservationId: id},
        });
        Swal.fire({
            title: 'ACCEPT BOOKING',
            text: "Reservation was accept successfully",
            icon: 'success',
            showConfirmButton: false,
            timer: 1500,
        }).then((result) => {
        if (result) {
            $('#pendingReservationTable').DataTable().ajax.reload();
        }
        });
        }
        });
    } 
// ACCEPT RESERVATION

// SET RESERVATION
    function ongoingReservation(reservationId , roomId){
        Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to SET this BOOKING?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Accept it'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
            url: '/ongoingReservation',
            type: 'GET',
            dataType: 'json',
            data: {reservationId: reservationId, roomId: roomId},
            success: function(response) {
                if(response == 1){
                    Swal.fire({
                        title: 'ON-GOING BOOKING',
                        text: "Reservation was set to ON-GOING successfully",
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500,
                    }).then((result) => {
                    if (result) {
                        $('#acceptReservationTable').DataTable().ajax.reload();
                    }
                    });
                }else if(response == 2){
                    Swal.fire({
                        icon: 'error',
                        title: 'Set Failed',
                        text: 'The BOOKING was not reach the Check In Date and Time',
                    })
                }
            }
        });       
        }
        });
    } 
// SET RESERVATION

// COMPLETE TRANSACTION
    function completeTransaction(reservationId){
        Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to COMPLETE this BOOKING?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Accept it'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
            url: '/completeReservation',
            type: 'GET',
            dataType: 'json',
            data: {reservationId: reservationId},
            success: function(response) {
                if(response == 1){
                    Swal.fire({
                        title: 'COMPLETE BOOKING',
                        text: "Reservation was COMPLETE successfully",
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500,
                    }).then((result) => {
                    if (result) {
                        $('#ongoingReservationTable').DataTable().ajax.reload();
                    }
                    });
                }else if(response == 2){
                    Swal.fire({
                        icon: 'error',
                        title: 'Complete Failed',
                        text: 'The reservation was not done yet',
                    })
                }
            }
        });
        }
        });
    } 
// COMPLETE TRANSACTION

// BACK OUT RESERVATION
    function backOutReservation(reservationId, userId){
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
                    text: "Once you submit, You won't be able to revert this",
                    inputPlaceholder: 'Type your reason here...',
                    inputAttributes: {
                    'aria-label': 'Type your message here'
                    },
                    showCancelButton: true
                })
                if(reason){
                    $.ajax({
                        url: '/adminBackOutReservationFunction',
                        type: 'GET',
                        dataType: 'text',
                        data: {reason: reason, reservationId: reservationId,  userId: userId},
                        success: function(response) {
                            if(response == 1){
                                Swal.fire({
                                    title: 'BACK OUT SUCCESSFULLY',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1000,
                                }).then((result) => {
                                if (result) {
                                    $('#acceptReservationTable').DataTable().ajax.reload();
                                }
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

function viewReasonOfCancelled(id){
    $('#cancelledReasonModal').modal('show')
    $.ajax({
        url: '/viewReasonCancelled',
        type: 'GET',
        dataType: 'json',
        data: {reservationId: id},
    })
    .done(function(response) {
        $('#cancelledReason').text(response.reason);
        $('#cancelledLast').text(response.created_at);
    })
}

// VIEW DECLINE REASON
    function viewReasonOfDecline(id){
        $('#declineReasonModal').modal('show')
        $.ajax({
            url: '/viewReasonDecline',
            type: 'GET',
            dataType: 'json',
            data: {reservationId: id},
        })
        .done(function(response) {
            $('#declinedReason').text(response.reason); 
        })
    } 
// VIEW DECLINE REASON

// VIEW BACK OUT REASON
    function viewReasonOfBackOut(id){
        $('#backOutReasonModal').modal('show')
        $.ajax({
            url: '/viewReasonBackOut',
            type: 'GET',
            dataType: 'json',
            data: {reservationId: id},
        })
        .done(function(response) {
            $('#backOutReason').text(response.reason); 
        })
    } 
// VIEW BACK OUT REASON