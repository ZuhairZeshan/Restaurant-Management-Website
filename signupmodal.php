<style>
    #colour{
        color: red;
        font-weight: bold;
    }
</style>

<!--Start signup Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Signup Form</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Password do not match Error -->
        <?php 
          if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "false"){
            echo '
              <div class="mb-3">
                <div class="container">
                  <label for="invalid" class="form-label" id="colour">Passwords Do not Match</label>
                </div>
              </div>';
          }
        ?>
        <!-- User Exists Error -->
        <?php 
          if (isset($_GET['userexists']) && $_GET['userexists'] == "false"){
            echo '
              <div class="mb-3">
                <div class="container">
                  <label for="invalid" class="form-label" id="colour">User Already Exists</label>
                </div>
              </div>';
          }
        ?>
        <!-- signup Form start -->
        <form action="/Restaurant-Management-Website/_handlesignup.php" method="POST">
          <div class="mb-3">
            <label for="signupname" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="signupname" name="signupname" aria-describedby="emailHelp">
          </div>
          <div class="mb-3">
            <label for="signupemail" class="form-label">Email address</label>
            <input type="email" class="form-control" id="signupemail" name="signupemail" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
          </div>
          <div class="mb-3">
            <label for="contacts" class="form-label">Contact No</label>
            <input type="text" class="form-control" id="contacts" name="contacts" aria-describedby="emailHelp">
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" aria-describedby="emailHelp">
          </div>
          <div class="mb-3">
            <label for="signuppassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="signuppassword" name="signuppassword">
          </div>
          <div class="mb-3">
            <label for="signupcpassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="signupcpassword" name="signupcpassword">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Signup</button>
          </div>
        </form>
        <!-- signup Form End -->
      </div>
    </div>
  </div>
</div>
<!-- Signup modal end -->





