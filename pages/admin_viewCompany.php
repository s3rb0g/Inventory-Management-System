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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   // Edit company ....................................................................................
   if (isset($_POST['edit_company'])) {
      $edit_comapny_id = $_POST['edit_company_id'];
      $edit_company_name = filter_input(INPUT_POST, 'edit_company_name', FILTER_SANITIZE_SPECIAL_CHARS);
      $edit_company_email = filter_input(INPUT_POST, 'edit_company_email', FILTER_SANITIZE_SPECIAL_CHARS);
      $edit_company_address = filter_input(INPUT_POST, 'edit_company_address', FILTER_SANITIZE_SPECIAL_CHARS);
      $edit_company_num = $_POST['edit_company_number'];
      $edit_company_number = implode(',', $edit_company_num);
      $edit_contact_person = filter_input(INPUT_POST, 'edit_contact_person', FILTER_SANITIZE_SPECIAL_CHARS);
      $edit_contact_num = $_POST['edit_contact_number'];
      $edit_contact_number = implode(',', $edit_contact_num);
      $edit_company_link = filter_input(INPUT_POST, 'edit_company_link', FILTER_SANITIZE_SPECIAL_CHARS);
      $edit_contact_status = $_POST['edit_company_status'];

      $result = mysqli_query($db_conn, "UPDATE tbl_companies SET company_name='$edit_company_name', company_email='$edit_company_email', company_address='$edit_company_address', company_number='$edit_company_number', contact_person='$edit_contact_person', contact_number='$edit_contact_number', company_link='$edit_company_link', company_status='$edit_contact_status' WHERE id='$edit_comapny_id'");

      if ($result) {

         if (isset($_FILES['edit_company_bir']) && $_FILES['edit_company_bir']['error'] == 0) {

            $bir_name = $_FILES["edit_company_bir"]["name"];

            $bir_file_name = $edit_comapny_id . '_BIR.pdf';
            $bir_old_path = $_FILES["edit_company_bir"]["tmp_name"];
            $bir_new_path = 'upload_file/BIR/' . $bir_file_name;
            move_uploaded_file($bir_old_path, $bir_new_path);

            mysqli_query($db_conn, "UPDATE tbl_companies SET bir = '$bir_file_name', bir_name = '$bir_name' WHERE id = '$edit_comapny_id'");
         }

         if (isset($_FILES['edit_company_dti']) && $_FILES['edit_company_dti']['error'] == 0) {

            $dti_name = $_FILES["edit_company_dti"]["name"];

            $dti_file_name = $edit_comapny_id . '_DTI.pdf';
            $dti_old_path = $_FILES["edit_company_dti"]["tmp_name"];
            $dti_new_path = 'upload_file/DTI/' . $dti_file_name;
            move_uploaded_file($dti_old_path, $dti_new_path);

            mysqli_query($db_conn, "UPDATE tbl_companies SET dti = '$dti_file_name', dti_name = '$dti_name' WHERE id = '$edit_comapny_id'");
         }

         if (isset($_FILES['edit_company_permit']) && $_FILES['edit_company_permit']['error'] == 0) {

            $permit_name = $_FILES["edit_company_permit"]["name"];

            $permit_file_name = $edit_comapny_id . '_PERMIT.pdf';
            $permit_old_path = $_FILES["edit_company_permit"]["tmp_name"];
            $permit_new_path = 'upload_file/PERMIT/' . $permit_file_name;
            move_uploaded_file($permit_old_path, $permit_new_path);

            mysqli_query($db_conn, "UPDATE tbl_companies SET permit = '$permit_file_name', permit_name = '$permit_name' WHERE id = '$edit_comapny_id'");
         }

         if (isset($_FILES['edit_company_invoice']) && $_FILES['edit_company_invoice']['error'] == 0) {

            $invoice_name = $_FILES["edit_company_invoice"]["name"];

            $invoice_file_name = $edit_comapny_id . '_INVOICE.pdf';
            $invoice_old_path = $_FILES["edit_company_invoice"]["tmp_name"];
            $invoice_new_path = 'upload_file/INVOICE/' . $invoice_file_name;
            move_uploaded_file($invoice_old_path, $invoice_new_path);

            mysqli_query($db_conn, "UPDATE tbl_companies SET invoice = '$invoice_file_name', invoice_name = '$invoice_name' WHERE id = '$edit_comapny_id'");
         }

         if (isset($_FILES['edit_company_certification']) && $_FILES['edit_company_certification']['error'] == 0) {

            $certification_name = $_FILES["edit_company_certification"]["name"];

            $certification_file_name = $edit_comapny_id . '_CERTIFICATION.pdf';
            $certification_old_path = $_FILES["edit_company_certification"]["tmp_name"];
            $certification_new_path = 'upload_file/CERTIFICATION/' . $certification_file_name;
            move_uploaded_file($certification_old_path, $certification_new_path);

            mysqli_query($db_conn, "UPDATE tbl_companies SET certification = '$certification_file_name', certification_name = '$certification_name' WHERE id = '$edit_comapny_id'");
         }

         $_SESSION["message"] = "Company updated successfully.";
      } else {
         $_SESSION["message"] = "Failed to update company.";
      }

      header("Refresh: .3; url=admin_company.php");
      ob_end_flush();
      exit;
   }

   // Delete company ...........................................................................
   if (isset($_POST['delete_company'])) {
      $id = $_POST['id'];
      $result = mysqli_query($db_conn, "DELETE FROM tbl_companies WHERE id='$id' ");

      if ($result) {
         $_SESSION["message"] = "Company deleted successfully.";
      } else {
         $_SESSION["message"] = "Failed to delete company.";
      }

      header("Refresh: .3; url=admin_company.php");
      ob_end_flush();
      exit;
   }
}

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

         <button type="button" class="btn btn-warning float-right mr-2" onclick="editCompany('<?php echo $company['id']; ?>', '<?php echo $company['company_name']; ?>', '<?php echo $company['company_email']; ?>', '<?php echo $company['company_address']; ?>', '<?php echo $company['contact_person']; ?>', '<?php echo $company['company_link']; ?>', '<?php echo $company['company_status']; ?>')">
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
                  <th>Link Address</th>
                  <td><?php echo !empty($company['company_link']) ? $company['company_link'] : "<i class='text-danger'>No Link Address Registered</i>"; ?></td>
                  <td class="d-flex justify-content-center align-items-center">
                     <?php if (!empty($company['company_link'])): ?>
                        <a href="<?php echo $company['company_link']; ?>" target="_blank">
                           <button class="btn btn-sm bg-primary text-white">
                              <i class="fas fa-eye mr-1"></i> View
                           </button>
                        </a>
                     <?php endif; ?>
                  </td>
               </tr>
               <tr>
                  <th>BIR</th>
                  <td><?php echo !empty($company['bir_name']) ? $company['bir_name'] : "<i class='text-danger'>No file uploaded</i>"; ?></td>
                  <td class="d-flex justify-content-center align-items-center">
                     <?php if (!empty($company['bir'])): ?>
                        <a href="upload_file/BIR/<?php echo $company['bir']; ?>" target="_blank">
                           <button class="btn btn-sm bg-primary text-white">
                              <i class="fas fa-eye mr-1"></i> View
                           </button>
                        </a>
                     <?php endif; ?>
                  </td>
               </tr>
               <tr>
                  <th>DTI/SEC</th>
                  <td><?php echo !empty($company['dti_name']) ? $company['dti_name'] : "<i class='text-danger'>No file uploaded</i>"; ?></td>
                  <td class="d-flex justify-content-center align-items-center">
                     <?php if (!empty($company['dti'])): ?>
                        <a href="upload_file/DTI/<?php echo $company['dti']; ?>" target="_blank">
                           <button class="btn btn-sm bg-primary text-white">
                              <i class="fas fa-eye mr-1"></i> View
                           </button>
                        </a>
                     <?php endif; ?>
                  </td>
               </tr>
               <tr>
                  <th>Mayor's Permit</th>
                  <td><?php echo !empty($company['permit_name']) ? $company['permit_name'] : "<i class='text-danger'>No file uploaded</i>"; ?></td>
                  <td class="d-flex justify-content-center align-items-center">
                     <?php if (!empty($company['permit'])): ?>
                        <a href="upload_file/PERMIT/<?php echo $company['permit']; ?>" target="_blank">
                           <button class="btn btn-sm bg-primary text-white">
                              <i class="fas fa-eye mr-1"></i> View
                           </button>
                        </a>
                     <?php endif; ?>
                  </td>
               </tr>
               <tr>
                  <th>Sample Invoice</th>
                  <td><?php echo !empty($company['invoice_name']) ? $company['invoice_name'] : "<i class='text-danger'>No file uploaded</i>"; ?></td>
                  <td class="d-flex justify-content-center align-items-center">
                     <?php if (!empty($company['invoice'])): ?>
                        <a href="upload_file/INVOICE/<?php echo $company['invoice']; ?>" target="_blank">
                           <button class="btn btn-sm bg-primary text-white">
                              <i class="fas fa-eye mr-1"></i> View
                           </button>
                        </a>
                     <?php endif; ?>
                  </td>
               </tr>
               <tr>
                  <th>Certification</th>
                  <td><?php echo !empty($company['certification_name']) ? $company['certification_name'] : "<i class='text-danger'>No file uploaded</i>"; ?></td>
                  <td class="d-flex justify-content-center align-items-center">
                     <?php if (!empty($company['certification'])): ?>
                        <a href="upload_file/CERTIFICATION/<?php echo $company['certification']; ?>" target="_blank">
                           <button class="btn btn-sm bg-primary text-white">
                              <i class="fas fa-eye mr-1"></i> View
                           </button>
                        </a>
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
   function editCompany(id, name, email, address, contactPerson, link, status) {
      $('#edit_company_id').val(id);
      $('#edit_company_name').val(name);
      $('#edit_company_email').val(email);
      $('#edit_company_address').val(address);
      $('#edit_contact_person').val(contactPerson);
      $('#edit_company_link').val(link);
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