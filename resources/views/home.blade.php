<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stay Swift Hotel Reservation</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Roboto', sans-serif;
            background-color: #ff8c00;
            color: #333;
            overflow-x: hidden;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .container {
            position: relative;
            z-index: 2;
            padding: 40px;
            max-width: 1200px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh; /* This ensures the container takes up the full viewport height */
        }

        .title {
            text-align: center;
            font-size: 48px;
            font-weight: 700;
            color: #ff8c00;
            margin-bottom: 20px;
        }

        .headline {
            text-align: center;
            font-size: 24px;
            font-weight: 300;
            margin-bottom: 40px;
            color: #555;
        }

        .section-title {
            text-align: center;
            font-size: 28px;
            font-weight: 700;
            margin: 40px 0 20px;
            color: #ff8c00;
        }

        .featured-card-container, .special-offers-content, .hotel-amenities-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .featured-card, .special-offer-item, .hotel-amenity-item {
            background: #fff;
            color: #333;
            margin: 20px 0;
            border-radius: 10px;
            overflow: hidden;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            width: calc(50% - 10px);
        }

        .featured-card img, .special-offer-item img, .hotel-amenity-item img {
            width: 100%;
            max-height: 300px;
            object-fit: contain;
        }

        .featured-card-content, .special-offer-item-content, .hotel-amenity-item-content {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .featured-card-content h3, .special-offer-item-content h3, .hotel-amenity-item-content h3 {
            font-size: 22px;
            font-weight: 700;
            margin: 10px 0;
        }

        .featured-card-content p, .special-offer-item-content p, .hotel-amenity-item-content p {
            font-size: 18px;
            font-weight: 400;
            color: #777;
        }

        .special-offers, .hotel-amenities, .testimonials {
            margin: 20px 0;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .special-offers p, .hotel-amenities p, .testimonials p {
            margin: 10px 0;
            font-size: 18px;
            font-weight: 400;
            color: #555;
        }

        .special-offer-item, .hotel-amenity-item {
            display: flex;
            align-items: center;
            background-color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .special-offer-item img, .hotel-amenity-item img {
            width: 40px;
            height: 40px;
            margin-right: 20px;
        }

        .special-offer-item p, .hotel-amenity-item p {
            font-size: 18px;
            font-weight: 400;
            color: #333;
            margin: 0;
        }

        .book-now {
            display: flex;
            justify-content: center;
            margin: 40px 0;
        }

        .book-now-button, .developers-button {
            background-color: #ff8c00;
            color: white;
            padding: 15px 30px;
            border-radius: 30px;
            border: none;
            cursor: pointer;
            margin: 0 10px;
            font-size: 18px;
            font-weight: 700;
            transition: background-color 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }

        .book-now-button:hover, .developers-button:hover {
            background-color: #ff7000;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="container">
        <div class="title">Stay Swift</div>
        <div class="headline">Your Dream Vacation Awaits</div>

        <div class="section-title">Featured Rooms</div>
        <div class="featured-card-container" id="featuredRoomsContainer"></div>

        <div class="section-title">Special Offers & Discounts</div>
        <div class="special-offers">
            <div class="special-offers-content">
                <div class="special-offer-item">
                    <p>Early Bird Discount!</p>
                </div>
                <div class="special-offer-item">
                    <p>Stay 3 nights, get 1 night free!</p>
                </div>
            </div>
        </div>

        <div class="section-title">Hotel Amenities</div>
        <div class="hotel-amenities">
            <div class="hotel-amenities-content">
                <div class="hotel-amenity-item">
                    <p>Swimming Pool</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>Gym</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>Free Wi-Fi</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>Fitness Center</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>Spa & Wellness Center</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>Restaurant & Bar</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>Business Center</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>Room Service</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>Concierge Service</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>Laundry Service</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>Parking Facilities</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>Shuttle Service</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>Airport Transfer</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>24-Hour Front Desk</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>Conference Rooms</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>Banquet Facilities</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>Pet-Friendly Accommodations</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>Childcare Services</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>Gift Shop</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>Currency Exchange</p>
                </div>
                <div class="hotel-amenity-item">
                    <p>Elevator</p>
                </div>
            </div>
        </div>

        <div class="section-title">Customer Testimonials</div>
        <div class="testimonials">
            <p>"User-friendly and efficient hotel reservation application that offers seamless booking experiences!" - Alexis Luzon</p>
            <p>"Featuring a wide range of accommodations, exclusive packages, and intuitive search functionalities." - Justyn Mejia</p>
        </div>

        <div class="book-now">
            <a href="/login" class="book-now-button">Book Now</a>
            <a href="/adminLogin" class="book-now-button">Login as Admin</a>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchRooms();
        });

        function fetchRooms() {
            fetch('/rooms')
                .then(response => response.json())
                .then(rooms => {
                    const container = document.getElementById('featuredRoomsContainer');
                    container.innerHTML = ''; // Clear any existing content
                    let roomIndex = 0;

                    function displayRoom() {
                        const room = rooms[roomIndex];
                        container.innerHTML = `
                            <div class="featured-card">
                                <img src="${room.photos}" alt="${room.type_of_room}">
                                <div class="featured-card-content">
                                    <h3>${room.type_of_room}</h3>
                                    <p>Starting at $${room.price_per_hour}/night</p>
                                </div>
                            </div>
                        `;
                        roomIndex = (roomIndex + 1) % rooms.length;
                    }

                    // Display the first room immediately
                    displayRoom();

                    // Change the room every 5 seconds
                    setInterval(displayRoom, 1000);
                })
                .catch(error => console.error('Error fetching rooms:', error));
        }
    </script>
</body>
</html>