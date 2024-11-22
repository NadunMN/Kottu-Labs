document.addEventListener("DOMContentLoaded", () => {
    // Get all list items in the sidebar
    const menuItems = document.querySelectorAll(".sidebar ul li");

    // Get the current URL fragment (default to #viewusers if empty)
    let currentPage = window.location.hash || "#viewusers";
    
    // Set the initial active class for the default page
    setActiveMenuItem(currentPage);

    // Listen for hash changes to dynamically highlight the correct menu item
    window.addEventListener("hashchange", () => {
        currentPage = window.location.hash;
        setActiveMenuItem(currentPage);
    });

    // Function to highlight the active menu item
    function setActiveMenuItem(currentPage) {
        menuItems.forEach((item) => {
            // Remove 'active' class from all items
            item.classList.remove("active");

            // Check if the item's link matches the current URL fragment
            const link = item.querySelector("a").getAttribute("href");
            if (link === currentPage) {
                item.classList.add("active"); // Add 'active' class to the matching item
            }
        });
    }
});

