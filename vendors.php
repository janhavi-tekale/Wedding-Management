<?php
require_once "php/auth.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="assets/images/favicon.png">
<title>Vendors | EverAfter</title>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
      rel="stylesheet">

<link rel="stylesheet"
      href="css/dashboard.css">

<style>

/* ========================================
   PAGE
======================================== */

.vendor-page-header {

    margin-bottom:24px;

}

.vendor-page-header h1 {

    margin:6px 0 5px;

}


/* ========================================
   FILTER AREA
======================================== */

.vendor-filter-box {

    background:white;

    border:1px solid #e8dfdc;

    border-radius:18px;

    padding:18px;

    margin-bottom:25px;

}


.vendor-search-row {

    display:grid;

    grid-template-columns:
        minmax(200px,2fr)
        repeat(3,minmax(130px,1fr));

    gap:10px;

    margin-bottom:15px;

}


.vendor-search {

    width:100%;

    box-sizing:border-box;

    border:1px solid #e8dfdc;

    border-radius:12px;

    padding:12px 14px;

    font-family:"DM Sans",sans-serif;

    font-size:11px;

    outline:none;

}


.vendor-search:focus {

    border-color:#9a5b63;

}


.vendor-select {

    width:100%;

    box-sizing:border-box;

    border:1px solid #e8dfdc;

    border-radius:12px;

    padding:12px 10px;

    background:white;

    font-family:"DM Sans",sans-serif;

    font-size:11px;

    outline:none;

}


.vendor-select:focus {

    border-color:#9a5b63;

}


/* ========================================
   CATEGORY BUTTONS
======================================== */

.category-buttons {

    display:flex;

    gap:8px;

    flex-wrap:wrap;

}


.category-buttons button {

    border:1px solid #e8dfdc;

    background:white;

    padding:9px 15px;

    border-radius:99px;

    cursor:pointer;

    font-size:10px;

    font-family:"DM Sans",sans-serif;

}


.category-buttons button:hover {

    border-color:#9a5b63;

}


.category-buttons button.active {

    background:#9a5b63;

    color:white;

    border-color:#9a5b63;

}


/* ========================================
   RESULT COUNT
======================================== */

.vendor-result-info {

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:15px;

    color:#777074;

    font-size:10px;

}


/* ========================================
   VENDOR GRID
======================================== */

.vendor-page-grid {

    display:grid;

    grid-template-columns:
        repeat(3,1fr);

    gap:18px;

}


/* ========================================
   VENDOR CARD
======================================== */

.vendor-card {

    background:white;

    border:1px solid #e8dfdc;

    border-radius:18px;

    overflow:hidden;

    transition:.25s;

}


.vendor-card:hover {

    transform:translateY(-4px);

    box-shadow:
        0 15px 40px
        rgba(55,35,38,.10);

}


/* ========================================
   IMAGE
======================================== */

.vendor-image-wrapper {

    position:relative;

    height:210px;

    background:#f3eeee;

    overflow:hidden;

}


.vendor-image {

    width:100%;

    height:100%;

    object-fit:cover;

    display:block;

    transition:.35s;

}


.vendor-card:hover
.vendor-image {

    transform:scale(1.04);

}


.vendor-image-placeholder {

    width:100%;

    height:100%;

    display:flex;

    align-items:center;

    justify-content:center;

    color:#9a5b63;

    font-size:12px;

}


/* ========================================
   PHOTO COUNT
======================================== */

.vendor-photo-count {

    position:absolute;

    bottom:10px;

    left:10px;

    background:rgba(0,0,0,.65);

    color:white;

    padding:6px 10px;

    border-radius:99px;

    font-size:9px;

}


/* ========================================
   RATING BADGE
======================================== */

.vendor-rating {
    position:absolute;
    top:10px;
    right:10px;
    background:white;
    padding:7px 10px;
    border-radius:99px;
    font-size:9px;
    font-weight:700;
    box-shadow:
        0 5px 15px
        rgba(0,0,0,.10);
    display:flex;
    align-items:center;
    gap:4px;
    white-space:nowrap;
}


/* ========================================
   CONTENT
======================================== */

.vendor-content {

    padding:20px;

}


.vendor-category {

    color:#9a5b63;

    font-size:9px;

    text-transform:uppercase;

    letter-spacing:1px;

    font-weight:700;

}


.vendor-content h3 {

    font-family:
        "Playfair Display",serif;

    font-size:22px;

    margin:5px 0 5px;

}


.vendor-location {

    color:#777074;

    font-size:10px;

    margin:5px 0 14px;

}


.vendor-meta {

    display:flex;

    gap:8px;

    flex-wrap:wrap;

    margin-bottom:16px;

}


.vendor-meta span {

    background:#f8f3f1;

    border-radius:99px;

    padding:6px 9px;

    font-size:9px;

    color:#665e60;

}


.vendor-bottom {

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:10px;

}


.vendor-price {

    font-size:12px;

    font-weight:700;

}


.vendor-price small {

    display:block;

    font-size:8px;

    font-weight:400;

    color:#777074;

    margin-bottom:2px;

}


.vendor-actions {

    display:flex;

    gap:7px;

}


.vendor-btn {

    border:0;

    border-radius:99px;

    padding:9px 13px;

    font-size:9px;

    cursor:pointer;

    font-family:"DM Sans",sans-serif;

}


.vendor-btn.primary {

    background:#9a5b63;

    color:white;

}


.vendor-btn.secondary {

    background:#f4eeee;

    color:#7d4b53;

}


.vendor-btn.secondary.active {

    background:#9a5b63;

    color:white;

}


/* ========================================
   EMPTY STATE
======================================== */

.vendor-empty {

    grid-column:1/-1;

    text-align:center;

    padding:60px 20px;

    background:white;

    border:1px solid #e8dfdc;

    border-radius:18px;

}


.vendor-empty h3 {

    font-family:"Playfair Display",serif;

    margin-bottom:7px;

}


.vendor-empty p {

    color:#777074;

    font-size:11px;

}


/* ========================================
   MOBILE
======================================== */

@media(max-width:1000px) {

    .vendor-search-row {

        grid-template-columns:
            repeat(2,1fr);

    }

    .vendor-search-row
    .vendor-search {

        grid-column:1/-1;

    }

    .vendor-page-grid {

        grid-template-columns:
            repeat(2,1fr);

    }

}


@media(max-width:600px) {

    .vendor-search-row {

        grid-template-columns:1fr;

    }

    .vendor-search-row
    .vendor-search {

        grid-column:auto;

    }

    .vendor-page-grid {

        grid-template-columns:1fr;

    }

    .vendor-bottom {

        align-items:flex-start;

        flex-direction:column;

    }

    .vendor-actions {

        width:100%;

    }

    .vendor-btn {

        flex:1;

    }

}

</style>

</head>


<body>

<div class="app">

<?php include "php/sidebar.php"; ?>


<main class="main">


<header class="dashboard-top vendor-page-header">

<div>

<span class="eyebrow">
VENDOR MANAGEMENT
</span>

<h1>
Find your perfect vendors.
</h1>

<p style="
    color:#777074;
    font-size:11px;
    margin:0;
">

Discover verified vendors for your special day.

</p>

</div>


<a href="dashboard.php"
   class="primary-button">

← Dashboard

</a>

</header>


<!-- ========================================
     FILTER AREA
======================================== -->

<div class="vendor-filter-box">


<div class="vendor-search-row">


<input
    type="text"
    id="vendorSearch"
    class="vendor-search"
    placeholder="Search vendors, categories or cities..."
    oninput="applyFilters()">


<select
    id="cityFilter"
    class="vendor-select"
    onchange="applyFilters()">

<option value="All">
All Cities
</option>

</select>


<select
    id="ratingFilter"
    class="vendor-select"
    onchange="applyFilters()">

<option value="All">
Any Rating
</option>

<option value="4">
4★ & above
</option>

<option value="4.5">
4.5★ & above
</option>

</select>


<select
    id="priceFilter"
    class="vendor-select"
    onchange="applyFilters()">

<option value="All">
Any Price
</option>

<option value="30000">
Under ₹30,000
</option>

<option value="50000">
Under ₹50,000
</option>

<option value="100000">
Under ₹1,00,000
</option>

</select>


</div>


<div class="category-buttons">


<button
    class="active"
    data-category="All"
    onclick="filterVendor('All',this)">

All

</button>


<button
    data-category="Venue"
    onclick="filterVendor('Venue',this)">

Venues

</button>


<button
    data-category="Catering"
    onclick="filterVendor('Catering',this)">

Catering

</button>


<button
    data-category="Photography"
    onclick="filterVendor('Photography',this)">

Photography

</button>


<button
    data-category="Decoration"
    onclick="filterVendor('Decoration',this)">

Decoration

</button>


</div>

</div>


<!-- ========================================
     RESULT INFO
======================================== -->

<div class="vendor-result-info">

<span id="vendorResultCount">
Loading vendors...
</span>

</div>


<!-- ========================================
     VENDOR GRID
======================================== -->

<div
    class="vendor-page-grid"
    id="vendorPageGrid">

</div>


</main>

</div>


<script>


// ========================================
// STATE
// ========================================

let allVendors = [];

let selectedCategory = "All";


// ========================================
// LOAD VENDORS
// ========================================

async function loadVendors() {

    const grid =
        document.getElementById(
            "vendorPageGrid"
        );

    try {

        const response =
            await fetch(
                "php/api.php?action=vendors",
                {
                    credentials:"same-origin"
                }
            );


        const result =
            await response.json();


        console.log(
            "VENDOR API:",
            result
        );


        if (!result.success) {

            showError();

            return;

        }


        allVendors =
            result.data || [];


        populateCities();

        applyFilters();

    }

    catch(error) {

        console.error(
            "Vendor loading failed:",
            error
        );

        showError();

    }

}


// ========================================
// POPULATE CITY FILTER
// ========================================

function populateCities() {

    const cityFilter =
        document.getElementById(
            "cityFilter"
        );


    const cities =
        [
            ...new Set(
                allVendors
                    .map(v => v.city)
                    .filter(Boolean)
            )
        ]
        .sort();


    cities.forEach(
        city => {

            const option =
                document.createElement(
                    "option"
                );

            option.value = city;

            option.textContent = city;

            cityFilter.appendChild(
                option
            );

        }
    );

}


// ========================================
// CATEGORY FILTER
// ========================================

function filterVendor(
    category,
    button
) {

    selectedCategory =
        category;


    document
        .querySelectorAll(
            ".category-buttons button"
        )
        .forEach(
            btn => {

                btn.classList.remove(
                    "active"
                );

            }
        );


    button.classList.add(
        "active"
    );


    applyFilters();

}


// ========================================
// APPLY ALL FILTERS
// ========================================

function applyFilters() {

    const search =
        document
            .getElementById(
                "vendorSearch"
            )
            .value
            .trim()
            .toLowerCase();


    const city =
        document
            .getElementById(
                "cityFilter"
            )
            .value;


    const rating =
        document
            .getElementById(
                "ratingFilter"
            )
            .value;


    const price =
        document
            .getElementById(
                "priceFilter"
            )
            .value;


    const filtered =
        allVendors.filter(
            vendor => {


                // CATEGORY

                if (
                    selectedCategory !== "All" &&
                    String(
                        vendor.category || ""
                    ).toLowerCase() !==
                    selectedCategory.toLowerCase()
                ) {

                    return false;

                }


                // CITY

                if (
                    city !== "All" &&
                    String(
                        vendor.city || ""
                    ) !== city
                ) {

                    return false;

                }


                // SEARCH

                const searchable =
                    [
                        vendor.name,
                        vendor.business_name,
                        vendor.category,
                        vendor.city,
                        vendor.description
                    ]
                    .filter(Boolean)
                    .join(" ")
                    .toLowerCase();


                if (
                    search &&
                    !searchable.includes(
                        search
                    )
                ) {

                    return false;

                }


                // RATING

                if (
                    rating !== "All" &&
                    Number(
                        vendor.rating || 0
                    ) < Number(rating)
                ) {

                    return false;

                }


                // PRICE

                if (
                    price !== "All" &&
                    Number(
                        vendor.price || 0
                    ) > Number(price)
                ) {

                    return false;

                }


                return true;

            }
        );


    displayVendors(
        filtered
    );

}


// ========================================
// DISPLAY VENDORS
// ========================================

function displayVendors(
    vendors
) {

    const grid =
        document.getElementById(
            "vendorPageGrid"
        );


    const count =
        document.getElementById(
            "vendorResultCount"
        );


    grid.innerHTML = "";


    count.textContent =
        `${vendors.length} vendor${
            vendors.length === 1
                ? ""
                : "s"
        } found`;


    if (!vendors.length) {

        grid.innerHTML = `

            <div class="vendor-empty">

                <h3>
                    No vendors found
                </h3>

                <p>
                    Try changing your search or filters.
                </p>

            </div>

        `;

        return;

    }


    vendors.forEach(
        vendor => {

            const card =
                document.createElement(
                    "div"
                );


            card.className =
                "vendor-card";


            // ========================================
            // IMAGE
            // ========================================

            const imageWrapper =
                document.createElement(
                    "div"
                );


            imageWrapper.className =
                "vendor-image-wrapper";


            const imageUrl =
                getVendorImage(
                    vendor
                );


            if (imageUrl) {

                const image =
                    document.createElement(
                        "img"
                    );

                image.className =
                    "vendor-image";

                image.src =
                    imageUrl;

                image.alt =
                    vendor.name ||
                    "Vendor";

                image.onerror =
                    function() {

                        this.style.display =
                            "none";

                        imageWrapper.innerHTML += `

                            <div class="
                                vendor-image-placeholder
                            ">

                                Image unavailable

                            </div>

                        `;

                    };


                imageWrapper.appendChild(
                    image
                );

            }

            else {

                imageWrapper.innerHTML = `

                    <div class="
                        vendor-image-placeholder
                    ">

                        No image available

                    </div>

                `;

            }


// ========================================
// RATING + REVIEW COUNT
// ========================================

const vendorRating =
    Number(vendor.rating || 0);

const reviewCount =
    Number(vendor.review_count || 0);

const rating =
    document.createElement(
        "div"
    );

rating.className =
    "vendor-rating";

if (reviewCount > 0) {

    rating.innerHTML = `
        ⭐ ${vendorRating.toFixed(1)}
        <span style="
            font-weight:500;
            color:#777074;
        ">
            (${reviewCount})
        </span>
    `;

} else {

    rating.innerHTML = `
        ⭐ New
    `;

}

imageWrapper.appendChild(
    rating
);


            // ========================================
            // FUTURE GALLERY COUNT
            // ========================================

            const imageCount =
                getImageCount(
                    vendor
                );


            if (imageCount > 1) {

                const photoCount =
                    document.createElement(
                        "div"
                    );

                photoCount.className =
                    "vendor-photo-count";

                photoCount.textContent =
                    `📷 ${imageCount} Photos`;

                imageWrapper.appendChild(
                    photoCount
                );

            }


            // ========================================
            // CONTENT
            // ========================================

            const content =
                document.createElement(
                    "div"
                );


            content.className =
                "vendor-content";


            const price =
                Number(
                    vendor.price || 0
                );


            const experience =
                Number(
                    vendor.experience_years || 0
                );


            content.innerHTML = `

                <span class="vendor-category">

                    ${escapeHtml(
                        vendor.category
                    )}

                </span>


                <h3>

                    ${escapeHtml(
                        vendor.name
                    )}

                </h3>


                <p class="vendor-location">

                    📍 ${escapeHtml(
                        vendor.city
                    )}

                </p>


                <div class="vendor-meta">

                    ${
                        experience > 0
                        ? `
                            <span>
                                ${experience} Years Experience
                            </span>
                          `
                        : ""
                    }


${
    Number(vendor.review_count || 0) > 0
    ? `
        <span>
            ⭐ ${Number(vendor.rating || 0).toFixed(1)}
            · ${Number(vendor.review_count)} Reviews
        </span>
      `
    : `
        <span>
            ⭐ New
        </span>
      `
}

                </div>


                <div class="vendor-bottom">

                    <div class="vendor-price">

                        <small>
                            Starting from
                        </small>

                        ₹${formatPrice(price)}

                    </div>


                    <div class="vendor-actions">


                        <button
                            class="
                                vendor-btn
                                secondary
                            "
                            onclick="
                                toggleShortlist(
                                    ${vendor.id},
                                    this
                                )
                            ">

                            ♡ Shortlist

                        </button>


                        <button
                            class="
                                vendor-btn
                                primary
                            "
                            onclick="
                                viewVendor(
                                    ${vendor.id}
                                )
                            ">

                            View Details

                        </button>


                    </div>

                </div>

            `;


            card.appendChild(
                imageWrapper
            );


            card.appendChild(
                content
            );


            grid.appendChild(
                card
            );

        }
    );

}


// ========================================
// VENDOR IMAGE
// ========================================

function getVendorImage(
    vendor
) {

    /*
       Future API can return:

       images: [
           "image1.jpg",
           "image2.jpg",
           "image3.jpg"
       ]

       For listing page we use
       the first image.
    */


    if (
        Array.isArray(
            vendor.images
        ) &&
        vendor.images.length
    ) {

        return vendor.images[0];

    }


    return vendor.image_url || "";

}


// ========================================
// IMAGE COUNT
// ========================================

function getImageCount(
    vendor
) {

    if (
        Array.isArray(
            vendor.images
        )
    ) {

        return vendor.images.length;

    }


    return 0;

}


// ========================================
// VIEW DETAILS
// ========================================

function viewVendor(
    vendorId
) {

    window.location.href =
        "vendor-details.php?id=" +
        encodeURIComponent(
            vendorId
        );

}


// ========================================
// SHORTLIST
// ========================================

async function toggleShortlist(
    vendorId,
    button
) {

    try {

        const checkResponse =
            await fetch(
                `php/api.php?action=check_shortlist`,
                {
                    method:"POST",

                    credentials:
                        "same-origin",

                    headers:{
                        "Content-Type":
                            "application/json"
                    },

                    body:JSON.stringify({
                        vendor_id:
                            vendorId
                    })
                }
            );


        const checkResult =
            await checkResponse.json();


        if (
            !checkResult.success
        ) {

            alert(
                checkResult.message ||
                "Unable to check shortlist."
            );

            return;

        }


        if (
            checkResult.shortlisted
        ) {

            const removeResponse =
                await fetch(
                    "php/api.php?action=remove_shortlist",
                    {
                        method:"POST",

                        credentials:
                            "same-origin",

                        headers:{
                            "Content-Type":
                                "application/json"
                        },

                        body:JSON.stringify({
                            vendor_id:
                                vendorId
                        })
                    }
                );


            const removeResult =
                await removeResponse.json();


            if (
                !removeResult.success
            ) {

                alert(
                    removeResult.message ||
                    "Unable to remove shortlist."
                );

                return;

            }


            button.classList.remove(
                "active"
            );

            button.textContent =
                "♡ Shortlist";

        }

        else {

            const addResponse =
                await fetch(
                    "php/api.php?action=add_shortlist",
                    {
                        method:"POST",

                        credentials:
                            "same-origin",

                        headers:{
                            "Content-Type":
                                "application/json"
                        },

                        body:JSON.stringify({
                            vendor_id:
                                vendorId
                        })
                    }
                );


            const addResult =
                await addResponse.json();


            if (
                !addResult.success
            ) {

                alert(
                    addResult.message ||
                    "Unable to shortlist vendor."
                );

                return;

            }


            button.classList.add(
                "active"
            );

            button.textContent =
                "♥ Shortlisted";

        }

    }

    catch(error) {

        console.error(
            "Shortlist error:",
            error
        );

        alert(
            "Something went wrong."
        );

    }

}


// ========================================
// FORMAT PRICE
// ========================================

function formatPrice(
    value
) {

    const number =
        Number(value);


    if (
        !Number.isFinite(
            number
        )
    ) {

        return "0";

    }


    return number.toLocaleString(
        "en-IN",
        {
            maximumFractionDigits:0
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

    catch(error) {

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

        loadVendors();

    }
);

</script>

</body>
</html>