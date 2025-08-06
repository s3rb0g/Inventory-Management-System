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
?>

<!-- Begin Page Content -->
<div class="container-fluid">
   <div class="card shadow mb-4">
      <div class="card-header py-3.5 pt-4">
         <h4 class="float-left">Company List</h4>
         <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#createCompanyModal" onclick="resetForm();">
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
                     <th>Contact Person</th>
                     <th>Contact Number</th>
                     <th>Status</th>
                     <th style="width: 170px;">Actions</th>
                  </tr>
               </thead>

               <tbody>

                  <!-- <?php
                        $result = mysqli_query($db_conn, "SELECT * FROM tbl_accounts WHERE access != 1 ORDER BY id ASC");
                        if (mysqli_num_rows($result) > 0):
                           while ($row = mysqli_fetch_assoc($result)):
                        ?>

                        <tr>
                           <td class="text-center"><?php echo !empty($row["id"]) ? $row["id"] : "" ?></td>
                           <td><?php echo !empty($row["title"]) ? $row["title"] : "" ?></td>
                           <td><?php echo !empty($row["firstname"]) ? $row["firstname"] : "" ?></td>
                           <td><?php echo !empty($row["lastname"]) ? $row["lastname"] : "" ?></td>
                           <td><?php echo !empty($row["access"]) ? getAccessValue($row["access"]) : "" ?></td>
                           <td><?php echo isset($row["status"]) ? getStatusValue($row["status"]) : "" ?></td>
                           <td class="d-flex justify-content-center align-items-center">
                              <button type="button" class="btn btn-sm btn-primary mr-2" onclick="editAccount('<?php echo $row['id']; ?>', '<?php echo $row['title']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['username']; ?>', '<?php echo $row['access']; ?>', '<?php echo $row['status']; ?>')">Edit</button>
                              <button type="button" class="btn btn-sm btn-danger" onclick="deleteAccount()">Delete</button>
                           </td>
                        </tr>

                  <?php
                           endwhile;
                        endif;
                  ?> -->

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
      </button>
   `;
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

   // Add Company Number 
   function addContactNumber() {
      const contactNumberList = document.getElementById("contactNumberList");
      const newContactDiv = document.createElement("div");
      newContactDiv.className = "d-flex align-items-stretch mb-2";
      newContactDiv.innerHTML = `
      <input type="number" name="contact_number[]" class="form-control">
      <button type="button" class="btn btn-danger btn-sm ml-2 mt-1" style="height: 30px;" onclick="removeContactNumber(this)">
         <i class="fa fa-times" aria-hidden="true"></i>
      </button>
   `;
      contactNumberList.appendChild(newContactDiv);
   }

   // Remove Company Number 
   function removeContactNumber(button) {
      const container = button.closest('.d-flex.align-items-stretch');
      const parentList = container.parentElement;
      const memberCount = parentList.querySelectorAll('.d-flex.align-items-stretch').length;
      if (memberCount > 1) {
         container.remove();
      }
   }
</script>