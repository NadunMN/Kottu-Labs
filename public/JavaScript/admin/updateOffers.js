const offerContent = document.getElementById("main-content");
offerContent.innerHTML = `
                        <div class="update-offers-section">
                            <h2>Update Offers</h2>

                            <!-- Add New Offer -->
                            <div class="add-new-offer">
                                <h3>Add New Offer</h3>
                                <form class="update-offer-form">
                                    <div class="form-group">
                                        <label for="offer-image">Upload Offer Image</label>
                                        <input type="file" id="offer-image" name="offer-image" accept="image/*" />
                                    </div>
                                    <div class="form-group">
                                        <label for="offer-description">Offer Description</label>
                                        <textarea id="offer-description" name="offer-description" rows="5" placeholder="Describe the offer..."></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn submit-offer-btn">Add Offer</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Existing Offers -->
                            <div class="existing-offers">
                                <h3>Existing Offers</h3>
                                <div class="offers-container">
                                    <!-- Example Offer Cards -->
                                    <div class="offer-card">
                                        <img src="path/to/image1.jpg" alt="Offer Image 1" class="offer-image" />
                                        <div class="offer-content">
                                            <h4>50% Off on All Kottu</h4>
                                            <p>Enjoy half-price Kottu this weekend!</p>
                                            <button class="btn delete-btn">Delete</button>
                                        </div>
                                    </div>
                                    <div class="offer-card">
                                        <img src="path/to/image2.jpg" alt="Offer Image 2" class="offer-image" />
                                        <div class="offer-content">
                                            <h4>Free Drink with Any Meal</h4>
                                            <p>Get a free drink with every meal purchase over $10.</p>
                                            <button class="btn delete-btn">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr />

                            <!-- Add New Special Notice -->
                            <div class="add-new-special-notice">
                                <h3>Add New Special Notice</h3>
                                <form class="special-notice-form">
                                    <div class="form-group">
                                        <label for="special-notice-image">Upload Notice Image</label>
                                        <input type="file" id="special-notice-image" name="special-notice-image" accept="image/*" />
                                    </div>
                                    <div class="form-group">
                                        <label for="special-notice-description">Notice Description</label>
                                        <textarea id="special-notice-description" name="special-notice-description" rows="5" placeholder="Add a description for the notice..."></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn submit-notice-btn">Add Special Notice</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Existing Special Notices -->
                            <div class="existing-special-notices">
                                <h3>Existing Special Notices</h3>
                                <div class="notices-container">
                                    <!-- Example Notice Cards -->
                                    <div class="notice-card">
                                        <img src="path/to/special-image1.jpg" alt="Special Notice 1" class="notice-image" />
                                        <div class="notice-content">
                                            <h4>Maintenance Notice</h4>
                                            <p>The Nawala branch will be closed for maintenance on Dec 5th.</p>
                                            <button class="btn delete-btn">Delete</button>
                                        </div>
                                    </div>
                                    <div class="notice-card">
                                        <img src="path/to/special-image2.jpg" alt="Special Notice 2" class="notice-image" />
                                        <div class="notice-content">
                                            <h4>Special Event</h4>
                                            <p>Join us for a live music night on Nov 30th at Wattala!</p>
                                            <button class="btn delete-btn">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
