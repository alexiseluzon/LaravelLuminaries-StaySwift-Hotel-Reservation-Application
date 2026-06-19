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
    <style>
        body, html { background-color: #1a1612 !important; color: #d4c4a8; }
        .navbar { background-color: #221e18 !important; border-color: #3a3228 !important; }
        #page-content-wrapper { background-color: #1a1612; }
        h4 { color: #e8dcc8; letter-spacing: 0.15em; }
        .mainBar { background-color: #1a1612; }

        /* SWAL THEME */
        .swal2-popup {
            background: #221e18 !important;
            border: 1px solid #3a3228 !important;
            border-radius: 0 !important;
            color: #d4c4a8 !important;
            font-family: 'Montserrat', sans-serif !important;
        }
        .swal2-title {
            color: #e8dcc8 !important;
            font-family: 'Cormorant Garamond', serif !important;
            font-weight: 400 !important;
            letter-spacing: 0.1em !important;
        }
        .swal2-html-container, .swal2-content {
            color: #7a6a56 !important;
            font-size: 12px !important;
        }
        .swal2-textarea, .swal2-input {
            background: #1a1612 !important;
            border: 1px solid #3a3228 !important;
            color: #d4c4a8 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
        }
        .swal2-textarea:focus, .swal2-input:focus {
            border-color: #c9a96e !important;
            outline: none !important;
        }
        .swal2-checkbox { color: #d4c4a8 !important; }
        .swal2-checkbox input { accent-color: #c9a96e; }
        .swal2-confirm {
            background: #c9a96e !important;
            color: #1a1612 !important;
            border-radius: 0 !important;
            font-family: 'Montserrat', sans-serif !important;
            font-size: 10px !important;
            font-weight: 500 !important;
            letter-spacing: 0.2em !important;
            text-transform: uppercase !important;
            padding: 11px 28px !important;
            border: none !important;
        }
        .swal2-confirm:hover { background: #e8cfa0 !important; }
        .swal2-cancel {
            background: transparent !important;
            color: #c9a96e !important;
            border: 1px solid #3a3228 !important;
            border-radius: 0 !important;
            font-family: 'Montserrat', sans-serif !important;
            font-size: 10px !important;
            font-weight: 500 !important;
            letter-spacing: 0.2em !important;
            text-transform: uppercase !important;
            padding: 11px 28px !important;
        }
        .swal2-cancel:hover { border-color: #c9a96e !important; }
        .swal2-icon { border-color: #3a3228 !important; }
        .swal2-icon.swal2-question { border-color: #c9a96e !important; color: #c9a96e !important; }
        .swal2-icon.swal2-success { border-color: #c9a96e !important; }
        .swal2-icon.swal2-success [class^='swal2-success-line'] { background: #c9a96e !important; }
        .swal2-icon.swal2-success .swal2-success-ring { border-color: #c9a96e !important; }
        .swal2-icon.swal2-warning { border-color: #c9a96e !important; color: #c9a96e !important; }
        .swal2-label {
            color: #d4c4a8 !important;
        }
        .swal2-label a {
            color: #c9a96e !important;
        }
        .swal2-checkbox {
            background: transparent !important;
        }
    </style>
</head>
<body>

    <div class="d-flex" id="wrapper">
        
            <?php echo $__env->make('layouts.customerSidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        

        
            <div id="page-content-wrapper">
                
                    <nav class="navbar navbar-expand-lg text-white border-bottom">
                        <div class="container-fluid">
                            <button class="btn btn-lg" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
                            <h4 class="ms-2 pt-2">PENDING RESERVATION</h4>
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
                        <div class="row g-2" id="showPendingReservation"></div>
                    </div>
                
            </div>
        
    </div>

    
        <script>
            $(document).ready(function(){
                showBookingPerUser();
            });
            function showBookingPerUser(){
                    $.ajax({
                        url: "/getBookPerUser",
                        method: 'GET',
                        success : function(data) {
                            $("#showPendingReservation").html(data);
                        }
                    })
                }
                function cancelReservation(id) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to cancel this booking?",
                        icon: 'question',
                        input: "checkbox",
                        inputValue: 1,
                        inputPlaceholder: `I read the <a href='notesRemarks'>notes and remarks</a>.`,
                        confirmButtonText: `Continue&nbsp;<i class="fa fa-arrow-right"></i>`,
                        inputValidator: (result) => !result && "You need to read the notes and remarks before cancelling."
                    }).then(({ value: accepted }) => {
                        if (!accepted) return;

                        Swal.fire({
                            input: 'textarea',
                            title: 'Reason for Cancelling?',
                            text: "This cannot be reverted once submitted.",
                            inputPlaceholder: 'Type your reason here...',
                            showCancelButton: true,
                            didOpen: () => {
                                const confirmBtn = Swal.getConfirmButton();
                                const textarea = Swal.getInput();
                                confirmBtn.disabled = true;
                                textarea.addEventListener('input', () => {
                                    confirmBtn.disabled = !textarea.value.trim();
                                });
                            }
                        }).then(({ value: reason }) => {
                            if (!reason || !reason.trim()) {
                                Swal.fire({ icon: 'warning', title: 'Reason Required', text: 'Please provide a reason for cancelling.' });
                                return;
                            }
                            $.ajax({
                                url: '/cancelReservation',
                                type: 'POST',
                                data: { reason, reservationId: id },
                                success: function (response) {
                                    if (response.success) {
                                        Swal.fire({ title: 'Cancelled Successfully', icon: 'success', timer: 1000, showConfirmButton: false })
                                            .then(() => showBookingPerUser());
                                    } else {
                                        Swal.fire({ icon: 'error', title: 'Cancellation Failed', text: response.message ?? 'Something went wrong.' });
                                    }
                                }
                            });
                        });
                    });
                }
        </script>
        <script src="<?php echo e(asset('/js/dateTime.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/global.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/logout.js')); ?>"></script>
    
</body>
</html>
<?php /**PATH C:\xampp\htdocs\LaravelLuminaries-StaySwift-Hotel-Reservation-Application\resources\views/customer/reservation.blade.php ENDPATH**/ ?>