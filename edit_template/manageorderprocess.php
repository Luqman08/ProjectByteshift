<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}

include('dbcon.php');

// Function to add a product to the order
function addProductToOrder($orderId, $productId, $quantity)
{
    global $con;

    // Check if the product is already in the order
    if (isProductInOrder($orderId, $productId)) {
        $_SESSION['popup_message'] = "Product #$productId is already in the order. To update the quantity, use the 'Update Quantity' option.";
        return;
    }

    // Get product price and available quantity
    $productInfoQuery = "SELECT p_price, p_quantity FROM tb_product WHERE p_id = $productId";
    $result = $con->query($productInfoQuery);

    if ($result && $row = $result->fetch_assoc()) {
        $price = $row['p_price'];
        $availableQuantity = $row['p_quantity'];

        // Check if the quantity is sufficient
        if ($quantity > $availableQuantity) {
            $_SESSION['popup_message'] = "Error: Insufficient quantity for Product #$productId. Available quantity is $availableQuantity.";
            return;
        }

        // Insert the new product into the order
        $insertProductQuery = "INSERT INTO tb_orderproduct (op_orderid, op_productid, op_quantity, op_total_price) 
                                VALUES ($orderId, $productId, $quantity, $quantity * $price)";
        $con->query($insertProductQuery);

        // Update the grand total for the order
        updateGrandTotal($orderId);

        // Set the success alert message
        $_SESSION['popup_message'] = "Product #$productId added to the order successfully!";
    } else {
        $_SESSION['popup_message'] = "Failed to retrieve product information for Product #$productId.";
    }
}

// Function to update the quantity of a product in the order
function updateProductQuantity($orderProductId, $newQuantity)
{
    global $con;

    // Get the existing quantity and price
    $getProductDetailsQuery = "SELECT op_quantity, op_total_price FROM tb_orderproduct WHERE op_id = $orderProductId";
    $result = $con->query($getProductDetailsQuery);

    if ($result && $row = $result->fetch_assoc()) {
        $quantity = $row['op_quantity'];
        $totalPrice = $row['op_total_price'];

        // Update the quantity and recalculate total price
        $updateQuantityQuery = "UPDATE tb_orderproduct SET op_quantity = $newQuantity, op_total_price = $newQuantity * $totalPrice WHERE op_id = $orderProductId";
        $con->query($updateQuantityQuery);

        // Get the order ID and update the grand total for the order
        $getOrderIdQuery = "SELECT op_orderid FROM tb_orderproduct WHERE op_id = $orderProductId";
        $result = $con->query($getOrderIdQuery);

        if ($result && $row = $result->fetch_assoc()) {
            $orderId = $row['op_orderid'];
            updateGrandTotal($orderId);
        }

        $_SESSION['popup_message'] = "Quantity updated successfully!";
    } else {
        $_SESSION['popup_message'] = "Failed to retrieve product details for order product ID #$orderProductId.";
    }
}

// Function to update the grand total for an order
function updateGrandTotal($orderId)
{
    global $con;

    // Calculate the new grand total
    $calculateGrandTotalQuery = "SELECT SUM(op_total_price) as grand_total FROM tb_orderproduct WHERE op_orderid = $orderId";
    $result = $con->query($calculateGrandTotalQuery);

    if ($result && $row = $result->fetch_assoc()) {
        $grandTotal = $row['grand_total'];

        // Update the grand total in the tb_order table
        $updateGrandTotalQuery = "UPDATE tb_order SET grand_total = $grandTotal WHERE o_id = $orderId";
        $con->query($updateGrandTotalQuery);
    } else {
        $_SESSION['popup_message'] = "Failed to calculate the grand total for Order ID #$orderId.";
    }
}

// Function to check if a product is already in the order
function isProductInOrder($orderId, $productId)
{
    global $con;

    $checkProductQuery = "SELECT COUNT(*) as count FROM tb_orderproduct WHERE op_orderid = $orderId AND op_productid = $productId";
    $result = $con->query($checkProductQuery);

    if ($result && $row = $result->fetch_assoc()) {
        return $row['count'] > 0;
    }

    return false;
}

// Function to delete a product from the order
function deleteProductFromOrder($orderProductId)
{
    global $con;

    // Get the order ID
    $getOrderIdQuery = "SELECT op_orderid FROM tb_orderproduct WHERE op_id = $orderProductId";
    $result = $con->query($getOrderIdQuery);

    if ($result && $row = $result->fetch_assoc()) {
        $orderId = $row['op_orderid'];

        // Delete the product from the order
        $deleteProductQuery = "DELETE FROM tb_orderproduct WHERE op_id = $orderProductId";
        $con->query($deleteProductQuery);

        // Update the grand total for the order
        updateGrandTotal($orderId);

        $_SESSION['popup_message'] = "Product deleted from the order successfully!";
    } else {
        $_SESSION['popup_message'] = "Failed to retrieve order details for order product ID #$orderProductId.";
    }
}
