<?php
require_once "php/auth.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<link rel="icon" type="image/png" href="assets/images/favicon.png">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>My Events | EverAfter</title>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="css/dashboard.css">

<style>

.events-header {
    display:flex;
    justify-content:space-between;
    align-items:flex-end;
    margin-bottom:28px;
    gap:20px;
}

.create-event-btn {
    background:#9a5b63;
    color:white;
    border:0;
    padding:11px 18px;
    border-radius:99px;
    font-size:10px;
    cursor:pointer;
    text-decoration:none;
}

.events-grid {
    display:grid;
    grid-template-columns:repeat(2, minmax(0, 1fr));
    gap:20px;
}

.event-card {
    background:white;
    border:1px solid #e8dfdc;
    border-radius:18px;
    overflow:hidden;
    transition:.2s ease;
}

.event-card:hover {
    transform:translateY(-2px);
    box-shadow:0 12px 30px rgba(40,25,28,.08);
}

.event-card-top {
    padding:24px 25px 20px;
    border-bottom:1px solid #eee5e2;
}

.event-type {
    color:#9a5b63;
    font-size:9px;
    font-weight:700;
    letter-spacing:1.2px;
    text-transform:uppercase;
}

.event-card h2 {
    font-family:"Playfair Display",serif;
    font-size:25px;
    margin:7px 0 15px;
    color:#292023;
}

.event-status {
    display:inline-block;
    padding:5px 10px;
    border-radius:99px;
    background:#f3e8e6;
    color:#9a5b63;
    font-size:8px;
    text-transform:capitalize;
}

.event-details {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
    padding:20px 25px;
}

.event-detail small {
    display:block;
    color:#777074;
    font-size:8px;
    margin-bottom:5px;
    text-transform:uppercase;
    letter-spacing:.5px;
}

.event-detail strong {
    font-size:11px;
    color:#393133;
}

.event-card-bottom {
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:16px 25px;
    background:#fcf9f8;
}

.event-budget {
    font-family:"Playfair Display",serif;
    font-size:20px;
    color:#9a5b63;
}

.manage-event-btn {
    background:#292023;
    color:white;
    border:0;
    border-radius:99px;
    padding:9px 16px;
    font-size:9px;
    cursor:pointer;
}

.empty-events {
    background:white;
    border:1px solid #e8dfdc;
    border-radius:18px;
    padding:60px 20px;
    text-align:center;
}

.empty-events .icon {
    font-size:38px;
    margin-bottom:12px;
}

.empty-events h2 {
    font-family:"Playfair Display",serif;
    margin:0 0 8px;
}

.empty-events p {
    color:#777074;
    font-size:11px;
    margin-bottom:20px;
}

.loading-events {
    color:#777074;
    font-size:11px;
    padding:30px 0;
}

.error-events {
    color:#a23b3b;
    font-size:11px;
    padding:30px 0;
}

@media(max-width:850px) {

    .events-grid {
        grid-template-columns:1fr;
    }

}

@media(max-width:600px) {

    .events-header {
        align-items:flex-start;
        flex-direction:column;
    }

    .event-details {
        grid-template-columns:1fr;
    }

    .event-card-bottom {
        gap:15px;
    }

}

</style>

</head>

<body>

<div class="app">

<?php include "php/sidebar.php"; ?>


<main class="main">

<header class="dashboard-top events-header">

<div>

<span class="eyebrow">
EVENT MANAGEMENT
</span>

<h1>
My Events
</h1>

<p style="
color:#777074;
font-size:11px;
margin-top:6px;
">
Manage all your events from one place.
</p>

</div>

<a
href="plan-event.php"
class="create-event-btn">

+ Create New Event

</a>

</header>


<div id="eventsContainer">

<div class="loading-events">
Loading your events...
</div>

</div>


</main>

</div>


<script>

let allEvents = [];


/* =========================
   LOAD EVENTS
========================= */

async function loadEvents() {

    const container =
        document.getElementById(
            "eventsContainer"
        );

    try {

        const response =
            await fetch(
                "php/api.php?action=my_events",
                {
                    credentials:
                        "same-origin"
                }
            );

        const result =
            await response.json();

        console.log(
            "MY EVENTS:",
            result
        );


        if (!result.success) {

            container.innerHTML = `
                <div class="error-events">
                    ${escapeHtml(
                        result.message ||
                        "Unable to load events."
                    )}
                </div>
            `;

            return;

        }


        allEvents =
            result.data || [];


        if (!allEvents.length) {

            container.innerHTML = `

                <div class="empty-events">

                    <div class="icon">
                        ✦
                    </div>

                    <h2>
                        No Events Yet
                    </h2>

                    <p>
                        Create your first event to start planning.
                    </p>

                    <a
                        href="plan-event.php"
                        class="create-event-btn">

                        + Create Event

                    </a>

                </div>

            `;

            return;

        }


        renderEvents();


    } catch(error) {

        console.error(
            "Events loading failed:",
            error
        );

        container.innerHTML = `
            <div class="error-events">
                Unable to load your events.
            </div>
        `;

    }

}


/* =========================
   RENDER EVENTS
========================= */

function renderEvents() {

    const container =
        document.getElementById(
            "eventsContainer"
        );

    container.className =
        "events-grid";

    container.innerHTML = "";


    allEvents.forEach(
        function(event) {

            const card =
                document.createElement(
                    "div"
                );

            card.className =
                "event-card";


            card.innerHTML = `

                <div class="event-card-top">

                    <span class="event-type">
                        ${escapeHtml(
                            event.event_type
                        )}
                    </span>

                    <h2>
                        ${escapeHtml(
                            event.event_name ||
                            event.event_type +
                            " Event"
                        )}
                    </h2>

                    <span class="event-status">
                        ${escapeHtml(
                            event.status ||
                            "planning"
                        )}
                    </span>

                </div>


                <div class="event-details">

                    <div class="event-detail">

                        <small>
                            Event Date
                        </small>

                        <strong>
                            ${formatDate(
                                event.event_date
                            )}
                        </strong>

                    </div>


                    <div class="event-detail">

                        <small>
                            Location
                        </small>

                        <strong>
                            ${escapeHtml(
                                event.city ||
                                "Not specified"
                            )}
                        </strong>

                    </div>


                    <div class="event-detail">

                        <small>
                            Guests
                        </small>

                        <strong>
                            ${Number(
                                event.guest_count || 0
                            ).toLocaleString(
                                "en-IN"
                            )}
                        </strong>

                    </div>


                    <div class="event-detail">

                        <small>
                            Venue
                        </small>

                        <strong>
                            ${escapeHtml(
                                event.venue ||
                                "Not specified"
                            )}
                        </strong>

                    </div>

                </div>


                <div class="event-card-bottom">

                    <div>

                        <small style="
                            display:block;
                            color:#777074;
                            font-size:8px;
                            margin-bottom:3px;
                        ">
                            EVENT BUDGET
                        </small>

                        <span class="event-budget">
                            ${formatCurrency(
                                event.budget
                            )}
                        </span>

                    </div>


                    <button
                        class="manage-event-btn"
                        onclick="manageEvent(
                            ${event.id}
                        )">

                        Manage Event

                    </button>

                </div>

            `;


            container.appendChild(
                card
            );

        }
    );

}


async function manageEvent(eventId) {

    try {

        const response = await fetch(
            "php/api.php?action=select_event",
            {
                method: "POST",

                headers: {
                    "Content-Type": "application/json"
                },

                credentials: "same-origin",

                body: JSON.stringify({
                    event_id: eventId
                })
            }
        );

        const result = await response.json();

        console.log(
            "SELECT EVENT:",
            result
        );

        if (!result.success) {

            alert(
                result.message ||
                "Unable to select event."
            );

            return;
        }

        // Go to dashboard after selecting event
        window.location.href =
            "dashboard.php";

    } catch (error) {

        console.error(
            "Select event error:",
            error
        );

        alert(
            "Something went wrong while selecting the event."
        );

    }

}


/* =========================
   DATE
========================= */

function formatDate(date) {

    if (!date) {

        return "Not specified";

    }

    const parts =
        date.split("-");


    if (parts.length !== 3) {

        return date;

    }


    const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
    ];


    return (
        parseInt(parts[2]) +
        " " +
        months[
            parseInt(parts[1]) - 1
        ] +
        " " +
        parts[0]
    );

}


/* =========================
   CURRENCY
========================= */

function formatCurrency(amount) {

    return "₹" +
        Number(
            amount || 0
        ).toLocaleString(
            "en-IN",
            {
                maximumFractionDigits:0
            }
        );

}


/* =========================
   ESCAPE HTML
========================= */

function escapeHtml(value) {

    return String(
        value ?? ""
    )
    .replace(/&/g,"&amp;")
    .replace(/</g,"&lt;")
    .replace(/>/g,"&gt;")
    .replace(/"/g,"&quot;")
    .replace(/'/g,"&#039;");

}


/* =========================
   LOGOUT
========================= */

async function logoutUser() {

    await fetch(
        "php/api.php?action=logout",
        {
            credentials:
                "same-origin"
        }
    );

    location.href =
        "index.html";

}


/* =========================
   START
========================= */

document.addEventListener(
    "DOMContentLoaded",
    function() {

        loadEvents();

    }
);

</script>

</body>

</html>