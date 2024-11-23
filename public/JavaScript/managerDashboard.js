document.addEventListener("DOMContentLoaded", () => {
    // Get all list items in the sidebar
    const menuItems = document.querySelectorAll(".sidebar ul li");

    // Get the current URL fragment or default to #viewUsers
    let currentPage = window.location.hash || "#viewUsers";

    // Set the initial active menu item
    setActiveMenuItem(currentPage);

    // Load the content for the default page on load
    loadContent(currentPage.substring(1)); // Remove '#' to get the page name

    // Add event listener for hash changes
    window.addEventListener("hashchange", () => {
        currentPage = window.location.hash; // Update the current page based on hash
        setActiveMenuItem(currentPage); // Highlight the corresponding menu item
        loadContent(currentPage.substring(1)); // Load the corresponding content
    });

    /**
     * Highlights the active menu item based on the current page
     * @param {string} currentPage - The current URL hash
     */
    function setActiveMenuItem(currentPage) {
        menuItems.forEach((item) => {
            // Remove the active class from all menu items
            item.classList.remove("active");

            // Check if the item's link matches the current URL fragment
            const link = item.querySelector("a").getAttribute("href");
            if (link === currentPage) {
                item.classList.add("active"); // Add the active class to the matching item
            }
        });
    }

    /**
     * Dynamically loads content into the main content area
     * @param {string} page - The name of the page to load (e.g., 'viewUsers')
     */
    function loadContent(page) {
        const contentArea = document.getElementById("main-content");

        // Use fetch to load the PHP file in the same folder as managerDashboard.php
        fetch(`${page}.php`) // Directly fetch the PHP file in the current directory
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`Failed to load page: ${page}`);
                }
                return response.text(); // Get the HTML content as text
            })
            .then((data) => {
                contentArea.innerHTML = data; // Set the fetched content in the main area
            })
            .catch((error) => {
                // Display an error message if the fetch fails
                contentArea.innerHTML = `
                    <p>Error loading content. Please try again.</p>
                    <p>${error.message}</p>
                `;
                console.error("Error:", error);
            });
    }
});




