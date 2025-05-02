<style>
    #colour{
        color: red;
        font-weight: bold;
    }
</style>

<!-- login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Login Form</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Error message -->
        <?php 
          if (isset($_GET['loginerror']) && $_GET['loginerror'] == "true"){
            echo '
              <div class="mb-3">
                <div class="container">
                  <label for="invalid" class="form-label" id="colour">INVALID CREDENTIALS</label>
                </div>
              </div>';
          }
        ?>
        <!-- login Form start -->
        <form action="/Restaurant-Management-Website/_handlelogin.php" method="post">
          <div class="mb-3">
            <label for="loginemail" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="loginemail" name="loginemail" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
          </div>
          <div class="mb-3">
            <label for="loginpassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="loginpassword" name="loginpassword">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
        </form>
        <!--login Form End -->
      </div>
    </div>
  </div>
</div>




