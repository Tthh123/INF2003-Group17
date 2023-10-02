<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Groom & Go</title>
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
        <?php
        include "nav.inc.php";
        ?>

        <section id="page-header" class="about-header">

            <h2>#checkout</h2>
            <p>You are 30 seconds away from completing your order!</p>

        </section>

        <div class="container py-5">

            <div class="row mb-4">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4">Choose Your Payment Method</h1>
                    <p class="lead mb-0">Select the payment method that works best for you</p>
                    <p class="lead">We accept all major credit cards through PayPal, and bank transfers.</p>
                </div>
            </div>

            <!-- End -->


            <div class="row">
                <div class="col-lg-7 mx-auto">
                    <div class="bg-white rounded-lg shadow-sm p-5">

                        <!-- Credit card form tabs -->
                        <ul role="tablist" class="nav bg-light nav-pills rounded-pill nav-fill mb-3">
                            <li class="nav-item">
                                <a data-toggle="pill" href="#nav-tab-paypal" class="nav-link rounded-pill">
                                    <i class="fa"></i>
                                    Paypal
                                </a>
                            </li>
                            <li class="nav-item">
                                <a data-toggle="pill" href="#nav-tab-bank" class="nav-link rounded-pill">
                                    <i class="fa fa-university"></i>
                                    Bank Transfer
                                </a>
                            </li>
                        </ul>
                        <!-- End -->


                        <!-- Credit card form content -->
                        <div class="tab-content">

                            <!-- Paypal info -->
                            <div id="nav-tab-paypal" class="tab-pane fade show active">
                                <p>Paypal is easiest way to pay online</p>
                                <p>

                                <div id="paypal-payment-button"></div>

                                </p>
                                <p class="text-muted">By clicking "PayPal", you will be directed to the PayPal website to complete your purchase. PayPal is a secure and easy way to pay online, and offers buyer protection and other benefits.</p>
                            </div>
                            <!-- End -->

                            <!-- bank transfer info -->
                            <div id="nav-tab-bank" class="tab-pane fade">
                                <h6>Bank account details</h6>
                                <dl>
                                    <dt>Bank</dt>
                                    <dd> THE WORLD BANK</dd>
                                </dl>
                                <dl>
                                    <dt>Account number</dt>
                                    <dd>7775877975</dd>
                                </dl>
                                <dl>
                                    <dt>IBAN</dt>
                                    <dd>CZ7775877975656</dd>
                                </dl>
                                <p class="text-muted">Please make your payment using the information provided above. Once payment has been received and processed, your order will be shipped promptly. Thank you for your business!
                                </p>
                            </div>
                            <!-- End -->
                        </div>
                    </div>
                    <!-- End -->
                </div>
            </div>
        </div>



        <?php
        include "newsletter.inc.php";
        ?>

        <?php
        include "footer.inc.php";
        ?>

        <!-- jQuery, Popper.js, and Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://www.paypal.com/sdk/js?client-id=ARNO-Hyyb4AggKSj3BBjHbSrvfn6uu9IGgOCr3OkhPJ29MDU9UlTVATf-CrzbdJwQws16lGnEWb4mXjT"></script>
        <script>
                    paypal.Buttons({
                        createOrder: function (data, actions) {
                            var value;
                            <?php
                            if (isset($_SESSION['newtotalcheckout'])) {
                                echo 'value="' . number_format($_SESSION['newtotalcheckout'], 2) . '";';
                                unset($_SESSION['newtotalcheckout']); // unset newtotalcheckout after setting value
                            } else {
                                echo 'value="' . number_format($_SESSION['total'], 2) . '";';
                            }
                            ?>
                            return actions.order.create({
                                purchase_units: [{
                                        amount: {
                                            value: value
                                        }
                                    }]
                            });
                        },
                        onApprove: function (data, actions) {
                            return actions.order.capture().then(function (details) {
                                // Make an AJAX call to process_checkout.php to generate order_id
                                $.ajax({
                                    type: "POST",
                                    url: "process_checkout.php",
                                    success: function (order_id) {
                                        // Create a form with the returned order ID and submit it to formsubmit.co
                                        var yourForm = $('<form action="https://formsubmit.co/groomgohair@gmail.com" method="POST">' +
                                                '<input type="hidden" name="message" value="New order received! Product quantities updated successfully!">' +
                                                '<input type="hidden" name="order_id" value="' + order_id + '">' +
                                                '<input type="hidden" name="_next" value="https://35.212.180.138/ProjectPhp/successpayment.php">' +
                                                '</form>');
                                        $('body').append(yourForm);
                                        yourForm.submit();
                                    },
                                    error: function () {
                                        alert("Error processing checkout");
                                    }
                                });
                            });
                        }


                    }).render('#paypal-payment-button');
        </script>


    </body>

</html>