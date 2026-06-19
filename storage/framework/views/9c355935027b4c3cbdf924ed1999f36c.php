<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php echo $__env->make('cdn', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link href="<?php echo e(asset('/css/sideBar.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/swal-theme.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/css/roomTheme.css')); ?>" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo e(URL('/img/StaySwift Logo no bg.png')); ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <title>StaySwift — Manage Rooms</title>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <?php echo $__env->make('layouts.adminSidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg border-bottom">
                <div class="container-fluid">
                    <h4 class="ms-2">Manage Rooms</h4>
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
                <div class="page-panel">
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Available Rooms</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/adminNotAvailableRoom">Unavailable Rooms</a>
                        </li>
                        <li class="nav-item ms-auto">
                            <a href="/addNewRoom" class="btn-gold">Add New Room <i class="bi bi-plus"></i></a>
                        </li>
                    </ul>

                    <table id="availableRoom" class="table table-sm table-bordered text-center align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Room Number</th>
                                <th>Floor</th>
                                <th>Type of Room</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="updateRoomModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateRoomForm" name="updateRoomForm">
                        <input type="hidden" id="room_id" name="room_id" required>

                        <img src="" id="roomPhoto" class="rounded mx-auto d-block mb-3" style="height:200px; width:100%; object-fit:cover;">

                        <div class="row g-2 mb-3">
                            <div class="col-12">
                                <label class="form-label">Room Photo</label>
                                <input type="file" class="form-control" id="clearPhoto" name="roomPhoto" accept="image/png, image/jpg, image/jpeg, image/gif, image/svg">
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-4">
                                <label class="form-label">Room Number</label>
                                <input type="text" class="form-control" id="roomNumber" name="roomNumber" readonly required>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Floor</label>
                                <select class="form-select" id="roomFloor" name="roomFloor" required>
                                    <option value="First Floor" selected>First Floor</option>
                                    <option value="Second Floor">Second Floor</option>
                                    <option value="Third Floor">Third Floor</option>
                                    <option value="Fourth Floor">Fourth Floor</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Price / Night</label>
                                <input type="text" class="form-control" id="roomPricePerHour" name="roomPricePerHour" required>
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-4">
                                <label class="form-label">Type of Room</label>
                                <select class="form-select" id="roomType" name="roomType">
                                    <option value="Standard Room" selected>Standard Room</option>
                                    <option value="Superior Double Room">Superior Double Room</option>
                                    <option value="Single Deluxe Room">Single Deluxe Room</option>
                                    <option value="Executive Deluxe King Room">Executive Deluxe King Room</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Beds</label>
                                <input type="number" class="form-control" id="roomBedNumber" name="roomBedNumber" min="0" max="5" required>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Max Person</label>
                                <input type="number" class="form-control" id="roomMaxPerson" name="roomMaxPerson" min="0" max="10" required>
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-12">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="roomStatus" name="roomStatus">
                                    <option value="Available" selected>Available</option>
                                    <option value="Occupied">Occupied</option>
                                    <option value="Reserved">Reserved</option>
                                    <option value="Under Maintenance">Under Maintenance</option>
                                    <option value="Ready for Inspection">Ready for Inspection</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-12">
                                <label class="form-label">Details</label>
                                <textarea class="form-control" style="height:80px; resize:none;" id="detailsOfRoom" name="detailsOfRoom" required></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn-close" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="updateRoomForm" class="modal-btn-submit">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('/js/admin/room.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/dateTime.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/logout.js')); ?>"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\LaravelLuminaries-StaySwift-Hotel-Reservation-Application\resources\views/admin/room.blade.php ENDPATH**/ ?>