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
         <h4 class="float-left">Service List</h4>
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
</script>