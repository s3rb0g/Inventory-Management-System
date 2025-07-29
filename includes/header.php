<?php
include("../includes/header-link.php");
include("../includes/ajax.php");
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
   <link rel="icon" type="image/png" href="../assets/img/logo.png">
</head>

<body id="page-top">

   <!-- Page Wrapper -->
   <div id="wrapper">

      <!-- Sidebar -->
      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

         <?php if ($_SESSION['user_access'] == 1): ?>

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin_dashboard.php">
               <div class="sidebar-brand-icon">
                  <i class="fas fa-warehouse"></i>
               </div>
               <div class="sidebar-brand-text mx-3">Inventory Management</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
               <a class="nav-link" href="admin_dashboard.php">
                  <i class="fas fa-fw fa-tachometer-alt"></i>
                  <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
               Components
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
               <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                  aria-expanded="true" aria-controls="collapseTwo">
                  <i class="fas fa-fw fa-cogs"></i>
                  <span>Management</span>
               </a>
               <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                     <a class="collapse-item" href="admin_account.php">Account</a>
                     <a class="collapse-item" href="admin_company.php">Company</a>
                     <a class="collapse-item" href="admin_item.php">Item</a>
                  </div>
               </div>
            </li>

         <?php elseif ($_SESSION['user_access'] == 2): ?>

         <?php endif; ?>

         <!-- Divider -->
         <hr class="sidebar-divider d-none d-md-block">

         <!-- Sidebar Toggler (Sidebar) -->
         <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
         </div>

      </ul>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">

         <!-- Main Content -->
         <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

               <!-- Topbar Navbar -->
               <ul class="navbar-nav ml-auto">

                  <div class="topbar-divider d-none d-sm-block mr-n1"></div>

                  <!-- Nav Item - User Information -->
                  <li class="nav-item dropdown no-arrow">
                     <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo getFullname() ?></span>
                        <img class="img-profile rounded-circle" src="../assets/img/undraw_profile.svg">
                     </a>
                     <!-- Dropdown - User Information -->
                     <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                           <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                           Logout
                        </a>
                     </div>
                  </li>

               </ul>

            </nav>
            <!-- End of Topbar -->