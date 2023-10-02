<?php

function get_productsdetails($names) {
    // Create database connection
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

    // Check connection
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    }

    // Retrieve products data from database
    if (empty($names)) {
        $sql = "SELECT name, brand, category, description, price, quantity, imageSrc, link FROM products";
    } else {
        $placeholders = implode(',', array_fill(0, count($names), '?'));
        $sql = "SELECT name, brand, category, description, price, quantity, imageSrc, link FROM products WHERE name IN ($placeholders)";
    }

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters, if any
    if (!empty($names)) {
        $stmt->bind_param(str_repeat('s', count($names)), ...$names);
    }

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

//generate the product details dynamically
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <section id="prodetails" class="section-p1">
                <div class="single-pro-image">
                    <img src="<?php echo $row['imageSrc']; ?>" width="100%" id="MainImg" alt="">
                </div>

                <div class="single-pro-details">
                    <h5><?php echo $row['brand'] . ' / ' . $row['category']; ?></h5>
                    <h2><?php echo $row['name']; ?></h2>
                    <h5>$<?php echo $row['price']; ?></h5>
                    <h4>Quantity Left: <?php echo $row['quantity']; ?></h4>
                    <?php if ($row['quantity'] <= 0) { ?>
                        <h4 class="out-of-stock">Out of stock</h4>
                        <h3>We will be restocking soon!</h3>
                    <?php } else if (!isset($_SESSION['email']) || empty($_SESSION['email'])) { ?>
                        <div class="add-to-cart-container">
                            <label for="inputQuantity" class="visually-hidden">Quantity</label>
                            <input type="number" id="inputQuantity" name="quantity" min="1" placeholder="1" oninput="enforceNonNegativeValue(this);" aria-label="Enter Quantity">
                            <button class="add-to-cart" onclick="sendNotification('notlogin', 'You have to login first.');">Add To Cart</button>
                        </div>
                    <?php } else { ?>
                        <div class="add-to-cart-container">
                            <input type="number" id="inputQuantity" name="quantity" min="1" placeholder="1" oninput="enforceNonNegativeValue(this);">
                            <button class="add-to-cart" onclick="sendNotification('success', 'Added to cart!'); addToCart(<?php echo htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); ?>, document.getElementById('inputQuantity').value);">Add To Cart</button>
                        </div>

                    <?php } ?>

                    <h4>Product Details</h4>
                    <span><?php echo $row['description']; ?></span>
                </div>

            </section>
            <?php
        }
    } else {
        echo "No products found.";
    }
}
