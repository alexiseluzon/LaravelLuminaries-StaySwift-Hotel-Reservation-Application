<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('cdn')
    <link href="{{ asset('/css/sideBar.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/customerDashboard.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ URL('/img/StaySwift Login no bg.png')}}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <title>StaySwift — Available Rooms</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #1a1612;
            color: #d4c4a8;
        }

        /* NAV */
        .navbar {
            background: #221e18 !important;
            border-color: #3a3228 !important;
        }
        .navbar h4 {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 300;
            letter-spacing: 0.22em;
            color: #e8dcc8;
            font-size: 18px;
        }
        .navbar .nav-link { color: #7a6a56 !important; font-size: 11px; letter-spacing: 0.12em; }

        /* FILTER */
        .mainBar { padding: 28px 24px; }

        .gold-line {
            height: 1px;
            background: linear-gradient(90deg, transparent, #c9a96e, transparent);
            margin: 20px 0 28px;
        }

        #filterForm .form-label {
            font-size: 8.5px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #7a6a56;
            margin-bottom: 6px;
        }

        #filterForm .form-select {
            background-color: #1a1612;
            border: 1px solid #3a3228;
            color: #d4c4a8;
            font-family: 'Montserrat', sans-serif;
            font-size: 12px;
            border-radius: 1px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        #filterForm .form-select:focus {
            border-color: #c9a96e;
            box-shadow: 0 0 0 3px rgba(201,169,110,0.1);
        }
        #filterForm .form-select option { background: #221e18; }

        /* ROOM CARDS */
        #showTotalRoom { margin-top: 28px; }

        .room-card {
            background: #221e18;
            border: 1px solid #3a3228;
            border-radius: 2px;
            overflow: hidden;
            transition: box-shadow 0.2s, border-color 0.2s;
            height: 100%;
        }
        .room-card:hover {
            border-color: #c9a96e;
            box-shadow: 0 4px 24px rgba(0,0,0,0.4);
        }

        .room-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }

        .room-card-body { padding: 20px; }

        .room-number {
            font-family: 'Cormorant Garamond', serif;
            font-size: 18px;
            font-weight: 300;
            color: #e8dcc8;
            letter-spacing: 0.1em;
            margin-bottom: 4px;
        }

        .room-type-badge {
            display: inline-block;
            font-size: 8px;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: #c9a96e;
            border: 1px solid #3a3228;
            padding: 3px 10px;
            margin-bottom: 14px;
        }

        .room-divider {
            height: 1px;
            background: #3a3228;
            margin: 12px 0;
        }

        .room-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 12px;
            margin-bottom: 14px;
        }

        .room-meta-item { }
        .room-meta-label {
            font-size: 7.5px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #7a6a56;
            display: block;
            margin-bottom: 2px;
        }
        .room-meta-value {
            font-size: 12px;
            color: #d4c4a8;
        }

        .room-price {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            font-weight: 300;
            color: #c9a96e;
            letter-spacing: 0.05em;
        }
        .room-price span { font-size: 12px; color: #7a6a56; font-family: 'Montserrat', sans-serif; }

        .room-details {
            font-size: 11px;
            color: #7a6a56;
            line-height: 1.6;
            margin: 10px 0 16px;
        }

        .book-btn {
            width: 100%;
            background: #c9a96e;
            color: #1a1612;
            border: none;
            padding: 11px;
            font-family: 'Montserrat', sans-serif;
            font-size: 9.5px;
            font-weight: 500;
            letter-spacing: 0.24em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.2s;
            border-radius: 1px;
        }
        .book-btn:hover { background: #e8cfa0; }

        /* MODAL */
        .modal-content {
            background: #221e18;
            border: 1px solid #3a3228;
            border-radius: 2px;
            color: #d4c4a8;
        }
        .modal-header {
            border-bottom: 1px solid #3a3228;
            padding: 20px 24px 16px;
        }
        .modal-title {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 300;
            font-size: 20px;
            letter-spacing: 0.18em;
            color: #e8dcc8 !important;
        }
        .btn-close { filter: invert(1) brightness(0.5); }
        .modal-body { padding: 24px; }
        .modal-footer {
            border-top: 1px solid #3a3228;
            padding: 16px 24px;
        }

        .modal-body .form-label {
            font-size: 8.5px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #7a6a56;
            margin-bottom: 6px;
        }
        .modal-body .form-control {
            background: #1a1612;
            border: 1px solid #3a3228;
            color: #d4c4a8;
            font-family: 'Montserrat', sans-serif;
            font-size: 13px;
            border-radius: 1px;
        }
        .modal-body .form-control:focus {
            border-color: #c9a96e;
            box-shadow: 0 0 0 3px rgba(201,169,110,0.1);
            background: #1e1a15;
            color: #d4c4a8;
        }
        /* date input icon color fix */
        .modal-body .form-control::-webkit-calendar-picker-indicator { filter: invert(0.6); cursor: pointer; }

        .modal-btn-close {
            background: transparent;
            border: 1px solid #3a3228;
            color: #7a6a56;
            font-family: 'Montserrat', sans-serif;
            font-size: 9.5px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            padding: 10px 20px;
            border-radius: 1px;
            transition: border-color 0.2s, color 0.2s;
        }
        .modal-btn-close:hover { border-color: #7a6a56; color: #d4c4a8; }

        .modal-btn-submit {
            background: #c9a96e;
            color: #1a1612;
            border: none;
            font-family: 'Montserrat', sans-serif;
            font-size: 9.5px;
            font-weight: 500;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            padding: 10px 24px;
            border-radius: 1px;
            transition: background 0.2s;
        }
        .modal-btn-submit:hover { background: #e8cfa0; }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            margin-top: 8rem;
            color: #4a4035;
        }
        .empty-state i { font-size: 40px; margin-bottom: 16px; display: block; }
        .empty-state p {
            font-size: 10px;
            letter-spacing: 0.22em;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        @include('layouts.customerSidebar')

        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-lg" id="sidebarToggle" style="color:#7a6a56"><i class="fa-solid fa-bars"></i></button>
                    <h4 class="me-3 me-lg-0 pt-2 ms-lg-2">Available Rooms</h4>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li>
                                <a class="nav-link me-3">
                                    {{ auth()->guard('userModel')->user()->firstname }}
                                    {{ auth()->guard('userModel')->user()->lastname }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid mainBar">
                <form id="filterForm" class="row g-3">
                    <div class="col-md-4">
                        <label for="capacityFilter" class="form-label">Room Capacity</label>
                        <select id="capacityFilter" class="form-select">
                            <option value="">All</option>
                            <option value="2">2 Persons</option>
                            <option value="3">3 Persons</option>
                            <option value="4">4 Persons</option>
                            <option value="6">6 Persons</option>
                            <option value="8">8 Persons</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="typeFilter" class="form-label">Room Type</label>
                        <select id="typeFilter" class="form-select">
                            <option value="">All</option>
                            <option value="Standard Room">Standard Room</option>
                            <option value="Deluxe Room">Deluxe Room</option>
                            <option value="Superior Room">Superior Room</option>
                            <option value="Junior Suite">Junior Suite</option>
                            <option value="Executive Suite">Executive Suite</option>
                            <option value="Family Room">Family Room</option>
                            <option value="Connecting Room">Connecting Room</option>
                            <option value="Accessible Room">Accessible Room</option>
                            <option value="Deluxe Suite">Deluxe Suite</option>
                            <option value="Presidential Suite">Presidential Suite</option>
                            <option value="Penthouse Suite">Penthouse Suite</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="sortFilter" class="form-label">Sort by Price</label>
                        <select id="sortFilter" class="form-select">
                            <option value="">None</option>
                            <option value="asc">Low to High</option>
                            <option value="desc">High to Low</option>
                        </select>
                    </div>
                </form>

                <div class="gold-line"></div>
                <div class="row g-3" id="showTotalRoom"></div>
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <div class="modal fade" id="reservationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Book a Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bookReservationForm" name="bookReservationForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label">Check In</label>
                                <input required type="date" class="form-control" id="checkInDate" name="checkInDate">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Check Out</label>
                                <input required type="date" class="form-control" id="checkOutDate" name="checkOutDate">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn-close" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="submitDateBooking" class="modal-btn-submit">Confirm Booking</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END MODAL --}}

    <script src="{{ asset('/js/customer/room.js') }}"></script>
    <script src="{{ asset('/js/logout.js') }}"></script>
    <script>
        const CUTOFF_HOUR = 14;

        function getPHToday() {
            const ph = new Date(new Date().toLocaleString('en-US', { timeZone: 'Asia/Manila' }));
            const cutoffPassed = ph.getHours() >= CUTOFF_HOUR;
            ph.setDate(ph.getDate() + (cutoffPassed ? 1 : 0));
            return `${ph.getFullYear()}-${String(ph.getMonth()+1).padStart(2,'0')}-${String(ph.getDate()).padStart(2,'0')}`;
        }

        function addOneDay(dateStr) {
            const [y, m, d] = dateStr.split('-').map(Number);
            const next = new Date(y, m - 1, d + 1);
            return `${next.getFullYear()}-${String(next.getMonth()+1).padStart(2,'0')}-${String(next.getDate()).padStart(2,'0')}`;
        }

        function setDateConstraints() {
            const minDate = getPHToday();
            const checkIn = document.getElementById('checkInDate');
            const checkOut = document.getElementById('checkOutDate');
            const minCheckOut = addOneDay(minDate);

            checkIn.min = minDate;
            checkIn.value = minDate;
            checkOut.min = minCheckOut;
            checkOut.value = minCheckOut;

            checkIn.addEventListener('change', function () {
                if (!this.value) return;
                const minCheckOut = addOneDay(this.value);
                checkOut.min = minCheckOut;
                checkOut.value = minCheckOut;
            });
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

        function fetchRooms(capacity = '', type = '', sort = '') {
            const url = new URL('{{ url('/rooms/filter') }}');
            url.search = new URLSearchParams({ capacity, type, sort }).toString();

            fetch(url)
                .then(r => r.json())
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

        document.getElementById('filterForm').addEventListener('change', function () {
            fetchRooms(
                document.getElementById('capacityFilter').value,
                document.getElementById('typeFilter').value,
                document.getElementById('sortFilter').value
            );
        });

        document.addEventListener('DOMContentLoaded', function () {
            setDateConstraints();
            fetchRooms(); // use fetchRooms for initial load for consistent card template
        });
    </script>
</body>
</html>