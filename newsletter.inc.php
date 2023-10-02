<section id="newsletter" class="section-p1 section-m1">
    <div class="newstext">
        <h4>Stay in the Loop</h4>
        <p>Stay up-to-date on <span>exclusive offers and styling guide.</span> </p>
    </div>

    <form id="myForm" action="https://formsubmit.co/GroomGoHair@gmail.com" method="POST" class="newsletter-form">
        <div class="input-group">
            <input type="email" class="form-control" placeholder="Email Address" name="email" required aria-label="Email Address Input">
            <button type="submit" class="newsletterbtn btn btn-outline-secondary" >Sign Up</button>
        </div>
        <input type="hidden" name="_subject" value="Welcome to our mailing list!">
        <input type="hidden" name="_blacklist" value="spammy pattern, banned term, phrase">
        <input type="hidden" name="_next" value="https://35.212.180.138/ProjectPhp/thankyou.php">
    </form>

</section>

<script>
    document.getElementById("myForm").addEventListener("submit", function (event) {
        event.preventDefault(); // prevent the form from submitting

        var email = document.getElementsByName("email")[0].value; // get the value of the email input
        var formAction = "https://formsubmit.co/" + email; // create the new form action
        console.log("formAction:", formAction); // output the form action to the console
        document.getElementById("myForm").action = formAction; // set the new form action

        // create a new XMLHttpRequest object to send the form data to FormSubmit
        var xhr = new XMLHttpRequest();
        xhr.open('POST', formAction);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            console.log("FormSubmit response:", xhr.responseText);

            // submit the form to your PHP script
            var xhr2 = new XMLHttpRequest();
            xhr2.open('POST', 'submit_email.php');
            xhr2.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr2.onload = function () {
                console.log("Email stored successfully"); // output a success message to the console

                // change the form action to the new URL
                document.getElementById("myForm").action = formAction;

                // submit the form to the new URL
                document.getElementById("myForm").submit();
            };
            xhr2.send('email=' + encodeURIComponent(email));
        };

        xhr.send(new FormData(event.target));
    });
</script>