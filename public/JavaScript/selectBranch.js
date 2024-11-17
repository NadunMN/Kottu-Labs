document.addEventListener("DOMContentLoaded", () => {
    // Select all branch elements
    const branches = document.querySelectorAll(".branch");

    // Add click event to each branch
    branches.forEach(branch => {
        branch.addEventListener("click", () => {
            const selectedBranch = branch.getAttribute("data-branch");

            // Redirect to the next page based on the selected branch
            if (selectedBranch) {
                window.location.href = `/branch/${selectedBranch}`;
            }
        });
    });
});


