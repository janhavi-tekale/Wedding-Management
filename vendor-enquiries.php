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

    <title>Vendor Enquiries - EverAfter</title>

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
                        Customer Enquiries
                    </h1>

                    <p>
                        View enquiries received from customers interested in your services.
                    </p>

                </div>

            </div>


            <!-- PAGE MESSAGE -->

            <div
                id="pageMessage"
                class="vendor-message"
                style="display:none;"
            ></div>


            <!-- ENQUIRIES -->

            <div
                id="enquiriesContainer"
                class="vendor-enquiries"
            >

                <div class="vendor-empty">

                    <div class="vendor-empty-icon">
                        ⏳
                    </div>

                    <h2>
                        Loading enquiries...
                    </h2>

                    <p>
                        Please wait while we load your enquiries.
                    </p>

                </div>

            </div>


        </div>

    </main>

</div>


<script>


/* =========================================
   LOAD ENQUIRIES
========================================= */

async function loadEnquiries() {

    const container =
        document.getElementById(
            "enquiriesContainer"
        );


    try {

        const response = await fetch(
            "php/api.php?action=vendor_enquiries&_=" +
            Date.now(),
            {
                credentials: "same-origin",
                cache: "no-store"
            }
        );


        const result =
            await response.json();


        console.log(
            "Vendor Enquiries:",
            result
        );


        if (!result.success) {

            showError(
                result.message ||
                "Unable to load enquiries."
            );

            return;
        }


        const enquiries =
            result.data || [];


        /* ---------------------------------
           NO ENQUIRIES
        --------------------------------- */

        if (enquiries.length === 0) {

            container.innerHTML = `

                <div class="vendor-empty">

                    <div class="vendor-empty-icon">
                        ♢
                    </div>

                    <h2>
                        No enquiries yet
                    </h2>

                    <p>
                        Customer enquiries will appear here when someone contacts you.
                    </p>

                </div>

            `;

            return;
        }


        /* ---------------------------------
           RENDER ENQUIRIES
        --------------------------------- */

        container.innerHTML = "";


        enquiries.forEach(function(enquiry) {

            const status =
                String(
                    enquiry.status || "Pending"
                ).toLowerCase();


            let statusClass = "pending";


            if (status === "accepted") {

                statusClass = "accepted";

            }

            else if (status === "rejected") {

                statusClass = "rejected";

            }


            const customerName =
                enquiry.name ||
                "Customer";


            const eventName =
                enquiry.event_name ||
                "Event";


            const eventDate =
                enquiry.event_date ||
                "-";


            const phone =
                enquiry.phone ||
                "-";


            const email =
                enquiry.email ||
                "-";


            const message =
                enquiry.message ||
                "No message provided.";


            const createdAt =
                enquiry.created_at ||
                "";


            const enquiryId =
                enquiry.id ||
                "-";


            const card =
                document.createElement("div");


            card.className =
                "vendor-card vendor-enquiry-card";


            card.innerHTML = `

                <!-- HEADER -->

                <div class="vendor-enquiry-header">

                    <div>

                        <h2 class="vendor-enquiry-name">
                            ${escapeHtml(customerName)}
                        </h2>

                        <p class="vendor-enquiry-event">
                            ${escapeHtml(eventName)}
                        </p>

                    </div>


                    <span
                        class="vendor-enquiry-status ${statusClass}"
                    >
                        ${escapeHtml(
                            status.toUpperCase()
                        )}
                    </span>

                </div>


                <!-- DETAILS -->

                <div class="vendor-enquiry-details">


                    <div class="vendor-enquiry-detail">

                        <span>
                            PHONE
                        </span>

                        <strong>
                            ${escapeHtml(phone)}
                        </strong>

                    </div>


                    <div class="vendor-enquiry-detail">

                        <span>
                            EMAIL
                        </span>

                        <strong>
                            ${escapeHtml(email)}
                        </strong>

                    </div>


                    <div class="vendor-enquiry-detail">

                        <span>
                            EVENT DATE
                        </span>

                        <strong>
                            ${escapeHtml(eventDate)}
                        </strong>

                    </div>


                    <div class="vendor-enquiry-detail">

                        <span>
                            ENQUIRY ID
                        </span>

                        <strong>
                            #${escapeHtml(
                                String(enquiryId)
                            )}
                        </strong>

                    </div>


                </div>


                <!-- CUSTOMER MESSAGE -->

                <div class="vendor-enquiry-message">

                    <span>
                        CUSTOMER MESSAGE
                    </span>

                    <p>
                        ${escapeHtml(message)}
                    </p>

                </div>


                <!-- FOOTER -->

<!-- FOOTER -->

<div class="vendor-enquiry-footer">

    <span>
        Received: ${escapeHtml(createdAt)}
    </span>

</div>


<!-- ACTIONS -->

${
    status === "pending"
        ? `

            <div class="vendor-enquiry-actions">

                <button
                    type="button"
                    class="vendor-enquiry-action accept"
                    onclick="updateEnquiryStatus(
                        ${Number(enquiryId)},
                        'Accepted'
                    )"
                >
                    ✓ Accept Enquiry
                </button>


                <button
                    type="button"
                    class="vendor-enquiry-action reject"
                    onclick="updateEnquiryStatus(
                        ${Number(enquiryId)},
                        'Rejected'
                    )"
                >
                    ✕ Reject Enquiry
                </button>

            </div>

        `
        : ""
}

            `;


            container.appendChild(card);

        });


    }

    catch (error) {

        console.error(
            "Vendor enquiries error:",
            error
        );


        showError(
            "Unable to connect to the server."
        );



    }

}


/* =========================================
   ESCAPE HTML
========================================= */

function escapeHtml(value) {

    return String(value)

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
        document.getElementById(
            "pageMessage"
        );


    box.textContent =
        message;


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
        document.getElementById(
            "pageMessage"
        );

    if (!box) {
        console.log(message);
        return;
    }

    box.textContent =
        message;

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
   UPDATE ENQUIRY STATUS
========================================= */

async function updateEnquiryStatus(
    enquiryId,
    newStatus
) {

    const confirmed = confirm(
        `Are you sure you want to ${newStatus.toLowerCase()} this enquiry?`
    );

    if (!confirmed) {
        return;
    }


    try {

        const response = await fetch(
            "php/api.php?action=vendor_update_enquiry_status&_=" +
            Date.now(),
            {
                method: "POST",

                headers: {
                    "Content-Type": "application/json"
                },

                credentials: "same-origin",

                cache: "no-store",

                body: JSON.stringify({

                    enquiry_id:
                        Number(enquiryId),

                    status:
                        newStatus

                })
            }
        );


        const result =
            await response.json();


        console.log(
            "Enquiry Status Update:",
            result
        );


        if (!result.success) {

            showError(
                result.message ||
                "Unable to update enquiry."
            );

            return;
        }


        showSuccess(
            `Enquiry #${enquiryId} is now ${newStatus}.`
        );


        /* Reload from database */

        await loadEnquiries();

    }

    catch (error) {

        console.error(
            "Enquiry status error:",
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
   INITIALIZE
========================================= */

document.addEventListener(
    "DOMContentLoaded",
    function() {

        loadEnquiries();

    }
);

</script>

</body>

</html>