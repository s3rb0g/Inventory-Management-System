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

if (!isset($_GET['id']) || empty($_GET['id'])) {
   echo "<script>
            alert('No company ID provided. Please check the ID and try again.');
            window.location.href = 'admin_company.php';
         </script>";
   exit;
}

$id = intval($_GET['id']);
$result = mysqli_query($db_conn, "SELECT * FROM tbl_companies WHERE id = $id");

if (mysqli_num_rows($result) == 0) {
   echo "<script>
            alert('Company not found. Please select a company again.');
            window.location.href = 'admin_company.php';
         </script>";
   exit;
}

$company = mysqli_fetch_assoc($result);

$company_number = explode(',', $company['company_number']);
$contact_number = explode(',', $company['contact_number']);

?>

<!-- Begin Page Content -->
<div class="container-fluid">

   <div class="card shadow mb-4">
      <div class="card-header py-3.5 pt-4">
         <h4 class="float-left">Company Details</h4>

         <a href="admin_company.php">
            <button type="button" class="btn btn-primary float-right">
               <i class="fa fa-chevron-left pr-1"></i> Back to List
            </button>
         </a>
      </div>

      <div class="card-body">
         <div class="table-responsive table-bordered table-striped table-hover">
            <table class="table table-bordered">
               <tr>
                  <th class="col-3">Name</th>
                  <td class="col-8"><?php echo $company['company_name']; ?></td>
                  <td></td>
               </tr>
               <tr>
                  <th>Email</th>
                  <td><?php echo $company['company_email']; ?></td>
                  <td></td>
               </tr>
               <tr>
                  <th>Address</th>
                  <td><?php echo $company['company_address']; ?></td>
                  <td></td>
               </tr>
               <tr>
                  <th>Number</th>

                  <td>
                     <?php
                     foreach ($company_number as $index => $number) {
                        if ($index > 0) {
                           echo "<br>";
                        }
                        echo htmlspecialchars($number);
                     }
                     ?>
                  </td>
                  <td></td>

               </tr>
               <tr>
                  <th>Contact Person</th>
                  <td><?php echo $company['contact_person']; ?></td>
                  <td></td>
               </tr>
               <tr>
                  <th>Contact Number</th>
                  <td>
                     <?php
                     foreach ($contact_number as $index => $number) {
                        if ($index > 0) {
                           echo "<br>";
                        }
                        echo htmlspecialchars($number);
                     }
                     ?>
                  </td>
                  <td></td>
               </tr>
               <tr>
                  <th>Status</th>
                  <td><?php echo getStatusValue($company['company_status']); ?></td>
                  <td></td>
               </tr>
               <tr>
                  <th>BIR</th>
                  <td><?php echo !empty($company['bir_name']) ? $company['bir_name'] : "<i>No file uploaded</i>"; ?></td>
                  <td class="d-flex justify-content-center align-items-center">
                     <?php if (!empty($company['bir'])): ?>
                        <a href="upload_file/BIR/<?php echo $company['bir']; ?>" target="_blank">
                           <button class="btn btn-sm bg-primary text-white">View</button>
                        </a>
                     <?php else: ?>
                        <button class="btn btn-sm bg-primary text-white" disabled>Upload</button>
                     <?php endif; ?>
                  </td>
               </tr>
               <tr>
                  <th>DTI/SEC</th>
                  <td><?php echo !empty($company['dti_name']) ? $company['dti_name'] : "<i>No file uploaded</i>"; ?></td>
                  <td class="d-flex justify-content-center align-items-center">
                     <?php if (!empty($company['dti'])): ?>
                        <a href="upload_file/DTI/<?php echo $company['dti']; ?>" target="_blank">
                           <button class="btn btn-sm bg-primary text-white">View</button>
                        </a>
                     <?php else: ?>
                        <button class="btn btn-sm bg-primary text-white" disabled>Upload</button>
                     <?php endif; ?>
                  </td>
               </tr>
               <tr>
                  <th>Mayor's Permit</th>
                  <td><?php echo !empty($company['permit_name']) ? $company['permit_name'] : "<i>No file uploaded</i>"; ?></td>
                  <td class="d-flex justify-content-center align-items-center">
                     <?php if (!empty($company['permit'])): ?>
                        <a href="upload_file/PERMIT/<?php echo $company['permit']; ?>" target="_blank">
                           <button class="btn btn-sm bg-primary text-white">View</button>
                        </a>
                     <?php else: ?>
                        <button class="btn btn-sm bg-primary text-white" disabled>Upload</button>
                     <?php endif; ?>
                  </td>
               </tr>
               <tr>
                  <th>Sample Invoice</th>
                  <td><?php echo !empty($company['invoice_name']) ? $company['invoice_name'] : "<i>No file uploaded</i>"; ?></td>
                  <td class="d-flex justify-content-center align-items-center">
                     <?php if (!empty($company['invoice'])): ?>
                        <a href="upload_file/INVOICE/<?php echo $company['invoice']; ?>" target="_blank">
                           <button class="btn btn-sm bg-primary text-white">View</button>
                        </a>
                     <?php else: ?>
                        <button class="btn btn-sm bg-primary text-white" disabled>Upload</button>
                     <?php endif; ?>
                  </td>
               </tr>
            </table>
         </div>
      </div>
   </div>

</div>
<!-- /.container-fluid -->

<?php
include('../includes/footer.php');
?>

<!-- <div class="container">
   <h2>Company Details</h2>
   <table class="table table-bordered">
      <tr>
         <th>Name</th>
         <td>asdasd</td>
      </tr>
      <tr>
         <th>Email</th>
         <td>asdasd</td>
      </tr>
      <tr>
         <th>Address</th>
         <td>asdasd</td>
      </tr>
      <tr>
         <th>Number</th>
         <td>asdasd</td>
      </tr>
      <tr>
         <th>Contact Person</th>
         <td>asdasd</td>
      </tr>
      <tr>
         <th>Contact Number</th>
         <td>asdasd</td>
      </tr>
      <tr>
         <th>Status</th>
         <td>asdasd</td>
      </tr>
      <tr>
         <th>BIR</th>
         <td>
            <?php if (!empty($company['bir'])): ?>
               <a href="upload_file/<?php echo $company['bir']; ?>" target="_blank">View File</a>
            <?php else: ?>
               No file uploaded
            <?php endif; ?>
         </td>
      </tr>
      <tr>
         <th>DTI/SEC</th>
         <td>
            <?php if (!empty($company['dti'])): ?>
               <a href="upload_file/<?php echo $company['dti']; ?>" target="_blank">View File</a>
            <?php else: ?>
               No file uploaded
            <?php endif; ?>
         </td>
      </tr>
   </table>
   <a href="admin_company.php" class="btn btn-secondary">Back to List</a>
</div> -->