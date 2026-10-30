<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Create Account | EverAfter</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        :root {

            --primary: #8b5e83;
            --primary-dark: #70486a;

            --rose: #a96570;

            --soft: #f8f3f6;

            --cream: #fffaf7;

            --text: #29242a;

            --muted: #777078;

            --border: #e7dfe5;

            --success: #438a62;

            --danger: #c45151;
        }


        body {

            font-family:
                Inter,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Arial,
                sans-serif;

            min-height: 100vh;

            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(139, 94, 131, 0.13),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 90% 90%,
                    rgba(218, 184, 202, 0.18),
                    transparent 32%
                ),
                linear-gradient(
                    135deg,
                    #fffaf7,
                    #f8f3f6
                );

            color: var(--text);

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 30px 20px;

            position: relative;

            overflow-x: hidden;
        }


        /* =========================================
           DECORATIVE BACKGROUND
        ========================================= */

        body::before,
        body::after {

            content: "";

            position: fixed;

            width: 280px;

            height: 280px;

            border-radius: 50%;

            background:
                rgba(139, 94, 131, 0.05);

            z-index: -1;
        }


        body::before {

            top: -130px;

            left: -110px;
        }


        body::after {

            bottom: -140px;

            right: -110px;
        }


        /* =========================================
           MAIN WRAPPER
        ========================================= */

        .auth-wrapper {

            width: 100%;

            max-width: 1080px;

            background:
                rgba(255, 255, 255, 0.96);

            border:
                1px solid
                rgba(139, 94, 131, 0.10);

            border-radius: 28px;

            overflow: hidden;

            display: grid;

            grid-template-columns:
                0.9fr 1.1fr;

            box-shadow:
                0 25px 70px
                rgba(66, 42, 61, 0.12);
        }


        /* =========================================
           LEFT BRAND PANEL
        ========================================= */

        .auth-brand {

            position: relative;

            padding: 52px;

            min-height: 720px;

            display: flex;

            flex-direction: column;

            justify-content: space-between;

            background:
                linear-gradient(
                    145deg,
                    #8b5e83,
                    #70486a
                );

            color: white;

            overflow: hidden;
        }


        .auth-brand::before {

            content: "";

            position: absolute;

            width: 340px;

            height: 340px;

            border-radius: 50%;

            background:
                rgba(255,255,255,0.07);

            top: -150px;

            right: -120px;
        }


        .auth-brand::after {

            content: "";

            position: absolute;

            width: 240px;

            height: 240px;

            border-radius: 50%;

            background:
                rgba(255,255,255,0.05);

            bottom: -110px;

            left: -90px;
        }


        .brand-content {

            position: relative;

            z-index: 2;
        }


        .logo {

            font-size: 30px;

            font-weight: 800;

            letter-spacing: -1px;

            margin-bottom: 65px;
        }


        .logo span {

            opacity: 0.72;
        }


        .brand-eyebrow {

            font-size: 11px;

            letter-spacing: 2px;

            text-transform: uppercase;

            opacity: 0.72;

            margin-bottom: 16px;

            font-weight: 700;
        }


        .brand-title {

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size: 40px;

            line-height: 1.12;

            letter-spacing: -1px;

            margin-bottom: 20px;

            max-width: 390px;
        }


        .brand-title span {

            color: #e9b7c2;

            font-style: italic;
        }


        .brand-text {

            color:
                rgba(255,255,255,0.78);

            font-size: 14px;

            line-height: 1.75;

            max-width: 390px;
        }


        /* =========================================
           BRAND FEATURES
        ========================================= */

        .brand-features {

            position: relative;

            z-index: 2;

            display: grid;

            gap: 14px;
        }


        .feature {

            display: flex;

            align-items: center;

            gap: 12px;

            font-size: 13px;

            color:
                rgba(255,255,255,0.88);
        }


        .feature-icon {

            width: 34px;

            height: 34px;

            flex-shrink: 0;

            border-radius: 50%;

            background:
                rgba(255,255,255,0.12);

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 14px;
        }


        /* =========================================
           RIGHT FORM PANEL
        ========================================= */

        .auth-form-panel {

            padding: 48px 55px;

            display: flex;

            align-items: center;

            justify-content: center;
        }


        .auth-form-container {

            width: 100%;

            max-width: 470px;
        }


        .welcome {

            margin-bottom: 26px;
        }


        .welcome h1 {

            font-size: 30px;

            letter-spacing: -0.7px;

            margin-bottom: 8px;
        }


        .welcome p {

            color: var(--muted);

            font-size: 14px;

            line-height: 1.6;
        }


        /* =========================================
           FORM GROUP
        ========================================= */

        .form-group {

            margin-bottom: 18px;
        }


        label {

            display: block;

            font-size: 13px;

            font-weight: 700;

            margin-bottom: 8px;

            color: #413a40;
        }


        /* =========================================
           INPUTS
        ========================================= */

        .input-wrapper {

            position: relative;
        }


        .input-icon {

            position: absolute;

            left: 15px;

            top: 50%;

            transform:
                translateY(-50%);

            color: #9a9098;

            font-size: 15px;

            pointer-events: none;
        }


        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"] {

            width: 100%;

            height: 49px;

            padding:
                0 15px 0 43px;

            border:
                1px solid
                var(--border);

            border-radius: 11px;

            background: #fff;

            color: var(--text);

            font-size: 14px;

            outline: none;

            transition:
                border-color .2s,
                box-shadow .2s;
        }


        input::placeholder {

            color: #aaa2a8;
        }


        input:focus {

            border-color:
                var(--primary);

            box-shadow:
                0 0 0 4px
                rgba(139, 94, 131, 0.09);
        }


        /* =========================================
           ACCOUNT TYPE
        ========================================= */

        .account-type-label {

            margin-bottom: 10px;
        }


        .account-type-options {

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 12px;
        }


        .account-option {

            position: relative;
        }


        .account-option input {

            position: absolute;

            opacity: 0;

            pointer-events: none;
        }


        .account-option label {

            display: block;

            margin: 0;

            padding: 16px;

            min-height: 104px;

            border:
                1.5px solid
                var(--border);

            border-radius: 13px;

            cursor: pointer;

            background: white;

            transition:
                border-color .2s,
                background .2s,
                transform .2s,
                box-shadow .2s;
        }


        .account-option label:hover {

            border-color:
                #b99ab3;

            transform:
                translateY(-1px);
        }


        .account-option input:checked + label {

            border-color:
                var(--primary);

            background:
                #faf4f9;

            box-shadow:
                0 7px 18px
                rgba(139, 94, 131, 0.09);
        }


        .account-option-title-row {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 7px;
        }


        .account-option-title {

            font-size: 14px;

            font-weight: 800;

            color: #332d32;
        }


        .account-option-icon {

            width: 29px;

            height: 29px;

            border-radius: 8px;

            display: flex;

            align-items: center;

            justify-content: center;

            background:
                #f1e8ef;

            font-size: 14px;
        }


        .account-option-description {

            display: block;

            font-size: 11px;

            line-height: 1.5;

            font-weight: 400;

            color: #777078;
        }


        /* =========================================
           PASSWORD
        ========================================= */

        .password-wrapper {

            position: relative;
        }


        .password-wrapper input {

            padding-right: 70px;
        }


        .show-password {

            position: absolute;

            right: 10px;

            top: 50%;

            transform:
                translateY(-50%);

            border: none;

            background: transparent;

            color:
                var(--primary);

            font-size: 12px;

            font-weight: 700;

            cursor: pointer;

            padding: 6px;
        }


        .show-password:hover {

            color:
                var(--primary-dark);
        }


        /* =========================================
           PASSWORD STRENGTH
        ========================================= */

        .password-strength {

            display: none;

            margin-top: 8px;
        }


        .strength-track {

            height: 4px;

            border-radius: 10px;

            background: #eee8ec;

            overflow: hidden;

            margin-bottom: 5px;
        }


        .strength-bar {

            height: 100%;

            width: 0;

            border-radius: 10px;

            transition:
                width .25s ease,
                background .25s ease;
        }


        .strength-text {

            font-size: 10px;

            color: #8a8289;
        }


        /* =========================================
           SUBMIT BUTTON
        ========================================= */

        .btn {

            width: 100%;

            height: 51px;

            border: none;

            border-radius: 12px;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary-dark)
                );

            color: white;

            font-size: 14px;

            font-weight: 700;

            cursor: pointer;

            box-shadow:
                0 10px 22px
                rgba(139, 94, 131, 0.22);

            transition:
                transform .2s,
                box-shadow .2s,
                opacity .2s;

            margin-top: 5px;
        }


        .btn:hover {

            transform:
                translateY(-1px);

            box-shadow:
                0 13px 26px
                rgba(139, 94, 131, 0.27);
        }


        .btn:active {

            transform:
                translateY(0);
        }


        .btn:disabled {

            opacity: .65;

            cursor: not-allowed;

            transform: none;
        }


        /* =========================================
           MESSAGE
        ========================================= */

        .message {

            margin-top: 13px;

            min-height: 20px;

            text-align: center;

            font-size: 13px;

            line-height: 1.5;
        }


        /* =========================================
           LOGIN LINK
        ========================================= */

        .login-link {

            margin-top: 20px;

            text-align: center;

            color: var(--muted);

            font-size: 13px;
        }


        .login-link a {

            color:
                var(--primary);

            text-decoration: none;

            font-weight: 700;

            margin-left: 4px;
        }


        .login-link a:hover {

            text-decoration: underline;
        }


        .back-home {

            display: block;

            text-align: center;

            margin-top: 14px;

            color: #999199;

            text-decoration: none;

            font-size: 12px;
        }


        .back-home:hover {

            color:
                var(--primary);
        }


        /* =========================================
           MOBILE
        ========================================= */

        @media (max-width: 850px) {

            .auth-wrapper {

                max-width: 520px;

                grid-template-columns: 1fr;
            }


            .auth-brand {

                min-height: 300px;

                padding: 35px 30px;
            }


            .logo {

                margin-bottom: 35px;
            }


            .brand-title {

                font-size: 32px;
            }


            .brand-features {

                display: none;
            }


            .auth-form-panel {

                padding:
                    40px 30px;
            }

        }


        @media (max-width: 500px) {

            body {

                padding: 15px;
            }


            .auth-wrapper {

                border-radius: 20px;
            }


            .auth-brand {

                padding:
                    30px 24px;
            }


            .brand-title {

                font-size: 28px;
            }


            .auth-form-panel {

                padding:
                    32px 20px;
            }


            .welcome h1 {

                font-size: 26px;
            }


            .account-type-options {

                grid-template-columns: 1fr;
            }


            .account-option label {

                min-height: auto;
            }

        }

    </style>

</head>


<body>


<div class="auth-wrapper">


    <!-- =====================================================
         LEFT BRAND PANEL
    ====================================================== -->

    <section class="auth-brand">

        <div class="brand-content">


            <div class="logo">

                Ever<span>After</span>

            </div>


            <div class="brand-eyebrow">

                Wedding & Event Management

            </div>


            <h2 class="brand-title">

                Bring your
                <span>perfect day</span>
                to life.

            </h2>


            <p class="brand-text">

                Create your EverAfter account and
                discover everything you need to plan,
                organize and manage your celebration
                beautifully.

            </p>

        </div>


        <div class="brand-features">


            <div class="feature">

                <div class="feature-icon">
                    ✓
                </div>

                <span>
                    Discover trusted event vendors
                </span>

            </div>


            <div class="feature">

                <div class="feature-icon">
                    ♡
                </div>

                <span>
                    Shortlist vendors you love
                </span>

            </div>


            <div class="feature">

                <div class="feature-icon">
                    ✦
                </div>

                <span>
                    Manage your entire celebration
                </span>

            </div>


            <div class="feature">

                <div class="feature-icon">
                    ⟡
                </div>

                <span>
                    Connect with customers as a vendor
                </span>

            </div>


        </div>

    </section>



    <!-- =====================================================
         REGISTER PANEL
    ====================================================== -->

    <section class="auth-form-panel">

        <div class="auth-form-container">


            <div class="welcome">

                <h1>
                    Create your account
                </h1>

                <p>
                    Join EverAfter and start planning
                    something unforgettable.
                </p>

            </div>



            <form id="registerForm">


                <!-- =================================================
                     ACCOUNT TYPE
                ================================================== -->

                <div class="form-group">


                    <label class="account-type-label">

                        I want to join as

                    </label>


                    <div class="account-type-options">


                        <!-- CUSTOMER -->

                        <div class="account-option">

                            <input
                                type="radio"
                                id="roleCustomer"
                                name="role"
                                value="customer"
                                checked
                            >


                            <label
                                for="roleCustomer"
                            >

                                <div
                                    class="account-option-title-row"
                                >

                                    <span
                                        class="account-option-title"
                                    >
                                        Customer
                                    </span>


                                    <span
                                        class="account-option-icon"
                                    >
                                        💍
                                    </span>

                                </div>


                                <span
                                    class="account-option-description"
                                >

                                    Plan your event,
                                    discover vendors and
                                    manage your celebration.

                                </span>

                            </label>

                        </div>



                        <!-- VENDOR -->

                        <div class="account-option">

                            <input
                                type="radio"
                                id="roleVendor"
                                name="role"
                                value="vendor"
                            >


                            <label
                                for="roleVendor"
                            >

                                <div
                                    class="account-option-title-row"
                                >

                                    <span
                                        class="account-option-title"
                                    >
                                        Vendor
                                    </span>


                                    <span
                                        class="account-option-icon"
                                    >
                                        ✦
                                    </span>

                                </div>


                                <span
                                    class="account-option-description"
                                >

                                    Showcase your services
                                    and connect with event
                                    customers.

                                </span>

                            </label>

                        </div>


                    </div>

                </div>



                <!-- =================================================
                     FULL NAME
                ================================================== -->

                <div class="form-group">

                    <label for="name">
                        Full Name
                    </label>


                    <div class="input-wrapper">

                        <span class="input-icon">
                            👤
                        </span>


                        <input
                            type="text"
                            id="name"
                            placeholder="Enter your full name"
                            autocomplete="name"
                            required
                        >

                    </div>

                </div>



                <!-- =================================================
                     EMAIL
                ================================================== -->

                <div class="form-group">

                    <label for="email">
                        Email address
                    </label>


                    <div class="input-wrapper">

                        <span class="input-icon">
                            ✉
                        </span>


                        <input
                            type="email"
                            id="email"
                            placeholder="you@example.com"
                            autocomplete="email"
                            required
                        >

                    </div>

                </div>



                <!-- =================================================
                     PASSWORD
                ================================================== -->

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>


                    <div class="input-wrapper password-wrapper">

                        <span class="input-icon">
                            🔒
                        </span>


                        <input
                            type="password"
                            id="password"
                            placeholder="Minimum 6 characters"
                            minlength="6"
                            autocomplete="new-password"
                            required
                        >


                        <button
                            type="button"
                            class="show-password"
                            onclick="togglePassword(
                                'password',
                                this
                            )"
                        >
                            Show
                        </button>

                    </div>


                    <div
                        id="passwordStrength"
                        class="password-strength"
                    >

                        <div class="strength-track">

                            <div
                                id="strengthBar"
                                class="strength-bar"
                            ></div>

                        </div>


                        <div
                            id="strengthText"
                            class="strength-text"
                        ></div>

                    </div>

                </div>



                <!-- =================================================
                     WEDDING DATE
                ================================================== -->

                <div
                    class="form-group"
                    id="weddingDateGroup"
                >

                    <label for="wedding_date">

                        Wedding Date

                        <span
                            style="
                                font-weight:400;
                                color:#999;
                            "
                        >
                            (optional)
                        </span>

                    </label>


                    <div class="input-wrapper">

                        <span class="input-icon">
                            📅
                        </span>


                        <input
                            type="date"
                            id="wedding_date"
                        >

                    </div>

                </div>



                <!-- =================================================
                     SUBMIT
                ================================================== -->

                <button
                    type="submit"
                    class="btn"
                    id="registerButton"
                >

                    Create My Account

                </button>


                <div
                    id="message"
                    class="message"
                ></div>


            </form>



            <div class="login-link">

                Already have an account?

                <a href="login.php">
                    Sign in
                </a>

            </div>


            <a
                href="index.html"
                class="back-home"
            >

                ← Back to EverAfter

            </a>


        </div>

    </section>


</div>



<script>


// ============================================================
// PASSWORD SHOW / HIDE
// ============================================================

function togglePassword(
    inputId,
    button
) {

    const input =
        document.getElementById(
            inputId
        );


    if (input.type === "password") {

        input.type = "text";

        button.textContent =
            "Hide";

    } else {

        input.type = "password";

        button.textContent =
            "Show";
    }

}



// ============================================================
// PASSWORD STRENGTH
// ============================================================

const passwordInput =
    document.getElementById(
        "password"
    );


const passwordStrength =
    document.getElementById(
        "passwordStrength"
    );


const strengthBar =
    document.getElementById(
        "strengthBar"
    );


const strengthText =
    document.getElementById(
        "strengthText"
    );


passwordInput.addEventListener(
    "input",
    function() {

        const password =
            this.value;


        if (!password) {

            passwordStrength.style.display =
                "none";

            strengthBar.style.width =
                "0%";

            return;
        }


        passwordStrength.style.display =
            "block";


        let score = 0;


        if (password.length >= 6) {
            score++;
        }


        if (password.length >= 10) {
            score++;
        }


        if (/[A-Z]/.test(password)) {
            score++;
        }


        if (/[0-9]/.test(password)) {
            score++;
        }


        if (/[^A-Za-z0-9]/.test(password)) {
            score++;
        }


        if (score <= 2) {

            strengthBar.style.width =
                "35%";

            strengthBar.style.background =
                "#c45151";

            strengthText.textContent =
                "Weak password";

        } else if (score <= 3) {

            strengthBar.style.width =
                "65%";

            strengthBar.style.background =
                "#c58a4a";

            strengthText.textContent =
                "Moderate password";

        } else {

            strengthBar.style.width =
                "100%";

            strengthBar.style.background =
                "#438a62";

            strengthText.textContent =
                "Strong password";

        }

    }
);



// ============================================================
// ROLE SELECTION
// ============================================================

document
    .querySelectorAll(
        'input[name="role"]'
    )
    .forEach(
        function(radio) {

            radio.addEventListener(
                "change",
                function() {

                    const weddingDateGroup =
                        document.getElementById(
                            "weddingDateGroup"
                        );


                    const weddingDate =
                        document.getElementById(
                            "wedding_date"
                        );


                    /*
                     * Wedding date is relevant
                     * for customers.
                     */

                    if (
                        this.value ===
                        "vendor"
                    ) {

                        weddingDateGroup.style.display =
                            "none";

                        weddingDate.value =
                            "";

                    } else {

                        weddingDateGroup.style.display =
                            "block";
                    }

                }
            );

        }
    );



// ============================================================
// REGISTRATION
// ============================================================

document
    .getElementById("registerForm")
    .addEventListener(
        "submit",
        async function(event) {

            event.preventDefault();


            const message =
                document.getElementById(
                    "message"
                );


            const registerButton =
                document.getElementById(
                    "registerButton"
                );


            message.textContent =
                "Creating your account...";

            message.style.color =
                "#777078";


            registerButton.disabled =
                true;

            registerButton.textContent =
                "Creating Account...";


            /*
             * GET SELECTED ROLE
             */

            const selectedRole =
                document.querySelector(
                    'input[name="role"]:checked'
                );


            if (!selectedRole) {

                message.textContent =
                    "Please select Customer or Vendor.";

                message.style.color =
                    "#c45151";


                registerButton.disabled =
                    false;

                registerButton.textContent =
                    "Create My Account";


                return;
            }


            const role =
                selectedRole.value;


            /*
             * FORM DATA
             */

            const data = {

                name:
                    document
                        .getElementById("name")
                        .value
                        .trim(),

                email:
                    document
                        .getElementById("email")
                        .value
                        .trim(),

                password:
                    document
                        .getElementById("password")
                        .value,

                wedding_date:
                    role === "customer"
                        ? (
                            document
                                .getElementById(
                                    "wedding_date"
                                )
                                .value || null
                        )
                        : null,

                role:
                    role

            };


            try {

                const response =
                    await fetch(
                        "php/api.php?action=register",
                        {

                            method:
                                "POST",

                            headers: {
                                "Content-Type":
                                    "application/json"
                            },

                            credentials:
                                "same-origin",

                            body:
                                JSON.stringify(data)

                        }
                    );


                const result =
                    await response.json();


                console.log(
                    "Registration response:",
                    result
                );


                if (result.success) {

                    message.textContent =
                        "Account created successfully! Redirecting...";

                    message.style.color =
                        "#438a62";


                    setTimeout(
                        function() {

                            /*
                             * ROLE-BASED REDIRECT
                             */

                            if (
                                role ===
                                "vendor"
                            ) {

                                window.location.href =
                                    "vendor-dashboard.php";

                            } else {

                                window.location.href =
                                    "dashboard.php";

                            }

                        },
                        700
                    );


                } else {

                    message.textContent =
                        result.message ||
                        "Registration failed.";

                    message.style.color =
                        "#c45151";


                    registerButton.disabled =
                        false;

                    registerButton.textContent =
                        "Create My Account";
                }


            } catch (error) {

                console.error(
                    "Registration error:",
                    error
                );


                message.textContent =
                    "Something went wrong. Please try again.";

                message.style.color =
                    "#c45151";


                registerButton.disabled =
                    false;

                registerButton.textContent =
                    "Create My Account";
            }

        }
    );

</script>


</body>

</html>