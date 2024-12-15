const feedbackContent = document.getElementById("main-content");
feedbackContent.innerHTML = `
                        <div class="feedbacks-section">
                            <h2>Customer Feedbacks</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Rating</th>
                                        <th>Review</th>
                                        <th>Customer Name</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>5/5</td>
                                        <td>Excellent service and amazing food!</td>
                                        <td>Thirani Imanya</td>
                                        <td>2024-11-20</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4/5</td>
                                        <td>Great experience, but waiting time was long.</td>
                                        <td>Nadun Madushanka</td>
                                        <td>2024-11-21</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5/5</td>
                                        <td>The kottu was out of this world!</td>
                                        <td>Imeth Methnuka</td>
                                        <td>2024-11-22</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3/5</td>
                                        <td>Food was good, but the drinks could be better.</td>
                                        <td>Abdul Raheem</td>
                                        <td>2024-11-23</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>`;
