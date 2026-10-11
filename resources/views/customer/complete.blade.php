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
    <link href="{{ asset('/css/swal-theme.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ URL('/img/StaySwift Logo no bg.png')}}" type="image/x-icon">
    <title>StaySwift</title>
    <style>
        body, html { background-color: #1a1612 !important; color: #d4c4a8; }
        .navbar { background-color: #221e18 !important; border-color: #3a3228 !important; }
        #page-content-wrapper { background-color: #1a1612; }
        h4 { color: #e8dcc8; letter-spacing: 0.15em; }
        .mainBar { background-color: #1a1612; }

        .complete-card {
            background: #221e18;
            border: 1px solid #3a3228;
            border-radius: 2px;
            overflow: hidden;
            width: 100%;
        }
        .complete-card img { height: 230px; width: 100%; object-fit: cover; display: block; border-bottom: 1px solid #3a3228; }
        .complete-card-body { padding: 20px 24px; }
        .complete-room-type {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            color: #e8dcc8;
            letter-spacing: 0.08em;
            margin-bottom: 16px;
        }
        .complete-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px; }
        .complete-meta-label { font-size: 10px; color: #7a6a56; letter-spacing: 0.08em; text-transform: uppercase; }
        .complete-meta-value { color: #d4c4a8; font-size: 12px; margin-top: 3px; text-transform: none; }
        .complete-price { color: #c9a96e; font-size: 13px; margin-top: 3px; text-transform: none; }
        .complete-divider { border-top: 1px solid #3a3228; margin: 14px 0; }
        .complete-details-label { font-size: 10px; color: #7a6a56; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 6px; }
        .complete-details-text { font-size: 12px; color: #d4c4a8; margin-bottom: 14px; line-height: 1.6; }

        .empty-state { text-align: center; margin-top: 8rem; color: #4a4035; }
        .empty-state i { font-size: 40px; margin-bottom: 16px; display: block; }
        .empty-state p { font-size: 10px; letter-spacing: 0.22em; text-transform: uppercase; }
    </style>
</head>
<body>

    <div class="d-flex" id="wrapper">
        @include('layouts.customerSidebar')

        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg text-white border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-lg" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
                    <h4 class="ms-2 pt-2">COMPLETED RESERVATION</h4>
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

            <div class="container-fluid mainBar">
                <div class="row g-2" id="showCompleteReservation"></div>
            </div>
        </div>
    </div>

    <script src="{{ asset('/js/customer/complete.js') }}"></script>
    <script src="{{ asset('/js/global.js') }}"></script>
    <script src="{{ asset('/js/dateTime.js') }}"></script>
    <script src="{{ asset('/js/logout.js') }}"></script>
    <script>
        $(document).ready(function () {
            showCompleteReservationPerUser();
        });

        function showCompleteReservationPerUser() {
            $.ajax({
                url: "/getCompleteBookPerUser",
                method: 'GET',
                success: function (data) {
                    $("#showCompleteReservation").html(data);
                }
            });
        }
    </script>
</body>
</html>