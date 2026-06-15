function getPhTime() {
    return new Date(new Date().toLocaleString('en-US', { timeZone: 'Asia/Manila' }));
}

function renderTime() {
    const days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    const d = getPhTime();

    document.getElementById("dateDisplay").innerText =
        `${months[d.getMonth()]} ${d.getDate()}, ${d.getFullYear()}`;
}

function displayClock() {
    document.getElementById("clockDisplay").innerText =
        new Date().toLocaleTimeString('en-US', { timeZone: 'Asia/Manila' });
    setTimeout(displayClock, 1000);
}

renderTime();
displayClock();