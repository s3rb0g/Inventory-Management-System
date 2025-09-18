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
         <h4 class="float-left">Item List</h4>
      </div>

      <div class="card-body">
         <div class="table-responsive">
            <table class=" table table-bordered table-hover" id="itemTable" width="100%" cellspacing="0">
               <thead class="bg-primary text-white">
                  <tr class="text-center">
                     <th style="width: 50px;">ID</th>
                     <th style="width: 350px;">Item Name</th>
                     <th style="width: 200px;">Brand</th>
                     <th style="width: 130px;">Status</th>
                     <th style="width: 170px;">Action</th>
                  </tr>
               </thead>

               <tbody>

                  <?php
                  $result = mysqli_query($db_conn, "SELECT * FROM tbl_items ORDER BY id ASC");
                  if (mysqli_num_rows($result) > 0):
                     while ($row = mysqli_fetch_assoc($result)):
                  ?>

                        <tr>
                           <td class="text-center"><?php echo !empty($row["id"]) ? $row["id"] : "" ?></td>
                           <td><?php echo !empty($row["item_name"]) ? $row["item_name"] : "" ?></td>
                           <td><?php echo !empty($row["item_brand"]) ? $row["item_brand"] : "" ?></td>
                           <td><?php echo isset($row["item_status"]) ? getStatusValue($row["item_status"]) : "" ?></td>
                           <td class="d-flex justify-content-center align-items-center">
                              <button type="button" class="btn btn-sm btn-primary mr-2" onclick="viewItemDetails('<?php echo $row['id']; ?>')">
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
      $('#itemTable').DataTable();
   });

   function viewItemDetails(item_id) {
      $.ajax({
         url: '../includes/ajax.php',
         type: 'POST',
         data: {
            action: 'item_details',
            item_id: item_id
         },
         dataType: 'json',
         success: function(response) {
            $('#itemDetails_image').attr('src', response.item_image);
            $('#itemDetails_name').text(response.item_name);
            $('#itemDetails_brand').html(response.item_brand);
            $('#itemDetails_specification').html(response.item_specification);

            $('#itemDetails_sheet').html(response.item_dataname);
            $('#itemDetails_sheet_btn').html(response.item_datasheet);

            $('#itemDetails_status').html(response.item_status);

            $('#deleteItem_btn').attr('onclick', "deleteItem('" + response.item_id + "')");

            $('#editItem_btn').attr("onclick",
               "editItem(" +
               JSON.stringify(response.item_id) + ", " +
               JSON.stringify(response.item_name) + ", " +
               JSON.stringify(response.item_brand_edit) + ", " +
               JSON.stringify(response.item_specification_edit) + ", " +
               JSON.stringify(response.item_status_edit) +
               ")"
            );

            $('#viewItemModal').modal('show');
         },
         error: function(xhr, status, error) {
            console.error("AJAX Error:");
            console.error("Response Text: " + xhr.responseText);
         }
      });
   }
</script>