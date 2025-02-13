<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/CSS/managerDashboard.css">
    <link rel="stylesheet" href="/CSS/admindashboard.css">

    <style>
        #offer-image {
            /* Basic styling */
            display: block;
            width: 100%;
            padding: 8px;

            /* Custom file input styling */
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Style the file input button */
        #offer-image::file-selector-button {
            padding: 6px 12px;
            border: none;
            background: #4a90e2;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        #offer-description {
            width: 100%;
            /* Border and appearance */
            border: 1px solid #ccc;
            border-radius: 4px;

            /* Typography */
            font-family: inherit;
            font-size: 16px;
            line-height: 1.5;

            /* Placeholder styling */
            ::placeholder {
                color: #999;
                opacity: 1;
            }

            /* Focus state */
            :focus {
                outline: none;
                border-color: #4a90e2;
                box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
            }

            /* Disable resize if desired */
            resize: vertical;
        }
    </style>
</head>

<body>



    <div class="view-branch-menu-section" id="main-content">

        <div class="update-offers-section">
            <h2>Update Offers</h2>

            <!-- Add New Offer -->
            <div class="add-new-offer">
                <h3>Add New Offer</h3>
                <form class="personal-information-form-wrapper" id="update-form" action="">
                    <div class="personal-information-form-information">
                        <div class="personal-information-container-first">
                            <div class="personal-information-name">

                                <div>
                                    <label for="offer-image" class="file-label">Upload Image</label>
                                    <input type="file" id="offer_photo" name="offer_photo" />
                                </div>

                            </div>


                            <div class="personal-information-name">
                                <div>
                                    <label for="offer-name" class="file-label">Offer Name</label>
                                    <input type="text" id="offer-name" name="offer_name" />

                                </div>
                            </div>


                            <div class="personal-information-name">
                                <div>
                                    <label for="offer-price" class="file-label">Offer Price</label>
                                    <input type="number" id="offer-price" name="offer_price" />

                                </div>
                            </div>

                            <div class="personal-information-name">
                                <div>
                                    <label for="offer-image" class="file-label">Select Branch</label>
                                    <div class="check-box-container">
                                        <div class="branch-group">
                                            <input type="checkbox" id="wattala" name="branch1" value="1">
                                            <label for="wattala">Wattala</label>
                                        </div>

                                        <div class="branch-group">
                                            <input type="checkbox" id="kelaniya" name="branch2" value="2">
                                            <label for="kelaniya">Kelaniya</label>
                                        </div>

                                        <div class="branch-group">
                                            <input type="checkbox" id="kotahena" name="branch3" value="3">
                                            <label for="kotahena">Kotahena</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            

                        </div>

                        <div class="personal-information-container-second">

                            <div class="personal-information-name">
                                <div>
                                    <label for="offer-description">Offer Description</label>
                                    <textarea id="offer-description" name="offer_description" rows="5" placeholder="Describe the offer..."></textarea>

                                </div>

                            </div>

                            <div class="personal-information-name">
                            <div class="selected-meals">
                                <button class="add-meals" type="button" onclick="window.location.href='/addMeal'">
                                    <img src="/Photo/icon/plus.png" alt="">Add Meals
                                </button>
                                <div id="selected-meals-container">
                                    <!-- Selected meals will be displayed here -->
                                </div>
                            </div>
                            </div>

                        </div>

                    </div>

                    <div class="personal-information-form-button">
                        <div>
                            <button id="save" type="submit">Add Offer</button>
                            <button id="cancel" type="" disabled>Cancel</button>

                        </div>
                    </div>
                </form>

            </div>

            <!-- Existing Offers -->
            <div class="existing-offers">
                <h3>Existing Offers</h3>

                <div class="offers-container" id="offers-container">                    
                    
                </div>

            </div>



        </div>

        <script src="/JavaScript/admin/updateOffers.js"></script>
</body>

</html>