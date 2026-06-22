<div class="border-end bg-white" id="sidebar-wrapper">
    <div class="sidebar-heading border-bottom pt-5 text-center">
        <img class="scpiLogo" src="/img/StaySwift Logo no bg.png">
        <link href="{{ asset('/css/sideBar.css') }}" rel="stylesheet">
        <p class="portal pt-4">Administrator Portal</p>
    </div>
    <div class="list-group list-group-flush recruiterLink">
        <a class="list-group-item recruiterA list-group-item-action list-group-item-light p-3" 
            href="/adminDashboard"><i class="bi bi-bar-chart pe-3"></i> Dashboard</a>
        <a class="list-group-item recruiterA list-group-item-action list-group-item-light p-3" 
            href="/adminRoom"><i class="bi bi-box pe-3"></i> Rooms</a>
        <a class="list-group-item recruiterA list-group-item-action list-group-item-light p-3" 
            href="/adminReservation"><i class="bi bi-piggy-bank pe-3"></i> Reservations</a>
        <a class="list-group-item recruiterA list-group-item-action list-group-item-light p-3" 
            href="/adminCustomer"><i class="bi bi-clock-history pe-3"></i> Customers</a>
    </div>
    <div class="sidebar-footing border-top pt-3 text-center">
        <p class="text-center" id="dateDisplay"></p>
        <p class="text-center" id="clockDisplay"></p>

        <button type="button" id="logout" class="btn btn-sm py-2" data-title="Logout?">
            <i class="bi bi-box-arrow-left fs-4"></i>
        </button>
    </div>
</div>