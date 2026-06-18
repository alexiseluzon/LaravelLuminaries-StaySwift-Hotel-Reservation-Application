<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <link href="<?php echo e(asset('css/auth.css')); ?>" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo e(URL('/img/logo.png')); ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <?php echo $__env->make('cdn', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <title>StaySwift — Sign In</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body, html {
            height: 100%;
            font-family: 'Montserrat', sans-serif;
            background-color: #1a1612;
            color: #d4c4a8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .homeButton {
            position: fixed;
            top: 24px;
            left: 24px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #7a6a56;
            text-decoration: none;
            font-size: 10px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            transition: color 0.2s;
        }
        .homeButton:hover { color: #c9a96e; }
        .homeButton i { font-size: 16px; }

        .card {
            background: #221e18;
            border: 1px solid #3a3228;
            box-shadow: 0 4px 32px rgba(0,0,0,0.4);
            padding: 48px 40px;
            width: 100%;
            max-width: 400px;
            border-radius: 2px;
            text-align: center;
        }

        .brand-icon {
            width: 52px; height: 52px;
            border-radius: 50%;
            border: 1px solid #c9a96e;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 18px;
        }
        .brand-icon img {
            width: 28px;
            opacity: 0.85;
            filter: brightness(0) saturate(100%) invert(72%) sepia(30%) saturate(600%) hue-rotate(5deg) brightness(95%);
        }

        .brand-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 30px;
            font-weight: 300;
            color: #e8dcc8;
            letter-spacing: 0.22em;
            display: block;
            margin-bottom: 6px;
        }

        .brand-sub {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 13px;
            color: #7a6a56;
            letter-spacing: 0.08em;
            display: block;
            margin-bottom: 32px;
        }

        .gold-line {
            height: 1px;
            background: linear-gradient(90deg, transparent, #c9a96e, transparent);
            margin-bottom: 32px;
        }

        .alert-success {
            background: rgba(201,169,110,0.1);
            border: 1px solid #c9a96e;
            color: #c9a96e;
            padding: 10px 14px;
            font-size: 11px;
            letter-spacing: 0.08em;
            margin-bottom: 20px;
            text-align: left;
        }

        .input-wrap {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 16px;
            text-align: left;
        }

        .input-wrap label {
            font-size: 8.5px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #7a6a56;
        }

        .input-wrap input {
            background: #1a1612;
            border: 1px solid #3a3228;
            color: #d4c4a8;
            padding: 11px 12px;
            font-family: 'Montserrat', sans-serif;
            font-size: 13px;
            width: 100%;
            outline: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
            border-radius: 1px;
        }
        .input-wrap input:focus {
            border-color: #c9a96e;
            background: #1e1a15;
            box-shadow: 0 0 0 3px rgba(201,169,110,0.1);
        }
        .input-wrap input::placeholder { color: #4a4035; }

        .show-password {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            margin-bottom: 24px;
            text-align: left;
        }
        .show-password input[type="checkbox"] {
            width: 14px; height: 14px;
            accent-color: #c9a96e;
            cursor: pointer;
        }
        .show-password span {
            font-size: 9px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #7a6a56;
        }

        .submit-btn {
            width: 100%;
            background: #c9a96e;
            color: #1a1612;
            border: none;
            padding: 14px;
            font-family: 'Montserrat', sans-serif;
            font-size: 10.5px;
            font-weight: 500;
            letter-spacing: 0.24em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.2s;
            border-radius: 1px;
        }
        .submit-btn:hover { background: #e8cfa0; }

        .register-link {
            margin-top: 20px;
        }
        .register-link a {
            font-size: 9.5px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: #5a4e3e;
            text-decoration: none;
            transition: color 0.2s;
        }
        .register-link a:hover { color: #c9a96e; }
        /* SWAL THEME */
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
        .swal2-icon.swal2-success { border-color: #c9a96e !important; }
        .swal2-icon.swal2-success [class^='swal2-success-line'] { background: #c9a96e !important; }
        .swal2-icon.swal2-success .swal2-success-ring { border-color: #c9a96e !important; }
        .swal2-icon.swal2-warning { border-color: #c9a96e !important; color: #c9a96e !important; }
        .swal2-icon.swal2-error { border-color: #c9a96e !important; }
        .swal2-icon.swal2-error [class^='swal2-x-mark-line'] { background: #c9a96e !important; }
        /* Toast specifically */
        .swal2-popup.swal2-toast {
            background: #221e18 !important;
            border: 1px solid #3a3228 !important;
            color: #d4c4a8 !important;
        }
        .swal2-popup.swal2-toast .swal2-title { color: #e8dcc8 !important; font-size: 13px !important; }
    </style>
</head>
<body>
    <a class="homeButton" href="/"><i class="bi bi-arrow-left"></i> Home</a>

    <div class="card">
        <div class="brand-icon">
            <img src="<?php echo e(URL('/img/StaySwift Logo no bg.png')); ?>" alt="StaySwift">
        </div>
        <span class="brand-name">Stay Swift</span>
        <span class="brand-sub">Sign in to your account</span>
        <div class="gold-line"></div>

        <form name="userLoginForm" id="userLoginForm">
            <?php if(session('message')): ?>
                <div class="alert-success"><?php echo e(session('message')); ?></div>
            <?php endif; ?>

            <div class="input-wrap">
                <label for="userEmail">Email Address</label>
                <input type="email" name="userEmail" id="userEmail" placeholder="juan@email.com" required>
            </div>

            <div class="input-wrap">
                <label for="userLoginPassword">Password</label>
                <input type="password" name="userLoginPassword" id="userLoginPassword" placeholder="Your password" required>
            </div>

            <label class="show-password">
                <input type="checkbox" onclick="seePasswordUserLogin()">
                <span>Show Password</span>
            </label>

            <button type="submit" id="appLoginBtn" name="appLoginBtn" class="submit-btn">Sign In</button>

            <div class="register-link">
                <a href="/registration">Don't have an account? Create one</a>
            </div>
        </form>
    </div>

    <script src="<?php echo e(asset('/js/auth.js')); ?>"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\LaravelLuminaries-StaySwift-Hotel-Reservation-Application\resources\views/login.blade.php ENDPATH**/ ?>