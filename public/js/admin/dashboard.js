$(document).ready(function () {
    loadStats();
    // getBackOutContent();
});

function loadStats() {
    $.get('/getAllTotalForAdmin', function(data) {
        $('#totalPendingReservation').html(data.totalPendingReservation);
        $('#totalOnGoingReservation').html(data.totalOnGoingReservation);
        $('#totalCompletedReservation').html(data.totalCompletedReservation);
        $('#totalCustomer').html(data.totalCustomer);
    });
}

// // — Back-out content —
// function getBackOutContent() {
//     $.get('/getBackOutContentForAdmin', (data) => $('#fetchAllBackOut').html(data));
// }

// function noteBackOutContent(id) {
//     Swal.fire({
//         title: 'Are you sure?',
//         text: "Do you want to NOTE this LETTER?",
//         icon: 'question',
//         showCancelButton: true,
//         confirmButtonText: 'Yes, Note it'
//     }).then(({ isConfirmed }) => {
//         if (!isConfirmed) return;
//         $.get('/archivedCancelledReservation', { reservationId: id }, null, 'json');
//         Swal.fire({
//             title: 'Noted',
//             text: "Reservation was noted successfully.",
//             icon: 'success',
//             showConfirmButton: false,
//             timer: 1500,
//         }).then(() => getBackOutContent());
//     });
// }