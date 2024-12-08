document.addEventListener('DOMContentLoaded', () => {
    const menuItems = document.querySelectorAll('.menu-item');
    const mainContent = document.getElementById('main-content');

    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            const contentId = item.id;
            const phpFile = `/profile/${contentId}`;

            // Display loading indicator
            mainContent.innerHTML = '<p>Loading content...</p>';

            fetch(phpFile)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Failed to load content from ${phpFile}`);
                    }
                    return response.text();
                })
                .then(data => {

                    // Execute embedded scripts
                    const scripts = mainContent.querySelectorAll('script');
                    scripts.forEach(script => {
                        if (script.textContent.trim()) {
                            const newScript = document.createElement('script');
                            newScript.textContent = script.textContent;
                            document.body.appendChild(newScript).parentNode.removeChild(newScript);
                        }
                    });

                    mainContent.innerHTML = data;

                })
                .catch(error => {
                    console.error(`Error loading content from ${phpFile}:`, error);
                    mainContent.innerHTML = '<p>Error loading content. Please try again later.</p>';
                });
        });
    });
});
