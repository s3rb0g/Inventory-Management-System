<?php
include('../includes/header.php');

if (isset($_SESSION['user_access'])) {
   if ($_SESSION['user_access'] == 1) {
      // header('location: admin_dashboard.php');
   } elseif ($_SESSION['user_access'] == 2) {
      header('location: user_dashboard.php');
   } elseif ($_SESSION['user_access'] == 3) {
      header('location: viewer_dashboard.php');
   }
} else {
   header('location: ../index.php');
}

function updateMaterial($material_id)
{
   global $db_conn;
   $username = getFullname($_SESSION['user_id']);
   $result = mysqli_query($db_conn, "SELECT * FROM tbl_materials WHERE id = '$material_id' LIMIT 1");

   if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);

      $item = getItemName($row['material_item_id']);
      $company = getCompanyName($row['material_company_id']);
      $vat = getVatValue($row['material_vat']);
      $unitprice = $row['material_cost'] . ' ' . $row['material_unit'];
      $status = getStatusValue($row['material_status']);
      $date = $row['material_date'];

      mysqli_query($db_conn, "INSERT INTO tbl_history_materials (id, item_name, company, vat, unit_price, previous_update, updated_by, status) VALUES ('$material_id', '$item', '$company', '$vat', '$unitprice', '$date', '$username', '$status')");
   }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   // Add Material ....................................................................................
   if (isset($_POST['add_material'])) {
      $material_item = $_POST['material_item'];
      $material_company = $_POST['material_company'];
      $material_vat = $_POST['material_vat'];
      $material_cost = $_POST['material_cost'];
      $material_unit = filter_input(INPUT_POST, 'material_unit', FILTER_SANITIZE_SPECIAL_CHARS);

      $result = mysqli_query($db_conn, "INSERT INTO tbl_materials (material_item_id, material_company_id, material_vat, material_cost, material_unit, material_status) VALUES ('$material_item', '$material_company', '$material_vat', '$material_cost', '$material_unit', '1')");

      if ($result) {
         $_SESSION["message"] = "Material Registered successfully.";
      } else {
         $_SESSION["message"] = "Failed to register material.";
      }

      header("Refresh: .3; url=" . $_SERVER['PHP_SELF']);
      ob_end_flush();
      exit;
   }

   // Edit Material ....................................................................................
   if (isset($_POST['edit_material'])) {
      $edit_material_id = $_POST['edit_material_id'];
      $edit_material_item = $_POST['edit_material_item'];
      $edit_material_company = $_POST['edit_material_company'];
      $edit_material_vat = $_POST['edit_material_vat'];
      $edit_material_cost = $_POST['edit_material_cost'];
      $edit_material_unit = filter_input(INPUT_POST, 'edit_material_unit', FILTER_SANITIZE_SPECIAL_CHARS);
      $edit_material_status = $_POST['edit_material_status'];

      updateMaterial($edit_material_id);

      $result = mysqli_query($db_conn, "UPDATE tbl_materials SET material_item_id='$edit_material_item', material_company_id='$edit_material_company', material_vat='$edit_material_vat', material_cost='$edit_material_cost', material_unit='$edit_material_unit', material_status='$edit_material_status' WHERE id='$edit_material_id'");

      if ($result) {
         $_SESSION["message"] = "Material Updated successfully.";
      } else {
         $_SESSION["message"] = "Failed to Update material.";
      }

      header("Refresh: .3; url=" . $_SERVER['PHP_SELF']);
      ob_end_flush();
      exit;
   }

   // Delete Material .................................................................................
   if (isset($_POST['delete_material'])) {
      $id = $_POST['id'];
      $result = mysqli_query($db_conn, "DELETE FROM tbl_materials WHERE id='$id' ");

      if ($result) {
         $_SESSION["message"] = "Material deleted successfully.";
      } else {
         $_SESSION["message"] = "Failed to delete material.";
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
         <h4 class="float-left">Materials List</h4>
         <button type="button" class="btn btn-primary float-right" onclick="registerMaterial()">
            <i class="fa fa-plus pr-1"></i> Add Materials
         </button>
      </div>

      <div class="card-body">
         <div class="table-responsive">
            <table class=" table table-bordered table-scollable table-hover" id="materialTable" width="100%" cellspacing="0">
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
                  $result = mysqli_query($db_conn, "SELECT tbl_materials.*, tbl_companies.company_address FROM tbl_materials INNER JOIN tbl_companies ON tbl_materials.material_company_id=tbl_companies.id ORDER BY id ASC");
                  if (mysqli_num_rows($result) > 0):
                     while ($row = mysqli_fetch_assoc($result)):
                  ?>

                        <tr>
                           <td class="d-none"><?php echo !empty($row["id"]) ? $row["id"] : "" ?></td>
                           <td><?php echo !empty($row["material_item_id"]) ? getItemName($row["material_item_id"]) : "" ?></td>
                           <td><?php echo !empty($row["material_company_id"]) ? getCompanyName($row["material_company_id"]) : "" ?></td>
                           <td><?php echo !empty($row["company_address"]) ? $row["company_address"] : "" ?></td>
                           <td><?php echo isset($row["material_vat"]) ? getVatValue($row["material_vat"]) : "" ?></td>
                           <td><?php echo !empty($row["material_cost"]) ? ('₱ ' . $row["material_cost"]) : "" ?></td>
                           <td><?php echo !empty($row["material_unit"]) ? $row["material_unit"] : "" ?></td>
                           <td><?php echo isset($row["material_status"]) ? getStatusValue($row["material_status"]) : "" ?></td>
                           <td class="d-flex justify-content-center align-items-center">
                              <button type="button" class="btn btn-sm btn-primary mr-2" onclick="viewMaterialDetails(<?php echo $row['id']; ?>)">
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
      $('#materialTable').DataTable();
   });

   function registerMaterial() {
      $('#registerMaterialModal').modal('show');
   }

   function viewMaterialDetails(material_id) {
      $.ajax({
         type: "POST",
         url: "../includes/ajax.php",
         data: {
            action: 'material_details',
            material_id: material_id
         },
         dataType: "json",
         success: function(response) {
            $('#materialDetails_image').attr('src', response.material_image);
            $('#materialDetails_name').text(response.material_item);
            $('#materialDetails_company').text(response.material_company);
            $('#materialDetails_location').text(response.material_address);
            $('#materialDetails_brand').html(response.material_brand);
            $('#materialDetails_specification').text(response.material_specification);
            $('#materialDetails_vat').text(response.material_vat);
            $('#materialDetails_price').text('₱ ' + response.material_cost);
            $('#materialDetails_unit').text(response.material_unit);
            $('#materialDetails_contact_person').text(response.material_person);
            $('#materialDetails_contact_number').html(response.material_number);

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

            $.ajax({
               type: "POST",
               url: "../includes/ajax.php",
               data: {
                  action: 'material_recent_updates',
                  material_id: material_id
               },
               success: function(updates) {
                  if ($.fn.DataTable.isDataTable('#materialUpdates_table')) {
                     $('#materialUpdates_table').DataTable().clear().destroy();
                  }
                  $('#materialUpdates_table tbody').html(updates);
                  $('#materialUpdates_table').DataTable({
                     // "paging": false,
                     "searching": false,
                     // "info": false,
                     "lengthChange": false,
                     "ordering": false,
                     "pageLength": 5,
                     "autoWidth": false
                  })
               },
               error: function(xhr, status, error) {
                  console.error("AJAX Error:");
                  console.error("Response Text: " + xhr.responseText);
               }
            });

            $('#viewMaterialModal').modal('show');
         },
         error: function(xhr, status, error) {
            console.error("AJAX Error:");
            console.error("Response Text: " + xhr.responseText);
         }
      })
   }

   function editMaterial(id, itemId, itemName, companyId, companyName, vatId, vatName, cost, unit, status) {
      $('#edit_material_id').val(id);
      $('#edit_material_item_option').val(itemId).text(itemName);
      $('#edit_material_company_option').val(companyId).text(companyName);
      $('#edit_material_vat_option').val(vatId).text(vatName);
      $('#edit_material_cost').val(cost);
      $('#edit_material_unit').val(unit);
      $('#edit_material_status_option').val(status).text(status == 1 ? "Active" : "Inactive");

      $('#viewMaterialModal').modal('hide');
      $('#editMaterialModal').modal('show');
   }

   function deleteMaterial(id) {
      $('#delete_material_id').val(id);
      $('#viewMaterialModal').modal('hide');
      $('#deleteMaterialModal').modal('show');
   }
</script>