    // Get the current path
    const currentPath = window.location.pathname;
    
    // Select the button element
    const button = document.getElementById("view-profile");

    // Check the current path and update the button accordingly
    if (currentPath === '/profile') {
      button.textContent = "View Profile";
      button.onclick = () => { window.location.href = '/myaccount'; };
    } else if (currentPath === '/myaccount') {
      button.textContent = "View Dashboard";
      button.onclick = () => { window.location.href = '/profile'; };
    }