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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   // Add account ....................................................................................
   if (isset($_POST['add_account'])) {
      $title = $_POST['title'];
      $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
      $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
      $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
      $role = $_POST['role'];
      $pass = 12345;
      $password = password_hash($pass, PASSWORD_DEFAULT);
      $status = 1;

      $result = mysqli_query($db_conn, "INSERT INTO tbl_accounts (title, firstname, lastname, username, access, status, password) VALUES ('$title', '$firstname', '$lastname', '$username', '$role', '$status', '$password')");

      if ($result) {
         $_SESSION["message"] = "Account created successfully.";
      } else {
         $_SESSION["message"] = "Failed to create account.";
      }

      header("Refresh: .3; url=" . $_SERVER['PHP_SELF']);
      ob_end_flush();
      exit;
   }

   // Edit account ....................................................................................
   if (isset($_POST['edit_account'])) {
      $id = $_POST['edit_id'];
      $title = $_POST['edit_title'];
      $firstname = filter_input(INPUT_POST, 'edit_firstname', FILTER_SANITIZE_SPECIAL_CHARS);
      $lastname = filter_input(INPUT_POST, 'edit_lastname', FILTER_SANITIZE_SPECIAL_CHARS);
      $username = filter_input(INPUT_POST, 'edit_username', FILTER_SANITIZE_SPECIAL_CHARS);
      $role = $_POST['edit_role'];
      $status = $_POST['edit_status'];

      $result = mysqli_query($db_conn, "UPDATE tbl_accounts SET title='$title', firstname='$firstname', lastname='$lastname', username='$username', access='$role', status='$status' WHERE id='$id'");

      if ($result) {
         $_SESSION["message"] = "Account updated successfully.";
      } else {
         $_SESSION["message"] = "Failed to update account.";
      }

      header("Refresh: .3; url=" . $_SERVER['PHP_SELF']);
      ob_end_flush();
      exit;
   }

   // Delete account submit ...........................................................................
   if (isset($_POST['delete_account'])) {
      $id = $_POST['id'];
      $result = mysqli_query($db_conn, "DELETE FROM tbl_accounts WHERE id='$id' ");

      if ($result) {
         $_SESSION["message"] = "Account deleted successfully.";
      } else {
         $_SESSION["message"] = "Failed to delete account.";
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
         <h4 class="float-left">Account List</h4>
         <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#createAccountModal" onclick="resetForm();">
            <i class="fa fa-plus pr-1"></i> Add Account
         </button>
      </div>

      <div class="card-body">
         <div class="table-responsive">
            <table class=" table table-bordered table-hover" id="accountTable" width="100%" cellspacing="0">
               <thead class="bg-primary text-white">
                  <tr class="text-center">
                     <th>ID</th>
                     <th>Title</th>
                     <th>Firstname</th>
                     <th>Lastname</th>
                     <th>Access</th>
                     <th>Status</th>
                     <th style="width: 170px;">Actions</th>
                  </tr>
               </thead>

               <tbody>

                  <?php
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
                              <button type="button" class="btn btn-sm btn-primary mr-2" onclick="editAccount('<?php echo $row['id']; ?>', '<?php echo $row['title']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['username']; ?>', '<?php echo $row['access']; ?>', '<?php echo $row['status']; ?>')">
                                 <i class="fa fa-edit"></i> Edit
                              </button>
                              <button type="button" class="btn btn-sm btn-danger" onclick="deleteAccount('<?php echo $row['id']; ?>')">
                                 <i class="fa fa-trash"></i> Delete
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
      $('#accountTable').DataTable();
   });

   function resetForm() {
      $('#title').val('');
      $('#firstname').val('');
      $('#lastname').val('');
      $('#username').val('');
      $('#role').val('');
   }

   function editAccount(id, title, firstname, lastname, username, access, status) {

      var titleLabel = title == "Ar." ? "Architect (Ar.)" : (title == "Engr." ? "Engineer (Engr.)" : "");
      var roleLabel = access == 2 ? "Editor" : "Viewer";
      var statusLabel = status == 1 ? "Active" : "Inactive";

      $('#edit_id').val(id);
      $('#edit_title').val(title).text(titleLabel);
      $('#edit_firstname').val(firstname);
      $('#edit_lastname').val(lastname);
      $('#edit_username').val(username);
      $('#edit_role').val(access).text(roleLabel);
      $('#edit_status').val(status).text(statusLabel);
      $('#editAccountModal').modal('show');
   }

   function deleteAccount(id) {
      $('#delete_account_id').val(id);
      $('#deleteAccountModal').modal('show');
   }
</script>