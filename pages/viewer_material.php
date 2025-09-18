<?php
include('../includes/header.php');

if (isset($_SESSION['user_access'])) {
   if ($_SESSION['user_access'] == 1) {
      header('location: admin_dashboard.php');
   } elseif ($_SESSION['user_access'] == 2) {
      header('location: user_dashboard.php');
   } elseif ($_SESSION['user_access'] == 3) {
      //   header('location: viewer_dashboard.php');
   }
} else {
   header('location: ../index.php');
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">
   <div class="card shadow mb-4">
      <div class="card-header py-3.5 pt-4">
         <h4 class="float-left">Materials List</h4>
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
</script>