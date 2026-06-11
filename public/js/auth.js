$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

function seePassword() {
    var x = document.getElementById("userRegisterPassword");
    var a = document.getElementById("userRegisterConPassword");
    x.type = (x.type === 'password') ? 'text' : 'password';
    a.type = x.type;
}

function seePasswordUserLogin() {
    var x = document.getElementById("userLoginPassword");
    x.type = x.type === 'password' ? 'text' : 'password';
}

function seePasswordAdminLogin() {
    var x = document.getElementById("adminPassword");
    x.type = x.type === 'password' ? 'text' : 'password';
}

// SIGN UP FUNCTION
$('#registrationForm').on('submit', function(e) {
    e.preventDefault();
    var email = $('#userEmail').val();
    var password = $('#userRegisterPassword').val();
    var confirmPassword = $('#userRegisterConPassword').val();
    if (password.length < 6 || password.length > 20) {
        Swal.fire('PASSWORD FAILED', 'The password must be between 6 and 20 characters', 'error');
    } else if (password !== confirmPassword) {
        Swal.fire('PASSWORD MISMATCH', 'Please check your password', 'error');
    } else if (password === 'password') {
        Swal.fire('PASSWORD FAILED', 'The password cannot be set to "password"', 'error');
    } else {
        $.ajax({
            url: "/registrationFunction",
            method: "POST",
            dataType: "text",
            data: { email: email, password: password },
            success: function(response) {
                var parsed = JSON.parse(response);
                if (parsed == 1) {
                    Swal.fire({ icon: 'success', title: 'REGISTERED SUCCESSFULLY', showConfirmButton: false, timer: 1500 })
                        .then(() => { $("#registrationForm").trigger("reset"); window.location.href = "/login"; });
                } else if (parsed == 2) {
                    Swal.fire('EMAIL NOT AVAILABLE', 'Please choose another email', 'error');
                } else {
                    Swal.fire('REGISTRATION FAILED', 'Please re-enter your credentials', 'error');
                }
            },
            error: function(er) { console.log(er); }
        });
    }
});

// USER LOGIN FUNCTION
$('#userLoginForm').on('submit', function(e) {
    e.preventDefault();
    var data = $('#userLoginForm').serialize();
    $.ajax({
        url: "/userLoginFunction",
        method: "POST",
        dataType: "text",
        data: data
    })
    .done(function(response) {
        var parsed = JSON.parse(response);
        if (parsed == 1) {
            $('#userLoginForm').trigger("reset");
            const Toast = Swal.mixin({
                toast: true, position: 'top-end',
                showConfirmButton: false, timer: 2000, timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                },
                didClose: () => { window.location = "/customerDashboard"; }
            });
            Toast.fire({ icon: 'success', title: 'Signed in successfully', text: 'Welcome!' });
        } else if (parsed == 2) {
            Swal.fire('Email Not Verified', 'Please verify your email before logging in.', 'warning');
        } else if (parsed == 3) {
            Swal.fire('Inactive Account', 'Your account has been disabled.', 'error');
        } else {
            Swal.fire('Login Failed', 'Wrong email or password.', 'error');
        }
    });
});

// ADMIN LOGIN FUNCTION
$('#adminLoginForm').on('submit', function(e) {
    e.preventDefault();
    var data = $('#adminLoginForm').serialize();
    $.ajax({
        url: "/adminLoginFunction",
        method: "POST",
        dataType: "text",
        data: data
    })
    .done(function(response) {
        var parsed = JSON.parse(response);
        if (parsed == 1) {
            $('#adminLoginForm').trigger("reset");
            const Toast = Swal.mixin({
                toast: true, position: 'top-end',
                showConfirmButton: false, timer: 2000, timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                },
                didClose: () => { window.location = "/adminDashboard"; }
            });
            Toast.fire({ icon: 'success', title: 'Signed in successfully', text: 'Welcome Admin' });
        } else if (parsed == 3) {
            Swal.fire('Inactive Account', 'Your account has been disabled.', 'error');
        } else {
            Swal.fire('Login Failed', 'Wrong username or password.', 'error');
        }
    });
});

// LISTENER
var sideButtons = document.querySelectorAll('.bottomLink');
sideButtons.forEach(btn => btn.addEventListener('click', () => {
    document.body.classList.toggle('signup');
}));