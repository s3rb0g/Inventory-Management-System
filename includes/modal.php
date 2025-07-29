<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">x</span>
            </button>
         </div>
         <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
         <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="../includes/logout.php">Logout</a>
         </div>
      </div>
   </div>
</div>

<!-- Pop up for Message -->
<div class="modal" tabindex="-1" id="popup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5);">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header bg-primary">
            <h5 class="modal-title text-white">Notification</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" onclick="closePopup()">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>

         <?php
         if (isset($_SESSION["message"])) {
            $message = $_SESSION["message"];

            echo "<script> 
                document.addEventListener('DOMContentLoaded', function () {
                  document.getElementById('popup').style.display = 'block'; 
                  document.body.style.overflow = 'hidden'; 
                }); 
              </script>";
         ?>

            <div class="modal-body my-2">
               <p class="h5"> <?php echo $message ?></p>
            </div>

         <?php
            unset($_SESSION["message"]);
         }
         ?>
      </div>
   </div>
</div>

<!-- Create Account Modal -->
<div class="modal fade" id="createAccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="exampleModalLabel">Create an Account</h5>
            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">x</span>
            </button>
         </div>

         <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" style="width: 100%; max-width: 600px;">
            <div class="modal-body">

               <div class="mb-3">
                  <label for="title" class="form-label">Title</label>
                  <select name="title" id="title" class="form-control">
                     <option value="" hidden></option>
                     <option value="Ar.">Architect (Ar.)</option>
                     <option value="Engr.">Engineer (Engr.)</option>
                  </select>
               </div>

               <div class="mb-3">
                  <label for="firstname" class="form-label">First Name <span style="color: red;">*</span></label>
                  <input type="text" name="firstname" id="firstname" class="form-control" required>
               </div>

               <div class="mb-3">
                  <label for="lastname" class="form-label">Last Name <span style="color: red;">*</span></label>
                  <input type="text" name="lastname" id="lastname" class="form-control" required>
               </div>

               <div class="mb-3">
                  <label for="username" class="form-label">Username <span style="color: red;">*</span></label>
                  <input type="text" name="username" id="username" class="form-control" required>
               </div>

               <div class="mb-2">
                  <label for="role" class="form-label">Role <span style="color: red;">*</span></label>
                  <select name="role" id="role" class="form-control" required>
                     <option value="" hidden></option>
                     <option value="2">Editor</option>
                     <option value="3">Viewer</option>
                  </select>
               </div>

            </div>

            <div class="modal-footer">
               <input type="submit" name="add_account" value="Save" class="btn btn-success pr-3">
               <input type="reset" name="reset" value="Cancel" data-dismiss="modal" class="btn btn-secondary ml-2">
            </div>
         </form>

      </div>
   </div>
</div>