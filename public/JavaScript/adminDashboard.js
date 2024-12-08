document.addEventListener('DOMContentLoaded', () => {
    const menuItems = document.querySelectorAll('.menu-item');
    const iframe = document.getElementById('dynamicIframe');

    // Define mapping between menu items and iframe sources
    const iframeSources = {
        dashboard: '/profile/dashboard',
        staff: '/profile/staff', // Corrected typo here
        'update-menu': '/path/to/update-menu.php',
        'view-reservations': '/path/to/view-reservations.php',
        'update-offers': '/path/to/update-offers.php',
        feedbacks: '/path/to/feedbacks.php',
        'order-history': '/path/to/order-history.php'
    };

    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            const itemId = item.id; // Get ID of the clicked menu item
            if (iframeSources[itemId]) {
                iframe.src = iframeSources[itemId]; // Update iframe src
            } else {
                iframe.src = ''; // Clear iframe src if no source is defined
            }
        });
    });
});
