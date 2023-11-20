<?php
include('nav.inc.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Groom & Go</title>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> 
        <link rel="stylesheet" href="style.css">

        <!-- ====== Custom Js ====== -->
        <script defer src="script.js"></script>

        <!-- ====== Boxicons ====== -->
        <link
            href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css"
            rel="stylesheet"
            />
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

        <title>Search Results</title>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
                margin-top: 20px;
            }

            th, td {
                text-align: left;
                padding: 8px;
                border-bottom: 1px solid #ddd;
            }

            th {
                background-color: #f2f2f2;
                font-weight: bold;
            }

            img {
                max-width: 100%;
                height: auto;
            }

        </style>
    </head>
    <body>
        <?php
        // get the search term from the form input and sanitize it
        $searchTerm = filter_input(INPUT_GET, 'Search', FILTER_SANITIZE_STRING);

        // establish database connection
        $config = parse_ini_file('../../private/db-config.ini');
        $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

            // check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (!empty($searchTerm)) {
            // sanitize the search term and create query
            $searchTerm = mysqli_real_escape_string($conn, $searchTerm);
            $query = "SELECT * FROM products WHERE name LIKE '%$searchTerm%'";
        } elseif (strtolower($searchTerm) === "all") {
            // Display all products
            $query = "SELECT * FROM products";
        } else {
            echo "Please enter a search term.";
            exit();
        }

        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo '<div class="container">';
            echo "<table>";
            echo "<tr><th>Name</th><th>Price</th><th>Brand</th><th>Quantity</th><th>Image</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                echo "<td>" . htmlspecialchars($row['brand']) . "</td>";
                echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                echo "<td><img src='" . htmlspecialchars($row['imageSrc']) . "' width='150' height='150'></td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        } else {
            echo "No product found. Try typing a name.";
        }

// close database connection
        mysqli_close($conn);
        ?>


        <br><br><br><br><br>
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>
