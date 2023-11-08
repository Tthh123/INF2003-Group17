<?php

function get_products($type = 'recommended') {
    // Create database connection
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

    // Check connection
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    }

    // If 'random' type is requested, get 4 random products
    if ($type === 'random') {
        $sql = "SELECT name, brand, price, quantity, imageSrc, link, productid FROM products ORDER BY RAND() LIMIT 4";
        $stmt = $conn->prepare($sql);
    } else {

        if (!empty($_SESSION['email'])) {
            $email = $_SESSION['email'];

            // Check for the user's recent cart items with a non-empty "order_id"
            $sqla = "SELECT name FROM cart WHERE email = ? AND order_id IS NOT NULL LIMIT 4";
            $stmt = $conn->prepare($sqla);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            // Create an array to store personalized product recommendations
            $personalizedProducts = array();

            while ($row = $result->fetch_assoc()) {
                $personalizedProducts[] = $row['name'];
            }

            // Check if the array for the user has two or fewer elements in their recent purchase
            if (count($personalizedProducts) <= 2) {

                // Display top 4 most popular items from the cart table by counting the number of identical names in 'name' column
                // and summing the quantity for items with non-null 'order_id'
                $sql = "SELECT name, COUNT(*) AS popularity, SUM(quantity) AS total_quantity FROM cart WHERE order_id IS NOT NULL GROUP BY name ORDER BY popularity DESC, total_quantity DESC LIMIT 4";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                // Create array to store the popular products
                $popularProducts = array();
                while ($row = $result->fetch_assoc()) {
                    $popularProducts[] = $row['name'];
                }

                // If there are at least 4 unique items, prepare a SQL to select their details from the products table
                if (count($popularProducts) >= 4) {
                    $in = str_repeat('?,', count($popularProducts) - 1) . '?';
                    $sql = "SELECT name, brand, price, quantity, imageSrc, link, productid FROM products WHERE name IN ($in)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param(str_repeat('s', count($popularProducts)), ...$popularProducts);
                } else {
                    // Display random 4 items if the cart does not have at least 4 unique items
                    $sql = "SELECT name, brand, price, quantity, imageSrc, link, productid FROM products ORDER BY RAND() LIMIT 4";
                    $stmt = $conn->prepare($sql);
                }
            } else {

                // Create a list of question mark placeholders for the array elements
                $placeholders = implode(',', array_fill(0, count($personalizedProducts), '?'));

                // Construct the SQL query using the placeholders
                $sql = "SELECT name, brand, price, quantity, imageSrc, link, productid FROM products WHERE name IN ($placeholders)";

                // Prepare the SQL statement
                $stmt = $conn->prepare($sql);

                // Generate a type definition string for bind_param (one 's' for each product name)
                $types = str_repeat('s', count($personalizedProducts));

                // Bind the product names array to the statement using the generated types
                $stmt->bind_param($types, ...$personalizedProducts);
            }
        } else {

            // Display top 4 most popular items from the cart table for non-logged-in users
            // using the updated SQL query that includes the 'order_id' condition and 'quantity' sum
            $sql = "SELECT name, COUNT(*) AS popularity, SUM(quantity) AS total_quantity FROM cart WHERE order_id IS NOT NULL GROUP BY name ORDER BY popularity DESC, total_quantity DESC LIMIT 4";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            // Create array to store the popular products
            $popularProducts = array();
            while ($row = $result->fetch_assoc()) {
                $popularProducts[] = $row['name'];
            }


            // If there are at least 4 unique items, prepare a SQL to select their details from the products table
            if (count($popularProducts) >= 4) {
                $in = str_repeat('?,', count($popularProducts) - 1) . '?';
                $sql = "SELECT name, brand, price, quantity, imageSrc, link, productid FROM products WHERE name IN ($in)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param(str_repeat('s', count($popularProducts)), ...$popularProducts);
            } else {
                // Display random 4 items if the cart does not have at least 4 unique items
                $sql = "SELECT name, brand, price, quantity, imageSrc, link, productid FROM products ORDER BY RAND() LIMIT 4";
                $stmt = $conn->prepare($sql);
            }
        }
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
