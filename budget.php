<?php
require_once "php/auth.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="assets/images/favicon.png">
<title>Budget | EverAfter</title>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="css/dashboard.css">

<style>

.budget-grid {

    display:grid;

    grid-template-columns:
    .8fr 1.2fr;

    gap:20px;

}

.budget-total {

    background:#292023;

    color:white;

    border-radius:20px;

    padding:30px;

}

.budget-total small {

    color:#bfb3b5;

    font-size:9px;

}

.budget-total h2 {

    font-family:
    "Playfair Display",serif;

    font-size:38px;

    margin:8px 0;

}

.remaining {

    color:#e9bfc3;

    font-size:11px;

}

.progress-container {

    height:8px;

    background:#493b3e;

    border-radius:99px;

    margin-top:8px;

    overflow:hidden;

}

.progress-bar {

    height:100%;

    width:0%;

    background:#d99ba1;

    border-radius:99px;

    transition:width .3s ease;

}

.budget-stats {

    display:flex;

    justify-content:space-between;

    margin-top:25px;

    gap:15px;

}

.budget-stat {

    flex:1;

}

.budget-stat small {

    display:block;

    margin-bottom:5px;

}

.budget-stat strong {

    font-size:15px;

}

.expense-row {

    display:flex;

    align-items:center;

    gap:14px;

    padding:15px 0;

    border-bottom:1px solid #eee5e2;

}

.expense-row:last-child {

    border-bottom:none;

}

.expense-row div {

    flex:1;

}

.expense-row strong {

    display:block;

    font-size:11px;

}

.expense-row small {

    color:#777074;

    font-size:8px;

}

.expense-icon {

    width:38px;

    height:38px;

    border-radius:10px;

    background:#f2e5e3;

    color:#9a5b63;

    display:grid;

    place-items:center;

    flex-shrink:0;

}

.expense-amount {

    text-align:right;

    white-space:nowrap;

}

.delete-expense {

    border:0;

    background:none;

    color:#a23b3b;

    cursor:pointer;

    font-size:10px;

    padding:5px;

}

.add-expense {

    background:#9a5b63;

    color:white;

    border:0;

    padding:10px 17px;

    border-radius:99px;

    font-size:10px;

    cursor:pointer;

}

.empty-expenses {

    text-align:center;

    padding:40px 20px;

    color:#777074;

}

.empty-expenses .icon {

    font-size:30px;

    margin-bottom:10px;

}

.loading {

    text-align:center;

    padding:30px;

    color:#777074;

    font-size:11px;

}


/* MODAL */

.expense-overlay {

    position:fixed;

    inset:0;

    background:rgba(0,0,0,.55);

    display:flex;

    align-items:center;

    justify-content:center;

    z-index:9999;

    padding:20px;

}

.expense-modal {

    width:100%;

    max-width:480px;

    background:white;

    border-radius:18px;

    padding:28px;

    box-sizing:border-box;

    position:relative;

    box-shadow:0 20px 60px rgba(0,0,0,.25);

}

.expense-modal h2 {

    margin:0 0 5px;

    font-family:
    "Playfair Display",serif;

    font-size:25px;

}

.expense-subtitle {

    color:#777074;

    font-size:11px;

    margin-bottom:20px;

}

.close-expense {

    position:absolute;

    right:18px;

    top:12px;

    border:0;

    background:none;

    font-size:27px;

    color:#777;

    cursor:pointer;

}

.expense-modal label {

    display:block;

    margin:13px 0 6px;

    font-size:11px;

    font-weight:600;

    color:#4d4546;

}

.expense-modal input,
.expense-modal select,
.expense-modal textarea {

    width:100%;

    box-sizing:border-box;

    padding:11px 12px;

    border:1px solid #ddd;

    border-radius:9px;

    font-family:inherit;

    font-size:12px;

    outline:none;

}

.expense-modal input:focus,
.expense-modal select:focus,
.expense-modal textarea:focus {

    border-color:#9a5b63;

}

.expense-modal textarea {

    resize:vertical;

    min-height:75px;

}

.save-expense-btn {

    width:100%;

    margin-top:20px;

    padding:13px;

    border:0;

    border-radius:10px;

    background:#9a5b63;

    color:white;

    font-weight:600;

    cursor:pointer;

}

.save-expense-btn:disabled {

    opacity:.6;

    cursor:not-allowed;

}

.expense-message {

    text-align:center;

    font-size:11px;

    margin-top:12px;

}


@media(max-width:800px) {

    .budget-grid {

        grid-template-columns:1fr;

    }

}

@media(max-width:600px) {

    .budget-total {

        padding:22px;

    }

    .budget-total h2 {

        font-size:30px;

    }

    .budget-stats {

        flex-direction:column;

    }

    .expense-row {

        gap:9px;

    }

    .expense-icon {

        width:34px;

        height:34px;

    }

}

</style>

</head>


<body>

<div class="app">


<?php include "php/sidebar.php"; ?>


<main class="main">


<header class="dashboard-top">

<div>

<span class="eyebrow">
BUDGET MANAGEMENT
</span>

<h1>
Wedding Budget
</h1>

</div>

<button
class="add-expense"
onclick="addExpense()">

+ Add Expense

</button>

</header>


<div class="budget-grid">


<!-- BUDGET SUMMARY -->

<div class="budget-total">

<small>
TOTAL WEDDING BUDGET
</small>

<h2 id="totalBudget">
₹0
</h2>

<div class="remaining"
id="remainingBudget">

₹0 remaining

</div>


<div style="margin-top:30px;">

<small>
BUDGET USED
</small>

<div class="progress-container">

<div
id="budgetProgress"
class="progress-bar">
</div>

</div>

<div
style="
display:flex;
justify-content:space-between;
margin-top:7px;
font-size:9px;
color:#bfb3b5;
">

<span id="spentAmount">
₹0 spent
</span>

<span id="usedPercentage">
0%
</span>

</div>

</div>


<div class="budget-stats">

<div class="budget-stat">

<small>
TOTAL SPENT
</small>

<strong id="totalSpent">
₹0
</strong>

</div>


<div class="budget-stat">

<small>
REMAINING
</small>

<strong id="remainingSmall">
₹0
</strong>

</div>

</div>

</div>


<!-- EXPENSES -->

<div class="panel">

<div class="panel-header">

<div>

<span class="eyebrow">
EXPENSES
</span>

<h3>
Recent Expenses
</h3>

</div>

</div>


<div id="expenseList">

<div class="loading">
Loading expenses...
</div>

</div>

</div>


</div>


</main>

</div>


<script>


let eventBudget = 0;
let allExpenses = [];


/* =========================
   LOAD BUDGET
========================= */
async function loadBudget() {

    try {

        const response = await fetch(
            "php/api.php?action=my_event",
            {
                credentials: "same-origin"
            }
        );

        const result = await response.json();

        console.log("EVENT DATA:", result);

        if (result.success && result.event) {

            eventBudget = parseFloat(
                result.event.budget || 0
            );

        } else {

            eventBudget = 0;

        }

        // Show event budget immediately
        updateBudgetSummary();

        // Then load expenses
        await loadExpenses();

    } catch (error) {

        console.error(
            "Budget loading failed:",
            error
        );

        eventBudget = 0;

        updateBudgetSummary();

        await loadExpenses();

    }

}

/* =========================
   LOAD EXPENSES
========================= */

async function loadExpenses() {

    const container =
        document.getElementById(
            "expenseList"
        );

    try {

        const response = await fetch(
            "php/api.php?action=my_expenses",
            {
                credentials:"same-origin"
            }
        );

        const result =
            await response.json();

        if (!result.success) {

            container.innerHTML = `
                <div class="empty-expenses">
                    Unable to load expenses.
                </div>
            `;

            return;

        }

        allExpenses =
            result.data || [];

        updateBudgetSummary();

        renderExpenses();

    } catch(error) {

        console.error(
            "Expense loading failed:",
            error
        );

        container.innerHTML = `
            <div class="empty-expenses">
                Unable to load expenses.
            </div>
        `;

    }

}


/* =========================
   UPDATE SUMMARY
========================= */

function updateBudgetSummary() {

    let totalSpent = 0;

    allExpenses.forEach(
        function(expense) {

            totalSpent +=
                parseFloat(
                    expense.amount || 0
                );

        }
    );


    const remaining =
        eventBudget - totalSpent;


    let percentage = 0;

    if (eventBudget > 0) {

        percentage =
            (totalSpent / eventBudget) * 100;

    }


    document.getElementById(
        "totalBudget"
    ).textContent =
        formatCurrency(eventBudget);


    document.getElementById(
        "totalSpent"
    ).textContent =
        formatCurrency(totalSpent);


    document.getElementById(
        "spentAmount"
    ).textContent =
        formatCurrency(totalSpent) +
        " spent";


    document.getElementById(
        "remainingBudget"
    ).textContent =
        formatCurrency(remaining) +
        " remaining";


    document.getElementById(
        "remainingSmall"
    ).textContent =
        formatCurrency(remaining);


    document.getElementById(
        "usedPercentage"
    ).textContent =
        Math.round(percentage) + "%";


    document.getElementById(
        "budgetProgress"
    ).style.width =
        Math.min(
            percentage,
            100
        ) + "%";

}


/* =========================
   RENDER EXPENSES
========================= */

function renderExpenses() {

    const container =
        document.getElementById(
            "expenseList"
        );


    if (!allExpenses.length) {

        container.innerHTML = `
            <div class="empty-expenses">

                <div class="icon">
                    ₹
                </div>

                <strong>
                    No expenses yet
                </strong>

                <p>
                    Start adding your wedding expenses.
                </p>

            </div>
        `;

        return;

    }


    container.innerHTML = "";


    allExpenses.forEach(
        function(expense) {

            const row =
                document.createElement(
                    "div"
                );

            row.className =
                "expense-row";


            row.innerHTML = `

                <div class="expense-icon">
                    ${getCategoryIcon(
                        expense.category
                    )}
                </div>

                <div>

                    <strong>
                        ${escapeHtml(
                            expense.category
                        )}
                    </strong>

                    <small>
                        ${escapeHtml(
                            expense.note ||
                            "No note"
                        )}
                        •
                        ${formatDate(
                            expense.spent_on
                        )}
                    </small>

                </div>

                <strong class="expense-amount">

                    ${formatCurrency(
                        expense.amount
                    )}

                </strong>

                <button
                    class="delete-expense"
                    onclick="deleteExpense(
                        ${expense.id}
                    )"
                    title="Delete expense">

                    🗑

                </button>

            `;

            container.appendChild(row);

        }
    );

}


/* =========================
   ADD EXPENSE MODAL
========================= */

function addExpense() {

    const html = `

        <div
            id="expenseModal"
            class="expense-overlay">

            <div class="expense-modal">

                <button
                    class="close-expense"
                    onclick="closeExpenseModal()"
                    type="button">

                    ×

                </button>

                <h2>
                    Add Expense
                </h2>

                <p class="expense-subtitle">
                    Add a new wedding expense
                </p>


                <form
                    id="expenseForm">


                    <label>
                        Category
                    </label>

                    <select
                        id="expenseCategory"
                        required>

                        <option value="">
                            Select category
                        </option>

                        <option value="Venue">
                            Venue
                        </option>

                        <option value="Catering">
                            Catering
                        </option>

                        <option value="Photography">
                            Photography
                        </option>

                        <option value="Decoration">
                            Decoration
                        </option>

                        <option value="Clothing">
                            Clothing
                        </option>

                        <option value="Music">
                            Music & DJ
                        </option>

                        <option value="Transportation">
                            Transportation
                        </option>

                        <option value="Invitation">
                            Invitations
                        </option>

                        <option value="Jewellery">
                            Jewellery
                        </option>

                        <option value="Other">
                            Other
                        </option>

                    </select>


                    <label>
                        Amount
                    </label>

                    <input
                        type="number"
                        id="expenseAmount"
                        placeholder="Enter amount"
                        min="1"
                        step="0.01"
                        required>


                    <label>
                        Note
                    </label>

                    <textarea
                        id="expenseNote"
                        placeholder="Optional note"></textarea>


                    <label>
                        Date
                    </label>

                    <input
                        type="date"
                        id="expenseDate"
                        value="${new Date()
                            .toISOString()
                            .split("T")[0]}"
                        required>


                    <button
                        type="submit"
                        class="save-expense-btn">

                        Add Expense

                    </button>

                    <div
                        id="expenseMessage"
                        class="expense-message">
                    </div>

                </form>

            </div>

        </div>

    `;


    document.body.insertAdjacentHTML(
        "beforeend",
        html
    );


    document
        .getElementById("expenseForm")
        .addEventListener(
            "submit",
            function(event) {

                event.preventDefault();

                submitExpense();

            }
        );

}


/* =========================
   CLOSE MODAL
========================= */

function closeExpenseModal() {

    const modal =
        document.getElementById(
            "expenseModal"
        );

    if (modal) {

        modal.remove();

    }

}


/* =========================
   SUBMIT EXPENSE
========================= */

async function submitExpense() {

    const category =
        document.getElementById(
            "expenseCategory"
        ).value;

    const amount =
        document.getElementById(
            "expenseAmount"
        ).value;

    const note =
        document.getElementById(
            "expenseNote"
        ).value.trim();

    const spentOn =
        document.getElementById(
            "expenseDate"
        ).value;


    const message =
        document.getElementById(
            "expenseMessage"
        );

    const button =
        document.querySelector(
            ".save-expense-btn"
        );


    button.disabled = true;

    button.textContent =
        "Saving...";


    try {

        const response =
            await fetch(
                "php/api.php?action=add_expense",
                {
                    method:"POST",

                    headers:{
                        "Content-Type":
                        "application/json"
                    },

                    credentials:
                        "same-origin",

                    body:JSON.stringify({

                        category:
                            category,

                        amount:
                            amount,

                        note:
                            note,

                        spent_on:
                            spentOn

                    })

                }
            );


        const result =
            await response.json();


        if (result.success) {

            message.style.color =
                "green";

            message.textContent =
                "✓ Expense added successfully.";

            setTimeout(
                function() {

                    closeExpenseModal();

                    loadExpenses();

                },
                700
            );

        } else {

            message.style.color =
                "red";

            message.textContent =
                result.message ||
                "Unable to add expense.";

            button.disabled =
                false;

            button.textContent =
                "Add Expense";

        }

    } catch(error) {

        console.error(
            "Add expense error:",
            error
        );

        message.style.color =
            "red";

        message.textContent =
            "Something went wrong.";

        button.disabled =
            false;

        button.textContent =
            "Add Expense";

    }

}


/* =========================
   DELETE EXPENSE
========================= */

async function deleteExpense(
    expenseId
) {

    if (
        !confirm(
            "Delete this expense?"
        )
    ) {

        return;

    }


    try {

        const response =
            await fetch(
                "php/api.php?action=delete_expense",
                {
                    method:"POST",

                    headers:{
                        "Content-Type":
                        "application/json"
                    },

                    credentials:
                        "same-origin",

                    body:JSON.stringify({

                        expense_id:
                            expenseId

                    })

                }
            );


        const result =
            await response.json();


        if (!result.success) {

            alert(
                result.message ||
                "Unable to delete expense."
            );

            return;

        }


        await loadExpenses();

    } catch(error) {

        console.error(
            "Delete expense error:",
            error
        );

        alert(
            "Something went wrong."
        );

    }

}


/* =========================
   CATEGORY ICON
========================= */

function getCategoryIcon(
    category
) {

    const icons = {

        "Venue":"🏛",

        "Catering":"🍽",

        "Photography":"📷",

        "Decoration":"🌸",

        "Clothing":"👗",

        "Music":"🎵",

        "Transportation":"🚗",

        "Invitation":"💌",

        "Jewellery":"💍",

        "Other":"✨"

    };


    return icons[category] || "₹";

}


/* =========================
   CURRENCY
========================= */

function formatCurrency(
    amount
) {

    return "₹" +
        Number(
            amount || 0
        ).toLocaleString(
            "en-IN",
            {
                maximumFractionDigits:0
            }
        );

}


/* =========================
   DATE
========================= */

function formatDate(
    date
) {

    if (!date) {

        return "";

    }


    const parts =
        date.split("-");


    if (parts.length !== 3) {

        return date;

    }


    return (
        parts[2] +
        "/" +
        parts[1] +
        "/" +
        parts[0]
    );

}


/* =========================
   ESCAPE HTML
========================= */

function escapeHtml(
    value
) {

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


/* =========================
   LOGOUT
========================= */

async function logoutUser() {

    await fetch(
        "php/api.php?action=logout",
        {
            credentials:
                "same-origin"
        }
    );

    location.href =
        "index.html";

}


/* =========================
   START
========================= */

document.addEventListener(
    "DOMContentLoaded",
    function() {

        loadBudget();

    }
);

</script>

</body>

</html>