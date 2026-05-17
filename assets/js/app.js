document.addEventListener('DOMContentLoaded', () => {
    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.style.background = 'rgba(22, 22, 26, 0.95)';
            navbar.style.padding = '1rem 0';
        } else {
            navbar.style.background = 'rgba(22, 22, 26, 0.7)';
            navbar.style.padding = '1.5rem 0';
        }
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Filtering logic
    const filterBtns = document.querySelectorAll('.filter-btn');
    const products = document.querySelectorAll('.product-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active class
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class
            btn.classList.add('active');

            const filterValue = btn.getAttribute('data-filter');

            products.forEach(product => {
                if (filterValue === 'all' || product.getAttribute('data-category') === filterValue) {
                    product.style.display = 'block';
                    // Animation
                    setTimeout(() => {
                        product.style.opacity = '1';
                        product.style.transform = 'translateY(0)';
                    }, 50);
                } else {
                    product.style.opacity = '0';
                    product.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        product.style.display = 'none';
                    }, 300);
                }
            });
        });
    });

    // Cart Logic
    let cart = [];
    const cartCountElement = document.querySelector('.cart-count');
    const addToCartBtns = document.querySelectorAll('.btn-add-cart');

    // Add checkout button dynamically
    const navActions = document.querySelector('.nav-actions');
    const checkoutBtn = document.createElement('button');
    checkoutBtn.className = 'btn btn-primary checkout-btn';
    checkoutBtn.style.display = 'none';
    checkoutBtn.style.marginLeft = '1rem';
    checkoutBtn.style.padding = '0.5rem 1rem';
    checkoutBtn.style.fontSize = '0.9rem';
    checkoutBtn.textContent = 'Comprar';
    navActions.appendChild(checkoutBtn);

    addToCartBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const productId = btn.getAttribute('data-id');
            const existingItem = cart.find(item => item.id === productId);
            
            if (existingItem) {
                existingItem.cantidad++;
            } else {
                cart.push({ id: productId, cantidad: 1 });
            }

            // Update UI
            const totalItems = cart.reduce((sum, item) => sum + item.cantidad, 0);
            cartCountElement.textContent = totalItems;
            
            if (cart.length > 0) {
                checkoutBtn.style.display = 'block';
            }
            
            // Animation for button
            const originalText = btn.textContent;
            btn.innerHTML = '<i data-lucide="check"></i> Añadido';
            lucide.createIcons();
            btn.style.background = '#00cc66';
            btn.style.color = 'white';
            
            setTimeout(() => {
                btn.textContent = originalText;
                btn.style.background = '';
                btn.style.color = '';
            }, 2000);
        });
    });

    // Checkout process
    checkoutBtn.addEventListener('click', async () => {
        if (cart.length === 0) return;

        try {
            checkoutBtn.textContent = 'Procesando...';
            checkoutBtn.disabled = true;

            const response = await fetch('api/checkout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ cart })
            });

            const data = await response.json();

            if (data.success) {
                alert(`¡Compra realizada con éxito! Venta ID: ${data.id_venta}`);
                // Clear cart
                cart = [];
                cartCountElement.textContent = '0';
                checkoutBtn.style.display = 'none';
            } else {
                alert(`Error: ${data.message}`);
            }
        } catch (error) {
            console.error('Error during checkout:', error);
            alert('Error al procesar la compra.');
        } finally {
            checkoutBtn.textContent = 'Comprar';
            checkoutBtn.disabled = false;
        }
    });

    // Wishlist Toggle
    const wishlistBtns = document.querySelectorAll('.wishlist-btn');
    wishlistBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const icon = btn.querySelector('svg');
            if(icon.getAttribute('fill') === 'none' || !icon.getAttribute('fill')) {
                icon.setAttribute('fill', 'var(--primary-color)');
                icon.style.color = 'var(--primary-color)';
            } else {
                icon.setAttribute('fill', 'none');
                icon.style.color = 'white';
            }
        });
    });
});
