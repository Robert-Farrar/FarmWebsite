<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_POST['add_to_cart'])) {
    $item = $_POST['item'];

    if (isset($_SESSION['cart'][$item])) {
        $_SESSION['cart'][$item] = $_SESSION['cart'][$item] + 1;
    } else {
        $_SESSION['cart'][$item] = 1; 
    }
}

if (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_POST['checkout'])) {
    header("Location: orderConfirmation.php");
    exit();
}

$cartCount = 0;
foreach ($_SESSION['cart'] as $quantity) {
    $cartCount = $cartCount + $quantity;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LionOrder Salads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#">LionOrder Salads</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                </ul>
                <form class="d-flex">
                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#cartModal">
                        <i class="bi-cart-fill me-1"></i>
                        Cart <span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo $cartCount; ?></span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Product Section -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <!-- Lettuce -->
                <div class="col mb-5">
                    <div class="card h-100">
                        <img class="card-img-top" src="pngtree-stacked-lettuce-leaves-png-image_5508541.png" alt="Lettuce">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <h5 class="fw-bolder">Lettuce</h5>
                                <p>$1.00</p>
                            </div>
                        </div>
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <form method="post">
                                    <input type="hidden" name="item" value="Lettuce">
                                    <button type="submit" name="add_to_cart" class="btn btn-outline-dark mt-auto">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tomatoes -->
                <div class="col mb-5">
                    <div class="card h-100">
                        <img class="card-img-top" src="pngimg.com - tomato_PNG12589.png" alt="Tomatoes">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <h5 class="fw-bolder">Tomatoes</h5>
                                <p>$1.00</p>
                            </div>
                        </div>
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <form method="post">
                                    <input type="hidden" name="item" value="Tomatoes">
                                    <button type="submit" name="add_to_cart" class="btn btn-outline-dark mt-auto">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col mb-5">
                    <div class="card h-100">
                        <img class="card-img-top" src="purepng.com-cucumbercucumbervegetablespicklegreenfoodhealthycucumbers-481522161925n6wbx.png" alt="Cucumber">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <h5 class="fw-bolder">Cucumber</h5>
                                <p>$1.00</p>
                            </div>
                        </div>
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <form method="post">
                                    <input type="hidden" name="item" value="Cucumber">
                                    <button type="submit" name="add_to_cart" class="btn btn-outline-dark mt-auto">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Your Shopping Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <?php
                        if (count($_SESSION['cart']) == 0) {
                            echo "<li class='list-group-item'>Your cart is empty.</li>";
                        } else {
                            foreach ($_SESSION['cart'] as $item => $quantity) {
                                echo "<li class='list-group-item'>" . $item . " - Quantity: " . $quantity . "</li>";
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="modal-footer">
                    <form method="post">
                        <button type="submit" name="clear_cart" class="btn btn-danger">Clear Cart</button>
                        <button type="submit" name="checkout" class="btn btn-success">Proceed to Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
