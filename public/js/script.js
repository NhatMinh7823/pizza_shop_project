document.getElementById('navbar-toggler').addEventListener('click', function () {
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenu.classList.toggle('hidden');
});
// public/js/script.js

document.addEventListener("DOMContentLoaded", function () {
    const addToCartButtons = document.querySelectorAll('.add-to-cart-button');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = e.target.closest('.add-to-cart-form');
            const formData = new FormData(form);

            // Add the action parameter for the AJAX endpoint
            formData.append('action', 'add_to_cart');

            fetch('/ajax.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' // Marks the request as an AJAX request
                }
            })
                .then(response => {
                    if (response.headers.get('content-type')?.includes('application/json')) {
                        return response.json();
                    } else {
                        throw new Error('Response is not JSON');
                    }
                })
                .then(data => {
                    if (data.loggedIn === false) {
                        showLoginModal();
                    } else if (data.success) {
                        alert("Product added to cart successfully!");
                    } else {
                        alert("An error occurred while adding the product to the cart.");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("An error occurred. Please try again.");
                });
        });
    });

    function showLoginModal() {
        const modalHtml = `
            <div class="modal" id="loginModal" style="display: block; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5);">
                <div style="background: #fff; padding: 20px; max-width: 500px; margin: 100px auto; border-radius: 8px;">
                    <h3>Please log in to add items to your cart</h3>
                    <p>To add products to your cart, you need to log in. You can also continue browsing the product details.</p>
                    <a href="/index.php?page=login" class="btn btn-primary">Log In</a>
                    <button id="continueBrowsing" class="btn btn-secondary">Continue Browsing</button>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHtml);

        document.getElementById('continueBrowsing').addEventListener('click', function () {
            document.getElementById('loginModal').remove();
        });
    }
});


