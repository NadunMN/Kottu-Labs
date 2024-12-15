document.addEventListener('DOMContentLoaded', () => {
    const menuItems = document.querySelectorAll('.menu-item');
    const iframe = document.getElementById('dynamicIframe');

    // Define mapping between menu items and iframe sources
    const iframeSources = {
        dashboard: '/profile/dashboard',
        staff: '/profile/staff',
        updatemenu: '/profile/update-menu',
        viewreservations: '/profile/view-reservations',
        updateoffers: '/profile/update-offers',
        feedbacks: '/profile/feedbacks',
        orderhistory: '/profile/order-history'
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
