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

<title>Vendor Details | EverAfter</title>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
      rel="stylesheet">

<link rel="stylesheet"
      href="css/dashboard.css">



<style>

.vendor-details {
    max-width: 1000px;
}

/* ========================================
   HERO
======================================== */

.vendor-hero {
    background: white;
    border: 1px solid #e8dfdc;
    border-radius: 18px;
    overflow: hidden;
}

.vendor-hero-image {
    width: 100%;
    height: 350px;
    background-size: cover;
    background-position: center;
}

.vendor-info {
    padding: 30px;
}

.vendor-category {
    color: #9a5b63;
    font-size: 9px;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 700;
}

.vendor-info h1 {
    font-family: "Playfair Display", serif;
    font-size: 38px;
    margin: 8px 0;
}

.vendor-location {
    color: #777074;
    font-size: 11px;
    margin: 8px 0 20px;
}

.vendor-rating {
    font-size: 11px;
    margin-bottom: 20px;
}

.vendor-description {
    font-size: 12px;
    line-height: 1.8;
    color: #5f5859;
    max-width: 750px;
}

.vendor-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #eee5e2;
}

.vendor-price {
    font-family: "Playfair Display", serif;
    font-size: 24px;
    color: #9a5b63;
}

.vendor-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.vendor-btn {
    border: 0;
    border-radius: 99px;
    padding: 11px 20px;
    font-size: 10px;
    cursor: pointer;
}

.primary-vendor-btn {
    background: #9a5b63;
    color: white;
}

.secondary-vendor-btn {
    background: #f5efed;
    color: #6d5a5d;
}

.message {
    font-size: 10px;
    margin-top: 12px;
}

.success-message {
    color: #4d7c4d;
}

.error-message {
    color: #a23b3b;
}

.loading {
    font-size: 11px;
    color: #777074;
    padding: 30px 0;
}


/* ========================================
   ENQUIRY MODAL
======================================== */

.enquiry-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.55);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 20px;
}

.enquiry-modal {
    width: 100%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    background: white;
    border-radius: 18px;
    padding: 28px;
    position: relative;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
    box-sizing: border-box;
}

.enquiry-modal h2 {
    margin: 0 0 5px;
    font-size: 24px;
    font-family: "Playfair Display", serif;
}

.enquiry-subtitle {
    color: #777;
    margin: 0 0 22px;
    font-size: 12px;
}

.close-enquiry {
    position: absolute;
    right: 18px;
    top: 14px;
    border: none;
    background: none;
    font-size: 28px;
    cursor: pointer;
    color: #777;
}

.enquiry-modal label {
    display: block;
    margin-top: 14px;
    margin-bottom: 6px;
    font-size: 12px;
    font-weight: 600;
    color: #4d4546;
}

.enquiry-modal input,
.enquiry-modal textarea {
    width: 100%;
    padding: 11px 12px;
    border: 1px solid #ddd;
    border-radius: 9px;
    box-sizing: border-box;
    font-family: inherit;
    font-size: 12px;
    outline: none;
}

.enquiry-modal input:focus,
.enquiry-modal textarea:focus {
    border-color: #9a5b63;
}

.enquiry-modal textarea {
    resize: vertical;
    min-height: 90px;
}

.send-enquiry-btn {
    width: 100%;
    margin-top: 20px;
    padding: 13px;
    border: none;
    border-radius: 10px;
    background: #9a5b63;
    color: white;
    font-weight: 600;
    cursor: pointer;
    font-size: 12px;
}

.send-enquiry-btn:hover {
    opacity: 0.9;
}

.send-enquiry-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

#enquiryMessageBox {
    text-align: center;
    margin-top: 14px;
    font-size: 12px;
}



/* ========================================
   PORTFOLIO GALLERY
======================================== */

.vendor-gallery {
    background: #fff;
    border: 1px solid #e8dfdc;
    border-radius: 18px;
    margin-bottom: 20px;
    overflow: hidden;
}

.gallery-main {
    position: relative;
    width: 100%;
    height: 520px;
    background: #f5efed;
    overflow: hidden;
}

.gallery-main-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    cursor: zoom-in;
    transition: opacity 0.2s ease;
}

.gallery-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);

    width: 44px;
    height: 44px;

    border: none;
    border-radius: 50%;

    background: rgba(255, 255, 255, 0.9);
    color: #5f5859;

    font-size: 24px;
    line-height: 44px;

    cursor: pointer;
    z-index: 5;

    box-shadow: 0 4px 15px rgba(0,0,0,0.12);

    transition:
        transform 0.2s ease,
        background 0.2s ease;
}

.gallery-arrow:hover {
    background: white;
    transform: translateY(-50%) scale(1.05);
}

.gallery-prev {
    left: 18px;
}

.gallery-next {
    right: 18px;
}

.gallery-counter {
    position: absolute;
    right: 18px;
    bottom: 18px;

    background: rgba(0,0,0,0.55);
    color: white;

    padding: 6px 11px;
    border-radius: 99px;

    font-size: 10px;
    z-index: 5;
}

.gallery-thumbnails {
    display: flex;
    gap: 10px;

    padding: 14px;

    overflow-x: auto;

    scrollbar-width: thin;

    background: #fff;
}

.gallery-thumbnail {
    flex: 0 0 78px;

    width: 78px;
    height: 65px;

    border-radius: 9px;

    overflow: hidden;

    border: 2px solid transparent;

    cursor: pointer;

    background: #f5efed;

    padding: 0;

    transition:
        border-color 0.2s ease,
        opacity 0.2s ease;
}

.gallery-thumbnail:hover {
    opacity: 0.85;
}

.gallery-thumbnail.active {
    border-color: #9a5b63;
}

.gallery-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}


/* ========================================
   LIGHTBOX
======================================== */

.gallery-lightbox {
    position: fixed;
    inset: 0;

    background: rgba(0,0,0,0.92);

    display: none;

    align-items: center;
    justify-content: center;

    z-index: 10000;

    padding: 30px;

    box-sizing: border-box;
}

.gallery-lightbox.active {
    display: flex;
}

.lightbox-image {
    max-width: 90vw;
    max-height: 85vh;

    object-fit: contain;

    border-radius: 8px;

    box-shadow: 0 20px 70px rgba(0,0,0,0.5);
}

.lightbox-close {
    position: absolute;

    top: 20px;
    right: 25px;

    width: 45px;
    height: 45px;

    border: none;
    border-radius: 50%;

    background: rgba(255,255,255,0.15);

    color: white;

    font-size: 28px;

    cursor: pointer;

    z-index: 10;
}

.lightbox-arrow {
    position: absolute;

    top: 50%;
    transform: translateY(-50%);

    width: 48px;
    height: 48px;

    border: none;
    border-radius: 50%;

    background: rgba(255,255,255,0.15);

    color: white;

    font-size: 26px;

    cursor: pointer;

    z-index: 10;
}

.lightbox-arrow:hover,
.lightbox-close:hover {
    background: rgba(255,255,255,0.25);
}

.lightbox-prev {
    left: 25px;
}

.lightbox-next {
    right: 25px;
}


/* ========================================
   MOBILE GALLERY
======================================== */

@media (max-width: 600px) {

    .gallery-main {
        height: 280px;
    }

    .gallery-arrow {
        width: 38px;
        height: 38px;

        font-size: 20px;

        line-height: 38px;
    }

    .gallery-prev {
        left: 10px;
    }

    .gallery-next {
        right: 10px;
    }

    .gallery-thumbnail {
        flex-basis: 65px;
        width: 65px;
        height: 55px;
    }

    .gallery-lightbox {
        padding: 15px;
    }

    .lightbox-image {
        max-width: 94vw;
        max-height: 80vh;
    }

    .lightbox-prev {
        left: 10px;
    }

    .lightbox-next {
        right: 10px;
    }

}


/* ========================================
   MOBILE
======================================== */
@media (max-width: 600px) {

    .vendor-hero-image {
        height: 240px;
    }

    .vendor-info {
        padding: 20px;
    }

    .vendor-info h1 {
        font-size: 28px;
    }

    .vendor-bottom {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
    }

    .vendor-actions {
        width: 100%;
    }

    .vendor-actions button {
        flex: 1;
    }

    .enquiry-modal {
        padding: 22px;
    }

    .shortlisted-button {
        background: #9a5b63 !important;
        color: white !important;
    }

}


/* ========================================
   BOOKING MODAL
======================================== */

.booking-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.55);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 20px;
}

.booking-modal {
    width: 100%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    background: white;
    border-radius: 18px;
    padding: 28px;
    position: relative;
    box-shadow: 0 20px 60px rgba(0,0,0,0.25);
    box-sizing: border-box;
}

.booking-modal h2 {
    margin: 0 0 5px;
    font-size: 24px;
    font-family: "Playfair Display", serif;
}

.booking-subtitle {
    color: #777;
    font-size: 12px;
    margin-bottom: 20px;
}

.booking-event-box {
    background: #f8f3f1;
    border-radius: 12px;
    padding: 14px;
    margin-bottom: 18px;
}

.booking-event-box small {
    display: block;
    color: #777;
    font-size: 10px;
    margin-bottom: 4px;
}

.booking-event-box strong {
    font-size: 14px;
    color: #4d4546;
}

.booking-modal label {
    display: block;
    margin-top: 14px;
    margin-bottom: 6px;
    font-size: 12px;
    font-weight: 600;
}

.booking-modal input {
    width: 100%;
    padding: 11px 12px;
    border: 1px solid #ddd;
    border-radius: 9px;
    box-sizing: border-box;
    font-family: inherit;
    font-size: 12px;
    outline: none;
}

.booking-modal input:focus {
    border-color: #9a5b63;
}

.booking-confirm-btn {
    width: 100%;
    margin-top: 20px;
    padding: 13px;
    border: none;
    border-radius: 10px;
    background: #9a5b63;
    color: white;
    font-weight: 600;
    cursor: pointer;
}

.booking-confirm-btn:hover {
    opacity: 0.9;
}

.booking-confirm-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.close-booking {
    position: absolute;
    right: 18px;
    top: 14px;
    border: none;
    background: none;
    font-size: 28px;
    cursor: pointer;
    color: #777;
}

#bookingMessageBox {
    text-align: center;
    margin-top: 14px;
    font-size: 12px;
}


/* ========================================
   VENDOR EXTRA INFORMATION
======================================== */

.vendor-extra-info {
    display: grid;
    grid-template-columns:
        repeat(3, 1fr);

    gap: 12px;

    margin-top: 25px;
}


.vendor-info-card {
    background: #f8f3f1;
    border-radius: 12px;
    padding: 16px;
}


.vendor-info-label {
    display: block;

    font-size: 8px;

    letter-spacing: 1px;

    color: #777074;

    font-weight: 700;

    margin-bottom: 7px;
}


.vendor-info-card strong {
    font-size: 13px;

    color: #4d4546;
}


/* ========================================
   CONTACT
======================================== */

.vendor-contact-section {
    margin-top: 28px;

    padding-top: 22px;

    border-top: 1px solid #eee5e2;
}


.vendor-contact-section h3 {
    font-family:
        "Playfair Display",
        serif;

    font-size: 22px;

    margin: 0 0 18px;

    color: #4d4546;
}


.vendor-contact-grid {
    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 15px;
}


.vendor-contact-grid > div {
    background: #faf7f6;

    border: 1px solid #eee5e2;

    border-radius: 10px;

    padding: 14px;
}


.vendor-contact-label {
    display: block;

    font-size: 8px;

    letter-spacing: 1px;

    color: #777074;

    font-weight: 700;

    margin-bottom: 7px;
}


.vendor-contact-grid > div > div {
    font-size: 11px;

    color: #4d4546;

    word-break: break-word;
}


/* ========================================
   MOBILE
======================================== */

@media (max-width: 600px) {

    .vendor-extra-info {
        grid-template-columns: 1fr;
    }

    .vendor-contact-grid {
        grid-template-columns: 1fr;
    }

}



/* ========================================
   REVIEWS & RATINGS
======================================== */

.vendor-reviews-section {
    background: #fff;
    border: 1px solid #e8dfdc;
    border-radius: 18px;
    margin-top: 20px;
    padding: 26px;
}

.vendor-reviews-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 22px;
}

.vendor-reviews-header h3 {
    font-family: "Playfair Display", serif;
    font-size: 24px;
    margin: 0;
    color: #4d4546;
}

.vendor-reviews-header p {
    margin: 5px 0 0;
    color: #777074;
    font-size: 11px;
}

.review-write-btn {
    border: none;
    border-radius: 99px;
    padding: 10px 17px;
    background: #9a5b63;
    color: white;
    font-size: 10px;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
}

.review-write-btn:hover {
    opacity: .9;
}

.review-write-btn:disabled {
    opacity: .6;
    cursor: not-allowed;
}

.review-summary {
    display: grid;
    grid-template-columns: 150px 1fr;
    gap: 25px;
    padding: 20px;
    background: #faf7f6;
    border: 1px solid #eee5e2;
    border-radius: 14px;
    margin-bottom: 22px;
}

.review-average {
    text-align: center;
    border-right: 1px solid #e8dfdc;
    padding-right: 20px;
}

.review-average-number {
    font-family: "Playfair Display", serif;
    font-size: 42px;
    line-height: 1;
    color: #4d4546;
}

.review-stars {
    color: #d69b45;
    letter-spacing: 2px;
    font-size: 15px;
    margin: 7px 0;
}

.review-total {
    color: #777074;
    font-size: 10px;
}

.review-bars {
    display: flex;
    flex-direction: column;
    gap: 8px;
    justify-content: center;
}

.review-bar-row {
    display: grid;
    grid-template-columns: 35px 1fr 35px;
    align-items: center;
    gap: 8px;
    font-size: 9px;
    color: #777074;
}

.review-bar-track {
    height: 7px;
    background: #eee5e2;
    border-radius: 99px;
    overflow: hidden;
}

.review-bar-fill {
    height: 100%;
    background: #d69b45;
    border-radius: 99px;
}

.review-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.review-card {
    border: 1px solid #eee5e2;
    border-radius: 13px;
    padding: 17px;
    background: white;
}

.review-card-header {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    align-items: flex-start;
}

.review-customer {
    font-size: 13px;
    font-weight: 700;
    color: #4d4546;
}

.review-event {
    margin-top: 4px;
    color: #8a8081;
    font-size: 9px;
}

.review-card-date {
    color: #999091;
    font-size: 9px;
    white-space: nowrap;
}

.review-card-stars {
    color: #d69b45;
    letter-spacing: 2px;
    font-size: 12px;
    margin: 10px 0 8px;
}

.review-card-text {
    color: #5f5859;
    font-size: 11px;
    line-height: 1.7;
    margin: 0;
    white-space: pre-wrap;
}

.review-empty {
    padding: 28px 15px;
    text-align: center;
    background: #faf7f6;
    border-radius: 12px;
    color: #777074;
    font-size: 11px;
}

/* Review modal */
.review-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.55);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10001;
    padding: 20px;
}

.review-modal {
    width: 100%;
    max-width: 470px;
    background: white;
    border-radius: 18px;
    padding: 28px;
    position: relative;
    box-shadow: 0 20px 60px rgba(0,0,0,.25);
    box-sizing: border-box;
}

.review-modal h2 {
    margin: 0 0 5px;
    font-family: "Playfair Display", serif;
    font-size: 24px;
    color: #4d4546;
}

.review-modal-subtitle {
    color: #777;
    font-size: 11px;
    margin: 0 0 22px;
}

.close-review {
    position: absolute;
    right: 18px;
    top: 14px;
    border: none;
    background: none;
    font-size: 28px;
    cursor: pointer;
    color: #777;
}

.review-rating-selector {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin: 12px 0 22px;
}

.review-star-button {
    border: none;
    background: none;
    color: #d8d0ce;
    font-size: 30px;
    cursor: pointer;
    padding: 2px;
    transition: transform .15s ease, color .15s ease;
}

.review-star-button:hover,
.review-star-button.selected {
    color: #d69b45;
    transform: scale(1.08);
}

.review-modal label {
    display: block;
    margin: 12px 0 6px;
    font-size: 11px;
    font-weight: 600;
    color: #4d4546;
}

.review-modal textarea {
    width: 100%;
    min-height: 110px;
    resize: vertical;
    border: 1px solid #ddd;
    border-radius: 9px;
    padding: 11px 12px;
    box-sizing: border-box;
    font-family: inherit;
    font-size: 11px;
    outline: none;
}

.review-modal textarea:focus {
    border-color: #9a5b63;
}

.submit-review-btn {
    width: 100%;
    margin-top: 18px;
    padding: 13px;
    border: none;
    border-radius: 10px;
    background: #9a5b63;
    color: white;
    font-weight: 600;
    cursor: pointer;
}

.submit-review-btn:disabled {
    opacity: .6;
    cursor: not-allowed;
}

#reviewModalMessage {
    text-align: center;
    font-size: 11px;
    margin-top: 12px;
}

@media (max-width: 600px) {
    .vendor-reviews-section {
        padding: 20px;
    }

    .vendor-reviews-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .review-summary {
        grid-template-columns: 1fr;
    }

    .review-average {
        border-right: none;
        border-bottom: 1px solid #e8dfdc;
        padding: 0 0 16px;
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

    VENDOR DETAILS

</span>


<h1>

    Vendor Profile

</h1>

</div>


<a href="vendors.php"
   class="primary-button">

    ← Back to Vendors

</a>

</header>



<div class="vendor-details">


<div
    id="vendorContainer"
    class="loading">

    Loading vendor...

</div>


</div>


</main>


</div>



<script>


// ========================================
// GET VENDOR ID
// ========================================

const params =
    new URLSearchParams(
        window.location.search
    );


const vendorId =
    params.get("id");



// ========================================
// LOAD VENDOR
// ========================================

async function loadVendor() {


    const container =
        document.getElementById(
            "vendorContainer"
        );


    if (!vendorId) {

        container.innerHTML = `

            <p class="error-message">

                Vendor not found.

            </p>

        `;

        return;

    }


    try {


        const response =
            await fetch(
                "php/api.php?action=vendors",
                {
                    credentials:
                        "same-origin"
                }
            );


        const result =
            await response.json();


        if (!result.success) {

            throw new Error(
                "Unable to load vendors."
            );

        }


        const vendor =
            result.data.find(
                function(item) {

                    return Number(item.id) ===
                           Number(vendorId);

                }
            );


        if (!vendor) {

            container.innerHTML = `

                <p class="error-message">

                    Vendor not found.

                </p>

            `;

            return;

        }


        displayVendor(
            vendor
        );

        loadVendorReviews(
            Number(vendor.id)
        );

    }

    catch (error) {

        console.error(
            "Vendor loading failed:",
            error
        );


        container.innerHTML = `

            <p class="error-message">

                Unable to load vendor details.

            </p>

        `;

    }

}



function displayVendor(vendor) {

    const container =
        document.getElementById("vendorContainer");

    if (!container) {
        console.error("vendorContainer not found.");
        return;
    }

    container.className = "";

    container.innerHTML = `

        <div class="vendor-hero">

            <!-- =====================================================
                 VENDOR PORTFOLIO GALLERY
                 ===================================================== -->

            <div id="vendorGallery"
                 class="vendor-gallery">

                <div class="gallery-main">

                    <img
                        id="galleryMainImage"
                        class="gallery-main-image"
                        src="${escapeHtml(vendor.image_url || "")}"
                        alt="${escapeHtml(vendor.name || "Vendor")}"
                        onclick="openGalleryLightbox()"
                    >

                    <button
                        type="button"
                        class="gallery-arrow gallery-prev"
                        onclick="previousGalleryImage()"
                        aria-label="Previous image"
                    >
                        ‹
                    </button>

                    <button
                        type="button"
                        class="gallery-arrow gallery-next"
                        onclick="nextGalleryImage()"
                        aria-label="Next image"
                    >
                        ›
                    </button>

                    <div
                        id="galleryCounter"
                        class="gallery-counter"
                    >
                        1 / 1
                    </div>

                </div>

                <!-- Portfolio thumbnails -->
                <div
                    id="galleryThumbnails"
                    class="gallery-thumbnails">
                </div>

            </div>


            <!-- =====================================================
                 VENDOR INFORMATION
                 ===================================================== -->

            <div class="vendor-info">

                <!-- Category -->

                <span class="vendor-category">
                    ${escapeHtml(vendor.category || "Wedding Vendor")}
                </span>


                <!-- Vendor Name -->

                <h1>
                    ${escapeHtml(vendor.name || "Vendor")}
                </h1>


                <!-- Location -->

                <p class="vendor-location">
                    📍 ${escapeHtml(vendor.city || "Location not available")}
                </p>


                <!-- Rating -->

                <div class="vendor-rating">

                    ⭐

                    <strong>
                        ${escapeHtml(
                            vendor.rating !== null &&
                            vendor.rating !== undefined
                                ? vendor.rating
                                : "0"
                        )}
                    </strong>

                    / 5

                </div>


                <!-- Description -->

                <p class="vendor-description">

                    ${escapeHtml(
                        vendor.description ||
                        "No description available."
                    )}

                </p>


                <!-- =================================================
                     PRICE + ACTION BUTTONS
                     ================================================= -->

                <div class="vendor-bottom">

                    <!-- Starting Price -->

                    <div>

                        <div
                            style="
                                font-size:9px;
                                color:#777074;
                                margin-bottom:4px;
                            "
                        >
                            STARTING PRICE
                        </div>

                        <div class="vendor-price">

                            ${escapeHtml(
                                vendor.price !== null &&
                                vendor.price !== undefined &&
                                vendor.price !== ""
                                    ? vendor.price
                                    : "Contact for price"
                            )}

                        </div>

                    </div>


                    <!-- Action Buttons -->

                    <div class="vendor-actions">

                        <!-- Shortlist -->

                        <button
                            type="button"
                            id="shortlistButton"
                            class="
                                vendor-btn
                                secondary-vendor-btn
                            "
                            onclick="toggleShortlist(${Number(vendor.id)})"
                        >
                            ♡ Shortlist
                        </button>


                        <!-- Enquire -->

                        <button
                            type="button"
                            class="
                                vendor-btn
                                secondary-vendor-btn
                            "
                            onclick="enquireVendor(${Number(vendor.id)})"
                        >
                            ✉ Enquire
                        </button>


                        <!-- Book Now -->

                        <button
                            type="button"
                            class="
                                vendor-btn
                                primary-vendor-btn
                            "
                            onclick="openBookingModal(${Number(vendor.id)})"
                        >
                            Book Now
                        </button>

                    </div>

                </div>


                <!-- Action message -->

                <div
                    id="actionMessage"
                    class="message">
                </div>

            </div>

        </div>

    `;


    /* =========================================================
       REVIEWS & RATINGS SECTION
       ========================================================= */

    container.insertAdjacentHTML(
        "beforeend",
        `
            <section
                id="vendorReviewsSection"
                class="vendor-reviews-section"
            >

                <div class="vendor-reviews-header">

                    <div>
                        <h3>Reviews & Ratings</h3>
                        <p>See what customers say about this vendor.</p>
                    </div>

                    <button
                        type="button"
                        class="review-write-btn"
                        onclick="openReviewModal(${Number(vendor.id)})"
                    >
                        ✎ Write a Review
                    </button>

                </div>

                <div id="reviewSummary">
                    Loading ratings...
                </div>

                <div id="reviewList" class="review-list">
                    Loading reviews...
                </div>

            </section>
        `
    );


    /* =========================================================
       LOAD ALL PORTFOLIO IMAGES
       ========================================================= */

    loadVendorGallery(vendor);


    /* =========================================================
       CHECK SHORTLIST STATUS
       ========================================================= */

    if (typeof checkShortlistStatus === "function") {

        checkShortlistStatus(
            Number(vendor.id)
        );

    }

}




/* ========================================
   VENDOR GALLERY
======================================== */

let vendorGalleryImages = [];

let currentGalleryIndex = 0;


/* ----------------------------------------
   LOAD GALLERY
---------------------------------------- */

async function loadVendorGallery(vendor) {

    try {

        const response = await fetch(
            "php/api.php?action=vendor_images_public&vendor_id=" +
            encodeURIComponent(vendor.id),
            {
                credentials: "same-origin"
            }
        );

        const result = await response.json();

        if (
            !result.success ||
            !Array.isArray(result.data)
        ) {
            throw new Error(
                "Unable to load portfolio."
            );
        }


        /*
         * Build image list
         */

        vendorGalleryImages =
            result.data
                .filter(function(image) {

                    return image.image_url;

                })
                .map(function(image) {

                    return image.image_url;

                });


        /*
         * If portfolio is empty,
         * use main vendor image.
         */

        if (
            vendorGalleryImages.length === 0 &&
            vendor.image_url
        ) {

            vendorGalleryImages = [
                vendor.image_url
            ];

        }


        /*
         * If absolutely no image exists
         */

        if (
            vendorGalleryImages.length === 0
        ) {

            vendorGalleryImages = [
                "assets/images/vendor-placeholder.jpg"
            ];

        }


        currentGalleryIndex = 0;

        renderGallery();

    }

    catch (error) {

        console.error(
            "Gallery loading failed:",
            error
        );


        /*
         * Fallback to main vendor image
         */

        vendorGalleryImages = [];

        if (vendor.image_url) {

            vendorGalleryImages.push(
                vendor.image_url
            );

        }

        currentGalleryIndex = 0;

        renderGallery();

    }

}


/* ----------------------------------------
   RENDER GALLERY
---------------------------------------- */

function renderGallery() {

    const mainImage =
        document.getElementById(
            "galleryMainImage"
        );

    const thumbnails =
        document.getElementById(
            "galleryThumbnails"
        );

    const counter =
        document.getElementById(
            "galleryCounter"
        );


    if (!mainImage) {
        return;
    }


    if (
        !vendorGalleryImages.length
    ) {
        return;
    }


    /*
     * Main image
     */

    mainImage.src =
        vendorGalleryImages[
            currentGalleryIndex
        ];


    /*
     * Counter
     */

    if (counter) {

        counter.textContent =
            (currentGalleryIndex + 1) +
            " / " +
            vendorGalleryImages.length;

    }


    /*
     * Thumbnails
     */

    if (thumbnails) {

        thumbnails.innerHTML =
            vendorGalleryImages
                .map(function(image, index) {

                    return `

                        <button
                            class="
                                gallery-thumbnail
                                ${
                                    index ===
                                    currentGalleryIndex
                                        ? "active"
                                        : ""
                                }
                            "
                            onclick="
                                selectGalleryImage(${index})
                            "
                            aria-label="
                                View image ${index + 1}
                            "
                        >

                            <img
                                src="${escapeHtml(image)}"
                                alt="Portfolio image ${index + 1}"
                            >

                        </button>

                    `;

                })
                .join("");

    }

}


/* ----------------------------------------
   SELECT IMAGE
---------------------------------------- */

function selectGalleryImage(index) {

    if (
        index < 0 ||
        index >= vendorGalleryImages.length
    ) {
        return;
    }

    currentGalleryIndex = index;

    renderGallery();

}


/* ----------------------------------------
   NEXT
---------------------------------------- */

function nextGalleryImage() {

    if (
        vendorGalleryImages.length <= 1
    ) {
        return;
    }

    currentGalleryIndex =
        (
            currentGalleryIndex + 1
        ) %
        vendorGalleryImages.length;

    renderGallery();

}


/* ----------------------------------------
   PREVIOUS
---------------------------------------- */

function previousGalleryImage() {

    if (
        vendorGalleryImages.length <= 1
    ) {
        return;
    }

    currentGalleryIndex =
        (
            currentGalleryIndex -
            1 +
            vendorGalleryImages.length
        ) %
        vendorGalleryImages.length;

    renderGallery();

}

// ========================================
// TOGGLE SHORTLIST
// ========================================

async function toggleShortlist(vendorId) {

    const button =
        document.getElementById(
            "shortlistButton"
        );

    const message =
        document.getElementById(
            "actionMessage"
        );

    if (!button) {
        return;
    }

    button.disabled = true;

    try {

        // Check current status first

        const checkResponse =
            await fetch(
                "php/api.php?action=check_shortlist",
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

        const checkResult =
            await checkResponse.json();


        if (!checkResult.success) {

            throw new Error(
                checkResult.message ||
                "Unable to check shortlist."
            );
        }


        // ====================================
        // REMOVE
        // ====================================

        if (checkResult.shortlisted) {

            const removeResponse =
                await fetch(
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


            const removeResult =
                await removeResponse.json();


            if (!removeResult.success) {

                throw new Error(
                    removeResult.message ||
                    "Unable to remove vendor."
                );
            }


            button.innerHTML =
                "♡ Shortlist";

            button.classList.remove(
                "shortlisted-button"
            );

            message.className =
                "message";

            message.textContent =
                "Vendor removed from shortlist.";

        }

        // ====================================
        // ADD
        // ====================================

        else {

            const addResponse =
                await fetch(
                    "php/api.php?action=add_shortlist",
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


            const addResult =
                await addResponse.json();


            if (!addResult.success) {

                throw new Error(
                    addResult.message ||
                    "Unable to shortlist vendor."
                );
            }


            button.innerHTML =
                "♥ Shortlisted";

            button.classList.add(
                "shortlisted-button"
            );

            message.className =
                "message success-message";

            message.textContent =
                "✓ Vendor added to your shortlist.";
        }

    }
    catch (error) {

        console.error(
            "Shortlist error:",
            error
        );

        message.className =
            "message error-message";

        message.textContent =
            error.message ||
            "Something went wrong.";

    }
    finally {

        button.disabled = false;
    }
}


// ========================================
// ENQUIRE
// ========================================

// ========================================
// ENQUIRE
// ========================================

function enquireVendor(id) {

    const formHtml = `
        <div id="enquiryModal" class="enquiry-overlay">

            <div class="enquiry-modal">

                <button
                    class="close-enquiry"
                    onclick="closeEnquiry()"
                    type="button"
                >
                    ×
                </button>

                <h2>Send Enquiry</h2>

                <p class="enquiry-subtitle">
                    Tell the vendor about your event
                </p>

                <form id="enquiryForm">

                    <input
                        type="hidden"
                        id="enquiryVendorId"
                        value="${id}"
                    >

                    <label>Your Name</label>

                    <input
                        type="text"
                        id="enquiryName"
                        placeholder="Enter your name"
                        required
                    >

                    <label>Phone Number</label>

                    <input
                        type="tel"
                        id="enquiryPhone"
                        placeholder="Enter your phone number"
                        required
                    >

                    <label>Email</label>

                    <input
                        type="email"
                        id="enquiryEmail"
                        placeholder="Enter your email"
                    >

                    <label>Event Date</label>

                    <input
                        type="date"
                        id="enquiryDate"
                    >

                    <label>Message</label>

                    <textarea
                        id="enquiryMessage"
                        rows="4"
                        placeholder="Tell the vendor what you need..."
                    ></textarea>

                    <button
                        type="submit"
                        class="send-enquiry-btn"
                    >
                        Send Enquiry
                    </button>

                </form>

                <p id="enquiryMessageBox"></p>

            </div>

        </div>
    `;

    document.body.insertAdjacentHTML(
        "beforeend",
        formHtml
    );

    document
        .getElementById("enquiryForm")
        .addEventListener("submit", function(event) {

            event.preventDefault();

            submitEnquiry();
        });
}





async function submitEnquiry() {

    const vendorId =
        document.getElementById("enquiryVendorId").value;

    const name =
        document.getElementById("enquiryName").value.trim();

    const phone =
        document.getElementById("enquiryPhone").value.trim();

    const email =
        document.getElementById("enquiryEmail").value.trim();

    const eventDate =
        document.getElementById("enquiryDate").value;

    const message =
        document.getElementById("enquiryMessage").value.trim();

    const messageBox =
        document.getElementById("enquiryMessageBox");

    const button =
        document.querySelector(".send-enquiry-btn");

    button.disabled = true;
    button.textContent = "Sending...";

    try {

        const response = await fetch(
            "php/api.php?action=create_enquiry",
            {
                method: "POST",

                headers: {
                    "Content-Type": "application/json"
                },

                credentials: "same-origin",

                body: JSON.stringify({
                    vendor_id: vendorId,
                    name: name,
                    phone: phone,
                    email: email,
                    event_date: eventDate,
                    message: message
                })
            }
        );

        const result =
            await response.json();

        if (result.success) {

            messageBox.style.color = "green";

            messageBox.textContent =
                "✓ Enquiry sent successfully!";

            document
                .getElementById("enquiryForm")
                .reset();

            setTimeout(function() {
                closeEnquiry();
            }, 1800);

        } else {

            messageBox.style.color = "red";

            messageBox.textContent =
                result.message ||
                "Unable to send enquiry.";

            button.disabled = false;
            button.textContent = "Send Enquiry";
        }

    } catch (error) {

        console.error(
            "Enquiry error:",
            error
        );

        messageBox.style.color = "red";

        messageBox.textContent =
            "Something went wrong. Please try again.";

        button.disabled = false;
        button.textContent = "Send Enquiry";
    }
}


function closeEnquiry() {

    const modal = document.getElementById("enquiryModal");

    if (modal) {
        modal.remove();
    }
}




// ========================================
// LOAD SHORTLIST STATUS
// ========================================

async function checkShortlistStatus(vendorId) {

    const button =
        document.getElementById(
            "shortlistButton"
        );

    if (!button) {
        return;
    }

    try {

        const response =
            await fetch(
                "php/api.php?action=check_shortlist",
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


        if (
            result.success &&
            result.shortlisted
        ) {

            button.innerHTML =
                "♥ Shortlisted";

            button.classList.add(
                "shortlisted-button"
            );

        } else {

            button.innerHTML =
                "♡ Shortlist";

            button.classList.remove(
                "shortlisted-button"
            );
        }

    }
    catch (error) {

        console.error(
            "Shortlist status error:",
            error
        );
    }
}


// ========================================
// REVIEWS & RATINGS
// ========================================

async function loadVendorReviews(vendorId) {

    const summary = document.getElementById("reviewSummary");
    const list = document.getElementById("reviewList");

    if (!summary || !list) {
        return;
    }

    try {

        const response = await fetch(
            "php/api.php?action=get_vendor_reviews&vendor_id=" +
            encodeURIComponent(vendorId) +
            "&_=" + Date.now(),
            {
                credentials: "same-origin",
                cache: "no-store"
            }
        );

        const result = await response.json();

        if (!result.success) {
            throw new Error(
                result.message || "Unable to load reviews."
            );
        }

        renderReviewSummary(result.summary || {});
        renderReviewList(result.data || []);

    } catch (error) {

        console.error("Review loading failed:", error);

        summary.innerHTML = "";
        list.innerHTML = `
            <div class="review-empty">
                Unable to load reviews right now.
            </div>
        `;
    }
}


function renderReviewSummary(summary) {

    const container = document.getElementById("reviewSummary");

    if (!container) {
        return;
    }

    const total = Number(summary.total_reviews || 0);
    const average = Number(summary.average_rating || 0);

    if (total === 0) {
        container.innerHTML = `
            <div class="review-empty" style="margin-bottom:22px;">
                <strong>No reviews yet.</strong><br>
                Be the first customer to share your experience.
            </div>
        `;
        return;
    }

    const counts = [
        { star: 5, count: Number(summary.five_star || 0) },
        { star: 4, count: Number(summary.four_star || 0) },
        { star: 3, count: Number(summary.three_star || 0) },
        { star: 2, count: Number(summary.two_star || 0) },
        { star: 1, count: Number(summary.one_star || 0) }
    ];

    const bars = counts.map(function(item) {
        const percentage = total > 0
            ? Math.round((item.count / total) * 100)
            : 0;

        return `
            <div class="review-bar-row">
                <span>${item.star} ★</span>
                <div class="review-bar-track">
                    <div
                        class="review-bar-fill"
                        style="width:${percentage}%"
                    ></div>
                </div>
                <span>${item.count}</span>
            </div>
        `;
    }).join("");

    container.innerHTML = `
        <div class="review-summary">

            <div class="review-average">
                <div class="review-average-number">
                    ${average.toFixed(1)}
                </div>

                <div class="review-stars">
                    ${getStarsHtml(average)}
                </div>

                <div class="review-total">
                    ${total} ${total === 1 ? "review" : "reviews"}
                </div>
            </div>

            <div class="review-bars">
                ${bars}
            </div>

        </div>
    `;
}


function getStarsHtml(rating) {

    const rounded = Math.round(Number(rating) || 0);

    return "★★★★★".split("").map(function(star, index) {
        return index < rounded
            ? "★"
            : "☆";
    }).join("");
}


function renderReviewList(reviews) {

    const container = document.getElementById("reviewList");

    if (!container) {
        return;
    }

    if (!reviews.length) {
        container.innerHTML = `
            <div class="review-empty">
                No customer reviews have been posted yet.
            </div>
        `;
        return;
    }

    container.innerHTML = reviews.map(function(review) {

        const customerName =
            review.customer_name || "Customer";

        const eventName =
            review.event_name ||
            review.event_type ||
            "Event";

        const reviewText =
            review.review_text ||
            "No written review provided.";

        const rating = Number(review.rating || 0);

        return `
            <article class="review-card">

                <div class="review-card-header">

                    <div>
                        <div class="review-customer">
                            ${escapeHtml(customerName)}
                        </div>

                        <div class="review-event">
                            ${escapeHtml(eventName)}
                        </div>
                    </div>

                    <div class="review-card-date">
                        ${escapeHtml(formatReviewDate(review.created_at))}
                    </div>

                </div>

                <div class="review-card-stars">
                    ${getStarsHtml(rating)}
                </div>

                <p class="review-card-text">
                    ${escapeHtml(reviewText)}
                </p>

            </article>
        `;

    }).join("");
}


function formatReviewDate(value) {

    if (!value) {
        return "";
    }

    const date = new Date(value.replace(" ", "T"));

    if (Number.isNaN(date.getTime())) {
        return value;
    }

    return date.toLocaleDateString("en-IN", {
        day: "2-digit",
        month: "short",
        year: "numeric"
    });
}


async function openReviewModal(vendorId) {

    const existing = document.getElementById("reviewModal");

    if (existing) {
        existing.remove();
    }

    try {

        const response = await fetch(
            "php/api.php?action=check_review_eligibility&vendor_id=" +
            encodeURIComponent(vendorId) +
            "&_=" + Date.now(),
            {
                credentials: "same-origin",
                cache: "no-store"
            }
        );

        const result = await response.json();

        if (!result.success) {
            alert(result.message || "Unable to check review eligibility.");
            return;
        }

        if (!result.eligible) {

            if (result.already_reviewed) {
                alert("You have already reviewed this booking.");
            } else {
                alert("You can write a review after your booking with this vendor is completed.");
            }

            return;
        }

        const bookingId = Number(result.booking?.id || 0);

        if (!bookingId) {
            alert("No eligible completed booking was found.");
            return;
        }

        const modalHtml = `
            <div id="reviewModal" class="review-modal-overlay">

                <div class="review-modal">

                    <button
                        type="button"
                        class="close-review"
                        onclick="closeReviewModal()"
                    >
                        ×
                    </button>

                    <h2>Write a Review</h2>

                    <p class="review-modal-subtitle">
                        Share your experience with this vendor.
                    </p>

                    <label>Your Rating</label>

                    <div
                        id="reviewRatingSelector"
                        class="review-rating-selector"
                    >
                        ${[1,2,3,4,5].map(function(star) {
                            return `
                                <button
                                    type="button"
                                    class="review-star-button"
                                    data-rating="${star}"
                                    onclick="selectReviewRating(${star})"
                                    aria-label="${star} star"
                                >
                                    ★
                                </button>
                            `;
                        }).join("")}
                    </div>

                    <label for="reviewText">
                        Your Review
                    </label>

                    <textarea
                        id="reviewText"
                        placeholder="Tell others about your experience..."
                        maxlength="2000"
                    ></textarea>

                    <button
                        type="button"
                        id="submitReviewButton"
                        class="submit-review-btn"
                        onclick="submitReview(${bookingId})"
                    >
                        Submit Review
                    </button>

                    <div id="reviewModalMessage"></div>

                </div>

            </div>
        `;

        document.body.insertAdjacentHTML(
            "beforeend",
            modalHtml
        );

        window.currentReviewRating = 0;

    } catch (error) {

        console.error("Review eligibility error:", error);

        alert("Unable to open the review form. Please try again.");
    }
}


function selectReviewRating(rating) {

    window.currentReviewRating = Number(rating);

    document.querySelectorAll(
        ".review-star-button"
    ).forEach(function(button) {

        const buttonRating = Number(
            button.dataset.rating
        );

        button.classList.toggle(
            "selected",
            buttonRating <= rating
        );
    });
}


async function submitReview(bookingId) {

    const rating = Number(window.currentReviewRating || 0);

    const reviewText =
        document.getElementById("reviewText")?.value.trim() || "";

    const message =
        document.getElementById("reviewModalMessage");

    const button =
        document.getElementById("submitReviewButton");

    if (rating < 1 || rating > 5) {
        message.style.color = "#a23b3b";
        message.textContent = "Please select a rating from 1 to 5 stars.";
        return;
    }

    button.disabled = true;
    button.textContent = "Submitting...";

    try {

        const response = await fetch(
            "php/api.php?action=create_review",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                credentials: "same-origin",
                body: JSON.stringify({
                    booking_id: bookingId,
                    rating: rating,
                    review_text: reviewText
                })
            }
        );

        const result = await response.json();

        if (!result.success) {
            throw new Error(
                result.message || "Unable to submit review."
            );
        }

        message.style.color = "#4d7c4d";
        message.textContent = "✓ Review submitted successfully.";

        setTimeout(function() {
            closeReviewModal();
            loadVendorReviews(Number(vendorId));
        }, 900);

    } catch (error) {

        console.error("Review submission error:", error);

        message.style.color = "#a23b3b";
        message.textContent =
            error.message || "Unable to submit review.";

        button.disabled = false;
        button.textContent = "Submit Review";
    }
}


function closeReviewModal() {

    const modal = document.getElementById("reviewModal");

    if (modal) {
        modal.remove();
    }

    window.currentReviewRating = 0;
}


// ========================================
// BOOKING
// ========================================

async function openBookingModal(vendorId) {

    try {

        // Get the currently active event
        const response = await fetch(
            "php/api.php?action=active_event",
            {
                credentials: "same-origin"
            }
        );

        const result = await response.json();

        if (!result.success || !result.event) {

            alert(
                "Please select an event before booking a vendor."
            );

            return;
        }

        const event = result.event;

        const vendor = await getVendorById(vendorId);

        if (!vendor) {

            alert("Vendor information could not be loaded.");

            return;
        }

        const modalHtml = `

            <div
                id="bookingModal"
                class="booking-overlay"
            >

                <div class="booking-modal">

                    <button
                        class="close-booking"
                        onclick="closeBooking()"
                        type="button"
                    >
                        ×
                    </button>

                    <h2>Book Vendor</h2>

                    <p class="booking-subtitle">
                        Create a booking for your selected event
                    </p>

                    <div class="booking-event-box">

                        <small>EVENT</small>

                        <strong>
                            ${escapeHtml(event.event_name)}
                        </strong>

                        <small style="margin-top:8px;">
                            ${escapeHtml(event.event_type)}
                            •
                            ${escapeHtml(event.city || "")}
                        </small>

                    </div>

                    <div class="booking-event-box">

                        <small>VENDOR</small>

                        <strong>
                            ${escapeHtml(vendor.name)}
                        </strong>

                        <small style="margin-top:8px;">
                            ${escapeHtml(vendor.category)}
                        </small>

                    </div>

                    <form
                        id="bookingForm"
                        onsubmit="submitBooking(event, ${vendorId})"
                    >

                        <label>
                            Booking Date
                        </label>

                        <input
                            type="date"
                            id="bookingDate"
                            value="${event.event_date || ""}"
                            required
                        >

                        <label>
                            Booking Amount
                        </label>

                        <input
                            type="number"
                            id="bookingAmount"
                            min="0"
                            step="0.01"
                            value="${parseFloat(vendor.price) || 0}"
                            required
                        >

                        <button
                            type="submit"
                            class="booking-confirm-btn"
                        >
                            Confirm Booking
                        </button>

                    </form>

                    <p id="bookingMessageBox"></p>

                </div>

            </div>
        `;

        document.body.insertAdjacentHTML(
            "beforeend",
            modalHtml
        );

    }
    catch (error) {

        console.error(
            "Booking modal error:",
            error
        );

        alert(
            "Unable to open booking form."
        );
    }
}


async function getVendorById(vendorId) {

    const response = await fetch(
        "php/api.php?action=vendors",
        {
            credentials: "same-origin"
        }
    );

    const result = await response.json();

    if (!result.success) {
        return null;
    }

    return result.data.find(function(vendor) {

        return Number(vendor.id) ===
               Number(vendorId);

    });
}


function closeBooking() {

    const modal =
        document.getElementById("bookingModal");

    if (modal) {
        modal.remove();
    }
}


async function submitBooking(event, vendorId) {

    event.preventDefault();

    const date =
        document.getElementById(
            "bookingDate"
        ).value;

    const amount =
        document.getElementById(
            "bookingAmount"
        ).value;

    const messageBox =
        document.getElementById(
            "bookingMessageBox"
        );

    const button =
        document.querySelector(
            ".booking-confirm-btn"
        );

    button.disabled = true;
    button.textContent = "Creating Booking...";

    try {

        const response = await fetch(
            "php/api.php?action=create_booking",
            {
                method: "POST",

                headers: {
                    "Content-Type":
                        "application/json"
                },

                credentials:
                    "same-origin",

                body: JSON.stringify({

                    vendor_id: vendorId,

                    booking_date: date,

                    amount: amount

                })
            }
        );

        const result =
            await response.json();

        console.log(
            "CREATE BOOKING:",
            result
        );

        if (!result.success) {

            messageBox.style.color = "red";

            messageBox.textContent =
                result.message ||
                "Unable to create booking.";

            button.disabled = false;
            button.textContent =
                "Confirm Booking";

            return;
        }

        messageBox.style.color = "green";

        messageBox.textContent =
            "✓ Booking created successfully!";

        setTimeout(function() {

            window.location.href =
                "bookings.php";

        }, 1200);

    }
    catch (error) {

        console.error(
            "Booking error:",
            error
        );

        messageBox.style.color = "red";

        messageBox.textContent =
            "Something went wrong. Please try again.";

        button.disabled = false;

        button.textContent =
            "Confirm Booking";
    }
}



function formatPrice(value) {

    const number =
        Number(value);

    if (
        !Number.isFinite(number)
    ) {
        return "0";
    }

    return number.toLocaleString(
        "en-IN",
        {
            maximumFractionDigits: 0
        }
    );
}



// ========================================
// ESCAPE HTML
// ========================================

function escapeHtml(
    value
) {

    return String(
        value ?? ""
    )

    .replace(
        /&/g,
        "&amp;"
    )

    .replace(
        /</g,
        "&lt;"
    )

    .replace(
        />/g,
        "&gt;"
    )

    .replace(
        /"/g,
        "&quot;"
    )

    .replace(
        /'/g,
        "&#039;"
    );

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

        loadVendor();

    }
);



/* ========================================
   LIGHTBOX
======================================== */

function openGalleryLightbox() {

    if (
        !vendorGalleryImages.length
    ) {
        return;
    }


    const lightbox =
        document.getElementById(
            "galleryLightbox"
        );

    const image =
        document.getElementById(
            "lightboxImage"
        );


    if (!lightbox || !image) {
        return;
    }


    image.src =
        vendorGalleryImages[
            currentGalleryIndex
        ];


    lightbox.classList.add(
        "active"
    );


    document.body.style.overflow =
        "hidden";

}


function closeGalleryLightbox() {

    const lightbox =
        document.getElementById(
            "galleryLightbox"
        );


    if (!lightbox) {
        return;
    }


    lightbox.classList.remove(
        "active"
    );


    document.body.style.overflow =
        "";

}


/* ----------------------------------------
   UPDATE LIGHTBOX IMAGE
---------------------------------------- */

function updateLightboxImage() {

    const lightbox =
        document.getElementById(
            "galleryLightbox"
        );

    const image =
        document.getElementById(
            "lightboxImage"
        );


    if (
        !lightbox ||
        !image ||
        !lightbox.classList.contains("active")
    ) {
        return;
    }


    image.src =
        vendorGalleryImages[
            currentGalleryIndex
        ];

}


/* ----------------------------------------
   KEEP LIGHTBOX IN SYNC
---------------------------------------- */

const originalNextGalleryImage =
    nextGalleryImage;

const originalPreviousGalleryImage =
    previousGalleryImage;


nextGalleryImage = function() {

    originalNextGalleryImage();

    updateLightboxImage();

};


previousGalleryImage = function() {

    originalPreviousGalleryImage();

    updateLightboxImage();

};


/* ----------------------------------------
   CLOSE WHEN CLICKING BACKDROP
---------------------------------------- */

document.addEventListener(
    "click",
    function(event) {

        const lightbox =
            document.getElementById(
                "galleryLightbox"
            );

        if (
            lightbox &&
            event.target === lightbox
        ) {

            closeGalleryLightbox();

        }

    }
);


/* ----------------------------------------
   ESCAPE KEY
---------------------------------------- */

document.addEventListener(
    "keydown",
    function(event) {

        const lightbox =
            document.getElementById(
                "galleryLightbox"
            );

        if (
            !lightbox ||
            !lightbox.classList.contains("active")
        ) {
            return;
        }


        if (event.key === "Escape") {

            closeGalleryLightbox();

        }


        if (event.key === "ArrowRight") {

            nextGalleryImage();

        }


        if (event.key === "ArrowLeft") {

            previousGalleryImage();

        }

    }
);

</script>


<!-- ========================================
     PORTFOLIO LIGHTBOX
======================================== -->

<div
    id="galleryLightbox"
    class="gallery-lightbox"
>

    <button
        class="lightbox-close"
        onclick="closeGalleryLightbox()"
        aria-label="Close"
    >
        ×
    </button>


    <button
        class="
            lightbox-arrow
            lightbox-prev
        "
        onclick="previousGalleryImage()"
        aria-label="Previous image"
    >
        ‹
    </button>


    <img
        id="lightboxImage"
        class="lightbox-image"
        src=""
        alt="Vendor portfolio"
    >


    <button
        class="
            lightbox-arrow
            lightbox-next
        "
        onclick="nextGalleryImage()"
        aria-label="Next image"
    >
        ›
    </button>

</div>


</body>

</html>