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
    <title>StaySwift — Create Account</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body, html {
            height: 100%;
            font-family: 'Montserrat', sans-serif;
            background-color: #1a1612;
            color: #e8dcc8;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .page-wrapper {
            width: 100%;
            max-width: 680px;
            padding: 48px 24px 64px;
        }

        .homeButton {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #7a6a56;
            text-decoration: none;
            font-size: 11px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            margin-bottom: 40px;
            transition: color 0.2s;
        }
        .homeButton:hover { color: #e8dcc8; }
        .homeButton i { font-size: 14px; }

        .brand {
            text-align: center;
            margin-bottom: 40px;
        }
        .brand img {
            width: 56px;
            margin-bottom: 16px;
            opacity: 0.85;
        }
        .brand-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 36px;
            font-weight: 300;
            color: #e8dcc8;
            letter-spacing: 0.18em;
            display: block;
        }
        .brand-sub {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 14px;
            color: #7a6a56;
            letter-spacing: 0.08em;
            margin-top: 4px;
            display: block;
        }

        .form-card {
            background: #221e18;
            border: 1px solid #3a3228;
            padding: 40px 36px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        }

        .section-label {
            font-size: 9px;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: #c9a96e;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 1px solid #3a3228;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-label::before {
            content: ''; display: inline-block;
            width: 18px; height: 1px; background: #c9a96e;
        }

        .form-group { margin-bottom: 28px; }

        .input-row { display: flex; gap: 12px; }
        .input-row .input-wrap { flex: 1; }

        .input-wrap {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .input-wrap label {
            font-size: 9px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: #7a6a56;
        }

        .input-wrap input,
        .input-wrap select {
            background: #1a1612;
            border: 1px solid #3a3228;
            color: #d4c4a8;
            padding: 10px 12px;
            font-family: 'Montserrat', sans-serif;
            font-size: 13px;
            width: 100%;
            outline: none;
            transition: border-color 0.2s, background 0.2s;
            border-radius: 0;
            -webkit-appearance: none;
        }
        .input-wrap input:focus,
        .input-wrap select:focus {
            border-color: #c9a96e;
            background: #1e1a15;
            box-shadow: 0 0 0 3px rgba(201,169,110,0.1);
        }
        .input-wrap input::placeholder { color: #4a4035; }
        .input-wrap input[readonly] { color: #7a6a56; cursor: default; background: #1a1612; }
        .input-wrap select option { background: #221e18; color: #d4c4a8; }

        .show-password {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        .show-password input[type="checkbox"] {
            width: 14px; height: 14px;
            accent-color: #c9a96e;
            cursor: pointer;
        }
        .show-password span {
            font-size: 10px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #7a6a56;
        }

        .divider {
            height: 1px;
            background: #3a3228;
            margin: 28px 0;
        }

        .submit-btn {
            width: 100%;
            background: #e8dcc8;
            color: #1a1612;
            border: none;
            padding: 14px;
            font-family: 'Montserrat', sans-serif;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.2s;
        }
        .submit-btn:hover { background: #e8cfa0; color: #fff;}

        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        .login-link a {
            font-size: 10px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #7a6a56;
            text-decoration: none;
            transition: color 0.2s;
        }
        .login-link a:hover { color: #e8dcc8; }

        @media (max-width: 520px) {
            .input-row { flex-direction: column; }
            .form-card { padding: 28px 20px; }
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <a class="homeButton" href="/"><i class="bi bi-arrow-left"></i> Back to Home</a>

        <div class="brand">
            <img src="<?php echo e(URL('/img/StaySwift Logo no bg.png')); ?>" alt="StaySwift">
            <span class="brand-name">Stay Swift</span>
            <span class="brand-sub">Create your account</span>
        </div>

        <div class="form-card">
            <div style="height:2px; background: linear-gradient(90deg,#c9a96e,#e8cfa0,#c9a96e); margin-bottom:32px;"></div>
            <form name="registrationForm" id="registrationForm">
                <?php echo csrf_field(); ?>

                
                <div class="form-group">
                    <div class="section-label">Personal Information</div>
                    <div class="input-row" style="margin-bottom:12px;">
                        <div class="input-wrap">
                            <label>First Name</label>
                            <input type="text" required id="userFirstName" name="userFirstName" placeholder="Juan">
                        </div>
                        <div class="input-wrap">
                            <label>Middle Name</label>
                            <input type="text" id="userMiddleName" name="userMiddleName" placeholder="dela">
                        </div>
                        <div class="input-wrap">
                            <label>Last Name</label>
                            <input type="text" required id="userLastName" name="userLastName" placeholder="Cruz">
                        </div>
                    </div>
                    <div class="input-row">
                        <div class="input-wrap" style="max-width:140px;">
                            <label>Suffix</label>
                            <select id="userExtension" name="userExtension">
                                <option value="">None</option>
                                <option value="Jr.">Jr.</option>
                                <option value="Sr.">Sr.</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                            </select>
                        </div>
                        <div class="input-wrap">
                            <label>Birthdate</label>
                            <input type="date" required id="userBirthdate" name="userBirthdate" onchange="calculateAge()">
                        </div>
                        <div class="input-wrap" style="max-width:100px;">
                            <label>Age</label>
                            <input type="text" required id="userAge" name="userAge" placeholder="—" readonly>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                
                <div class="form-group">
                    <div class="section-label">Contact Details</div>
                    <div class="input-row">
                        <div class="input-wrap">
                            <label>Email Address</label>
                            <input type="email" required id="userEmailAddress" name="userEmailAddress" placeholder="juan@email.com">
                        </div>
                        <div class="input-wrap">
                            <label>Phone Number</label>
                            <input type="text" required id="userPhone" name="userPhone" placeholder="+63 9XX XXX XXXX">
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                
                <div class="form-group">
                    <div class="section-label">Security</div>
                    <div class="input-row" style="margin-bottom:14px;">
                        <div class="input-wrap">
                            <label>Password</label>
                            <input type="password" required id="userPassword" name="userPassword" placeholder="Min. 6 characters">
                        </div>
                        <div class="input-wrap">
                            <label>Confirm Password</label>
                            <input type="password" required id="userConfirmPassword" name="userConfirmPassword" placeholder="Re-enter password">
                        </div>
                    </div>
                    <label class="show-password">
                        <input type="checkbox" onclick="seePasswordUserRegistration()">
                        <span>Show Password</span>
                    </label>
                </div>

                <div class="divider"></div>

                <button type="submit" class="submit-btn">Create Account</button>
            </form>

            <div class="login-link">
                <a href="/login">Already have an account? Sign in</a>
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('/js/auth.js')); ?>"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\LaravelLuminaries-StaySwift-Hotel-Reservation-Application\resources\views/registration.blade.php ENDPATH**/ ?>