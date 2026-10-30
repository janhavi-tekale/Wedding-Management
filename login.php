
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <title>Login | EverAfter</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #8b5e83;
            --primary-dark: #70486a;
            --soft: #f8f3f6;
            --cream: #fffaf7;
            --text: #29242a;
            --muted: #777078;
            --border: #e7dfe5;
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
            overflow: hidden;
        }


        /* Decorative background */

        body::before,
        body::after {
            content: "";
            position: fixed;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(139, 94, 131, 0.05);
            z-index: -1;
        }

        body::before {
            top: -120px;
            left: -100px;
        }

        body::after {
            bottom: -130px;
            right: -100px;
        }


        /* Main wrapper */

        .auth-wrapper {

            width: 100%;
            max-width: 1050px;

            min-height: 620px;

            background: rgba(255, 255, 255, 0.94);

            border: 1px solid rgba(139, 94, 131, 0.10);

            border-radius: 28px;

            overflow: hidden;

            display: grid;

            grid-template-columns: 1fr 1fr;

            box-shadow:
                0 25px 70px rgba(66, 42, 61, 0.12);
        }


        /* Left branding panel */

        .auth-brand {

            position: relative;

            padding: 55px;

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

            width: 300px;
            height: 300px;

            border-radius: 50%;

            background: rgba(255,255,255,0.07);

            top: -130px;
            right: -100px;
        }


        .auth-brand::after {

            content: "";

            position: absolute;

            width: 220px;
            height: 220px;

            border-radius: 50%;

            background: rgba(255,255,255,0.05);

            bottom: -100px;
            left: -80px;
        }


        .brand-content {
            position: relative;
            z-index: 2;
        }


        .logo {

            font-size: 29px;

            font-weight: 800;

            letter-spacing: -1px;

            margin-bottom: 65px;
        }


        .logo span {
            opacity: 0.75;
        }


        .brand-eyebrow {

            font-size: 12px;

            letter-spacing: 2px;

            text-transform: uppercase;

            opacity: 0.72;

            margin-bottom: 16px;

            font-weight: 600;
        }


        .brand-title {

            font-size: 42px;

            line-height: 1.12;

            letter-spacing: -1.5px;

            margin-bottom: 20px;

            max-width: 400px;
        }


        .brand-text {

            color: rgba(255,255,255,0.78);

            font-size: 15px;

            line-height: 1.7;

            max-width: 390px;
        }


        .brand-features {

            position: relative;

            z-index: 2;

            display: grid;

            gap: 13px;
        }


        .feature {

            display: flex;

            align-items: center;

            gap: 12px;

            font-size: 14px;

            color: rgba(255,255,255,0.88);
        }


        .feature-icon {

            width: 31px;
            height: 31px;

            border-radius: 50%;

            background: rgba(255,255,255,0.12);

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 14px;
        }


        /* Right form */

        .auth-form-panel {

            padding: 55px 60px;

            display: flex;

            align-items: center;

            justify-content: center;
        }


        .auth-form-container {

            width: 100%;

            max-width: 390px;
        }


        .welcome {

            margin-bottom: 32px;
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


        /* Form */

        .form-group {

            margin-bottom: 20px;
        }


        label {

            display: block;

            font-size: 13px;

            font-weight: 700;

            margin-bottom: 8px;

            color: #413a40;
        }


        .input-wrapper {

            position: relative;
        }


        .input-icon {

            position: absolute;

            left: 15px;

            top: 50%;

            transform: translateY(-50%);

            color: #9a9098;

            font-size: 16px;

            pointer-events: none;
        }


        input {

            width: 100%;

            height: 52px;

            padding: 0 15px 0 43px;

            border: 1px solid var(--border);

            border-radius: 12px;

            background: #fff;

            color: var(--text);

            font-size: 14px;

            outline: none;

            transition:
                border-color 0.2s,
                box-shadow 0.2s,
                background 0.2s;
        }


        input::placeholder {
            color: #aaa2a8;
        }


        input:focus {

            border-color: var(--primary);

            background: white;

            box-shadow:
                0 0 0 4px rgba(139, 94, 131, 0.09);
        }


        .password-wrapper input {

            padding-right: 70px;
        }


        .show-password {

            position: absolute;

            right: 12px;

            top: 50%;

            transform: translateY(-50%);

            border: none;

            background: transparent;

            color: var(--primary);

            font-size: 12px;

            font-weight: 700;

            cursor: pointer;

            padding: 6px;
        }


        .show-password:hover {
            color: var(--primary-dark);
        }


        /* Login button */

        .btn {

            width: 100%;

            height: 52px;

            border: none;

            border-radius: 12px;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary-dark)
                );

            color: white;

            font-size: 15px;

            font-weight: 700;

            cursor: pointer;

            box-shadow:
                0 10px 22px
                rgba(139, 94, 131, 0.22);

            transition:
                transform 0.2s,
                box-shadow 0.2s,
                opacity 0.2s;
        }


        .btn:hover {

            transform: translateY(-1px);

            box-shadow:
                0 13px 26px
                rgba(139, 94, 131, 0.27);
        }


        .btn:active {
            transform: translateY(0);
        }


        .btn:disabled {

            opacity: 0.65;

            cursor: not-allowed;

            transform: none;
        }


        /* Message */

        .message {

            margin-top: 14px;

            min-height: 20px;

            text-align: center;

            font-size: 13px;

            line-height: 1.5;
        }


        /* Register */

        .register-link {

            margin-top: 25px;

            text-align: center;

            color: var(--muted);

            font-size: 13px;
        }


        .register-link a {

            color: var(--primary);

            text-decoration: none;

            font-weight: 700;

            margin-left: 4px;
        }


        .register-link a:hover {
            text-decoration: underline;
        }


        .back-home {

            display: block;

            text-align: center;

            margin-top: 18px;

            color: #999199;

            text-decoration: none;

            font-size: 12px;
        }


        .back-home:hover {
            color: var(--primary);
        }


        /* Mobile */

        @media (max-width: 800px) {

            .auth-wrapper {

                max-width: 500px;

                min-height: auto;

                grid-template-columns: 1fr;
            }


            .auth-brand {

                padding: 35px 30px;

                min-height: 300px;
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

                padding: 40px 30px;
            }
        }


        @media (max-width: 480px) {

            body {
                padding: 15px;
            }


            .auth-wrapper {
                border-radius: 20px;
            }


            .auth-brand {
                padding: 30px 25px;
            }


            .brand-title {
                font-size: 29px;
            }


            .auth-form-panel {
                padding: 35px 22px;
            }


            .welcome h1 {
                font-size: 26px;
            }
        }

    </style>

</head>


<body>


<div class="auth-wrapper">


    <!-- BRAND PANEL -->

    <section class="auth-brand">

        <div class="brand-content">

            <div class="logo">
                Ever<span>After</span>
            </div>


            <div class="brand-eyebrow">
                Wedding & Event Management
            </div>


            <h2 class="brand-title">
                Your perfect celebration starts here.
            </h2>


            <p class="brand-text">
                Discover trusted vendors, organize your event,
                manage bookings and bring every detail of your
                celebration together in one place.
            </p>

        </div>


        <div class="brand-features">

            <div class="feature">

                <div class="feature-icon">✓</div>

                <span>
                    Discover verified vendors
                </span>

            </div>


            <div class="feature">

                <div class="feature-icon">♡</div>

                <span>
                    Save your favourite vendors
                </span>

            </div>


            <div class="feature">

                <div class="feature-icon">✦</div>

                <span>
                    Plan your celebration effortlessly
                </span>

            </div>

        </div>

    </section>



    <!-- LOGIN PANEL -->

    <section class="auth-form-panel">

        <div class="auth-form-container">


            <div class="welcome">

                <h1>
                    Welcome back
                </h1>

                <p>
                    Sign in to continue planning your
                    perfect celebration.
                </p>

            </div>



            <form id="loginForm">


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
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="show-password"
                            onclick="togglePassword('password', this)"
                        >
                            Show
                        </button>

                    </div>

                </div>



                <button
                    type="submit"
                    class="btn"
                    id="loginButton"
                >
                    Sign In
                </button>


                <div
                    id="message"
                    class="message"
                ></div>


            </form>



            <div class="register-link">

                Don't have an account?

                <a href="register.php">
                    Create one
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


function togglePassword(inputId, button) {

    const input =
        document.getElementById(inputId);

    if (input.type === "password") {

        input.type = "text";

        button.textContent = "Hide";

    } else {

        input.type = "password";

        button.textContent = "Show";

    }

}



document
    .getElementById("loginForm")
    .addEventListener("submit", async function(event) {

        event.preventDefault();


        const message =
            document.getElementById("message");

        const loginButton =
            document.getElementById("loginButton");


        message.textContent =
            "Signing you in...";

        message.style.color =
            "#777078";


        loginButton.disabled = true;

        loginButton.textContent =
            "Signing In...";


        const data = {

            email:
                document
                    .getElementById("email")
                    .value
                    .trim(),

            password:
                document
                    .getElementById("password")
                    .value

        };


        try {

            const response =
                await fetch(
                    "php/api.php?action=login",
                    {
                        method: "POST",

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
                "Login response:",
                result
            );


            if (result.success) {

                message.textContent =
                    "Login successful! Redirecting...";

                message.style.color =
                    "#438a62";


                setTimeout(function() {

                    const user =
                        result.user || {};

                    const role =
                        String(
                            user.role ||
                            result.role ||
                            "customer"
                        ).toLowerCase();


                    const mustChangePassword =
                        Number(
                            user.must_change_password || 0
                        ) === 1;


                    /*
                     * FORCE PASSWORD CHANGE
                     */

                    if (mustChangePassword) {

                        window.location.href =
                            "change-password.php";

                        return;
                    }


                    /*
                     * ROLE-BASED REDIRECT
                     */

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

                }, 500);


            } else {

                message.textContent =
                    result.message ||
                    "Invalid email or password.";

                message.style.color =
                    "#c45151";

                loginButton.disabled = false;

                loginButton.textContent =
                    "Sign In";
            }


        } catch (error) {

            console.error(
                "Login error:",
                error
            );


            message.textContent =
                "Something went wrong. Please try again.";

            message.style.color =
                "#c45151";


            loginButton.disabled = false;

            loginButton.textContent =
                "Sign In";
        }

    });

</script>


</body>

</html>
