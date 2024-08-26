// Function to load a component
function loadComponent(componentId, componentFile) {
    fetch(componentFile)
        .then(response => response.text())
        .then(data => {
            document.getElementById(componentId).innerHTML = data;
        })
        .catch(error => console.error('Error loading component:', error));
}

// Load the navbar and footer components
loadComponent('NavBar', '/HTML/NavBar.html');
loadComponent('footer', '/HTML/footer.html');