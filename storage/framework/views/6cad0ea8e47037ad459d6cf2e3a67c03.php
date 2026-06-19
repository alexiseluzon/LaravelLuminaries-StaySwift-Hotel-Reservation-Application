<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php echo $__env->make('cdn', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
        <link href="<?php echo e(asset('/css/customerDashboard.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('/css/sideBar.css')); ?>" rel="stylesheet">
        <link rel="shortcut icon" href="<?php echo e(URL('/img/logo.png')); ?>" type="image/x-icon">
    
    <title>StaySwift</title>
</head>
<body>

    <div class="d-flex" id="wrapper">
        
            <?php echo $__env->make('layouts.customerSidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        

        
            <div id="page-content-wrapper">
                
                    <nav class="navbar navbar-expand-lg text-white border-bottom">
                        <div class="container-fluid">
                            <button class="btn btn-lg" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
                            <h4 class="ms-2 pt-2">MY RESERVATION</h4>
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
                

                
                    <div class="container-fluid mainBar">
                        <ul class="nav nav-tabs mb-4 mx-4">
                            <li class="nav-item">
                                <a class="nav-link" href="/customerReservation">Pending Reservation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Accept Reservation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/customerDeclinedReservation">Declined Reservation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/customerUnpaidReservation">Unpaid Reservation</a>
                            </li>
                        </ul>
                        <div class="row g-2" id="showAcceptReservation"></div>
                    </div>
                
            </div>
        
    </div>

    
        <script>
            $(document).ready(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                showAcceptBookingPerUser();
                function showAcceptBookingPerUser(){
                    $.ajax({
                        url: "/getAcceptBookPerUser",
                        method: 'GET',
                        success : function(data) {
                            $("#showAcceptReservation").html(data);
                        }
                    })
                }
            });
        </script>
        <script src="<?php echo e(asset('/js/dateTime.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/logout.js')); ?>"></script>
    
</body>
</html>
<?php /**PATH C:\xampp\htdocs\LaravelLuminaries-StaySwift-Hotel-Reservation-Application\resources\views/customer/acceptReservation.blade.php ENDPATH**/ ?>