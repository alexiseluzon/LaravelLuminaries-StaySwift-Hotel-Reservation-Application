$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

function seePasswordUserRegistration() {
    var x = document.getElementById("userPassword");
    var a = document.getElementById("userConfirmPassword");
    x.type = x.type === 'password' ? 'text' : 'password';
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

$(document).on('click', '.demo-login-btn', function () {
    const btn = $(this).prop('disabled', true);
    const role = btn.data('role');
    $.ajax({ url: '/demoLogin/' + role, method: 'POST', dataType: 'json' })
        .done(function (res) {
            if (res == 1) {
                Swal.mixin({
                    toast: true, position: 'top-end', showConfirmButton: false,
                    timer: 1500, timerProgressBar: true,
                    didClose: () => { window.location = role === 'admin' ? '/adminDashboard' : '/customerDashboard'; }
                }).fire({ icon: 'success', title: 'Signed in as demo ' + role });
            } else {
                btn.prop('disabled', false);
                Swal.fire('Demo Login Failed', 'Please try again.', 'error');
            }
        })
        .fail(function (xhr) {
            btn.prop('disabled', false);
            Swal.fire('Demo Login Unavailable', xhr.status === 429 ? 'Too many attempts. Wait a minute.' : 'Demo login is disabled.', 'error');
        });
});