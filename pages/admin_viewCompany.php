<?php
include('../includes/header.php');

if (isset($_SESSION['user_access'])) {
   if ($_SESSION['user_access'] == 1) {
      // header('location: admin_dashboard.php');
   } elseif ($_SESSION['user_access'] == 2) {
   }
} else {
   header('location: ../index.php');
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
   echo "<script>
            alert('No company ID provided. Please check the ID and try again.');
            window.location.href = 'admin_company.php';
         </script>";
   exit;
}

$id = intval($_GET['id']);
$result = mysqli_query($db_conn, "SELECT * FROM tbl_companies WHERE id = $id");

if (mysqli_num_rows($result) == 0) {
   echo "<script>
            alert('Company not found. Please select a company again.');
            window.location.href = 'admin_company.php';
         </script>";
   exit;
}

$company = mysqli_fetch_assoc($result);

$company_number = explode(',', $company['company_number']);
$contact_number = explode(',', $company['contact_number']);

?>

<!-- Begin Page Content -->
<div class="container-fluid">

   <div class="card shadow mb-4">
      <div class="card-header py-3.5 pt-4">
         <h4 class="float-left">Company Details</h4>

         <a href="admin_company.php">
            <button type="button" class="btn btn-primary float-right">
               <i class="fa fa-chevron-left pr-1"></i> Back to List
            </button>
         </a>

         <button type="button" class="btn btn-danger float-right mr-2" onclick="deleteCompany('<?php echo $company['id']; ?>')">
            <i class="fa fa-trash pr-1"></i> Delete
         </button>

         <button type="button" class="btn btn-warning float-right mr-2" onclick="editCompany('<?php echo $company['id']; ?>', '<?php echo $company['company_name']; ?>', '<?php echo $company['company_email']; ?>', '<?php echo $company['company_address']; ?>', '<?php echo $company['contact_person']; ?>', '<?php echo $company['company_status']; ?>')">
            <i class="fa fa-edit pr-1"></i> Edit
         </button>
      </div>

      <div class="card-body">
         <div class="table-responsive table-bordered table-striped table-hover">
            <table class="table table-bordered">
               <tr>
                  <th class="col-3">Name</th>
                  <td class="col-8"><?php echo $company['company_name']; ?></td>
                  <td></td>
               </tr>
               <tr>
                  <th>Email</th>
                  <td><?php echo !empty($company['company_email']) ? $company['company_email'] : "<i class='text-danger'>No Company Email Registered</i>"; ?></td>
                  <td></td>
               </tr>
               <tr>
                  <th>Address</th>
                  <td><?php echo $company['company_address']; ?></td>
                  <td></td>
               </tr>
               <tr>
                  <th>Number</th>

                  <td>
                     <?php
                     if (!empty($company['company_number'])) {
                        foreach ($company_number as $index => $number) {
                           echo htmlspecialchars($number);
                           echo "<br>";
                        }
                     } else {
                        echo "<i class='text-danger'>No Company Number Registered</i>";
                     }
                     ?>
                  </td>
                  <td></td>

               </tr>
               <tr>
                  <th>Contact Person</th>
                  <td><?php echo $company['contact_person']; ?></td>
                  <td></td>
               </tr>
               <tr>
                  <th>Contact Number</th>
                  <td>
                     <?php
                     foreach ($contact_number as $index => $number) {
                        if ($index > 0) {
                           echo "<br>";
                        }
                        echo htmlspecialchars($number);
                     }
                     ?>
                  </td>
                  <td></td>
               </tr>
               <tr>
                  <th>Status</th>
                  <td><?php echo getStatusValue($company['company_status']); ?></td>
                  <td></td>
               </tr>
               <tr>
                  <th>BIR</th>
                  <td><?php echo !empty($company['bir_name']) ? $company['bir_name'] : "<i class='text-danger'>No file uploaded</i>"; ?></td>
                  <td class="d-flex justify-content-center align-items-center">
                     <?php if (!empty($company['bir'])): ?>
                        <a href="upload_file/BIR/<?php echo $company['bir']; ?>" target="_blank">
                           <button class="btn btn-sm bg-primary text-white">View</button>
                        </a>
                     <?php else: ?>
                        <button class="btn btn-sm bg-primary text-white" disabled>Upload</button>
                     <?php endif; ?>
                  </td>
               </tr>
               <tr>
                  <th>DTI/SEC</th>
                  <td><?php echo !empty($company['dti_name']) ? $company['dti_name'] : "<i class='text-danger'>No file uploaded</i>"; ?></td>
                  <td class="d-flex justify-content-center align-items-center">
                     <?php if (!empty($company['dti'])): ?>
                        <a href="upload_file/DTI/<?php echo $company['dti']; ?>" target="_blank">
                           <button class="btn btn-sm bg-primary text-white">View</button>
                        </a>
                     <?php else: ?>
                        <button class="btn btn-sm bg-primary text-white" disabled>Upload</button>
                     <?php endif; ?>
                  </td>
               </tr>
               <tr>
                  <th>Mayor's Permit</th>
                  <td><?php echo !empty($company['permit_name']) ? $company['permit_name'] : "<i class='text-danger'>No file uploaded</i>"; ?></td>
                  <td class="d-flex justify-content-center align-items-center">
                     <?php if (!empty($company['permit'])): ?>
                        <a href="upload_file/PERMIT/<?php echo $company['permit']; ?>" target="_blank">
                           <button class="btn btn-sm bg-primary text-white">View</button>
                        </a>
                     <?php else: ?>
                        <button class="btn btn-sm bg-primary text-white" disabled>Upload</button>
                     <?php endif; ?>
                  </td>
               </tr>
               <tr>
                  <th>Sample Invoice</th>
                  <td><?php echo !empty($company['invoice_name']) ? $company['invoice_name'] : "<i class='text-danger'>No file uploaded</i>"; ?></td>
                  <td class="d-flex justify-content-center align-items-center">
                     <?php if (!empty($company['invoice'])): ?>
                        <a href="upload_file/INVOICE/<?php echo $company['invoice']; ?>" target="_blank">
                           <button class="btn btn-sm bg-primary text-white">View</button>
                        </a>
                     <?php else: ?>
                        <button class="btn btn-sm bg-primary text-white" disabled>Upload</button>
                     <?php endif; ?>
                  </td>
               </tr>
            </table>
         </div>
      </div>
   </div>

</div>
<!-- /.container-fluid -->

<?php
include('../includes/footer.php');
?>

<script>
   function editCompany(id, name, email, address, contactPerson, status) {
      $('#edit_company_id').val(id);
      $('#edit_company_name').val(name);
      $('#edit_company_email').val(email);
      $('#edit_company_address').val(address);
      $('#edit_contact_person').val(contactPerson);
      $('#edit_companystatus').val(status).text(status == 1 ? "Active" : "Inactive");
      $('#editCompanyModal').modal('show');
   }

   function deleteCompany(id) {
      $('#delete_company_id').val(id);
      $('#deleteCompanyModal').modal('show');
   }

   // Add Company Number 
   function addCompanyNumber() {
      const companyNumberList = document.getElementById("edit_companyNumberList");
      const newNumberDiv = document.createElement("div");
      newNumberDiv.className = "d-flex align-items-stretch mb-2";
      newNumberDiv.innerHTML = `
      <input type="number" name="edit_company_number[]" class="form-control">
      <button type="button" class="btn btn-danger btn-sm ml-2 mt-1" style="height: 30px;" onclick="removeCompanyNumber(this)">
         <i class="fa fa-times" aria-hidden="true"></i>
      </button>`;
      companyNumberList.appendChild(newNumberDiv);
   }

   // Remove Company Number 
   function removeCompanyNumber(button) {
      const container = button.closest('.d-flex.align-items-stretch');
      const parentList = container.parentElement;
      const memberCount = parentList.querySelectorAll('.d-flex.align-items-stretch').length;
      if (memberCount > 1) {
         container.remove();
      }
   }

   // Add Contact Number 
   function addContactNumber() {
      const contactNumberList = document.getElementById("edit_contactNumberList");
      const newContactDiv = document.createElement("div");
      newContactDiv.className = "d-flex align-items-stretch mb-2";
      newContactDiv.innerHTML = `
      <input type="number" name="edit_contact_number[]" class="form-control">
      <button type="button" class="btn btn-danger btn-sm ml-2 mt-1" style="height: 30px;" onclick="removeContactNumber(this)">
         <i class="fa fa-times" aria-hidden="true"></i>
      </button>`;
      contactNumberList.appendChild(newContactDiv);
   }

   // Remove Contact Number 
   function removeContactNumber(button) {
      const container = button.closest('.d-flex.align-items-stretch');
      const parentList = container.parentElement;
      const memberCount = parentList.querySelectorAll('.d-flex.align-items-stretch').length;
      if (memberCount > 1) {
         container.remove();
      }
   }
</script>