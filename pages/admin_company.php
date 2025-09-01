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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   // Add company ....................................................................................
   if (isset($_POST['add_company'])) {
      $company_name = filter_input(INPUT_POST, 'company_name', FILTER_SANITIZE_SPECIAL_CHARS);
      $company_email = filter_input(INPUT_POST, 'company_email', FILTER_SANITIZE_SPECIAL_CHARS);
      $company_address = filter_input(INPUT_POST, 'company_address', FILTER_SANITIZE_SPECIAL_CHARS);
      $company_num = $_POST['company_number'];
      $company_number = implode(',', $company_num);
      $contact_person = filter_input(INPUT_POST, 'contact_person', FILTER_SANITIZE_SPECIAL_CHARS);
      $contact_num = $_POST['contact_number'];
      $contact_number = implode(',', $contact_num);
      $company_link = filter_input(INPUT_POST, 'company_link', FILTER_SANITIZE_SPECIAL_CHARS);
      $status = 1;

      $result = mysqli_query($db_conn, "INSERT INTO tbl_companies (company_name, company_email, company_address, company_number, contact_person, contact_number, company_link, company_status) VALUES ('$company_name', '$company_email', '$company_address', '$company_number', '$contact_person', '$contact_number', '$company_link', '$status')");

      if ($result) {
         $inserted_id = mysqli_insert_id($db_conn);

         if (isset($_FILES['company_bir']) && $_FILES['company_bir']['error'] == 0) {

            $bir_name = $_FILES["company_bir"]["name"];

            $bir_file_name = $inserted_id . '_BIR.pdf';
            $bir_old_path = $_FILES["company_bir"]["tmp_name"];
            $bir_new_path = 'upload_file/BIR/' . $bir_file_name;
            move_uploaded_file($bir_old_path, $bir_new_path);

            mysqli_query($db_conn, "UPDATE tbl_companies SET bir = '$bir_file_name', bir_name = '$bir_name' WHERE id = '$inserted_id'");
         }

         if (isset($_FILES['company_dti']) && $_FILES['company_dti']['error'] == 0) {

            $dti_name = $_FILES["company_dti"]["name"];

            $dti_file_name = $inserted_id . '_DTI.pdf';
            $dti_old_path = $_FILES["company_dti"]["tmp_name"];
            $dti_new_path = 'upload_file/DTI/' . $dti_file_name;
            move_uploaded_file($dti_old_path, $dti_new_path);

            mysqli_query($db_conn, "UPDATE tbl_companies SET dti = '$dti_file_name', dti_name = '$dti_name' WHERE id = '$inserted_id'");
         }

         if (isset($_FILES['company_permit']) && $_FILES['company_permit']['error'] == 0) {

            $permit_name = $_FILES["company_permit"]["name"];

            $permit_file_name = $inserted_id . '_PERMIT.pdf';
            $permit_old_path = $_FILES["company_permit"]["tmp_name"];
            $permit_new_path = 'upload_file/PERMIT/' . $permit_file_name;
            move_uploaded_file($permit_old_path, $permit_new_path);

            mysqli_query($db_conn, "UPDATE tbl_companies SET permit = '$permit_file_name', permit_name = '$permit_name' WHERE id = '$inserted_id'");
         }

         if (isset($_FILES['company_invoice']) && $_FILES['company_invoice']['error'] == 0) {

            $invoice_name = $_FILES["company_invoice"]["name"];

            $invoice_file_name = $inserted_id . '_INVOICE.pdf';
            $invoice_old_path = $_FILES["company_invoice"]["tmp_name"];
            $invoice_new_path = 'upload_file/INVOICE/' . $invoice_file_name;
            move_uploaded_file($invoice_old_path, $invoice_new_path);

            mysqli_query($db_conn, "UPDATE tbl_companies SET invoice = '$invoice_file_name', invoice_name = '$invoice_name' WHERE id = '$inserted_id'");
         }

         if (isset($_FILES['company_certification']) && $_FILES['company_certification']['error'] == 0) {

            $certification_name = $_FILES["company_certification"]["name"];

            $certification_file_name = $inserted_id . '_CERTIFICATION.pdf';
            $certification_old_path = $_FILES["company_certification"]["tmp_name"];
            $certification_new_path = 'upload_file/CERTIFICATION/' . $certification_file_name;
            move_uploaded_file($certification_old_path, $certification_new_path);

            mysqli_query($db_conn, "UPDATE tbl_companies SET certification = '$certification_file_name', certification_name = '$certification_name' WHERE id = '$inserted_id'");
         }

         $_SESSION["message"] = "Company created successfully.";
      } else {
         $_SESSION["message"] = "Failed to create company.";
      }

      header("Refresh: .3; url=" . $_SERVER['PHP_SELF']);
      ob_end_flush();
      exit;
   }
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">
   <div class="card shadow mb-4">
      <div class="card-header py-3.5 pt-4">
         <h4 class="float-left">Company List</h4>
         <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#createCompanyModal" onclick="resetForm();">
            <i class="fa fa-plus pr-1"></i> Add Company
         </button>
      </div>

      <div class="card-body">
         <div class="table-responsive">
            <table class=" table table-bordered table-hover" id="companyTable" width="100%" cellspacing="0">
               <thead class="bg-primary text-white">
                  <tr class="text-center">
                     <th>ID</th>
                     <th>Company Name</th>
                     <th>Address</th>
                     <th>Contact Person</th>
                     <th>Status</th>
                     <th style="width: 170px;">Actions</th>
                  </tr>
               </thead>

               <tbody>

                  <?php
                  $result = mysqli_query($db_conn, "SELECT * FROM tbl_companies ORDER BY id ASC");
                  if (mysqli_num_rows($result) > 0):
                     while ($row = mysqli_fetch_assoc($result)):
                  ?>

                        <tr>
                           <td class="text-center"><?php echo !empty($row["id"]) ? $row["id"] : "" ?></td>
                           <td><?php echo !empty($row["company_name"]) ? $row["company_name"] : "" ?></td>
                           <td><?php echo !empty($row["company_address"]) ? $row["company_address"] : "" ?></td>
                           <td><?php echo !empty($row["contact_person"]) ? $row["contact_person"] : "" ?></td>
                           <td><?php echo isset($row["company_status"]) ? getStatusValue($row["company_status"]) : "" ?></td>
                           <td class="d-flex justify-content-center align-items-center">
                              <button type="button" class="btn btn-sm btn-primary mr-2" onclick="viewDetails(<?php echo $row['id']; ?>)">
                                 <i class="fas fa-eye"></i> View
                              </button>
                           </td>
                        </tr>

                  <?php
                     endwhile;
                  endif;
                  ?>

               </tbody>
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
   $(document).ready(function() {
      $('#companyTable').DataTable();
   });

   function viewDetails(companyId) {
      $.ajax({
         url: '../includes/ajax.php',
         type: 'POST',
         data: {
            action: 'company_details',
            company_id: companyId
         },
         dataType: 'json',
         success: function(response) {

            $('#companyDetails_name').text("Name");
            $('#companyDetails_email').text("Email");
            $('#companyDetails_address').text("adddd");




            // $('#viewCompanyModal #companyAddress').text(company.company_address);
            // $('#viewCompanyModal #companyNumber').text(company.company_number);
            // $('#viewCompanyModal #contactPerson').text(company.contact_person);
            // $('#viewCompanyModal #contactNumber').text(company.contact_number);
            // $('#viewCompanyModal #companyLink').html('<a href="' + company.company_link + '" target="_blank">' + company.company_link + '</a>');
            // $('#viewCompanyModal #companyStatus').text(company.company_status == 1 ? 'Active' : 'Inactive');

            // // Display file links if they exist
            // if (company.bir) {
            //    $('#viewCompanyModal #companyBIR').html('<a href="upload_file/BIR/' + company.bir + '" target="_blank">' + company.bir_name + '</a>');
            // } else {
            //    $('#viewCompanyModal #companyBIR').text('N/A');
            // }

            // if (company.dti) {
            //    $('#viewCompanyModal #companyDTI').html('<a href="upload_file/DTI/' + company.dti + '" target="_blank">' + company.dti_name + '</a>');
            // } else {
            //    $('#viewCompanyModal #companyDTI').text('N/A');
            // }

            // if (company.permit) {
            //    $('#viewCompanyModal #companyPermit').html('<a href="upload_file/PERMIT/' + company.permit + '" target="_blank">' + company.permit_name + '</a>');
            // } else {
            //    $('#viewCompanyModal #companyPermit').text('N/A');
            // }

            // if (company.invoice) {
            //    $('#viewCompanyModal #companyInvoice').html('<a href="upload_file/INVOICE/' + company.invoice + '" target="_blank">' + company.invoice_name + '</a>');
            // } else {
            //    $('#viewCompanyModal #companyInvoice').text('N/A');
            // }
         }
      });

      $('#viewCompanyModal').modal('show');
   }

   function resetForm() {
      // $('#title').val('');
      // $('#firstname').val('');
      // $('#lastname').val('');
      // $('#username').val('');
      // $('#role').val('');
   }

   // Add Company Number 
   function addCompanyNumber() {
      const companyNumberList = document.getElementById("companyNumberList");
      const newNumberDiv = document.createElement("div");
      newNumberDiv.className = "d-flex align-items-stretch mb-2";
      newNumberDiv.innerHTML = `
      <input type="number" name="company_number[]" class="form-control">
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
      const contactNumberList = document.getElementById("contactNumberList");
      const newContactDiv = document.createElement("div");
      newContactDiv.className = "d-flex align-items-stretch mb-2";
      newContactDiv.innerHTML = `
      <input type="number" name="contact_number[]" class="form-control">
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