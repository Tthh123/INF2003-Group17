<?php
$page = 'admin'; // change this to match the name of the page
// Check if the user is an admin and redirect to login page if not
session_start();

if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Create database connection.
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    $success = false;
}

function sanitize_input($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}

// Read Product
if (isset($_POST['read'])) {
    $productname = sanitize_input($_POST['name']);
    $stmt = $conn->prepare("SELECT * FROM products WHERE name = ?");
    $stmt->bind_param("s", $productname);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $brand = $row['brand'];
        $quantity = $row['quantity'];
        $price = $row['price'];
        $link = $row['link'];
        $imageSrc = $row['imageSrc'];
        $description = $row['description']; // new
        $category = $row['category']; // new
        $success = true;
    } else {
        $errorMsg = "Product not found";
        $success = false;
    }
    $stmt->close();
}

// Retrieve all coupon codes from the database
$sql = "SELECT * FROM couponcode";
$result_couponcodes = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Groom & Go Admin</title>
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

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


        <!--Bootstrap JS--> 
        <script defer 
                src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" 
                integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" 
                crossorigin="anonymous">
        </script> 

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <script>
                    $(document).ready(function () {
                        // Disable the Submit button by default
                        $('#submitBtn').prop('disabled', true);

                        // When the user types in any of the form fields, check if all fields are filled in and Quantity/Price fields are numeric
                        $('#formfield').on('input', function () {
                            var allFilled = true;
                            $('input[type="text"], input[type="number"], textarea', this).each(function () {
                                if ($.trim($(this).val()) === '') {
                                    allFilled = false;
                                    return false;
                                }
                            });
                            if (allFilled && $.isNumeric($('#price').val()) && $.isNumeric($('#quantity').val())) {
                                $('#submitBtn').prop('disabled', false);
                                $('#validationMessage').text('');
                            } else {
                                $('#submitBtn').prop('disabled', true);
                                $('#validationMessage').text('Please fill in all fields and make sure Quantity/Price fields are numeric');
                            }
                        });

                        // Show confirmation dialog when user clicks the Submit button
                        $('#submitBtn').click(function () {
                            updateConfirmDialog();
                        });

                        // Submit form when user confirms
                        $('#submit').click(function () {
                            $('#formfield').submit();
                        });
                    });

                    function updateConfirmDialog() {
                        $('#nameVal').text($('#name').val());
                        $('#brandVal').text($('#brand').val());
                        $('#priceVal').text($('#price').val());
                        $('#quantityVal').text($('#quantity').val());
                        $('#imageVal').text($('#imageSrc').val());
                        $('#linkVal').text($('#link').val());
                        $('#descVal').text($('#description').val());
                        $('#categoryVal').text($('#category').val());
                    }

                    $(document).ready(function () {
                        if (<?php echo isset($_SESSION['product_created']) && $_SESSION['product_created'] ? 'true' : 'false' ?>) {
                            $('#successModal').modal('show');
                            setTimeout(function () {
                                $('#successModal').modal('hide');
                            }, 2000);
<?php unset($_SESSION['product_created']) ?>
                        }
                    });

                    $(document).ready(function () {
                        if (<?php echo isset($_SESSION['error_msg']) && $_SESSION['error_msg'] ? 'true' : 'false' ?>) {
                            $('#failModal').modal('show');
                            setTimeout(function () {
                                $('#failModal').modal('hide');
                            }, 4000);
<?php unset($_SESSION['error_msg']) ?>
                        }
                    });

                    $(document).ready(function () {
                        if (<?php echo isset($_SESSION['product_exists']) && $_SESSION['product_exists'] ? 'true' : 'false' ?>) {
                            $('#failModal1').modal('show');
                            setTimeout(function () {
                                $('#failModal1').modal('hide');
                            }, 4000);
<?php unset($_SESSION['product_exists']) ?>
                        }
                    });


                    $(document).ready(function () {
                        if (<?php echo isset($_SESSION['product_deleted']) && $_SESSION['product_deleted'] ? 'true' : 'false' ?>) {
                            $('#successModalDelete').modal('show');
                            setTimeout(function () {
                                $('#successModalDelete').modal('hide');
                            }, 4000);
<?php unset($_SESSION['product_deleted']) ?>
                        }
                    });

        </script>


        <script>
            $(document).ready(function () {

                // Function to display confirmation dialog
                function updateConfirmDialogupdate() {
                    $('#nameValupdate').text($('#nameupdate').val());
                    $('#brandValupdate').text($('#brandupdate').val());
                    $('#priceValupdate').text($('#priceupdate').val());
                    $('#quantityValupdate').text($('#quantityupdate').val());
                    $('#imageValupdate').text($('#imageSrcupdate').val());
                    $('#linkValupdate').text($('#linkupdate').val());
                    $('#descValupdate').text($('#descriptionupdate').val());
                    $('#categoryValupdate').text($('#categoryupdate').val());
                    $('#confirm-submitupdate').modal('show');
                }

                // Function to validate input fields
                function validateInputFields() {
                    // Check if required fields are empty
                    if ($('#nameupdate').val() === '' || $('#brandupdate').val() === '' || $('#priceupdate').val() === '' || $('#quantityupdate').val() === '') {
                        $('#validationMessage1').text('Please fill in all required fields. Price and quantity must be numeric.');
                        return false;
                    }

                    // Check if price and quantity are numeric
                    if (!$.isNumeric($('#priceupdate').val()) || !$.isNumeric($('#quantityupdate').val())) {
                        $('#validationMessage1').text('Price and quantity must be numeric.');
                        return false;
                    }

                    // Input is valid
                    $('#validationMessage1').text('');
                    return true;
                }

                // Handle input events to validate input fields
                $('#nameupdate, #brandupdate, #priceupdate, #quantityupdate').on('input', function () {
                    validateInputFields();
                });

                // Handle submit button click
                $('#submitBtnupdate').click(function () {
                    if (validateInputFields()) {
                        // All input is valid, proceed with confirmation dialog
                        updateConfirmDialogupdate();
                    }
                });

                // Handle confirm button click
                $('#confirmBtnupdate').click(function () {
                    $('#formfieldupdate').submit();
                });
            });

            $(document).ready(function () {
                if (<?php echo isset($_SESSION['product_updated']) && $_SESSION['product_updated'] ? 'true' : 'false' ?>) {
                    $('#successModalupdated').modal('show');
                    setTimeout(function () {
                        $('#successModalupdated').modal('hide');
                    }, 2000);
<?php unset($_SESSION['product_updated']) ?>
                }
            });

            $(document).ready(function () {
                if (<?php echo isset($_SESSION['product_not_exist']) && $_SESSION['product_not_exist'] ? 'true' : 'false' ?>) {
                    $('#failModalupdated').modal('show');
                    setTimeout(function () {
                        $('#failModalupdated').modal('hide');
                    }, 4000);
<?php unset($_SESSION['product_not_exist']) ?>
                }
            });


        </script>
    </head>
    <body>
        <?php include('nav.inc.php'); ?>

        <section class="py-5 my-5">
            <div class="container">
                <h1 class="mb-5">Admin Page</h1>

                <?php
                if (isset($_SESSION['success_message'])) {
                    echo '<div role="alert" aria-label="Success message" class="alert alert-success">';
                    echo $_SESSION['success_message'];
                    echo '</div>';
                    unset($_SESSION['success_message']);
                }
                ?>

                <!-- Show error message if there is one -->
                <?php
                if (isset($_SESSION['error_message'])) {
                    echo '<div role="alert" aria-label="Error message" class="alert alert-danger">';
                    echo $_SESSION['error_message'];
                    echo '</div>';
                    unset($_SESSION['error_message']);
                }
                ?>


                <div class="bg-white shadow rounded-lg d-block d-sm-flex">
                    <div class="profile-tab-nav border-right">
                        <div class="p-4">
                            <div class="img-circle text-center mb-3">
                                <img src="img/user2.jpg" alt="Image" class="shadow">
                            </div>
                            <?php if (isset($_SESSION['fname']) && isset($_SESSION['lname'])) { ?>
                                <h4 class="text-center"><?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname']; ?></h4>
                            <?php } ?>

                        </div>

                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="notification-tab" data-toggle="pill" href="#list" role="tab" aria-controls="notification" aria-selected="false">
                                <i class="far fa-edit text-center mr-1"></i> 
                                Edit Existing Products
                            </a>
                            <a class="nav-link" id="account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="true">
                                <i class="fas fa-plus text-center mr-1"></i> 
                                Create Products
                            </a>
                            <a class="nav-link" id="password-tab" data-toggle="pill" href="#password" role="tab" aria-controls="password" aria-selected="false">
                                <i class="fas fa-exchange-alt text-center mr-1"></i> 
                                Replace Existing Products
                            </a>
                            <a class="nav-link" id="coupon-tab" data-toggle="pill" href="#coupon" role="tab" aria-controls="coupon" aria-selected="false">
                                <i class="fas fa-ticket-alt"></i>
                                Create Coupon Codes
                            </a>
                            <a class="nav-link" id="editcoupon-tab" data-toggle="pill" href="#editcoupon" role="tab" aria-controls="editcoupon" aria-selected="false">
                                <i class="far fa-list-alt"></i>
                                Edit Coupon Codes
                            </a>
                            <a class="nav-link" id="CustomerOrder-tab" data-toggle="pill" href="#customerorder" role="tab" aria-controls="customerorder" aria-selected="false">
                                <i class="far fa-receipt"></i>
                                Customer Orders
                            </a>
                        </div>
                    </div>

                    <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">

                        <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
                            <h3 class="mb-4">Create Product</h3>

                            <!-- Validation message element -->
                            <p id="validationMessage" style="color: red;"></p>

                            <!-- Create Product Form -->
                            <form id="formfield" action="process_create.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="name">Name</label><span class="label label-danger"></span>
                                    <input class="form-control" placeholder="Enter product name" name="name" id="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="brand">Brand</label><span class="label label-danger"></span>
                                    <input class="form-control" placeholder="Enter product brand" name="brand" id="brand" required>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label><span class="label label-danger"></span>
                                    <input type="number" class="form-control" placeholder="Enter product price" name="price" id="price" required min="1" step="0.01">
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label><span class="label label-danger"></span>
                                    <input type="number" class="form-control" placeholder="Enter product quantity" name="quantity" id="quantity" required min="1">
                                </div>

                                <div class="form-group">
                                    <label for="imageSrc">Image Source</label><span class="label label-danger"></span>
                                    <input type="text" class="form-control" placeholder="Enter Image Source URL" name="imageSrc" id="imageSrc" required>
                                </div>
                                <div class="form-group">
                                    <label for="link">Link</label><span class="label label-danger"></span>
                                    <input class="form-control" placeholder="Enter product link" name="link" id="link" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label><span class="label label-danger"></span>
                                    <textarea class="form-control" rows="5" placeholder="Enter product description" name="description" id="description" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="category">Category</label><span class="label label-danger"></span>
                                    <input class="form-control" placeholder="Enter product category" name="category" id="category" required>
                                </div>
                                <input type="hidden" name="action" value="add_form" >
                                <input type="button" name="btn" value="Submit" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-default" >
                                <input type="button" name="btn" value="Reset" onclick="window.location = 'admin.php'" class="btn btn-default" data-modal-type="confirm">
                            </form>



                        </div>

                        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">

                            <h3 class="mb-4">Replace Existing Product</h3>

                            <!-- Validation message element -->
                            <p id="validationMessage1" style="color: red;"></p>

                            <!-- Update Product Form -->
                            <form id="formfieldupdate" action="process_update.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="nameupdate">Name</label><span class="label label-danger"></span>
                                    <input class="form-control" placeholder="Enter product name" name="name" id="nameupdate" value="<?php echo $product['name']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="brandupdate">Brand</label><span class="label label-danger"></span>
                                    <input class="form-control" placeholder="Enter product brand" name="brand" id="brandupdate" value="<?php echo $product['brand']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="priceupdate">Price</label><span class="label label-danger"></span>
                                    <input type="number" placeholder="Enter product price" name="price" id="priceupdate" value="<?php echo $product['price']; ?>" required min="1" step="0.01">
                                </div>
                                <div class="form-group">
                                    <label for="quantityupdate">Quantity</label><span class="label label-danger"></span>
                                    <input type="number" placeholder="Enter product quantity" name="quantity" id="quantityupdate" value="<?php echo $product['quantity']; ?>" required min="1">
                                </div>
                                <div class="form-group">
                                    <label for="imageSrcupdate">Image Source</label><span class="label label-danger"></span>
                                    <input class="form-control" placeholder="Enter Image Source URL" name="imageSrc" id="imageSrcupdate" value="<?php echo $product['imageSrc']; ?>" required >
                                </div>
                                <div class="form-group">
                                    <label for="linkupdate">Link</label><span class="label label-danger"></span>
                                    <input class="form-control" placeholder="Enter product link" name="link" id="linkupdate" value="<?php echo $product['link']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="descriptionupdate">Description</label><span class="label label-danger"></span>
                                    <textarea class="form-control" rows="5" placeholder="Enter product description" name="description" id="descriptionupdate" required><?php echo $product['description']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="categoryupdate">Category</label><span class="label label-danger"></span>
                                    <input class="form-control" placeholder="Enter product category" name="category" id="categoryupdate" value="<?php echo $product['category']; ?>" required>
                                </div>
                                <input type="hidden" name="action" value="update_form" >
                                <input type="button" name="btn" value="Submit" id="submitBtnupdate" data-toggle="modal" data-target="#confirm-submitupdate" class="btn btn-default" >
                                <input type="button" name="btn" value="Reset" onclick="window.location = 'admin.php'" class="btn btn-default" data-modal-type="confirm">
                            </form>

                        </div>

                        <!-- List Products -->
                        <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
                            <h3 class="mb-4">Product Lists</h3>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="search">Search by Category or Product Name:</label>
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Type 'all' to display all products">
                                </div>

                                <input type="submit" value="Search" name="search_submit" class="btn btn-primary">
                            </form>

                            <?php
                            if (isset($_POST['search_submit'])) {
                                $search = sanitize_input($_POST['search']);
                                if ($search == "all") {
                                    $stmt = $conn->prepare("SELECT * FROM products");
                                } else {
                                    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ? OR category LIKE ?");
                                    $searchTerm = "%" . $search . "%";
                                    $stmt->bind_param("ss", $searchTerm, $searchTerm);
                                }
                                $stmt->execute();
                                $result = $stmt->get_result();
                            } else {
                                $stmt = $conn->prepare("SELECT * FROM products");
                                $stmt->execute();
                                $result = $stmt->get_result();
                            }

                            // Display products in a table
                            if ($result->num_rows > 0) {
                                echo '<table class="table table-bordered">';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th>Image</th>';
                                echo '<th>Name</th>';
                                echo '<th>Category</th>';
                                echo '<th>Quantity</th>';
                                echo '<th>Update Quantity</th>';
                                echo '<th>Delete Product</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';
                                $counter = 1;
                                while ($row = $result->fetch_assoc()) {
                                    $form_id = 'delete-form-' . $counter;
                                    $modal_id = 'deleteModal-' . $counter;
                                    echo '<tr>';
                                    echo '<td><img src="' . $row['imageSrc'] . '" alt="' . $row['name'] . ' image" height="50"></td>';
                                    echo '<td>' . $row['name'] . '</td>';
                                    echo '<td>' . $row['category'] . '</td>';
                                    echo '<td>' . $row['quantity'] . '</td>';
                                    echo '<td>
                                        <form action="process_updatequantity.php" method="post">
                                            <input type="hidden" name="name" value="' . $row['name'] . '">
                                            <input type="number" name="quantity" value="' . $row['quantity'] . '">
                                            <input type="submit" value="Update" name="update_quantity" class="btn btn-primary">
                                        </form>
                                    </td>';
                                    echo '<td>
                                    <form action="process_delete.php" method="post" id="' . $form_id . '">
                                            <input type="hidden" name="name" value="' . $row['name'] . '">
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#' . $modal_id . '">Delete</button>

                                            <div class="modal fade" id="' . $modal_id . '" tabindex="-1" aria-labelledby="deleteModalLabel-' . $form_id . '" aria-hidden="true">
                                              <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel-' . $form_id . '">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete ' . $row['name'] . '? This action cannot be undone and may affect any customer shopping carts or wishlists that include this product.
                                                </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="button" class="btn btn-danger" onclick="document.getElementById(\'delete-form-' . $counter . '\').submit();">Delete</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                        </form>
                                    </td>';
                                    echo '</tr>';
                                    $counter++;
                                }
                                echo '</tbody>';
                                echo '</table>';
                            } else {
                                echo '<p>No products found</p>';
                            }
                            $stmt->close();
                            ?>
                        </div>

                        <div class="tab-pane fade" id="coupon" role="tabpanel" aria-labelledby="coupon-tab">
                            <h3 class="mb-4">Create Coupon Code</h3>

                            <!-- Create Coupon Form -->
                            <form role="form" id="formfield" action="process_couponcode.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="coupon_name">Coupon Name</label><span class="label label-danger"></span>
                                    <input type="text" class="form-control" placeholder="Enter coupon name" name="coupon_name" id="coupon_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="coupon_percentage">Coupon Percentage</label><span class="label label-danger"></span>
                                    <input type="number" class="form-control" placeholder="Enter coupon percentage without %. E.g. 30.5 means 30.5% Discount" name="coupon_percentage" id="coupon_percentage" required pattern="\d+(\.\d+)?" title="Please enter a numeric value for the coupon percentage." aria-describedby="coupon_percentage_help">
                                    <small id="coupon_percentage_help" class="form-text text-muted">Please enter a numeric value for the coupon percentage.</small>
                                </div>
                                <input type="submit" name="btn" value="Create Coupon" class="btn btn-primary" />
                            </form>

                        </div>

                        <div class="tab-pane fade" id="editcoupon" role="tabpanel" aria-labelledby="editcoupon-tab">
                            <!-- Display coupon codes in a table -->
                            <h3 class="mb-4 mt-4">Existing Coupon Codes</h3>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Coupon Name</th>
                                        <th>Percentage</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result_couponcodes->num_rows > 0): ?>
                                        <?php while ($row = $result_couponcodes->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo $row['couponcodename']; ?></td>
                                                <td><?php echo $row['percentage']; ?>%</td>
                                                <td>
                                                    <form action="process_deletecoupon.php" method="post">
                                                        <input type="hidden" name="couponcodename" value="<?php echo $row['couponcodename']; ?>">
                                                        <input type="submit" name="delete_coupon" value="Delete" class="btn btn-danger">
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3">No coupon code found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>



                        <div class="tab-pane fade" id="customerorder" role="tabpanel" aria-labelledby="CustomerOrder-tab">
                            <h3 class="mb-4">All Orders By Customers</h3>

                            <form method="post" action="">
                                <label for="searchOrderId">Enter Order ID:</label>
                                <input type="text" name="searchOrderId" id="searchOrderId" placeholder="e.g. ORDER1680051858993356">
                                <button type="submit" name="searchBtn" class="btn btn-primary">Search</button>
                            </form>

                            <hr>

                            <?php
                            include 'cart_summary.php';
                            ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <p>Total number of orders: <?php echo $num_orders; ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p>Total Revenue: $<?php echo $total_sum; ?></p>
                                </div>
                            </div>

                            <hr>
                            <?php
                            // Include the trackorders.php file
                            if (($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['searchBtn'])) || $_SERVER['REQUEST_METHOD'] === 'GET') {
                                include 'process_allorder.php';
                            }
                            ?>

                        </div>





                    </div>
                </div>
        </section> 


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

        <!-- ----------------------------------------------Confirm Create Modal --------------------------------------------->
        <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        Confirm Submit
                    </div>
                    <div class="modal-body">
                        Are you sure you want to submit the following details?
                        <table class="table">
                            <tr>
                                <th>Name</th>
                                <td id="nameVal"></td>
                            </tr>
                            <tr>
                                <th>Brand</th>
                                <td id="brandVal"></td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td id="priceVal"></td>
                            </tr>
                            <tr>
                                <th>Quantity</th>
                                <td id="quantityVal"></td>
                            </tr>
                            <tr>
                                <th>Image</th>
                                <td id="imageVal"></td>
                            </tr>
                            <tr>
                                <th>Link</th>
                                <td id="linkVal"></td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td id="descVal"></td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td id="categoryVal"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="submit" id="submit" class="btn btn-success success">Yes</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Modal for CREATE -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Product created successfully!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="fas fa-check-circle fa-4x text-success"></i>
                        </div>
                        <div class="text-center mt-3">
                            <p>Your product has been created successfully.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fail Modal for CREATE -->
        <div class="modal fade" id="failModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <?php echo isset($_SESSION['error_msg']) ? 'Invalid input' : 'Invalid input!'; ?>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="fas fa-times-circle fa-4x text-danger"></i>
                        </div>
                        <div class="text-center mt-3">
                            <p>Your product can't be created.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fail Modal for CREATE -->
        <div class="modal fade" id="failModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Product name already existed!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="fas fa-times-circle fa-4x text-danger"></i>
                        </div>
                        <div class="text-center mt-3">
                            <p>Your product can't be created.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Confirm Update Modal -->
        <div class="modal fade" id="confirm-submitupdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        Confirm Update
                    </div>
                    <div class="modal-body">
                        Are you sure you want to update the following details?
                        <table class="table">
                            <tr>
                                <th>Name</th>
                                <td id="nameValupdate"></td>
                            </tr>
                            <tr>
                                <th>Brand</th>
                                <td id="brandValupdate"></td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td id="priceValupdate"></td>
                            </tr>
                            <tr>
                                <th>Quantity</th>
                                <td id="quantityValupdate"></td>
                            </tr>
                            <tr>
                                <th>Image</th>
                                <td id="imageValupdate"></td>
                            </tr>
                            <tr>
                                <th>Link</th>
                                <td id="linkValupdate"></td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td id="descValupdate"></td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td id="categoryValupdate"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" id="confirmBtnupdate" class="btn btn-success">Update</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirm Update Success Modal -->
        <div class="modal fade" id="successModalupdated" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Product updated successfully!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="fas fa-check-circle fa-4x text-success"></i>
                        </div>
                        <div class="text-center mt-3">
                            <p>Your product has been updated successfully.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Fail Modal for UPDATE -->
        <div class="modal fade" id="failModalupdated" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Product name don't existed!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="fas fa-times-circle fa-4x text-danger"></i>
                        </div>
                        <div class="text-center mt-3">
                            <p>Your product can't be updated.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- success Modal for Delete -->
        <div class="modal fade" id="successModalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Product deleted successfully!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="fas fa-check-circle fa-4x text-success"></i>
                        </div>
                        <div class="text-center mt-3">
                            <p>Your product is deleted.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script>

        </script>
    </body>
</html>