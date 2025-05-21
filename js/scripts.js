// Theme Toggle
document.getElementById('theme-toggle').addEventListener('click', () => {
    document.body.classList.toggle('light-theme');
    document.body.classList.toggle('dark-theme');
    localStorage.setItem('theme', document.body.classList.contains('dark-theme') ? 'dark' : 'light');
});

// Load Theme Preference
window.addEventListener('load', () => {
    const theme = localStorage.getItem('theme') || 'light';
    document.body.classList.add(`${theme}-theme`);

    // Debug CSS loading
    const cssLink = document.querySelector('link[href*="/electronics_catalog/css/styles.css"]');
    if (!cssLink) {
        console.error('CSS file not found. Check the path in header.php.');
    } else {
        console.log('CSS file loaded:', cssLink.href);
    }

    // Debug form styling
    const formContainer = document.querySelector('.form-container');
    if (formContainer) {
        const computedStyle = window.getComputedStyle(formContainer);
        if (computedStyle.backgroundColor === 'rgba(0, 0, 0, 0)' || computedStyle.backgroundColor === 'transparent') {
            console.warn('Form container styling not applied. Check CSS rules for .form-container.');
        } else {
            console.log('Form container styling applied:', computedStyle.backgroundColor);
        }
    }

    // Debug sidebar width
    const sidebar = document.querySelector('aside.sidebar');
    if (sidebar) {
        const computedWidth = window.getComputedStyle(sidebar).width;
        const windowWidth = window.innerWidth;
        const widthPercentage = (parseFloat(computedWidth) / windowWidth) * 100;
        if (windowWidth > 1024 && (widthPercentage < 20 || widthPercentage > 30)) {
            console.warn('Sidebar width not applied correctly. Expected ~25%, got:', widthPercentage.toFixed(2) + '%');
        } else {
            console.log('Sidebar width applied:', widthPercentage.toFixed(2) + '%');
        }
        // Check visibility
        const rect = sidebar.getBoundingClientRect();
        if (rect.left < 0 || rect.right > windowWidth) {
            console.warn('Sidebar may be clipped or not fully visible. Bounding rect:', rect);
        }
    } else {
        console.error('Sidebar not found. Check markup in header.php.');
    }

    // Debug product grid
    const productGrid = document.querySelector('.product-grid');
    if (productGrid) {
        const gridRect = productGrid.getBoundingClientRect();
        const mainContent = document.querySelector('.main-content');
        const mainRect = mainContent.getBoundingClientRect();
        if (gridRect.right > mainRect.right || gridRect.width > mainRect.width) {
            console.warn('Product grid exceeds main content area. Grid rect:', gridRect, 'Main rect:', mainRect);
        } else {
            console.log('Product grid fits within main content. Grid width:', gridRect.width, 'Main width:', mainRect.width);
        }
    }
});