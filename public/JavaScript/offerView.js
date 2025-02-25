document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const offerId = urlParams.get('id');
    console.log(offerId);

      // Quantity Selector
  document.querySelectorAll('.quantity-btn').forEach(button => {
    button.addEventListener('click', () => {
        const input = document.querySelector('.quantity-number');
        let value = parseInt(input.value);
        
        if (button.classList.contains('plus')) {
            value++;
        } else {
            value = value > 1 ? value - 1 : 1;
        }
        input.value = value;
    });
});

// Tab Switching
document.querySelectorAll('.tab').forEach(tab => {
    tab.addEventListener('click', () => {
        const tabId = tab.dataset.tab;
        
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        
        tab.classList.add('active');
        document.getElementById(tabId).classList.add('active');
    });
});

    if (offerId) {
        fetch(`/get/offer?offerId=${offerId}`)
            .then(response => response.json())
            .then(offer => {
                
            });
    } else {
        // Handle missing ID case
        window.location.href = '/offers'; // Redirect if no ID
    }
});