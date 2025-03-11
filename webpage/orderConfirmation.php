<?php
session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: home.php");
    exit();
}

if (!isset($_SESSION['customerID'])) {
    header("Location: login.php");
    exit();
}

$customerID = $_SESSION['customerID'];
$orderStatus = "Processing";
$orderDateCreated = date("Y-m-d");

$orderPlaced = false;
$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $address = trim($_POST["address"]);

    if ($name === "" || $email === "" || $address === "") {
        $error_message = "Please fill in all fields before placing your order.";
    } else {
        $orderData = json_encode([
            "customerID" => $customerID,
            "orderStatus" => $orderStatus,
            "orderDateCreated" => $orderDateCreated
        ]);

        $orderApiUrl = "http://order-api:8003/order/create";

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $orderApiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $orderData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $responseData = json_decode($response, true);
            $orderID = $responseData["orderID"] ?? null;

            if ($orderID) {
                foreach ($_SESSION['cart'] as $item => $quantity) {
                    $orderListData = json_encode([
                        "orderID" => $orderID,
                        "storeInventoryItemID" => $item, 
                        "amountSold" => $quantity
                    ]);

                    $orderListApiUrl = "http://order-api:8003/orderID/$orderID/storeInventoryItemID/$item/amountSold/$quantity";

                    $ch2 = curl_init();
                    curl_setopt($ch2, CURLOPT_URL, $orderListApiUrl);
                    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch2, CURLOPT_POST, true);
                    curl_setopt($ch2, CURLOPT_POSTFIELDS, $orderListData);
                    curl_setopt($ch2, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json'
                    ]);
                    curl_exec($ch2);
                    curl_close($ch2);
                }

                $_SESSION['cart'] = [];
                $orderPlaced = true;
                $success_message = "✅ Thank you, " . htmlspecialchars($name) . "! Your order has been placed successfully.";
            } else {
                $error_message = "Failed to place order. Please try again.";
            }
        } else {
            $error_message = "Order API error. Please try again.";
        }
    }
}

$cart_size = count($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Order Confirmation</h2>

        <?php 
        if ($orderPlaced) {
            echo "<div class='alert alert-success'>" . $success_message . "</div>";
        }
        ?>

        <h4>Your Cart:</h4>
        <ul class="list-group">
            <?php 
            if ($cart_size == 0) {
                echo "<li class='list-group-item'>Your cart is empty.</li>";
            } else {
                $cart_keys = array(); 
                $cart_values = array();
                $index = 0;

                foreach ($_SESSION['cart'] as $item => $quantity) {
                    $cart_keys[$index] = $item;
                    $cart_values[$index] = $quantity;
                    $index++;
                }

                for ($i = 0; $i < $cart_size; $i++) {
                    echo "<li class='list-group-item'>" . htmlspecialchars($cart_keys[$i]) . " - Quantity: " . $cart_values[$i] . "</li>";
                }
            }
            ?>
        </ul>

        <hr>

        <h4>Shipping Details:</h4>
        <?php 
        if ($error_message !== "") {
            echo "<div class='alert alert-danger'>" . $error_message . "</div>";
        }
        ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" 
                value="<?php 
                if (isset($name)) { 
                    echo htmlspecialchars($name); 
                    } ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" 
                value="<?php 
                if (isset($email)) { echo htmlspecialchars($email); 
                } ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Shipping Address</label>
                <textarea name="address" class="form-control" rows="3" required>
                    <?php if (isset($address)) { echo htmlspecialchars($address); } ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>

        <a href="index.php" class="btn btn-secondary mt-3">Go Back</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
