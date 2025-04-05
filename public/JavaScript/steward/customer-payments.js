async function fetchPayments(selectedDate = null, selectedTime = null) {
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
        paymentContent.innerHTML = "<p>No payments available</p>";
        return;
      }
  
      // Fetch user branch ID before rendering
      let branch_id = null;
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
        }
      } catch (error) {
        console.error('Error fetching user data:', error);
      }
  
      const branchName = branch_id === 1 ? 'Wattala' : branch_id === 2 ? 'Kelaniya' : 'Kotahena';
      const currentDate = selectedDate || new Date().toISOString().split('T')[0];
  
      // Filter payments for the selected date and branch
      const filteredData = data.filter(payment => {
        const paymentDate = new Date(payment.payment_date).toISOString().slice(0, 10);
        return paymentDate === currentDate && payment.branch_id === branch_id;
      });
  
      // Count pending payments
      const pendingCount = filteredData.filter(payment => payment.payment_status !== 1).length;
      
      paymentContent.innerHTML = `
        <div class="main-section">
          <div class="topic-bar">
            <div class="topic-bar-text">
              <h2>Payments - ${branchName} </h2>
              <span>${currentDate}</span>
              <h4>${filteredData.length} payments available  &emsp; ${pendingCount} pending payments</h4>
            </div>
            <div class="date-filter-container">
              <div class="date-input-group">
                  <label for="date-filter">Select Date:</label>
                  <input type="date" id="date-filter" value="${currentDate}"  />
              </div>
              <button id="current-date-button">Go to Current Date</button>
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
  
      // Sort payments: pending first, then confirmed, sorted by time
      filteredData.sort((a, b) => {
        if (a.payment_status !== 1 && b.payment_status === 1) return -1;
        if (a.payment_status === 1 && b.payment_status !== 1) return 1;
        
        //time eka add karala sort karanna ona
        // If both have the same status, sort by time
        // return a.payment_time.localeCompare(b.payment_time);

      });
  
      // Populate the table with filtered payment data
      filteredData.forEach((payment) => {
        
        const row = document.createElement("tr");
        row.innerHTML = `
          <td class="payment-id">${payment.payment_id}</td>
          <td>${payment.payment_date}</td>
          <td>${payment.payment_type === 'cash' ? 'Cash' : 'Card'}</td>
          <td>${payment.payment_amount}</td>
          <td class="status">
              <span class="status-${payment.payment_status}">
                  ${payment.payment_status === 1 ? "Done" : 'Pending'}
              </span>
          </td>
        `;
        tableContent.appendChild(row);
      });
  
      // Remove existing event listeners to avoid duplication
      const dateFilter = document.getElementById("date-filter");
      const currentDateButton = document.getElementById("current-date-button");
  
      dateFilter.replaceWith(dateFilter.cloneNode(true));
      currentDateButton.replaceWith(currentDateButton.cloneNode(true));
  
      document.getElementById("date-filter").addEventListener("change", () => {
        const selectedDate = new Date(document.getElementById("date-filter").value).toISOString().slice(0, 10);
        fetchPayments(selectedDate);
      });
  
      document.getElementById("current-date-button").addEventListener("click", () => {
        const currentDate = new Date().toISOString().split('T')[0];
        document.getElementById("date-filter").value = currentDate;
        fetchPayments(currentDate);
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
