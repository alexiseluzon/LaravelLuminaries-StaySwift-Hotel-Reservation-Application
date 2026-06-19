function bookReservation(id) {
    $.ajax({
        url: "/getRoomBookedDates",
        type: "GET",
        dataType: "json",
        data: { roomId: id },
        success: function(bookedDates) {
            const disabledRanges = bookedDates.map(b => ({
                from: moment(b.start_dataTime).format('YYYY-MM-DD'),
                to: moment(b.end_dateTime).subtract(1, 'day').format('YYYY-MM-DD')
            }));

            $('#reservationModal').modal('show');
            setDateConstraints(disabledRanges);

            $('#submitDateBooking').off('click').on('click', function() {
                var checkInDateTime = $("#checkInDate").val();
                var checkOutDateTime = $("#checkOutDate").val();
                $.ajax({
                    url: "/bookReservation",
                    type: "POST",
                    dataType: "json",
                    data: { roomId: id, checkInDateTime: checkInDateTime, checkOutDateTime: checkOutDateTime },
                    success: function(response) {
                        if (response.status == 1) {
                            fetchRooms();
                            $("#bookReservationForm").trigger("reset");
                            $('#reservationModal').modal('hide');
                            Swal.fire({
                                position: 'center', icon: 'success',
                                title: 'RESERVATION HAS BEEN SUBMITTED',
                                showConfirmButton: false, timer: 1500
                            });
                        } else if (response.status == 0) {
                            Swal.fire('Added Failed', 'Sorry operation has not stored', 'error');
                        } else if (response.status == 4) {
                            Swal.fire('Invalid Check In', 'Please check the date and time of the CHECK IN', 'error');
                        } else if (response.status == 3) {
                            Swal.fire('Invalid Check Out', 'Please check the date and time of the CHECK OUT', 'error');
                        } else if (response.status == 2) {
                            Swal.fire('Invalid Date and Time', 'The date of both CHECK IN and CHECK OUT must not be the same', 'error');
                        } else if (response.status == 5) {
                            Swal.fire({
                                icon: 'error', title: 'BOOK FAILED',
                                text: 'Please complete all of your information.',
                                footer: '<a href="/customerAccount">DIRECT ME TO MANAGE ACCOUNT</a>'
                            });
                        } else if (response.status == 6) {
                            Swal.fire('Room Unavailable', 'This room is already reserved for the selected dates.', 'error');
                        } else if (response.status == 7) {
                            Swal.fire('Duplicate Booking', 'You already have a reservation for this room on the selected dates.', 'error');
                        }
                    },
                    error: function(error) { console.log(error); }
                });
            });
        },
        error: function(error) { console.log(error); }
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
                fetchRoom();            
            }
            });
            }
        });
    }
// FUNCTION FOR BOOKING

    function fetchRooms(capacity = '', type = '', sort = '') {
        const url = new URL('/rooms/filter', window.location.origin);
        url.search = new URLSearchParams({ capacity, type, sort }).toString();
        fetch(url)
            .then(r => {
                if (r.status === 401 || r.status === 419) {
                    window.location = '/login';
                    return;
                }
                return r.json();
            })
            .then(data => {
                const container = document.getElementById('showTotalRoom');
                if (!data.rooms.length) {
                    container.innerHTML = `
                        <div class="empty-state col-12">
                            <i class="fa-solid fa-door-open"></i>
                            <p>No rooms available</p>
                        </div>`;
                    return;
                }
                container.innerHTML = data.rooms.map(renderRoomCard).join('');
            })
            .catch(err => console.error('Error fetching rooms:', err));
    }

    function renderRoomCard(room) {
        return `
            <div class="col-md-6 col-lg-4 d-flex">
                <div class="room-card w-100">
                    <img src="${room.photos}" alt="Room ${room.room_number}">
                    <div class="room-card-body">
                        <div class="room-number">Room ${room.room_number}</div>
                        <div class="room-type-badge">${room.type_of_room}</div>
                        <div class="room-meta">
                            <div class="room-meta-item">
                                <span class="room-meta-label">Floor</span>
                                <span class="room-meta-value">${room.floor}</span>
                            </div>
                            <div class="room-meta-item">
                                <span class="room-meta-label">Beds</span>
                                <span class="room-meta-value">${room.number_of_bed}</span>
                            </div>
                            <div class="room-meta-item">
                                <span class="room-meta-label">Max Guests</span>
                                <span class="room-meta-value">${room.max_person} Persons</span>
                            </div>
                        </div>
                        <div class="room-divider"></div>
                        <div class="room-details">${room.details}</div>
                        <div class="room-price">₱${Number(room.price).toLocaleString()}<span> / night</span></div>
                        <div class="room-divider"></div>
                        <button onclick="bookReservation(${room.room_id})" type="button" class="book-btn">Book Now</button>
                    </div>
                </div>
            </div>`;
    }