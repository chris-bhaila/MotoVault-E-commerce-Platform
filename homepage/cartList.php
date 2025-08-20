<div class="cart-table">
    <?php echo $message; ?>
    <div align="right">
        <a href="productPage.php?action=clear&id=<?php echo $product_id?>"><b>Clear Cart</b></a>
    </div>
    <table class="table table-bordered">
        <tr>
            <th width="10%">Item ID</th>
            <th width="40%">Item Name</th>
            <th width="10%">Item Price</th>
            <th width="15%">Action</th>
        </tr>
        <?php
            $cookie_name = "shopping_cart_" . $_SESSION['UID'];
            if (isset($_COOKIE[$cookie_name])) {
                $total = 0;
                $cookie_data = stripslashes($_COOKIE[$cookie_name]);
                $cart_data = json_decode($cookie_data, true);
            
                $items_found = false; // Track if items exist for the current user
            
                foreach ($cart_data as $keys => $values) {
                    // Ensure the item belongs to the logged-in user
                    if ($values["user_id"] == $_SESSION['UID']) {
                        $items_found = true; // Set flag if an item is found
                        ?>
                        <tr style="text-align: center;">
                            <td><?php echo $values["item_id"]; ?></td>
                            <td><?php echo $values["item_name"]; ?></td>
                            <td><?php echo "Rs. " . number_format($values["item_price"], 2); ?></td>
                            <td>
                                <a href="productPage.php?action=delete&id=<?php echo $product_id ?>">
                                    <span class="text-danger">Remove</span>
                                </a>
                            </td>
                        </tr>
                        <?php
                        $total += $values["item_price"]; // Accumulate the total price
                    }
                }
            
                // Display total if items were found
                if ($items_found) {
                    ?>
                    <tr style="text-align: center;">
                        <td colspan="2"><strong>Total</strong></td>
                        <td><?php echo "Rs. " . number_format($total, 2); ?></td>
                        <td></td>
                    </tr>
                    <?php
                } else {
                    // No items for the current user
                    ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">Your cart is empty.</td>
                    </tr>
                    <?php
                }
            } else {
                // Cookie does not exist or is empty
                ?>
                <tr>
                    <td colspan="4" style="text-align: center;">Your cart is empty.</td>
                </tr>
                <?php
            }                        
        ?>
    </table>
</div>