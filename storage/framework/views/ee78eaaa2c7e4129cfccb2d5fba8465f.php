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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <title>StaySwift</title>
    <style>
        body, html { background-color: #1a1612 !important; color: #d4c4a8; }
        .navbar { background-color: #221e18 !important; border-color: #3a3228 !important; }
        #page-content-wrapper { background-color: #1a1612; }
        h4 { color: #e8dcc8; letter-spacing: 0.15em; }
        .mainBar { background-color: #1a1612; }

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
        .swal2-html-container, .swal2-content { color: #7a6a56 !important; font-size: 12px !important; }
        .swal2-textarea, .swal2-input {
            background: #1a1612 !important;
            border: 1px solid #3a3228 !important;
            color: #d4c4a8 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
        }
        .swal2-textarea:focus, .swal2-input:focus { border-color: #c9a96e !important; outline: none !important; }
        .swal2-checkbox { background: transparent !important; color: #d4c4a8 !important; }
        .swal2-checkbox input { accent-color: #c9a96e; }
        .swal2-label { color: #d4c4a8 !important; }
        .swal2-label a { color: #c9a96e !important; }
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
        .swal2-icon.swal2-question { border-color: #c9a96e !important; color: #c9a96e !important; }
        .swal2-icon.swal2-success { border-color: #c9a96e !important; }
        .swal2-icon.swal2-success [class^='swal2-success-line'] { background: #c9a96e !important; }
        .swal2-icon.swal2-success .swal2-success-ring { border-color: #c9a96e !important; }
        .swal2-icon.swal2-warning { border-color: #c9a96e !important; color: #c9a96e !important; }
        .swal2-icon.swal2-error { border-color: #c9a96e !important; }
        .swal2-icon.swal2-error [class^='swal2-x-mark-line'] { background: #c9a96e !important; }

        /* Modal */
        .modal-content {
            background: #221e18;
            border: 1px solid #3a3228;
            border-radius: 2px;
            color: #d4c4a8;
        }
        .modal-header { border-bottom: 1px solid #3a3228; }
        .modal-footer { border-top: 1px solid #3a3228; }
        .modal-title {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 300;
            font-size: 20px;
            letter-spacing: 0.18em;
            color: #e8dcc8 !important;
        }
        .btn-close { filter: invert(1) brightness(0.5); }
        .modal-body .form-label {
            font-size: 8.5px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #7a6a56;
        }
        .modal-body .form-control {
            background: #1a1612;
            border: 1px solid #3a3228;
            color: #d4c4a8;
            border-radius: 1px;
        }
        .modal-body .form-control:focus {
            border-color: #c9a96e;
            box-shadow: 0 0 0 3px rgba(201,169,110,0.1);
            background: #1e1a15;
            color: #d4c4a8;
        }
        .modal-body .form-control::-webkit-calendar-picker-indicator { filter: invert(0.6); cursor: pointer; }
        .flatpickr-calendar {
            background: #221e18 !important;
            border: 1px solid #3a3228 !important;
            border-radius: 2px !important;
            box-shadow: 0 8px 24px rgba(0,0,0,0.5) !important;
        }
        .flatpickr-month, .flatpickr-weekdays, span.flatpickr-weekday {
            background: #221e18 !important;
            color: #7a6a56 !important;
        }
        .flatpickr-current-month input.cur-year,
        .flatpickr-current-month .flatpickr-monthDropdown-months {
            color: #e8dcc8 !important;
            background: transparent !important;
        }
        .flatpickr-current-month .flatpickr-monthDropdown-months option { background: #221e18; }
        .flatpickr-day {
            color: #d4c4a8 !important;
            border-radius: 1px !important;
        }
        .flatpickr-day:hover { background: #3a3228 !important; border-color: #3a3228 !important; }
        .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange {
            background: #c9a96e !important;
            border-color: #c9a96e !important;
            color: #1a1612 !important;
        }
        .flatpickr-day.today { border-color: #c9a96e !important; }
        .flatpickr-day.flatpickr-disabled, .flatpickr-day.prevMonthDay, .flatpickr-day.nextMonthDay {
            color: #3a3228 !important;
        }
        .flatpickr-prev-month svg, .flatpickr-next-month svg { fill: #c9a96e !important; }
        .flatpickr-prev-month:hover svg, .flatpickr-next-month:hover svg { fill: #e8cfa0 !important; }
    </style>
</head>
<body>

    <div class="d-flex" id="wrapper">
        
            <?php echo $__env->make('layouts.customerSidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        

        
            <div id="page-content-wrapper">
                
                    <nav class="navbar navbar-expand-lg text-white border-bottom">
                        <div class="container-fluid">
                            <button class="btn btn-lg" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
                            <h4 class="ms-2 pt-2">UNPAID RESERVATION</h4>
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
                        <div class="row g-2" id="showUnpaidReservation"></div>
                    </div>
                
            </div>
        
    </div>

    
        <div class="modal fade" id="updateUnpaidReservationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">UPDATE BOOK</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="updateUnpaidReservation" name="updateUnpaidReservation">
                    <?php echo csrf_field(); ?>
                        <div class="row gap-0">
                            <div class="col-6 my-2">
                                <label class="form-label">CHECK IN:</label>
                                <input type="hidden" id="reservationId" name="reservationId">
                                <input required type="date" class="form-control" id="checkInDate" name="checkInDate">
                            </div>
                            <div class="col-6 my-2">
                                <label class="form-label">CHECK OUT:</label>
                                <input required type="date" class="form-control" id="checkOutDate" name="checkOutDate">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="font-family:Montserrat,sans-serif; font-size:10px; font-weight:500; letter-spacing:0.2em; text-transform:uppercase; padding:11px 24px; background:transparent; color:#7a6a56; border:1px solid #3a3228; cursor:pointer;" data-bs-dismiss="modal">Close</button>
                        <button type="submit" style="font-family:Montserrat,sans-serif; font-size:10px; font-weight:500; letter-spacing:0.2em; text-transform:uppercase; padding:11px 24px; background:#c9a96e; color:#1a1612; border:none; cursor:pointer;">Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    

    
        <script>
            const CUTOFF_HOUR = 14;

            function getPHToday() {
                const ph = new Date(new Date().toLocaleString('en-US', { timeZone: 'Asia/Manila' }));
                ph.setDate(ph.getDate() + (ph.getHours() >= CUTOFF_HOUR ? 1 : 0));
                return `${ph.getFullYear()}-${String(ph.getMonth()+1).padStart(2,'0')}-${String(ph.getDate()).padStart(2,'0')}`;
            }

            function addOneDay(dateStr) {
                const [y, m, d] = dateStr.split('-').map(Number);
                const next = new Date(y, m - 1, d + 1);
                return `${next.getFullYear()}-${String(next.getMonth()+1).padStart(2,'0')}-${String(next.getDate()).padStart(2,'0')}`;
            }

            let checkInPicker, checkOutPicker;

            function setDateConstraints(checkInVal = null) {
                const minDate = getPHToday();

                if (checkInPicker) checkInPicker.destroy();
                if (checkOutPicker) checkOutPicker.destroy();

                checkInPicker = flatpickr('#checkInDate', {
                    minDate: minDate,
                    defaultDate: checkInVal || minDate,
                    dateFormat: 'Y-m-d',
                    onChange: function(selectedDates, dateStr) {
                        const nextDay = addOneDay(dateStr);
                        checkOutPicker.set('minDate', nextDay);
                        checkOutPicker.setDate(nextDay);
                    }
                });

                checkOutPicker = flatpickr('#checkOutDate', {
                    minDate: addOneDay(checkInVal || minDate),
                    defaultDate: addOneDay(checkInVal || minDate),
                    dateFormat: 'Y-m-d',
                });
            }

            $(document).ready(function () {
                showUnpaidBookingPerUser();
            });

            function showUnpaidBookingPerUser() {
                $.ajax({
                    url: '/getUnpaidBooking',
                    method: 'GET',
                    success: data => {
                        $('#showUnpaidReservation').html(data);
                        startCountdowns();
                    }
                });
            }

            let countdownInterval;

            function startCountdowns() {
                clearInterval(countdownInterval);
                countdownInterval = setInterval(() => {
                    document.querySelectorAll('.countdown-timer').forEach(el => {
                        const expiresAt = new Date(el.dataset.expires).getTime();
                        const now = Date.now();
                        const diff = expiresAt - now;
            
                        if (diff <= 0) {
                            el.textContent = 'Expired — cancelling...';
                            const card = el.closest('.col-lg-6');
                            if (card && !card.dataset.removing) {
                                card.dataset.removing = 'true';
                                setTimeout(() => {
                                    card.style.transition = 'opacity 0.4s';
                                    card.style.opacity = '0';
                                    setTimeout(() => {
                                        card.remove();
                                        checkIfEmpty();
                                    }, 400);
                                }, 1000);
                            }
                            return;
                        }
            
                        const minutes = Math.floor(diff / 60000);
                        const seconds = Math.floor((diff % 60000) / 1000);
                        el.textContent = `Expires in ${minutes}m ${String(seconds).padStart(2, '0')}s`;
                    });
                }, 1000);
            }
            
            function checkIfEmpty() {
                const container = document.getElementById('showUnpaidReservation');
                if (container.children.length === 0) {
                    container.innerHTML = `
                        <div style="width:100%; text-align:center; padding: 80px 20px;">
                            <div style="width:40px; height:1px; background:#c9a96e; margin:0 auto 20px;"></div>
                            <div style="font-family:'Cormorant Garamond', serif; font-size:22px; color:#e8dcc8; letter-spacing:0.15em; margin-bottom:10px;">No Reservations Found</div>
                            <div style="font-size:11px; color:#7a6a56; letter-spacing:0.1em; text-transform:uppercase;">You have no unpaid reservations at this time</div>
                            <div style="width:40px; height:1px; background:#c9a96e; margin:20px auto 0;"></div>
                        </div>`;
                }
            }

            function cancelReservation(id) {
                Swal.fire({
                    title: 'Cancel this booking?',
                    input: 'text',
                    inputPlaceholder: 'Reason for cancellation (optional)',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d72323',
                    confirmButtonText: 'Yes, Cancel it'
                }).then(({ isConfirmed, value }) => {
                    if (!isConfirmed) return;
                    $.ajax({
                        url: '/cancelReservation', type: 'POST', dataType: 'text',
                        data: { reservationId: id, reason: value || null },
                        success: r => {
                            if (r == 1) Swal.fire({ title: 'Cancelled', icon: 'success', showConfirmButton: false, timer: 1500 })
                                .then(() => showUnpaidBookingPerUser());
                            else Swal.fire({ title: 'Could not cancel', icon: 'error', showConfirmButton: false, timer: 1500 });
                        },
                        error: () => Swal.fire({ title: 'Something went wrong', icon: 'error', showConfirmButton: false, timer: 1500 })
                    });
                });
            }

            function getUpdateUnpaidReservation(id) {
                $.ajax({
                    url: '/viewUnpaidReservation', type: 'GET', dataType: 'json',
                    data: { reservationId: id },
                    success: function (res) {
                        const checkInVal = moment(res.start_dataTime).format('YYYY-MM-DD');
                        const checkOutVal = moment(res.end_dateTime).format('YYYY-MM-DD');
                        setDateConstraints(checkInVal);
                        checkOutPicker.setDate(checkOutVal);
                        $('#reservationId').val(res.reservation_id);
                        $('#updateUnpaidReservationModal').modal('show');
                    }
                });
            }

            $('#updateUnpaidReservation').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: '/updateUnpaidReservation', type: 'POST',
                    dataType: 'json',
                    data: new FormData(this),
                    cache: false, contentType: false, processData: false,
                    success: function (res) {
                        const status = res.status ?? res;
                        const cases = {
                            1: () => { $('#updateUnpaidReservationModal').modal('hide'); Swal.fire({ title: 'Updated', icon: 'success', showConfirmButton: false, timer: 1500 }).then(() => showUnpaidBookingPerUser()); },
                            0: () => Swal.fire('Update Failed', 'Operation not stored.', 'error'),
                            2: () => Swal.fire('Invalid Dates', 'Check-in and check-out cannot be the same.', 'error'),
                            3: () => Swal.fire('Invalid Check Out', 'Please check your check-out date.', 'error'),
                            4: () => Swal.fire('Invalid Check In', 'Please check your check-in date.', 'error'),
                            6: () => Swal.fire('Conflict', 'A reservation already exists for these dates.', 'error'),
                        };
                        (cases[status] || (() => Swal.fire('Unexpected Error', '', 'error')))();
                    },
                    error: err => console.error(err)
                });
            });
        </script>
        <script src="<?php echo e(asset('/js/global.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/logout.js')); ?>"></script>
    
</body>
</html>
<?php /**PATH C:\xampp\htdocs\LaravelLuminaries-StaySwift-Hotel-Reservation-Application\resources\views/customer/unpaidReservation.blade.php ENDPATH**/ ?>