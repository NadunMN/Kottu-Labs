const orderContent = document.getElementById("main-content");

orderContent.innerHTML = `
                        <div class="order-history-section">
                            <h2>Order History</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Customer Name</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#1001</td>
                                        <td>2024-11-20</td>
                                        <td>18:30</td>
                                        <td>John Doe</td>
                                        <td>$45.00</td>
                                        <td>Completed</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>View</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#1002</td>
                                        <td>2024-11-21</td>
                                        <td>19:00</td>
                                        <td>Jane Smith</td>
                                        <td>$25.00</td>
                                        <td>Pending</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>View</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#1003</td>
                                        <td>2024-11-22</td>
                                        <td>20:15</td>
                                        <td>Michael Brown</td>
                                        <td>$60.00</td>
                                        <td>Completed</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>View</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#1004</td>
                                        <td>2024-11-23</td>
                                        <td>17:45</td>
                                        <td>Linda Lee</td>
                                        <td>$30.00</td>
                                        <td>Cancelled</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>View</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>`;
