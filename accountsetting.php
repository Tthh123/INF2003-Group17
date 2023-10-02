<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Groom & Go Profile - Your one-stop-shop for all your haircare needs.">
        <title>Groom & Go Profile</title>
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
    $page = 'profile'; // change this to match the name of the page
    ?>

    <body>

        <?php
        include "nav.inc.php";
        ?>
        <section class="py-5 my-5">
            <div class="container">
                <h1 class="mb-5">Account Settings</h1>
                <div class="bg-white shadow rounded-lg d-block d-sm-flex">

                    <div class="profile-tab-nav border-right">
                        <div class="p-4">
                            <div class="img-circle text-center mb-3">
                                <img src="img/user2.jpg" alt="Profile picture of user" class="shadow">
                            </div>

                            <?php if (isset($_SESSION['fname']) && isset($_SESSION['lname'])) { ?>
                                <h4 class="text-center"><?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname']; ?></h4>
                            <?php } ?>

                        </div>
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="true">
                                <i class="fa fa-home text-center mr-1"></i> 
                                Account
                            </a>
                            <a class="nav-link" id="password-tab" data-toggle="pill" href="#password" role="tab" aria-controls="password" aria-selected="false">
                                <i class="fa fa-key text-center mr-1"></i> 
                                Password
                            </a>
                            <a class="nav-link" id="notification-tab" data-toggle="pill" href="#notification" role="tab" aria-controls="notification" aria-selected="false">
                                <i class="fa fa-bell text-center mr-1"></i> 
                                Track Order
                            </a>
                        </div>
                    </div>


                    <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">

                            <h3 class="mb-4">Account Settings</h3>

                            <?php
                            if (isset($_GET['error'])) {
                                echo '<div class="alert alert-danger" role="alert">' . $_GET['error'] . '</div>';
                            }
                            ?>

                            <?php
                            if (isset($_GET['success'])) {
                                echo '<div class="alert alert-success" role="alert">' . $_GET['success'] . '</div>';
                            }
                            ?>

                            <form action="process_accountsetting.php" method="POST">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fname_new">New First Name</label>
                                            <input type="text" class="form-control" id="fname_new" name="fname_new" placeholder="Enter your new first name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lname_new">New Last Name</label>
                                            <input type="text" class="form-control" id="lname_new" name="lname_new" placeholder="Enter your new last name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email_new">New Email</label>
                                            <input type="email" class="form-control" id="email_new" name="email_new" placeholder="Enter your new email" required>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-primary" type="submit" name="update_details">Update</button>
                                </div>
                            </form>

                        </div>

                        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">

                            <?php
                            if (isset($_GET['error'])) {
                                echo '<div class="alert alert-danger" role="alert">' . $_GET['error'] . '</div>';
                            }
                            ?>
                            <?php
                            if (isset($_GET['success'])) {
                                echo '<div class="alert alert-success" role="alert">' . $_GET['success'] . '</div>';
                            }
                            ?>

                            <form action="process_accountsetting.php" method="POST">
                                <h3 class="mb-4">Password Settings</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="old_password">Old password</label>
                                            <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Enter old password" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="new_password">New password</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="confirm_new_password">Confirm new password</label>
                                            <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" placeholder="Confirm new password" required>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-primary" type="submit" name="update_password">Update</button>
                                </div>
                            </form>

                        </div>

                        <div class="tab-pane fade" id="notification" role="tabpanel" aria-labelledby="notification-tab">
                            <h3 class="mb-4">Orders History</h3>

                            <?php
                            // Include the trackorders.php file
                            include 'process_trackorder.php';
                            ?>

                        </div>
                    </div>
                </div>
        </section>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

        <script>
                    var userType = '<?php echo $_SESSION["usertype"]; ?>';
        </script>

        <?php
        include "footer.inc.php";
        ?>


        <!-- Order Details Modal -->
        <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                    </div>
                    <div class="modal-body">
                        <div id="orderDetailsContent"></div>
                    </div>
                </div>
            </div>
        </div>

    </body>

</html>