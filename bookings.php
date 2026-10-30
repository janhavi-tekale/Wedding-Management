<?php
require_once "php/auth.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" type="image/png" href="assets/images/favicon.png">
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Bookings | EverAfter</title>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet" href="css/dashboard.css">

<style>

.booking {
    display: grid;
    grid-template-columns: 50px 1fr 150px 150px;
    align-items: center;
    gap: 18px;
    padding: 20px 0;
    border-bottom: 1px solid #eee5e2;
}

.booking:last-child {
    border-bottom: none;
}

.booking-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: #f2e5e3;
    color: #9a5b63;
    display: grid;
    place-items: center;
    font-size: 19px;
}

.booking-info strong {
    display: block;
    font-size: 13px;
    color: #333;
}

.booking-info small {
    display: block;
    color: #777074;
    font-size: 9px;
    margin-top: 5px;
}

.booking-details {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.booking-detail-row {
    display: flex;
    justify-content: space-between;
    gap: 15px;
    font-size: 9px;
}

.booking-detail-row span:first-child {
    color: #888;
}

.booking-detail-row span:last-child {
    font-weight: 700;
    color: #444;
}

.booking-price {
    font-size: 12px;
    font-weight: 700;
}

.booking-remaining {
    color: #a34d4d !important;
}

.booking-paid {
    color: #4d7e5a !important;
}

.booking-actions {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 8px;
}

.booking-status {
    font-size: 8px;
    font-weight: 800;
    padding: 6px 10px;
    border-radius: 99px;
    text-align: center;
    display: inline-block;
}

.confirmed {
    background: #e6f1e9;
    color: #4d7e5a;
}

.pending {
    background: #fff0d5;
    color: #9c6d24;
}

.cancelled {
    background: #f9e1e1;
    color: #a34d4d;
}

.completed {
    background: #e5edf7;
    color: #526f91;
}

.payment-status {
    font-size: 8px;
    font-weight: 700;
    padding: 5px 8px;
    border-radius: 99px;
    background: #f2f2f2;
    color: #666;
}

.payment-paid {
    background: #e6f1e9;
    color: #4d7e5a;
}

.payment-partial {
    background: #fff0d5;
    color: #9c6d24;
}

.payment-unpaid {
    background: #f9e1e1;
    color: #a34d4d;
}

.payment-refunded {
    background: #e5edf7;
    color: #526f91;
}

.cancel-booking-btn {
    border: none;
    background: transparent;
    color: #a34d4d;
    font-size: 9px;
    font-weight: 700;
    cursor: pointer;
    padding: 3px 0;
}

.cancel-booking-btn:hover {
    text-decoration: underline;
}

.booking-notes {
    margin-top: 7px;
    font-size: 9px;
    color: #888;
    font-style: italic;
}

.booking-empty {
    padding: 60px 20px;
    text-align: center;
    color: #777074;
}

.booking-empty h3 {
    margin: 0 0 8px;
    color: #333;
    font-size: 18px;
}

.booking-empty p {
    margin: 0;
    font-size: 13px;
}

.booking-loading {
    padding: 50px 20px;
    text-align: center;
    color: #777074;
    font-size: 13px;
}

.booking-error {
    padding: 50px 20px;
    text-align: center;
    color: #a34d4d;
    font-size: 13px;
}

@media(max-width:900px) {

    .booking {
        grid-template-columns: 45px 1fr 130px;
    }

    .booking-actions {
        grid-column: 2 / 4;
        align-items: flex-start;
        margin-top: 8px;
    }

}

@media(max-width:600px) {

    .booking {
        grid-template-columns: 42px 1fr;
        gap: 12px;
    }

    .booking-details {
        grid-column: 2;
        margin-top: 8px;
    }

    .booking-actions {
        grid-column: 2;
        align-items: flex-start;
        margin-top: 5px;
    }

    .booking-icon {
        width: 40px;
        height: 40px;
    }

}

</style>

</head>

<body>

<div class="app">

<?php include "php/sidebar.php"; ?>

<main class="main">

<header class="dashboard-top">

<div>

<span class="eyebrow">
BOOKING MANAGEMENT
</span>

<h1>
Your Bookings
</h1>

</div>

<a href="vendors.php" class="primary-button">
+ Find Vendors
</a>

</header>


<div class="panel">

<div class="panel-header">

<div>

<span class="eyebrow">
BOOKING HISTORY
</span>

<h3>
All Bookings
</h3>

</div>

</div>


<!-- REAL BOOKINGS LOAD HERE -->

<div id="bookingList">

    <div class="booking-loading">
        Loading bookings...
    </div>

</div>


</div>

</main>

</div>


<script>

async function loadBookings() {

    const bookingList = document.getElementById("bookingList");

    if (!bookingList) {
        return;
    }

    bookingList.innerHTML = `
        <div class="booking-loading">
            Loading bookings...
        </div>
    `;

    try {

        const response = await fetch(
            "php/api.php?action=my_bookings"
        );

        const result = await response.json();

        console.log("Bookings API:", result);

        if (!result.success) {

            bookingList.innerHTML = `
                <div class="booking-error">
                    ${escapeHtml(
                        result.message || "Unable to load bookings."
                    )}
                </div>
            `;

            return;
        }


        const bookings = result.data || [];


        /* NO BOOKINGS */

        if (bookings.length === 0) {

            bookingList.innerHTML = `
                <div class="booking-empty">

                    <h3>No bookings yet</h3>

                    <p>
                        Book a vendor from the Vendors section
                        to see your bookings here.
                    </p>

                </div>
            `;

            return;
        }


        /* DISPLAY BOOKINGS */

/* DISPLAY BOOKINGS */

bookingList.innerHTML = bookings.map(booking => {

    const amount = Number(
        booking.amount || 0
    );

    const paidAmount = Number(
        booking.paid_amount || 0
    );

    const remainingAmount = Number(
        booking.remaining_amount ??
        (amount - paidAmount)
    );

    const formattedAmount =
        amount.toLocaleString("en-IN");

    const formattedPaid =
        paidAmount.toLocaleString("en-IN");

    const formattedRemaining =
        Math.max(0, remainingAmount)
            .toLocaleString("en-IN");


    /* BOOKING STATUS */

    const rawStatus =
        String(
            booking.status || "Pending"
        );

    const status =
        rawStatus.charAt(0).toUpperCase()
        + rawStatus.slice(1).toLowerCase();

    const statusClass =
        rawStatus.toLowerCase();


    /* PAYMENT STATUS */

    const paymentStatus =
        booking.payment_status ||
        "Unpaid";

    const paymentClass =
        paymentStatus
            .toLowerCase()
            .replace(/\s+/g, "-");


    /* CANCEL BUTTON */

    const canCancel =
        rawStatus.toLowerCase() !== "cancelled";


    /* NOTES */

    const notesHtml =
        booking.notes
        ? `
            <div class="booking-notes">
                ${escapeHtml(booking.notes)}
            </div>
        `
        : "";


    return `

        <div class="booking">

            <!-- ICON -->

            <div class="booking-icon">
                ${getVendorIcon(booking.category)}
            </div>


            <!-- VENDOR -->

            <div class="booking-info">

                <strong>
                    ${escapeHtml(
                        booking.name || "Vendor"
                    )}
                </strong>

                <small>

                    ${escapeHtml(
                        booking.category || "Service"
                    )}

                    •

                    ${formatBookingDate(
                        booking.booking_date
                    )}

                </small>

                ${notesHtml}

            </div>


            <!-- PAYMENT DETAILS -->

            <div class="booking-details">

                <div class="booking-detail-row">

                    <span>
                        Total
                    </span>

                    <span>
                        ₹${formattedAmount}
                    </span>

                </div>


                <div class="booking-detail-row">

                    <span>
                        Paid
                    </span>

                    <span class="booking-paid">
                        ₹${formattedPaid}
                    </span>

                </div>


                <div class="booking-detail-row">

                    <span>
                        Remaining
                    </span>

                    <span class="booking-remaining">
                        ₹${formattedRemaining}
                    </span>

                </div>

            </div>


            <!-- STATUS + ACTIONS -->

            <div class="booking-actions">

                <span class="booking-status ${escapeHtml(statusClass)}">
                    ${escapeHtml(status)}
                </span>


                <span class="payment-status payment-${escapeHtml(paymentClass)}">
                    ${escapeHtml(paymentStatus)}
                </span>


                ${
                    canCancel
                    ? `
                        <button
                            type="button"
                            class="cancel-booking-btn"
                            onclick="cancelBooking(${Number(booking.id)})">

                            Cancel Booking

                        </button>
                    `
                    : ""
                }

            </div>

        </div>

    `;

}).join("");


    } catch (error) {

        console.error(
            "Booking loading error:",
            error
        );

        bookingList.innerHTML = `
            <div class="booking-error">
                Unable to load bookings.
                Please refresh the page.
            </div>
        `;

    }

}


/* DATE FORMAT */

function formatBookingDate(dateString) {

    if (!dateString) {
        return "Date not set";
    }

    const date = new Date(dateString);

    if (isNaN(date.getTime())) {
        return dateString;
    }

    return date.toLocaleDateString(
        "en-IN",
        {
            day: "2-digit",
            month: "short",
            year: "numeric"
        }
    );

}


/* VENDOR ICON */

function getVendorIcon(category) {

    if (!category) {
        return "📋";
    }

    const value = category.toLowerCase();

    if (
        value.includes("venue") ||
        value.includes("hall") ||
        value.includes("hotel")
    ) {
        return "🏛";
    }

    if (
        value.includes("photo") ||
        value.includes("video")
    ) {
        return "📷";
    }

    if (
        value.includes("cater") ||
        value.includes("food")
    ) {
        return "🍽";
    }

    if (
        value.includes("decor") ||
        value.includes("flower")
    ) {
        return "🌸";
    }

    if (
        value.includes("music") ||
        value.includes("dj")
    ) {
        return "🎵";
    }

    if (
        value.includes("makeup") ||
        value.includes("beauty")
    ) {
        return "💄";
    }

    return "📋";

}


/* SECURITY */

function escapeHtml(value) {

    const div = document.createElement("div");

    div.textContent = value ?? "";

    return div.innerHTML;

}


async function cancelBooking(bookingId) {

    const confirmed = confirm(
        "Are you sure you want to cancel this booking?"
    );

    if (!confirmed) {
        return;
    }

    try {

        const response = await fetch(
            "php/api.php?action=cancel_booking",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    booking_id: bookingId
                })
            }
        );

        const result = await response.json();

        if (!result.success) {

            alert(
                result.message ||
                "Unable to cancel booking."
            );

            return;
        }

        alert("Booking cancelled successfully.");

        // Reload bookings
        loadBookings();

    } catch (error) {

        console.error(
            "Cancel booking error:",
            error
        );

        alert(
            "Something went wrong. Please try again."
        );
    }
}

/* LOAD WHEN PAGE OPENS */

document.addEventListener(
    "DOMContentLoaded",
    loadBookings
);

</script>

</body>

</html>