<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <title>StaySwift</title>
        <!-- CSS -->
            <link rel="shortcut icon" href="<?php echo e(URL('/img/StaySwift Logo no bg.png')); ?>" type="image/x-icon">
            <link href="<?php echo e(asset('/css/adminDashboard.css')); ?>" rel="stylesheet">
            <link href="<?php echo e(asset('/css/reservationTheme.css')); ?>" rel="stylesheet">
        <!-- CSS -->
    <?php echo $__env->make('cdn', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body>
    <div class="d-flex" id="wrapper">

        <!-- SIDE NAV -->
            <?php echo $__env->make('layouts.adminSidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- SIDE NAV -->

        <!-- MAIN CONTENT -->
            <div id="page-content-wrapper">
                <!-- NAV BAR -->
                    <nav class="navbar navbar-expand-lg border-bottom">
                        <div class="container-fluid">
                            <h4 class="ms-2"> MANAGE RESERVATION</h4>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                                    <li>
                                        <a class="nav-link me-3">
                                            <span><?php echo e(auth()->guard('userModel')->user()->firstname); ?></span>
                                            <span><?php echo e(auth()->guard('userModel')->user()->lastname); ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                <!-- NAV BAR -->

                <!-- MAIN CONTENT -->
                    <div class="container-fluid mainBar">
                        <div class="container-fluid">
                            <div class="container-fluid px-5 py-4 reservation-panel rounded shadow-lg">
                                <ul class="nav nav-tabs mb-4">
                                    <li class="nav-item">
                                        <a class="nav-link" href="/adminReservation">Pending Reservation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="/adminOnGoingReservation">On-Going Reservation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/adminCancelledReservation">Cancelled Reservation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/adminUnpaidReservation">Unpaid Reservation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/adminCompletedReservation">Completed Reservation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/adminUnattendedReservation">Unattended Reservation</a>
                                    </li>
                                </ul>

                                <div class="d-flex gap-2 mb-3">
                                    <select id="searchColumn" class="form-select form-select-sm w-auto">
                                        <option value="1">Customer Name</option>
                                        <option value="2">Room</option>
                                        <option value="3">Check In</option>
                                        <option value="4">Check Out</option>
                                    </select>
                                    <input type="text" id="searchInput" class="form-control form-control-sm w-auto" placeholder="Search...">
                                </div>

                                <table id="ongoingReservationTable" class="table table-sm table-bordered text-center align-middle">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Customer Name</th>
                                            <th class="text-center">Room</th>
                                            <th class="text-center">Check In</th>
                                            <th class="text-center">Check Out</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                </table>

                            </div>
                        </div>
                    </div>
                <!-- MAIN CONTENT -->
            </div>
        <!-- MAIN CONTENT -->
    </div>

        <!-- JS -->
            <script src="<?php echo e(asset('/js/admin/reservation.js')); ?>"></script>
            <script src="<?php echo e(asset('/js/dateTime.js')); ?>"></script>
            <script src="<?php echo e(asset('/js/logout.js')); ?>"></script>
        <!-- JS -->
</body>
</html>
<?php /**PATH C:\xampp\htdocs\LaravelLuminaries-StaySwift-Hotel-Reservation-Application\resources\views/admin/ongoingReservation.blade.php ENDPATH**/ ?>