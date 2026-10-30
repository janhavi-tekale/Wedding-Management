<?php
require_once "php/auth.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Wedding Planner | EverAfter</title>
<link rel="icon" type="image/png" href="assets/images/favicon.png">

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
      rel="stylesheet">


<link rel="stylesheet"
      href="css/dashboard.css">


<style>

/* ========================================
   PLANNER GRID
======================================== */

.planner-grid {

    display:grid;

    grid-template-columns:
        1.5fr .7fr;

    gap:20px;

}


/* ========================================
   TASK ITEM
======================================== */

.task-item {

    display:flex;

    align-items:center;

    gap:15px;

    padding:17px 0;

    border-bottom:1px solid #eee5e2;

}


/* ========================================
   TASK CHECKBOX
======================================== */

.task-box {

    width:25px;

    height:25px;

    min-width:25px;

    border:2px solid #d9c6c7;

    border-radius:7px;

    display:grid;

    place-items:center;

    cursor:pointer;

    color:white;

    font-size:13px;

    transition:.2s ease;

}


.task-box:hover {

    border-color:#9a5b63;

}


.task-box.completed {

    background:#9a5b63;

    border-color:#9a5b63;

}


/* ========================================
   TASK CONTENT
======================================== */

.task-item-content {

    flex:1;

    min-width:0;

}


.task-item strong {

    font-size:12px;

    display:block;

}


.task-item small {

    font-size:9px;

    color:#777074;

    display:block;

    margin-top:4px;

}


/* ========================================
   PRIORITY
======================================== */

.priority {

    font-size:8px;

    padding:4px 8px;

    border-radius:99px;

    background:#fff0d5;

    color:#9c6d24;

    white-space:nowrap;

}


.priority.high {

    background:#ffe1e1;

    color:#a23b3b;

}


.priority.low {

    background:#e8f3e8;

    color:#4d7c4d;

}


/* ========================================
   EMPTY TASKS
======================================== */

.empty-tasks {

    font-size:10px;

    color:#777074;

    padding:25px 0;

    text-align:center;

}


/* ========================================
   PROGRESS
======================================== */

.progress-box {

    text-align:center;

    padding:20px;

}


.progress-number {

    font-family:"Playfair Display",serif;

    font-size:55px;

    color:#9a5b63;

}


.progress-line {

    height:8px;

    background:#eee5e2;

    border-radius:99px;

    overflow:hidden;

}


.progress-line span {

    display:block;

    width:0%;

    height:100%;

    background:#9a5b63;

    border-radius:99px;

    transition:width .3s ease;

}


/* ========================================
   ADD TASK
======================================== */

.add-task-box {

    margin-top:25px;

    padding-top:20px;

    border-top:1px solid #eee5e2;

}


.add-task-form {

    display:flex;

    flex-direction:column;

    gap:10px;

    margin-top:15px;

}


.add-task-form input,

.add-task-form select {

    width:100%;

    padding:10px 12px;

    border:1px solid #e3d8d6;

    border-radius:8px;

    font-family:"DM Sans",sans-serif;

    font-size:11px;

    box-sizing:border-box;

    outline:none;

}


.add-task-form input:focus,

.add-task-form select:focus {

    border-color:#9a5b63;

}


.add-task-form button {

    border:none;

    cursor:pointer;

}


/* ========================================
   FORM MESSAGE
======================================== */

.form-message {

    font-size:10px;

    margin-top:8px;

}


.success-message {

    color:#4d7c4d;

}


.error-message {

    color:#a23b3b;

}


/* ========================================
   UPCOMING TASK
======================================== */

.upcoming-item {

    font-size:10px;

    margin-top:15px;

    padding-bottom:12px;

    border-bottom:1px solid #eee5e2;

}


.upcoming-item:last-child {

    border-bottom:none;

}


/* ========================================
   MOBILE
======================================== */

@media(max-width:800px) {

    .planner-grid {

        grid-template-columns:1fr;

    }

}

</style>

</head>


<body>


<div class="app">


<!-- ========================================
     SIDEBAR
======================================== -->

<?php include "php/sidebar.php"; ?>





<!-- ========================================
     MAIN
======================================== -->

<main class="main">


<header class="dashboard-top">


<div>


<span class="eyebrow">

    WEDDING PLANNER

</span>


<h1>

    Planning Checklist

</h1>


</div>


<a href="dashboard.php"
   class="primary-button">

    ← Dashboard

</a>


</header>



<div class="planner-grid">


<!-- ========================================
     LEFT PANEL
======================================== -->

<div class="panel">


<div class="panel-header">


<div>


<span class="eyebrow">

    YOUR TASKS

</span>


<h3>

    Wedding Checklist

</h3>


</div>


</div>



<!-- ========================================
     TASK LIST
======================================== -->

<div id="taskList">

<p class="empty-tasks">

    Loading tasks...

</p>

</div>



<!-- ========================================
     ADD TASK
======================================== -->

<div class="add-task-box">


<span class="eyebrow">

    ADD TASK

</span>


<h3 style="
font-family:'Playfair Display',serif;
margin-top:6px;
">

    Create a new task

</h3>



<form
    id="addTaskForm"
    class="add-task-form">


<input
    type="text"
    id="taskTitle"
    placeholder="Task title"
    required>


<input
    type="date"
    id="taskDueDate">


<select id="taskPriority">

<option value="HIGH">

    High Priority

</option>


<option value="MEDIUM"
        selected>

    Medium Priority

</option>


<option value="LOW">

    Low Priority

</option>

</select>


<button
    type="submit"
    class="primary-button">

    + Add Task

</button>


<div
    id="formMessage"
    class="form-message">

</div>


</form>


</div>


</div>



<!-- ========================================
     RIGHT PANEL
======================================== -->

<div class="panel">


<!-- ========================================
     PROGRESS
======================================== -->

<div class="progress-box">


<span class="eyebrow">

    OVERALL PROGRESS

</span>


<div
    class="progress-number"
    id="progressNumber">

    0%

</div>


<p
    id="progressText"
    style="
    font-size:10px;
    color:#777074;
    margin-bottom:20px;
    ">

    0 of 0 tasks completed

</p>


<div class="progress-line">

<span id="progressLine"></span>

</div>


</div>



<!-- ========================================
     UPCOMING
======================================== -->

<div style="
margin-top:25px;
padding-top:20px;
border-top:1px solid #eee5e2;
">


<span class="eyebrow">

    UPCOMING

</span>


<h3 style="
font-family:'Playfair Display',serif;
">

    Important Dates

</h3>


<div id="upcomingTasks">

<p style="
font-size:10px;
color:#777074;
margin-top:15px;
">

    No upcoming tasks.

</p>

</div>


</div>


</div>


</div>


</main>


</div>



<script>


// ========================================
// LOAD TASKS
// ========================================

async function loadTasks() {

    try {

        const response =
            await fetch(
                "php/api.php?action=my_tasks",
                {
                    credentials:
                        "same-origin"
                }
            );


        const result =
            await response.json();


        console.log(
            "TASK API:",
            result
        );


        if (!result.success) {

            document.getElementById(
                "taskList"
            ).innerHTML = `

                <p class="empty-tasks">

                    Unable to load tasks.

                </p>

            `;

            return;

        }


        const tasks =
         result.data || [];


        renderTasks(tasks);

    }

    catch (error) {

        console.error(
            "Task loading failed:",
            error
        );


        document.getElementById(
            "taskList"
        ).innerHTML = `

            <p class="empty-tasks">

                Unable to load tasks.

            </p>

        `;

    }

}



// ========================================
// RENDER TASKS
// ========================================

function renderTasks(tasks) {


    const taskList =
        document.getElementById(
            "taskList"
        );


    const upcomingTasks =
        document.getElementById(
            "upcomingTasks"
        );


    // ========================================
    // NO TASKS
    // ========================================

    if (!tasks.length) {


        taskList.innerHTML = `

            <p class="empty-tasks">

                No tasks yet.
                Add your first planning task below.

            </p>

        `;


        upcomingTasks.innerHTML = `

            <p style="
                font-size:10px;
                color:#777074;
                margin-top:15px;
            ">

                No upcoming tasks.

            </p>

        `;


        updateProgress(tasks);


        return;

    }



    // ========================================
    // TASK LIST
    // ========================================

    taskList.innerHTML = "";


    tasks.forEach(
        function(task) {


            const item =
                document.createElement(
                    "div"
                );


            item.className =
                "task-item";


const completed =
    String(task.status).toLowerCase() ===
    "completed";



            // ========================================
            // CHECKBOX
            // ========================================

            const box =
                document.createElement(
                    "div"
                );


            box.className =
                completed
                    ? "task-box completed"
                    : "task-box";


            box.textContent =
                completed
                    ? "✓"
                    : "";


            box.title =
                completed
                    ? "Mark as pending"
                    : "Mark as completed";


            box.onclick =
                function() {

                    toggleTask(
                        task.id
                    );

                };



            // ========================================
            // CONTENT
            // ========================================

            const content =
                document.createElement(
                    "div"
                );


            content.className =
                "task-item-content";


            const title =
                document.createElement(
                    "strong"
                );


            title.textContent =
                task.task_title;


            const details =
                document.createElement(
                    "small"
                );


            if (task.due_date) {

                details.textContent =
                    completed
                        ? "Completed • " +
                          formatDate(
                              task.due_date
                          )
                        : "Due • " +
                          formatDate(
                              task.due_date
                          );

            } else {

                details.textContent =
                    completed
                        ? "Completed"
                        : "No due date";

            }


            content.appendChild(
                title
            );


            content.appendChild(
                details
            );



            // ========================================
            // ADD TO ITEM
            // ========================================

            item.appendChild(
                box
            );


            item.appendChild(
                content
            );



            // ========================================
            // PRIORITY
            // ========================================

            if (task.priority) {


                const priority =
                    document.createElement(
                        "span"
                    );


                priority.className =
                    "priority " +
                    String(
                        task.priority
                    ).toLowerCase();


                priority.textContent =
                    task.priority;


                item.appendChild(
                    priority
                );

            }


            taskList.appendChild(
                item
            );

        }
    );



    // ========================================
    // UPCOMING TASKS
    // ========================================

    const upcoming =
        tasks
            .filter(
                function(task) {

return (
    String(task.status).toLowerCase() !==
        "completed"
    &&
    task.due_date
);

                }
            )
            .sort(
                function(a, b) {

                    return (
                        new Date(
                            a.due_date
                        )
                        -
                        new Date(
                            b.due_date
                        )
                    );

                }
            )
            .slice(0, 3);



    if (!upcoming.length) {


        upcomingTasks.innerHTML = `

            <p style="
                font-size:10px;
                color:#777074;
                margin-top:15px;
            ">

                No upcoming tasks.

            </p>

        `;

    }

    else {


        upcomingTasks.innerHTML =
            "";


        upcoming.forEach(
            function(task) {


                const item =
                    document.createElement(
                        "div"
                    );


                item.className =
                    "upcoming-item";


                const date =
                    document.createElement(
                        "strong"
                    );


                date.textContent =
                    "📅 " +
                    formatDate(
                        task.due_date
                    );


                const title =
                    document.createElement(
                        "div"
                    );


                title.style.marginTop =
                    "4px";


                title.textContent =
                    task.task_title;


                item.appendChild(
                    date
                );


                item.appendChild(
                    title
                );


                upcomingTasks.appendChild(
                    item
                );

            }
        );

    }


    updateProgress(tasks);

}



// ========================================
// UPDATE PROGRESS
// ========================================

// ========================================
// UPDATE PROGRESS
// ========================================

function updateProgress(tasks) {

    const total =
        tasks.length;

    const completed =
        tasks.filter(
            function(task) {

                return (
                    String(task.status).toLowerCase() ===
                    "completed"
                );

            }
        ).length;

    const percentage =
        total === 0
            ? 0
            : Math.round(
                (
                    completed /
                    total
                ) * 100
            );

    document.getElementById(
        "progressNumber"
    ).textContent =
        percentage + "%";

    document.getElementById(
        "progressText"
    ).textContent =
        `${completed} of ${total} tasks completed`;

    document.getElementById(
        "progressLine"
    ).style.width =
        percentage + "%";

}



// ========================================
// COMPLETE / UNCOMPLETE TASK
// ========================================

async function toggleTask(taskId) {


    try {


        const response =
            await fetch(
                "php/api.php?action=complete_task",
                {

                    method:"POST",

                    credentials:
                        "same-origin",

                    headers: {

                        "Content-Type":
                            "application/json"

                    },

                    body:
                        JSON.stringify({

                            task_id:
                                taskId

                        })

                }
            );


        const result =
            await response.json();


        console.log(
            "COMPLETE TASK:",
            result
        );


        if (result.success) {

            loadTasks();

        }

        else {

            alert(
                result.message ||
                "Unable to update task."
            );

        }

    }

    catch (error) {


        console.error(
            "Task update failed:",
            error
        );


        alert(
            "Unable to update task."
        );

    }

}



// ========================================
// ADD TASK
// ========================================

document.getElementById(
    "addTaskForm"
).addEventListener(
    "submit",
    async function(event) {


        event.preventDefault();


        const title =
            document.getElementById(
                "taskTitle"
            )
            .value
            .trim();


        const dueDate =
            document.getElementById(
                "taskDueDate"
            )
            .value;


        const priority =
            document.getElementById(
                "taskPriority"
            )
            .value;


        const message =
            document.getElementById(
                "formMessage"
            );


        if (!title) {


            message.className =
                "form-message error-message";


            message.textContent =
                "Please enter a task title.";


            return;

        }


        try {


            const response =
                await fetch(
                    "php/api.php?action=add_task",
                    {

                        method:"POST",

                        credentials:
                            "same-origin",

                        headers: {

                            "Content-Type":
                                "application/json"

                        },

                        body:
                            JSON.stringify({

                                task_title:
                                    title,

                                due_date:
                                    dueDate ||
                                    null,

                                priority:
                                    priority

                            })

                    }
                );


            const result =
                await response.json();


            console.log(
                "ADD TASK:",
                result
            );


            if (result.success) {


                message.className =
                    "form-message success-message";


                message.textContent =
                    "Task added successfully.";


                document.getElementById(
                    "addTaskForm"
                ).reset();


                loadTasks();


                setTimeout(
                    function() {

                        message.textContent =
                            "";

                    },
                    2500
                );


            }

            else {


                message.className =
                    "form-message error-message";


                message.textContent =
                    result.message ||
                    "Unable to add task.";

            }

        }

        catch (error) {


            console.error(
                "Add task failed:",
                error
            );


            message.className =
                "form-message error-message";


            message.textContent =
                "Unable to add task.";

        }

    }
);



// ========================================
// FORMAT DATE
// ========================================

function formatDate(dateString) {


    if (!dateString) {

        return "";

    }


    const parts =
        dateString.split("-");


    if (parts.length !== 3) {

        return dateString;

    }


    const date =
        new Date(

            Number(parts[0]),

            Number(parts[1]) - 1,

            Number(parts[2])

        );


    return date.toLocaleDateString(

        "en-IN",

        {

            day:"2-digit",

            month:"short"

        }

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


        window.location.href =
            "index.html";


    }

    catch (error) {


        console.error(

            "Logout failed:",

            error

        );

    }

}



// ========================================
// INITIAL LOAD
// ========================================

document.addEventListener(
    "DOMContentLoaded",
    function() {

        loadTasks();

    }
);

</script>


</body>

</html>