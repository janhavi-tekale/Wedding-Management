<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (($_SESSION["user_role"] ?? "customer") !== "admin") {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <title>Admin Bookings - EverAfter</title>

    <link rel="stylesheet" href="css/admin.css">

    <style>
        .booking-filters {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .booking-filter {
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #374151;
            padding: 10px 16px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: 0.2s ease;
        }

        .booking-filter:hover {
            background: #f9fafb;
        }

        .booking-filter.active {
            background: #111827;
            color: #fff;
            border-color: #111827;
        }

        .booking-list {
            display: grid;
            gap: 18px;
        }

        .booking-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 22px;
        }

        .booking-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 20px;
        }

        .booking-id {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .booking-title {
            font-size: 19px;
            font-weight: 700;
            color: #111827;
            margin: 0 0 5px;
        }

        .booking-subtitle {
            font-size: 14px;
            color: #6b7280;
        }

        .booking-badges {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .booking-badge {
            display: inline-flex;
            align-items: center;
            padding: 7px 11px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-pending {
            background: #fff7ed;
            color: #c2410c;
        }

        .status-confirmed {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .status-completed {
            background: #ecfdf3;
            color: #15803d;
        }

        .status-cancelled {
            background: #fef2f2;
            color: #dc2626;
        }

        .payment-unpaid {
            background: #fef2f2;
            color: #dc2626;
        }

        .payment-partial {
            background: #fff7ed;
            color: #c2410c;
        }

        .payment-paid {
            background: #ecfdf3;
            color: #15803d;
        }

        .payment-refunded {
            background: #f3f4f6;
            color: #4b5563;
        }

        .booking-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .booking-info {
            padding: 14px;
            background: #f9fafb;
            border-radius: 12px;
        }

        .booking-info-label {
            display: block;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #6b7280;
            margin-bottom: 6px;
            font-weight: 700;
        }

        .booking-info-value {
            display: block;
            font-size: 14px;
            color: #111827;
            font-weight: 600;
            word-break: break-word;
        }

        .booking-money {
            margin-top: 18px;
            padding-top: 18px;
            border-top: 1px solid #e5e7eb;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .money-item small {
            display: block;
            color: #6b7280;
            font-size: 12px;
            margin-bottom: 4px;
        }

        .money-item strong {
            color: #111827;
            font-size: 17px;
        }

        .booking-notes {
            margin-top: 18px;
            padding: 14px;
            border-left: 3px solid #e5e7eb;
            background: #fafafa;
            color: #4b5563;
            font-size: 14px;
            line-height: 1.5;
        }

        .booking-empty {
            text-align: center;
            padding: 55px 20px;
            background: #fff;
            border: 1px dashed #d1d5db;
            border-radius: 16px;
            color: #6b7280;
        }

        .booking-empty strong {
            display: block;
            color: #111827;
            font-size: 17px;
            margin-bottom: 6px;
        }

        .booking-loading {
            text-align: center;
            padding: 40px;
            color: #6b7280;
        }

        @media (max-width: 1000px) {
            .booking-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .booking-card-top {
                flex-direction: column;
            }

            .booking-badges {
                justify-content: flex-start;
            }

            .booking-grid,
            .booking-money {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="admin-layout">

    <?php include "php/admin-sidebar.php"; ?>

    <main class="admin-main">

        <div class="admin-content">

            <div class="admin-page-header">
                <div>
                    <div class="admin-eyebrow">ADMIN</div>
                    <h1>Bookings</h1>
                    <p>Monitor and manage all customer bookings.</p>
                </div>
            </div>

            <div class="booking-filters">
                <button
                    type="button"
                    class="booking-filter active"
                    data-filter="all">
                    All
                </button>

                <button
                    type="button"
                    class="booking-filter"
                    data-filter="pending">
                    Pending
                </button>

                <button
                    type="button"
                    class="booking-filter"
                    data-filter="confirmed">
                    Confirmed
                </button>

                <button
                    type="button"
                    class="booking-filter"
                    data-filter="completed">
                    Completed
                </button>

                <button
                    type="button"
                    class="booking-filter"
                    data-filter="cancelled">
                    Cancelled
                </button>
            </div>

            <div id="bookingList" class="booking-list">
                <div class="booking-loading">
                    Loading bookings...
                </div>
            </div>

        </div>

    </main>

</div>

<script>

let allBookings = [];
let currentFilter = "all";

document.addEventListener("DOMContentLoaded", function () {

    loadBookings();

    document.querySelectorAll(".booking-filter").forEach(function (button) {

        button.addEventListener("click", function () {

            document.querySelectorAll(".booking-filter")
                .forEach(function (btn) {
                    btn.classList.remove("active");
                });

            button.classList.add("active");

            currentFilter = button.dataset.filter;

            renderBookings();
        });

    });

});


async function loadBookings() {

    const container = document.getElementById("bookingList");

    try {

        const response = await fetch(
            "php/api.php?action=admin_bookings",
            {
                credentials: "same-origin"
            }
        );

        const result = await response.json();

        if (!result.success) {

            container.innerHTML = `
                <div class="booking-empty">
                    <strong>Unable to load bookings</strong>
                    <span>${escapeHtml(result.message || "Something went wrong.")}</span>
                </div>
            `;

            return;
        }

        allBookings = Array.isArray(result.data)
            ? result.data
            : [];

        renderBookings();

    } catch (error) {

        console.error(error);

        container.innerHTML = `
            <div class="booking-empty">
                <strong>Unable to load bookings</strong>
                <span>Please try again.</span>
            </div>
        `;
    }
}


function renderBookings() {

    const container = document.getElementById("bookingList");

    let bookings = Array.isArray(allBookings)
        ? allBookings
        : [];

    if (currentFilter !== "all") {

        const selectedStatus = normalizeBookingStatus(
            currentFilter
        );

        bookings = bookings.filter(function (booking) {

            const bookingStatus = normalizeBookingStatus(
                booking.status
            );

            console.log(
                "Booking:",
                booking.booking_id,
                "DB Status:",
                booking.status,
                "Normalized:",
                bookingStatus,
                "Selected:",
                selectedStatus
            );

            return bookingStatus === selectedStatus;
        });
    }

    if (bookings.length === 0) {

        container.innerHTML = `
            <div class="booking-empty">
                <strong>No bookings found</strong>
                <span>
                    There are no bookings matching this filter.
                </span>
            </div>
        `;

        return;
    }

    container.innerHTML = bookings
        .map(function (booking) {
            return createBookingCard(booking);
        })
        .join("");
}



function normalizeBookingStatus(status) {

    return String(status || "")
        .trim()
        .toLowerCase()
        .replace(/[\s_-]+/g, "");
}


function createBookingCard(booking) {

const status = String(
    booking.status || "Pending"
).trim();

    const paymentStatus = String(
        booking.payment_status || "Unpaid"
    );

    const statusClass = getStatusClass(status);

    const paymentClass = getPaymentClass(paymentStatus);

    const amount = formatCurrency(booking.amount);

    const paidAmount = formatCurrency(
        booking.paid_amount
    );

    const remainingAmount = formatCurrency(
        booking.remaining_amount
    );

    return `
        <div class="booking-card">

            <div class="booking-card-top">

                <div>
                    <div class="booking-id">
                        Booking #${escapeHtml(booking.booking_id)}
                    </div>

                    <h2 class="booking-title">
                        ${escapeHtml(
                            booking.event_name || "Unnamed Event"
                        )}
                    </h2>

                    <div class="booking-subtitle">
                        ${escapeHtml(
                            booking.event_type || "Event"
                        )}
                    </div>
                </div>

                <div class="booking-badges">

                    <span class="booking-badge ${statusClass}">
                        ${escapeHtml(status)}
                    </span>

                    <span class="booking-badge ${paymentClass}">
                        ${escapeHtml(paymentStatus)}
                    </span>

                </div>

            </div>


            <div class="booking-grid">

                <div class="booking-info">
                    <span class="booking-info-label">
                        Customer
                    </span>

                    <span class="booking-info-value">
                        ${escapeHtml(
                            booking.customer_name || "-"
                        )}
                    </span>
                </div>


                <div class="booking-info">
                    <span class="booking-info-label">
                        Customer Email
                    </span>

                    <span class="booking-info-value">
                        ${escapeHtml(
                            booking.customer_email || "-"
                        )}
                    </span>
                </div>


                <div class="booking-info">
                    <span class="booking-info-label">
                        Vendor
                    </span>

                    <span class="booking-info-value">
                        ${escapeHtml(
                            booking.vendor_name || "-"
                        )}
                    </span>
                </div>


                <div class="booking-info">
                    <span class="booking-info-label">
                        Category
                    </span>

                    <span class="booking-info-value">
                        ${escapeHtml(
                            booking.vendor_category || "-"
                        )}
                    </span>
                </div>


                <div class="booking-info">
                    <span class="booking-info-label">
                        Event Date
                    </span>

                    <span class="booking-info-value">
                        ${formatDate(
                            booking.event_date
                        )}
                    </span>
                </div>


                <div class="booking-info">
                    <span class="booking-info-label">
                        Booking Date
                    </span>

                    <span class="booking-info-value">
                        ${formatDate(
                            booking.booking_date
                        )}
                    </span>
                </div>


                <div class="booking-info">
                    <span class="booking-info-label">
                        City
                    </span>

                    <span class="booking-info-value">
                        ${escapeHtml(
                            booking.city || "-"
                        )}
                    </span>
                </div>


                <div class="booking-info">
                    <span class="booking-info-label">
                        Venue
                    </span>

                    <span class="booking-info-value">
                        ${escapeHtml(
                            booking.venue || "-"
                        )}
                    </span>
                </div>

            </div>


            <div class="booking-money">

                <div class="money-item">
                    <small>Total Amount</small>
                    <strong>${amount}</strong>
                </div>

                <div class="money-item">
                    <small>Paid Amount</small>
                    <strong>${paidAmount}</strong>
                </div>

                <div class="money-item">
                    <small>Remaining</small>
                    <strong>${remainingAmount}</strong>
                </div>

            </div>


            ${
                booking.notes
                ? `
                    <div class="booking-notes">
                        <strong>Notes:</strong>
                        ${escapeHtml(booking.notes)}
                    </div>
                  `
                : ""
            }

        </div>
    `;
}


function getStatusClass(status) {

    const value = String(status)
        .toLowerCase();

    if (value === "confirmed") {
        return "status-confirmed";
    }

    if (value === "completed") {
        return "status-completed";
    }

    if (value === "cancelled") {
        return "status-cancelled";
    }

    return "status-pending";
}


function getPaymentClass(status) {

    const value = String(status)
        .toLowerCase();

    if (value === "paid") {
        return "payment-paid";
    }

    if (value === "partially paid") {
        return "payment-partial";
    }

    if (value === "refunded") {
        return "payment-refunded";
    }

    return "payment-unpaid";
}


function formatCurrency(value) {

    const number = Number(value || 0);

    return "₹" + number.toLocaleString("en-IN", {
        maximumFractionDigits: 0
    });
}


function formatDate(value) {

    if (!value) {
        return "-";
    }

    const date = new Date(value + "T00:00:00");

    if (Number.isNaN(date.getTime())) {
        return escapeHtml(value);
    }

    return date.toLocaleDateString("en-IN", {
        day: "2-digit",
        month: "short",
        year: "numeric"
    });
}


function escapeHtml(value) {

    return String(value ?? "")
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}


function logoutAdmin() {

    fetch("php/api.php?action=logout", {
        method: "POST",
        credentials: "same-origin"
    })
    .finally(function () {
        window.location.href = "login.php";
    });
}

</script>

</body>
</html>