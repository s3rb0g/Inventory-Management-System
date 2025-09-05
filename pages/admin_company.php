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

   // Delete company .................................................................................
   if (isset($_POST['delete_company'])) {
      $id = $_POST['id'];
      $result = mysqli_query($db_conn, "DELETE FROM tbl_companies WHERE id='$id' ");

      if ($result) {
         $_SESSION["message"] = "Company deleted successfully.";
      } else {
         $_SESSION["message"] = "Failed to delete company.";
      }

      header("Refresh: .3; url=" . $_SERVER['PHP_SELF']);
      ob_end_flush();
      exit;
   }

   // Edit company ...................................................................................
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
         <button type="button" class="btn btn-primary float-right" onclick="resetForm();">
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
                     <th style="width: 170px;">Action</th>
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
                              <button type="button" class="btn btn-sm btn-primary mr-2" onclick="viewCompanyDetails(<?php echo $row['id']; ?>)">
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

   function viewCompanyDetails(companyId) {
      $.ajax({
         url: '../includes/ajax.php',
         type: 'POST',
         data: {
            action: 'company_details',
            company_id: companyId
         },
         dataType: 'json',
         success: function(response) {

            $('#companyDetails_name').text(response.company_name);
            $('#companyDetails_email').html(response.company_email);
            $('#companyDetails_address').text(response.company_address);

            $('#companyDetails_number').html(response.company_number);
            $('#companyDetails_conPerson').text(response.contact_person);
            $('#companyDetails_conNumber').html(response.contact_number);
            $('#companyDetails_status').text(response.company_status);

            $('#companyDetails_link').html(response.company_link);
            $('#companyDetails_link_btn').html(response.company_link_btn);

            $('#companyDetails_bir').html(response.bir_name);
            $('#companyDetails_bir_btn').html(response.bir_btn);

            $('#companyDetails_dti').html(response.dti_name);
            $('#companyDetails_dti_btn').html(response.dti_btn);

            $('#companyDetails_permit').html(response.permit_name);
            $('#companyDetails_permit_btn').html(response.permit_btn);

            $('#companyDetails_invoice').html(response.invoice_name);
            $('#companyDetails_invoice_btn').html(response.invoice_btn);

            $('#companyDetails_certification').html(response.certification_name);
            $('#companyDetails_certification_btn').html(response.certification_btn);

            $("#deleteCompany_btn").attr("onclick", "deleteCompany(" + response.company_id + ")");
            $("#editCompany_btn").attr("onclick",
               "editCompany(" +
               JSON.stringify(companyId) + ", " +
               JSON.stringify(response.company_name) + ", " +
               JSON.stringify(response.company_email_edit) + ", " +
               JSON.stringify(response.company_address) + ", " +
               JSON.stringify(response.company_number_edit) + ", " +
               JSON.stringify(response.contact_person) + ", " +
               JSON.stringify(response.contact_number_edit) + ", " +
               JSON.stringify(response.company_link_edit) + ", " +
               JSON.stringify(response.company_status_edit) +
               ")"
            );

            $('#viewCompanyModal').modal('show');
         },
         error: function(xhr, status, error) {
            console.error("AJAX Error:");
            console.error("Response Text: " + xhr.responseText);
         }
      });

   }

   function deleteCompany(id) {
      $('#delete_company_id').val(id);
      $('#viewCompanyModal').modal('hide');
      $('#deleteCompanyModal').modal('show');
   }

   function editCompany(id, name, email, address, companyNumber, contactPerson, contactNumber, link, status) {

      $('#edit_company_id').val(id);
      $('#edit_company_name').val(name);
      $('#edit_company_email').val(email);
      $('#edit_company_address').val(address);
      $('#edit_contact_person').val(contactPerson);
      $('#edit_company_link').val(link);
      $('#edit_companystatus').val(status).text(status == 1 ? "Active" : "Inactive");

      const companyNumberList = $('#edit_companyNumberList');
      companyNumberList.empty();
      companyNumber.forEach(function(comNumber) {
         companyNumberList.append(`
         <div class="d-flex align-items-stretch mb-2">
            <input type="number" name="edit_company_number[]" class="form-control" value="${comNumber}">
            <button type="button" class="btn btn-danger btn-sm ml-2 mt-1" style="height: 30px;" onclick="removeCompanyNumber(this)">
               <i class="fa fa-times" aria-hidden="true"></i>
            </button>
         </div>`);
      });

      const contactNumberList = $('#edit_contactNumberList');
      contactNumberList.empty();
      contactNumber.forEach(function(conNumber) {
         contactNumberList.append(`
         <div class="d-flex align-items-stretch mb-2">
            <input type="number" name="edit_contact_number[]" class="form-control" value="${conNumber}" required>
            <button type="button" class="btn btn-danger btn-sm ml-2 mt-1" style="height: 30px;" onclick="removeContactNumber(this)">
               <i class="fa fa-times" aria-hidden="true"></i>
            </button>
         </div>`);
      });

      $('#viewCompanyModal').modal('hide');
      $('#editCompanyModal').modal('show');
   }

   function resetForm() {
      $('#company_name').val('');
      $('#company_email').val('');
      $('#company_address').val('');
      $('#company_number').val('');
      $('#contact_person').val('');
      $('#contact_number').val('');
      $('#company_link').val('');

      $('#company_bir').val('');
      $('#company_dti').val('');
      $('#company_permit').val('');
      $('#company_invoice').val('');
      $('#company_certification').val('');

      $('#createCompanyModal').modal('show');
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

   // FOR EDIT Add Company Number 
   function edit_addCompanyNumber() {
      const companyNumberList = document.getElementById("edit_companyNumberList");
      const newNumberDiv = document.createElement("div");
      newNumberDiv.className = "d-flex align-items-stretch mb-2";
      newNumberDiv.innerHTML = `
      <input type="number" name="edit_company_number[]" class="form-control">
      <button type="button" class="btn btn-danger btn-sm ml-2 mt-1" style="height: 30px;" onclick="edit_removeCompanyNumber(this)">
         <i class="fa fa-times" aria-hidden="true"></i>
      </button>`;
      companyNumberList.appendChild(newNumberDiv);
   }

   // FOR EDIT Remove Company Number 
   function edit_removeCompanyNumber(button) {
      const container = button.closest('.d-flex.align-items-stretch');
      const parentList = container.parentElement;
      const memberCount = parentList.querySelectorAll('.d-flex.align-items-stretch').length;
      if (memberCount > 1) {
         container.remove();
      }
   }

   // FOR EDIT Add Contact Number 
   function edit_addContactNumber() {
      const contactNumberList = document.getElementById("edit_contactNumberList");
      const newContactDiv = document.createElement("div");
      newContactDiv.className = "d-flex align-items-stretch mb-2";
      newContactDiv.innerHTML = `
      <input type="number" name="edit_contact_number[]" class="form-control">
      <button type="button" class="btn btn-danger btn-sm ml-2 mt-1" style="height: 30px;" onclick="edit_removeContactNumber(this)">
         <i class="fa fa-times" aria-hidden="true"></i>
      </button>`;
      contactNumberList.appendChild(newContactDiv);
   }

   // FOR EDIT Remove Contact Number 
   function edit_removeContactNumber(button) {
      const container = button.closest('.d-flex.align-items-stretch');
      const parentList = container.parentElement;
      const memberCount = parentList.querySelectorAll('.d-flex.align-items-stretch').length;
      if (memberCount > 1) {
         container.remove();
      }
   }
</script>