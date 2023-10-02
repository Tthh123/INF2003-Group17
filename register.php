<!-- ====== Login Form ====== -->
<div class="user-form">
    <div class="close-form d-flex"><i class="bx bx-x"></i></div>
    <div class="form-wrapper container">

        <div class="user login">
            <div class="form-box">
                <div class="top">
                    <p>
                        Not a member?
                        <span data-id="#ff0066">Register now</span>
                    </p>
                </div>
                <form action="process_login.php" method="post">
                    <div class="form-control no-border">
                        <h2>Hello Again!</h2>
                        <p>Welcome back you've been missed.</p>
                        <input class="form-control" id="email" required name="email" type="email" placeholder="Enter Email" aria-label="Email address" >
                        <div>
                            <input class="form-control" id="password" required name="password" type="password" placeholder="Password" aria-label="Password" >
                            <div class="icon form-icon">
                                <img src="./images/eye.svg" alt="Mask Password Function" >
                            </div>
                        </div>
                        <input type="Submit" value="Login" >
                        <!-- Add the Forgot Password link -->
                        <a href="forgetpassword.php" class="forgot-password">Forgot Password?</a>
                    </div>
                </form>

            </div>
        </div>

        <!-- Register -->
        <div class="user signup">
            <div class="form-box">
                <div class="top">
                    <p>
                        Already a member?
                        <span data-id="#1a1aff">Login now</span>
                    </p>
                </div>
                <form action="process_register.php" method="post" >
                    <div class="form-control">
                        <h2>Welcome!</h2>
                        <p>It's good to have you.</p>

                        <div>
                            <input class="form-control" id="fname" aria-label="Enter your first name" required name="fname" type="text" placeholder="First Name" >
                        </div>

                        <div>
                            <input class="form-control" id="lname" aria-label="Enter your last name" required name="lname" type="text" placeholder="Last Name" >
                        </div>

                        <input class="form-control" id="email" aria-label="Enter your email" required name="email" type="email"  placeholder="Enter Email" >

                        <div>
                            <input class="form-control" id="password" aria-label="Enter your password" required name="password" type="password" placeholder="Password" >
                        </div>

                        <div>
                            <input class="form-control" id="confirm_password" aria-label="Confirm your password" required name="confirm_password" type="password" placeholder="Confirm Password" >
                            <div class="icon form-icon">
                                <img src="./images/eye.svg" alt="Mask Password Function" >
                            </div>
                        </div>
                        <input type="Submit" value="Register" aria-label="Submit registration form" >
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

