<?php
session_start();

include 'process_products.php';
include "process_productsdetails.php";
?>

<div class="notification-box flex items-center justify-center">
    <!-- Notification container -->
</div>


<section id="header">
    <a href="index.php"><img src="img/groomgologo.png" class="logo" alt="Groomandgo company logo" width="90" height="70"></a>


    <div>
        <ul id="navbar">
            <li><a <?php
                if ($page == 'index') {
                    echo 'class="active"';
                }
                ?> href="index.php" aria-label="Home page">Home</a></li>
            <li><a <?php
                if ($page == 'shop') {
                    echo 'class="active"';
                }
                ?> href="shop.php" aria-label="Shop page">Shop</a></li>
                <?php if (isset($_SESSION['email'])) { ?>
                <li><a <?php
                    if ($page == 'profile') {
                        echo 'class="active"';
                    }
                    ?> href="accountsetting.php" aria-label="User profile page">Profile</a></li>
                <?php } ?>

            <?php if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'admin') { ?>
                <li><a <?php
                    if ($page == 'admin') {
                        echo 'class="active"';
                    }
                    ?> href="admin.php">Admin</a></li>
                <?php } ?>

            <?php if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'admin') { ?>
                <li><a <?php
                    if ($page == 'reviews') {
                        echo 'class="active"';
                    }
                    ?> href="sqlreviewsmanagement.php">SQL Reviews</a></li>
                <?php } ?>

            <?php if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'admin') { ?>
                <li><a <?php
                    if ($page == 'nosqlreviews') {
                        echo 'class="active"';
                    }
                    ?> href="mongoreviewsmanagement.php">NoSQL Reviews</a></li>
                <?php } ?>

            <?php if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'admin') { ?>
                <li><a <?php
                    if ($page == 'submitreviews') {
                        echo 'class="active"';
                    }
                    ?> href="reviews.php">Submit Reviews</a></li>
                <?php } ?>


            <li><a <?php
                if ($page == 'about') {
                    echo 'class="active"';
                }
                ?> href="about.php" aria-label="About page">About</a></li>
            <li><a <?php
                if ($page == 'contact') {
                    echo 'class="active"';
                }
                ?> href="contact.php" aria-label="Contact page">Contact</a></li>

            <?php if (isset($_SESSION['email'])) { ?>
                <li class="icons d-flex">
                    <div class="icon logout-link d-flex">
                        <a id="logout" class="logout-link" href="process_logout.php">Logout</a>
                    </div>
                </li>
            <?php } else { ?>
                <li class="icons d-flex">
                    <div class="icon user-icon d-flex">
                        <a class="user-link" href="#">Login</a>
                    </div>
                </li>
            <?php } ?>

            <li id="lg-bag"><a <?php
                if ($page == 'cart') {
                    echo 'class="active"';
                }
                ?> href="cart.php" aria-label="Shopping Cart"><i class="far fa-shopping-bag" alt="Shopping Bag Icon"></i></a></li>

            <li id="lg-wishlist"><a <?php
                if ($page == 'wishlist') {
                    echo 'class="active"';
                }
                ?> href="wishlist.php" aria-label="Wishlist"><i class="far fa-heart" alt="Heart Icon"></i></a></li>
        </ul>
    </div>


    <div id="mobile">
        <a href="cart.php"><i class="far fa-shopping-bag"></i></a>
        <i id="bar" class="fas fa-outdent"></i>
    </div>
</section>

<script>
    document.getElementById("logout").addEventListener("click", function (event) {
        document.cookie = "remember_email=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    });
</script>