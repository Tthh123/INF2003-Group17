<?php



function get_ordersforcart($email) {

    // Create database connection
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

    // Check connection
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    }

    // Retrieve products data from database
    $sql = "SELECT name, price, quantity, imgsrc, subtotal FROM cart WHERE email = ? AND order_id IS NULL";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        printf("Error: %s\n", $conn->error);
        exit();
    }

    // Bind parameter
    $stmt->bind_param("s", $email);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    //initialize total variable
    $total = 0;

    //generate the product details dynamically
    if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
        echo '<img src="img/log-in.png" style = "width:100px; height:100px; margin-left: 710px; margin-top:30px;"/>';
        echo '<div style="text-align:center; font-size:24px; margin-top:30px;">You have to login first.</div>';
        echo '<div style="text-align:center; font-size:24px; margin-top:20px;">You can do it! It just 10 seconds away.</div>';
        echo "<div class='icon user-icon d-flex justify-content-center'>";
        echo "<button class='btn btn-primary user-link cartwishbtn' href='#'>Login Now!</button>";
        echo "</div>";
    } else if ($result->num_rows > 0) {
        echo '<section id="cart" class="section-p1">
            <table width="100%">
                <thead>
                    <tr>
                        <td>Remove</td>
                        <td>Image</td>
                        <td>Product</td>
                        <td>Price</td>
                        <td>Quantity</td>
                        <td>Subtotal</td>
                    </tr>
                </thead>
                <tbody>';
        while ($row = $result->fetch_assoc()) {
            $imgsrc = $row['imgsrc'];
            $name = $row['name'];
            $price = $row['price'];
            $quantity = $row['quantity'];
            $subtotal = $row['subtotal'];
            $total += $subtotal; //update total
            $_SESSION['total'] = $total;

            echo "<tr data-name='$name'>
<td>
  <a href='#' class='delete-row' onclick='deleteRow(event, this)' aria-label='Delete Product Row'>
    <i class='far fa-times-circle'></i>
  </a>
</td>
            <td><img src='$imgsrc' alt='$name image'></td>
            <td>$name</td>
            <td>$$price</td>
            <td>$quantity</td>
            <td>$$subtotal</td>
            </tr>";
        }
        echo '</tbody></table></section>';

        echo'        
<section id="cart-add" class="section-p1">
    <div id="cuopon">
        <h3>Apply Coupon</h3>
        <div id="couponmessages">
';

        if (isset($_SESSION['error_message'])) {
            echo '<div class="carterror-message">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']); // Clear the error_message from the session
        }

        if (isset($_SESSION['success_message'])) {
            echo '<div class="cartsuccess-message">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']); // Clear the success_message from the session
        }

        echo '
        </div>
        
        <div>
            <form id="coupon-form" method="POST" action="validate_coupon.php">
                <input type="text" name="coupon_code" id="coupon_code" aria-label="Coupon code" placeholder="Enter Your Coupon" required>
                <button type="submit" class="normal">Apply</button>
            </form>
        </div>
    </div>
    

<div id="subtotal">
  <h3>Cart Totals</h3>
  <table>
    <thead>
      <tr>
        <th scope="col">Description</th>
        <th scope="col">Amount</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Cart Subtotal</td>
    <td>USD ' . (isset($_SESSION['newtotal']) ? number_format($_SESSION['newtotal'], 2) : number_format($total, 2)) . '</td>
      </tr>
      <tr>
        <td>Shipping</td>
        <td>Free</td>
      </tr>
      <tr>
        <td><strong>Total</strong></td>
    <td><strong>USD ' . (isset($_SESSION['newtotal']) ? number_format($_SESSION['newtotal'], 2) : number_format($total, 2)) . '</strong></td>
      </tr>
    </tbody>
  </table>
</div>

</section>
';

        if (isset($_SESSION['newtotal'])) {
            if (!isset($_SESSION['newtotalcheckout'])) {
                $_SESSION['newtotalcheckout'] = $_SESSION['newtotal'];
            }
            unset($_SESSION['newtotal']);
        }

        echo '
<div class="row mt-3 mx-3 black-text" style="margin-top:25px;">
    <div class="col-lg-12" style="margin-left: 50px;">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card card-custom pb-4">
                    <div class="card-body mt-0 mx-5">
                        <div id="shipping-details" class="text-center mb-3 pb-2 mt-3 shippingdetails">
                            <h4 style="color: #495057; font-size:30px;">Shipping Details</h4>
                        </div>
                            <form class="mb-0" method="post" action="process_orders.php">
                                <div class="row mb-4">
                                    <div class="col">
                                        <div class="form-outline">
                                            <label class="form-label" for="form9Example1">First name</label>
                                            <input type="text" id="form9Example1" name="first_name" class="form-control input-custom" placeholder="Enter your first name" required />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-outline">
                                            <label class="form-label" for="form9Example2">Last name</label>
                                            <input type="text" id="form9Example2" name="last_name" class="form-control input-custom" placeholder="Enter your last name" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col">
                                        <div class="form-outline">
                                            <label class="form-label" for="form9Example3">City</label>
                                            <input type="text" id="form9Example3" name="city" class="form-control input-custom" placeholder="Enter your city" required />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-outline">
                                            <label class="form-label" for="form9Example4">Zip</label>
                                            <input type="text" id="form9Example4" name="zip_code" class="form-control input-custom" placeholder="Enter your zip code" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col">
                                        <div class="form-outline">
                                            <label class="form-label" for="form9Example6">Address</label>
                                            <input type="text" id="form9Example6" name="address" class="form-control input-custom" placeholder="Enter your address" required /> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-center">
                                        <button type="submit" class="btn btn-primary btn-lg btn-rounded waves-effect waves-light">Proceed to checkout</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
    } else {
        echo '<img src="img/cart.png" style = "width:100px; height:100px; margin-left: 710px; margin-top:30px;"/>';
        echo '<div style="text-align:center; font-size:24px; margin-top:50px;">No items in the cart? That is like having a cake with no icing.</div>';
        echo '<div style="text-align:center; margin-top:25px;"><a href="shop.php" class="btn btn-primary btn-lg">Go to Shop</a></div>';
    }
}
