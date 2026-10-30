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

$adminName = $_SESSION["user_name"] ?? "Admin";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard | EverAfter</title>

    <link rel="stylesheet"
          href="css/admin.css">

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

                    <h1>
                        Welcome, <?= htmlspecialchars($adminName) ?>
                    </h1>

                    <p>
                        Manage users, vendors and bookings from one place.
                    </p>

                </div>

            </div>


            <div id="adminMessage"
                 class="admin-message">
            </div>


            <!-- STAT CARDS -->

            <section class="admin-stats">

                <div class="admin-stat-card">

                    <div class="admin-stat-top">

                        <span class="admin-stat-label">
                            Total Users
                        </span>

                        <span class="admin-stat-icon">
                            ♙
                        </span>

                    </div>

                    <strong class="admin-stat-value"
                            id="totalUsers">
                        0
                    </strong>

                </div>


                <div class="admin-stat-card">

                    <div class="admin-stat-top">

                        <span class="admin-stat-label">
                            Vendors
                        </span>

                        <span class="admin-stat-icon">
                            ♢
                        </span>

                    </div>

                    <strong class="admin-stat-value"
                            id="totalVendors">
                        0
                    </strong>

                </div>


                <div class="admin-stat-card">

                    <div class="admin-stat-top">

                        <span class="admin-stat-label">
                            Pending Vendors
                        </span>

                        <span class="admin-stat-icon">
                            ⏳
                        </span>

                    </div>

                    <strong class="admin-stat-value"
                            id="pendingVendors">
                        0
                    </strong>

                </div>


                <div class="admin-stat-card">

                    <div class="admin-stat-top">

                        <span class="admin-stat-label">
                            Bookings
                        </span>

                        <span class="admin-stat-icon">
                            ▣
                        </span>

                    </div>

                    <strong class="admin-stat-value"
                            id="totalBookings">
                        0
                    </strong>

                </div>

            </section>


            <!-- QUICK INFO -->

            <section class="admin-card">

                <div class="admin-card-header">

                    <h2>
                        Admin Overview
                    </h2>

                    <span>
                        System Management
                    </span>

                </div>

                <p style="margin:0;color:#6b7280;line-height:1.7;">

                    From here you will be able to manage registered
                    customers, vendor approvals, bookings and other
                    platform activities.

                </p>

            </section>

        </div>

    </main>

</div>


<script>

async function loadAdminStats() {

    const message =
        document.getElementById("adminMessage");

    try {

        const response = await fetch(
            "php/api.php?action=admin_stats&_=" + Date.now(),
            {
                method: "GET",
                credentials: "same-origin",
                cache: "no-store"
            }
        );

        const result =
            await response.json();

        console.log("Admin stats:", result);

        if (!result.success) {

            message.textContent =
                result.message || "Unable to load admin statistics.";

            message.className =
                "admin-message error";

            return;
        }

        const data = result.data || {};

        document.getElementById("totalUsers").textContent =
            data.total_users ?? 0;

        document.getElementById("totalVendors").textContent =
            data.total_vendors ?? 0;

        document.getElementById("pendingVendors").textContent =
            data.pending_vendors ?? 0;

        document.getElementById("totalBookings").textContent =
            data.total_bookings ?? 0;

    } catch (error) {

        console.error("Admin stats error:", error);

        message.textContent =
            "Unable to connect to the server.";

        message.className =
            "admin-message error";
    }
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


document.addEventListener(
    "DOMContentLoaded",
    function() {

        loadAdminStats();

    }
);

</script>

</body>
</html>