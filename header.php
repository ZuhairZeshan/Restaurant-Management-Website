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

<?php



if(isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true"){
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
    <strong>Success!</strong> New User Created Successfully! 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}

echo '
<div class="container-fluid">
    <div class="row justify-content-center align-content-center text-center" style="min-height: 600px;">
        <div class="col-12 col-md-6 ">
            <h5 class="fw-bold text-white ">Welcome to</h5>
            <h1 class="fw-bolder text-white" style="font-size: 80px;">DELIGHT INN</h1>
            ';
            if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
                echo '
                <div class="my-4">
                    <button type="button" class="btn px-4 mx-5 text-light fw-bold" id="button" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                    <button type="button" class="btn my-3 px-3 mx-5 text-light fw-bold" id="button" data-bs-toggle="modal" data-bs-target="#signupModal">Sign-Up</button>
                </div>';
            }
            else{
                echo '
                <div class="my-4">
                    <a class="btn text-light fw-bold my-3" onclick="logout()" id="button">Logout <a>
                </div>';
            }
      echo'      
        </div>
    </div>
</div>
';


?>