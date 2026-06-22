<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>StaySwift</title>
    <link rel="shortcut icon" href="{{ URL('/img/StaySwift Logo no bg.png') }}" type="image/x-icon">
    <link href="{{ asset('/css/swal-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/sideBar.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/roomtheme.css') }}" rel="stylesheet">
    @include('cdn')
</head>
<body>
<div class="d-flex" id="wrapper">

    @include('layouts.adminSidebar')

    <div id="page-content-wrapper">

        <nav class="navbar navbar-expand-lg border-bottom">
            <div class="container-fluid">
                <h4 class="ms-2">MANAGE ROOM</h4>
                <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                    <li>
                        <a class="nav-link me-3">
                            {{ auth()->guard('userModel')->user()->firstname }}
                            {{ auth()->guard('userModel')->user()->lastname }}
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="mainBar">
            <div class="page-panel">
                <h5 class="mb-4">ADD NEW ROOM</h5>
                <div class="gold-line"></div>

                <form id="addRoomDetailsForm" name="addRoomDetailsForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Image of Room</label>
                        <label for="roomPhoto" class="file-upload-label">
                            <i class="bi bi-upload me-2"></i>
                            <span id="fileUploadText">Choose File</span>
                        </label>
                        <input required type="file" id="roomPhoto" name="roomPhoto"
                               accept="image/png,image/jpg,image/jpeg,image/gif,image/svg"
                               style="display:none">
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-md-2">
                            <label class="form-label">Room Number</label>
                            <input required class="form-control rounded-0" type="number"
                                   id="roomNumber" name="roomNumber" placeholder="00#">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Floor</label>
                            <select required class="form-select rounded-0" id="roomFloor" name="roomFloor">
                                <option value="First Floor">First Floor</option>
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
                        <div class="col-md-2">
                            <label class="form-label">Type of Room</label>
                            <select class="form-select rounded-0" id="roomType" name="roomType">
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
                        <div class="col-md-2">
                            <label class="form-label">Number of Beds</label>
                            <input required class="form-control rounded-0" type="number"
                                   min="0" max="5" id="bedNumber" name="bedNumber">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Max Person</label>
                            <input required class="form-control rounded-0" type="number"
                                   min="0" max="10" id="maxPerson" name="maxPerson">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Price Per Night</label>
                            <input required class="form-control rounded-0" type="number"
                                   id="pricePerHour" name="pricePerHour" min="0"> 
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Room Details</label>
                        <textarea required class="form-control rounded-0"
                                  style="height:80px;resize:none;"
                                  id="detailsOfRoom" name="detailsOfRoom"></textarea>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn-gold px-4 py-2">Add Room</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="{{ asset('/js/admin/room.js') }}"></script>
<script src="{{ asset('/js/dateTime.js') }}"></script>
<script src="{{ asset('/js/logout.js') }}"></script>
</body>
</html>