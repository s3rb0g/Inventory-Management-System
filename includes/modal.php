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
         <div class="modal-header bg-primary text-white">
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
               <input type="submit" name="add_account" value="Save" class="btn btn-primary pr-3">
               <input type="reset" name="reset" value="Cancel" data-dismiss="modal" class="btn btn-secondary ml-2">
            </div>
         </form>

      </div>
   </div>
</div>

<!-- Edit Account Modal -->
<div class="modal fade" id="editAccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="exampleModalLabel">Edit an Account</h5>
            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">x</span>
            </button>
         </div>

         <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" style="width: 100%; max-width: 600px;">
            <div class="modal-body">

               <input type="hidden" name="edit_id" id="edit_id">

               <div class="mb-3">
                  <label for="title" class="form-label">Title</label>
                  <select name="edit_title" id="title" class="form-control">
                     <option id="edit_title" value="" hidden></option>
                     <option value="Ar.">Architect (Ar.)</option>
                     <option value="Engr.">Engineer (Engr.)</option>
                  </select>
               </div>

               <div class="mb-3">
                  <label for="edit_firstname" class="form-label">First Name <span style="color: red;">*</span></label>
                  <input type="text" name="edit_firstname" id="edit_firstname" class="form-control" required>
               </div>

               <div class="mb-3">
                  <label for="edit_lastname" class="form-label">Last Name <span style="color: red;">*</span></label>
                  <input type="text" name="edit_lastname" id="edit_lastname" class="form-control" required>
               </div>

               <div class="mb-3">
                  <label for="edit_username" class="form-label">Username <span style="color: red;">*</span></label>
                  <input type="text" name="edit_username" id="edit_username" class="form-control" required>
               </div>

               <div class="mb-2">
                  <label for="role" class="form-label">Role <span style="color: red;">*</span></label>
                  <select name="edit_role" id="role" class="form-control" required>
                     <option id="edit_role" value="" hidden></option>
                     <option value="2">Editor</option>
                     <option value="3">Viewer</option>
                  </select>
               </div>

               <div class="mb-2">
                  <label for="status" class="form-label">Status <span style="color: red;">*</span></label>
                  <select name="edit_status" id="status" class="form-control" required>
                     <option id="edit_status" value="" hidden></option>
                     <option value="1">Active</option>
                     <option value="0">Inactive</option>
                  </select>
               </div>

            </div>

            <div class="modal-footer">
               <input type="submit" name="edit_account" value="Save" class="btn btn-primary pr-3">
               <input type="reset" name="reset" value="Cancel" data-dismiss="modal" class="btn btn-secondary ml-2">
            </div>
         </form>

      </div>
   </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-danger">
            <h5 class="modal-title text-white">Delete an Account</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>

         <div class="modal-body">
            <p class="h5">Are you sure you want to delete this account permanently?</p>
         </div>

         <div class="modal-footer">
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
               <input type="hidden" name="id" value="" id="delete_account_id">
               <input type="submit" name="delete_account" value="Confirm" class="btn btn-danger pr-3">
               <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </form>
         </div>
      </div>
   </div>
</div>

<!-- Create Company Modal -->
<div class="modal fade" id="createCompanyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
         <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="exampleModalLabel">Register a Company</h5>
            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">x</span>
            </button>
         </div>

         <div class="modal-body">
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
               <div class="row">
                  <div class="col-md-6">
                     <div class="mb-3">
                        <label for="company_name" class="form-label">Name <span style="color: red;">*</span></label>
                        <input type="text" name="company_name" id="company_name" class="form-control" required>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="mb-3">
                        <label for="company_email" class="form-label">Email</label>
                        <input type="text" name="company_email" id="company_email" class="form-control">
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-6">
                     <div class="mb-3">
                        <label for="company_address" class="form-label mb-3">Address <span style="color: red;">*</span></label>
                        <input type="text" name="company_address" id="company_address" class="form-control" required>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="mb-3 Company-number-container">
                        <div class="d-flex align-items-center mb-2">
                           <label for="company_number" class="form-label">Number</label>
                           <button type="button" class="btn btn-primary btn-sm ml-auto" onclick="addCompanyNumber()">Add</button>
                        </div>
                        <div id="companyNumberList">
                           <div class="d-flex align-items-stretch mb-2">
                              <input type="number" name="company_number[]" class="form-control">
                              <button type="button" class="btn btn-danger btn-sm ml-2 mt-1" style="height: 30px;" onclick="removeCompanyNumber(this)">
                                 <i class="fa fa-times" aria-hidden="true"></i>
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-6">
                     <div class="mb-3">
                        <label for="contact_person" class="form-label mb-3">Contact Person <span style="color: red;">*</span></label>
                        <input type="text" name="contact_person" id="contact_person" class="form-control" required>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="mb-3 Contact-number-container">
                        <div class="d-flex align-items-center mb-2">
                           <label for="contact_number" class="form-label">Contact Number <span style="color: red;">*</span></label>
                           <button type="button" class="btn btn-primary btn-sm ml-auto" onclick="addContactNumber()">Add</button>
                        </div>
                        <div id="contactNumberList">
                           <div class="d-flex align-items-stretch mb-2">
                              <input type="number" name="contact_number[]" class="form-control" required>
                              <button type="button" class="btn btn-danger btn-sm ml-2 mt-1" style="height: 30px;" onclick="removeContactNumber(this)">
                                 <i class="fa fa-times" aria-hidden="true"></i>
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <hr>

               <div class="row">
                  <div class="col-md-6">
                     <div class="mb-3">
                        <label for="company_bir" class="form-label">BIR</label>
                        <input type="file" name="company_bir" id="company_bir" class="form-control" accept="application/pdf">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="mb-3">
                        <label for="company_dti" class="form-label">DTI/SEC</label>
                        <input type="file" name="company_dti" id="company_dti" class="form-control" accept="application/pdf">
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-6">
                     <div class="mb-3">
                        <label for="company_permit" class="form-label">Mayor's Permit</label>
                        <input type="file" name="company_permit" id="company_permit" class="form-control" accept="application/pdf">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="mb-3">
                        <label for="company_invoice" class="form-label">Sample Invoice</label>
                        <input type="file" name="company_invoice" id="company_invoice" class="form-control" accept="application/pdf">
                     </div>
                  </div>
               </div>
         </div>

         <div class="modal-footer">
            <input type="submit" name="add_company" value="Save" class="btn btn-primary pr-3">
            <input type="reset" name="reset" value="Cancel" data-dismiss="modal" class="btn btn-secondary ml-2">
            </form>
         </div>

      </div>
   </div>
</div>

<!-- Edit Company Modal -->
<div class="modal fade" id="editCompanyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
         <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="exampleModalLabel">Edit Company</h5>
            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">x</span>
            </button>
         </div>

         <div class="modal-body">
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
               <input type="hidden" name="edit_company_id" id="edit_company_id">
               <div class="row">
                  <div class="col-md-6">
                     <div class="mb-3">
                        <label for="edit_company_name" class="form-label">Name <span style="color: red;">*</span></label>
                        <input type="text" name="edit_company_name" id="edit_company_name" class="form-control" required>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="mb-3">
                        <label for="edit_company_email" class="form-label">Email</label>
                        <input type="text" name="edit_company_email" id="edit_company_email" class="form-control">
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-6">
                     <div class="mb-3">
                        <label for="edit_company_address" class="form-label mb-3">Address <span style="color: red;">*</span></label>
                        <input type="text" name="edit_company_address" id="edit_company_address" class="form-control" required>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="mb-3 Company-number-container">
                        <div class="d-flex align-items-center mb-2">
                           <label for="company_number" class="form-label">Number</label>
                           <button type="button" class="btn btn-primary btn-sm ml-auto" onclick="addCompanyNumber()">Add</button>
                        </div>
                        <div class="mb-3 Contact-number-container" id="edit_companyNumberList">
                           <?php foreach ($company_number as $index => $number): ?>
                              <div class="d-flex align-items-stretch mb-2">
                                 <input type="number" name="edit_company_number[]" class="form-control" value="<?php echo htmlspecialchars($number); ?>">
                                 <button type="button" class="btn btn-danger btn-sm ml-2 mt-1" style="height: 30px;" onclick="removeCompanyNumber(this)">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                 </button>
                              </div>
                           <?php endforeach; ?>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-6">
                     <div class="mb-3">
                        <label for="edit_contact_person" class="form-label mb-3">Contact Person <span style="color: red;">*</span></label>
                        <input type="text" name="edit_contact_person" id="edit_contact_person" class="form-control" required>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="mb-3 Contact-number-container">
                        <div class="d-flex align-items-center mb-2">
                           <label for="edit_contact_number" class="form-label">Contact Number <span style="color: red;">*</span></label>
                           <button type="button" class="btn btn-primary btn-sm ml-auto" onclick="addContactNumber()">Add</button>
                        </div>
                        <div class="mb-3 Contact-number-container" id="edit_contactNumberList">
                           <?php foreach ($contact_number as $index => $number): ?>
                              <div class="d-flex align-items-stretch mb-2">
                                 <input type="number" name="edit_contact_number[]" class="form-control" value="<?php echo htmlspecialchars($number); ?>" required>
                                 <button type="button" class="btn btn-danger btn-sm ml-2 mt-1" style="height: 30px;" onclick="removeContactNumber(this)">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                 </button>
                              </div>
                           <?php endforeach; ?>
                        </div>
                     </div>
                  </div>
               </div>
               <hr>

               <div class="row">
                  <div class="col-md-6">
                     <div class="mb-3">
                        <label for="edit_company_bir" class="form-label">BIR</label>
                        <input type="file" name="edit_company_bir" id="edit_company_bir" class="form-control" accept="application/pdf">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="mb-3">
                        <label for="edit_company_dti" class="form-label">DTI/SEC</label>
                        <input type="file" name="edit_company_dti" id="edit_company_dti" class="form-control" accept="application/pdf">
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-6">
                     <div class="mb-3">
                        <label for="edit_company_permit" class="form-label">Mayor's Permit</label>
                        <input type="file" name="edit_company_permit" id="edit_company_permit" class="form-control" accept="application/pdf">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="mb-3">
                        <label for="edit_company_invoice" class="form-label">Sample Invoice</label>
                        <input type="file" name="edit_company_invoice" id="edit_company_invoice" class="form-control" accept="application/pdf">
                     </div>
                  </div>
               </div>

               <div class="mb-2">
                  <label for="edit_company_status" class="form-label">Status <span style="color: red;">*</span></label>
                  <select name="edit_company_status" id="edit_company_status" class="form-control" required>
                     <option id="edit_companystatus" value="" hidden></option>
                     <option value="1">Active</option>
                     <option value="0">Inactive</option>
                  </select>
               </div>
         </div>

         <div class="modal-footer">
            <input type="submit" name="edit_company" value="Save" class="btn btn-primary pr-3">
            <input type="reset" name="reset" value="Cancel" data-dismiss="modal" class="btn btn-secondary ml-2">
            </form>
         </div>

      </div>
   </div>
</div>

<!-- Delete Company Modal -->
<div class="modal fade" id="deleteCompanyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-danger">
            <h5 class="modal-title text-white">Delete an Account</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>

         <div class="modal-body">
            <p class="h5">Are you sure you want to delete this company permanently?</p>
         </div>

         <div class="modal-footer">
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
               <input type="hidden" name="id" value="" id="delete_company_id">
               <input type="submit" name="delete_company" value="Confirm" class="btn btn-danger pr-3">
               <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </form>
         </div>
      </div>
   </div>
</div>