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

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <title>Vendors | Admin | EverAfter</title>

    <link rel="stylesheet"
          href="css/admin.css">

    <style>

        .vendor-filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 22px;
            flex-wrap: wrap;
        }

        .vendor-filter-btn {
            min-height: 40px;
            padding: 0 15px;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
            background: #fff;
            color: #6b7280;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .vendor-filter-btn:hover {
            background: #f9fafb;
        }

        .vendor-filter-btn.active {
            background: #f3eee8;
            border-color: #dfd1c0;
            color: #8b5e34;
        }

        .admin-vendor-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .admin-vendor-card {
            border: 1px solid #e8e8ec;
            border-radius: 13px;
            padding: 21px;
            background: #fff;
        }

        .admin-vendor-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 17px;
        }

        .admin-vendor-name {
            margin: 0;
            font-size: 18px;
            color: #1f2937;
        }

        .admin-vendor-owner {
            margin: 5px 0 0;
            color: #6b7280;
            font-size: 13px;
        }

        .admin-vendor-status {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .admin-vendor-status.pending {
            background: #fff7ed;
            color: #c2410c;
        }

        .admin-vendor-status.approved {
            background: #ecfdf5;
            color: #047857;
        }

        .admin-vendor-status.rejected {
            background: #fef2f2;
            color: #b91c1c;
        }

        .admin-vendor-details {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 13px;
            margin-bottom: 18px;
        }

        .admin-vendor-detail {
            padding: 12px;
            border-radius: 9px;
            background: #f8f8fa;
        }

        .admin-vendor-detail small {
            display: block;
            margin-bottom: 5px;
            color: #9ca3af;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .admin-vendor-detail strong {
            color: #374151;
            font-size: 13px;
            font-weight: 600;
        }

        .admin-vendor-description {
            margin: 0 0 19px;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.6;
        }

        .admin-vendor-actions {
            display: flex;
            gap: 9px;
            flex-wrap: wrap;
            padding-top: 17px;
            border-top: 1px solid #eeeeef;
        }

        .admin-vendor-btn {
            min-height: 40px;
            padding: 0 14px;
            border-radius: 8px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .admin-vendor-btn.approve {
            background: #ecfdf5;
            color: #047857;
            border-color: #bbf7d0;
        }

        .admin-vendor-btn.approve:hover {
            background: #dcfce7;
        }

        .admin-vendor-btn.reject {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }

        .admin-vendor-btn.reject:hover {
            background: #fee2e2;
        }

        .admin-vendor-btn.details {
            background: #f8f8fa;
            color: #4b5563;
            border-color: #e5e7eb;
        }

        .admin-vendor-btn.details:hover {
            background: #f3f4f6;
        }

        .admin-vendor-btn:disabled {
            opacity: .55;
            cursor: not-allowed;
        }

        .admin-vendor-empty,
        .admin-vendor-loading {
            grid-column: 1 / -1;
            text-align: center;
            padding: 55px 20px;
            color: #9ca3af;
        }

        /* MODAL */

        .admin-vendor-modal {
            position: fixed;
            inset: 0;
            background: rgba(17, 24, 39, .45);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 1000;
        }

        .admin-vendor-modal.show {
            display: flex;
        }

        .admin-vendor-modal-card {
            width: 100%;
            max-width: 650px;
            max-height: 90vh;
            overflow-y: auto;
            background: #fff;
            border-radius: 15px;
            padding: 25px;
        }

        .admin-vendor-modal-header {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 20px;
        }

        .admin-vendor-modal-header h2 {
            margin: 0;
            color: #1f2937;
        }

        .admin-vendor-close {
            width: 36px;
            height: 36px;
            border: 0;
            border-radius: 8px;
            background: #f3f4f6;
            cursor: pointer;
            font-size: 18px;
        }

        /* DETAILS */

        .vendor-details-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 24px;
            padding-bottom: 18px;
            border-bottom: 1px solid #e5e7eb;
        }

        .vendor-details-header h3 {
            margin: 0 0 6px;
            font-size: 22px;
            font-weight: 700;
        }

        .vendor-details-header p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }

        .vendor-details-section {
            margin-bottom: 24px;
        }

        .vendor-details-section h4 {
            margin: 0 0 14px;
            font-size: 16px;
            font-weight: 700;
            color: #111827;
        }

        .admin-details-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .admin-detail-item {
            padding: 13px;
            border-radius: 9px;
            background: #f8f8fa;
        }

        .admin-detail-label {
            margin-bottom: 5px;
            color: #9ca3af;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .admin-detail-value {
            color: #374151;
            font-size: 13px;
            font-weight: 600;
            word-break: break-word;
        }

        .admin-detail-full {
            grid-column: 1 / -1;
        }

        .admin-detail-highlight {
            font-size: 16px;
            font-weight: 700;
        }

        .vendor-activity-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .vendor-activity-card {
            padding: 18px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #f9fafb;
            text-align: center;
        }

        .vendor-activity-number {
            font-size: 21px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 5px;
        }

        .vendor-activity-label {
            font-size: 12px;
            color: #6b7280;
        }

        .vendor-status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: capitalize;
        }

        .vendor-status-badge.approved {
            background: #dcfce7;
            color: #166534;
        }

        .vendor-status-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .vendor-status-badge.rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .vendor-id-badge {
            display: inline-block;
            margin-top: 5px;
            padding: 3px 8px;
            border-radius: 6px;
            background: #f3f4f6;
            color: #6b7280;
            font-size: 11px;
        }

        @media (max-width: 850px) {

            .admin-vendor-grid {
                grid-template-columns: 1fr;
            }

        }

        @media (max-width: 650px) {

            .vendor-details-header {
                flex-direction: column;
            }

            .vendor-activity-grid {
                grid-template-columns: 1fr;
            }

            .admin-details-grid {
                grid-template-columns: 1fr;
            }

        }

        @media (max-width: 500px) {

            .admin-vendor-details {
                grid-template-columns: 1fr;
            }

            .admin-vendor-actions {
                flex-direction: column;
            }

            .admin-vendor-btn {
                width: 100%;
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

                    <p class="admin-eyebrow">
                        ADMIN PANEL
                    </p>

                    <h1>Vendors</h1>

                    <p>
                        Review vendor registrations and manage vendor approvals.
                    </p>

                </div>

            </div>

            <div id="adminMessage"
                 class="admin-message">
            </div>

            <section class="admin-card">

                <div class="admin-card-header">

                    <h2>Vendor Management</h2>

                    <span id="vendorCount">
                        Loading...
                    </span>

                </div>

                <div class="vendor-filter-bar">

                    <button type="button"
                            class="vendor-filter-btn active"
                            data-status="all">
                        All
                    </button>

                    <button type="button"
                            class="vendor-filter-btn"
                            data-status="pending">
                        Pending
                    </button>

                    <button type="button"
                            class="vendor-filter-btn"
                            data-status="approved">
                        Approved
                    </button>

                    <button type="button"
                            class="vendor-filter-btn"
                            data-status="rejected">
                        Rejected
                    </button>

                </div>

                <div id="vendorGrid"
                     class="admin-vendor-grid">

                    <div class="admin-vendor-loading">
                        Loading vendors...
                    </div>

                </div>

            </section>

        </div>

    </main>

</div>


<!-- VENDOR DETAILS MODAL -->

<div id="vendorModal"
     class="admin-vendor-modal">

    <div class="admin-vendor-modal-card">

        <div class="admin-vendor-modal-header">

            <div>

                <p class="admin-eyebrow">
                    VENDOR DETAILS
                </p>

                <h2 id="modalVendorName">
                    Vendor
                </h2>

            </div>

            <button type="button"
                    class="admin-vendor-close"
                    onclick="closeVendorModal()">
                ×
            </button>

        </div>

        <div id="vendorModalContent"></div>

    </div>

</div>


<script>

let allVendors = [];

let currentFilter = "all";


/* =========================================
   LOAD VENDORS
   ========================================= */

async function loadVendors() {

    const grid =
        document.getElementById("vendorGrid");

    const message =
        document.getElementById("adminMessage");

    try {

        const response = await fetch(
            "php/api.php?action=admin_vendors&_=" + Date.now(),
            {
                method: "GET",
                credentials: "same-origin",
                cache: "no-store"
            }
        );

        const result = await response.json();

        console.log("ADMIN VENDORS RESPONSE:", result);

        if (!result.success) {

            grid.innerHTML = `
                <div class="admin-vendor-empty">
                    ${escapeHtml(
                        result.message ||
                        "Unable to load vendors."
                    )}
                </div>
            `;

            showAdminMessage(
                result.message ||
                "Unable to load vendors.",
                "error"
            );

            return;
        }

        allVendors =
            Array.isArray(result.data)
                ? result.data
                : [];

        renderVendors();

    } catch (error) {

        console.error(
            "Admin vendors error:",
            error
        );

        grid.innerHTML = `
            <div class="admin-vendor-empty">
                Unable to connect to the server.
            </div>
        `;

        showAdminMessage(
            "Unable to connect to the server.",
            "error"
        );

    }

}


/* =========================================
   RENDER VENDORS
   ========================================= */

function renderVendors() {

    const grid =
        document.getElementById("vendorGrid");

    let vendors = allVendors;

    if (currentFilter !== "all") {

        vendors =
            allVendors.filter(function(vendor) {

                return String(
                    vendor.status || "pending"
                ).toLowerCase() === currentFilter;

            });

    }

    document.getElementById("vendorCount")
        .textContent =
            vendors.length +
            " vendor" +
            (vendors.length === 1 ? "" : "s");


    if (vendors.length === 0) {

        grid.innerHTML = `
            <div class="admin-vendor-empty">
                No ${
                    currentFilter === "all"
                        ? ""
                        : currentFilter + " "
                }vendors found.
            </div>
        `;

        return;
    }


    grid.innerHTML =
        vendors.map(function(vendor, index) {

            const status =
                String(
                    vendor.status || "pending"
                ).toLowerCase();


            const vendorProfileId =
                Number(
                    vendor.vendor_profile_id ||
                    vendor.id ||
                    0
                );


            const actualVendorId =
                Number(
                    vendor.vendor_id ||
                    0
                );


            const price =
                vendor.price_from !== null &&
                vendor.price_from !== undefined &&
                vendor.price_from !== ""
                    ? "₹" + Number(
                        vendor.price_from
                    ).toLocaleString("en-IN")
                    : "Not specified";


            const description =
                vendor.description ||
                "No description provided.";


            let actionButtons = "";


            if (status === "pending") {

                actionButtons = `

                    <button
                        type="button"
                        class="admin-vendor-btn approve"
                        onclick="updateVendorStatus(
                            ${vendorProfileId},
                            'approved'
                        )">
                        ✓ Approve
                    </button>

                    <button
                        type="button"
                        class="admin-vendor-btn reject"
                        onclick="updateVendorStatus(
                            ${vendorProfileId},
                            'rejected'
                        )">
                        ✕ Reject
                    </button>

                `;

            }


            return `

                <article class="admin-vendor-card">

                    <div class="admin-vendor-top">

                        <div>

                            <h3 class="admin-vendor-name">
                                ${escapeHtml(
                                    vendor.business_name ||
                                    "Unnamed Vendor"
                                )}
                            </h3>

                            <p class="admin-vendor-owner">
                                ${escapeHtml(
                                    vendor.owner_name ||
                                    "-"
                                )}
                            </p>

                            ${
                                actualVendorId
                                    ? `
                                        <span class="vendor-id-badge">
                                            Vendor ID #${actualVendorId}
                                        </span>
                                      `
                                    : ""
                            }

                        </div>

                        <span class="admin-vendor-status ${escapeHtml(status)}">
                            ${escapeHtml(
                                capitalize(status)
                            )}
                        </span>

                    </div>


                    <div class="admin-vendor-details">

                        <div class="admin-vendor-detail">

                            <small>Category</small>

                            <strong>
                                ${escapeHtml(
                                    vendor.category || "-"
                                )}
                            </strong>

                        </div>


                        <div class="admin-vendor-detail">

                            <small>City</small>

                            <strong>
                                ${escapeHtml(
                                    vendor.city || "-"
                                )}
                            </strong>

                        </div>


                        <div class="admin-vendor-detail">

                            <small>Price From</small>

                            <strong>
                                ${escapeHtml(price)}
                            </strong>

                        </div>


                        <div class="admin-vendor-detail">

                            <small>Experience</small>

                            <strong>
                                ${
                                    vendor.experience_years
                                        ? escapeHtml(
                                            vendor.experience_years +
                                            " years"
                                        )
                                        : "-"
                                }
                            </strong>

                        </div>

                    </div>


                    <p class="admin-vendor-description">
                        ${escapeHtml(description)}
                    </p>


                    <div class="admin-vendor-actions">

                        <button
                            type="button"
                            class="admin-vendor-btn details"
                            onclick="showVendorDetailsByIndex(${index})">
                            View Details
                        </button>

                        ${actionButtons}

                    </div>

                </article>

            `;

        }).join("");

}


/* =========================================
   VIEW DETAILS
   ========================================= */

function showVendorDetailsByIndex(index) {

    const vendor =
        allVendors[index];

    if (!vendor) {

        console.error(
            "Vendor not found:",
            index
        );

        return;
    }

    showVendorDetails(vendor);

}


function showVendorDetails(vendor) {

    const modal =
        document.getElementById("vendorModal");

    const content =
        document.getElementById("vendorModalContent");


    if (!modal || !content) {

        console.error(
            "Vendor details modal elements not found."
        );

        return;
    }


    const money = function(value) {

        const amount =
            Number(value);

        if (!Number.isFinite(amount)) {
            return "₹0";
        }

        return "₹" +
            amount.toLocaleString("en-IN");

    };


    const safe = function(
        value,
        fallback = "Not provided"
    ) {

        if (
            value === null ||
            value === undefined ||
            String(value).trim() === ""
        ) {

            return fallback;

        }

        return escapeHtml(String(value));

    };


    const dateTime = function(value) {

        if (!value) {
            return "Not available";
        }

        const date =
            new Date(value);

        if (Number.isNaN(date.getTime())) {
            return safe(value);
        }

        return date.toLocaleString(
            "en-IN",
            {
                day: "2-digit",
                month: "short",
                year: "numeric",
                hour: "2-digit",
                minute: "2-digit"
            }
        );

    };


    const status =
        String(
            vendor.status ||
            "pending"
        ).toLowerCase();


    let statusClass =
        "pending";


    if (status === "approved") {
        statusClass = "approved";
    }

    if (status === "rejected") {
        statusClass = "rejected";
    }


    document.getElementById(
        "modalVendorName"
    ).textContent =
        vendor.business_name ||
        "Vendor";


    content.innerHTML = `

        <!-- HEADER -->

        <div class="vendor-details-header">

            <div>

                <h3>
                    ${safe(vendor.business_name)}
                </h3>

                <p>
                    ${safe(vendor.category)}
                    ${
                        vendor.city
                            ? " • " +
                              safe(vendor.city)
                            : ""
                    }
                </p>

            </div>

            <span class="vendor-status-badge ${statusClass}">
                ${safe(
                    capitalize(status),
                    "Pending"
                )}
            </span>

        </div>


        <!-- OWNER -->

        <div class="vendor-details-section">

            <h4>Owner Information</h4>

            <div class="admin-details-grid">

                <div class="admin-detail-item">

                    <div class="admin-detail-label">
                        Owner Name
                    </div>

                    <div class="admin-detail-value">
                        ${safe(vendor.owner_name)}
                    </div>

                </div>


                <div class="admin-detail-item">

                    <div class="admin-detail-label">
                        Owner Email
                    </div>

                    <div class="admin-detail-value">
                        ${safe(vendor.owner_email)}
                    </div>

                </div>


                <div class="admin-detail-item">

                    <div class="admin-detail-label">
                        User ID
                    </div>

                    <div class="admin-detail-value">
                        #${safe(vendor.user_id)}
                    </div>

                </div>


                <div class="admin-detail-item">

                    <div class="admin-detail-label">
                        Account Created
                    </div>

                    <div class="admin-detail-value">
                        ${dateTime(
                            vendor.owner_created_at
                        )}
                    </div>

                </div>

            </div>

        </div>


        <!-- BUSINESS -->

        <div class="vendor-details-section">

            <h4>Business Information</h4>

            <div class="admin-details-grid">

                <div class="admin-detail-item">

                    <div class="admin-detail-label">
                        Business Name
                    </div>

                    <div class="admin-detail-value">
                        ${safe(
                            vendor.business_name
                        )}
                    </div>

                </div>


                <div class="admin-detail-item">

                    <div class="admin-detail-label">
                        Category
                    </div>

                    <div class="admin-detail-value">
                        ${safe(
                            vendor.category
                        )}
                    </div>

                </div>


                <div class="admin-detail-item">

                    <div class="admin-detail-label">
                        Vendor ID
                    </div>

                    <div class="admin-detail-value">
                        ${
                            vendor.vendor_id
                                ? "#" +
                                  escapeHtml(
                                      vendor.vendor_id
                                  )
                                : "Not created"
                        }
                    </div>

                </div>


                <div class="admin-detail-item">

                    <div class="admin-detail-label">
                        Vendor Rating
                    </div>

                    <div class="admin-detail-value">
                        ${
                            vendor.rating !== null &&
                            vendor.rating !== undefined &&
                            vendor.rating !== ""
                                ? Number(
                                    vendor.rating
                                  ).toFixed(1) +
                                  " / 5"
                                : "No rating yet"
                        }
                    </div>

                </div>

            </div>


            <div class="admin-detail-item admin-detail-full">

                <div class="admin-detail-label">
                    Description
                </div>

                <div class="admin-detail-value">
                    ${safe(
                        vendor.description
                    )}
                </div>

            </div>

        </div>


        <!-- CONTACT -->

        <div class="vendor-details-section">

            <h4>Contact & Location</h4>

            <div class="admin-details-grid">

                <div class="admin-detail-item">

                    <div class="admin-detail-label">
                        Business Phone
                    </div>

                    <div class="admin-detail-value">
                        ${safe(vendor.phone)}
                    </div>

                </div>


                <div class="admin-detail-item">

                    <div class="admin-detail-label">
                        Business Email
                    </div>

                    <div class="admin-detail-value">
                        ${safe(vendor.email)}
                    </div>

                </div>


                <div class="admin-detail-item">

                    <div class="admin-detail-label">
                        City
                    </div>

                    <div class="admin-detail-value">
                        ${safe(vendor.city)}
                    </div>

                </div>


                <div class="admin-detail-item">

                    <div class="admin-detail-label">
                        Address
                    </div>

                    <div class="admin-detail-value">
                        ${safe(vendor.address)}
                    </div>

                </div>

            </div>

        </div>


        <!-- PRICING -->

        <div class="vendor-details-section">

            <h4>Pricing & Experience</h4>

            <div class="admin-details-grid">

                <div class="admin-detail-item">

                    <div class="admin-detail-label">
                        Starting Price
                    </div>

                    <div class="admin-detail-value admin-detail-highlight">
                        ${money(
                            vendor.price_from
                        )}
                    </div>

                </div>


                <div class="admin-detail-item">

                    <div class="admin-detail-label">
                        Experience
                    </div>

                    <div class="admin-detail-value">
                        ${
                            vendor.experience_years !==
                            null &&
                            vendor.experience_years !==
                            undefined &&
                            vendor.experience_years !==
                            ""
                                ? escapeHtml(
                                    vendor.experience_years
                                  ) +
                                  " years"
                                : "0 years"
                        }
                    </div>

                </div>

            </div>

        </div>


        <!-- ACTIVITY -->

        <div class="vendor-details-section">

            <h4>Vendor Activity</h4>

            <div class="vendor-activity-grid">

                <div class="vendor-activity-card">

                    <div class="vendor-activity-number">
                        ${Number(
                            vendor.enquiry_count || 0
                        )}
                    </div>

                    <div class="vendor-activity-label">
                        Enquiries
                    </div>

                </div>


                <div class="vendor-activity-card">

                    <div class="vendor-activity-number">
                        ${Number(
                            vendor.booking_count || 0
                        )}
                    </div>

                    <div class="vendor-activity-label">
                        Bookings
                    </div>

                </div>


                <div class="vendor-activity-card">

                    <div class="vendor-activity-number">
                        ${money(
                            vendor.paid_revenue
                        )}
                    </div>

                    <div class="vendor-activity-label">
                        Paid Revenue
                    </div>

                </div>

            </div>

        </div>


        <!-- SYSTEM -->

        <div class="vendor-details-section">

            <h4>System Information</h4>

            <div class="admin-details-grid">

                <div class="admin-detail-item">

                    <div class="admin-detail-label">
                        Vendor Profile ID
                    </div>

                    <div class="admin-detail-value">
                        #${safe(
                            vendor.vendor_profile_id
                        )}
                    </div>

                </div>


                <div class="admin-detail-item">

                    <div class="admin-detail-label">
                        Profile Created
                    </div>

                    <div class="admin-detail-value">
                        ${dateTime(
                            vendor.created_at
                        )}
                    </div>

                </div>


                <div class="admin-detail-item">

                    <div class="admin-detail-label">
                        Profile Updated
                    </div>

                    <div class="admin-detail-value">
                        ${dateTime(
                            vendor.updated_at
                        )}
                    </div>

                </div>


                <div class="admin-detail-item">

                    <div class="admin-detail-label">
                        Vendor Record Created
                    </div>

                    <div class="admin-detail-value">
                        ${dateTime(
                            vendor.vendor_created_at
                        )}
                    </div>

                </div>

            </div>

        </div>

    `;


    modal.classList.add("show");

}


/* =========================================
   CLOSE MODAL
   ========================================= */

function closeVendorModal() {

    const modal =
        document.getElementById(
            "vendorModal"
        );

    if (modal) {
        modal.classList.remove("show");
    }

}


/* =========================================
   APPROVE / REJECT
   ========================================= */

async function updateVendorStatus(
    vendorProfileId,
    status
) {

    const actionText =
        status === "approved"
            ? "approve"
            : "reject";


    if (!confirm(
        "Are you sure you want to " +
        actionText +
        " this vendor?"
    )) {

        return;

    }


    try {

        const action =
            status === "approved"
                ? "admin_approve_vendor"
                : "admin_reject_vendor";


        const response =
            await fetch(
                "php/api.php?action=" +
                action,
                {
                    method: "POST",

                    headers: {
                        "Content-Type":
                            "application/json"
                    },

                    credentials:
                        "same-origin",

                    body: JSON.stringify({
                        vendor_profile_id:
                            Number(
                                vendorProfileId
                            )
                    })
                }
            );


        const result =
            await response.json();


        console.log(
            "Vendor status response:",
            result
        );


        if (!result.success) {

            showAdminMessage(
                result.message ||
                "Unable to update vendor.",
                "error"
            );

            return;

        }


        showAdminMessage(
            result.message ||
            "Vendor updated successfully.",
            "success"
        );


        await loadVendors();

    } catch (error) {

        console.error(error);

        showAdminMessage(
            "Unable to connect to the server.",
            "error"
        );

    }

}


/* =========================================
   MESSAGE
   ========================================= */

function showAdminMessage(
    message,
    type
) {

    const box =
        document.getElementById(
            "adminMessage"
        );


    if (!box) {
        return;
    }


    box.textContent =
        message;


    box.className =
        "admin-message " +
        type;


    box.style.display =
        "block";


    setTimeout(function() {

        box.style.display =
            "none";

    }, 3500);

}


/* =========================================
   ESCAPE HTML
   ========================================= */

function escapeHtml(value) {

    return String(value ?? "")
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


/* =========================================
   CAPITALIZE
   ========================================= */

function capitalize(value) {

    if (!value) {
        return "";
    }

    const text =
        String(value);

    return text.charAt(0)
        .toUpperCase() +
        text.slice(1);

}


/* =========================================
   FILTERS
   ========================================= */

document.querySelectorAll(
    ".vendor-filter-btn"
).forEach(function(button) {

    button.addEventListener(
        "click",
        function() {

            document.querySelectorAll(
                ".vendor-filter-btn"
            ).forEach(function(btn) {

                btn.classList.remove(
                    "active"
                );

            });


            this.classList.add(
                "active"
            );


            currentFilter =
                this.dataset.status;


            renderVendors();

        }
    );

});


/* =========================================
   MODAL CLICK OUTSIDE
   ========================================= */

document.getElementById(
    "vendorModal"
).addEventListener(
    "click",
    function(event) {

        if (
            event.target === this
        ) {

            closeVendorModal();

        }

    }
);


/* =========================================
   ESCAPE KEY
   ========================================= */

document.addEventListener(
    "keydown",
    function(event) {

        if (
            event.key === "Escape"
        ) {

            closeVendorModal();

        }

    }
);


/* =========================================
   LOAD
   ========================================= */

document.addEventListener(
    "DOMContentLoaded",
    function() {

        loadVendors();

    }
);


/* =========================================
   LOGOUT
   ========================================= */

async function logoutAdmin() {

    try {

        const response =
            await fetch(
                "php/api.php?action=logout",
                {
                    method: "POST",
                    credentials:
                        "same-origin"
                }
            );


        const result =
            await response.json();


        if (result.success) {

            window.location.href =
                "login.php";

        } else {

            alert(
                result.message ||
                "Logout failed."
            );

        }

    } catch (error) {

        console.error(error);

        window.location.href =
            "login.php";

    }

}

</script>

</body>

</html>