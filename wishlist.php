<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Groom &amp; Go Wishlist - Your Favorite Hair Products</title>
        <meta name="description" content="Browse and manage your favorite hair products with Groom &amp; Go's wishlist feature. Add items to your wishlist and keep track of them for future purchases.">
        <meta name="keywords" content="hair products, wishlist, favorites, grooming, Groom &amp; Go">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" >
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
    $page = 'wishlist'; // change this to match the name of the page
    include "nav.inc.php";
    $email = $_SESSION['email'];
    ?>

    <body>

        <section id="page-header" class="about-header">

            <h2>#wishlist</h2>
            <p>Create your dream shopping list and never miss out on your favorite items again!</p>

        </section>


        <?php include 'process_wishlist.php'; ?>
        <?php get_ordersforwishlist($email); ?>


        <?php
        include "newsletter.inc.php";
        ?>

        <?php
        include "footer.inc.php";
        ?>  

    </body>

</html>