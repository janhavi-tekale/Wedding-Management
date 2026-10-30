<?php

require_once "php/auth.php";

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>My Shortlist | EverAfter</title>
<link rel="icon" type="image/png" href="assets/images/favicon.png">
<link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
    rel="stylesheet">

<link
    rel="stylesheet"
    href="css/dashboard.css">


<style>

/* ========================================
   PAGE
======================================== */

.shortlist-page {
    max-width: 1100px;
}


/* ========================================
   HEADER
======================================== */

.shortlist-intro {
    margin-bottom: 25px;
}

.shortlist-intro p {
    font-size: 12px;
    color: #777074;
    margin-top: 6px;
}


/* ========================================
   GRID
======================================== */

.shortlist-grid {
    display: grid;
    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    gap: 20px;
}


/* ========================================
   CARD
======================================== */

.shortlist-card {
    background: white;
    border: 1px solid #e8dfdc;
    border-radius: 16px;
    overflow: hidden;
    transition: 0.2s ease;
}

.shortlist-card:hover {
    transform: translateY(-3px);
    box-shadow:
        0 10px 30px rgba(0, 0, 0, 0.07);
}


/* ========================================
   IMAGE
======================================== */

.shortlist-image {
    width: 100%;
    height: 190px;

    background-size: cover;
    background-position: center;
}


/* ========================================
   CONTENT
======================================== */

.shortlist-content {
    padding: 18px;
}

.shortlist-category {
    color: #9a5b63;
    font-size: 9px;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 700;
}

.shortlist-content h3 {
    font-family: "Playfair Display", serif;
    font-size: 21px;
    margin: 7px 0;
}

.shortlist-location {
    color: #777074;
    font-size: 11px;
    margin: 5px 0 12px;
}

.shortlist-description {
    color: #625b5c;
    font-size: 11px;
    line-height: 1.6;

    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;

    min-height: 35px;
}


/* ========================================
   BOTTOM
======================================== */

.shortlist-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;

    margin-top: 16px;
    padding-top: 14px;

    border-top: 1px solid #eee5e2;
}

.shortlist-price {
    font-family: "Playfair Display", serif;
    font-size: 18px;
    color: #9a5b63;
}

.shortlist-rating {
    font-size: 10px;
    color: #555;
}


/* ========================================
   BUTTONS
======================================== */

.shortlist-actions {
    display: flex;
    gap: 8px;
    margin-top: 14px;
}

.shortlist-btn {
    flex: 1;

    border: 0;
    border-radius: 9px;

    padding: 10px;

    font-size: 10px;
    cursor: pointer;

    text-align: center;
}

.view-btn {
    background: #9a5b63;
    color: white;
}

.remove-btn {
    background: #f5efed;
    color: #6d5a5d;
}


/* ========================================
   EMPTY STATE
======================================== */

.empty-shortlist {
    background: white;
    border: 1px solid #e8dfdc;
    border-radius: 16px;

    text-align: center;

    padding: 60px 20px;
}

.empty-shortlist .heart {
    font-size: 40px;
    margin-bottom: 15px;
}

.empty-shortlist h2 {
    font-family: "Playfair Display", serif;
    font-size: 25px;
    margin: 0 0 8px;
}

.empty-shortlist p {
    color: #777074;
    font-size: 12px;
    margin-bottom: 20px;
}

.browse-vendors-btn {
    display: inline-block;

    background: #9a5b63;
    color: white;

    text-decoration: none;

    padding: 11px 20px;

    border-radius: 99px;

    font-size: 10px;
}


/* ========================================
   LOADING
======================================== */

.shortlist-loading {
    color: #777074;
    font-size: 11px;
    padding: 30px 0;
}


/* ========================================
   MOBILE
======================================== */

@media (max-width: 850px) {

    .shortlist-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 600px) {

    .shortlist-grid {
        grid-template-columns: 1fr;
    }

}

</style>

</head>


<body>

<div class="app">


<!-- ========================================
     SIDEBAR
======================================== -->

<?php include "php/sidebar.php"; ?>

<!-- ========================================
     MAIN
======================================== -->

<main class="main">


<header class="dashboard-top">

    <div>

        <span class="eyebrow">
            SAVED VENDORS
        </span>

        <h1>
            My Shortlist
        </h1>

    </div>


    <a
        href="vendors.php"
        class="primary-button"
    >
        Browse Vendors
    </a>

</header>


<div class="shortlist-page">

    <div class="shortlist-intro">

        <p>
            Vendors you've saved while planning your event.
        </p>

    </div>


    <div
        id="shortlistContainer"
        class="shortlist-loading"
    >
        Loading your shortlist...
    </div>

</div>


</main>

</div>


<script>


// ========================================
// LOAD SHORTLIST
// ========================================

async function loadShortlist() {

    const container =
        document.getElementById(
            "shortlistContainer"
        );


    try {

        const response = await fetch(
            "php/api.php?action=my_shortlist",
            {
                credentials: "same-origin"
            }
        );


        const result =
            await response.json();


        if (!result.success) {

            container.innerHTML = `
                <div class="empty-shortlist">
                    <div class="heart">♡</div>

                    <h2>
                        Unable to load shortlist
                    </h2>

                    <p>
                        ${escapeHtml(
                            result.message ||
                            "Please try again."
                        )}
                    </p>
                </div>
            `;

            return;
        }


        const vendors =
            result.data || [];


        if (!vendors.length) {

            container.innerHTML = `
                <div class="empty-shortlist">

                    <div class="heart">
                        ♡
                    </div>

                    <h2>
                        Your shortlist is empty
                    </h2>

                    <p>
                        Save vendors you like and
                        they will appear here.
                    </p>

                    <a
                        href="vendors.php"
                        class="browse-vendors-btn"
                    >
                        Browse Vendors
                    </a>

                </div>
            `;

            return;
        }


        renderShortlist(vendors);

    }
    catch (error) {

        console.error(
            "Shortlist loading failed:",
            error
        );

        container.innerHTML = `
            <div class="empty-shortlist">

                <div class="heart">
                    !
                </div>

                <h2>
                    Something went wrong
                </h2>

                <p>
                    Please refresh the page and try again.
                </p>

            </div>
        `;
    }
}


// ========================================
// RENDER SHORTLIST
// ========================================

function renderShortlist(vendors) {

    const container =
        document.getElementById(
            "shortlistContainer"
        );


    container.className =
        "shortlist-grid";


    container.innerHTML = "";


    vendors.forEach(function(vendor) {

        const card =
            document.createElement("div");

        card.className =
            "shortlist-card";


        card.innerHTML = `

            <div
                class="shortlist-image"
                style="
                    background-image:
                    url('${escapeHtml(
                        vendor.image_url
                    )}');
                "
            ></div>


            <div class="shortlist-content">

                <span class="shortlist-category">

                    ${escapeHtml(
                        vendor.category
                    )}

                </span>


                <h3>

                    ${escapeHtml(
                        vendor.name
                    )}

                </h3>


                <p class="shortlist-location">

                    📍 ${escapeHtml(
                        vendor.city
                    )}

                    &nbsp; • &nbsp;

                    ⭐ ${escapeHtml(
                        vendor.rating
                    )}

                </p>


                <p class="shortlist-description">

                    ${escapeHtml(
                        vendor.description ||
                        "No description available."
                    )}

                </p>


                <div class="shortlist-bottom">

                    <span class="shortlist-price">

                        ${escapeHtml(
                            vendor.price
                        )}

                    </span>

                </div>


                <div class="shortlist-actions">

                    <button
                        class="
                            shortlist-btn
                            view-btn
                        "
                        onclick="
                            viewVendor(${vendor.id})
                        "
                    >
                        View Details
                    </button>


                    <button
                        class="
                            shortlist-btn
                            remove-btn
                        "
                        onclick="
                            removeShortlist(${vendor.id})
                        "
                    >
                        Remove
                    </button>

                </div>

            </div>
        `;


        container.appendChild(card);

    });
}


// ========================================
// VIEW VENDOR
// ========================================

function viewVendor(vendorId) {

    window.location.href =
        "vendor-details.php?id=" +
        encodeURIComponent(vendorId);
}


// ========================================
// REMOVE SHORTLIST
// ========================================

async function removeShortlist(vendorId) {

    if (
        !confirm(
            "Remove this vendor from your shortlist?"
        )
    ) {
        return;
    }


    try {

        const response = await fetch(
            "php/api.php?action=remove_shortlist",
            {
                method: "POST",

                headers: {
                    "Content-Type":
                        "application/json"
                },

                credentials:
                    "same-origin",

                body: JSON.stringify({
                    vendor_id: vendorId
                })
            }
        );


        const result =
            await response.json();


        if (!result.success) {

            alert(
                result.message ||
                "Unable to remove vendor."
            );

            return;
        }


        // Reload shortlist

        loadShortlist();

    }
    catch (error) {

        console.error(
            "Remove shortlist error:",
            error
        );

        alert(
            "Something went wrong."
        );
    }
}


// ========================================
// ESCAPE HTML
// ========================================

function escapeHtml(value) {

    return String(value ?? "")

        .replace(/&/g, "&amp;")

        .replace(/</g, "&lt;")

        .replace(/>/g, "&gt;")

        .replace(/"/g, "&quot;")

        .replace(/'/g, "&#039;");
}


// ========================================
// LOGOUT
// ========================================

async function logoutUser() {

    try {

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
    catch (error) {

        console.error(
            "Logout failed:",
            error
        );
    }
}


// ========================================
// INITIAL LOAD
// ========================================

document.addEventListener(
    "DOMContentLoaded",
    function() {

        loadShortlist();

    }
);

</script>


</body>

</html>