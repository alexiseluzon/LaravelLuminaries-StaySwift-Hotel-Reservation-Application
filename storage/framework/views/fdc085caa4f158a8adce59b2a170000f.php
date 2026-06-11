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
    <title>StaySwift - Login</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #ff8c00, #ff7000);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .container img.logo {
            width: 100px;
            margin-bottom: 20px;
        }

        .title {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
        }

        .form-floating {
            position: relative;
            margin-bottom: 15px;
        }

        .form-floating input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-floating label {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 14px;
            color: #999;
            transition: 0.2s;
        }

        .form-floating input:focus + label,
        .form-floating input:not(:placeholder-shown) + label {
            top: -10px;
            left: 10px;
            font-size: 12px;
            color: #ff7000;
        }

        .checkBox {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #555;
        }

        .checkBox input {
            margin-right: 10px;
        }

        .btn {
            background: #ff8c00;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #ff7000;
        }

        .navbar-nav {
            margin-top: 20px;
        }

        .nav-link {
            font-size: 14px;
            color: #ff8c00;
            text-decoration: none;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .homeButton {
            position: absolute;
            top: 20px;
            left: 20px;
            background: #ff8c00;
            color: #fff;
            padding: 10px;
            border-radius: 50%;
            font-size: 20px;
            text-decoration: none;
        }

        .homeButton:hover {
            background: #ff7000;
        }
    </style>
</head>
<body>
    <a class="homeButton" href="/" data-title="Back to Home?"><i class="bi bi-house"></i></a>
    <div class="container">
        <img class="border-0 logo" src="<?php echo e(URL('/img/logo.jpg')); ?>" alt="StaySwift Logo">
        <p class="title">STAYSWIFT SOLUTION SYSTEM</p>
        <form name="userLoginForm" id="userLoginForm">
            <?php if(session('message')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('message')); ?>

                </div>
            <?php endif; ?>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="userEmail" id="userEmail" placeholder="Email" required>
                <label for="userEmail" class="text-muted">Email</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="userLoginPassword" id="userLoginPassword" placeholder="Password" required>
                <label for="userLoginPassword" class="text-muted">Password</label>
            </div>
            <div class="mb-3 checkBox">
                <input type="checkbox" class="form-check-input" onclick="seePasswordUserLogin()">
                <label class="form-check-label">Show Password</label>
            </div>
            <button type="submit" id="appLoginBtn" name="appLoginBtn" class="btn rounded">LOGIN</button>
            <ul class="navbar-nav text-center">
                <li class="nav-item"><a href="/registration" class="nav-link bottomLink">Create Your Account</a></li>
            </ul>
        </form>
    </div>
    <script src="<?php echo e(asset('/js/auth.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\LaravelLuminaries-StaySwift-Hotel-Reservation-Application\resources\views/login.blade.php ENDPATH**/ ?>