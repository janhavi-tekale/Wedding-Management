<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (($_SESSION["user_role"] ?? "customer") !== "vendor") {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Vendor Profile - EverAfter</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link rel="stylesheet" href="css/vendor.css">
</head>

<body>

<div class="vendor-layout">

    <?php include "php/vendor-sidebar.php"; ?>


    <main class="vendor-main">

        <div class="vendor-content">

            <!-- PAGE HEADER -->

            <div class="vendor-page-header">

                <div>

                    <div class="vendor-eyebrow">
                        VENDOR PANEL
                    </div>

                    <h1>
                        Business Profile
                    </h1>

                    <p>
                        Manage your business information and marketplace profile.
                    </p>

                </div>

            </div>


            <!-- PROFILE CARD -->

            <div class="vendor-card">

                <div class="vendor-card-header">

                    <div>
                        <h2>
                            Business Information
                        </h2>

                        <p>
                            Keep your vendor details up to date.
                        </p>
                    </div>

                </div>


                <!-- APPROVAL STATUS -->

                <div
                    id="statusBox"
                    class="vendor-message"
                >
                    Loading approval status...
                </div>


                <!-- PROFILE FORM -->

                <form id="profileForm">

                    <div class="vendor-form-grid">


                        <!-- BUSINESS NAME -->

                        <div class="vendor-form-group">

                            <label for="businessName">
                                Business Name *
                            </label>

                            <input
                                type="text"
                                id="businessName"
                                placeholder="Enter your business name"
                                required
                            >

                        </div>


                        <!-- CATEGORY -->

                        <div class="vendor-form-group">

                            <label for="category">
                                Category *
                            </label>

                            <select
                                id="category"
                                required
                            >

                                <option value="">
                                    Select Category
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

                                <option value="Makeup">
                                    Makeup
                                </option>

                                <option value="Mehendi">
                                    Mehendi
                                </option>

                                <option value="Music">
                                    Music / DJ
                                </option>

                                <option value="Wedding Planner">
                                    Wedding Planner
                                </option>

                                <option value="Other">
                                    Other
                                </option>

                            </select>

                        </div>


                        <!-- DESCRIPTION -->

                        <div class="vendor-form-group vendor-form-group-full">

                            <label for="description">
                                Business Description
                            </label>

                            <textarea
                                id="description"
                                placeholder="Describe your business and services..."
                            ></textarea>

                        </div>


                        <!-- PHONE -->

                        <div class="vendor-form-group">

                            <label for="phone">
                                Phone
                            </label>

                            <input
                                type="text"
                                id="phone"
                                placeholder="Enter phone number"
                            >

                        </div>


                        <!-- EMAIL -->

                        <div class="vendor-form-group">

                            <label for="email">
                                Business Email
                            </label>

                            <input
                                type="email"
                                id="email"
                                placeholder="Enter business email"
                            >

                        </div>


                        <!-- CITY -->

                        <div class="vendor-form-group">

                            <label for="city">
                                City
                            </label>

                            <input
                                type="text"
                                id="city"
                                placeholder="Enter city"
                            >

                        </div>


                        <!-- STARTING PRICE -->

                        <div class="vendor-form-group">

                            <label for="priceFrom">
                                Starting Price (₹)
                            </label>

                            <input
                                type="number"
                                id="priceFrom"
                                min="0"
                                step="100"
                                placeholder="e.g. 30000"
                            >

                        </div>


                        <!-- EXPERIENCE -->

                        <div class="vendor-form-group">

                            <label for="experienceYears">
                                Experience (Years)
                            </label>

                            <input
                                type="number"
                                id="experienceYears"
                                min="0"
                                max="100"
                                placeholder="e.g. 5"
                            >

                        </div>


                        <!-- ADDRESS -->

                        <div class="vendor-form-group vendor-form-group-full">

                            <label for="address">
                                Address
                            </label>

                            <input
                                type="text"
                                id="address"
                                placeholder="Enter business address"
                            >

                        </div>

                    </div>


                    <!-- ACTIONS -->

                    <div class="vendor-form-actions">

                        <button
                            type="submit"
                            class="vendor-primary-btn"
                        >
                            Save Changes
                        </button>

                        <a
                            href="vendor-dashboard.php"
                            class="vendor-secondary-btn"
                        >
                            Back to Dashboard
                        </a>

                    </div>


                    <!-- MESSAGE -->

                    <div
                        id="message"
                        class="vendor-message"
                        style="display:none;"
                    ></div>

                </form>

            </div>


            <!-- ========================================
     PORTFOLIO / GALLERY
======================================== -->

<div class="vendor-card portfolio-card">

    <div class="vendor-card-header">

        <div>

            <h2>
                Portfolio & Gallery
            </h2>

            <p>
                Showcase your previous work to customers.
            </p>

        </div>

    </div>


    <div class="portfolio-upload-area">

        <label
            for="vendorImages"
            class="portfolio-upload-box">

            <div class="portfolio-upload-icon">
                +
            </div>

            <strong>
                Add Photos
            </strong>

            <span>
                Upload multiple images of your work
            </span>

            <small>
                JPG, JPEG, PNG or WEBP • Maximum 5 MB each
            </small>

        </label>


        <input
            type="file"
            id="vendorImages"
            accept="image/jpeg,image/png,image/webp"
            multiple
            style="display:none;"
        >

    </div>


    <!-- SELECTED FILE PREVIEW -->

    <div
        id="selectedImagePreview"
        class="portfolio-grid"
        style="display:none;"
    ></div>


    <!-- UPLOAD BUTTON -->

    <div
        id="uploadActions"
        class="vendor-form-actions"
        style="display:none;"
    >

        <button
            type="button"
            id="uploadImagesBtn"
            class="vendor-primary-btn">

            Upload Photos

        </button>

    </div>


    <div
        id="portfolioMessage"
        class="vendor-message"
        style="display:none;"
    ></div>


    <!-- EXISTING IMAGES -->

    <div class="portfolio-existing">

        <div class="portfolio-section-title">

            Your Photos

        </div>


        <div
            id="existingImages"
            class="portfolio-grid"
        >

            <div class="portfolio-empty">
                Loading photos...
            </div>

        </div>

    </div>

</div>

        </div>

    </main>

</div>


<script>

async function loadVendorProfile() {

    try {

        const response = await fetch(
            "php/api.php?action=vendor_profile&_=" + Date.now(),
            {
                credentials: "same-origin",
                cache: "no-store"
            }
        );

        const result = await response.json();

        console.log("Vendor Profile:", result);


        if (!result.success) {

            showMessage(
                result.message || "Unable to load profile.",
                "error"
            );

            return;
        }


        const vendor = result.data;


        document.getElementById("businessName").value =
            vendor.business_name || "";


        document.getElementById("category").value =
            vendor.category || "";


        document.getElementById("description").value =
            vendor.description || "";


        document.getElementById("phone").value =
            vendor.phone || "";


        document.getElementById("email").value =
            vendor.email || "";


        document.getElementById("city").value =
            vendor.city || "";


        document.getElementById("address").value =
            vendor.address || "";


        document.getElementById("priceFrom").value =
            vendor.price_from || 0;


        document.getElementById("experienceYears").value =
            vendor.experience_years || 0;


        updateStatus(vendor.status);


    } catch (error) {

        console.error(error);

        showMessage(
            "Unable to load vendor profile.",
            "error"
        );

    }

}


/* ---------------------------------
   APPROVAL STATUS
--------------------------------- */

function updateStatus(status) {

    const statusBox =
        document.getElementById("statusBox");

    const currentStatus =
        String(status || "pending").toLowerCase();


    statusBox.style.display = "block";


    if (currentStatus === "approved") {

        statusBox.className =
            "vendor-message success";

        statusBox.textContent =
            "✓ Your vendor profile is approved and visible in the marketplace.";

    }

    else if (currentStatus === "rejected") {

        statusBox.className =
            "vendor-message error";

        statusBox.textContent =
            "Your vendor profile has been rejected. Please review your information.";

    }

    else {

        statusBox.className =
            "vendor-message";

        statusBox.textContent =
            "Your vendor profile is pending admin approval.";

    }

}


/* ---------------------------------
   SAVE PROFILE
--------------------------------- */

document
    .getElementById("profileForm")
    .addEventListener("submit", async function(event) {

        event.preventDefault();


        const saveButton =
            this.querySelector('button[type="submit"]');


        saveButton.disabled = true;

        saveButton.textContent =
            "Saving...";


        const data = {

            business_name:
                document
                    .getElementById("businessName")
                    .value
                    .trim(),

            category:
                document
                    .getElementById("category")
                    .value
                    .trim(),

            description:
                document
                    .getElementById("description")
                    .value
                    .trim(),

            phone:
                document
                    .getElementById("phone")
                    .value
                    .trim(),

            email:
                document
                    .getElementById("email")
                    .value
                    .trim(),

            city:
                document
                    .getElementById("city")
                    .value
                    .trim(),

            address:
                document
                    .getElementById("address")
                    .value
                    .trim(),

            price_from:
                Number(
                    document
                        .getElementById("priceFrom")
                        .value || 0
                ),

            experience_years:
                Number(
                    document
                        .getElementById("experienceYears")
                        .value || 0
                )

        };


        try {

            const response = await fetch(
                "php/api.php?action=update_vendor_profile",
                {
                    method: "POST",

                    headers: {
                        "Content-Type": "application/json"
                    },

                    credentials: "same-origin",

                    body: JSON.stringify(data)
                }
            );


            const result =
                await response.json();


            console.log(
                "Update Profile:",
                result
            );


            if (result.success) {

                showMessage(
                    "✓ Profile updated successfully.",
                    "success"
                );


                await loadVendorProfile();

            }

            else {

                showMessage(
                    result.message ||
                    "Profile update failed.",
                    "error"
                );

            }


        } catch (error) {

            console.error(error);

            showMessage(
                "Something went wrong while updating the profile.",
                "error"
            );

        }


        saveButton.disabled = false;

        saveButton.textContent =
            "Save Changes";

    });


/* ---------------------------------
   MESSAGE
--------------------------------- */

function showMessage(text, type) {

    const message =
        document.getElementById("message");


    message.textContent =
        text;


    message.className =
        "vendor-message " + type;


    message.style.display =
        "block";


    setTimeout(function() {

        message.style.display =
            "none";

    }, 4000);

}


/* ---------------------------------
   LOGOUT
--------------------------------- */

async function logoutVendor() {

    try {

        await fetch(
            "php/api.php?action=logout",
            {
                credentials: "same-origin"
            }
        );

    }

    finally {

        window.location.href =
            "login.php";

    }

}



/* =========================================================
   VENDOR PORTFOLIO / GALLERY
   ========================================================= */

let selectedImages = [];


/* -----------------------------------------
   SHOW MESSAGE
----------------------------------------- */

function showPortfolioMessage(message, type = "success") {

    const box = document.getElementById("portfolioMessage");

    if (!box) return;

    box.textContent = message;
    box.className = "vendor-message " + type;
    box.style.display = "block";

    setTimeout(() => {
        box.style.display = "none";
    }, 4000);
}


/* -----------------------------------------
   FILE SELECTION
----------------------------------------- */

const vendorImagesInput =
    document.getElementById("vendorImages");


if (vendorImagesInput) {

    vendorImagesInput.addEventListener(
        "change",
        function () {

            selectedImages =
                Array.from(this.files || []);

            renderSelectedImages();
        }
    );
}


/* -----------------------------------------
   PREVIEW SELECTED IMAGES
----------------------------------------- */

function renderSelectedImages() {

    const preview =
        document.getElementById("selectedImagePreview");

    const uploadActions =
        document.getElementById("uploadActions");


    if (!preview || !uploadActions) return;


    preview.innerHTML = "";


    if (selectedImages.length === 0) {

        preview.style.display = "none";
        uploadActions.style.display = "none";

        return;
    }


    preview.style.display = "grid";
    uploadActions.style.display = "flex";


    selectedImages.forEach((file, index) => {

        const reader =
            new FileReader();


        reader.onload = function (event) {

            const item =
                document.createElement("div");

            item.className =
                "portfolio-item";


            item.innerHTML = `
                <img
                    src="${event.target.result}"
                    alt="Selected portfolio image"
                >

                <button
                    type="button"
                    class="portfolio-delete-btn"
                    title="Remove"
                    onclick="removeSelectedImage(${index})"
                >
                    ×
                </button>

                <div class="portfolio-number">
                    ${index + 1}
                </div>
            `;


            preview.appendChild(item);
        };


        reader.readAsDataURL(file);
    });
}


/* -----------------------------------------
   REMOVE SELECTED IMAGE BEFORE UPLOAD
----------------------------------------- */

function removeSelectedImage(index) {

    selectedImages.splice(index, 1);

    renderSelectedImages();


    /*
     * Rebuild the FileList so the input matches
     * the selectedImages array.
     */

    const dataTransfer =
        new DataTransfer();


    selectedImages.forEach(file => {
        dataTransfer.items.add(file);
    });


    if (vendorImagesInput) {
        vendorImagesInput.files =
            dataTransfer.files;
    }
}


/* -----------------------------------------
   UPLOAD IMAGES
----------------------------------------- */

const uploadImagesBtn =
    document.getElementById("uploadImagesBtn");


if (uploadImagesBtn) {

    uploadImagesBtn.addEventListener(
        "click",
        async function () {

            if (selectedImages.length === 0) {

                showPortfolioMessage(
                    "Please select at least one image.",
                    "error"
                );

                return;
            }


            /* ---------------------------------
               FRONTEND FILE VALIDATION
            --------------------------------- */

            const allowedTypes = [
                "image/jpeg",
                "image/png",
                "image/webp"
            ];


            for (const file of selectedImages) {

                if (!allowedTypes.includes(file.type)) {

                    showPortfolioMessage(
                        `${file.name} is not a supported image format.`,
                        "error"
                    );

                    return;
                }


                if (file.size > 5 * 1024 * 1024) {

                    showPortfolioMessage(
                        `${file.name} is larger than 5 MB.`,
                        "error"
                    );

                    return;
                }
            }


            /* ---------------------------------
               FORM DATA
            --------------------------------- */

            const formData =
                new FormData();


            selectedImages.forEach(file => {

                formData.append(
                    "images[]",
                    file
                );

            });


            /* ---------------------------------
               BUTTON STATE
            --------------------------------- */

            uploadImagesBtn.disabled = true;
            uploadImagesBtn.textContent =
                "Uploading...";


            try {

                const response =
                    await fetch(
                        "php/api.php?action=upload_vendor_images",
                        {
                            method: "POST",
                            body: formData
                        }
                    );


                const result =
                    await response.json();


                if (!result.success) {

                    throw new Error(
                        result.message ||
                        "Unable to upload images."
                    );
                }


                showPortfolioMessage(
                    result.message ||
                    "Images uploaded successfully.",
                    "success"
                );


                /* ---------------------------------
                   CLEAR SELECTION
                --------------------------------- */

                selectedImages = [];


                if (vendorImagesInput) {
                    vendorImagesInput.value = "";
                }


                renderSelectedImages();


                /* ---------------------------------
                   RELOAD EXISTING IMAGES
                --------------------------------- */

                await loadVendorImages();


            } catch (error) {

                console.error(error);


                showPortfolioMessage(
                    error.message ||
                    "Something went wrong while uploading.",
                    "error"
                );

            } finally {

                uploadImagesBtn.disabled = false;

                uploadImagesBtn.textContent =
                    "Upload Photos";
            }
        }
    );
}



function escapeHtml(value) {
    const div = document.createElement("div");
    div.textContent = value ?? "";
    return div.innerHTML;
}


/* -----------------------------------------
   LOAD EXISTING IMAGES
----------------------------------------- */

async function loadVendorImages() {

    const container =
        document.getElementById("existingImages");


    if (!container) return;


    container.innerHTML =
        `<div class="portfolio-empty">
            Loading photos...
        </div>`;


    try {

        const response =
            await fetch(
                "php/api.php?action=vendor_images&_=" +
                Date.now()
            );


        const result =
            await response.json();


        if (!result.success) {

            throw new Error(
                result.message ||
                "Unable to load images."
            );
        }


        const images =
            result.data || [];


        if (images.length === 0) {

            container.innerHTML =
                `<div class="portfolio-empty">
                    No portfolio photos yet.
                </div>`;

            return;
        }


        container.innerHTML = "";


        images.forEach((image, index) => {

            const item =
                document.createElement("div");

            item.className =
                "portfolio-item";


            item.innerHTML = `
                <img
                    src="${escapeHtml(image.image_url)}"
                    alt="Portfolio image ${index + 1}"
                >

                <button
                    type="button"
                    class="portfolio-delete-btn"
                    title="Delete image"
                    onclick="deleteVendorImage(${image.id})"
                >
                    ×
                </button>

                <div class="portfolio-number">
                    ${index + 1}
                </div>
            `;


            container.appendChild(item);
        });


    } catch (error) {

        console.error(error);


        container.innerHTML =
            `<div class="portfolio-empty">
                Unable to load portfolio photos.
            </div>`;
    }
}


/* -----------------------------------------
   DELETE EXISTING IMAGE
----------------------------------------- */

async function deleteVendorImage(imageId) {

    if (!confirm(
        "Are you sure you want to delete this photo?"
    )) {
        return;
    }


    try {

        const response =
            await fetch(
                "php/api.php?action=delete_vendor_image",
                {
                    method: "POST",

                    headers: {
                        "Content-Type":
                            "application/json"
                    },

                    body: JSON.stringify({
                        image_id: imageId
                    })
                }
            );


        const result =
            await response.json();


        if (!result.success) {

            throw new Error(
                result.message ||
                "Unable to delete image."
            );
        }


        showPortfolioMessage(
            "Photo deleted successfully.",
            "success"
        );


        await loadVendorImages();


    } catch (error) {

        console.error(error);


        showPortfolioMessage(
            error.message ||
            "Unable to delete photo.",
            "error"
        );
    }
}


/* ---------------------------------
   INITIAL LOAD
--------------------------------- */

document.addEventListener(
    "DOMContentLoaded",
    async function() {

        await loadVendorProfile();

        await loadVendorImages();

    }
);

</script>

</body>
</html>