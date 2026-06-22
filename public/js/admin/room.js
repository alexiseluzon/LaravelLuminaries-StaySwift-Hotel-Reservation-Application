$(document).ready(function(){
    availableRoom();
    notAvailableRoom();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

// Escapes a value for safe use inside an HTML attribute (e.g. title="...")
function escapeAttr(value) {
    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

// Truncates long text and exposes the full text via a native title tooltip
function renderTruncated(text, maxLength = 60) {
    var safe = String(text ?? '');
    var truncated = safe.length > maxLength ? safe.slice(0, maxLength) + '…' : safe;
    return '<span class="cell-truncate" title="' + escapeAttr(safe) + '">' + escapeAttr(truncated) + '</span>';
}

function formatPrice(amount) {
    return '₱' + amount + '.00';
}

// (Re)initializes Bootstrap tooltips on whatever action buttons exist after a DataTables draw
function initTooltips() {
    $('[data-bs-toggle="tooltip"]').tooltip();
}

// FETCH AVAILABLE ROOM FOR TABLE
    function availableRoom(){
    var table = $('#availableRoom').DataTable({
        "language": {
            "emptyTable": "No Room Found"
        },
        "lengthChange": true,
        "scrollCollapse": true,
        "paging": true,
        "info": true,
        "responsive": true,
        "ordering": false,
        "autoWidth": false,
        "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
        "iDisplayLength": 25,
        "ajax":{
            "url":"/getAvailableRoom",
            "dataSrc": "",
        },
        "columns":[
            {"data":"room_id"},
            {"data":"room_number"},
            {"data":"floor"},
            {"data":"type_of_room"},
            {"data":"number_of_bed"},
            {"data":"max_person"},
            {"data":"price", "render": function (data, type, row) {
                return formatPrice(data);
            }},
            {"data":"details", "render": function (data, type, row) {
                return renderTruncated(data);
            }},
            {"data": "room_id",
                render: function (data, type, row) {
                return '<button type="button" title="Update" data-bs-toggle="tooltip" data-bs-placement="top" onclick=viewRoomDetails('+data+') class="btn rounded-0 btn-outline-secondary btn-sm py-2 px-3"><i class="bi bi-pencil-square"></i></button> <button type="button" title="Deactivate Room" data-bs-toggle="tooltip" data-bs-placement="top" onclick=deactivateRoom('+data+') class="btn rounded-0 btn-outline-danger btn-sm py-2 px-3"><i class="bi bi-toggle-off"></i></button>'
            }
            }
        ],
        order: [[1, 'asc']],
        drawCallback: initTooltips,
    });
    table.on('order.dt search.dt', function () {
        let i = 1;
        table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
        });
    }).draw();
    }
// FETCH AVAILABLE ROOM FOR TABLE

// FETCH NOT AVAILABLE ROOM FOR TABLE
    function notAvailableRoom(){
    var table = $('#notAvailableRoom').DataTable({
        "language": {
            "emptyTable": "No Room Found"
        },
        "lengthChange": true,
        "scrollCollapse": true,
        "paging": true,
        "info": true,
        "responsive": true,
        "ordering": false,
        "autoWidth": false,
        "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
        "iDisplayLength": 25,
        "ajax":{
            "url":"/getNotAvailableRoom",
            "dataSrc": "",
        },
        "columns":[
            {"data":"room_id"},
            {"data":"room_number"},
            {"data":"floor"},
            {"data":"type_of_room"},
            {"data":"number_of_bed"},
            {"data":"max_person"},
            {"data":"price", "render": function (data, type, row) {
                return formatPrice(data);
            }},
            {"data":"details", "render": function (data, type, row) {
                return renderTruncated(data);
            }},
            {"data": "room_id",
                render: function (data, type, row) {
                    return '<button type="button" title="Update" data-bs-toggle="tooltip" data-bs-placement="top" onclick=viewRoomDetails('+data+') class="btn rounded-0 btn-outline-secondary btn-sm py-2 px-3"><i class="bi bi-pencil-square"></i></button> <button type="button" title="Activate Room" data-bs-toggle="tooltip" data-bs-placement="top" onclick=activateRoom('+data+') class="btn rounded-0 btn-outline-success btn-sm py-2 px-3"><i class="bi bi-toggle-on"></i></button>'
                }
            }
        ],
        order: [[1, 'asc']],
        drawCallback: initTooltips,
    });
    table.on('order.dt search.dt', function () {
        let i = 1;
        table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
        });
    }).draw();
    }
// FETCH NOT AVAILABLE ROOM FOR TABLE

// ADD ROOM
    $(document).ready(function () {
        $('#addRoomDetailsForm').on( 'submit' , function(e){
            e.preventDefault();
            var currentForm = $('#addRoomDetailsForm')[0];
            var data = new FormData(currentForm);
                $.ajax({
                    url: "/addRoom",
                    type:"POST",
                    method:"POST",
                    dataType: "text",
                    data:data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(response){
                        if(response == 1){
                            $("#addRoomDetailsForm").trigger("reset");
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'NEW ROOM HAS BEEN STORED',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }else if(response == 0){
                            Swal.fire(
                            'Added Failed',
                            'Sorry room has not stored',
                            'error'
                            )
                        }
                    },
                    error:function(error){
                        console.log(error)
                    }
                })
        });
    });
// ADD ROOM

// VIEW DETAILS OF ROOM
    function viewRoomDetails(id){
        $('#updateRoomModal').modal('show')
        $.ajax({
            url: '/viewRoomDetails',
            type: 'GET',
            dataType: 'json',
            data: {roomId: id},
        })
        .done(function(response) {
            $('#room_id').val(response.room_id),
            $('#roomNumber').val(response.room_number),
            $('#roomFloor').val(response.floor)
            $('#roomPricePerHour').val(response.price)
            $('#roomType').val(response.type_of_room)
            $('#roomBedNumber').val(response.number_of_bed)
            $('#roomMaxPerson').val(response.max_person)
            $('#detailsOfRoom').val(response.details)
            $('#roomPhoto').attr("src",response.photos)
        })
    }
// VIEW DETAILS OF ROOM

// UPDATE ROOM
    $(document).ready(function () {
        $('#updateRoomForm').on( 'submit' , function(e){
            e.preventDefault();
            var currentForm = $('#updateRoomForm')[0];
            var data = new FormData(currentForm);
            $.ajax({
                url: "/updateRoom",
                type:"post",
                method:"post",
                dataType: "text",
                data:data,
                cache: false,
                contentType: false,
                processData: false,
                success:function(response){
                    if(response == 1){
                        $('#updateRoomModal').modal('hide');
                        $('#availableRoom').DataTable().ajax.reload();
                        $('#notAvailableRoom').DataTable().ajax.reload();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'ROOM HAS BEEN UPDATED SUCCESSFULLY',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                },
                error:function(error){
                    console.log(error)
                }
            })
        });
    });
// UPDATE ROOM

// DEACTIVATE ROOM
    function deactivateRoom(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to DEACTIVATE this ROOM?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d72323',
            confirmButtonText: 'Yes, Continue'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                url: '/deactivateRoom',
                type: 'GET',
                dataType: 'json',
                data: {roomId: id},
            });
            Swal.fire({
                title: 'DEACTIVATED SUCCESSFULLY',
                icon: 'success',
                showConfirmButton: false,
                timer: 1000,
            }).then((result) => {
            if (result) {
                $('#availableRoom').DataTable().ajax.reload();
            }
            });
            }
        });
    }
// DEACTIVATE ROOM

// ACTIVATE ROOM
    function activateRoom(id){
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to ACTIVATE this ROOM?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d72323',
        confirmButtonText: 'Yes, Continue'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
            url: '/activateRoom',
            type: 'GET',
            dataType: 'json',
            data: {roomId: id},
        });
        Swal.fire({
            title: 'ACTIVATED SUCCESSFULLY',
            icon: 'success',
            showConfirmButton: false,
            timer: 1000,
        }).then((result) => {
        if (result) {
            $('#notAvailableRoom').DataTable().ajax.reload();
        }
        });
        }
    });
    }
// ACTIVATE ROOM