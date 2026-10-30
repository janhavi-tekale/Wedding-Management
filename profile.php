<?php
require_once "php/auth.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>My Profile | EverAfter</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="css/dashboard.css">

    <style>

        .profile-page {
            max-width: 760px;
        }

        .profile-card {
            background: #ffffff;
            border: 1px solid #e8dfdc;
            border-radius: 18px;
            overflow: hidden;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 28px;
            border-bottom: 1px solid #eee5e2;
        }

        .profile-avatar {
            width: 72px;
            height: 72px;
            min-width: 72px;
            border-radius: 50%;
            background: #ead6d8;
            color: #70464c;
            display: grid;
            place-items: center;
            font-size: 24px;
            font-weight: 700;
        }

        .profile-header h2 {
            margin: 0 0 5px;
            font-family: "Playfair Display", serif;
            font-size: 28px;
            color: #342d2e;
        }

        .profile-header p {
            margin: 0;
            font-size: 11px;
            color: #777074;
        }

        .profile-form {
            padding: 28px;
        }

        .profile-section-title {
            margin: 0 0 22px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #6d5a5d;
        }

        .profile-field {
            margin-bottom: 20px;
        }

        .profile-field label {
            display: block;
            margin-bottom: 7px;
            font-size: 10px;
            font-weight: 700;
            color: #4d4546;
            letter-spacing: .4px;
        }

        .profile-field input {
            display: block;
            width: 100%;
            box-sizing: border-box;
            padding: 12px 13px;
            border: 1px solid #e8dfdc;
            border-radius: 9px;
            background: #ffffff;
            color: #342d2e;
            font-family: "DM Sans", sans-serif;
            font-size: 12px;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .profile-field input:focus {
            border-color: #9a5b63;
            box-shadow: 0 0 0 3px rgba(154, 91, 99, .08);
        }

        .profile-field input[readonly] {
            background: #f7f3f1;
            color: #777074;
            cursor: not-allowed;
        }

        .field-note {
            display: block;
            margin-top: 6px;
            font-size: 9px;
            color: #999194;
        }

        .profile-actions {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 8px;
        }

        .save-profile-btn {
            border: none;
            border-radius: 9px;
            padding: 12px 22px;
            background: #9a5b63;
            color: white;
            font-family: "DM Sans", sans-serif;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity .2s;
        }

        .save-profile-btn:hover {
            opacity: .9;
        }

        .save-profile-btn:disabled {
            opacity: .6;
            cursor: not-allowed;
        }

        .profile-message {
            min-height: 18px;
            font-size: 10px;
            font-weight: 600;
        }

        .profile-message.success {
            color: #4d7c4d;
        }

        .profile-message.error {
            color: #a23b3b;
        }

        .account-info {
            margin-top: 20px;
            padding: 20px 28px;
            border-top: 1px solid #eee5e2;
            background: #fcfaf9;
        }

        .account-info-title {
            margin: 0 0 8px;
            font-size: 10px;
            font-weight: 700;
            color: #6d5a5d;
            letter-spacing: .7px;
        }

        .account-created {
            margin: 0;
            font-size: 10px;
            color: #777074;
        }

        .loading-profile {
            font-size: 11px;
            color: #777074;
        }

        @media (max-width: 600px) {

            .profile-header {
                padding: 22px;
            }

            .profile-form {
                padding: 22px;
            }

            .account-info {
                padding: 18px 22px;
            }

            .profile-avatar {
                width: 60px;
                height: 60px;
                min-width: 60px;
                font-size: 20px;
            }

            .profile-header h2 {
                font-size: 23px;
            }

            .profile-actions {
                flex-direction: column;
                align-items: flex-start;
            }

        }

    </style>

</head>


<body>


<div class="app">


    <?php include "php/sidebar.php"; ?>


    <main class="main">


        <!-- ========================================
             PAGE HEADER
        ======================================== -->

        <header class="dashboard-top">

            <div>

                <span class="eyebrow">
                    ACCOUNT
                </span>

                <h1>
                    My Profile
                </h1>

            </div>

        </header>


        <!-- ========================================
             PROFILE
        ======================================== -->

        <div class="profile-page">


            <div class="profile-card">


                <!-- PROFILE HEADER -->

                <div class="profile-header">

                    <div
                        id="profileInitial"
                        class="profile-avatar">

                        A

                    </div>


                    <div>

                        <h2 id="profileName">
                            Loading...
                        </h2>

                        <p id="profileEmail">
                            Loading...
                        </p>

                    </div>

                </div>


                <!-- PROFILE FORM -->

                <div class="profile-form">

                    <h3 class="profile-section-title">
                        PERSONAL INFORMATION
                    </h3>


                    <!-- FULL NAME -->

                    <div class="profile-field">

                        <label for="name">
                            FULL NAME
                        </label>

                        <input
                            id="name"
                            type="text"
                            placeholder="Enter your full name"
                            autocomplete="name">

                    </div>


                    <!-- EMAIL -->

                    <div class="profile-field">

                        <label for="email">
                            EMAIL ADDRESS
                        </label>

                        <input
                            id="email"
                            type="email"
                            readonly>

                        <span class="field-note">
                            Email address cannot be changed here.
                        </span>

                    </div>


                    <!-- WEDDING DATE -->

                    <div class="profile-field">

                        <label for="weddingDate">
                            WEDDING DATE
                        </label>

                        <input
                            id="weddingDate"
                            type="date">

                    </div>


                    <!-- ACTIONS -->

                    <div class="profile-actions">

                        <button
                            id="saveProfileButton"
                            onclick="saveProfile()"
                            class="save-profile-btn">

                            Save Changes

                        </button>


                        <span
                            id="profileMessage"
                            class="profile-message">
                        </span>

                    </div>

                </div>


                <!-- ACCOUNT INFORMATION -->

                <div class="account-info">

                    <p class="account-info-title">
                        ACCOUNT INFORMATION
                    </p>

                    <p
                        id="accountCreated"
                        class="account-created">

                        Loading...

                    </p>

                </div>


            </div>


        </div>


    </main>


</div>


<script>


// ========================================
// LOAD PROFILE
// ========================================

async function loadProfile() {

    const message =
        document.getElementById(
            "profileMessage"
        );

    try {

        const response =
            await fetch(
                "php/api.php?action=profile",
                {
                    credentials: "same-origin"
                }
            );


        const result =
            await response.json();


        if (!result.success) {

            window.location.href =
                "index.html";

            return;
        }


        const user =
            result.user;


        // ------------------------------------
        // HEADER
        // ------------------------------------

        document.getElementById(
            "profileName"
        ).textContent =
            user.full_name || "User";


        document.getElementById(
            "profileEmail"
        ).textContent =
            user.email || "";


        // ------------------------------------
        // FORM
        // ------------------------------------

        document.getElementById(
            "name"
        ).value =
            user.full_name || "";


        document.getElementById(
            "email"
        ).value =
            user.email || "";


        document.getElementById(
            "weddingDate"
        ).value =
            user.wedding_date || "";


        // ------------------------------------
        // PROFILE INITIAL
        // ------------------------------------

        const fullName =
            user.full_name || "A";


        const initial =
            fullName
                .charAt(0)
                .toUpperCase();


        document.getElementById(
            "profileInitial"
        ).textContent =
            initial;


        // ------------------------------------
        // ACCOUNT CREATED
        // ------------------------------------

        if (user.created_at) {

            const createdDate =
                new Date(
                    user.created_at
                );


            if (!isNaN(
                createdDate.getTime()
            )) {

                document.getElementById(
                    "accountCreated"
                ).textContent =
                    "Account created on " +
                    createdDate.toLocaleDateString(
                        "en-IN",
                        {
                            day: "2-digit",
                            month: "long",
                            year: "numeric"
                        }
                    );

            } else {

                document.getElementById(
                    "accountCreated"
                ).textContent =
                    "Account created on " +
                    user.created_at;

            }

        } else {

            document.getElementById(
                "accountCreated"
            ).textContent =
                "Account information available";

        }

    }
    catch (error) {

        console.error(
            "Profile loading error:",
            error
        );


        message.className =
            "profile-message error";


        message.textContent =
            "Unable to load your profile. Please refresh the page.";

    }

}


// ========================================
// SAVE PROFILE
// ========================================

async function saveProfile() {

    const nameInput =
        document.getElementById(
            "name"
        );


    const weddingDateInput =
        document.getElementById(
            "weddingDate"
        );


    const button =
        document.getElementById(
            "saveProfileButton"
        );


    const message =
        document.getElementById(
            "profileMessage"
        );


    const name =
        nameInput.value.trim();


    const weddingDate =
        weddingDateInput.value;


    // ------------------------------------
    // VALIDATION
    // ------------------------------------

    if (name === "") {

        message.className =
            "profile-message error";

        message.textContent =
            "Please enter your full name.";

        nameInput.focus();

        return;
    }


    if (name.length < 2) {

        message.className =
            "profile-message error";

        message.textContent =
            "Name must contain at least 2 characters.";

        nameInput.focus();

        return;
    }


    // ------------------------------------
    // BUTTON STATE
    // ------------------------------------

    button.disabled = true;

    button.textContent =
        "Saving...";


    message.className =
        "profile-message";

    message.textContent =
        "";


    try {

        const response =
            await fetch(
                "php/api.php?action=update_profile",
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

                        wedding_date:
                            weddingDate

                    })
                }
            );


        const result =
            await response.json();


        if (result.success) {

            message.className =
                "profile-message success";

            message.textContent =
                "✓ " +
                (
                    result.message ||
                    "Profile updated successfully."
                );


            // Reload profile information

            await loadProfile();

        } else {

            message.className =
                "profile-message error";

            message.textContent =
                result.message ||
                "Unable to update profile.";

        }

    }
    catch (error) {

        console.error(
            "Profile update error:",
            error
        );


        message.className =
            "profile-message error";

        message.textContent =
            "Something went wrong. Please try again.";

    }
    finally {

        button.disabled = false;

        button.textContent =
            "Save Changes";

    }

}


// ========================================
// LOGOUT
// ========================================

async function logoutUser() {

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
        "index.html";

}


// ========================================
// INITIAL LOAD
// ========================================

document.addEventListener(
    "DOMContentLoaded",
    function() {

        loadProfile();

    }
);

</script>


</body>

</html>