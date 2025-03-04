<?php
    $message = '';
    if (isset($_POST["add-to-cart"])) 
    {
        // Create a unique cookie name for the logged-in user
        $cookie_name = "shopping_cart_" . $_SESSION['UID'];
    
        // Retrieve existing cart data for the current user from cookies
        if (isset($_COOKIE[$cookie_name])) {
            $cookie_data = stripslashes($_COOKIE[$cookie_name]);
            $cart_data = json_decode($cookie_data, true);
        } else {
            $cart_data = array();
        }
    
        // Extract item IDs from the cart
        $item_id_list = array_column($cart_data, 'item_id');
    
        // Check if the item already exists in the cart
        if (in_array($_POST["p-id"], $item_id_list)) 
        {
            foreach ($cart_data as $keys => $values) 
            {
                if ($cart_data[$keys]["item_id"] == $_POST["p-id"]) 
                {
                    $cart_data[$keys]["item_quantity"] += $_POST["quantity"];
                }
            }
            $item_data = json_encode($cart_data);
            setcookie($cookie_name, $item_data, time() + (86400 * 30), "/");
        } else {
            // Add the new item to the cart
            $item_array = array(
                'item_id' => $_POST["p-id"],
                'item_name' => $_POST["p-name"],
                'item_price' => $_POST["p-price"],
                'item_quantity'	=> $_POST["quantity"],
                'user_id' => $_SESSION['UID']
            );
            $cart_data[] = $item_array;
            $item_data = json_encode($cart_data);
    
            // Save the updated cart back to cookies with the unique name
            setcookie($cookie_name, $item_data, time() + (86400 * 30), "/");
    
            // Redirect to the same page with success message
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
    
    if (isset($_GET["action"])) {
        $cookie_name = "shopping_cart_" . $_SESSION['UID'];  // Include the user_id in the cookie name
        if ($_GET["action"] == "delete") {
    
            if (isset($_COOKIE[$cookie_name])) {
                // Get cookie data and decode it
                $cookie_data = stripslashes($_COOKIE[$cookie_name]);
                $cart_data = json_decode($cookie_data, true);
    
                // Loop through cart items and check if user_id and item_id match
                foreach ($cart_data as $keys => $values) {
                    if ($values['user_id'] == $_SESSION['UID'] && $cart_data[$keys]['item_id'] == $_GET["id"]) {
                        // Remove item from cart
                        unset($cart_data[$keys]);
                        $cart_data = array_values($cart_data); // Reindex the array after removing the item
    
                        // If the cart is empty, delete the cookie
                        if (empty($cart_data)) {
                            setcookie($cookie_name, "", time() - 3600, "/"); // Delete the cookie
                        } else {
                            // Otherwise, update the cookie with the remaining cart items
                            $item_data = json_encode($cart_data);
                            setcookie($cookie_name, $item_data, time() + (86400 * 30), "/"); // Set cookie for 30 days
                        }
    
                        // Redirect with success message
                        header('Location: ' . $_SERVER['HTTP_REFERER']);
                        exit;
                    }
                }
            }
    }
    
        if ($_GET["action"] == "clear") {
            // Check if the user-specific cookie exists before attempting to delete
            if (isset($_COOKIE[$cookie_name])) {
                setcookie($cookie_name, "", time() - 3600, "/"); // Delete the cookie by setting it to expire in the past
            }
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
        if(isset($_GET["success"]))
        {
            $message = '
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    Item Added into Cart
                </div>
            ';
        }
        if(isset($_GET["remove"]))
        {
            $message = '
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Item removed from Cart
            </div>
            ';
        }
?>