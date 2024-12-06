document.addEventListener('DOMContentLoaded', () => {
    const menuItems = document.querySelectorAll('.menu-item');
    const mainContent = document.getElementById('main-content');

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
