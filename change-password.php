<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <title>Change Password - EverAfter</title>

    <link rel="stylesheet" href="css/admin.css">

    <style>
        body {
            margin: 0;
            background: #f7f7f8;
            font-family: Georgia, "Times New Roman", serif;
        }

        .change-password-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }

        .change-password-card {
            width: 100%;
            max-width: 480px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 36px;
            box-sizing: border-box;
        }

        .change-password-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: 700;
            color: #111827;
        }

        .change-password-logo-mark {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #111827;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
        }

        .change-password-card h1 {
            margin: 0 0 10px;
            font-size: 28px;
            color: #111827;
        }

        .change-password-card p {
            margin: 0 0 25px;
            color: #6b7280;
            line-height: 1.6;
            font-size: 15px;
        }

        .change-password-group {
            margin-bottom: 18px;
        }

        .change-password-group label {
            display: block;
            margin-bottom: 7px;
            font-size: 13px;
            font-weight: 700;
            color: #374151;
        }

        .change-password-group input {
            width: 100%;
            box-sizing: border-box;
            padding: 13px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
        }

        .change-password-group input:focus {
            border-color: #111827;
        }

        .change-password-button {
            width: 100%;
            border: none;
            border-radius: 10px;
            padding: 14px;
            background: #111827;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 5px;
        }

        .change-password-button:hover {
            background: #1f2937;
        }

        .change-password-message {
            margin-top: 18px;
            padding: 12px 14px;
            border-radius: 10px;
            display: none;
            font-size: 14px;
        }

        .change-password-message.success {
            display: block;
            background: #ecfdf3;
            color: #15803d;
        }

        .change-password-message.error {
            display: block;
            background: #fef2f2;
            color: #dc2626;
        }

        @media (max-width: 500px) {
            .change-password-card {
                padding: 26px 20px;
            }
        }
    </style>
</head>

<body>

<div class="change-password-page">

    <div class="change-password-card">

        <div class="change-password-logo">
            <span class="change-password-logo-mark">EA</span>
            <span>EverAfter</span>
        </div>

        <h1>Change your password</h1>

        <p>
            Your password was reset by an administrator.
            Please create a new password before continuing.
        </p>

        <form id="changePasswordForm">

            <div class="change-password-group">
                <label for="currentPassword">
                    Temporary Password
                </label>

                <input
                    type="password"
                    id="currentPassword"
                    required
                    autocomplete="current-password"
                >
            </div>

            <div class="change-password-group">
                <label for="newPassword">
                    New Password
                </label>

                <input
                    type="password"
                    id="newPassword"
                    minlength="8"
                    required
                    autocomplete="new-password"
                >
            </div>

            <div class="change-password-group">
                <label for="confirmPassword">
                    Confirm New Password
                </label>

                <input
                    type="password"
                    id="confirmPassword"
                    minlength="8"
                    required
                    autocomplete="new-password"
                >
            </div>

            <button
                type="submit"
                class="change-password-button">
                Change Password
            </button>

        </form>

        <div id="changePasswordMessage"
             class="change-password-message">
        </div>

    </div>

</div>

<script>

document.getElementById("changePasswordForm")
    .addEventListener("submit", async function (event) {

        event.preventDefault();

        const currentPassword =
            document.getElementById("currentPassword").value;

        const newPassword =
            document.getElementById("newPassword").value;

        const confirmPassword =
            document.getElementById("confirmPassword").value;

        const message =
            document.getElementById("changePasswordMessage");

        if (newPassword.length < 8) {
            showMessage(
                "New password must be at least 8 characters.",
                "error"
            );
            return;
        }

        if (newPassword !== confirmPassword) {
            showMessage(
                "New passwords do not match.",
                "error"
            );
            return;
        }

        try {

            const response = await fetch(
                "php/api.php?action=change_password",
                {
                    method: "POST",
                    credentials: "same-origin",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        current_password: currentPassword,
                        new_password: newPassword
                    })
                }
            );

            const result = await response.json();

            if (!result.success) {
                showMessage(
                    result.message || "Unable to change password.",
                    "error"
                );
                return;
            }

            showMessage(
                "Password changed successfully. Redirecting...",
                "success"
            );

            setTimeout(function () {

                const role = String(
                    result.user?.role || "customer"
                ).toLowerCase();

                if (role === "vendor") {
                    window.location.href =
                        "vendor-dashboard.php";
                } else if (role === "admin") {
                    window.location.href =
                        "admin-dashboard.php";
                } else {
                    window.location.href =
                        "dashboard.php";
                }

            }, 1000);

        } catch (error) {

            console.error(error);

            showMessage(
                "Something went wrong. Please try again.",
                "error"
            );
        }
    });


function showMessage(text, type) {

    const message =
        document.getElementById("changePasswordMessage");

    message.textContent = text;

    message.className =
        "change-password-message " + type;
}

</script>

</body>
</html>