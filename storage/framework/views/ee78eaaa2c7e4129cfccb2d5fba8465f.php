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
                                <input required type="date" class="form-control shadow-sm bg-body rounded-0" id="checkInDate" name="checkInDate">
                            </div>
                            <div class="col-6 my-2">
                                <label class="form-label">CHECK OUT:</label>
                                <input required type="date" class="form-control shadow-sm rounded-0" id="checkOutDate" name="checkOutDate">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-0 px-4" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary rounded-0 px-4">Update</button>
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

            function setDateConstraints(checkInVal = null) {
                const minDate = getPHToday();
                const checkIn = document.getElementById('checkInDate');
                const checkOut = document.getElementById('checkOutDate');

                checkIn.min = minDate;
                checkIn.value = checkInVal || minDate;
                const minCheckOut = addOneDay(checkIn.value);
                checkOut.min = minCheckOut;
                checkOut.value = minCheckOut;

                checkIn.addEventListener('change', function () {
                    if (!this.value) return;
                    const min = addOneDay(this.value);
                    checkOut.min = min;
                    checkOut.value = min;
                });
            }

            $(document).ready(function () {
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                showUnpaidBookingPerUser();
            });

            function showUnpaidBookingPerUser() {
                $.ajax({ url: '/getUnpaidBooking', method: 'GET', success: data => $('#showUnpaidReservation').html(data) });
            }

            function deleteReservation(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to cancel this booking?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d72323',
                    confirmButtonText: 'Yes, Cancel it'
                }).then(({ isConfirmed }) => {
                    if (!isConfirmed) return;
                    $.ajax({
                        url: '/deleteReservation', type: 'GET', dataType: 'text',
                        data: { reservationId: id },
                        success: r => {
                            if (r == 1) Swal.fire({ title: 'Cancelled', icon: 'success', showConfirmButton: false, timer: 1500 })
                                .then(() => showUnpaidBookingPerUser());
                        },
                        error: err => console.error(err)
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
                        document.getElementById('checkOutDate').value = checkOutVal;
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
        <script src="<?php echo e(asset('/js/logout.js')); ?>"></script>
    
</body>
</html>
<?php /**PATH C:\xampp\htdocs\LaravelLuminaries-StaySwift-Hotel-Reservation-Application\resources\views/customer/unpaidReservation.blade.php ENDPATH**/ ?>