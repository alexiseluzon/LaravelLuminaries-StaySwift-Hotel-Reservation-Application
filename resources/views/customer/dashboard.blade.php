<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('cdn')
    <link href="{{ asset('/css/customerDashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/sideBar.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ URL('/img/StaySwift Logo no bg.png')}}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <title>StaySwift — Dashboard</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body, html {
            height: 100%;
            font-family: 'Montserrat', sans-serif;
            background-color: #1a1612;
            color: #d4c4a8;
        }

        #wrapper {
            display: flex;
            width: 100%;
        }

        #page-content-wrapper {
            width: 100%;
            min-height: 100vh;
        }

        /* NAVBAR */
        .navbar {
            background-color: #221e18;
            border-bottom: 1px solid #3a3228 !important;
            padding: 0 1.5rem;
            height: 60px;
        }

        .navbar h4 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 18px;
            font-weight: 300;
            color: #e8dcc8;
            letter-spacing: 0.18em;
            margin: 0;
        }

        .navbar .nav-link {
            font-size: 11px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #7a6a56 !important;
        }

        .navbar .nav-link:hover { color: #c9a96e !important; }

        .navbar .btn-lg {
            color: #7a6a56;
            background: transparent;
            border: none;
            padding: 0;
            font-size: 1.4rem;
            line-height: 1;
        }
        .navbar .btn-lg:hover { color: #c9a96e; }

        /* MAIN */
        .mainBar { padding: 2rem; }

        /* STAT CARDS */
        .stat-card {
            background: #221e18;
            border: 1px solid #3a3228;
            border-radius: 2px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            height: 100%;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover {
            border-color: #c9a96e;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }

        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 1px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 1.6rem;
        }

        .stat-info { flex: 1; }

        .stat-count {
            font-family: 'Cormorant Garamond', serif;
            font-size: 32px;
            font-weight: 400;
            line-height: 1;
            display: block;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 8px;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: #7a6a56;
        }

        /* STATUS COLORS */
        .stat-pending   .stat-icon { background: rgba(201,169,110,0.1); color: #c9a96e; }
        .stat-pending   .stat-count { color: #c9a96e; }
        .stat-pending   .stat-icon-bar { background: #c9a96e; }

        .stat-cancelled .stat-icon { background: rgba(180,80,80,0.12); color: #c97070; }
        .stat-cancelled .stat-count { color: #c97070; }

        .stat-unpaid    .stat-icon { background: rgba(180,130,70,0.1); color: #c9996e; }
        .stat-unpaid    .stat-count { color: #c9996e; }

        .stat-completed .stat-icon { background: rgba(100,160,100,0.1); color: #7ab87a; }
        .stat-completed .stat-count { color: #7ab87a; }

        .stat-card-border-pending   { border-left: 2px solid #c9a96e; }
        .stat-card-border-cancelled { border-left: 2px solid #c97070; }
        .stat-card-border-unpaid    { border-left: 2px solid #c9996e; }
        .stat-card-border-completed { border-left: 2px solid #7ab87a; }
    </style>
</head>
<body>

<div class="d-flex" id="wrapper">
    {{-- SIDE NAV --}}
    @include('layouts.customerSidebar')
    {{-- SIDE NAV --}}

    <div id="page-content-wrapper">
        {{-- NAVBAR --}}
        <nav class="navbar navbar-expand-lg border-bottom">
            <div class="container-fluid">
                <button class="btn btn-lg" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
                <h4 class="ms-2">Customer Dashboard</h4>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                        <li>
                            <a class="nav-link me-3">
                                <span>{{ auth()->guard('userModel')->user()->firstname }}</span>
                                <span>{{ auth()->guard('userModel')->user()->lastname }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        {{-- NAVBAR --}}

        {{-- MAIN --}}
        <div class="container-fluid mainBar">
            <div class="row my-3">
                <div class="col-lg-3 col-sm-12 mb-3">
                    <div class="stat-card stat-pending stat-card-border-pending">
                        <div class="stat-icon"><i class="bi bi-clock-history"></i></div>
                        <div class="stat-info">
                            <span class="stat-count" id="totalPendingReservation">0</span>
                            <span class="stat-label">Pending Reservation</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-12 mb-3">
                    <div class="stat-card stat-cancelled stat-card-border-cancelled">
                        <div class="stat-icon"><i class="bi bi-calendar2-x"></i></div>
                        <div class="stat-info">
                            <span class="stat-count" id="totalCancelReservation">0</span>
                            <span class="stat-label">Cancelled Reservation</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-12 mb-3">
                    <div class="stat-card stat-unpaid stat-card-border-unpaid">
                        <div class="stat-icon"><i class="bi bi-piggy-bank"></i></div>
                        <div class="stat-info">
                            <span class="stat-count" id="totalUnpaidReservation">0</span>
                            <span class="stat-label">Unpaid Reservation</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-12 mb-3">
                    <div class="stat-card stat-completed stat-card-border-completed">
                        <div class="stat-icon"><i class="bi bi-building-check"></i></div>
                        <div class="stat-info">
                            <span class="stat-count" id="totalCompleteReservation">0</span>
                            <span class="stat-label">Completed Reservation</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- MAIN --}}
    </div>
</div>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('/js/dateTime.js') }}"></script>
<script src="{{ asset('/js/logout.js') }}"></script>
<script>
    $(document).ready(function(){
        getAllTotalForCustomer();
    });

    function getAllTotalForCustomer(){
        $.ajax({
            url: '/getAllTotalForCustomer',
            method: 'GET',
            success: function(data) {
                $("#totalPendingReservation").html(data.totalPendingReservation);
                $("#totalCancelReservation").html(data.totalCancelReservation);
                $("#totalUnpaidReservation").html(data.totalUnpaidReservation);
                $("#totalCompleteReservation").html(data.totalCompleteReservation);
            }
        });
    }

    // if(window.location.href === 'http://127.0.0.1:8000/customerDashboard'){
    //     $.ajax({
    //         url: '/deleteUnpaidReservation',
    //         type: 'GET',
    //         dataType: 'json',
    //     })
    //     .done(function(response) {
    //         $('#ongoingReservationTable').DataTable().ajax.reload();
    //     });
    // }
</script>
{{-- END JS --}}
</body>
</html>