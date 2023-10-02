<footer class="section-p1 container" style="border-top: 1px solid #ddd; padding: 20px 0;">
    <div class="col">
        <h3>Contact</h3>
        <p><strong>Address: </strong> 311 New Upper Changi Rd, Singapore 467360</p>
        <p><strong>Email: </strong> GroomGoHair@gmail.com</p>
        <p><strong>Phone:</strong> +65 65248790</p>
        <p><strong>Hours:</strong> 10:00 - 18:00, Mon - Sat</p>
        <div class="follow">
            <h3>Follow Us</h3>
            <div class="icon">
                <a href="https://www.facebook.com/" aria-label="Link to our Facebook page"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com/" aria-label="Link to our Twitter page"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com/" aria-label="Link to our Instagram page"><i class="fab fa-instagram"></i></a>
                <a href="https://www.pinterest.com/" aria-label="Link to our Pinterest page"><i class="fab fa-pinterest-p"></i></a>
                <a href="https://www.youtube.com/" aria-label="Link to our YouTube page"><i class="fab fa-youtube"></i></a>
            </div> 
        </div>
    </div>

    <div class="col centred">
        <h3>About</h3>
        <a href="about.php">About Us</a>
        <a href="shop.php">Shop</a>
        <a href="contact.php">Locate/Contact Us</a>
    </div>

    <div class="col centred">
        <h3>My Account</h3>
        <?php if (isset($_SESSION['email'])): ?>
            <a href="accountsetting.php">Profile</a>
        <?php else: ?>
            <a class="user-link" href="#">Sign In</a>
        <?php endif; ?>
        <a href="cart.php">View Cart</a>
        <a href="wishlist.php">My Wishlist</a>
    </div>

    <div class="col install">
        <p>Secured Payment Gateways </p>
        <img src="img/pay/pay.png" alt="Accepted payment methods: Mastercard, Visa, Maestro, and American Express">
    </div>


    <div class="copyright">
        <p>Copyright © 2023 Groom & Go</p>
    </div>
</footer>



<?php
include "register.php";
