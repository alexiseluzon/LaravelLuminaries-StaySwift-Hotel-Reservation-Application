<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('cdn')
    {{-- CSS --}}
        <link href="{{ asset('/css/customerDashboard.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/sideBar.css') }}" rel="stylesheet">
        <link rel="shortcut icon" href="{{ URL('/img/logo.png')}}" type="image/x-icon">
    {{-- CSS --}}
    <title>StaySwift</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }

        #wrapper {
            display: flex;
            width: 100%;
        }

        #page-content-wrapper {
            width: 100%;
            padding: 2rem;
        }

        .navbar {
            background-color: #343a40;
            color: #ffffff;
            padding: 1rem;
        }

        .navbar h4 {
            margin: 0;
            color: #ffffff;
        }

        .navbar .nav-link {
            color: #ffffff;
        }

        .navbar .nav-link:hover {
            color: #dddddd;
        }

        .mainBar {
            padding: 2rem;
        }

        .card {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card .card-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card .card-body i {
            font-size: 2.5rem;
            color: #ff8c00;
        }

        .card .card-text {
            margin: 0;
        }

        .card .card-text.fw-bold {
            font-size: 1.5rem;
            color: #333333;
        }

        .card .card-text span {
            font-size: 0.875rem;
            color: #888888;
        }

        .shadow {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .icons {
            font-size: 3rem;
        }

        .bg-pending {
            background-color: #ffecb3;
        }

        .bg-cancelled {
            background-color: #ffcdd2;
        }

        .bg-unpaid {
            background-color: #ffe0b2;
        }

        .bg-completed {
            background-color: #c8e6c9;
        }

        .text-pending {
            color: #ff9800;
        }

        .text-cancelled {
            color: #f44336;
        }

        .text-unpaid {
            color: #ff5722;
        }

        .text-completed {
            color: #4caf50;
        }
    </style>
</head>
<body>

    <div class="d-flex" id="wrapper">
        {{-- SIDE NAV --}}
            @include('layouts.customerSidebar')
        {{-- SIDE NAV --}}

        {{-- MAIN CONTENT --}}
        <div id="page-content-wrapper">
            {{-- NAV BAR --}}
            <nav class="navbar navbar-expand-lg text-white border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-lg" id="sidebarToggle"><i class="fa-solid fa-bars icons"></i></button>
                    <h4 class="ms-2 pt-2">CUSTOMER DASHBOARD</h4>
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
            {{-- NAV BAR --}}

            {{-- MAIN CONTENT --}}
            <div class="container-fluid mainBar">
                <div class="row my-3">
                    <div class="col-lg-3 col-sm-12 mb-2">
                        <div class="card shadow bg-pending">
                            <div class="card-body">
                                <div class="col-3 text-center">
                                    <i class="bi bi-clock-history icons text-pending"></i>
                                </div>
                                <div class="col-9 text-center" style="line-height:19px; padding-top:1.5rem">
                                    <p class="card-text fw-bold text-pending" id="totalPendingReservation">0</p>
                                    <p class="card-text fw-bold text-pending" style="font-size: 13px;">PENDING RESERVATION</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12 mb-2">
                        <div class="card shadow bg-cancelled">
                            <div class="card-body">
                                <div class="col-3 text-center">
                                    <i class="bi bi-calendar2-x icons text-cancelled"></i>
                                </div>
                                <div class="col-9 text-center" style="line-height:19px; padding-top:1.4rem">
                                    <p class="card-text fw-bold text-cancelled" id="totalCancelReservation">0</p>
                                    <p class="card-text fw-bold text-cancelled" style="font-size: 13px;">CANCELLED RESERVATION</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12 mb-2">
                        <div class="card shadow bg-unpaid">
                            <div class="card-body">
                                <div class="col-3 text-center">
                                    <i class="bi bi-piggy-bank icons text-unpaid"></i>
                                </div>
                                <div class="col-9 text-center" style="line-height:19px; padding-top:1.4rem">
                                    <p class="card-text fw-bold text-unpaid" id="totalUnpaidReservation">0</p>
                                    <p class="card-text fw-bold text-unpaid" style="font-size: 13px;">UNPAID RESERVATION</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12 mb-2">
                        <div class="card shadow bg-completed">
                            <div class="card-body">
                                <div class="col-3 text-center">
                                    <i class="bi bi-building-check icons text-completed"></i>
                                </div>
                                <div class="col-9 text-center" style="line-height:19px; padding-top:1.4rem">
                                    <p class="card-text fw-bold text-completed" id="totalCompleteReservation">0</p>
                                    <p class="card-text fw-bold text-completed" style="font-size: 13px;">COMPLETED RESERVATION</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- MAIN CONTENT --}}
        </div>
    {{-- END MAIN CONTENT --}}
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
                success : function(data) {
                    $("#totalPendingReservation").html(data.totalPendingReservation);
                    $("#totalCancelReservation").html(data.totalCancelReservation);
                    $("#totalUnpaidReservation").html(data.totalUnpaidReservation);
                    $("#totalCompleteReservation").html(data.totalCompleteReservation);
                }
            })
        }

        // AUTOMATIC DELETE THE UNPAID RESERVATION
        if(window.location.href === 'http://127.0.0.1:8000/customerDashboard'){
            $.ajax({
                url: '/deleteUnpaidReservation',
                type: 'GET',
                dataType: 'json',
            })
            .done(function(response) {
                $('#ongoingReservationTable').DataTable().ajax.reload();
            })
        }
    </script>
    {{-- END JS --}}
</body>
</html>
