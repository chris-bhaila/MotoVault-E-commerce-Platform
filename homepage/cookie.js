function getCookie(name) {
    const cookies = document.cookie.split(';');
    for (let cookie of cookies) {
        const [key, value] = cookie.split('=').map(c => c.trim());
        if (key === name) {
            return decodeURIComponent(value);
        }
    }
    return '';
}


function removeFromCart(itemId, userId) {
    // Retrieve the cart data from cookies
    const cartData = JSON.parse(getCookie('shopping_cart') || '[]');

    // Filter out the item with the matching item_id and user_id
    const updatedCartData = cartData.filter(item => !(item.item_id == itemId && item.user_id == userId));

    // Update the cookie with the modified cart data
    document.cookie = `shopping_cart=${JSON.stringify(updatedCartData)}; path=/;`;

    window.location.reload();
    // Reload the page or refresh the cart display
    loadCart(); // Assuming this function refreshes the cart
}

function removeAll(userId) {
    // Retrieve the cart data from cookies
    let cartData = JSON.parse(getCookie('shopping_cart') || '[]');
    
    // Filter out items that match the given userId
    const updatedCartData = cartData.filter(item => item.user_id == userId);

    // Update the cookie with the filtered cart data
    document.cookie = `shopping_cart=${JSON.stringify(updatedCartData)}; path=/;`;

    window.location.reload();
    loadCart(); // Optionally reload the cart display
}