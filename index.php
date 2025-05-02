<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
  <!-- test -->
    <style>
        #button{
          background-color: #006d77;
          /* background-color: red; */
        }
        #button:hover{
          font-weight: bolder;
          border: 1px solid white;
          background-color: black;
        }
        .ty2:hover{
          border: 1px solid white;
        }
        .sec-2 h1{
          font-family:'Gill Sans', 'Gill Sans MT', 'Calibri', 'Trebuchet MS', sans-serif;
        }

    </style>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Home - DelightInn</title>
</head>


<body> 

<?php include '_dbconnect.php'; ?>

<!-- Section 1 start -->
 <section class="sec-1">
  <div class="wrapper">
    <!-- Navbar -->
     <?php include 'navbar.php'; ?>
     <?php include 'header.php'; ?> 
  </div>
  </section>
<?php include 'loginmodal.php'; ?>
<?php include 'signupmodal.php'; ?>
<!-- Section 1 End -->


<section class="sec-2">
    <div class="container-fluid">
      <div class="row justify-content-center align-content-center" style="min-height: 800px;">
        <h1 class="text-center fw-bolder my-5 font-italic">OUR INTERIOR</h1>
      <div class="col-12">

      

      <div id="carouselExampleDark" class="carousel carousel-dark slide">
        <div class="carousel-indicators ">
          <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active bg-white" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" class="bg-white" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" class="bg-white" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active" data-bs-interval="10000">
            
            <img src="https://images.pexels.com/photos/1449773/pexels-photo-1449773.jpeg?auto=compress&cs=tinysrgb&w=600" class="d-block img-fluid m-auto" style="height: 500px;  " alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5 class="text-light fw-bold ">Lunch Area</h5>
              
            </div>
          </div>
          <div class="carousel-item" data-bs-interval="2000">
            <img src="https://images.pexels.com/photos/17057017/pexels-photo-17057017/free-photo-of-interior-of-restaurant-hall.jpeg?auto=compress&cs=tinysrgb&w=600" class="d-block  img-fluid m-auto" style="height: 500px;" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5 class="text-light fw-bold">Family Hall</h5>
            </div>
          </div>
          <div class="carousel-item ">
            <img src="https://images.pexels.com/photos/6161666/pexels-photo-6161666.jpeg?auto=compress&cs=tinysrgb&w=600" class="d-block img-fluid m-auto " style="height: 500px;" alt="...">
            <div class="carousel-caption d-none d-md-block">
              
              <h5 class="text-light fw-bold">Buffet</h5>
            </div>
          </div>
        </div>

        <style>
          .carousel-control-prev,
          .carousel-control-next {
            background-color: transparent !important; /* Remove background */
            opacity: 0;
            transition: opacity 0.3s ease;
          }

          .carousel:hover .carousel-control-prev,
          .carousel:hover .carousel-control-next {
            opacity: 1;
          }
        </style>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

      </div>
    </div>
    </div>
</section>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

<!-- Password DO not Match -->
<?php 
  if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "false") {
    echo '<script>
            var signupModal = new bootstrap.Modal(document.getElementById("signupModal"));
            signupModal.show();
          </script>';
  }
?>

<!-- User Exists Error -->
<?php 
  if (isset($_GET['userexists']) && $_GET['userexists'] == "false") {
    echo '<script>
            var signupModal = new bootstrap.Modal(document.getElementById("signupModal"));
            signupModal.show();
          </script>';
  }
?>

<!-- Invalid Credentials Error -->
<?php 
  if (isset($_GET['loginerror']) && $_GET['loginerror'] == "true") {
    echo '<script>
            var loginModal = new bootstrap.Modal(document.getElementById("loginModal"));
            loginModal.show();
          </script>';
  }
?>


<script>
  // Clear cart data on logout
function logout() {
    // Clear localStorage
    localStorage.removeItem('cart'); // Clear cart data
    // Redirect to the PHP logout script
    window.location.href = 'logout.php'; // Make sure this path points to your logout PHP script
}
</script>


<script src="path/to/your/js/jquery.min.js"></script>
<script src="path/to/your/js/bootstrap.bundle.min.js"></script>

</body>
</html>