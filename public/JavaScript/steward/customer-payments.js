async function fetchPayments() {
    try {
        const response = await fetch("/payment/data");
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        
        const text = await response.text();
        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error("Response is not valid JSON:", text);
            document.getElementById("main-content").innerHTML = "<p>Error: Invalid data format</p>";
            return;
        }
        
        if (!Array.isArray(data)) {
            console.error("Data is not an array");
            document.getElementById("main-content").innerHTML = "<p>Error: Invalid data format</p>";
            return;
        }
  
        const paymentContent = document.getElementById("main-content");
        if (!data || data.length === 0) {
            paymentContent.innerHTML = `<div id="orderContent" class="empty-state">
        <div class="icon-container">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
        </div>
        <h2>No Payments Yet</h2>
        <p>It looks like Branch haven't any payments yet.</p>
        
    </div>`;
            return;
        }
  
        // Fetch user branch ID before rendering
        let branch_id = null;
        let stewardId = null;
        try {
            const userResponse = await fetch('/user/data');
            if (!userResponse.ok) {
                throw new Error("Network response was not ok");
            }
            const userData = await userResponse.json();
            if (userData.error) {
                console.error(userData.error);
            } else {
                branch_id = userData.branch_id;
                stewardId = userData.id;
            }
        } catch (error) {
            console.error('Error fetching user data:', error);
        }
  
        const branchNames = { 1: 'Wattala', 2: 'Kelaniya', 3: 'Kotahena' };
        const branchName = branchNames[branch_id] || 'Unknown';
        const currentDate = new Date().toLocaleDateString('en-CA');
  
        // Count pending payments
        const pendingCount = data.filter(payment => payment.payment_status === 0).length;
  
        paymentContent.innerHTML = `
            <div class="main-section">
                <div class="topic-bar">
                    <div class="topic-bar-text">
                        <h2>Payments - ${branchName} </h2>
                        <span>${currentDate}</span>
                        <h4>${data.length} payments available  &emsp; ${pendingCount} pending payments</h4>
                    </div>
                </div> 
                
                <table class="menu-table" id="menu-table">
                    <thead>
                        <tr>
                            <th>Payment Id</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Table No</th>
                        </tr>
                    </thead>
                    <tbody id="table-content"></tbody>
                </table>
            </div>
        `;
  
        const tableContent = document.getElementById("table-content");
        if (!tableContent) {
            console.error("Table content element not found.");
            return;
        }
  
        data.sort((a, b) => {
            // Move all payments with status = 2 to the bottom
            if (a.payment_status === 2 && b.payment_status !== 2) return 1;
            if (b.payment_status === 2 && a.payment_status !== 2) return -1;
  
            // If status is 1, it should be below status 0 but above status 2
            if (a.payment_status === 1 && b.payment_status === 0) return 1;
            if (b.payment_status === 1 && a.payment_status === 0) return -1;
  
            // If status is 0, prioritize by type: cash > card > none
            if (a.payment_status === 0 && b.payment_status === 0) {
                const typePriority = { cash: 1, card: 2, none: 3 };
                return typePriority[a.payment_type] - typePriority[b.payment_type];
            }
  
            // Default case: maintain original order
            return 0;
        });
  
        // Populate the table with payment data
        data.forEach((payment) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td class="payment-id">${payment.payment_id}</td>
                <td>${payment.payment_date}</td>
                <td>${payment.payment_type === 'cash' ? 'Cash' : 'Card'}</td>
                <td>${payment.total_payment}</td>
                <td class="status">
                    <span class="status-${payment.payment_status}">
                        ${payment.payment_status === 2 ? "Done" : payment.payment_status === 0 ? 'Pending' : 'Collecting'}
                    </span>
                    ${
                        payment.payment_type === 'cash' && payment.payment_status === 0
                        ? `<button class="confirm-btn" payment-status-id="${payment.payment_id}" next-status="1">Confirm</button>`
                        : payment.payment_type === 'cash' && payment.payment_status === 1
                        ? `<button class="confirm-btn" payment-status-id="${payment.payment_id}" next-status="2">Confirm</button>`
                        : ""
                    }
                </td>
                <td>${payment.table_number}</td>
            `;
            tableContent.appendChild(row);
        });
  
        // Confirm button click handler
        document.getElementById("table-content").addEventListener("click", async (event) => {
            if (event.target.classList.contains("confirm-btn")) {
                const paymentId = event.target.getAttribute("payment-status-id");
                const nextStatus = parseInt(event.target.getAttribute("next-status"), 10)
  
                try {
                    const response = await fetch('/payment/stewardCashConfirm', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            payment_id: paymentId,
                            payment_status: nextStatus,
                            steward_id: stewardId,    
                        }),
                    });
  
                    const result = await response.json();
  
                    if (result.success) {
                        fetchPayments();
                    } else if (result.error === 'Failed to update payment status') {
                        alert("You are not allowed to confirm this payment.");
                    } else {
                        console.error("Failed to update payment status:", result.error);
                    }
                } catch (e) {
                    console.error("Error:", e);
                }
            }
        });
  
    } catch (error) {
        console.error("Fetch error:", error);
        document.getElementById("main-content").innerHTML = "<p>Error loading payments.</p>";
    }
  }
  
  // Refresh payments every minute
  setInterval(() => {
    fetchPayments();
  }, 60000); 
  
  fetchPayments();