document.addEventListener('DOMContentLoaded', () => {
    // Handle nav-link clicks and tooltips
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            const target = event.target.getAttribute('data-target');
            const tooltip = document.getElementById(target);
            const navRect = event.target.getBoundingClientRect();
            tooltip.style.left = `${navRect.left}px`;
            tooltip.style.top = `${navRect.bottom}px`;
            document.querySelectorAll('.tooltiptext').forEach(tt => {
                if (tt !== tooltip) {
                    tt.classList.remove('show');
                }
            });
            tooltip.classList.toggle('show');
        });
    });

    // Hide tooltips when clicking outside
    document.addEventListener('click', (event) => {
        if (!event.target.matches('.nav-link')) {
            document.querySelectorAll('.tooltiptext').forEach(tooltip => {
                tooltip.classList.remove('show');
            });
        }
    });

    // Open login form in new tab
    const leftBtn = document.querySelector('.left');
    if (leftBtn) {
        leftBtn.addEventListener('click', () => {
            window.open('login.html', '_blank');
        });
    }

    // Toggle password visibility
    const toggleBtn = document.querySelector('.toggle-password');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', togglePasswordVisibility);
    }

    // Open registration form in new tab
    const rtBtn = document.querySelector('.rt');
    if (rtBtn) {
        rtBtn.addEventListener('click', () => {
            window.open('register.html', '_blank'); // Adjust the path if necessary
        });
    }

    // Open about us page in new tab
    const aboutLink = document.querySelector('.nav-link[data-target="about"]');
    if (aboutLink) {
        aboutLink.addEventListener('click', () => {
            window.open('aboutus.html', '_blank');
        });
    }

    // Open km.html in new tab
    const knowMoreBtn = document.querySelector('.know-more');
    if (knowMoreBtn) {
        knowMoreBtn.addEventListener('click', (event) => {
            event.preventDefault();
            window.open('km.html', '_blank');
        });
    }

    // Handle loans section
    const loansLink = document.querySelector('.nav-link[data-target="loans"]');
    if (loansLink) {
        loansLink.addEventListener('click', () => {
            const loansList = document.querySelector('.loans-list');
            loansList.classList.toggle('show');
        });
    }

    // Load loan content on link click
    document.querySelectorAll('.loan-item').forEach(item => {
        item.addEventListener('click', (event) => {
            event.preventDefault();
            const targetUrl = event.target.getAttribute('href');
            window.open(targetUrl, '_blank'); // Opens the specified URL in a new tab
        });
    });

    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const toggleBtn = document.querySelector('.toggle-password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleBtn.textContent = 'Hide';
        } else {
            passwordInput.type = 'password';
            toggleBtn.textContent = 'Show';
        }
    }
});
