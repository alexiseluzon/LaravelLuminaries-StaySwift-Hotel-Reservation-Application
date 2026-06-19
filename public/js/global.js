$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

$(document).ajaxError(function (event, jqxhr) {
    if (jqxhr.status === 401 || jqxhr.status === 419) {
        Swal.fire({
            icon: 'warning',
            title: 'Session Expired',
            text: 'Please log in again.',
            confirmButtonText: 'Go to Login'
        }).then(() => window.location = '/login');
    } else if (jqxhr.status === 403) {
        Swal.fire('Access Denied', "You don't have permission to do that.", 'error');
    }
});