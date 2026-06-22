<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php echo $__env->make('cdn', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link href="<?php echo e(asset('/css/sideBar.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/customerDashboard.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/swal-theme.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/roomTheme.css')); ?>" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo e(URL('/img/StaySwift Logo no bg.png')); ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <title>StaySwift — Available Rooms</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <?php echo $__env->make('layouts.customerSidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-lg" id="sidebarToggle" style="color:#7a6a56"><i class="fa-solid fa-bars"></i></button>
                    <h4 class="me-3 me-lg-0 pt-2 ms-lg-2">Available Rooms</h4>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li>
                                <a class="nav-link me-3">
                                    <?php echo e(auth()->guard('userModel')->user()->firstname); ?>

                                    <?php echo e(auth()->guard('userModel')->user()->lastname); ?>

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

    
    <div class="modal fade" id="reservationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Book a Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bookReservationForm" name="bookReservationForm">
                        <?php echo csrf_field(); ?>
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
    

    <script src="<?php echo e(asset('/js/customer/room.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/global.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/logout.js')); ?>"></script>
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

        function findFirstAvailableDate(startDate, disabledRanges) {
            let current = startDate;
            let safety = 0; // prevent infinite loop if something's misconfigured
            while (isDateDisabled(current, disabledRanges) && safety < 365) {
                current = addOneDay(current);
                safety++;
            }
            return current;
        }

        function isDateDisabled(dateStr, disabledRanges) {
            return disabledRanges.some(range => dateStr >= range.from && dateStr <= range.to);
        }

        let checkInPicker, checkOutPicker;

        function setDateConstraints(disabledRanges = []) {
            const minDate = getPHToday();
            const firstAvailableCheckIn = findFirstAvailableDate(minDate, disabledRanges);
            const minCheckOut = addOneDay(firstAvailableCheckIn);
            const firstAvailableCheckOut = findFirstAvailableDate(minCheckOut, disabledRanges);

            if (checkInPicker) checkInPicker.destroy();
            if (checkOutPicker) checkOutPicker.destroy();

            checkInPicker = flatpickr('#checkInDate', {
                minDate: minDate,
                defaultDate: firstAvailableCheckIn,
                dateFormat: 'Y-m-d',
                disable: disabledRanges,
                onChange: function(selectedDates, dateStr) {
                    const nextDay = addOneDay(dateStr);
                    const nextAvailable = findFirstAvailableDate(nextDay, disabledRanges);
                    checkOutPicker.set('minDate', nextDay);
                    checkOutPicker.setDate(nextAvailable);
                }
            });

            checkOutPicker = flatpickr('#checkOutDate', {
                minDate: minCheckOut,
                defaultDate: firstAvailableCheckOut,
                dateFormat: 'Y-m-d',
                disable: disabledRanges,
            });
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
</html><?php /**PATH C:\xampp\htdocs\LaravelLuminaries-StaySwift-Hotel-Reservation-Application\resources\views/customer/room.blade.php ENDPATH**/ ?>