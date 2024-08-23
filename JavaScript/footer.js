
fetch('footer.html')
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return response.text();
})
.then(data => {
    // Inject the content of header.html into the div with id "header"
    document.getElementById('footer').innerHTML = data;
})
.catch(error => {
    console.error('There has been a problem with your fetch operation:', error);
});
