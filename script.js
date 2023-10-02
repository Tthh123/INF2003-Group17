/* ========== User Form =========== */
document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM fully loaded and parsed");
    // Get the DOM elements needed
    const formWrapper = document.querySelector(".form-wrapper");
    const inputs = document.querySelectorAll(".form-box input[type = 'password']");
    const icons = Array.from(document.querySelectorAll(".form-icon")).slice(0, 2);
    const spans = Array.from(document.querySelectorAll(".form-box .top span")).slice(0, 2);
    const userForm = document.querySelector(".user-form");

    if (!userForm) {
        console.error("userForm not found");
    }

    // Add click event listeners for showing/hiding userForm and hiding navList
    [".user-icon", ".user-link"].forEach((p) => {
        const elements = document.querySelectorAll(p);
        elements.forEach((element) => {
            element.addEventListener("click", (event) => {
                event.preventDefault();
                // If the user is not logged in, show the registration form
                userForm.classList.add("show");
                navList.classList.remove("show");
            });
        });
    });

    // Add click event listener for closing userForm
    document.querySelector(".close-form").onclick = () => {
        userForm.classList.remove("show");
    };

    // Add click event listeners for toggling the color theme of the form
    spans.map((span) => {
        span.addEventListener("click", (e) => {
            const color = e.target.dataset.id;
            formWrapper.classList.toggle("active");
            userForm.classList.toggle("active");
            document.querySelector(":root").style.setProperty("--custom", color);
        });
    });

    // Add click event listeners for toggling the visibility of password inputs
    Array.from(inputs).map((input) => {
        icons.map((icon) => {
            // Set the HTML for the icon to display a "show password" icon
            icon.innerHTML = `<img src="./images/eye.svg" alt="" />`;

            // Add a click event listener for toggling the input type
            icon.addEventListener("click", () => {
                const type = input.getAttribute("type");
                if (type === "password") {
                    input.setAttribute("type", "text");
                    icon.innerHTML = `<img src="./images/hide.svg" alt="" />`;
                } else if (type === "text") {
                    input.setAttribute("type", "password");
                    icon.innerHTML = `<img src="./images/eye.svg" alt="" />`;
                }
            });
        });
    });

});

/*--------------------------------- Add to cart popup message function -------------- */

function sendNotification(type, text) {
    const alerts = {
        success: {
            icon: `<svg xmlns="http://www.w3.org/2000/svg" class="alert-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>`},
        error: {
            icon: `<svg xmlns="http://www.w3.org/2000/svg" class="alert-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>`},
        notlogin: {
            icon: `<svg xmlns="http://www.w3.org/2000/svg" class="alert-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17L6 12m0 0l5-5m-5 5h13" />
            </svg>`}
    };
    const notificationBox = document.querySelector(".notification-box");
    const component = document.createElement("div");
    component.className = `fixed inset-0 flex items-center justify-center`;
    component.innerHTML = `
    <div class="relative flex items-center bg-${alerts[type].color} text-white text-sm font-bold px-4 py-3 rounded-md opacity-0 transform transition-all duration-500 mb-1">
      ${alerts[type].icon}<p>${text}</p>
    </div>
  `;
    notificationBox.appendChild(component);

    setTimeout(() => {
        component.querySelector("div").classList.remove("opacity-0");
        component.querySelector("div").classList.add("opacity-1");
    }, 1);

    setTimeout(() => {
        component.querySelector("div").classList.remove("opacity-1");
        component.querySelector("div").classList.add("opacity-0");
        component.querySelector("div").style.margin = 0;
        component.querySelector("div").style.padding = 0;
    }, 500);

    setTimeout(() => {
        component.querySelector("div").style.setProperty("height", "0", "important");
    }, 500);

    setTimeout(() => {
        notificationBox.removeChild(component);
    }, 500);

    // Add the class to the notification box element
    if (type === "notlogin") {
        notificationBox.classList.add("notification-box-add", "notlogin");
    } else {
        notificationBox.classList.add("notification-box-add");
    }

    // Remove the class after 5 seconds to go back to original style
    setTimeout(() => {
        notificationBox.classList.remove("notification-box-add", "notlogin");
    }, 500);
}


/*--------------------------------- Nav Bar function -------------- */
const bar = document.getElementById('bar');
const close = document.getElementById('close');
const nav = document.getElementById('navbar');

if (bar) {
    bar.addEventListener('click', () => {
        nav.classList.add('active');
    });
}

if (close) {
    close.addEventListener('click', () => {
        nav.classList.remove('active');
    });
}


/*--------------------------------- Magic text function -------------- */
let index = 0,
        interval = 1000;

const rand = (min, max) =>
    Math.floor(Math.random() * (max - min + 1)) + min;

const animate = star => {
    star.style.setProperty("--star-left", `${rand(-10, 100)}%`);
    star.style.setProperty("--star-top", `${rand(-40, 80)}%`);

    star.style.animation = "none";
    star.offsetHeight;
    star.style.animation = "";
};

for (const star of document.getElementsByClassName("magic-star")) {
    setTimeout(() => {
        animate(star);
        setInterval(() => animate(star), 1000);
    }, index++ * (interval / 3));
}

/*--------------------------------- Slider function -------------- */
// Get the element with the ID "image-track"
const track = document.getElementById("image-track");

// Get all elements with the class "image" inside the "image-track" element
const images = track.getElementsByClassName("image");

// Count the number of images
const numImages = images.length;

// Get the width of the first image (assuming all images are the same width)
const imageWidth = images[0].offsetWidth;

// Calculate the total width of the track (number of images * image width)
const trackWidth = numImages * imageWidth;

// Calculate the total width of the slider, including the space after the last image
const totalWidth = trackWidth + 600;

// Add a "mousedown" event listener to the track element
track.addEventListener('mousedown', e => {

    // Set the "mouseDownAt" attribute of the track element to the X position of the mouse cursor
    track.dataset.mouseDownAt = e.clientX;
});

// Add a "touchstart" event listener to the track element
track.addEventListener('touchstart', e => {

    // Set the "mouseDownAt" attribute of the track element to the X position of the first touch
    track.dataset.mouseDownAt = e.touches[0].clientX;
});

// Add a "mouseup" event listener to the track element
track.addEventListener('mouseup', () => {

    // Set the "mouseDownAt" attribute of the track element to 0
    track.dataset.mouseDownAt = "0";

    // Store the previous percentage of track movement in the "prevPercentage" attribute of the track element
    track.dataset.prevPercentage = track.dataset.percentage;
});

// Add a "touchend" event listener to the track element
track.addEventListener('touchend', () => {

    // Set the "mouseDownAt" attribute of the track element to 0
    track.dataset.mouseDownAt = "0";

    // Store the previous percentage of track movement in the "prevPercentage" attribute of the track element
    track.dataset.prevPercentage = track.dataset.percentage;
});

// Add a "mousemove" event listener to the track element
track.addEventListener('mousemove', e => {

    // If the "mouseDownAt" attribute of the track element is 0, return
    if (track.dataset.mouseDownAt === "0")
        return;

    // Calculate the amount the mouse has moved since "mousedown"
    const mouseDelta = parseFloat(track.dataset.mouseDownAt) - e.clientX;

    // Set the maximum delta that the mouse can move to 1/4 of the window width
    maxDelta = window.innerWidth * 2;

    // Calculate the percentage of track movement based on the mouse movement
    const percentage = (mouseDelta / maxDelta) * -100;

    // Calculate the next percentage of track movement, constrained within the range of possible movement
    const nextPercentageUnconstrained = parseFloat(track.dataset.prevPercentage) + percentage;
    const maxPercentage = (totalWidth - window.innerWidth) / totalWidth * -100;
    const nextPercentage = Math.max(Math.min(nextPercentageUnconstrained, 0), maxPercentage);

    // Set the "percentage" attribute of the track element to the next percentage of track movement
    track.dataset.percentage = nextPercentage;

    // Animate the track element's transformation to move to the next percentage of track movement
    track.animate({
        transform: `translateX(${nextPercentage}%)`
    }, {duration: 1200, fill: "forwards"});

    for (const image of images) {
        image.animate({
            objectPosition: `${100 + nextPercentage}% center`
        }, {duration: 1200, fill: "forwards"});
    }
});

track.addEventListener('touchmove', e => { // listen for touchmove events on the track element
    if (track.dataset.mouseDownAt === "0") // if mouse is not currently down, return and do nothing
        return;

    // calculate mouse movement delta and max movement allowed based on screen size
    const mouseDelta = parseFloat(track.dataset.mouseDownAt) - e.touches[0].clientX,
            maxDelta = window.innerWidth * 2;

    // calculate the next percentage of track movement based on mouse movement and max movement allowed
    const percentage = (mouseDelta / maxDelta) * -100,
            nextPercentageUnconstrained = parseFloat(track.dataset.prevPercentage) + percentage,
            maxPercentage = (totalWidth - window.innerWidth) / totalWidth * -100, // calculate max percentage based on total width
            nextPercentage = Math.max(Math.min(nextPercentageUnconstrained, 0), maxPercentage);

    track.dataset.percentage = nextPercentage; // update the percentage attribute on the track element

    // animate the track element's transformation to move to the next percentage of track movement
    track.animate({
        transform: `translate(${nextPercentage}%, -50%)`
    }, {duration: 1200, fill: "forwards"});

    // animate each image element's object position to move in the opposite direction of track movement
    for (const image of images) {
        image.animate({
            objectPosition: `${100 + nextPercentage}% center`
        }, {duration: 1200, fill: "forwards"});
    }
});

/*=====================================this is for carousel effect function==========*/
$(document).ready(function () {
    $('.carousel').carousel();
});

/*=====================================this is for payment function==========*/

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

/*=====================================this is for delete items in cart page function==========*/

function deleteRow(event, button) {
    // Prevent the link from being followed
    event.preventDefault();
    // Get the name of the product to be deleted
    const name = button.closest("tr").dataset.name;
    // Send an AJAX request to the server-side script to delete the row
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "delete-from-cart.php", true);
    xhr.setRequestHeader(
            "Content-type",
            "application/x-www-form-urlencoded"
            );
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // If the deletion was successful, remove the row from the table
                document
                        .querySelectorAll(`tr[data-name='${name}']`)
                        .forEach((row) => {
                            row.remove();
                        });

                // Refresh the page
                location.reload();
            } else {
                // If the deletion was not successful, display an error message
                alert("Error deleting from cart");
            }
        }
    };
    xhr.send(`name=${encodeURIComponent(name)}`);
}

/*=====================================this is for delete items in cart page function==========*/

function deleteRowcart(event, button) {
    // Prevent the link from being followed
    event.preventDefault();

    // Get the name of the product to be deleted
    const name = button.closest("tr").dataset.name;
    // Send an AJAX request to the server-side script to delete the row
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "delete-from-wishlist.php", true);
    xhr.setRequestHeader(
            "Content-type",
            "application/x-www-form-urlencoded"
            );
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // If the deletion was successful, remove the row from the table
                document
                        .querySelectorAll(`tr[data-name='${name}']`)
                        .forEach((row) => {
                            row.remove();
                        });
                // Refresh the page
                location.reload();
            } else {
                // If the deletion was not successful, display an error message
                alert("Error deleting from cart");
            }
        }
    };

    xhr.send(`name=${encodeURIComponent(name)}`);
}

function addToCart(product, quantity) {
    console.log("Quantity:", quantity);

    $.ajax({
        type: "POST",
        url: "process_addtocart.php",
        data: {
            price: product.price,
            name: product.name,
            brand: product.brand,
            imgsrc: product.imageSrc,
            quantity: quantity
        },
        success: function (response) {
            // parse the response as JSON
            var cart = JSON.parse(response);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}


function moveToCart(event, link) {
    // Prevent the link from being followed
    event.preventDefault();

    // Get the table row for the product
    const row = link.closest("tr");

    // Get the product details from the row
    const name = row.dataset.name;
    const brand = row.dataset.brand;
    const imageSrc = row.querySelector("img").getAttribute("src");
    const price = row.querySelector("td:nth-child(5)").textContent.replace(/^\$\s*/, '');
    const quantity = row.dataset.quantity;

    // Add the product to the cart using the addToCart function
    const product = {name, brand, imageSrc, price};
    addToCart(product, quantity);

    // Remove the row from the wishlist using the deleteRowcart function
    deleteRowcart(event, link);

}




function addToWishlist(product) {
    $.ajax({
        type: "POST",
        url: "process_addtowishlist.php",
        data: {
            price: product.price,
            name: product.name,
            brand: product.brand,
            imageSrc: product.imageSrc
        },
        success: function (response) {
            // parse the response as JSON
            var wishlist = JSON.parse(response);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}


function enforceNonNegativeValue(input) {
    input.value = Math.abs(input.value);
}

/*=====================================this is for Contact page function==========*/
function showSuccessMessage(event) {
    event.preventDefault(); // prevent the form from being submitted
    const form = event.currentTarget.closest('form');
    // Sanitize input values
    const sanitizedInputs = {};
    const inputElements = form.querySelectorAll('input, textarea');
    inputElements.forEach(input => {
        const sanitizedValue = DOMPurify.sanitize(input.value);
        sanitizedInputs[input.name] = sanitizedValue;
    });

    if (form.checkValidity()) {
        Swal.fire(
                'Form Submitted',
                event.target.dataset.message,
                'success'
                ).then(function (result) {
            // If the user clicks "OK", submit the form
            if (result.isConfirmed) {
                // Assign sanitized inputs to form values
                Object.keys(sanitizedInputs).forEach(key => {
                    form.elements[key].value = sanitizedInputs[key];
                });
                event.target.closest('form').submit();
            }
        });
    } else {
        // Display an error message
        Swal.fire(
                'Error',
                'Please fill in all required fields',
                'error'
                );
    }
}


/*=====================================this is for cancel and check order function==========*/

function handleCancelOrder(orderId) {
    if (userType === 'admin') {
        cancelOrder(orderId);
    } else {
        window.location.href = 'contact.php';
    }
}

function cancelOrder(order_id) {
    console.log('Cancel order called with ID:', order_id);

    if (confirm("Are you sure you want to cancel this order?")) {
        // Create AJAX request
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log('Ready state:', this.readyState, 'Status:', this.status);

                alert(this.responseText);
                location.reload();
            }
        };
        xhttp.open("POST", "process_deleteorder.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("order_id=" + order_id);
    }
}

