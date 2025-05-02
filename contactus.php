<?php include '_dbconnect.php'; ?>

<?php
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize it
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate input
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Prepare an SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        // Execute the statement
        if ($stmt->execute()) {
            // Success message
            echo "<script>alert('Thank you for contacting us! We will get back to you shortly.'); window.location.href='contactus.php';</script>";
        } else {
            // Error message
            echo "<script>alert('There was an error submitting your message. Please try again later.'); window.location.href='contactus.php';</script>";
        }

        // Close the statement
        $stmt->close();
    } else {
        // Error message for empty fields
        echo "<script>alert('Please fill in all fields.'); window.location.href='contactus.php';</script>";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contacts - DelightInn</title>    
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    /* body {
      font-family: Arial, sans-serif;
      overflow-x: hidden;
    } */

    .bgcolor {
      background-image: url(https://images.pexels.com/photos/326333/pexels-photo-326333.jpeg);
      background-position: center;
      background-size: cover;
      background-repeat: no-repeat;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .contact-form {
      background: rgba(255, 255, 255, 0.8);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s;
    }

    .contact-form:hover {
      transform: scale(1.05);
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
    }

    .form-control {
      border-radius: 5px;
    }

    .btn-custom {
      background-color: #007bff;
      color: white;
      border-radius: 5px;
    }

    .btn-custom:hover {
      background-color: #0056b3;
    }
  </style>

  <script type="text/javascript" src="https://cdn.emailjs.com/dist/email.min.js"></script>
  <script type="text/javascript">
    (function(){
      emailjs.init("R0oyRXmBMHhZacSnO"); // Replace with your actual public key
    })();
  </script>


</head>
<body>

<div class="container-fluid sec-1">
  <div class='wrapper '>
  <?php include 'navbar.php';?>
  </div>
</div>

<div class="container-fluid bgcolor ">
  <div class="row justify-content-center align-content-center">
    <div class="col-md-8 " style="width: 1000px">
      <h1 class="text-light">Contact Us</h1>
      <form id="contact-form" class="contact-form" action="contactus.php" method="POST">
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
          <label for="message" class="form-label">Message</label>
          <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>
        <div class="text-center">
        <button type="submit" class="btn btn-custom ">Send Message</button>
        </div>
      </form>
      
    <p id="status-msg"></p>
    
  </div>
  </div>
</div>

</body>
</html>



<script>
  document.getElementById("contact-form").addEventListener("submit", function(event) {
    event.preventDefault();

    // Optional: show sending status
    document.getElementById("status-msg").textContent = "Sending...";

    emailjs.sendForm('service_pdr0zau', 'template_f3ov2av', this)
      .then(function(response) {
        document.getElementById("status-msg").textContent = "Message sent successfully!";
        document.getElementById("contact-form").reset();
      }, function(error) {
        document.getElementById("status-msg").textContent = "Failed to send. Please try again.";
        console.error("EmailJS error:", error);
      });
  });
</script>
