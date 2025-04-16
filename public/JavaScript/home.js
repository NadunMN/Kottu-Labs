document.addEventListener('DOMContentLoaded', function() {
    const menuGrid = document.querySelector('.menu-grid');
    const categoryContainer = document.querySelector('.menu-categories');
    const paginationContainer = document.querySelector('.pagination');
    let currentBranch = 'all';
    let currentPage = 1;
    const itemsPerPage = 8;
    const branches = ['wattala', 'kelaniya', 'kotahena'];

    async function fetchMeals() {
        try {
            const response = await fetch(
                `/get/meals?branch=${currentBranch}&page=${currentPage}&limit=${itemsPerPage}`
            );
            return await response.json();
        } catch (error) {
            console.error('Error fetching meals:', error);
            return { meals: [], totalPages: 1 };
        }
    }

    function renderMeals(meals) {
        menuGrid.innerHTML = meals.map(meal => `
            <div class="menu-item" data-category="${meal.branch}">
                <div class="item-image">
                    <img src="${meal.image}" alt="${meal.name}">
                </div>
                <div class="item-details">
                    <div class="item-title">
                        <h3>${meal.name}</h3>
                        <div class="item-rating">${'★'.repeat(meal.rating)}</div>
                    </div>
                    <p class="item-description">${meal.description}</p>
                    <span class="price">$${meal.price.toFixed(2)}</span>
                    <button class="add-to-cart">Add to cart</button>
                </div>
            </div>
        `).join('');
    }

    function renderBranches() {
        const tabs = [
            '<div class="category-tab active" data-category="all">All Branches</div>',
            ...branches.map(branch => `
                <div class="category-tab" data-category="${branch}">
                    ${branch.charAt(0).toUpperCase() + branch.slice(1)}
                </div>
            `)
        ].join('');
        categoryContainer.innerHTML = tabs;
        setupBranchTabs();
    }

    function renderPagination(totalPages) {
        const buttons = Array.from({ length: totalPages }, (_, i) => `
            <button class="page-btn ${i + 1 === currentPage ? 'active' : ''}" 
                    data-page="${i + 1}">
                ${i + 1}
            </button>
        `).join('');

        paginationContainer.innerHTML = `
            <button class="page-nav-btn prev-btn">❮</button>
            ${buttons}
            <button class="page-nav-btn next-btn">❯</button>
        `;
        setupPagination();
    }

    function setupBranchTabs() {
        document.querySelectorAll('.category-tab').forEach(tab => {
            tab.addEventListener('click', async function() {
                document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                currentBranch = this.dataset.category;
                currentPage = 1;
                await updateContent();
            });
        });
    }

    function setupPagination() {
        document.querySelectorAll('.page-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                currentPage = parseInt(this.dataset.page);
                await updateContent();
            });
        });

        document.querySelector('.prev-btn').addEventListener('click', async () => {
            if (currentPage > 1) {
                currentPage--;
                await updateContent();
            }
        });

        document.querySelector('.next-btn').addEventListener('click', async () => {
            const totalPages = parseInt(document.querySelector('.page-btn:last-child')?.dataset.page || 1);
            if (currentPage < totalPages) {
                currentPage++;
                await updateContent();
            }
        });
    }

    async function updateContent() {
        const { meals, totalPages } = await fetchMeals();
        renderMeals(meals);
        renderPagination(totalPages);
    }

    async function initialize() {
        renderBranches();
        await updateContent();
    }

    initialize();
});