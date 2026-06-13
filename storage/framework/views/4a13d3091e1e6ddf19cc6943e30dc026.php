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
        <link rel="shortcut icon" href="<?php echo e(URL('/img/StaySwift Login no bg.png')); ?>" type="image/x-icon">
    
    <title>StaySwift</title>
</head>
<body>

    <div class="d-flex" id="wrapper">
        
            <?php echo $__env->make('layouts.customerSidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        

        
            <div id="page-content-wrapper">
                
                    <nav class="navbar navbar-expand-lg text-white border-bottom">
                        <div class="container-fluid">
                            <button class="btn btn-lg" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
                            <h4 class="me-3 me-lg-0 pt-2 ms-lg-2">AVAILABLE ROOM</h4>
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
                        <!-- Filter Form -->
                        <form id="filterForm" class="row g-3">
                            <div class="col-md-4">
                                <label for="capacityFilter" class="form-label">Room Capacity</label>
                                <select id="capacityFilter" class="form-select">
                                    <option value="">All</option>
                                    <option value="1">1 Person</option>
                                    <option value="2">2 Persons</option>
                                    <option value="2">3 Persons</option>
                                    <option value="4">4 Persons</option>
                                    <option value="2">6 Persons</option>
                                    <option value="2">8 Persons</option>

                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="typeFilter" class="form-label">Room Type</label>
                                <select id="typeFilter" class="form-select">
                                    <option value="">All</option>
                                    <option value="Standard Room">Standard Room</option>
                                    <option value="Single Deluxe Room">Single Deluxe Room</option>
                                    <option value="Superior Double Room">Superior Double Room</option>
                                    <option value="Executive Deluxe King Room">Executive Deluxe King Room</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="sortFilter" class="form-label">Sort by Price</label>
                                <select id="sortFilter" class="form-select">
                                    <option value="">None</option>
                                    <option value="asc">Price: Low to High</option>
                                    <option value="desc">Price: High to Low</option>
                                </select>
                            </div>
                        </form>

                        <div class="row g-2" id="showTotalRoom"></div>
                    </div>
                
            </div>
        
    </div>

    
        <script src="<?php echo e(asset('/js/customer/room.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/dateTime.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/logout.js')); ?>"></script>
        <script>
            document.getElementById('filterForm').addEventListener('change', function() {
                const capacity = document.getElementById('capacityFilter').value;
                const type = document.getElementById('typeFilter').value;
                const sort = document.getElementById('sortFilter').value;
                fetchRooms(capacity, type, sort);
            });

            function fetchRooms(capacity, type, sort) {
                const url = new URL('<?php echo e(url('/rooms/filter')); ?>');
                const params = { capacity: capacity, type: type, sort: sort };
                url.search = new URLSearchParams(params).toString();

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        const roomsContainer = document.getElementById('showTotalRoom');
                        roomsContainer.innerHTML = '';
                        data.rooms.forEach(room => {
                            const roomElement = document.createElement('div');
                            roomElement.className = 'col-md-4';
                            roomElement.innerHTML = `
                                <div class="card mb-4">
                                    <img src="${room.photos}" class="card-img-top" alt="Room Image">
                                    <div class="card-body">
                                        <h5 class="card-title">Room Number: ${room.room_number}</h5>
                                        <p class="card-text">Floor: ${room.floor}</p>
                                        <p class="card-text">Number of Bed: ${room.number_of_bed}</p>
                                        <p class="card-text">Type of Room: ${room.type_of_room}</p>
                                        <p class="card-text">Details: ${room.details}</p>
                                        <p class="card-text">Max Person: ${room.max_person}</p>
                                        <p class="card-text">Price per Night: ${room.price}</p>
                                        <p class="card-text">Status: ${room.status}</p>
                                    </div>
                                </div>
                            `;
                            roomsContainer.appendChild(roomElement);
                        });
                    })
                    .catch(error => console.error('Error fetching rooms:', error));
            }
        </script>
    

    
        <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:green">BOOK NOW</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="bookReservationForm" name="bookReservationForm">
                    <?php echo csrf_field(); ?>
                        <div class="row gap-0">
                            <div class="col-6 my-2">
                                <label class="form-label">CHECK IN: </label>
                                <input required type="date" class="form-control shadow-sm bg-body rounded-0" id="checkInDate" Name="checkInDate">
                            </div>
                            <div class="col-6 my-2">
                                <label class="form-label">CHECK OUT:</label>
                                <input required type="date" class="form-control shadow-sm rounded-0" id="checkOutDate" name="checkOutDate">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-0 px-4" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="submitDateBooking" class="btn btn-primary rounded-0 px-4">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    
</body>
</html>
<?php /**PATH C:\xampp\htdocs\LaravelLuminaries-StaySwift-Hotel-Reservation-Application\resources\views/customer/room.blade.php ENDPATH**/ ?>