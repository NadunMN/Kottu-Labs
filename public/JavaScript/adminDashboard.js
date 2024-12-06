document.addEventListener('DOMContentLoaded', () => {
    const menuItems = document.querySelectorAll('.menu-item');
    const mainContent = document.getElementById('main-content');

    mainContent.innerHTML = `<p>Welcome to the admin dashboard. Please select an option from the menu on the left.</p>`;

    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            // Extract the ID to determine which file to load
            const contentId = item.id;
            const phpFile = `/profile/${contentId}`;

            // Fetch the PHP content
            fetch(phpFile)
                .then(response => {
                    if (!response.ok) throw new Error('Failed to load content');
                    return response.text();
                })
                .then(data => {
                    // Inject the content into the main-content div
                    mainContent.innerHTML = data;
                })
                .catch(error => {
                    console.error(error);
                    mainContent.innerHTML = '<p>Error loading content. Please try again.</p>';
                });
        });
    });
});


// graph
const ctx = document.getElementById('cashflowChart').getContext('2d');
const data = {
labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
datasets: [
{
label: 'Income',
data: [55000, 58000, 60000, 52000, 50000, 65000, 58000, 62000, 57000, 59000, 61000, 63000],
backgroundColor: '#4285F4'
},
{
label: 'Expense',
data: [45000, 47000, 48000, 46000, 44000, 50000, 47000, 49000, 46000, 48000, 49000, 50000],
backgroundColor: '#EA4335'
}
]
};
const options = {
scales: {
y: {
beginAtZero: true,
ticks: {
callback: function(value, index, ticks) {
return '$' + value.toLocaleString();
}
}
}
},
plugins: {
title: {
display: true,
text: 'Cashflow'
},
legend: {
position: 'bottom'
}
}
};
new Chart(ctx, {
type: 'bar',
data: data,
options: options
});