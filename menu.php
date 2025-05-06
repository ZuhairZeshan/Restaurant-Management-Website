<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - DelightInn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .bgcolor {
            background-image: url(https://images.pexels.com/photos/326333/pexels-photo-326333.jpeg);
            background-position: center;
            background-size: cover;
            background-repeat: none;
        }

        .navcolor {
            background-color: #004e92;
        }
       

        /* .sticky-navbar {
            position: sticky;
            top: 80px;  Adjust this value based on where you want it to stick relative to the viewport 
            z-index: 1030;  Ensure it appears above other content 
            background-color: dark; Set background color if needed 
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);  Optional shadow for better visibility 
            }*/

    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script type="text/javascript" src="https://cdn.emailjs.com/dist/email.min.js"></script>
    <script type="text/javascript">
        (function(){
            emailjs.init("R0oyRXmBMHhZacSnO"); // Replace with your actual Public Key
        })();
    </script>


</head>

<body>

    
    <?php include '_dbconnect.php';?>
    

    <!-- navbar start -->
    <!-- <div class="container-fluid sec-1 fixed-top "> -->
    <section class="sec-1">
        <div class='wrapper'>
            <?php include 'navbar.php';?>
        </div>
    </section>
    <!-- </div> -->
   
    <!-- navbar end -->

    <!-- Category Slider Starts--> 
<section class="sec-m2 bgcolor" style="min-height: 700px; ">

    <nav class="navbar " >
        <form class="container-fluid justify-content-center " style="margin-top: 30px" >
            <?php 
                $sql="SELECT * FROM `categories`";
                $result=mysqli_query($conn,$sql);
                $menuData = []; // Initialize an array to hold menu data

                while($row=mysqli_fetch_assoc($result)){
                    $category_id = $row['Category_id'];
                    $sql2 = "SELECT * FROM `items` WHERE cat_id=$category_id";
                    $result2 = mysqli_query($conn, $sql2);
                    
                    $items = [];
                    while($row2 = mysqli_fetch_assoc($result2)){
                        $items[] = $row2; // Collect items for this category
                    }
                    
                    $menuData[$category_id] = [
                        'category_name' => $row['Category_name'],
                        'items' => $items
                    ];
                    
                    echo '<a href="#'.$row['Category_id'].'"><button class="btn mt-3 btn-sm btn-outline-light py-2 px-4 mx-4 fw-bold " type="button">'. $row['Category_name'] .'</button></a>';
                }
                
                
                // Store menu data in session
                $_SESSION['menuData'] = $menuData;
            ?>
            <div class="cart-container pe-3 mt-5 me-2 position-fixed" style="right: 10px; top: 50px;">
                <button type="button" class="btn btn-primary text-light fw-bolder" data-bs-toggle="modal" data-bs-target="#cartModal">
                    <i class="fa-solid fa-cart-shopping" style="font-size: 20px"></i>
                    <span id="cart-counter" class="badge bg-danger me-3">0</span>
                </button>
</div>
        </form>
        
    </nav>
    
    <!-- Category Slider Ends-->            


    <!-- Cards Start -->
    <div class="container">
        <div class="row pt-3">
            <?php 
                if (isset($_SESSION['menuData'])) {
                    $menuData = $_SESSION['menuData'];
                    foreach ($menuData as $category_id => $category) {
                        echo '<h1 id='.$category_id.' class="text-light pt-4 mb-3">'.$category['category_name'].'</h1>';
                        foreach ($category['items'] as $item) {
                            echo '
                            <div class="col-12 col-md-3 d-inline-block pt-2">
                                <div class="card" style="width: 16rem;">
                                    <img src="'.$item['Item_image'].'" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">'. $item['Item_name'] .'</h5>
                                        <p class="card-text">'. substr($item['Item_description'], 0, 80) .'...
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="#" class="see-more" id="see-more" data-bs-toggle="modal" data-bs-target="#exampleModal" 
                                                data-id="'. $item['Item_id'] .'" data-name="'. $item['Item_name'] .'" 
                                                data-description="'. $item['Item_description'] .'">See More</a>
                                            <h6 class="mb-0">Price: '.$item['Price'].'</h6>
                                        </div>
                                        <div class="counter-controls">
                                            <button type="button" class="btn btn-danger mx-4 px-4"  onclick="updateQuantity(\''.$item['Item_id'].'\', -1, \''.$item['Item_name'].'\',\''.$item['Price'].'\')" style="font-size: 30px height: 20px">-</button>
                                            <span id="quantity-'.$item['Item_id'].'" class="counter">0</span>
                                            <button type="button" class="btn btn-success px-4" onclick="updateQuantity(\''.$item['Item_id'].'\', 1, \''.$item['Item_name'].'\',\''.$item['Price'].'\')" style="font-size: 30px height: 20px">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }
                    }
                } else {
                    echo '<h1 class="text-light mb-3" style="font-size: 20px;">No Results Found</h1>';
                }
            ?>
        </div>
    </div>
</section>

    <!-- See more Modal Starts -->
    <?php include 'cardmodal.php';?>
    <script src="modal.js"></script>
    <!-- See more Modal Ends -->


<!-- Basket Modal Starts -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Shopping Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="modalError" class="container" style="color: red; display: none; font-size: 1.1rem; font-weight: bold; text-align: center;"></div>
            <div class="modal-body">
                <!-- Delivery Method Section -->
                <div class="form-group mt-2 mb-3">
                    <label for="deliveryMethod">Choose Delivery Method</label>
                    <select id="deliveryMethod" class="form-select" onchange="updateDeliveryCharges()">
                        <option value="pickup">Pickup</option>
                        <option value="delivery">Delivery</option>
                    </select>
                </div>
                <!-- Cart Items List -->
                <ul id="cartItems" class="list-group mb-3">
                    <!-- Cart items will be dynamically added here -->
                </ul>
                <p id="cartEmptyMessage" class="text-muted">Your cart is empty. Add items to see them here.</p>

                <!-- Total Price Section -->
                <div class="d-flex justify-content-between">
                    <strong>Subtotal:</strong>
                    <span id="cartSubtotalPrice">0.00</span> PKR
                </div>
                <div class="d-flex justify-content-between">
                    <strong>GST (13%):</strong>
                    <span id="cartGST">0.00</span> PKR
                </div>
                <div class="d-flex justify-content-between">
                    <strong>Delivery Fee:</strong>
                    <span id="del">0.00</span> PKR
                </div>
                <br>
                <div class="d-flex justify-content-between">
                    <strong>Total (incl. GST):</strong>
                    <span id="cartTotalPrice">0.00</span> PKR
                </div>

                <!-- Payment Method Section -->
                <div class="form-group mt-3">
                    <label for="paymentMethod">Choose Payment Method</label>
                    <select id="paymentMethod" class="form-select" onchange="togglePaymentDetails()">
                        <option value="cod">Cash on Delivery</option>
                        <option value="online">Online Payment</option>
                    </select>
                </div>

                <!-- Online Payment Details (Hidden by Default) -->
                <div id="onlinePaymentDetails" class="mt-3" style="display:none;">
                    <h6>Online Payment Details</h6>
                    <div class="mb-3">
                        <label for="cardNumber" class="form-label">Card Number</label>
                        <input type="text" id="cardNumber" class="form-control" placeholder="Enter card number" />
                    </div>
                    <div class="mb-3">
                        <label for="cardExpiry" class="form-label">Expiry Date</label>
                        <input type="text" id="cardExpiry" class="form-control" placeholder="MM/YY" />
                    </div>
                    <div class="mb-3">
                        <label for="cardCVV" class="form-label">CVV</label>
                        <input type="text" id="cardCVV" class="form-control" placeholder="Enter CVV" />
                    </div>
                </div>

            </div>
            <div class ="modal-footer">
                <!-- Hidden Form to Send Cart Data -->
                <form id="cartForm" method="POST" action="order.php">
                    <input type="hidden" name="cartData" id="cartDataInput">
                    <input type="hidden" name="deliveryMethod" id="deliveryMethodInput">
                    <input type="hidden" name="paymentMethod" id="paymentMethodInput">
                    <input type="hidden" name="paymentDetails" id="paymentDetailsInput">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="confirmOrderButton" onclick="submitCart()">Confirm Order</button>
                </form>
            </div>
            
        </div>
    </div>
</div>
<!-- Basket Modal Ends -->


    <!-- Checkout Button Starts -->
    <!-- <script>
        function submitCart() {
            const cartDataInput = document.getElementById('cartDataInput');
            cartDataInput.value = JSON.stringify(cart); // Serialize cart object as a JSON string
            document.getElementById('cartForm').submit(); // Submit the form to order.php
        }
    </script> -->
    <!-- Checkout Button Ends-->

    <!-- Card Java Starts -->
     <script>
    let cart = {}; // Object to store cart items and quantities
const notificationSound = new Audio('notification.mp3'); // Ensure this file exists in your project

// Load cart from localStorage on page load
window.onload = function() {
    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
        updateCartCounter(); // Update the cart counter on load
        updateModal(); // Update the modal to reflect loaded cart items
        updateItemQuantitiesOnCards(); // Update quantities displayed on cards
    }
};

// Update item quantity function
function updateQuantity(itemId, change, itemName, price) {
    notificationSound.play();

    // Initialize cart item if it doesn't exist
    if (!cart[itemId]) {
        cart[itemId] = { quantity: 0, name: itemName, price: price };
    }

    // Update quantity
    cart[itemId].quantity += change;

    // Remove item if the quantity is zero or less
    if (cart[itemId].quantity <= 0) {
        delete cart[itemId];
    }

    // Update the quantity display on the card
    const itemElement = document.getElementById("quantity-" + itemId);
    if (itemElement) {
        itemElement.innerText = cart[itemId]?.quantity || 0;
    }

    // Update the modal and cart counter
    updateModal();
    updateCartCounter();

    // Save cart to localStorage
    localStorage.setItem('cart', JSON.stringify(cart));

    // Update quantities displayed on cards
    updateItemQuantitiesOnCards();
}

function updateDeliveryCharges() {
    const deliveryMethod = document.getElementById('deliveryMethod').value;
    const deliveryFeeElement = document.getElementById('del'); // Element for delivery fee
    let deliveryFee = 0;

    // Set delivery fee based on the selected method
    if (deliveryMethod === 'delivery') {
        deliveryFee = 100; // Example delivery fee for delivery method
    } else {
        deliveryFee = 0; // No fee for pickup
    }

    deliveryFeeElement.innerText = deliveryFee.toFixed(2); // Update delivery fee display
    updateModal(); // Call updateModal to recalculate total price
}

// Update the cart modal content
function updateModal() {
    const cartItems = document.getElementById('cartItems');
    const cartEmptyMessage = document.getElementById('cartEmptyMessage');
    const cartTotalPriceElement = document.getElementById('cartTotalPrice');
    const cartGSTElement = document.getElementById('cartGST');
    const cartSubtotalPriceElement = document.getElementById('cartSubtotalPrice');
    const deliveryFeeElement = document.getElementById('del'); // Element for delivery fee
    let totalPrice = 0;

    cartItems.innerHTML = ''; // Clear current cart content

    if (Object.keys(cart).length === 0) {
        cartEmptyMessage.style.display = 'block';
        cartTotalPriceElement.innerText = '0.00'; // Reset total price
        cartGSTElement.innerText = '0.00'; // Reset GST
        cartSubtotalPriceElement.innerText = '0.00'; // Reset subtotal
        deliveryFeeElement.innerText = '0.00'; // Reset delivery fee
    } else {
        cartEmptyMessage.style.display = 'none';

        // Populate cart modal with items
        for (const itemId in cart) {
            const itemTotal = cart[itemId].price * cart[itemId].quantity;
            totalPrice += itemTotal;

            const listItem = document.createElement('li');
            listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
            listItem.innerHTML = `
                <div>
                    <strong>${cart[itemId].name}</strong><br>
                    Rs.${cart[itemId].price} x ${cart[itemId].quantity}
                </div>
                <div>
                    <span>Rs.${itemTotal.toFixed(2)}</span>
                    <button class="btn btn-sm btn-danger ms-2" onclick="removeFromCart('${itemId}')">Remove</button>
                </div>
            `;
            cartItems.appendChild(listItem);
        }

        // Calculate GST (13%)
        const gst = totalPrice * 0.13;
        const deliveryFee = parseFloat(deliveryFeeElement.innerText); // Get delivery fee from the element
        const totalWithGST = totalPrice + gst + deliveryFee; // Include delivery fee in total price

        // Update the subtotal, GST, delivery fee, and total price
        cartSubtotalPriceElement.innerText = totalPrice.toFixed(2); // Subtotal price
        cartGSTElement.innerText = gst.toFixed(2); // GST 13%
        cartTotalPriceElement.innerText = totalWithGST.toFixed(2); // Total price with GST
    }
}

function togglePaymentDetails() {
    const paymentMethod = document.getElementById('paymentMethod').value;
    const onlinePaymentDetails = document.getElementById('onlinePaymentDetails');

    if (paymentMethod === 'online') {
        onlinePaymentDetails.style.display = 'block'; // Show online payment details
    } else {
        onlinePaymentDetails.style.display = 'none'; // Hide online payment details
    }
}

function removeFromCart(itemId) {
    if (cart[itemId]) {
        delete cart[itemId]; // Remove item from the cart

        // Reset the quantity displayed on the card
        const quantitySpan = document.getElementById(`quantity-${itemId}`);
        if (quantitySpan) {
            quantitySpan.textContent = '0';
        }

        // Update the modal and cart counter
        updateModal();
        updateCartCounter();

        // Save updated cart to localStorage
        localStorage.setItem('cart', JSON.stringify(cart)); // Make sure key has no trailing space
    }
}

// Update the cart counter
function updateCartCounter() {
    const totalItems = Object.values(cart).reduce((sum, item) => sum + item.quantity, 0);
    const cartCounter = document.getElementById('cart-counter');

    if (totalItems > 0) {
        cartCounter.style.display = 'flex'; // Show counter if items exist
        cartCounter.innerText = totalItems;
    } else {
        cartCounter.style.display = 'none'; // Hide counter if no items
    }
}

// Update quantities displayed on cards
function updateItemQuantitiesOnCards() {
    for (const itemId in cart) {
        const itemElement = document.getElementById("quantity-" + itemId);
        if (itemElement) {
            itemElement.innerText = cart[itemId].quantity; // Update displayed quantity on the card
        }
    }
}

// Clear cart data on logout
function logout() {
    // Clear localStorage
    localStorage.removeItem('cart'); // Clear cart data
    // Redirect to the PHP logout script
    window.location.href = 'logout.php'; // Make sure this path points to your logout PHP script
}

// Call this function to initialize the cart and update the UI
function initializeCart() {
    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
        updateCartCounter(); // Update the cart counter on load
        updateModal(); // Update the modal to reflect loaded cart items
        updateItemQuantitiesOnCards(); // Update quantities displayed on cards
    }
}

function submitCart() {
    console.log("Confirm Order button clicked");

    // Check if cart is empty
    if (!cart || Object.keys(cart).length === 0) {
        showModalError("Select at least one item to continue.");
        return;
    }

    const userId = <?php echo isset($_SESSION['sno']) ? json_encode($_SESSION['sno']) : 'null'; ?>;

    if (!userId) {
        showModalError("Login First to Continue.");
        return;
    }

    // Step: Fetch user email from database using userId
    fetch('get_user_email.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ userId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status !== 'success') {
            showModalError(data.message || "Failed to retrieve email.");
            return;
        }

        const userEmail = data.email;
        const cartData = JSON.stringify(cart);
        const deliveryMethod = document.getElementById('deliveryMethod').value;
        const paymentMethod = document.getElementById('paymentMethod').value;

        let paymentDetails = {};
        if (paymentMethod === 'online') {
            paymentDetails = {
                cardNumber: document.getElementById('cardNumber').value,
                cardExpiry: document.getElementById('cardExpiry').value,
                cardCVV: document.getElementById('cardCVV').value
            };
        }

        const orderData = {
            userId: userId,
            cartData: cartData,
            deliveryMethod: deliveryMethod,
            paymentMethod: paymentMethod,
            paymentDetails: paymentDetails
        };

        console.log("Order Data:", orderData);

        fetch('order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(orderData)
        })
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.json();
        })
        .then(orderRes => {
            console.log(orderRes);
            if (orderRes.status === 'success') {
                // Place the email sending call after the order has been successfully placed
                sendOrderConfirmationEmail(userEmail, orderData, cart);
                alert(orderRes.message);


                // Clear the cart from localStorage
                localStorage.removeItem('cart');

                // Redirect the user to the order success page
                window.location.href = 'order_success.php';
            } else {
                showModalError(orderRes.message);
            }
        })
        .catch(err => {
            console.error('Order Error:', err);
            showModalError('Unexpected error occurred. Please try again.');
        });

    })
    .catch(error => {
        console.error('Email Fetch Error:', error);
        showModalError('Failed to retrieve user email.');
    });
}



function sendOrderConfirmationEmail(userEmail, orderData, cart) {
    emailjs.init("R0oyRXmBMHhZacSnO"); // EmailJS Public Key

    let cartItemsHTML = '';
    let totalPrice = 0;

    for (const productId in cart) {
        const item = cart[productId];
        cartItemsHTML += `${item.name} — Quantity: ${item.quantity} — Price: $${item.price}<br>`;
        totalPrice += item.price * item.quantity;
    }


    // cartItemsHTML += '</ul>';

    const templateParams = {
        to_email: userEmail,
        cart_items: cartItemsHTML,
        total_amount: `Rs. ${totalPrice.toFixed(2)}`,
        order_date: new Date().toLocaleDateString(),
        delivery_method: orderData.deliveryMethod,
        payment_method: orderData.paymentMethod === 'online'
            ? 'Online (Card Payment)'
            : 'Cash on Delivery'
    };

    emailjs.send("service_pdr0zau", "template_fd3gqyi", templateParams)
        .then(function(response) {
            console.log('SUCCESS!', response.status, response.text);
        }, function(error) {
            console.log('FAILED...', error);
        });
}



// Make sure to include the EmailJS SDK in your HTML file:

//modal errors
function showModalError(message) {
    const errorElement = document.getElementById('modalError');
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    } else {
        alert(message); // fallback
    }
}


// Call initializeCart on page load
window.onload = initializeCart;
</script>
<!-- Card Java Ends -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>


</body>

</html>
