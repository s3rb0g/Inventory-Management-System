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
                              <input type="number" name="company_number[]" id="company_number" class="form-control">
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
                              <input type="number" name="contact_number[]" id="contact_number" class="form-control" required>
                              <button type="button" class="btn btn-danger btn-sm ml-2 mt-1" style="height: 30px;" onclick="removeContactNumber(this)">
                                 <i class="fa fa-times" aria-hidden="true"></i>
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-12">
                     <div class="mb-3">
                        <label for="company_link" class="form-label mb-3">Link Address</label>
                        <input type="text" name="company_link" id="company_link" class="form-control">
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

               <div class="row">
                  <div class="col-md-12">
                     <div class="mb-3">
                        <label for="company_certification" class="form-label">Certification</label>
                        <input type="file" name="company_certification" id="company_certification" class="form-control" accept="application/pdf">
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

<!-- View Company Modal -->
<div class="modal fade" id="viewCompanyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
         <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="exampleModalLabel">Company Details</h5>
            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">x</span>
            </button>
         </div>

         <div class="modal-body">
            <div class="table-responsive table-striped table-hover">
               <table class="table table-bordered">
                  <tr>
                     <th class="col-3">Name</th>
                     <td class="col-7" id="companyDetails_name"></td>
                     <td></td>
                  </tr>
                  <tr>
                     <th>Email</th>
                     <td id="companyDetails_email"></td>
                     <td></td>
                  </tr>
                  <tr>
                     <th>Address</th>
                     <td id="companyDetails_address"></td>
                     <td></td>
                  </tr>
                  <tr>
                     <th>Number</th>
                     <td id="companyDetails_number"></td>
                     <td></td>
                  </tr>
                  <tr>
                     <th>Contact Person</th>
                     <td id="companyDetails_conPerson"></td>
                     <td></td>
                  </tr>
                  <tr>
                     <th>Contact Number</th>
                     <td id="companyDetails_conNumber"></td>
                     <td></td>
                  </tr>
                  <tr>
                     <th>Status</th>
                     <td id="companyDetails_status"></td>
                     <td></td>
                  </tr>
                  <tr>
                     <th>Link Address</th>
                     <td id="companyDetails_link"></td>
                     <td id="companyDetails_link_btn" class="d-flex justify-content-center align-items-center"></td>
                  </tr>
                  <tr>
                     <th>BIR</th>
                     <td id="companyDetails_bir"></td>
                     <td id="companyDetails_bir_btn" class="d-flex justify-content-center align-items-center"></td>
                  </tr>
                  <tr>
                     <th>DTI/SEC</th>
                     <td id="companyDetails_dti"></td>
                     <td id="companyDetails_dti_btn" class="d-flex justify-content-center align-items-center"></td>
                  </tr>
                  <tr>
                     <th>Mayor's Permit</th>
                     <td id="companyDetails_permit"></td>
                     <td id="companyDetails_permit_btn" class="d-flex justify-content-center align-items-center"></td>
                  </tr>
                  <tr>
                     <th>Sample Invoice</th>
                     <td id="companyDetails_invoice"></td>
                     <td id="companyDetails_invoice_btn" class="d-flex justify-content-center align-items-center"></td>
                  </tr>
                  <tr>
                     <th>Certification</th>
                     <td id="companyDetails_certification"></td>
                     <td id="companyDetails_certification_btn" class="d-flex justify-content-center align-items-center"></td>
                  </tr>
               </table>
            </div>
         </div>

         <div class="modal-footer">
            <button type="button" class="btn btn-danger float-right mr-2" id="deleteCompany_btn">
               <i class="fa fa-trash pr-1"></i> Delete
            </button>

            <button type="button" class="btn btn-warning float-right mr-2" id="editCompany_btn">
               <i class="fa fa-edit pr-1"></i> Edit
            </button>

            <button type="button" class="btn btn-secondary float-right mr-2" data-dismiss="modal">
               <i class="fa fa-chevron-left pr-1"></i> Close
            </button>

         </div>

      </div>
   </div>
</div>

<!-- Edit Company Modal -->
<div class="modal fade" id="editCompanyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
         <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="exampleModalLabel">Edit Company Details</h5>
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
                           <label for="edit_company_number" class="form-label">Number</label>
                           <button type="button" class="btn btn-primary btn-sm ml-auto" onclick="edit_addCompanyNumber()">Add</button>
                        </div>
                        <div class="mb-3 Contact-number-container" id="edit_companyNumberList"></div>
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
                           <button type="button" class="btn btn-primary btn-sm ml-auto" onclick="edit_addContactNumber()">Add</button>
                        </div>
                        <div class="mb-3 Contact-number-container" id="edit_contactNumberList"></div>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-12">
                     <div class="mb-3">
                        <label for="edit_company_link" class="form-label mb-3">Link Address</label>
                        <input type="text" name="edit_company_link" id="edit_company_link" class="form-control">
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

               <div class="row">
                  <div class="col-md-12">
                     <div class="mb-3">
                        <label for="edit_company_certification" class="form-label">Certification</label>
                        <input type="file" name="edit_company_certification" id="edit_company_certification" class="form-control" accept="application/pdf">
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
            <h5 class="modal-title text-white">Delete Company Record</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>

         <div class="modal-body">
            <p class="h5">Are you sure you want to delete this company record permanently?</p>
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

<!-- Register Item Modal -->
<div class="modal fade" id="registerAccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
         <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="exampleModalLabel">Register Item</h5>
            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">x</span>
            </button>
         </div>

         <div class="modal-body">
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">

               <div class="mb-3">
                  <label for="item_name" class="form-label">Item Name <span style="color: red;">*</span></label>
                  <input type="text" name="item_name" id="item_name" class="form-control" required>
               </div>

               <div class="mb-3">
                  <label for="item_brand" class="form-label">Brand</label>
                  <input type="text" name="item_brand" id="item_brand" class="form-control">
               </div>

               <div class="mb-3">
                  <label for="item_specification" class="form-label">Specification <span style="color: red;">*</span></label>
                  <textarea name="item_specification" id="item_specification" class="form-control" rows="4" required></textarea>
               </div>

               <div class="mb-3">
                  <label for="item_image" class="form-label">Image</label>
                  <input type="file" name="item_image" id="item_image" class="form-control" accept=".jpg, .jpeg, .png, .webp, .svg, .gif">
               </div>

               <div class="mb-3">
                  <label for="item_sheet" class="form-label">Data Sheet</label>
                  <input type="file" name="item_sheet" id="item_sheet" class="form-control" accept="application/pdf">
               </div>

         </div>

         <div class="modal-footer">
            <input type="submit" name="add_item" value="Save" class="btn btn-primary pr-3">
            <input type="reset" name="reset" value="Cancel" data-dismiss="modal" class="btn btn-secondary ml-2">
            </form>
         </div>

      </div>
   </div>
</div>

<!-- View Item Modal -->
<div class="modal fade" id="viewItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
         <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="exampleModalLabel">Item Details</h5>
            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">x</span>
            </button>
         </div>

         <div class="modal-body">
            <div class="table-responsive table-striped table-hover">
               <table class="table table-bordered">
                  <tr>
                     <th class="col-3">Item Image</th>
                     <td class="col-7">
                        <img src="../assets/img/Not_Available.png" style="height: 150px; width: 150px;" alt="No Image Available" id="itemDetails_image">
                     </td>
                     <td></td>
                  </tr>
                  <tr>
                     <th>Name</th>
                     <td id="itemDetails_name"></td>
                     <td></td>
                  </tr>
                  <tr>
                     <th>Brand</th>
                     <td id="itemDetails_brand"></td>
                     <td></td>
                  </tr>
                  <tr>
                     <th>Specification</th>
                     <td id="itemDetails_specification"></td>
                     <td></td>
                  </tr>
                  <tr>
                     <th>Data Sheet</th>
                     <td id="itemDetails_sheet"></td>
                     <td id="itemDetails_sheet_btn" class="d-flex justify-content-center align-items-center"></td>
                  </tr>
                  <tr>
                     <th>Status</th>
                     <td id="itemDetails_status"></td>
                     <td></td>
                  </tr>
               </table>
            </div>
         </div>

         <div class="modal-footer">
            <button type="button" class="btn btn-danger float-right mr-2" id="deleteItem_btn">
               <i class="fa fa-trash pr-1"></i> Delete
            </button>

            <button type="button" class="btn btn-warning float-right mr-2" id="editItem_btn">
               <i class="fa fa-edit pr-1"></i> Edit
            </button>

            <button type="button" class="btn btn-secondary float-right mr-2" data-dismiss="modal">
               <i class="fa fa-chevron-left pr-1"></i> Close
            </button>

         </div>

      </div>
   </div>
</div>

<!-- Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
         <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="exampleModalLabel">Edit Item Details</h5>
            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">x</span>
            </button>
         </div>

         <div class="modal-body">
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
               <input type="hidden" name="edit_item_id" id="edit_item_id">

               <div class="mb-3">
                  <label for="edit_item_name" class="form-label">Item Name <span style="color: red;">*</span></label>
                  <input type="text" name="edit_item_name" id="edit_item_name" class="form-control" required>
               </div>

               <div class="mb-3">
                  <label for="edit_item_brand" class="form-label">Brand</label>
                  <input type="text" name="edit_item_brand" id="edit_item_brand" class="form-control">
               </div>

               <div class="mb-3">
                  <label for="edit_item_specification" class="form-label">Specification <span style="color: red;">*</span></label>
                  <textarea name="edit_item_specification" id="edit_item_specification" class="form-control" rows="4" required></textarea>
               </div>

               <div class="mb-3">
                  <label for="edit_item_image" class="form-label">Image</label>
                  <input type="file" name="edit_item_image" id="edit_item_image" class="form-control" accept=".jpg, .jpeg, .png, .webp, .svg, .gif">
               </div>

               <div class="mb-3">
                  <label for="edit_item_sheet" class="form-label">Data Sheet</label>
                  <input type="file" name="edit_item_sheet" id="edit_item_sheet" class="form-control" accept="application/pdf">
               </div>

               <div class="mb-2">
                  <label for="edit_item_status" class="form-label">Status <span style="color: red;">*</span></label>
                  <select name="edit_item_status" id="edit_item_status" class="form-control" required>
                     <option id="edit_itemstatus" value="" hidden></option>
                     <option value="1">Active</option>
                     <option value="0">Inactive</option>
                  </select>
               </div>
         </div>

         <div class="modal-footer">
            <input type="submit" name="edit_item" value="Save" class="btn btn-primary pr-3">
            <input type="reset" name="reset" value="Cancel" data-dismiss="modal" class="btn btn-secondary ml-2">
            </form>
         </div>

      </div>
   </div>
</div>

<!-- Delete Item Modal -->
<div class="modal fade" id="deleteItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-danger">
            <h5 class="modal-title text-white">Delete Item Record</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>

         <div class="modal-body">
            <p class="h5">Are you sure you want to delete this item record permanently?</p>
         </div>

         <div class="modal-footer">
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
               <input type="hidden" name="id" value="" id="delete_item_id">
               <input type="submit" name="delete_item" value="Confirm" class="btn btn-danger pr-3">
               <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </form>
         </div>
      </div>
   </div>
</div>

<!-- Register Material Modal -->
<div class="modal fade" id="registerMaterialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
         <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="exampleModalLabel">Register Materials</h5>
            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">x</span>
            </button>
         </div>

         <div class="modal-body">
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">

               <div class="mb-3">
                  <label for="material_item" class="form-label">Item <span style="color: red;">*</span></label>
                  <select name="material_item" id="material_item" class="form-control" required>
                     <option hidden></option>

                     <?php
                     $result = mysqli_query($db_conn, "SELECT * FROM tbl_items WHERE item_status=1");
                     if ($result):
                        $i = 0;
                        while ($row = mysqli_fetch_assoc($result)):
                           $color = ($i % 2 == 0) ? "#ffffffff" : "#d1cbcbff";
                     ?>
                           <option value="<?php echo $row['id'] ?>" style="background-color: <?php echo $color; ?>;"><?php echo $row['item_name'] ?></option>
                     <?php
                           $i++;
                        endwhile;
                     endif;
                     ?>

                  </select>
               </div>

               <div class="mb-3">
                  <label for="material_company" class="form-label">Company <span style="color: red;">*</span></label>
                  <select name="material_company" id="material_company" class="form-control" required>
                     <option hidden></option>

                     <?php
                     $result = mysqli_query($db_conn, "SELECT * FROM tbl_companies WHERE company_status=1");
                     if ($result):
                        $i = 0;
                        while ($row = mysqli_fetch_assoc($result)):
                           $color = ($i % 2 == 0) ? "#ffffffff" : "#d1cbcbff";
                     ?>
                           <option value="<?php echo $row['id'] ?>" style="background-color: <?php echo $color; ?>;"><?php echo $row['company_name'] ?></option>
                     <?php
                           $i++;
                        endwhile;
                     endif;
                     ?>

                  </select>
               </div>

               <div class="mb-3">
                  <label for="material_vat" class="form-label">VAT <span style="color: red;">*</span></label>
                  <select name="material_vat" id="material_vat" class="form-control" required>
                     <option hidden></option>
                     <option value="1">VAT IN</option>
                     <option value="0">VAT EX</option>
                  </select>
               </div>

               <div class="mb-3">
                  <label for="material_cost" class="form-label">Cost <span style="color: red;">*</span></label>
                  <input type="number" name="material_cost" id="material_cost" class="form-control" required>
               </div>

               <div class="mb-3">
                  <label for="material_unit" class="form-label">Unit <span style="color: red;">*</span></label>
                  <input type="text" name="material_unit" id="material_unit" class="form-control" required>
               </div>
         </div>

         <div class="modal-footer">
            <input type="submit" name="add_material" value="Save" class="btn btn-primary pr-3">
            <input type="reset" name="reset" value="Cancel" data-dismiss="modal" class="btn btn-secondary ml-2">
            </form>
         </div>

      </div>
   </div>
</div>

<!-- View Material Modal -->
<div class="modal fade" id="viewMaterialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
         <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="exampleModalLabel">Material Details</h5>
            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">x</span>
            </button>
         </div>

         <div class="modal-body">
            <div class="card shadow mb-4">
               <div class="card-body card-outline-primary">
                  <div class="row">
                     <div class="col-md-5">
                        <div class="mb-3">
                           <img src="../assets/img/Not_Available.png" class="img-fluid rounded" style="max-width: auto; height: 455px; object-fit: contain;" alt="No Image Available" id="materialDetails_image">
                        </div>
                     </div>
                     <div class="col-md-7">
                        <div class="mb-3">
                           <table class="table table-borderless table-striped">
                              <tr>
                                 <th style="width: 25%;">Name:</th>
                                 <td id="materialDetails_name"></td>
                              </tr>
                              <tr>
                                 <th>Company:</th>
                                 <td id="materialDetails_company"></td>
                              </tr>
                              <tr>
                                 <th>Location:</th>
                                 <td id="materialDetails_location"></td>
                              </tr>
                              <tr>
                                 <th>Brand:</th>
                                 <td id="materialDetails_brand"></td>
                              </tr>
                              <tr>
                                 <th>Specification:</th>
                                 <td id="materialDetails_specification"></td>
                              </tr>
                              <tr>
                                 <th>VAT:</th>
                                 <td id="materialDetails_vat"></td>
                              </tr>
                              <tr>
                                 <th>Price:</th>
                                 <td id="materialDetails_price"></td>
                              </tr>
                              <tr>
                                 <th>Unit:</th>
                                 <td id="materialDetails_unit"></td>
                              </tr>
                              <tr>
                                 <th>Contact Person:</th>
                                 <td id="materialDetails_contact_person"></td>
                              </tr>
                              <tr>
                                 <th>Contact Number:</th>
                                 <td id="materialDetails_contact_number"></td>
                              </tr>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="modal-footer">
            <button type="button" class="btn btn-danger float-right mr-2" id="deleteMaterial_btn">
               <i class="fa fa-trash pr-1"></i> Delete
            </button>

            <button type="button" class="btn btn-warning float-right mr-2" id="editMaterial_btn">
               <i class="fa fa-edit pr-1"></i> Edit
            </button>

            <button type="button" class="btn btn-secondary float-right mr-2" data-dismiss="modal">
               <i class="fa fa-chevron-left pr-1"></i> Close
            </button>

         </div>

      </div>
   </div>
</div>

<!-- Edit Material Modal -->
<div class="modal fade" id="editMaterialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
         <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="exampleModalLabel">Edit Materials</h5>
            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">x</span>
            </button>
         </div>

         <div class="modal-body">
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
               <input type="hidden" name="edit_material_id" id="edit_material_id">

               <div class="mb-3">
                  <label for="edit_material_item" class="form-label">Item <span style="color: red;">*</span></label>
                  <select name="edit_material_item" id="edit_material_item" class="form-control" required>
                     <option id="edit_material_item_option" hidden></option>

                     <?php
                     $result = mysqli_query($db_conn, "SELECT * FROM tbl_items WHERE item_status=1");
                     if ($result):
                        $i = 0;
                        while ($row = mysqli_fetch_assoc($result)):
                           $color = ($i % 2 == 0) ? "#ffffffff" : "#d1cbcbff";
                     ?>
                           <option value="<?php echo $row['id'] ?>" style="background-color: <?php echo $color; ?>;"><?php echo $row['item_name'] ?></option>
                     <?php
                           $i++;
                        endwhile;
                     endif;
                     ?>

                  </select>
               </div>

               <div class="mb-3">
                  <label for="edit_material_company" class="form-label">Company <span style="color: red;">*</span></label>
                  <select name="edit_material_company" id="edit_material_company" class="form-control" required>
                     <option id="edit_material_company_option" hidden></option>

                     <?php
                     $result = mysqli_query($db_conn, "SELECT * FROM tbl_companies WHERE company_status=1");
                     if ($result):
                        $i = 0;
                        while ($row = mysqli_fetch_assoc($result)):
                           $color = ($i % 2 == 0) ? "#ffffffff" : "#d1cbcbff";
                     ?>
                           <option value="<?php echo $row['id'] ?>" style="background-color: <?php echo $color; ?>;"><?php echo $row['company_name'] ?></option>
                     <?php
                           $i++;
                        endwhile;
                     endif;
                     ?>

                  </select>
               </div>

               <div class="mb-3">
                  <label for="edit_material_vat" class="form-label">VAT <span style="color: red;">*</span></label>
                  <select name="edit_material_vat" id="edit_material_vat" class="form-control" required>
                     <option id="edit_material_vat_option" hidden></option>
                     <option value="1">VAT IN</option>
                     <option value="0">VAT EX</option>
                  </select>
               </div>

               <div class="mb-3">
                  <label for="edit_material_cost" class="form-label">Cost <span style="color: red;">*</span></label>
                  <input type="number" name="edit_material_cost" id="edit_material_cost" class="form-control" required>
               </div>

               <div class="mb-3">
                  <label for="edit_material_unit" class="form-label">Unit <span style="color: red;">*</span></label>
                  <input type="text" name="edit_material_unit" id="edit_material_unit" class="form-control" required>
               </div>

               <div class="mb-2">
                  <label for="edit_material_status" class="form-label">Status <span style="color: red;">*</span></label>
                  <select name="edit_material_status" id="edit_material_status" class="form-control" required>
                     <option id="edit_material_status_option" value="" hidden></option>
                     <option value="1">Active</option>
                     <option value="0">Inactive</option>
                  </select>
               </div>
         </div>

         <div class="modal-footer">
            <input type="submit" name="edit_material" value="Save" class="btn btn-primary pr-3">
            <input type="reset" name="reset" value="Cancel" data-dismiss="modal" class="btn btn-secondary ml-2">
            </form>
         </div>

      </div>
   </div>
</div>

<!-- Delete Material Modal -->
<div class="modal fade" id="deleteMaterialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-danger">
            <h5 class="modal-title text-white">Delete Material Record</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>

         <div class="modal-body">
            <p class="h5">Are you sure you want to delete this Material record permanently?</p>
         </div>

         <div class="modal-footer">
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
               <input type="hidden" name="id" value="" id="delete_material_id">
               <input type="submit" name="delete_material" value="Confirm" class="btn btn-danger pr-3">
               <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </form>
         </div>
      </div>
   </div>
</div>

<!-- Register Service Modal -->
<div class="modal fade" id="registerServiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
         <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="exampleModalLabel">Register Services</h5>
            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">x</span>
            </button>
         </div>

         <div class="modal-body">
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">

               <div class="mb-3">
                  <label for="service_name" class="form-label">Service <span style="color: red;">*</span></label>
                  <input type="text" name="service_name" id="service_name" class="form-control" required>
               </div>

               <div class="mb-3">
                  <label for="service_company" class="form-label">Company <span style="color: red;">*</span></label>
                  <select name="service_company" id="service_company" class="form-control" required>
                     <option hidden></option>

                     <?php
                     $result = mysqli_query($db_conn, "SELECT * FROM tbl_companies WHERE company_status=1");
                     if ($result):
                        $i = 0;
                        while ($row = mysqli_fetch_assoc($result)):
                           $color = ($i % 2 == 0) ? "#ffffffff" : "#d1cbcbff";
                     ?>
                           <option value="<?php echo $row['id'] ?>" style="background-color: <?php echo $color; ?>;"><?php echo $row['company_name'] ?></option>
                     <?php
                           $i++;
                        endwhile;
                     endif;
                     ?>

                  </select>
               </div>

               <div class="mb-3">
                  <label for="service_vat" class="form-label">VAT <span style="color: red;">*</span></label>
                  <select name="service_vat" id="service_vat" class="form-control" required>
                     <option hidden></option>
                     <option value="1">VAT IN</option>
                     <option value="0">VAT EX</option>
                  </select>
               </div>

               <div class="mb-3">
                  <label for="service_cost" class="form-label">Cost <span style="color: red;">*</span></label>
                  <input type="number" name="service_cost" id="service_cost" class="form-control" required>
               </div>

               <div class="mb-3">
                  <label for="service_unit" class="form-label">Unit <span style="color: red;">*</span></label>
                  <input type="text" name="service_unit" id="service_unit" class="form-control" required>
               </div>

               <div class="mb-3">
                  <label for="service_sheet" class="form-label">Data Sheet</label>
                  <input type="file" name="service_sheet" id="service_sheet" class="form-control" accept="application/pdf">
               </div>
         </div>

         <div class="modal-footer">
            <input type="submit" name="add_service" value="Save" class="btn btn-primary pr-3">
            <input type="reset" name="reset" value="Cancel" data-dismiss="modal" class="btn btn-secondary ml-2">
            </form>
         </div>

      </div>
   </div>
</div>

<!-- View Service Modal -->
<div class="modal fade" id="viewServiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-md modal-dialog-scrollable">
      <div class="modal-content">
         <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="exampleModalLabel">Service Details</h5>
            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">x</span>
            </button>
         </div>

         <div class="modal-body">
            <table class="table table-borderless table-striped">
               <tr>
                  <th style="width: 33%;">Name:</th>
                  <td id="serviceDetails_name"></td>
               </tr>
               <tr>
                  <th>Company:</th>
                  <td id="serviceDetails_company"></td>
               </tr>
               <tr>
                  <th>Location:</th>
                  <td id="serviceDetails_location"></td>
               </tr>
               <tr>
                  <th>VAT:</th>
                  <td id="serviceDetails_vat"></td>
               </tr>
               <tr>
                  <th>Price:</th>
                  <td id="serviceDetails_price"></td>
               </tr>
               <tr>
                  <th>Unit:</th>
                  <td id="serviceDetails_unit"></td>
               </tr>
               <tr>
                  <th>Contact Person:</th>
                  <td id="serviceDetails_contact_person"></td>
               </tr>
               <tr>
                  <th>Contact Number:</th>
                  <td id="serviceDetails_contact_number"></td>
               </tr>
            </table>
         </div>

         <div class="modal-footer">
            <button type="button" class="btn btn-danger float-right mr-2" id="deleteMaterial_btn" disabled>
               <i class="fa fa-trash pr-1"></i> Delete
            </button>

            <button type="button" class="btn btn-warning float-right mr-2" id="editMaterial_btn" disabled>
               <i class="fa fa-edit pr-1"></i> Edit
            </button>

            <button type="button" class="btn btn-secondary float-right mr-2" data-dismiss="modal">
               <i class="fa fa-chevron-left pr-1"></i> Close
            </button>

         </div>

      </div>
   </div>
</div>