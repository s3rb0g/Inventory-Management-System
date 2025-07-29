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
         <h4 class="float-left">Account List</h4>
         <button type="button" class="btn btn-secondary float-right">
            <i class="fa fa-plus pr-1"></i> Add Account
         </button>
      </div>

      <div class="card-body">
         <div class="table-responsive">
            <table class=" table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
               <thead class="">
                  <tr class="text-center">
                     <th>Title</th>
                     <th>Username</th>
                     <th>Password</th>
                     <th>Access</th>
                     <th>Status</th>
                     <th style="width: 170px;">Actions</th>
                  </tr>
               </thead>

               <tbody>
                  <tr>
                     <td>asd</td>
                     <td>asd</td>
                     <td>asd</td>
                     <td>asd</td>
                     <td>asd</td>
                     <td>asd</td>
                  </tr>
                  <tr>
                     <td>asd</td>
                     <td>asd</td>
                     <td>asd</td>
                     <td>asd</td>
                     <td>asd</td>
                     <td>asd</td>
                  </tr>
                  <tr>
                     <td>asd</td>
                     <td>asd</td>
                     <td>asd</td>
                     <td>asd</td>
                     <td>asd</td>
                     <td>asd</td>
                  </tr>
                  <tr>
                     <td>asd</td>
                     <td>asd</td>
                     <td>asd</td>
                     <td>asd</td>
                     <td>asd</td>
                     <td>asd</td>
                  </tr>
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