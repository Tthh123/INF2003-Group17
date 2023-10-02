<?php

function get_products($names) {
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
        $sql = "SELECT name, brand, price, quantity, imageSrc, link, productid FROM products";
    } else if ($names === "random") {
        $sql = "SELECT name, brand, price, quantity, imageSrc, link, productid FROM products ORDER BY RAND() LIMIT 4";
    } else {
        $placeholders = implode(',', array_fill(0, count($names), '?'));
        $sql = "SELECT name, brand, price, quantity, imageSrc, link, productid FROM products WHERE name IN ($placeholders)";
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

    //generate the product card dynamically
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $_SESSION['productname_' . $row['productid']] = $row['name']; //generate to have unique productID
            
            echo '<div class="pro">';
            echo '<a href="masterdetailproduct.php?productid=' . $row['productid'] . '" onclick="event.preventDefault(); window.location.href = \'masterdetailproduct.php?productid=' . $row['productid'] . '\'">';
            echo '<img src="' . $row['imageSrc'] . '" alt="' . $row['name'] . '">';
            echo '</a>';
            echo '<div class="des">';
            echo '<span>' . $row['brand'] . '</span>';
            echo '<h5>' . $row['name'] . '</h5>';
            echo '<div class="star">';
            echo '<i class="fas fa-star"></i>';
            echo '<i class="fas fa-star"></i>';
            echo '<i class="fas fa-star"></i>';
            echo '<i class="fas fa-star"></i>';
            echo '<i class="fas fa-star"></i>';
            echo '</div>';
            if ($row['quantity'] <= 0) {
                echo '<h4>Out of stock</h4>';
                echo '<button class="add-to-cart" disabled><i class="fal fa-shopping-cart cart"></i></button>';
            } else {
                echo '<h4>$' . $row['price'] . '</h4>';
                echo '<h5>Quantity: ' . $row['quantity'] . '</h5>';

                if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
                    echo '<button onclick="sendNotification(\'notlogin\', \'You have to login first.\');" aria-label="Add to cart (requires login)">' .
                    '<i class="fal fa-shopping-cart cart" aria-hidden="true"></i></button>';

                    echo '<button onclick="sendNotification(\'notlogin\', \'You have to login first.\');" aria-label="Add to wishlist (requires login)">' .
                    '<i class="far fa-heart wishlist" aria-hidden="true"></i></button>';
                } else {
                    echo '<button onclick="sendNotification(\'success\', \'Added to cart!\'); addToCart(' . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . ', 1);" aria-label="Add to cart">' .
                    '<i class="fal fa-shopping-cart cart" aria-hidden="true"></i></button>';

                    echo '<button onclick="sendNotification(\'success\', \'Added to wishlist!\'); addToWishlist(' . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . ');" aria-label="Add to wishlist">' .
                    '<i class="far fa-heart wishlist" aria-hidden="true"></i></button>';
                }
            }

            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "No products found.";
    }
}
