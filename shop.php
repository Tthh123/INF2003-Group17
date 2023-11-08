<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Groom & Go Shop - Hair Care Products for Everyone</title>
        <meta name="description" content="Groom & Go Shop offers high-quality hair care products for everyone. Browse our selection of hair wax, brush, shampoo, and more. Shop now and get free shipping on orders over $50.">
        <meta name="keywords" content="hair care products, hair wax, hair brush, hair shampoo, Groom & Go Shop">
        <meta name="author" content="Your Name or Company Name">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> 
        <link rel="stylesheet" href="style.css">

        <!-- ====== Custom Js ====== -->
        <script defer src="script.js"></script>

        <!-- ====== Boxicons ====== -->
        <link
            href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css"
            rel="stylesheet"
            >
        <!--jQuery--> 
        <script defer 
                src="https://code.jquery.com/jquery-3.4.1.min.js" 
                integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" 
                crossorigin="anonymous">
        </script> 

        <!--Bootstrap JS--> 
        <script defer 
                src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" 
                integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" 
                crossorigin="anonymous">
        </script>
    </head>
    
    <?php
    $page = 'shop';

    $searchTerm = filter_input(INPUT_GET, 'Search', FILTER_SANITIZE_STRING);

    // Retrieve categories of the products from the database
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT DISTINCT category FROM products";
    $result = $conn->query($sql);
    $categories = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row['category'];
        }
        // Add 'All' category to the list
        $categories[] = 'All';
    }
    $conn->close();

    // Retrieve all products from the database
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

     // Retrieve all products from the database, filtered by category if applicable
    if (isset($_GET['category']) && $_GET['category'] != 'All') {
        $category = $_GET['category'];
        $sql = "SELECT * FROM products WHERE category='$category'";
    } else if (isset($_GET['Search'])) {
        $search_input = $_GET['Search'];
        if (empty($search_input)) {
            $alert_message = "Please enter a search term.";
        } else {
            $sql = "SELECT * FROM products WHERE name LIKE '%$searchTerm%'";
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {
                echo "<h4>No products found.</h4>";
            }
        }
    } else {
        $sql = "SELECT * FROM products";
    }

    $result = $conn->query($sql);

    $products = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    $conn->close();
    ?>

    <body>
        <div class="col-md-12" style="padding:0">
            <?php
            include('nav.inc.php');
            ?>

            <section id="page-header">
                <h2>#Hairspiration</h2>
                <p>Save more with coupons & up to 70% off!</p>
            </section>

            <br>    
            <div class="container-fluid">
                <div class="row justify-content-end">
                    <div class="col-4">
                        <form class="form-inline" action="shop.php" method="GET">
                            <div class="input-group">
                                <label for="search" class="sr-only">Search for products</label>
                                <input type="text" class="form-control" placeholder="Search" id="search" name="Search" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                        <span class="sr-only">Search</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <div class="row" style="margin:0">
                <div class="col-md-3">
                    <div class="cat">Categories</div>
                    <ul class="list-group">
                        <?php foreach ($categories as $category) { ?>
                            <li class="list-group-item">
                                <?php if ($category == 'All') { ?>
                                    <a href="?" style="color: black">All</a>
                                <?php } else { ?>
                                    <a href="?category=<?php echo $category; ?>" style="color: black"><?php echo $category; ?></a>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

                <div class="col-md-9">
                    <section id="product1" class="section-p1">
                        <div class="pro-container">
                            <?php if (isset($category)) { ?>
                                <?php
                                $category = $_GET['category'] ?? "All";
                                if ($category == "All") {
                                    $category_heading = "All Products";
                                } else {
                                    $category_heading = "Products in " . $category;
                                }
                                ?>

                                <h3><?php echo $category_heading; ?></h3>

                                <div class="row">
                                    <?php foreach ($products as $product) { ?>
                                        <div class="pro col-md-3 mb-3">
                                            <img src="<?php echo $product['imageSrc']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>" onclick="event.preventDefault(); window.location.href = 'masterdetailproduct.php?productid=<?php echo $product['productid']; ?>'">
                                            <div class="des card-body">
                                                <span><?php echo $product['brand']; ?></span>
                                                <h5 class="card-title"> <?php echo $product['name']; ?></h5>
                                                <div class="star">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <?php
                                                if ($product['quantity'] == 0) {
                                                    echo '<h4>Out of stock</h4>';
                                                    echo '<button class="add-to-cart" disabled aria-label="Add to cart button" tabindex="-1"><i class="fal fa-shopping-cart cart"></i></button>';
                                                    echo '<button class="add-to-cart" disabled aria-label="Add to wishlist button" tabindex="-1"><i class="far fa-heart wishlist"></i></button>';
                                                } else {
                                                    echo '<h4>$' . $product['price'] . '</h4>';
                                                    echo '<h5>Quantity: ' . $product['quantity'] . '</h5>';

                                                    if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
                                                        echo '<button onclick="sendNotification(\'notlogin\', \'You have to login first.\');" aria-label="Add to cart button - Login required" tabindex="0">' .
                                                        '<i class="fal fa-shopping-cart cart"></i></button>';

                                                        echo '<button onclick="sendNotification(\'notlogin\', \'You have to login first.\');" aria-label="Add to wishlist button - Login required" tabindex="0">' .
                                                        '<i class="far fa-heart wishlist"></i></button>';
                                                    } else {
                                                        echo '<button onclick="sendNotification(\'success\', \'Added to cart!\'); addToCart(' . htmlspecialchars(json_encode($product), ENT_QUOTES, 'UTF-8') . ', 1);" aria-label="Add to cart button" tabindex="0">' .
                                                        '<i class="fal fa-shopping-cart cart"></i></button>';

                                                        echo '<button onclick="sendNotification(\'success\', \'Added to wishlist!\'); addToWishlist(' . htmlspecialchars(json_encode($product), ENT_QUOTES, 'UTF-8') . ');" aria-label="Add to wishlist button" tabindex="0">' .
                                                        '<i class="far fa-heart wishlist"></i></button>';
                                                    }
                                                }
                                                ?>

                                            </div>
                                        </div>

                                    <?php } ?>
                                </div>

                            <?php } else { ?>
                                <h3>All Products</h3>
                                <p>Please select a category to view products.</p>
                            <?php } ?>
                        </div>
                    </section>
                </div>
            </div>

            <section id="feature" class="section-p1">
                <div class="fe-box">
                    <img src="img/features/f1.png" alt="">
                    <h6>Free Shipping</h6>
                </div>
                <div class="fe-box">
                    <img src="img/features/f2.png" alt="">
                    <h6>Next Day Delivery</h6>
                </div>
                <div class="fe-box">
                    <img src="img/features/f3.png" alt="">
                    <h6>Low Price</h6>
                </div>
                <div class="fe-box">
                    <img src="img/features/f6.png" alt="">
                    <h6>Buyer Protection</h6>
                </div>
                <div class="fe-box">
                    <img src="img/features/f5.png" alt="">
                    <h6>Premium Quality Guarantee</h6>
                </div>
            </section>

            <section id="banner" class="section-m1">
                <h4>We got you! Try HAIR20</h4>
                <h2>Up to <span>70% Off</span> – All Hair Products</h2>
                <button class="normal" onclick="window.location.href = 'shop.php';">Explore More</button>
            </section> 

            <?php
            include "footer.inc.php";
            ?>
        </div>
    </body>
</html>