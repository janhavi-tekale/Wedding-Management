<?php
require_once "php/auth.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard | EverAfter</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.googleapis.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
          rel="stylesheet">

    <link rel="stylesheet"
          href="css/dashboard.css">

</head>


<body>

<div class="app">


    <!-- ======================================== -->
    <!-- SIDEBAR -->
    <!-- ======================================== -->

    <?php include "php/sidebar.php"; ?>



    <!-- ======================================== -->
    <!-- MAIN -->
    <!-- ======================================== -->

    <main class="main">


        <!-- ======================================== -->
        <!-- TOP HEADER -->
        <!-- ======================================== -->

        <header class="dashboard-top">

            <div>

                <span class="eyebrow">

                    WEDDING DASHBOARD

                </span>


                <h1>

                    Welcome back,

                    <span id="userName">
                        ...
                    </span>

                    👋

                </h1>

            </div>


            <div class="top-actions">

                <button
                    onclick="location.href='profile.php'"
                    class="profile-button">


                    <span id="userInitial">

                        A

                    </span>


                    <div>

                        <strong id="topUserName">

                            User

                        </strong>


                        <small>

                            Wedding Planner

                        </small>

                    </div>


                </button>

            </div>

        </header>



        <!-- ======================================== -->
        <!-- WEDDING SUMMARY -->
        <!-- ======================================== -->

        <section class="wedding-summary">


            <div class="summary-content">


                <span class="summary-label">

                    YOUR WEDDING

                </span>


                <h2 id="eventTitle">

                    Your perfect day starts here.

                </h2>


                <p id="eventDetails">

                    Create your event to start planning
                    your perfect day.

                </p>


                <a href="planner.php"
                   class="primary-button">

                    Continue Planning →

                </a>


            </div>



            <div class="countdown">


                <small>

                    DAYS UNTIL YOUR WEDDING

                </small>


                <strong id="daysLeft">

                    --

                </strong>


                <span>

                    Make every day count.

                </span>


            </div>


        </section>



        <!-- ======================================== -->
        <!-- STAT CARDS -->
        <!-- ======================================== -->

        <section class="stats-grid">


            <!-- TOTAL BUDGET -->

            <div class="stat-card">


                <div class="stat-icon">

                    ₹

                </div>


                <div>


                    <small>

                        TOTAL BUDGET

                    </small>


                    <strong id="totalBudget">

                        ₹0

                    </strong>


                    <span class="green">

                        Event budget

                    </span>


                </div>


            </div>



            <!-- GUESTS -->

            <div class="stat-card">


                <div class="stat-icon">

                    ♧

                </div>


                <div>


                    <small>

                        GUESTS

                    </small>


                    <strong id="guestTotal">

                        0

                    </strong>


                    <span>

                        Expected guests

                    </span>


                </div>


            </div>



            <!-- BOOKINGS -->

         <!-- BOOKINGS -->

<div class="stat-card">


    <div class="stat-icon">

        ▣

    </div>


    <div>


        <small>

            BOOKINGS

        </small>


        <strong id="bookingTotal">

            0

        </strong>


        <span
            id="bookingStatus"
            class="green">

            No bookings yet

        </span>


    </div>


</div>


            <!-- TASKS -->

            <div class="stat-card">


                <div class="stat-icon">

                    ✓

                </div>


                <div>


                    <small>

                        TASKS

                    </small>


                    <!-- IMPORTANT -->
                    <!-- JavaScript updates this -->

                    <strong id="taskTotal">

                        0

                    </strong>


                    <!-- IMPORTANT -->
                    <!-- JavaScript updates this -->

                    <span id="taskStatus">

                        No tasks yet

                    </span>


                </div>


            </div>


        </section>



        <!-- ======================================== -->
        <!-- TWO COLUMNS -->
        <!-- ======================================== -->

        <section class="dashboard-columns">



            <!-- ======================================== -->
            <!-- UPCOMING TASKS -->
            <!-- ======================================== -->

            <div class="panel">


                <div class="panel-header">


                    <div>


                        <span class="eyebrow">

                            PLANNING

                        </span>


                        <h3>

                            Upcoming Tasks

                        </h3>


                    </div>


                    <a href="planner.php">

                        View all →

                    </a>


                </div>



                <!-- ======================================== -->
                <!-- REAL TASKS LOAD HERE -->
                <!-- ======================================== -->

                <div id="dashboardTaskList">


                    <p style="
                        font-size:10px;
                        color:#777074;
                        padding:20px 0;
                    ">

                        Loading tasks...

                    </p>


                </div>


            </div>



<!-- ======================================== -->
<!-- BUDGET -->
<!-- ======================================== -->

<div class="panel">

    <div class="panel-header">

        <div>

            <span class="eyebrow">
                BUDGET
            </span>

            <h3>
                Expense Overview
            </h3>

        </div>

        <a href="budget.php">
            Manage →
        </a>

    </div>


    <div class="budget-overview">

        <div class="budget-circle">

            <strong id="budgetPercent">
                0%
            </strong>

        </div>


        <div>

            <small>
                SPENT
            </small>

            <strong class="big-number" id="budgetSpent">
                ₹0
            </strong>

            <span>
                of your event budget
            </span>

        </div>

    </div>


    <div class="mini-expense">

        <span>
            Venue
        </span>

        <strong id="budgetVenue">
            ₹0
        </strong>

    </div>


    <div class="mini-expense">

        <span>
            Catering
        </span>

        <strong id="budgetCatering">
            ₹0
        </strong>

    </div>


    <div class="mini-expense">

        <span>
            Photography
        </span>

        <strong id="budgetPhotography">
            ₹0
        </strong>

    </div>

</div>

        </section>



        <!-- ======================================== -->
        <!-- QUICK ACTIONS -->
        <!-- ======================================== -->

        <section>


            <div class="panel-header standalone">


                <div>


                    <span class="eyebrow">

                        QUICK ACTIONS

                    </span>


                    <h3>

                        What would you like to do?

                    </h3>


                </div>


            </div>



            <div class="quick-actions">


                <a href="vendors.php">


                    <span>

                        ♢

                    </span>


                    <strong>

                        Find Vendor

                    </strong>


                    <small>

                        Discover wedding services

                    </small>


                </a>



                <a href="guests.php">


                    <span>

                        ♧

                    </span>


                    <strong>

                        Add Guest

                    </strong>


                    <small>

                        Manage your guest list

                    </small>


                </a>



                <a href="budget.php">


                    <span>

                        ₹

                    </span>


                    <strong>

                        Add Expense

                    </strong>


                    <small>

                        Track wedding spending

                    </small>


                </a>



                <a href="planner.php">


                    <span>

                        ✓

                    </span>


                    <strong>

                        Add Task

                    </strong>


                    <small>

                        Keep your planning on track

                    </small>


                </a>


            </div>


        </section>


    </main>


</div>



<!-- ======================================== -->
<!-- DASHBOARD JAVASCRIPT -->
<!-- ======================================== -->

<script src="js/dashboard.js?v=3"></script>


</body>

</html>