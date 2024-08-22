// Fetch the content of header.html
fetch('NavBar.html')
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return response.text();
})
.then(data => {
    // Inject the content of header.html into the div with id "header"
    document.getElementById('NavBar').innerHTML = data;
})
.catch(error => {
    console.error('There has been a problem with your fetch operation:', error);
});

// How It Works:
// Fetch the HTML Content:

// The fetch function is used to request the header.html file from the server.
// Check the Response:

// The response is checked to ensure it's okay (response.ok). If it's not, an error is thrown.
// Convert the Response to Text:

// response.text() converts the fetched HTML content into a string.
// Inject the HTML Content:

// The HTML content is then injected into the div with the ID header using innerHTML.
// Error Handling:

// If there's any issue during the fetch operation, it catches the error and logs it to the console.
// Notes:
// Cross-Origin Requests: If header.html is hosted on a different domain, you'll need to make sure that CORS (Cross-Origin Resource Sharing) is correctly configured on the server.
// Local Files: If you're running this locally using file:// protocol, some browsers may block fetch requests. It's recommended to serve your files using a local server, like Live Server in VS Code or http-server via Node.js.
// This method allows you to modularize your HTML files, making your code more maintainable by separating concerns like headers, footers, and main content.
