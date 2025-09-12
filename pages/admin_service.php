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
            $('#serviceDetails_name').text(response.material_item);
            $('#serviceDetails_company').text(response.material_company);
            $('#serviceDetails_location').text(response.material_address);
            $('#serviceDetails_vat').text(response.material_vat);
            $('#serviceDetails_price').text('₱ ' + response.material_cost);
            $('#serviceDetails_unit').text(response.material_unit);
            $('#serviceDetails_contact_person').text(response.material_person);
            $('#serviceDetails_contact_number').html(response.material_number);

            $('#deleteMaterial_btn').attr('onclick', "deleteMaterial('" + response.material_id + "')");

            $("#editMaterial_btn").attr("onclick",
               "editMaterial(" +
               JSON.stringify(response.material_id) + ", " +
               JSON.stringify(response.material_item_edit) + ", " +
               JSON.stringify(response.material_item) + ", " +

               JSON.stringify(response.material_company_edit) + ", " +
               JSON.stringify(response.material_company) + ", " +

               JSON.stringify(response.material_vat_edit) + ", " +
               JSON.stringify(response.material_vat) + ", " +

               JSON.stringify(response.material_cost) + ", " +
               JSON.stringify(response.material_unit) + ", " +
               JSON.stringify(response.material_status_edit) +
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
</script>