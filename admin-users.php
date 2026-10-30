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
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Users | Admin | EverAfter</title>

    <link rel="stylesheet"
          href="css/admin.css">

    <style>

        .admin-toolbar {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .admin-search {
            flex: 1;
            min-width: 220px;
            height: 44px;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
            padding: 0 14px;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            background: #fff;
        }

        .admin-search:focus {
            border-color: #b88746;
        }

        .admin-role-filter {
            height: 44px;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
            padding: 0 35px 0 12px;
            font-family: inherit;
            font-size: 14px;
            background: #fff;
            outline: none;
        }

        .admin-table-wrapper {
            overflow-x: auto;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        .admin-table th {
            text-align: left;
            padding: 13px 14px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: #9ca3af;
            border-bottom: 1px solid #eeeeef;
            white-space: nowrap;
        }

        .admin-table td {
            padding: 16px 14px;
            font-size: 14px;
            color: #374151;
            border-bottom: 1px solid #f0f0f2;
            vertical-align: middle;
        }

        .admin-table tbody tr:hover {
            background: #fafafa;
        }

        .admin-user-name {
            font-weight: 600;
            color: #1f2937;
        }

        .admin-user-email {
            color: #6b7280;
        }

        .admin-role {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .admin-role.customer {
            background: #eff6ff;
            color: #2563eb;
        }

        .admin-role.vendor {
            background: #f5f3ff;
            color: #7c3aed;
        }

        .admin-role.admin {
            background: #f3eee8;
            color: #8b5e34;
        }

        .admin-empty {
            text-align: center;
            padding: 45px 20px;
            color: #9ca3af;
            font-size: 14px;
        }

        .admin-loading {
            text-align: center;
            padding: 35px;
            color: #9ca3af;
            font-size: 14px;
        }

        .admin-user-count {
            color: #9ca3af;
            font-size: 13px;
        }

        .admin-action-btn {
            border: 1px solid #e5e7eb; background: #fff; color: #8b5e34;
            border-radius: 8px; padding: 8px 12px; min-height: 38px;
            font-family: inherit; font-size: 12px; font-weight: 700; cursor: pointer;
            transition: all .2s ease; white-space: nowrap;
        }
        .admin-action-btn:hover { background: #f8f3ed; border-color: #d8c2a8; }
        .admin-action-btn:disabled { opacity: .5; cursor: not-allowed; }
        .admin-modal { position: fixed; inset: 0; background: rgba(17,24,39,.45); display: none; align-items: center; justify-content: center; padding: 20px; z-index: 1000; }
        .admin-modal.show { display: flex; }
        .admin-modal-card { width: min(100%, 460px); background: #fff; border-radius: 14px; padding: 26px; box-shadow: 0 20px 60px rgba(0,0,0,.18); }
        .admin-modal-header { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:20px; }
        .admin-modal-header h3 { margin:0 0 5px; font-size:21px; color:#1f2937; }
        .admin-modal-header p { margin:0; color:#6b7280; font-size:13px; }
        .admin-modal-close { border:0; background:transparent; color:#6b7280; font-size:24px; line-height:1; cursor:pointer; padding:4px; }
        .admin-reset-user { background:#faf7f3; border:1px solid #eee4d8; border-radius:10px; padding:12px 14px; margin-bottom:18px; }
        .admin-reset-user strong { display:block; color:#1f2937; margin-bottom:3px; }
        .admin-reset-user span { color:#6b7280; font-size:13px; word-break:break-word; }
        .admin-form-group { margin-bottom:18px; }
        .admin-form-group label { display:block; margin-bottom:7px; font-size:13px; font-weight:700; color:#374151; }
        .admin-password-wrap { display:flex; gap:8px; }
        .admin-password-input { flex:1; min-width:0; height:44px; border:1px solid #e5e7eb; border-radius:9px; padding:0 12px; font-family:inherit; font-size:14px; outline:none; }
        .admin-password-input:focus { border-color:#b88746; }
        .admin-generate-btn { border:1px solid #e5e7eb; background:#fff; border-radius:9px; padding:0 12px; font-family:inherit; font-size:12px; font-weight:700; color:#8b5e34; cursor:pointer; white-space:nowrap; }
        .admin-modal-actions { display:flex; justify-content:flex-end; gap:10px; margin-top:22px; }
        .admin-modal-btn { border:0; border-radius:9px; min-height:42px; padding:0 16px; font-family:inherit; font-size:13px; font-weight:700; cursor:pointer; }
        .admin-modal-btn.cancel { background:#f3f4f6; color:#374151; }
        .admin-modal-btn.primary { background:#8b5e34; color:#fff; }
        .admin-modal-btn:disabled { opacity:.55; cursor:not-allowed; }
        .admin-reset-help { margin-top:7px; color:#9ca3af; font-size:12px; line-height:1.5; }

        .admin-action-group {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .admin-action-btn.secondary {
            color: #374151;
            background: #f9fafb;
        }

        .admin-action-btn.secondary:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
        }

        .admin-details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .admin-detail-item {
            padding: 12px 13px;
            border: 1px solid #eeeef0;
            border-radius: 10px;
            background: #fafafa;
        }

        .admin-detail-item.full {
            grid-column: 1 / -1;
        }

        .admin-detail-label {
            display: block;
            margin-bottom: 5px;
            color: #9ca3af;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .admin-detail-value {
            color: #1f2937;
            font-size: 14px;
            font-weight: 600;
            word-break: break-word;
        }


        /* ========================================
   USER DETAILS MODAL
======================================== */

.user-details-modal {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(0, 0, 0, 0.55);

    align-items: center;
    justify-content: center;

    padding: 20px;
    box-sizing: border-box;
}

.user-details-modal.show {
    display: flex;
}

/* Main popup */
.user-details-modal-box {
    position: relative;

    width: min(900px, 100%);
    max-height: calc(100vh - 40px);

    background: #ffffff;
    border-radius: 14px;

    display: flex;
    flex-direction: column;

    overflow: hidden;

    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
}

/* Header */
.user-details-modal-header {
    flex: 0 0 auto;

    display: flex;
    align-items: center;
    justify-content: space-between;

    padding: 18px 22px;

    border-bottom: 1px solid #e5e7eb;
    background: #ffffff;
}

.user-details-modal-title {
    margin: 0;

    font-size: 20px;
    font-weight: 700;
    color: #111827;
}

/* Close button */
.user-details-close {
    width: 40px;
    height: 40px;

    border: none;
    border-radius: 8px;

    background: #f3f4f6;
    color: #374151;

    font-size: 24px;
    line-height: 1;

    cursor: pointer;

    display: flex;
    align-items: center;
    justify-content: center;

    transition: 0.2s ease;
}

.user-details-close:hover {
    background: #e5e7eb;
    color: #111827;
}

/* Scrollable content */
.user-details-modal-content {
    flex: 1 1 auto;

    min-height: 0;

    overflow-y: auto;
    overflow-x: hidden;

    padding: 22px;

    -webkit-overflow-scrolling: touch;
}

/* Scrollbar */
.user-details-modal-content::-webkit-scrollbar {
    width: 8px;
}

.user-details-modal-content::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.user-details-modal-content::-webkit-scrollbar-thumb {
    background: #c7c7c7;
    border-radius: 10px;
}

.user-details-modal-content::-webkit-scrollbar-thumb:hover {
    background: #999;
}

/* Sections */
.admin-details-section {
    margin-bottom: 24px;
}

.admin-details-section h3 {
    margin: 0 0 14px 0;

    font-size: 17px;
    font-weight: 700;

    color: #111827;
}

/* Detail grid */
.admin-details-grid {
    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 12px;
}

/* Individual information */
.admin-detail-item {
    padding: 12px 14px;

    background: #f9fafb;

    border: 1px solid #e5e7eb;
    border-radius: 8px;

    min-width: 0;
}

.admin-detail-label {
    font-size: 12px;
    font-weight: 600;

    color: #6b7280;

    margin-bottom: 5px;

    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.admin-detail-value {
    font-size: 14px;
    color: #111827;

    word-break: break-word;
}

/* Event / booking cards */
.admin-detail-card {
    border: 1px solid #e5e7eb;
    border-radius: 10px;

    padding: 16px;

    margin-bottom: 12px;

    background: #ffffff;
}

.admin-detail-card-title {
    font-size: 16px;
    font-weight: 700;

    color: #111827;

    margin-bottom: 14px;
}

/* Empty state */
.admin-empty-state {
    padding: 20px;

    text-align: center;

    color: #6b7280;

    border: 1px dashed #d1d5db;
    border-radius: 10px;

    background: #f9fafb;
}

/* Mobile */
@media (max-width: 700px) {

    .user-details-modal {
        padding: 10px;
    }

    .user-details-modal-box {
        max-height: calc(100vh - 20px);
        border-radius: 12px;
    }

    .user-details-modal-header {
        padding: 14px 16px;
    }

    .user-details-modal-content {
        padding: 16px;
    }

    .admin-details-grid {
        grid-template-columns: 1fr;
    }
}


        @media (max-width: 600px) {


            .admin-toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .admin-search {
                width: 100%;
            }

            .admin-role-filter {
                width: 100%;
            }

        }

    </style>

</head>

<body data-admin-id="<?php echo (int)($_SESSION["user_id"] ?? 0); ?>">

<div class="admin-layout">

    <?php include "php/admin-sidebar.php"; ?>

    <main class="admin-main">

        <div class="admin-content">

            <div class="admin-page-header">

                <div>

                    <p class="admin-eyebrow">
                        ADMIN PANEL
                    </p>

                    <h1>
                        Users
                    </h1>

                    <p>
                        Manage registered customers, vendors and administrators.
                    </p>

                </div>

            </div>


            <div id="adminMessage"
                 class="admin-message">
            </div>


            <section class="admin-card">

                <div class="admin-card-header">

                    <h2>
                        All Users
                    </h2>

                    <span id="userCount"
                          class="admin-user-count">
                        Loading...
                    </span>

                </div>


                <div class="admin-toolbar">

                    <input
                        type="text"
                        id="userSearch"
                        class="admin-search"
                        placeholder="Search by name or email..."
                    >


                    <select
                        id="roleFilter"
                        class="admin-role-filter">

                        <option value="all">
                            All Roles
                        </option>

                        <option value="customer">
                            Customers
                        </option>

                        <option value="vendor">
                            Vendors
                        </option>

                        <option value="admin">
                            Admins
                        </option>

                    </select>

                </div>


                <div class="admin-table-wrapper">

                    <table class="admin-table">

                        <thead>

                            <tr>

                                <th>
                                    ID
                                </th>

                                <th>
                                    Name
                                </th>

                                <th>
                                    Email
                                </th>

                                <th>
                                    Role
                                </th>

                                <th>
                                    Created
                                </th>

                                <th>
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody id="usersTableBody">

                            <tr>

                                <td colspan="6"
                                    class="admin-loading">

                                    Loading users...

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </section>

        </div>

    </main>

</div>


<div id="userDetailsModal" class="user-details-modal">

    <div class="user-details-modal-box">

        <div class="user-details-modal-header">

            <h2 class="user-details-modal-title">
                User Details
            </h2>

            <button
                type="button"
                class="user-details-close"
                id="userDetailsCloseBtn"
                aria-label="Close"
            >
                ×
            </button>

        </div>

        <div
            id="userDetailsContent"
            class="user-details-modal-content"
        >
            <div class="admin-empty-state">
                Loading user details...
            </div>
        </div>

    </div>

</div>

<div id="resetPasswordModal" class="admin-modal" aria-hidden="true">
    <div class="admin-modal-card" role="dialog" aria-modal="true" aria-labelledby="resetPasswordTitle">
        <div class="admin-modal-header">
            <div>
                <h3 id="resetPasswordTitle">Reset Password</h3>
                <p>Set a temporary password for this user.</p>
            </div>
            <button type="button" class="admin-modal-close" onclick="closeResetPasswordModal()" aria-label="Close">&times;</button>
        </div>
        <div class="admin-reset-user">
            <strong id="resetUserName">-</strong>
            <span id="resetUserEmail">-</span>
        </div>
        <div class="admin-form-group">
            <label for="temporaryPassword">Temporary Password</label>
            <div class="admin-password-wrap">
                <input type="password" id="temporaryPassword" class="admin-password-input" minlength="8" autocomplete="new-password" placeholder="Minimum 8 characters">
                <button type="button" class="admin-generate-btn" onclick="generateTemporaryPassword()">Generate</button>
            </div>
            <div class="admin-reset-help">The user will be required to create a new password after logging in.</div>
        </div>
        <div id="resetPasswordMessage" class="admin-message"></div>
        <div class="admin-modal-actions">
            <button type="button" class="admin-modal-btn cancel" onclick="closeResetPasswordModal()">Cancel</button>
            <button type="button" id="confirmResetPasswordBtn" class="admin-modal-btn primary" onclick="resetUserPassword()">Reset Password</button>
        </div>
    </div>
</div>

<script>

let allUsers = [];
let resetUserId = 0;


async function loadUsers() {

    const tableBody =
        document.getElementById("usersTableBody");

    const message =
        document.getElementById("adminMessage");

    try {

        const response = await fetch(
            "php/api.php?action=admin_users&_=" + Date.now(),
            {
                method: "GET",
                credentials: "same-origin",
                cache: "no-store"
            }
        );


        const result =
            await response.json();


        console.log("Admin users:", result);


        if (!result.success) {

            tableBody.innerHTML = `
                <tr>
                    <td colspan="6"
                        class="admin-empty">
                        ${escapeHtml(
                            result.message ||
                            "Unable to load users."
                        )}
                    </td>
                </tr>
            `;

            message.textContent =
                result.message ||
                "Unable to load users.";

            message.className =
                "admin-message error";

            return;
        }


        allUsers =
            Array.isArray(result.data)
                ? result.data
                : [];


        renderUsers();

    } catch (error) {

        console.error(
            "Admin users error:",
            error
        );


        tableBody.innerHTML = `
            <tr>
                <td colspan="6"
                    class="admin-empty">
                    Unable to connect to the server.
                </td>
            </tr>
        `;


        message.textContent =
            "Unable to connect to the server.";

        message.className =
            "admin-message error";
    }

}


const userDetailsCloseBtn =
    document.getElementById("userDetailsCloseBtn");

if (userDetailsCloseBtn) {
    userDetailsCloseBtn.addEventListener(
        "click",
        closeUserDetailsModal
    );
}


document.addEventListener("keydown", function(event) {

    if (event.key === "Escape") {
        closeUserDetailsModal();
    }

});


function renderUsers() {

    const tableBody =
        document.getElementById("usersTableBody");

    const search =
        document.getElementById("userSearch")
            .value
            .trim()
            .toLowerCase();


    const role =
        document.getElementById("roleFilter")
            .value;


    const filteredUsers =
        allUsers.filter(function(user) {

            const name =
                String(user.name || "")
                    .toLowerCase();

            const email =
                String(user.email || "")
                    .toLowerCase();

            const userRole =
                String(user.role || "")
                    .toLowerCase();


            const matchesSearch =
                !search ||
                name.includes(search) ||
                email.includes(search);


            const matchesRole =
                role === "all" ||
                userRole === role;


            return matchesSearch &&
                   matchesRole;

        });


    document.getElementById("userCount")
        .textContent =
            filteredUsers.length +
            " user" +
            (filteredUsers.length === 1 ? "" : "s");


    if (filteredUsers.length === 0) {

        tableBody.innerHTML = `
            <tr>
                <td colspan="6"
                    class="admin-empty">
                    No users found.
                </td>
            </tr>
        `;

        return;
    }


    tableBody.innerHTML =
        filteredUsers.map(function(user) {

            const userRole =
                String(
                    user.role || "customer"
                ).toLowerCase();


            const createdDate =
                formatDate(user.created_at);


            return `

                <tr>

                    <td>
                        #${Number(user.id)}
                    </td>

                    <td>
                        <span class="admin-user-name">
                            ${escapeHtml(user.name || "-")}
                        </span>
                    </td>

                    <td>
                        <span class="admin-user-email">
                            ${escapeHtml(user.email || "-")}
                        </span>
                    </td>

                    <td>

                        <span class="admin-role ${escapeHtml(userRole)}">
                            ${escapeHtml(
                                capitalize(userRole)
                            )}
                        </span>

                    </td>

                    <td>
                        ${escapeHtml(createdDate)}
                    </td>

                    <td>
                        <div class="admin-action-group">
                            <button
                                type="button"
                                class="admin-action-btn secondary"
                                onclick="openUserDetailsModal(${Number(user.id)})"
                            >
                                View Details
                            </button>

                            <button
                                type="button"
                                class="admin-action-btn"
                                ${Number(user.id) === getCurrentAdminId() ? "disabled" : ""}
                                onclick="openResetPasswordModal(
                                    ${Number(user.id)},
                                    '${escapeJs(user.name || "")}',
                                    '${escapeJs(user.email || "")}'
                                )"
                                title="${Number(user.id) === getCurrentAdminId() ? "You cannot reset your own admin password here." : "Reset this user's password"}"
                            >
                                Reset Password
                            </button>
                        </div>
                    </td>

                </tr>

            `;

        }).join("");

}


function getUserById(userId) {
    return allUsers.find(function(user) {
        return Number(user.id) === Number(userId);
    }) || null;
}

async function openUserDetailsModal(userId) {

    const user = getUserById(userId);

    if (!user) {
        alert("User not found.");
        return;
    }

    const modal = document.getElementById("userDetailsModal");

    if (!modal) {
        return;
    }

    modal.classList.add("show");

    const content = document.getElementById("userDetailsContent");

    content.innerHTML = `
        <div style="text-align:center;padding:30px;">
            <div style="font-size:16px;font-weight:600;">
                Loading user details...
            </div>
        </div>
    `;

    try {

        const response = await fetch(
            "php/api.php?action=admin_user_details&user_id=" +
            encodeURIComponent(userId) +
            "&_=" + Date.now(),
            {
                method: "GET",
                credentials: "same-origin",
                cache: "no-store"
            }
        );

        const result = await response.json();

        if (!result.success) {
            throw new Error(
                result.message || "Unable to load user details."
            );
        }

        const data = result.data || {};
        const detailedUser = data.user || {};
        const events = Array.isArray(data.events)
            ? data.events
            : [];
        const bookings = Array.isArray(data.bookings)
            ? data.bookings
            : [];

        const vendorProfile = data.vendor_profile || null;

        let html = "";

        // =========================
        // BASIC USER INFORMATION
        // =========================

        html += `
            <div class="admin-details-section">
                <h3>User Information</h3>

                <div class="admin-details-grid">

                    <div class="admin-detail-item">
                        <div class="admin-detail-label">
                            User ID
                        </div>
                        <div class="admin-detail-value">
                            ${escapeHtml(detailedUser.id)}
                        </div>
                    </div>

                    <div class="admin-detail-item">
                        <div class="admin-detail-label">
                            Name
                        </div>
                        <div class="admin-detail-value">
                            ${escapeHtml(detailedUser.name || "-")}
                        </div>
                    </div>

                    <div class="admin-detail-item">
                        <div class="admin-detail-label">
                            Email
                        </div>
                        <div class="admin-detail-value">
                            ${escapeHtml(detailedUser.email || "-")}
                        </div>
                    </div>

                    <div class="admin-detail-item">
                        <div class="admin-detail-label">
                            Role
                        </div>
                        <div class="admin-detail-value">
                            ${escapeHtml(detailedUser.role || "-")}
                        </div>
                    </div>

                    <div class="admin-detail-item">
                        <div class="admin-detail-label">
                            Account Created
                        </div>
                        <div class="admin-detail-value">
                            ${formatDateTime(detailedUser.created_at)}
                        </div>
                    </div>

                    <div class="admin-detail-item">
                        <div class="admin-detail-label">
                            Password Status
                        </div>
                        <div class="admin-detail-value">
                            ${
                                Number(
                                    detailedUser.must_change_password || 0
                                ) === 1
                                    ? "Temporary password"
                                    : "Normal password"
                            }
                        </div>
                    </div>

                </div>
            </div>
        `;


        // =========================
        // EVENTS
        // =========================

        html += `
            <div class="admin-details-section">
                <h3>
                    Events
                    <span style="font-weight:400;color:#777;">
                        (${events.length})
                    </span>
                </h3>
        `;

        if (events.length === 0) {

            html += `
                <div class="admin-empty-state">
                    No events found for this user.
                </div>
            `;

        } else {

            events.forEach(function(event) {

                html += `
                    <div class="admin-detail-card">

                        <div class="admin-detail-card-title">
                            ${escapeHtml(
                                event.event_name ||
                                event.event_type ||
                                "Event"
                            )}
                        </div>

                        <div class="admin-details-grid">

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Event Type
                                </div>
                                <div class="admin-detail-value">
                                    ${escapeHtml(
                                        event.event_type || "-"
                                    )}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Event Date
                                </div>
                                <div class="admin-detail-value">
                                    ${formatDate(
                                        event.event_date
                                    )}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    City
                                </div>
                                <div class="admin-detail-value">
                                    ${escapeHtml(
                                        event.city || "-"
                                    )}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Venue
                                </div>
                                <div class="admin-detail-value">
                                    ${escapeHtml(
                                        event.venue || "-"
                                    )}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Guests
                                </div>
                                <div class="admin-detail-value">
                                    ${
                                        event.guest_count !== null &&
                                        event.guest_count !== undefined
                                            ? escapeHtml(
                                                event.guest_count
                                            )
                                            : "-"
                                    }
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Budget
                                </div>
                                <div class="admin-detail-value">
                                    ${formatCurrency(event.budget)}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Status
                                </div>
                                <div class="admin-detail-value">
                                    ${escapeHtml(
                                        event.status || "-"
                                    )}
                                </div>
                            </div>

                        </div>

                    </div>
                `;

            });

        }

        html += `</div>`;


        // =========================
        // BOOKINGS
        // =========================

        html += `
            <div class="admin-details-section">
                <h3>
                    Bookings
                    <span style="font-weight:400;color:#777;">
                        (${bookings.length})
                    </span>
                </h3>
        `;

        if (bookings.length === 0) {

            html += `
                <div class="admin-empty-state">
                    No bookings found for this user.
                </div>
            `;

        } else {

            bookings.forEach(function(booking) {

                html += `
                    <div class="admin-detail-card">

                        <div class="admin-detail-card-title">
                            ${escapeHtml(
                                booking.vendor_name ||
                                "Vendor Booking"
                            )}
                        </div>

                        <div class="admin-details-grid">

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Booking ID
                                </div>
                                <div class="admin-detail-value">
                                    ${escapeHtml(booking.id)}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Vendor
                                </div>
                                <div class="admin-detail-value">
                                    ${escapeHtml(
                                        booking.vendor_name || "-"
                                    )}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Category
                                </div>
                                <div class="admin-detail-value">
                                    ${escapeHtml(
                                        booking.vendor_category || "-"
                                    )}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Booking Date
                                </div>
                                <div class="admin-detail-value">
                                    ${formatDate(
                                        booking.booking_date
                                    )}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Status
                                </div>
                                <div class="admin-detail-value">
                                    ${escapeHtml(
                                        booking.status || "-"
                                    )}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Amount
                                </div>
                                <div class="admin-detail-value">
                                    ${formatCurrency(
                                        booking.amount
                                    )}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Paid
                                </div>
                                <div class="admin-detail-value">
                                    ${formatCurrency(
                                        booking.paid_amount
                                    )}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Remaining
                                </div>
                                <div class="admin-detail-value">
                                    ${formatCurrency(
                                        booking.remaining_amount
                                    )}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Payment Status
                                </div>
                                <div class="admin-detail-value">
                                    ${escapeHtml(
                                        booking.payment_status || "-"
                                    )}
                                </div>
                            </div>

                        </div>

                    </div>
                `;

            });

        }

        html += `</div>`;


        // =========================
        // VENDOR PROFILE
        // =========================

        if (vendorProfile) {

            html += `
                <div class="admin-details-section">

                    <h3>Vendor Profile</h3>

                    <div class="admin-detail-card">

                        <div class="admin-details-grid">

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Business Name
                                </div>
                                <div class="admin-detail-value">
                                    ${escapeHtml(
                                        vendorProfile.business_name || "-"
                                    )}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Category
                                </div>
                                <div class="admin-detail-value">
                                    ${escapeHtml(
                                        vendorProfile.category || "-"
                                    )}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Phone
                                </div>
                                <div class="admin-detail-value">
                                    ${escapeHtml(
                                        vendorProfile.phone || "-"
                                    )}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Vendor Email
                                </div>
                                <div class="admin-detail-value">
                                    ${escapeHtml(
                                        vendorProfile.email || "-"
                                    )}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    City
                                </div>
                                <div class="admin-detail-value">
                                    ${escapeHtml(
                                        vendorProfile.city || "-"
                                    )}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Address
                                </div>
                                <div class="admin-detail-value">
                                    ${escapeHtml(
                                        vendorProfile.address || "-"
                                    )}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Starting Price
                                </div>
                                <div class="admin-detail-value">
                                    ${formatCurrency(
                                        vendorProfile.price_from
                                    )}
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Experience
                                </div>
                                <div class="admin-detail-value">
                                    ${escapeHtml(
                                        vendorProfile.experience_years || 0
                                    )} years
                                </div>
                            </div>

                            <div class="admin-detail-item">
                                <div class="admin-detail-label">
                                    Approval Status
                                </div>
                                <div class="admin-detail-value">
                                    ${escapeHtml(
                                        vendorProfile.status || "-"
                                    )}
                                </div>
                            </div>

                        </div>

                        <div style="margin-top:15px;">
                            <div class="admin-detail-label">
                                Description
                            </div>

                            <div class="admin-detail-value">
                                ${escapeHtml(
                                    vendorProfile.description || "-"
                                )}
                            </div>
                        </div>

                    </div>

                </div>
            `;
        }


        content.innerHTML = html;

    } catch (error) {

        console.error("User details error:", error);

        content.innerHTML = `
            <div class="admin-empty-state">
                <strong>Unable to load user details.</strong>
                <br>
                ${escapeHtml(
                    error.message || "Something went wrong."
                )}
            </div>
        `;
    }
}




const userDetailsModal =
    document.getElementById("userDetailsModal");

if (userDetailsModal) {

    userDetailsModal.addEventListener(
        "click",
        function(event) {

            if (event.target === userDetailsModal) {
                closeUserDetailsModal();
            }

        }
    );
}



function closeUserDetailsModal() {
    const modal = document.getElementById("userDetailsModal");
    modal.classList.remove("show");
    modal.setAttribute("aria-hidden", "true");
}

function getCurrentAdminId() {
    return Number(document.body.dataset.adminId || 0);
}

function escapeJs(value) {
    return String(value ?? "")
        .replace(/\\/g, "\\\\")
        .replace(/'/g, "\\'")
        .replace(/"/g, '\\"')
        .replace(/\r/g, "\\r")
        .replace(/\n/g, "\\n");
}

function generateTemporaryPassword() {
    const chars = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789";
    let password = "";
    for (let i = 0; i < 10; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    password += "@1";
    const input = document.getElementById("temporaryPassword");
    input.value = password;
    input.type = "text";
}

function openResetPasswordModal(userId, name, email) {
    resetUserId = Number(userId);
    document.getElementById("resetUserName").textContent = name || "-";
    document.getElementById("resetUserEmail").textContent = email || "-";
    const input = document.getElementById("temporaryPassword");
    input.value = "";
    input.type = "password";
    const message = document.getElementById("resetPasswordMessage");
    message.textContent = "";
    message.className = "admin-message";
    const button = document.getElementById("confirmResetPasswordBtn");
    button.disabled = false;
    button.textContent = "Reset Password";
    const modal = document.getElementById("resetPasswordModal");
    modal.classList.add("show");
    modal.setAttribute("aria-hidden", "false");
    setTimeout(() => input.focus(), 50);
}

function closeResetPasswordModal() {
    const modal = document.getElementById("resetPasswordModal");
    modal.classList.remove("show");
    modal.setAttribute("aria-hidden", "true");
    resetUserId = 0;
}

async function resetUserPassword() {
    const input = document.getElementById("temporaryPassword");
    const message = document.getElementById("resetPasswordMessage");
    const button = document.getElementById("confirmResetPasswordBtn");
    const temporaryPassword = input.value.trim();

    if (!resetUserId) {
        message.textContent = "Please select a user.";
        message.className = "admin-message error";
        return;
    }
    if (temporaryPassword.length < 8) {
        message.textContent = "Temporary password must be at least 8 characters.";
        message.className = "admin-message error";
        input.focus();
        return;
    }

    button.disabled = true;
    button.textContent = "Resetting...";
    message.textContent = "";
    message.className = "admin-message";

    try {
        const response = await fetch("php/api.php?action=admin_reset_password", {
            method: "POST",
            credentials: "same-origin",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                user_id: resetUserId,
                temporary_password: temporaryPassword
            })
        });
        const result = await response.json();
        if (!result.success) {
            throw new Error(result.message || "Unable to reset password.");
        }
        message.textContent = "Password reset successfully. The user must change it on next login.";
        message.className = "admin-message success";
        button.textContent = "Password Reset";
        setTimeout(closeResetPasswordModal, 1400);
    } catch (error) {
        console.error("Admin reset password error:", error);
        message.textContent = error.message || "Unable to reset password.";
        message.className = "admin-message error";
        button.disabled = false;
        button.textContent = "Reset Password";
    }
}

document.addEventListener("keydown", function(event) {
    if (event.key === "Escape") closeResetPasswordModal();
});

function formatDate(dateValue) {

    if (!dateValue) {
        return "-";
    }


    const date =
        new Date(dateValue);


    if (Number.isNaN(date.getTime())) {
        return String(dateValue);
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


function capitalize(value) {

    if (!value) {
        return "";
    }

    return value.charAt(0).toUpperCase()
        + value.slice(1);

}


function escapeHtml(value) {

    return String(value ?? "")
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");

}


document
    .getElementById("userSearch")
    .addEventListener(
        "input",
        renderUsers
    );


document
    .getElementById("roleFilter")
    .addEventListener(
        "change",
        renderUsers
    );


document.addEventListener(
    "DOMContentLoaded",
    function() {

        loadUsers();

    }
);


function formatCurrency(value) {
    const number = Number(value || 0);

    return "₹" + number.toLocaleString("en-IN", {
        maximumFractionDigits: 2
    });
}

function formatDate(value) {

    if (!value) {
        return "-";
    }

    const date = new Date(value);

    if (isNaN(date.getTime())) {
        return escapeHtml(value);
    }

    return date.toLocaleDateString("en-IN");
}

function formatDateTime(value) {

    if (!value) {
        return "-";
    }

    const date = new Date(value);

    if (isNaN(date.getTime())) {
        return escapeHtml(value);
    }

    return date.toLocaleString("en-IN");
}


async function logoutAdmin() {

    try {

        const response = await fetch(
            "php/api.php?action=logout",
            {
                method: "POST",
                credentials: "same-origin"
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