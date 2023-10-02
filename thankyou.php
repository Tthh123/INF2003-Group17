<!DOCTYPE html>
<html lang="en">
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
    </head>

<body>
  <div class="col-md-12" style="padding:0">
    <?php include('nav.inc.php'); ?>

    <?php
    // Retrieve the latest email address from the database
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT email FROM emails ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $row = mysqli_fetch_assoc($result);
      $dbEmail = $row['email'];
      ?>
      <div class="container message">
        <p>
          <?php echo "Welcome to the Groom & Go family! You're now part of a "
          . "community of hair enthusiasts who can't get enough of our products. "
                  . "Email sent successfully to " . $dbEmail; ?>
        </p>
        <a href="index.php" class="btn btn-primary">Return to Home</a> 
      </div>
      <?php
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      exit();
    }
    mysqli_close($conn); // close connection
    ?>

    <?php include('footer.inc.php'); ?>
  </div>
</body>


</html>