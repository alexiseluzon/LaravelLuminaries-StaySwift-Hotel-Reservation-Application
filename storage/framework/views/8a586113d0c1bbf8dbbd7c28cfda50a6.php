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
                <link href="<?php echo e(asset('/css/sideBar.css')); ?>" rel="stylesheet">
                <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
            <!-- CSS -->
        <?php echo $__env->make('cdn', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        
            body, html { height: 100%; font-family: 'Montserrat', sans-serif; background-color: #1a1612; color: #d4c4a8; }
        
            #page-content-wrapper { width: 100%; min-height: 100vh; }
        
            /* NAVBAR */
            .navbar { background-color: #221e18 !important; border-bottom: 1px solid #3a3228 !important; padding: 0 1.5rem; height: 60px; }
            .navbar h4 { font-family: 'Cormorant Garamond', serif; font-size: 18px; font-weight: 300; color: #e8dcc8 !important; letter-spacing: 0.18em; margin: 0; }
            .navbar .nav-link { font-size: 11px; letter-spacing: 0.12em; text-transform: uppercase; color: #7a6a56 !important; }
            .navbar .nav-link:hover { color: #c9a96e !important; }
        
            /* MAIN */
            .mainBar { padding: 2rem; }
        
            /* STAT CARDS */
            .stat-card {
                background: #221e18; border: 1px solid #3a3228; border-radius: 2px;
                padding: 20px 24px; display: flex; align-items: center; gap: 16px;
                height: 100%; transition: border-color 0.2s, box-shadow 0.2s;
            }
            .stat-card:hover { border-color: #c9a96e; box-shadow: 0 4px 20px rgba(0,0,0,0.3); }
            .stat-icon { width: 48px; height: 48px; border-radius: 1px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.6rem; }
            .stat-info { flex: 1; }
            .stat-count { font-family: 'Cormorant Garamond', serif; font-size: 32px; font-weight: 400; line-height: 1; display: block; margin-bottom: 4px; }
            .stat-label { font-size: 8px; letter-spacing: 0.22em; text-transform: uppercase; color: #7a6a56; }
        
            /* STATUS COLORS */
            .stat-pending .stat-icon   { background: rgba(201,169,110,0.1); color: #c9a96e; }
            .stat-pending .stat-count  { color: #c9a96e; }
            .stat-ongoing .stat-icon   { background: rgba(100,160,100,0.1); color: #7ab87a; }
            .stat-ongoing .stat-count  { color: #7ab87a; }
            .stat-completed .stat-icon { background: rgba(122,184,255,0.1); color: #7ab8ff; }
            .stat-completed .stat-count{ color: #7ab8ff; }
            .stat-customers .stat-icon { background: rgba(180,130,70,0.1); color: #c9996e; }
            .stat-customers .stat-count{ color: #c9996e; }
        
            .stat-card-border-pending   { border-left: 2px solid #c9a96e; }
            .stat-card-border-ongoing   { border-left: 2px solid #7ab87a; }
            .stat-card-border-completed { border-left: 2px solid #7ab8ff; }
            .stat-card-border-customers { border-left: 2px solid #c9996e; }
        
            /* CHART */
            .chart-card { background: #221e18; border: 1px solid #3a3228; border-radius: 2px; padding: 1.5rem; }
        
            /* SWAL */
            .swal2-popup { background: #221e18 !important; border: 1px solid #3a3228 !important; border-radius: 0 !important; color: #d4c4a8 !important; font-family: 'Montserrat', sans-serif !important; }
            .swal2-title { color: #e8dcc8 !important; font-family: 'Cormorant Garamond', serif !important; font-weight: 400 !important; letter-spacing: 0.1em !important; }
            .swal2-html-container { color: #7a6a56 !important; font-size: 12px !important; }
            .swal2-confirm { background: #c9a96e !important; color: #1a1612 !important; border-radius: 0 !important; font-size: 10px !important; font-weight: 500 !important; letter-spacing: 0.2em !important; text-transform: uppercase !important; padding: 11px 28px !important; border: none !important; }
            .swal2-confirm:hover { background: #e8cfa0 !important; }
            .swal2-cancel { background: transparent !important; color: #c9a96e !important; border: 1px solid #3a3228 !important; border-radius: 0 !important; font-size: 10px !important; font-weight: 500 !important; letter-spacing: 0.2em !important; text-transform: uppercase !important; padding: 11px 28px !important; }
            .swal2-cancel:hover { border-color: #c9a96e !important; }
            .swal2-icon.swal2-question { border-color: #c9a96e !important; color: #c9a96e !important; }
            .swal2-icon.swal2-success { border-color: #c9a96e !important; }
            .swal2-icon.swal2-success [class^='swal2-success-line'] { background: #c9a96e !important; }
            .swal2-icon.swal2-success .swal2-success-ring { border-color: #c9a96e !important; }
        </style>
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            
            <?php echo $__env->make('layouts.adminSidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
            <div id="page-content-wrapper">
                
                    <nav class="navbar navbar-expand-lg border-bottom">
                        <div class="container-fluid">
                            <h4 class="ms-2"> Admin Dashboard</h4>
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
                        <div class="row mb-3">
                            <div class="col-lg-3 col-sm-12 mb-3">
                                <div class="stat-card stat-pending stat-card-border-pending">
                                    <div class="stat-icon"><i class="bi bi-calendar-event"></i></div>
                                    <div class="stat-info">
                                        <span class="stat-count" id="totalPendingReservation">0</span>
                                        <span class="stat-label">Pending Reservation</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12 mb-3">
                                <div class="stat-card stat-ongoing stat-card-border-ongoing">
                                    <div class="stat-icon"><i class="bi bi-calendar-check"></i></div>
                                    <div class="stat-info">
                                        <span class="stat-count" id="totalOnGoingReservation">0</span>
                                        <span class="stat-label">On-Going Reservation</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12 mb-3">
                                <div class="stat-card stat-completed stat-card-border-completed">
                                    <div class="stat-icon"><i class="bi bi-person-workspace"></i></div>
                                    <div class="stat-info">
                                        <span class="stat-count" id="totalCompletedReservation">0</span>
                                        <span class="stat-label">Completed Reservation</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12 mb-3">
                                <div class="stat-card stat-customers stat-card-border-customers">
                                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                                    <div class="stat-info">
                                        <span class="stat-count" id="totalCustomer">0</span>
                                        <span class="stat-label">Total Customers</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 mt-2 border-2 shadow">
                            
                            <div class="chart-card mb-3 shadow">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                <!-- MAIN CONTENT -->
            </div>
        </div>

            <!-- JS -->
                <script src="<?php echo e(asset('/js/admin/dashboard.js')); ?>"></script>
                <script src="<?php echo e(asset('/js/dateTime.js')); ?>"></script>
                <script src="<?php echo e(asset('/js/logout.js')); ?>"></script>
    </body>
</html><?php /**PATH C:\xampp\htdocs\LaravelLuminaries-StaySwift-Hotel-Reservation-Application\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>