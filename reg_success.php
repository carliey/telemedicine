<?php
session_start();
require 'connection/sqlconnect.php';

//check for sessions
if (isset($_SESSION['patient_log']) && $_SESSION['patient_log'] == true){
 header('location: patient_dashboard.php');
 exit;
}
if (isset($_SESSION['doctor_log']) && $_SESSION['doctor_log'] == true){
 header('location: doc_dashboard.php');
 exit;
}
if (isset($_SESSION['admin_log']) && $_SESSION['admin_log'] == true){
 header('location: admin_dashboard.php');
 exit;
}
?>

<html>
<head>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/telemedicine.css">
	<link rel="stylesheet" href="../css/index.css">
	<style>
	
	.navbar{
         height: 150px;
         background:#bdf5bd;
      }

.btn-success:hover {
    color: #218838;
    background-color: #f8f9fa;
    border-color: #218838;
}

   .footer{
		width:100%;
		background: #bdf5bd;
		text-align:center;
		padding:5em;
	}
	
  .row{
    margin-right:0;
  }

	</style>
</head>
<body>
<div>
<div class="row">
<div class="col">
	<!-- header -->
    <nav class="navbar navbar-light ">
      <img src="../images/icons/logo.png" class="mx-auto mx-sm-1 mx-md-1">

    
    </nav>
		<!-- end of header -->
</div>
</div>

<div class="row">		
<div class="col">
<div class="jumbotron " style="margin-bottom:0;">
  <h1 class="display-4 text-center">Registration Successful</h1>
  <p class="lead text-center">Login To Start Using Our Services</p>
  <hr class="my-4">
  <div class="text-center">
  <a class="btn btn-success mb-2 mr-sm-2" href="index.php">Login</a>
  </div>
</div>
</div>
</div>
</div>

<div class="row">
   <div class="col">
      <div class="footer">
		<span>Telemedicine Nigeria © 2018</span>
      </div>
   </div>
</div>
	<!-- Optional JavaScript -->
   <!-- jQuery first, then Popper.js, then Bootstrap JS -->
   <script src="../scripts/jquery-3.3.1.js"></script>
	<script src="../scripts/popper.min.js"></script>
	<script src="../scripts/bootstrap.js"></script>
	<script>
		   // Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
</body>
</html>