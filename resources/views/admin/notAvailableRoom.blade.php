<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>StaySwift — Manage Rooms</title>

    @include('cdn')
    <link href="{{ asset('/css/sideBar.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/swal-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/roomTheme.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ URL('/img/StaySwift Logo no bg.png')}}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="d-flex" id="wrapper">
        @include('layouts.adminSidebar')

        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg border-bottom">
                <div class="container-fluid">
                    <h4 class="ms-2">Manage Rooms</h4>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li>
                                <a class="nav-link me-3">
                                    {{ auth()->guard('userModel')->user()->firstname }}
                                    {{ auth()->guard('userModel')->user()->lastname }}
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
                            <a class="nav-link" href="/adminRoom">Available Rooms</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Unavailable Rooms</a>
                        </li>
                        <li class="nav-item ms-auto">
                            <a href="/addNewRoom" class="btn-gold">Add New Room <i class="bi bi-plus"></i></a>
                        </li>
                    </ul>

                    <table id="notAvailableRoom" class="table table-sm table-bordered text-center align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Room Number</th>
                                <th>Floor</th>
                                <th>Type of Room</th>
                                <th>Beds</th>
                                <th>Max Guests</th>
                                <th>Price</th>
                                <th>Details</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- UPDATE ROOM MODAL --}}
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
                                <label for="clearPhoto" class="file-upload-label">
                                    <i class="bi bi-upload me-2"></i>
                                    <span id="fileUploadText">Choose File</span>
                                </label>
                                <input required type="file" id="clearPhoto" name="roomPhoto"
                                       accept="image/png,image/jpg,image/jpeg,image/gif,image/svg"
                                       style="display:none">
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-4">
                                <label class="form-label">Room Number</label>
                                <input type="text" class="form-control" id="roomNumber" name="roomNumber" required>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Floor</label>
                                <select class="form-select" id="roomFloor" name="roomFloor" required>
                                    <option value="First Floor" selected>First Floor</option>
                                    <option value="Second Floor">Second Floor</option>
                                    <option value="Third Floor">Third Floor</option>
                                    <option value="Fourth Floor">Fourth Floor</option>
                                    <option value="Fifth Floor">Fifth Floor</option>
                                    <option value="Sixth Floor">Sixth Floor</option>
                                    <option value="Seventh Floor">Seventh Floor</option>
                                    <option value="Eighth Floor">Eighth Floor</option>
                                    <option value="Ninth Floor">Ninth Floor</option>
                                    <option value="Tenth Floor">Tenth Floor</option>
                                    <option value="Eleventh Floor">Eleventh Floor</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Price / Night</label>
                                <input type="number" class="form-control" id="roomPricePerHour" name="roomPricePerHour" min="0" step="0.01" required>
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-4">
                                <label class="form-label">Type of Room</label>
                                <select class="form-select" id="roomType" name="roomType">
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
                            <div class="col-4">
                                <label class="form-label">Beds</label>
                                <input type="number" class="form-control" id="roomBedNumber" name="roomBedNumber" min="1" max="5" required>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Max Person</label>
                                <input type="number" class="form-control" id="roomMaxPerson" name="roomMaxPerson" min="1" max="10" required>
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

    <script src="{{ asset('/js/admin/room.js') }}"></script>
    <script src="{{ asset('/js/dateTime.js') }}"></script>
    <script src="{{ asset('/js/logout.js') }}"></script>
</body>
</html>