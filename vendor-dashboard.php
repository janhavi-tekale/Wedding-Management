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

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Vendor Dashboard - EverAfter</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link
        rel="stylesheet"
        href="css/vendor.css"
    >

    <style>

/* =========================================================
   VENDOR REVIEWS
   ========================================================= */

.vendor-reviews {
    margin-top: 30px;
}

.vendor-reviews-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 28px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.06);
}

.vendor-reviews-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 25px;
}

.vendor-reviews-header h2 {
    margin: 0 0 6px;
    font-size: 22px;
}

.vendor-reviews-header p {
    margin: 0;
    color: #777;
    font-size: 14px;
}

/* RATING SUMMARY */

.vendor-rating-summary {
    display: grid;
    grid-template-columns: 180px 1fr;
    gap: 35px;
    padding: 22px;
    background: #fafafa;
    border-radius: 14px;
    margin-bottom: 25px;
}

.vendor-average-rating {
    text-align: center;
    padding: 10px;
}

.vendor-average-number {
    font-size: 46px;
    font-weight: 700;
    line-height: 1;
}

.vendor-rating-stars {
    color: #f5a623;
    font-size: 22px;
    margin: 10px 0;
    letter-spacing: 2px;
}

.vendor-rating-total {
    color: #777;
    font-size: 13px;
}

/* RATING BARS */

.vendor-rating-bars {
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 8px;
}

.vendor-rating-row {
    display: grid;
    grid-template-columns: 45px 1fr 45px;
    align-items: center;
    gap: 10px;
    font-size: 13px;
}

.vendor-rating-row span:last-child {
    text-align: right;
    color: #777;
}

.vendor-rating-bar {
    height: 9px;
    background: #e9e9e9;
    border-radius: 20px;
    overflow: hidden;
}

.vendor-rating-fill {
    height: 100%;
    background: #f5a623;
    border-radius: 20px;
}

/* REVIEW LIST */

.vendor-review-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.vendor-review-item {
    border: 1px solid #eeeeee;
    border-radius: 14px;
    padding: 20px;
    background: #fff;
}

.vendor-review-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 10px;
}

.vendor-review-customer {
    font-weight: 600;
    font-size: 15px;
}

.vendor-review-date {
    font-size: 12px;
    color: #888;
}

.vendor-review-stars {
    color: #f5a623;
    font-size: 17px;
    margin-bottom: 10px;
    letter-spacing: 1px;
}

.vendor-review-text {
    color: #555;
    font-size: 14px;
    line-height: 1.6;
    margin: 0;
}

.vendor-review-event {
    margin-top: 12px;
    padding-top: 10px;
    border-top: 1px solid #eeeeee;
    color: #777;
    font-size: 12px;
}

.vendor-review-empty {
    text-align: center;
    padding: 35px 20px;
    color: #777;
    background: #fafafa;
    border-radius: 14px;
}

/* MOBILE */

@media (max-width: 700px) {

    .vendor-reviews-card {
        padding: 18px;
    }

    .vendor-rating-summary {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .vendor-rating-bars {
        width: 100%;
    }

    .vendor-review-top {
        flex-direction: column;
        gap: 5px;
    }

}

    </style>

</head>

<body>

<div class="vendor-layout">

    <?php include "php/vendor-sidebar.php"; ?>


    <main class="vendor-main">

        <div class="vendor-content">


            <!-- PAGE HEADER -->

            <div class="vendor-page-header">

                <span class="vendor-eyebrow">
                    VENDOR PANEL
                </span>

                <h1 id="businessName">
                    Vendor Dashboard
                </h1>

                <p id="vendorCategory">
                    Loading vendor information...
                </p>

                <span
                    id="vendorStatus"
                    class="vendor-status"
                >
                    Loading...
                </span>

            </div>


            <!-- MESSAGE -->

            <div
                id="dashboardMessage"
                class="vendor-message"
            ></div>


            <!-- PROFILE SETUP -->

            <div
                id="profileSetupBox"
                class="vendor-message"
                style="display:none;"
            >

                <strong>
                    Complete your vendor profile
                </strong>

                <br>

                Add your business information to submit your profile for admin approval.

                <br><br>

                <a
                    href="vendor-profile.php"
                    class="vendor-primary-btn"
                >
                    Complete Profile
                </a>

            </div>


            <!-- STATISTICS -->

            <div class="vendor-stats">


                <div class="vendor-stat-card">

                    <small>
                        ENQUIRIES
                    </small>

                    <strong id="enquiryCount">
                        0
                    </strong>

                </div>


                <div class="vendor-stat-card">

                    <small>
                        BOOKINGS
                    </small>

                    <strong id="bookingCount">
                        0
                    </strong>

                </div>


                <div class="vendor-stat-card">

                    <small>
                        REVENUE
                    </small>

                    <strong id="revenueAmount">
                        ₹0
                    </strong>

                </div>


            </div>


            <!-- BUSINESS PROFILE -->

            <div class="vendor-card">

                <div class="vendor-card-header">

                    <div>

                        <h2>
                            Business Profile
                        </h2>

                        <p>
                            Your public vendor information
                        </p>

                    </div>

                    <a
                        href="vendor-profile.php"
                        class="vendor-primary-btn"
                    >
                        Edit Profile
                    </a>

                </div>


                <div class="vendor-profile-row">

                    <div class="vendor-profile-label">
                        Business Name
                    </div>

                    <div
                        id="profileBusiness"
                        class="vendor-profile-value"
                    >
                        -
                    </div>

                </div>


                <div class="vendor-profile-row">

                    <div class="vendor-profile-label">
                        Category
                    </div>

                    <div
                        id="profileCategory"
                        class="vendor-profile-value"
                    >
                        -
                    </div>

                </div>


                <div class="vendor-profile-row">

                    <div class="vendor-profile-label">
                        Approval Status
                    </div>

                    <div
                        id="profileStatus"
                        class="vendor-profile-value"
                    >
                        -
                    </div>

                </div>


            </div>


            <!-- =====================================================
                 CUSTOMER REVIEWS
                 ===================================================== -->

            <section class="vendor-reviews">

                <div class="vendor-reviews-card">

                    <div class="vendor-reviews-header">

                        <div>

                            <h2>
                                Customer Reviews
                            </h2>

                            <p>
                                See what customers say about your services.
                            </p>

                        </div>

                    </div>


                    <!-- RATING SUMMARY -->

                    <div id="vendorRatingSummary">

                        Loading rating...

                    </div>


                    <!-- REVIEW LIST -->

                    <div id="vendorReviewList">

                        Loading reviews...

                    </div>


                </div>

            </section>


        </div>

    </main>

</div>


<script>


/* =========================================================
   LOAD VENDOR DASHBOARD
   ========================================================= */

async function loadVendorDashboard() {

    try {

        const response = await fetch(
            "php/api.php?action=vendor_dashboard&_=" +
            Date.now(),
            {
                credentials: "same-origin",
                cache: "no-store"
            }
        );


        const result = await response.json();


        console.log(
            "Vendor Dashboard:",
            result
        );


        if (!result.success) {

            showDashboardMessage(
                result.message ||
                "Unable to load vendor dashboard.",
                "error"
            );

            return;
        }


        const vendor =
            result.vendor || {};

        const stats =
            result.stats || {};


        /* PROFILE SETUP */

        const profileSetupBox =
            document.getElementById(
                "profileSetupBox"
            );


        if (result.profile_completed === false) {

            profileSetupBox.style.display =
                "block";

        } else {

            profileSetupBox.style.display =
                "none";

        }


        /* BUSINESS NAME */

        document.getElementById(
            "businessName"
        ).textContent =
            vendor.business_name ||
            "Vendor Dashboard";


        /* CATEGORY */

        document.getElementById(
            "vendorCategory"
        ).textContent =
            vendor.category ||
            "Vendor";


        /* STATUS */

        const statusElement =
            document.getElementById(
                "vendorStatus"
            );


        const status =
            String(
                vendor.status ||
                "pending"
            ).toLowerCase();


        statusElement.textContent =
            status.toUpperCase();


        statusElement.classList.remove(
            "approved",
            "rejected"
        );


        if (status === "approved") {

            statusElement.classList.add(
                "approved"
            );

        }


        if (status === "rejected") {

            statusElement.classList.add(
                "rejected"
            );

        }


        /* ENQUIRIES */

        document.getElementById(
            "enquiryCount"
        ).textContent =
            Number(
                stats.enquiries || 0
            );


        /* BOOKINGS */

        document.getElementById(
            "bookingCount"
        ).textContent =
            Number(
                stats.bookings || 0
            );


        /* REVENUE */

        document.getElementById(
            "revenueAmount"
        ).textContent =
            "₹" +
            Number(
                stats.revenue || 0
            ).toLocaleString("en-IN");


        /* PROFILE */

        document.getElementById(
            "profileBusiness"
        ).textContent =
            vendor.business_name ||
            "-";


        document.getElementById(
            "profileCategory"
        ).textContent =
            vendor.category ||
            "-";


        document.getElementById(
            "profileStatus"
        ).textContent =
            status.charAt(0).toUpperCase() +
            status.slice(1);


        /* =====================================================
           LOAD REVIEWS
           ===================================================== */

        if (vendor.id) {

            loadVendorReviews(
                Number(vendor.id)
            );

        } else {

            document.getElementById(
                "vendorRatingSummary"
            ).innerHTML =
                '<div class="vendor-review-empty">Unable to identify vendor.</div>';

            document.getElementById(
                "vendorReviewList"
            ).innerHTML = "";

        }


    }

    catch (error) {

        console.error(
            "Vendor dashboard error:",
            error
        );


        showDashboardMessage(
            "Unable to connect to the server.",
            "error"
        );

    }

}


/* =========================================================
   LOAD VENDOR REVIEWS
   ========================================================= */

async function loadVendorReviews(vendorId) {

    try {

        const response = await fetch(
            "php/api.php?action=get_vendor_reviews&vendor_id=" +
            encodeURIComponent(vendorId) +
            "&_=" +
            Date.now(),
            {
                credentials: "same-origin",
                cache: "no-store"
            }
        );


        const result =
            await response.json();


        console.log(
            "Vendor Reviews:",
            result
        );


        if (!result.success) {

            document.getElementById(
                "vendorRatingSummary"
            ).innerHTML =
                '<div class="vendor-review-empty">' +
                (result.message ||
                "Unable to load ratings.") +
                '</div>';


            document.getElementById(
                "vendorReviewList"
            ).innerHTML = "";

            return;
        }


        renderVendorRatingSummary(
            result.summary || {}
        );


        renderVendorReviewList(
            result.data || []
        );


    }

    catch (error) {

        console.error(
            "Vendor reviews error:",
            error
        );


        document.getElementById(
            "vendorRatingSummary"
        ).innerHTML =
            '<div class="vendor-review-empty">' +
            'Unable to load ratings.' +
            '</div>';


        document.getElementById(
            "vendorReviewList"
        ).innerHTML = "";

    }

}


/* =========================================================
   RATING SUMMARY
   ========================================================= */

function renderVendorRatingSummary(summary) {

    const total =
        Number(
            summary.total_reviews || 0
        );


    const average =
        Number(
            summary.average_rating || 0
        );


    if (total === 0) {

        document.getElementById(
            "vendorRatingSummary"
        ).innerHTML =

            '<div class="vendor-review-empty">' +

                '<strong>No reviews yet</strong>' +

                '<br><br>' +

                'Customer reviews will appear here after completed bookings.' +

            '</div>';

        return;

    }


    const five =
        Number(summary.five_star || 0);

    const four =
        Number(summary.four_star || 0);

    const three =
        Number(summary.three_star || 0);

    const two =
        Number(summary.two_star || 0);

    const one =
        Number(summary.one_star || 0);


    document.getElementById(
        "vendorRatingSummary"
    ).innerHTML = `

        <div class="vendor-rating-summary">

            <div class="vendor-average-rating">

                <div class="vendor-average-number">
                    ${average.toFixed(1)}
                </div>

                <div class="vendor-rating-stars">
                    ${getVendorStars(average)}
                </div>

                <div class="vendor-rating-total">
                    ${total}
                    ${total === 1 ? "review" : "reviews"}
                </div>

            </div>


            <div class="vendor-rating-bars">

                ${vendorRatingBar(5, five, total)}

                ${vendorRatingBar(4, four, total)}

                ${vendorRatingBar(3, three, total)}

                ${vendorRatingBar(2, two, total)}

                ${vendorRatingBar(1, one, total)}

            </div>

        </div>

    `;

}


/* =========================================================
   RATING BAR
   ========================================================= */

function vendorRatingBar(
    stars,
    count,
    total
) {

    const percentage =
        total > 0
            ? (count / total) * 100
            : 0;


    return `

        <div class="vendor-rating-row">

            <span>
                ${stars} ★
            </span>

            <div class="vendor-rating-bar">

                <div
                    class="vendor-rating-fill"
                    style="width:${percentage}%"
                ></div>

            </div>

            <span>
                ${count}
            </span>

        </div>

    `;

}


/* =========================================================
   STAR DISPLAY
   ========================================================= */

function getVendorStars(rating) {

    const rounded =
        Math.round(
            Number(rating) || 0
        );


    let stars = "";


    for (
        let i = 1;
        i <= 5;
        i++
    ) {

        stars +=
            i <= rounded
                ? "★"
                : "☆";

    }


    return stars;

}


/* =========================================================
   RENDER REVIEW LIST
   ========================================================= */

function renderVendorReviewList(
    reviews
) {

    const container =
        document.getElementById(
            "vendorReviewList"
        );


    if (!reviews.length) {

        container.innerHTML =

            '<div class="vendor-review-empty">' +

                'No customer reviews available.' +

            '</div>';

        return;

    }


    container.innerHTML =

        '<div class="vendor-review-list">' +

        reviews.map(
            review => {

                const customerName =
                    escapeVendorHtml(
                        review.customer_name ||
                        "Customer"
                    );


                const reviewText =
                    escapeVendorHtml(
                        review.review_text ||
                        "No written review."
                    );


                const eventName =
                    escapeVendorHtml(
                        review.event_name ||
                        ""
                    );


                const eventType =
                    escapeVendorHtml(
                        review.event_type ||
                        ""
                    );


                const rating =
                    Number(
                        review.rating || 0
                    );


                let eventInfo = "";


                if (
                    eventName ||
                    eventType
                ) {

                    eventInfo = `

                        <div class="vendor-review-event">

                            Event:
                            ${eventName || eventType}

                            ${
                                eventName && eventType
                                    ? " • " + eventType
                                    : ""
                            }

                        </div>

                    `;

                }


                return `

                    <div class="vendor-review-item">

                        <div class="vendor-review-top">

                            <div>

                                <div class="vendor-review-customer">
                                    ${customerName}
                                </div>

                                <div class="vendor-review-stars">
                                    ${getVendorStars(rating)}
                                </div>

                            </div>

                            <div class="vendor-review-date">

                                ${formatVendorReviewDate(
                                    review.created_at
                                )}

                            </div>

                        </div>


                        <p class="vendor-review-text">

                            ${reviewText}

                        </p>


                        ${eventInfo}

                    </div>

                `;

            }
        ).join("") +

        '</div>';

}


/* =========================================================
   ESCAPE HTML
   ========================================================= */

function escapeVendorHtml(value) {

    const div =
        document.createElement("div");

    div.textContent =
        value ?? "";

    return div.innerHTML;

}


/* =========================================================
   FORMAT REVIEW DATE
   ========================================================= */

function formatVendorReviewDate(
    dateValue
) {

    if (!dateValue) {
        return "";
    }


    const date =
        new Date(
            dateValue
        );


    if (
        Number.isNaN(
            date.getTime()
        )
    ) {

        return escapeVendorHtml(
            dateValue
        );

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


/* =========================================================
   DASHBOARD MESSAGE
   ========================================================= */

function showDashboardMessage(
    message,
    type
) {

    const box =
        document.getElementById(
            "dashboardMessage"
        );


    box.textContent =
        message;


    box.className =
        "vendor-message " +
        type;

}


/* =========================================================
   LOGOUT
   ========================================================= */

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


/* =========================================================
   INITIAL LOAD
   ========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    loadVendorDashboard
);

</script>


</body>

</html>