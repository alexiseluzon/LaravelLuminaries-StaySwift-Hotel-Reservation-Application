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
                            <h4 class="ms-2 pt-2">MANAGE ACCOUNT</h4>
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
                

                
                    <div class="container-fluid mainBar my-4">
                        <div class="card p-5 bg-body rounded-0 shadow-lg">
                            <h5 class="mb-4 text-lg-start text-center">CREDENTIALS</h4>
                            <ul class="nav nav-tabs mb-4 text-lg-start text-center">
                                <li class="nav-item">
                                    <a class="nav-link" href="/customerAccount">Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">Credentials</a>
                                </li>
                            </ul>
                            <form id="updateUserCredentials" name="updateUserCredentials">
                                    <?php echo csrf_field(); ?>
                                    <div class="row gap-0">
                                        <div class="col-3">
                                            <div class="mb-3">
                                                <label class="form-label">Old Password:</label>
                                                <input required class="form-control shadow-sm rounded-0" type="text"  id="userOldPassword" name="userOldPassword">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="mb-3">
                                            <label class="form-label">New Password:</label>
                                                <input required class="form-control shadow-sm rounded-0" type="text" id="userNewPassword" name="userNewPassword">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="mb-3">
                                            <label class="form-label">Confirm Password:</label>
                                                <input required class="form-control shadow-sm rounded-0" type="text" id="userNewConfirmPassword" name="userNewConfirmPassword">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-3 d-flex ms-auto">
                                            <button type="submit" readonly class="btn btn-primary px-4 py-2 rounded-0">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                        </div>
                    </div>
                
            </div>
        
    </div>

    
        <script src="<?php echo e(asset('/js/dateTime.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/logout.js')); ?>"></script>
        <script>
            $('#updateUserCredentials').on( 'submit' , function(e){
                e.preventDefault();
                const newPassword = $('#userNewPassword').val();
                const newConfirmPassword = $('#userNewConfirmPassword').val();
                if(newPassword !== newConfirmPassword){
                    Swal.fire(
                        'Update Failed',
                        'New Password and Confirm Password Not Same',
                        'error'
                    )
                }else if (newPassword.length < 8 || newConfirmPassword.length < 8) {
                    Swal.fire(
                        'Update Failed',
                        'Your password is not below 8 characters',
                        'error'
                    )
                }else{
                    const currentForm = $('#updateUserCredentials')[0];
                    const data = new FormData(currentForm);
                    $.ajax({
                        url: "/updateUserCredentials",
                        type: "post",
                        method: "post",
                        dataType: "text",
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if(response == 1){
                                let timerInterval;
                                Swal.fire({
                                title: "Update Successfully",
                                html: "We redirect you to login page and sign in again.",
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                    const timer = Swal.getPopup().querySelector("b");
                                    timerInterval = setInterval(() => {
                                    timer.textContent = `${Swal.getTimerLeft()}`;
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                }
                                }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    window.location = "/login";
                                }
                                });
                            }else if(response == 2){
                                Swal.fire(
                                    'Update Failed',
                                    'Sorry, Wrong Old Password',
                                    'error'
                                )
                            }
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            });
        </script>
    
</body>
</html>
<?php /**PATH C:\xampp\htdocs\LaravelLuminaries-StaySwift-Hotel-Reservation-Application\resources\views/customer/credentials.blade.php ENDPATH**/ ?>