</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
   <div class="container my-auto">
      <div class="copyright text-center my-auto">
         <span>Copyright &copy; Your Website 2021</span>
      </div>
   </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
   <i class="fas fa-angle-up"></i>
</a>

</body>

</html>

<?php
include("../includes/footer-link.php");
include("../includes/modal.php");
?>

<script>
   $("#passwordForm").on("submit", function(e) {
      e.preventDefault(); // stop normal form submit
      changePass(); // call your AJAX function
   });

   function changePass() {
      var currentPassword = document.querySelector('input[name="currentPassword"]').value;
      var newPassword = document.querySelector('input[name="newPassword"]').value;
      var confirmPassword = document.querySelector('input[name="confirmPassword"]').value;

      $.ajax({
         type: "POST",
         url: "../includes/ajax.php",
         data: {
            action: "changePassword",
            currentPassword: currentPassword,
            newPassword: newPassword,
            confirmPassword: confirmPassword
         },
         success: function(response) {

            if (response === "Password changed successfully.") {
               $('#passwordModal').modal('hide');
            }

            alert(response);
            document.querySelector('input[name="currentPassword"]').value = "";
            document.querySelector('input[name="newPassword"]').value = "";
            document.querySelector('input[name="confirmPassword"]').value = "";
         },
         error: function() {
            alert("An error occurred while processing your request.");
         }
      });

   }
</script>