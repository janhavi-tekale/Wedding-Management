<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (($_SESSION["user_role"] ?? "customer") !== "vendor") {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Vendor Bookings - EverAfter</title>

    <link
        rel="stylesheet"
        href="css/vendor.css"
    >

</head>


<body>

<div class="vendor-layout">


    <!-- =========================================
         SIDEBAR
    ========================================== -->

    <?php include "php/vendor-sidebar.php"; ?>


    <!-- =========================================
         MAIN CONTENT
    ========================================== -->

    <main class="vendor-main">

        <div class="vendor-content">


            <!-- PAGE HEADER -->

            <div class="vendor-page-header">

                <div>

                    <div class="vendor-eyebrow">
                        VENDOR PANEL
                    </div>

                    <h1>
                        My Bookings
                    </h1>

                    <p>
                        View and manage bookings received from customers.
                    </p>

                </div>

            </div>


            <!-- MESSAGE -->

            <div
                id="pageMessage"
                class="vendor-message"
                style="display:none;"
            ></div>


            <!-- BOOKINGS -->

            <div
                id="bookingContainer"
                class="vendor-bookings"
            >

                <div class="vendor-empty">

                    <div class="vendor-empty-icon">
                        ⏳
                    </div>

                    <h2>
                        Loading bookings...
                    </h2>

                    <p>
                        Please wait while we load your bookings.
                    </p>

                </div>

            </div>


        </div>

    </main>

</div>


<script>

/* =========================================
   HTML ESCAPE
========================================= */

function escapeHtml(value) {

    return String(value ?? "")
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");

}


/* =========================================
   ERROR MESSAGE
========================================= */

function showError(message) {

    const box =
        document.getElementById("pageMessage");

    if (!box) {
        console.error(message);
        return;
    }

    box.textContent = message;

    box.className =
        "vendor-message error";

    box.style.display =
        "block";
}


/* =========================================
   SUCCESS MESSAGE
========================================= */

function showSuccess(message) {

    const box =
        document.getElementById("pageMessage");

    if (!box) {
        console.log(message);
        return;
    }

    box.textContent = message;

    box.className =
        "vendor-message success";

    box.style.display =
        "block";

    setTimeout(function () {

        box.style.display =
            "none";

    }, 3500);
}




/* =========================================
   LOAD BOOKINGS
========================================= */

async function loadVendorBookings() {

    const container =
        document.getElementById(
            "bookingContainer"
        );


    try {

        const response = await fetch(
            "php/api.php?action=vendor_bookings&_=" +
            Date.now(),
            {
                credentials: "same-origin",
                cache: "no-store"
            }
        );


        const result =
            await response.json();


        console.log(
            "Vendor Bookings:",
            result
        );


        if (!result.success) {

            showError(
                result.message ||
                "Unable to load bookings."
            );

            return;
        }


        const bookings =
            Array.isArray(result.data)
                ? result.data
                : [];


        /* ---------------------------------
           EMPTY STATE
        --------------------------------- */

        if (bookings.length === 0) {

            container.innerHTML = `

                <div class="vendor-empty">

                    <div class="vendor-empty-icon">
                        ▣
                    </div>

                    <h2>
                        No bookings yet
                    </h2>

                    <p>
                        Customer bookings will appear here when someone books your service.
                    </p>

                </div>

            `;

            return;
        }


        /* ---------------------------------
           RENDER
        --------------------------------- */

        container.innerHTML = "";


        bookings.forEach(function(booking) {

            container.insertAdjacentHTML(
                "beforeend",
                renderBooking(booking)
            );

        });


    }

    catch (error) {

        console.error(
            "Vendor bookings error:",
            error
        );


        showError(
            "Unable to connect to the server."
        );

    }

}


/* =========================================
   RENDER BOOKING
========================================= */

function renderBooking(booking) {

    const status =
        String(
            booking.status || "Pending"
        ).trim();


    const statusLower =
        status.toLowerCase();


    let statusClass =
        "pending";


    if (statusLower === "confirmed") {

        statusClass =
            "confirmed";

    }

    else if (statusLower === "completed") {

        statusClass =
            "completed";

    }

    else if (statusLower === "cancelled") {

        statusClass =
            "cancelled";

    }


    const amount =
        Number(
            booking.amount || 0
        );


    const paid =
        Number(
            booking.paid_amount || 0
        );


    const remaining =
        Number(
            booking.remaining_amount ??
            Math.max(
                0,
                amount - paid
            )
        );


    /* ---------------------------------
       ACTION BUTTONS
    --------------------------------- */

    let actionButtons = "";


    if (statusLower === "pending") {

        actionButtons = `

            <button
                type="button"
                class="vendor-booking-action confirm"
                onclick="updateBookingStatus(
                    ${Number(booking.id)},
                    'Confirmed'
                )"
            >
                ✓ Confirm Booking
            </button>


            <button
                type="button"
                class="vendor-booking-action cancel"
                onclick="updateBookingStatus(
                    ${Number(booking.id)},
                    'Cancelled'
                )"
            >
                ✕ Cancel
            </button>

        `;

    }


    else if (statusLower === "confirmed") {

        actionButtons = `

            <button
                type="button"
                class="vendor-booking-action complete"
                onclick="updateBookingStatus(
                    ${Number(booking.id)},
                    'Completed'
                )"
            >
                ✓ Mark Completed
            </button>


            <button
                type="button"
                class="vendor-booking-action cancel"
                onclick="updateBookingStatus(
                    ${Number(booking.id)},
                    'Cancelled'
                )"
            >
                ✕ Cancel Booking
            </button>

        `;

    }


    return `

        <div class="vendor-card vendor-booking-card">


            <!-- HEADER -->

            <div class="vendor-booking-header">

                <div>

                    <div class="vendor-booking-id">
                        Booking #${escapeHtml(booking.id)}
                    </div>

                    <h2 class="vendor-booking-event">
                        ${escapeHtml(
                            booking.event_name ||
                            "Unnamed Event"
                        )}
                    </h2>

                    <p class="vendor-booking-type">
                        ${escapeHtml(
                            booking.event_type ||
                            "Event"
                        )}
                    </p>

                </div>


                <span
                    class="vendor-booking-status ${statusClass}"
                >
                    ${escapeHtml(status)}
                </span>

            </div>


            <!-- CUSTOMER / EVENT INFORMATION -->

            <div class="vendor-booking-details">


                <div class="vendor-booking-detail">

                    <span>
                        CUSTOMER
                    </span>

                    <strong>
                        ${escapeHtml(
                            booking.customer_name ||
                            "N/A"
                        )}
                    </strong>

                </div>


                <div class="vendor-booking-detail">

                    <span>
                        CUSTOMER EMAIL
                    </span>

                    <strong>
                        ${escapeHtml(
                            booking.customer_email ||
                            "N/A"
                        )}
                    </strong>

                </div>


                <div class="vendor-booking-detail">

                    <span>
                        EVENT DATE
                    </span>

                    <strong>
                        ${escapeHtml(
                            booking.event_date ||
                            booking.booking_date ||
                            "N/A"
                        )}
                    </strong>

                </div>


                <div class="vendor-booking-detail">

                    <span>
                        GUESTS
                    </span>

                    <strong>
                        ${escapeHtml(
                            booking.guest_count ||
                            "N/A"
                        )}
                    </strong>

                </div>


                <div class="vendor-booking-detail">

                    <span>
                        LOCATION
                    </span>

                    <strong>

                        ${escapeHtml(
                            booking.city ||
                            "N/A"
                        )}

                        ${
                            booking.venue
                                ? " · " +
                                  escapeHtml(
                                      booking.venue
                                  )
                                : ""
                        }

                    </strong>

                </div>


                <div class="vendor-booking-detail">

                    <span>
                        PAYMENT STATUS
                    </span>

                    <strong>
                        ${escapeHtml(
                            booking.payment_status ||
                            "Unpaid"
                        )}
                    </strong>

                </div>


            </div>


            <!-- PAYMENT -->

            <div class="vendor-booking-payment">

                <div class="vendor-booking-payment-row">

                    <span>
                        Total Amount
                    </span>

                    <strong>
                        ₹${amount.toLocaleString("en-IN")}
                    </strong>

                </div>


                <div class="vendor-booking-payment-row">

                    <span>
                        Paid
                    </span>

                    <strong>
                        ₹${paid.toLocaleString("en-IN")}
                    </strong>

                </div>


                <div class="vendor-booking-payment-row">

                    <span>
                        Remaining
                    </span>

                    <strong>
                        ₹${remaining.toLocaleString("en-IN")}
                    </strong>

                </div>

            </div>


            <!-- NOTES -->

            ${
                booking.notes
                    ? `

                        <div class="vendor-booking-notes">

                            <span>
                                NOTES
                            </span>

                            <p>
                                ${escapeHtml(
                                    booking.notes
                                )}
                            </p>

                        </div>

                    `
                    : ""
            }


            <!-- ACTIONS -->

            ${
                actionButtons
                    ? `

                        <div class="vendor-booking-actions">

                            ${actionButtons}

                        </div>

                    `
                    : ""
            }


        </div>

    `;

}


/* =========================================
   UPDATE BOOKING STATUS
========================================= */

async function updateBookingStatus(bookingId, newStatus) {

    const confirmed = confirm(
        `Are you sure you want to change booking #${bookingId} to "${newStatus}"?`
    );

    if (!confirmed) {
        return;
    }

    try {

        const response = await fetch(
            "php/api.php?action=vendor_update_booking_status&_=" + Date.now(),
            {
                method: "POST",

                headers: {
                    "Content-Type": "application/json"
                },

                credentials: "same-origin",

                cache: "no-store",

                body: JSON.stringify({
                    booking_id: Number(bookingId),
                    status: newStatus
                })
            }
        );

        const result = await response.json();

        console.log("========== STATUS UPDATE ==========");
        console.log("Booking ID:", bookingId);
        console.log("Requested Status:", newStatus);
        console.log("API Response:", result);
        console.log("===================================");


        /* -----------------------------------------
           API ERROR
        ----------------------------------------- */

        if (!result.success) {

            showError(
                result.message ||
                "Unable to update booking."
            );

            return;
        }


        /* -----------------------------------------
           VERIFY API RETURNED THE EXPECTED STATUS
        ----------------------------------------- */

        const returnedStatus =
            String(
                result.new_status ||
                result.booking?.status ||
                ""
            ).trim();


        console.log(
            "Returned Status:",
            returnedStatus
        );


        if (
            returnedStatus &&
            returnedStatus.toLowerCase() !==
            newStatus.toLowerCase()
        ) {

            showError(
                `Booking update mismatch. Requested "${newStatus}" but server returned "${returnedStatus}".`
            );

            console.error(
                "STATUS MISMATCH",
                {
                    requested: newStatus,
                    returned: returnedStatus
                }
            );

            return;
        }


        /* -----------------------------------------
           SUCCESS MESSAGE
        ----------------------------------------- */

        showSuccess(
            `Booking #${bookingId} is now ${newStatus}.`
        );


        /* -----------------------------------------
           RELOAD FROM DATABASE
        ----------------------------------------- */

        await loadVendorBookings();

    }

    catch (error) {

        console.error(
            "Booking status error:",
            error
        );

        showError(
            "Unable to connect to the server."
        );
    }
}

/* =========================================
   LOGOUT
========================================= */

async function logoutVendor() {

    try {

        await fetch(
            "php/api.php?action=logout",
            {
                credentials: "same-origin"
            }
        );

    }

    catch (error) {

        console.error(
            "Logout error:",
            error
        );

    }


    window.location.href =
        "login.php";

}


/* =========================================
   INITIAL LOAD
========================================= */

document.addEventListener(
    "DOMContentLoaded",
    function() {

        loadVendorBookings();

    }
);

</script>

</body>

</html>