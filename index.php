<?php
session_start();

if (isset($_SESSION['user_access'])) {
   if ($_SESSION['user_access'] == 1) {
      header('location: pages/admin_dashboard.php');
   } elseif ($_SESSION['user_access'] == 2) {
      header('location: user_dashboard.php');
   } elseif ($_SESSION['user_access'] == 3) {
      header('location: viewer_dashboard.php');
   }
} else {
   // header('location: ../index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="">
   <meta name="author" content="">

   <title>Parametric E&C</title>
   <link rel="icon" type="image/png" href="assets/img/logo.png">

   <!-- Custom fonts for this template-->
   <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
   <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

   <!-- Custom styles for this template-->
   <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
   <style>
      .card {
         background-color: rgba(255, 255, 255, 0.15) !important;
         box-shadow: none !important;
      }

      .form-control {
         background-color: rgba(255, 255, 255, 0.3) !important;
         border: 1px solid rgba(255, 255, 255, 0.5) !important;
         color: #000 !important;
      }

      .btn-primary {
         background-color: rgba(0, 123, 255, 0.6) !important;
         border-color: rgba(0, 123, 255, 0.6) !important;
      }
   </style>
</head>

<body class="bg-cover d-flex align-items-center justify-content-center text-white" style="height:100vh; background: url('assets/img/bg.jpg') no-repeat center center; background-size: cover; background-attachment: fixed;">

   <div class="container">
      <div class="row justify-content-center align-items-center min-vh-100">
         <div class="col-lg-12">
            <div class="card o-hidden border-0 shadow-lg">
               <div class="row no-gutters" style="height: 600px;">

                  <div class="col-md-12 d-flex align-items-center justify-content-center" style="background-color: rgba(255, 255, 255, 0.3);">
                     <div class="p-5 w-100" style="max-width: 400px;">

                        <!-- Logo / Title -->
                        <div class="text-center mb-4">
                           <img src="assets/img/logo.png"
                              alt="Company Logo"
                              class="img-fluid mb-3"
                              style="width: 80px; height: 80px; object-fit: contain;">
                           <h2 class="h4 text-dark">Parametric E&C</h2>
                           <p class="text-muted">Inventory Management System</p>
                        </div>

                        <!-- Form -->
                        <form class="user" id="loginForm">
                           <div class="form-group input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-user"></i>
                                 </span>
                              </div>
                              <input type="text" class="form-control" name="username" placeholder="Enter Username" required>
                           </div>

                           <div class="form-group input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-lock"></i>
                                 </span>
                              </div>
                              <input type="password" class="form-control" name="password" placeholder="Password" required>
                           </div>

                           <button type="submit" class="btn btn-primary btn-block">
                              <i class="fas fa-sign-in-alt"></i> Login
                           </button>
                        </form>

                     </div>
                  </div>

               </div>
            </div>
         </div>
      </div>
   </div>


   <!-- Bootstrap core JavaScript-->
   <script src="vendor/jquery/jquery.min.js"></script>
   <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

   <!-- Core plugin JavaScript-->
   <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

   <!-- Custom scripts for all pages-->
   <script src="assets/js/sb-admin-2.min.js"></script>

</body>

</html>

<script>
   $("#loginForm").on("submit", function(e) {
      e.preventDefault(); // stop normal form submit
      login(); // call your AJAX function
   });

   function login() {
      var username = document.querySelector('input[name="username"]').value;
      var password = document.querySelector('input[name="password"]').value;

      if (username && password) {
         $.ajax({
            type: "POST",
            url: "includes/ajax.php",
            data: {
               action: "login",
               username: username,
               password: password
            },
            success: function(response) {
               if (response === "admin") {
                  window.location.href = "pages/admin_dashboard.php";
               } else if (response === "user") {
                  window.location.href = "pages/user_dashboard.php";
               } else if (response === "viewer") {
                  window.location.href = "pages/viewer_dashboard.php";
               } else {
                  alert("Incorrect username or password.");
                  document.querySelector('input[name="username"]').value = "";
                  document.querySelector('input[name="password"]').value = "";
               }
            },
            error: function() {
               alert("An error occurred while processing your request.");
            }
         });
      } else {
         alert("Please enter both username and password.");
         document.querySelector('input[name="username"]').value = "";
         document.querySelector('input[name="password"]').value = "";
      }
   }
</script>