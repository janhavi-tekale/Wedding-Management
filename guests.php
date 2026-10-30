<?php
require_once "php/auth.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">
    
    <title>Guests | EverAfter</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="css/dashboard.css">

    <style>

        .guest-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .55);
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 20px;
            box-sizing: border-box;
        }

        .guest-modal {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            border-radius: 18px;
            padding: 28px;
            box-sizing: border-box;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .25);
        }

        .guest-modal h2 {
            margin: 0 0 5px;
            font-family: "Playfair Display", serif;
            font-size: 26px;
        }

        .guest-modal-subtitle {
            margin: 0 0 22px;
            color: #777074;
            font-size: 11px;
        }

        .guest-form-group {
            margin-bottom: 16px;
        }

        .guest-form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 10px;
            font-weight: 700;
            color: #4d4546;
        }

        .guest-form-group input,
        .guest-form-group select {
            width: 100%;
            box-sizing: border-box;
            padding: 11px 12px;
            border: 1px solid #e1d8d5;
            border-radius: 9px;
            background: white;
            font-family: "DM Sans", sans-serif;
            font-size: 12px;
            outline: none;
        }

        .guest-form-group input:focus,
        .guest-form-group select:focus {
            border-color: #9a5b63;
        }

        .guest-modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .guest-modal-actions button {
            border: none;
            border-radius: 9px;
            padding: 11px 18px;
            cursor: pointer;
            font-family: "DM Sans", sans-serif;
            font-size: 11px;
            font-weight: 600;
        }

        .guest-add-btn {
            background: #9a5b63;
            color: white;
        }

        .guest-cancel-btn {
            background: #f1ecea;
            color: #5f5859;
        }

        .guest-modal-message {
            margin-top: 12px;
            min-height: 18px;
            font-size: 10px;
            text-align: center;
        }

        .guest-empty {
            padding: 45px 20px;
            text-align: center;
            color: #777074;
        }

        .guest-empty-icon {
            font-size: 34px;
            margin-bottom: 10px;
        }

        .guest-empty h3 {
            margin: 0 0 6px;
            font-family: "Playfair Display", serif;
            color: #342d2e;
            font-size: 22px;
        }

        .guest-empty p {
            margin: 0;
            font-size: 11px;
        }

        .guest-row {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #eee5e2;
        }

        .guest-row:last-child {
            border-bottom: none;
        }

        .guest-avatar {
            width: 42px;
            height: 42px;
            min-width: 42px;
            border-radius: 50%;
            background: #ead6d8;
            color: #70464c;
            display: grid;
            place-items: center;
            font-size: 11px;
            font-weight: 700;
        }

        .guest-info {
            flex: 1;
            min-width: 0;
        }

        .guest-info strong {
            display: block;
            color: #342d2e;
            font-size: 12px;
            margin-bottom: 4px;
        }

        .guest-info small {
            color: #777074;
            font-size: 9px;
        }

        .guest-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .guest-status-select {
            padding: 7px 8px;
            border: 1px solid #e1d8d5;
            border-radius: 7px;
            background: white;
            color: #5f5859;
            font-size: 9px;
            outline: none;
            cursor: pointer;
        }

        .guest-delete-btn {
            border: none;
            background: #f7eeee;
            color: #a23b3b;
            border-radius: 7px;
            padding: 7px 9px;
            font-size: 9px;
            cursor: pointer;
        }

        .guest-delete-btn:hover {
            background: #f2e1e1;
        }

        .stat-card .green {
            color: #4d7c4d;
        }

        .stat-card .red {
            color: #a23b3b;
        }

        .stat-card .orange {
            color: #a06a32;
        }

        @media (max-width: 700px) {

            .guest-row {
                align-items: flex-start;
            }

            .guest-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .guest-status-select {
                width: 100%;
            }

        }

    </style>

</head>


<body>


<div class="app">


    <?php include "php/sidebar.php"; ?>


    <main class="main">


        <!-- ========================================
             HEADER
        ======================================== -->

        <header class="dashboard-top">

            <div>

                <span class="eyebrow">
                    GUEST MANAGEMENT
                </span>

                <h1>
                    Your Guest List
                </h1>

            </div>


            <button
                onclick="openGuestModal()"
                class="primary-button">

                + Add Guest

            </button>

        </header>


        <!-- ========================================
             STATS
        ======================================== -->

        <div class="stats-grid">


            <!-- TOTAL -->

            <div class="stat-card">

                <div class="stat-icon">
                    ♧
                </div>

                <div>

                    <small>
                        TOTAL GUESTS
                    </small>

                    <strong id="totalGuests">
                        0
                    </strong>

                    <span>
                        All guests
                    </span>

                </div>

            </div>


            <!-- CONFIRMED -->

            <div class="stat-card">

                <div class="stat-icon">
                    ✓
                </div>

                <div>

                    <small>
                        CONFIRMED
                    </small>

                    <strong id="confirmedGuests">
                        0
                    </strong>

                    <span class="green">
                        Confirmed
                    </span>

                </div>

            </div>


            <!-- PENDING -->

            <div class="stat-card">

                <div class="stat-icon">
                    ?
                </div>

                <div>

                    <small>
                        PENDING
                    </small>

                    <strong id="pendingGuests">
                        0
                    </strong>

                    <span class="orange">
                        Awaiting RSVP
                    </span>

                </div>

            </div>


            <!-- DECLINED -->

            <div class="stat-card">

                <div class="stat-icon">
                    ×
                </div>

                <div>

                    <small>
                        DECLINED
                    </small>

                    <strong id="declinedGuests">
                        0
                    </strong>

                    <span class="red">
                        Not attending
                    </span>

                </div>

            </div>


        </div>


        <!-- ========================================
             GUEST DIRECTORY
        ======================================== -->

        <div class="panel">

            <div class="panel-header">

                <div>

                    <span class="eyebrow">
                        GUEST DIRECTORY
                    </span>

                    <h3>
                        All Guests
                    </h3>

                </div>

            </div>


            <div id="guestList">

                <div class="guest-empty">

                    <div class="guest-empty-icon">
                        ...
                    </div>

                    <h3>
                        Loading guests...
                    </h3>

                    <p>
                        Please wait.
                    </p>

                </div>

            </div>

        </div>


    </main>


</div>


<!-- ========================================
     ADD GUEST MODAL
======================================== -->

<div
    id="guestModal"
    class="guest-modal-overlay">


    <div class="guest-modal">


        <h2>
            Add Guest
        </h2>


        <p class="guest-modal-subtitle">
            Add someone to your event guest list.
        </p>


        <form id="guestForm">


            <!-- NAME -->

            <div class="guest-form-group">

                <label for="guestName">
                    GUEST NAME
                </label>

                <input
                    id="guestName"
                    type="text"
                    placeholder="Enter guest name"
                    required>

            </div>


            <!-- CATEGORY -->

            <div class="guest-form-group">

                <label for="guestCategory">
                    CATEGORY
                </label>

                <select id="guestCategory">

                    <option value="Family">
                        Family
                    </option>

                    <option value="Friend">
                        Friend
                    </option>

                    <option value="Colleague">
                        Colleague
                    </option>

                    <option value="Other">
                        Other
                    </option>

                </select>

            </div>


            <!-- COUNT -->

            <div class="guest-form-group">

                <label for="guestCount">
                    NUMBER OF GUESTS
                </label>

                <input
                    id="guestCount"
                    type="number"
                    min="1"
                    value="1"
                    required>

            </div>


            <div
                id="guestModalMessage"
                class="guest-modal-message">
            </div>


            <div class="guest-modal-actions">

                <button
                    type="submit"
                    id="addGuestButton"
                    class="guest-add-btn">

                    Add Guest

                </button>


                <button
                    type="button"
                    onclick="closeGuestModal()"
                    class="guest-cancel-btn">

                    Cancel

                </button>

            </div>


        </form>


    </div>


</div>


<script>


// ========================================
// OPEN MODAL
// ========================================

function openGuestModal() {

    document.getElementById(
        "guestModal"
    ).style.display = "flex";

    document.getElementById(
        "guestName"
    ).focus();

}


// ========================================
// CLOSE MODAL
// ========================================

function closeGuestModal() {

    document.getElementById(
        "guestModal"
    ).style.display = "none";

    document.getElementById(
        "guestForm"
    ).reset();

    document.getElementById(
        "guestCount"
    ).value = "1";

    document.getElementById(
        "guestModalMessage"
    ).textContent = "";

}


// ========================================
// LOAD GUESTS
// ========================================

async function loadGuests() {

    const list =
        document.getElementById(
            "guestList"
        );

    try {

        const response =
            await fetch(
                "php/api.php?action=my_guests",
                {
                    credentials:
                        "same-origin"
                }
            );


        const result =
            await response.json();


        if (!result.success) {

            list.innerHTML = `

                <div class="guest-empty">

                    <div class="guest-empty-icon">
                        ⚠
                    </div>

                    <h3>
                        Unable to load guests
                    </h3>

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


        const guests =
            result.data || [];


        // ------------------------------------
        // RESET STATS
        // ------------------------------------

        let totalGuests = 0;
        let confirmed = 0;
        let pending = 0;
        let declined = 0;


        guests.forEach(function(guest) {

            const count =
                Number(
                    guest.guest_count
                ) || 0;


            totalGuests += count;


            const status =
                String(
                    guest.rsvp_status || ""
                ).toLowerCase();


            if (status === "confirmed") {

                confirmed += count;

            }
            else if (status === "pending") {

                pending += count;

            }
            else if (status === "declined") {

                declined += count;

            }

        });


        // ------------------------------------
        // UPDATE STATS
        // ------------------------------------

        document.getElementById(
            "totalGuests"
        ).textContent =
            totalGuests;


        document.getElementById(
            "confirmedGuests"
        ).textContent =
            confirmed;


        document.getElementById(
            "pendingGuests"
        ).textContent =
            pending;


        document.getElementById(
            "declinedGuests"
        ).textContent =
            declined;


        // ------------------------------------
        // EMPTY STATE
        // ------------------------------------

        if (!guests.length) {

            list.innerHTML = `

                <div class="guest-empty">

                    <div class="guest-empty-icon">
                        ♧
                    </div>

                    <h3>
                        Your guest list is empty
                    </h3>

                    <p>
                        Add your first guest to start
                        managing your event.
                    </p>

                </div>

            `;

            return;
        }


        // ------------------------------------
        // RENDER GUESTS
        // ------------------------------------

        list.innerHTML = "";


        guests.forEach(function(guest) {

            const name =
                guest.name || "Guest";


            const initials =
                name
                    .split(" ")
                    .map(function(part) {
                        return part.charAt(0);
                    })
                    .join("")
                    .substring(0, 2)
                    .toUpperCase();


            const status =
                guest.rsvp_status ||
                "Pending";


            const row =
                document.createElement(
                    "div"
                );


            row.className =
                "guest-row";


            row.innerHTML = `

                <div class="guest-avatar">
                    ${escapeHtml(initials)}
                </div>


                <div class="guest-info">

                    <strong>
                        ${escapeHtml(name)}
                    </strong>

                    <small>
                        ${escapeHtml(
                            guest.category ||
                            "Other"
                        )}
                        •
                        ${escapeHtml(
                            guest.guest_count
                        )}
                        guest${Number(
                            guest.guest_count
                        ) === 1 ? "" : "s"}
                    </small>

                </div>


                <div class="guest-actions">

                    <select
                        class="guest-status-select"
                        onchange="
                            updateGuestStatus(
                                ${Number(guest.id)},
                                this.value
                            )
                        ">

                        <option
                            value="Confirmed"
                            ${status === "Confirmed"
                                ? "selected"
                                : ""}>

                            Confirmed

                        </option>

                        <option
                            value="Pending"
                            ${status === "Pending"
                                ? "selected"
                                : ""}>

                            Pending

                        </option>

                        <option
                            value="Declined"
                            ${status === "Declined"
                                ? "selected"
                                : ""}>

                            Declined

                        </option>

                    </select>


                    <button
                        class="guest-delete-btn"
                        onclick="
                            deleteGuest(
                                ${Number(guest.id)}
                            )
                        ">

                        Delete

                    </button>

                </div>

            `;


            list.appendChild(row);

        });

    }
    catch (error) {

        console.error(
            "Guest loading error:",
            error
        );


        list.innerHTML = `

            <div class="guest-empty">

                <div class="guest-empty-icon">
                    ⚠
                </div>

                <h3>
                    Something went wrong
                </h3>

                <p>
                    Please refresh the page and try again.
                </p>

            </div>

        `;

    }

}


// ========================================
// ADD GUEST
// ========================================

document
    .getElementById("guestForm")
    .addEventListener(
        "submit",
        async function(event) {

            event.preventDefault();


            const name =
                document.getElementById(
                    "guestName"
                ).value.trim();


            const category =
                document.getElementById(
                    "guestCategory"
                ).value;


            const count =
                Number(
                    document.getElementById(
                        "guestCount"
                    ).value
                );


            const message =
                document.getElementById(
                    "guestModalMessage"
                );


            const button =
                document.getElementById(
                    "addGuestButton"
                );


            if (!name) {

                message.style.color =
                    "#a23b3b";

                message.textContent =
                    "Please enter the guest name.";

                return;
            }


            if (count < 1) {

                message.style.color =
                    "#a23b3b";

                message.textContent =
                    "Guest count must be at least 1.";

                return;
            }


            button.disabled = true;

            button.textContent =
                "Adding...";


            try {

                const response =
                    await fetch(
                        "php/api.php?action=add_guest",
                        {
                            method: "POST",

                            headers: {
                                "Content-Type":
                                    "application/json"
                            },

                            credentials:
                                "same-origin",

                            body: JSON.stringify({

                                name: name,

                                category: category,

                                guest_count: count

                            })
                        }
                    );


                const result =
                    await response.json();


                if (result.success) {

                    closeGuestModal();

                    await loadGuests();

                }
                else {

                    message.style.color =
                        "#a23b3b";

                    message.textContent =
                        result.message ||
                        "Unable to add guest.";

                }

            }
            catch (error) {

                console.error(
                    "Add guest error:",
                    error
                );


                message.style.color =
                    "#a23b3b";

                message.textContent =
                    "Something went wrong.";

            }
            finally {

                button.disabled = false;

                button.textContent =
                    "Add Guest";

            }

        }
    );


// ========================================
// UPDATE RSVP STATUS
// ========================================

async function updateGuestStatus(
    guestId,
    status
) {

    try {

        const response =
            await fetch(
                "php/api.php?action=update_guest_status",
                {
                    method: "POST",

                    headers: {
                        "Content-Type":
                            "application/json"
                    },

                    credentials:
                        "same-origin",

                    body: JSON.stringify({

                        guest_id:
                            guestId,

                        rsvp_status:
                            status

                    })
                }
            );


        const result =
            await response.json();


        if (!result.success) {

            alert(
                result.message ||
                "Unable to update guest."
            );

            await loadGuests();

            return;
        }


        await loadGuests();

    }
    catch (error) {

        console.error(
            "Update guest status error:",
            error
        );

        alert(
            "Something went wrong."
        );

        await loadGuests();

    }

}


// ========================================
// DELETE GUEST
// ========================================

async function deleteGuest(
    guestId
) {

    const confirmed =
        confirm(
            "Are you sure you want to delete this guest?"
        );


    if (!confirmed) {
        return;
    }


    try {

        const response =
            await fetch(
                "php/api.php?action=delete_guest",
                {
                    method: "POST",

                    headers: {
                        "Content-Type":
                            "application/json"
                    },

                    credentials:
                        "same-origin",

                    body: JSON.stringify({

                        guest_id:
                            guestId

                    })
                }
            );


        const result =
            await response.json();


        if (!result.success) {

            alert(
                result.message ||
                "Unable to delete guest."
            );

            return;
        }


        await loadGuests();

    }
    catch (error) {

        console.error(
            "Delete guest error:",
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

    }
    catch (error) {

        console.error(
            "Logout error:",
            error
        );

    }


    window.location.href =
        "index.html";

}


// ========================================
// INITIAL LOAD
// ========================================

document.addEventListener(
    "DOMContentLoaded",
    function() {

        loadGuests();

    }
);

</script>


</body>

</html>