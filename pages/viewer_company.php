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
         <h4 class="float-left">Company List</h4>
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
</script>