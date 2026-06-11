<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <link href="<?php echo e(asset('css/auth.css')); ?>" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo e(URL('/img/logo.png')); ?>" type="image/x-icon">
    <?php echo $__env->make('cdn', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <title>StaySwift</title>
</head>
<body>
        
            <div class="back-image"><img src="./img/hotel.jpg" alt="background image"></div>
            <section class="left"></section>

            <section class="rightLogin">
                <section class="main login">
                    <div class="container mt-5 pt-5">
                        <a class='homeButton' href="/" data-title='Back to Home?'><i class="bi bi-house"></i></a>
                        <img class="border-0 logo" src="<?php echo e(URL('/img/icon.png')); ?>">
                        <p class="title mt-lg-3">ADMINISTRATOR LOGIN</p>
                        <form name="adminLoginForm" id="adminLoginForm">
                            <?php if(session('message')): ?>
                                <div class="alert alert-success">
                                    <?php echo e(session('message')); ?>

                                </div>
                            <?php endif; ?>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" name="adminEmail" id="adminEmail" placeholder="Email" required>
                                <label for="floatingInput" class="text-muted">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="adminPassword" id="adminPassword" placeholder="Password" required>
                                <label for="floatingInput" class="text-muted">Password</label>
                            </div>
                            <div class="mb-3 checkBox ms-4">
                                <input type="checkbox" class="form-check-input" onclick="seePasswordAdminLogin()">
                                <label class="form-check-label">Show Password</label>
                            </div>
                                <button type="submit" id="appLoginBtn" name="appLoginBtn" class="btn rounded">LOGIN</button>
                        </form>
                    </div>
                </section>
            </section>
        

    
        <script src="<?php echo e(asset('/js/auth.js')); ?>"></script>
    
</body>
</html>
<?php /**PATH C:\xampp\htdocs\LaravelLuminaries-StaySwift-Hotel-Reservation-Application\resources\views/adminLogin.blade.php ENDPATH**/ ?>