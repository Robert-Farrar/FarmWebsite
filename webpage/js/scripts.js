document.addEventListener("DOMContentLoaded", function () {
    var cartCount;
    var storedCount = localStorage.getItem("cartCount");

    if (storedCount) {
        cartCount = parseInt(storedCount);
    } else {
        cartCount = 0;
    }

    var cartCountElement = document.getElementById("cart-count");
    cartCountElement.textContent = cartCount; 

    var addToCartButtons = document.querySelectorAll(".add-to-cart");

    function updateCart(event) {
        event.preventDefault();
        cartCount = cartCount + 1; 
        cartCountElement.textContent = cartCount;
        localStorage.setItem("cartCount", cartCount);
    }

    for (var i = 0; i < addToCartButtons.length; i++) {
        addToCartButtons[i].addEventListener("click", updateCart);
    }
    cartCount = 0;
});

document.addEventListener("DOMContentLoaded", function () {
    var cartCountElement = document.getElementById("cart-count");
    var clearCartButton = document.getElementById("clear-cart");
    var checkoutButton = document.getElementById("checkout-button"); // New checkout button
    var cartItemsList = document.getElementById("cart-items");
    var addToCartButtons = document.querySelectorAll(".add-to-cart");

    var cart;
    var storedCart = localStorage.getItem("cart");

    if (storedCart) {
        cart = JSON.parse(storedCart);
    } else {
        cart = {};
    }

    updateCartDisplay();

    function updateCart(event) {
        var productElement = this.parentElement.parentElement.parentElement.querySelector("h5");
        var productName = productElement.textContent.trim();

        if (cart[productName]) {
            cart[productName] = cart[productName] + 1;
        } else {
            cart[productName] = 1;
        }

        localStorage.setItem("cart", JSON.stringify(cart));
        updateCartDisplay();
    }

    function clearCart() {
        cart = {};
        localStorage.removeItem("cart");
        updateCartDisplay();
    }

    function updateCartDisplay() {
        var totalCount = 0;
        cartItemsList.innerHTML = "";

        for (var key in cart) {
            if (cart.hasOwnProperty(key)) {
                totalCount += cart[key];

                var listItem = document.createElement("li");
                listItem.className = "list-group-item d-flex justify-content-between align-items-center";
                listItem.textContent = key + " - Quantity: " + cart[key];

                cartItemsList.appendChild(listItem);
            }
        }

        cartCountElement.textContent = totalCount;
    }

    function proceedToCheckout() {
        var cartData = encodeURIComponent(JSON.stringify(cart));
        window.location.href = "orderConfirmation.html?cart=" + cartData;
    }

    for (var i = 0; i < addToCartButtons.length; i++) {
        addToCartButtons[i].addEventListener("click", updateCart);
    }

    clearCartButton.addEventListener("click", clearCart);
    checkoutButton.addEventListener("click", proceedToCheckout);
});
