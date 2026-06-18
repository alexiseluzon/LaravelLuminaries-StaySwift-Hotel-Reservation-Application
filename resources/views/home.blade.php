<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stay Swift Hotel Reservation</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body, html {
            height: 100%;
            font-family: 'Montserrat', sans-serif;
            background-color: #1a1612;
            color: #d4c4a8;
            overflow-x: hidden;
        }

        /* HERO */
        .hero {
            background: #221e18;
            border-bottom: 1px solid #3a3228;
            padding: 72px 40px 60px;
            text-align: center;
        }

        .hero-icon {
            width: 52px; height: 52px;
            border-radius: 50%;
            border: 1px solid #c9a96e;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
        }

        .hero-icon img {
            width: 28px;
            opacity: 0.85;
            filter: brightness(0) saturate(100%) invert(72%) sepia(30%) saturate(600%) hue-rotate(5deg) brightness(95%);
        }

        .brand-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 48px;
            font-weight: 300;
            color: #e8dcc8;
            letter-spacing: 0.22em;
            display: block;
            margin-bottom: 10px;
        }

        .brand-sub {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 16px;
            color: #7a6a56;
            letter-spacing: 0.1em;
            display: block;
            margin-bottom: 36px;
        }

        .gold-line {
            height: 1px;
            background: linear-gradient(90deg, transparent, #c9a96e, transparent);
            width: 160px;
            margin: 0 auto 36px;
        }

        .hero-btns {
            display: flex;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn {
            font-family: 'Montserrat', sans-serif;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            padding: 13px 32px;
            border-radius: 1px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s, color 0.2s, border-color 0.2s;
            display: inline-block;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: #c9a96e;
            color: #1a1612;
            border-color: #c9a96e;
        }
        .btn-primary:hover { background: #e8cfa0; border-color: #e8cfa0; }

        .btn-ghost {
            background: transparent;
            color: #c9a96e;
            border-color: #3a3228;
        }
        .btn-ghost:hover { border-color: #c9a96e; }

        /* SECTIONS */
        .section {
            padding: 48px 40px;
            max-width: 900px;
            margin: 0 auto;
        }

        .section-divider {
            height: 1px;
            background: #3a3228;
            margin: 0 40px;
        }

        .section-label {
            font-size: 8px;
            letter-spacing: 0.28em;
            text-transform: uppercase;
            color: #c9a96e;
            margin-bottom: 28px;
            padding-bottom: 10px;
            border-bottom: 1px solid #3a3228;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-label::before {
            content: '';
            display: inline-block;
            width: 18px; height: 1px;
            background: #c9a96e;
        }

        /* ROOMS */
        .rooms-list { display: flex; flex-direction: column; gap: 10px; }

        .room-card {
            background: #221e18;
            border: 1px solid #3a3228;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        .room-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: none;
            border-bottom: 1px solid #3a3228;
            flex-shrink: 0;
        }

        .room-info {
            padding: 16px 20px;
        }

        .room-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 18px;
            font-weight: 400;
            color: #e8dcc8;
            letter-spacing: 0.08em;
            display: block;
            margin-bottom: 4px;
        }

        .room-price {
            font-size: 11px;
            color: #7a6a56;
            letter-spacing: 0.1em;
        }

        .room-price span { color: #c9a96e; }

        /* OFFERS */
        .offers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 14px;
        }

        .offer-card {
            background: #221e18;
            border: 1px solid #3a3228;
            padding: 20px;
        }

        .offer-title {
            font-size: 12px;
            color: #e8dcc8;
            letter-spacing: 0.06em;
            margin-bottom: 6px;
        }

        .offer-desc {
            font-size: 11px;
            color: #7a6a56;
            line-height: 1.6;
        }

        /* AMENITIES */
        .amenities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 10px;
        }

        .amenity-item {
            background: #221e18;
            border: 1px solid #3a3228;
            padding: 12px 16px;
            font-size: 11px;
            color: #d4c4a8;
            letter-spacing: 0.06em;
        }

        /* TESTIMONIALS */
        .testimonial {
            background: #221e18;
            border: 1px solid #3a3228;
            border-left: 2px solid #c9a96e;
            padding: 20px 24px;
            margin-bottom: 12px;
        }

        .testimonial p {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 15px;
            color: #d4c4a8;
            line-height: 1.7;
        }

        /* FOOTER */
        .footer {
            background: #221e18;
            border-top: 1px solid #3a3228;
            padding: 28px 40px;
            text-align: center;
        }

        .footer span {
            font-size: 10px;
            color: #5a4e3e;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        @media (max-width: 520px) {
            .hero { padding: 48px 20px 44px; }
            .section { padding: 36px 20px; }
            .section-divider { margin: 0 20px; }
        }
    </style>
</head>
<body>

    {{-- HERO --}}
    <div class="hero">
        <div class="hero-icon">
            <img src="{{ URL('/img/StaySwift Logo no bg.png') }}" alt="StaySwift">
        </div>
        <span class="brand-name">Stay Swift</span>
        <span class="brand-sub">Your dream vacation awaits</span>
        <div class="gold-line"></div>
        <div class="hero-btns">
            <a href="/login" class="btn btn-primary">Book Now</a>
            <a href="/adminLogin" class="btn btn-ghost">Login as Admin</a>
        </div>
    </div>

    {{-- FEATURED ROOMS --}}
    <div class="section">
        <div class="section-label">Featured Rooms</div>
        <div class="rooms-list" id="featuredRoomsContainer"></div>
    </div>

    <div class="section-divider"></div>

    {{-- SPECIAL OFFERS --}}
    <div class="section">
        <div class="section-label">Special Offers</div>
        <div class="offers-grid">
            <div class="offer-card">
                <div class="offer-title">Early Bird Discount</div>
                <div class="offer-desc">Book 14 days in advance and save up to 20% on any room.</div>
            </div>
            <div class="offer-card">
                <div class="offer-title">Stay 3, Get 1 Free</div>
                <div class="offer-desc">Book 3 nights and your 4th night is completely on us.</div>
            </div>
        </div>
    </div>

    <div class="section-divider"></div>

    {{-- AMENITIES --}}
    <div class="section">
        <div class="section-label">Hotel Amenities</div>
        <div class="amenities-grid">
            <div class="amenity-item">Swimming Pool</div>
            <div class="amenity-item">Gym</div>
            <div class="amenity-item">Free Wi-Fi</div>
            <div class="amenity-item">Fitness Center</div>
            <div class="amenity-item">Spa & Wellness Center</div>
            <div class="amenity-item">Restaurant & Bar</div>
            <div class="amenity-item">Business Center</div>
            <div class="amenity-item">Room Service</div>
            <div class="amenity-item">Concierge Service</div>
            <div class="amenity-item">Laundry Service</div>
            <div class="amenity-item">Parking Facilities</div>
            <div class="amenity-item">Shuttle Service</div>
            <div class="amenity-item">Airport Transfer</div>
            <div class="amenity-item">24-Hour Front Desk</div>
            <div class="amenity-item">Conference Rooms</div>
            <div class="amenity-item">Banquet Facilities</div>
            <div class="amenity-item">Pet-Friendly</div>
            <div class="amenity-item">Childcare Services</div>
            <div class="amenity-item">Gift Shop</div>
            <div class="amenity-item">Currency Exchange</div>
            <div class="amenity-item">Elevator</div>
        </div>
    </div>

    <div class="section-divider"></div>

    {{-- TESTIMONIALS --}}
    <div class="section">
        <div class="section-label">Guest Testimonials</div>
        <div class="testimonial">
            <p>"User-friendly and efficient hotel reservation application that offers seamless booking experiences!"</p>
        </div>
        <div class="testimonial">
            <p>"Featuring a wide range of accommodations, exclusive packages, and intuitive search functionalities."</p>
        </div>
    </div>

    <div class="footer">
        <span>Stay Swift &mdash; Where comfort meets elegance</span>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetchRooms();
        });

        function fetchRooms() {
            fetch('/rooms')
                .then(response => response.json())
                .then(rooms => {
                    const container = document.getElementById('featuredRoomsContainer');
                    container.innerHTML = '';
                    let roomIndex = 0;

                    function displayRoom() {
                        const room = rooms[roomIndex];
                        container.innerHTML = `
                            <div class="room-card">
                                <img src="${room.photos}" alt="${room.type_of_room}">
                                <div class="room-info">
                                    <span class="room-name">${room.type_of_room}</span>
                                    <div class="room-price">Starting at <span>&#8369;${room.price} / night</span></div>
                                </div>
                            </div>
                        `;
                        roomIndex = (roomIndex + 1) % rooms.length;
                    }

                    displayRoom();
                    setInterval(displayRoom, 5000);
                })
                .catch(error => console.error('Error fetching rooms:', error));
        }
    </script>
</body>
</html>