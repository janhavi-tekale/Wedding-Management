<?php
require_once "php/auth.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Plan Your Event | EverAfter</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link rel="stylesheet"
          href="css/dashboard.css">

    <style>

        .event-page {
            max-width: 1000px;
            margin: 0 auto;
            padding-bottom: 50px;
        }

        .event-header {
            margin-bottom: 30px;
        }

        .event-header h1 {
            font-family: "Playfair Display", serif;
            font-size: 34px;
            margin-bottom: 8px;
        }

        .event-header p {
            color: #777;
        }

        .event-card {
            background: #fff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.06);
            margin-bottom: 25px;
        }

        .event-card h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }

        .event-types {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .event-type {
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: 0.2s;
            background: #fff;
        }

        .event-type:hover {
            border-color: #b76e79;
            transform: translateY(-2px);
        }

        .event-type.selected {
            border-color: #b76e79;
            background: #fff5f6;
        }

        .event-type .icon {
            font-size: 30px;
            margin-bottom: 8px;
        }

        .event-type strong {
            display: block;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            margin-bottom: 7px;
            font-weight: 600;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 12px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            font-family: inherit;
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .service-option {
            border: 1px solid #ddd;
            padding: 13px;
            border-radius: 8px;
            cursor: pointer;
        }

        .service-option:hover {
            border-color: #b76e79;
        }

        .service-option input {
            margin-right: 8px;
        }

        .submit-area {
            text-align: right;
            margin-top: 25px;
        }

        .submit-btn {
            border: none;
            padding: 14px 28px;
            border-radius: 8px;
            background: #b76e79;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        .submit-btn:hover {
            opacity: 0.9;
        }

        .hidden {
            display: none;
        }

        .message {
            margin-top: 15px;
            padding: 12px;
            border-radius: 8px;
            display: none;
        }

        .message.success {
            display: block;
            background: #e9f8ee;
            color: #237a3b;
        }

        .message.error {
            display: block;
            background: #fdecec;
            color: #a52a2a;
        }

        @media (max-width: 768px) {

            .event-types {
                grid-template-columns: repeat(2, 1fr);
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>

<body>

<div class="app">

    <!-- SIDEBAR -->

    <?php include "php/sidebar.php"; ?>

    <!-- MAIN -->

    <main class="main">

        <div class="event-page">

            <div class="event-header">

                <h1>Plan Your Event</h1>

                <p>
                    Tell us about your event and we'll help you find
                    the right services and vendors.
                </p>

            </div>


            <!-- EVENT TYPE -->

            <div class="event-card">

                <h2>What are you planning?</h2>

                <div class="event-types">

                    <div class="event-type"
                         data-event="Wedding">

                        <div class="icon">💍</div>
                        <strong>Wedding</strong>

                    </div>

                    <div class="event-type"
                         data-event="Engagement">

                        <div class="icon">💑</div>
                        <strong>Engagement</strong>

                    </div>

                    <div class="event-type"
                         data-event="Baby Shower">

                        <div class="icon">👶</div>
                        <strong>Baby Shower</strong>

                    </div>

                    <div class="event-type"
                         data-event="Birthday">

                        <div class="icon">🎂</div>
                        <strong>Birthday</strong>

                    </div>

                    <div class="event-type"
                         data-event="Anniversary">

                        <div class="icon">❤️</div>
                        <strong>Anniversary</strong>

                    </div>

                    <div class="event-type"
                         data-event="Party">

                        <div class="icon">🎉</div>
                        <strong>Party</strong>

                    </div>

                    <div class="event-type"
                         data-event="Corporate Event">

                        <div class="icon">🏢</div>
                        <strong>Corporate</strong>

                    </div>

                    <div class="event-type"
                         data-event="Other">

                        <div class="icon">✨</div>
                        <strong>Other</strong>

                    </div>

                </div>

            </div>


            <!-- EVENT DETAILS -->

            <form id="eventForm">

                <div class="event-card">

                    <h2>Event Details</h2>

                    <div class="form-grid">

                        <div class="form-group full">

                            <label>
                                Event Name
                            </label>

                            <input
                                type="text"
                                id="eventName"
                                placeholder="Example: Rahul & Priya Wedding"
                            >

                        </div>


                        <div class="form-group">

                            <label>
                                Event Date *
                            </label>

                            <input
                                type="date"
                                id="eventDate"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label>
                                City *
                            </label>

                            <input
                                type="text"
                                id="city"
                                placeholder="Example: Nanded"
                                required
                            >

                        </div>


                        <div class="form-group full">

                            <label>
                                Venue
                            </label>

                            <input
                                type="text"
                                id="venue"
                                placeholder="Venue name or location"
                            >

                        </div>


                        <div class="form-group">

                            <label>
                                Number of Guests *
                            </label>

                            <input
                                type="number"
                                id="guestCount"
                                min="1"
                                placeholder="Example: 300"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label>
                                Estimated Budget (₹) *
                            </label>

                            <input
                                type="number"
                                id="budget"
                                min="0"
                                placeholder="Example: 500000"
                                required
                            >

                        </div>


                        <div class="form-group full">

                            <label>
                                Additional Details
                            </label>

                            <textarea
                                id="description"
                                placeholder="Tell us anything else about your event..."
                            ></textarea>

                        </div>

                    </div>

                </div>


                <!-- SERVICES -->

                <div class="event-card">

                    <h2>
                        What services do you need?
                    </h2>

                    <div
                        id="servicesContainer"
                        class="services-grid">
                    </div>

                </div>


                <div class="submit-area">

                    <button
                        type="submit"
                        class="submit-btn">

                        Save & Continue →

                    </button>

                </div>

                <div
                    id="message"
                    class="message">
                </div>

            </form>

        </div>

    </main>

</div>


<script>

const eventTypes =
    document.querySelectorAll(".event-type");

const servicesContainer =
    document.getElementById("servicesContainer");

const form =
    document.getElementById("eventForm");

const message =
    document.getElementById("message");

let selectedEvent = "";


/*
|--------------------------------------------------------------------------
| SERVICES FOR EACH EVENT
|--------------------------------------------------------------------------
*/

const eventServices = {

    "Wedding": [
        "Venue",
        "Photography",
        "Videography",
        "Catering",
        "Decoration",
        "Makeup Artist",
        "Mehendi",
        "DJ / Music",
        "Invitation",
        "Wedding Planner"
    ],

    "Engagement": [
        "Venue",
        "Photography",
        "Decoration",
        "Catering",
        "Makeup Artist",
        "DJ / Music",
        "Invitation"
    ],

    "Baby Shower": [
        "Venue",
        "Decoration",
        "Photography",
        "Catering",
        "Cake",
        "Makeup Artist",
        "Games / Entertainment",
        "Invitation"
    ],

    "Birthday": [
        "Venue",
        "Decoration",
        "Photography",
        "Catering",
        "Cake",
        "DJ / Music",
        "Entertainment",
        "Invitation"
    ],

    "Anniversary": [
        "Venue",
        "Decoration",
        "Photography",
        "Catering",
        "Cake",
        "Makeup Artist",
        "DJ / Music"
    ],

    "Party": [
        "Venue",
        "Decoration",
        "Catering",
        "Photography",
        "DJ / Music",
        "Entertainment",
        "Cake"
    ],

    "Corporate Event": [
        "Venue",
        "Catering",
        "Photography",
        "Decoration",
        "Audio / Visual",
        "Event Management",
        "Entertainment"
    ],

    "Other": [
        "Venue",
        "Photography",
        "Catering",
        "Decoration",
        "Entertainment",
        "Event Management"
    ]

};


/*
|--------------------------------------------------------------------------
| SELECT EVENT
|--------------------------------------------------------------------------
*/

eventTypes.forEach(type => {

    type.addEventListener("click", function() {

        eventTypes.forEach(item => {
            item.classList.remove("selected");
        });

        this.classList.add("selected");

        selectedEvent =
            this.dataset.event;

        loadServices(selectedEvent);

    });

});


/*
|--------------------------------------------------------------------------
| LOAD SERVICES
|--------------------------------------------------------------------------
*/

function loadServices(eventType) {

    servicesContainer.innerHTML = "";

    const services =
        eventServices[eventType] || [];

    services.forEach((service, index) => {

        const label =
            document.createElement("label");

        label.className =
            "service-option";

        label.innerHTML = `

            <input
                type="checkbox"
                name="services"
                value="${service}"
            >

            ${service}

        `;

        servicesContainer.appendChild(label);

    });

}


/*
|--------------------------------------------------------------------------
| SUBMIT EVENT
|--------------------------------------------------------------------------
*/

form.addEventListener("submit", async function(e) {

    e.preventDefault();


    if (!selectedEvent) {

        showMessage(
            "Please select your event type first.",
            "error"
        );

        return;
    }


    const selectedServices =
        Array.from(
            document.querySelectorAll(
                'input[name="services"]:checked'
            )
        ).map(input => input.value);


    const eventData = {

        event_type: selectedEvent,

        event_name:
            document.getElementById("eventName").value,

        event_date:
            document.getElementById("eventDate").value,

        city:
            document.getElementById("city").value,

        venue:
            document.getElementById("venue").value,

        guest_count:
            document.getElementById("guestCount").value,

        budget:
            document.getElementById("budget").value,

        description:
            document.getElementById("description").value,

        services:
            selectedServices

    };


    try {

        const response =
            await fetch(
                "php/api.php?action=create_event",
                {
                    method: "POST",

                    headers: {
                        "Content-Type":
                            "application/json"
                    },

                    body:
                        JSON.stringify(eventData)
                }
            );


        const result =
            await response.json();


        if (result.success) {

            showMessage(
                "Event created successfully!",
                "success"
            );


            form.reset();

            eventTypes.forEach(item => {
                item.classList.remove("selected");
            });

            servicesContainer.innerHTML = "";

            selectedEvent = "";

        } else {

            showMessage(
                result.message ||
                "Unable to create event.",
                "error"
            );

        }

    } catch (error) {

        console.error(error);

        showMessage(
            "Unable to connect to the server.",
            "error"
        );

    }

});


/*
|--------------------------------------------------------------------------
| MESSAGE
|--------------------------------------------------------------------------
*/

function showMessage(text, type) {

    message.textContent = text;

    message.className =
        "message " + type;

}

</script>

</body>

</html>