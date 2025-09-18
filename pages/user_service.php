<?php
include('../includes/header.php');

if (isset($_SESSION['user_access'])) {
   if ($_SESSION['user_access'] == 1) {
      header('location: admin_dashboard.php');
   } elseif ($_SESSION['user_access'] == 2) {
      //   header('location: user_dashboard.php');
   }
} else {
   header('location: ../index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   // Add Service ....................................................................................
   if (isset($_POST['add_service'])) {
      $service_name = filter_input(INPUT_POST, 'service_name', FILTER_SANITIZE_SPECIAL_CHARS);
      $service_company = $_POST['service_company'];
      $service_vat = $_POST['service_vat'];
      $service_cost = $_POST['service_cost'];
      $service_unit = filter_input(INPUT_POST, 'service_unit', FILTER_SANITIZE_SPECIAL_CHARS);

      $result = mysqli_query($db_conn, "INSERT INTO tbl_services (service_name, service_company_id, service_vat, service_cost, service_unit, service_status) VALUES ('$service_name', '$service_company', '$service_vat', '$service_cost', '$service_unit', '1')");

      if ($result) {
         $inserted_id = mysqli_insert_id($db_conn);

         if (isset($_FILES['service_sheet']) && $_FILES['service_sheet']['error'] == 0) {

            $sheet_name = $_FILES["service_sheet"]["name"];

            $sheet_file_name = $inserted_id . '_DATASHEET.pdf';
            $sheet_old_path = $_FILES["service_sheet"]["tmp_name"];
            $sheet_new_path = 'upload_file/DATASHEET/SERVICES/' . $sheet_file_name;
            move_uploaded_file($sheet_old_path, $sheet_new_path);

            mysqli_query($db_conn, "UPDATE tbl_services SET service_datasheet = '$sheet_file_name', service_dataname = '$sheet_name' WHERE id = '$inserted_id'");
         }

         $_SESSION["message"] = "Service Registered successfully.";
      } else {
         $_SESSION["message"] = "Failed to register service.";
      }

      header("Refresh: .3; url=" . $_SERVER['PHP_SELF']);
      ob_end_flush();
      exit;
   }

   // Edit Service ....................................................................................
   if (isset($_POST['edit_service'])) {
      $edit_service_id = $_POST['edit_service_id'];
      $edit_service_name = filter_input(INPUT_POST, 'edit_service_name', FILTER_SANITIZE_SPECIAL_CHARS);
      $edit_service_company = $_POST['edit_service_company'];
      $edit_service_vat = $_POST['edit_service_vat'];
      $edit_service_cost = $_POST['edit_service_cost'];
      $edit_service_unit = filter_input(INPUT_POST, 'edit_service_unit', FILTER_SANITIZE_SPECIAL_CHARS);
      $edit_service_status = $_POST['edit_service_status'];

      $result = mysqli_query($db_conn, "UPDATE tbl_services SET service_name='$edit_service_name', service_company_id='$edit_service_company', service_vat='$edit_service_vat', service_cost='$edit_service_cost', service_unit='$edit_service_unit', service_status='$edit_service_status' WHERE id='$edit_service_id'");

      if ($result) {

         if (isset($_FILES['edit_service_sheet']) && $_FILES['edit_service_sheet']['error'] == 0) {

            $sheet_name = $_FILES["edit_service_sheet"]["name"];

            $sheet_file_name = $edit_service_id . '_DATASHEET.pdf';
            $sheet_old_path = $_FILES["edit_service_sheet"]["tmp_name"];
            $sheet_new_path = 'upload_file/DATASHEET/SERVICES/' . $sheet_file_name;
            move_uploaded_file($sheet_old_path, $sheet_new_path);

            mysqli_query($db_conn, "UPDATE tbl_services SET service_datasheet = '$sheet_file_name', service_dataname = '$sheet_name' WHERE id = '$edit_service_id'");
         }

         $_SESSION["message"] = "Service Registered successfully.";
      } else {
         $_SESSION["message"] = "Failed to register service.";
      }

      header("Refresh: .3; url=" . $_SERVER['PHP_SELF']);
      ob_end_flush();
      exit;
   }

   // Delete Service .................................................................................
   if (isset($_POST['delete_service'])) {
      $id = $_POST['id'];
      $result = mysqli_query($db_conn, "DELETE FROM tbl_services WHERE id='$id' ");

      if ($result) {
         $_SESSION["message"] = "Service deleted successfully.";
      } else {
         $_SESSION["message"] = "Failed to delete service.";
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
         <h4 class="float-left">Service List</h4>
         <button type="button" class="btn btn-primary float-right" onclick="registerService()">
            <i class="fa fa-plus pr-1"></i> Add Service
         </button>
      </div>

      <div class="card-body">
         <div class="table-responsive">
            <table class=" table table-bordered table-scollable table-hover" id="serviceTable" width="100%" cellspacing="0">
               <thead class="bg-primary text-white">
                  <tr class="text-center">
                     <th class="d-none">ID</th>
                     <th style="width: 20%;">Name</th>
                     <th style="width: 20%;">Company</th>
                     <th style="width: 15%;">Location</th>
                     <th style="width: 10%;">VAT</th>
                     <th style="width: 10%;">Price</th>
                     <th style="width: 5%;">Unit</th>
                     <th style="width: 10%;">Status</th>
                     <th style="width: 10%;">Actions</th>
                  </tr>
               </thead>

               <tbody>

                  <?php
                  $result = mysqli_query($db_conn, "SELECT tbl_services.*, tbl_companies.company_address FROM tbl_services INNER JOIN tbl_companies ON tbl_services.service_company_id=tbl_companies.id ORDER BY id ASC");
                  if (mysqli_num_rows($result) > 0):
                     while ($row = mysqli_fetch_assoc($result)):
                  ?>

                        <tr>
                           <td class="d-none"><?php echo !empty($row["id"]) ? $row["id"] : "" ?></td>
                           <td><?php echo !empty($row["service_name"]) ? $row["service_name"] : "" ?></td>
                           <td><?php echo !empty($row["service_company_id"]) ? getCompanyName($row["service_company_id"]) : "" ?></td>
                           <td><?php echo !empty($row["company_address"]) ? $row["company_address"] : "" ?></td>
                           <td><?php echo isset($row["service_vat"]) ? getVatValue($row["service_vat"]) : "" ?></td>
                           <td><?php echo !empty($row["service_cost"]) ? ('₱ ' . $row["service_cost"]) : "" ?></td>
                           <td><?php echo !empty($row["service_unit"]) ? $row["service_unit"] : "" ?></td>
                           <td><?php echo isset($row["service_status"]) ? getStatusValue($row["service_status"]) : "" ?></td>
                           <td class="d-flex justify-content-center align-items-center">
                              <button type="button" class="btn btn-sm btn-primary mr-2" onclick="viewService(<?php echo $row['id']; ?>)">
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
      $('#serviceTable').DataTable();
   });

   function registerService() {
      $('#registerServiceModal').modal('show');
   }

   function viewService(service_id) {

      $.ajax({
         url: "../includes/ajax.php",
         type: "POST",
         data: {
            action: "service_details",
            service_id: service_id
         },
         dataType: "json",
         success: function(response) {
            $('#serviceDetails_name').text(response.service_name);
            $('#serviceDetails_company').text(response.service_company);
            $('#serviceDetails_location').text(response.service_address);
            $('#serviceDetails_vat').text(response.service_vat);
            $('#serviceDetails_price').text('₱ ' + response.service_cost);
            $('#serviceDetails_unit').text(response.service_unit);
            $('#serviceDetails_contact_person').text(response.service_person);
            $('#serviceDetails_contact_number').html(response.service_number);

            $('#deleteService_btn').attr('onclick', "deleteService('" + response.service_id + "')");

            $("#editService_btn").attr("onclick",
               "editService(" +
               JSON.stringify(response.service_id) + ", " +
               JSON.stringify(response.service_name) + ", " +

               JSON.stringify(response.service_company_edit) + ", " +
               JSON.stringify(response.service_company) + ", " +

               JSON.stringify(response.service_vat_edit) + ", " +
               JSON.stringify(response.service_vat) + ", " +

               JSON.stringify(response.service_cost) + ", " +
               JSON.stringify(response.service_unit) + ", " +
               JSON.stringify(response.service_status_edit) +
               ")"
            );

            $('#viewServiceModal').modal('show');

         },
         error: function(xhr, status, error) {
            console.error("AJAX Error:");
            console.error("Response Text: " + xhr.responseText);
         }
      });
   }

   function editService(id, serviceName, companyId, companyName, vatId, vatName, cost, unit, status) {
      $('#edit_service_id').val(id);
      $('#edit_service_name').val(serviceName);
      $('#edit_service_company_option').val(companyId).text(companyName);
      $('#edit_service_vat_option').val(vatId).text(vatName);
      $('#edit_service_cost').val(cost);
      $('#edit_service_unit').val(unit);
      $('#edit_service_status_option').val(status).text(status == 1 ? "Active" : "Inactive");

      $('#viewServiceModal').modal('hide');
      $('#editServiceModal').modal('show');
   }

   function deleteService(id) {
      $('#delete_service_id').val(id);
      $('#viewServiceModal').modal('hide');
      $('#deleteServiceModal').modal('show');
   }
</script>