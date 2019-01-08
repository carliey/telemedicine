<?php

session_start();
   require 'connection/sqlconnect.php';
	

if(!isset($_SESSION["pending"]) || $_SESSION["pending"] !== true){
   header('location: index.php');
} else{
    //set session variables
    
     //get doctor's details from database
   $query = "SELECT * FROM doctors WHERE `did` = '".$_SESSION['id']."'";
   $result = mysqli_query($conn, $query);
   if($result){
       if(mysqli_num_rows($result) == 1){
           $row = mysqli_fetch_assoc($result);
           $id = $row['did'];
           $firstname = $row['firstname'];	
           $lastname = $row['lastname'];	
           $username = $row['username'];
           $password = $row['password_hashed'];
           $gender = $row['speciality'];
           $age = $row['gender'];
           $genotype = $row['qualification'];
           $blood = $row['mdcn'];
           $contact = $row['school'];
           $state = $row['state'];
           $city = $row['city'];
           $address = $row['hospital'];
           $image_url = $row['image_url'];

           //set profile picture 
           if($image_url == "nopic"){
            $default = "uploads/defaultpic.png";
              $img_src = $default; 
          }else{
          $img_src = "uploads/".$image_url;
           }
       
       
        }
    }
}//end of session

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
		padding:3em;
	}

	
	</style>
</head>
<body>
<div>
<div class="row">
<div class="col">
	<!-- header -->
   <nav class="navbar navbar-light">
      <img src="../images/icons/logo.png" class="mx-auto mx-sm-1 mx-md-1">

    	<div class="dropdown open   ">
                    <button class="btn btn-success  dropdown-toggle float-right mt-3 mr-3" type="button" id="dropdownMenu3"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-sign-out"></i><span class="pr-1"> Logged in as <?php echo $username; ?> with Doctor ID<?php echo $id; ?></span> </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="logout.php"> <button class="btn btn-success btn-sm">Log Out</button></a>

                    </div>
    </nav>
      <!-- end of header -->
</div>
</div>

<div class="row">		
<div class="col">
<div class="jumbotron " style="margin-bottom:0;">
  <h1 class="display-4 text-center">Welcome, Dr. <?php echo $username; ?></h1>
  <p class="lead text-center">Your details are still yet to be verified, kindly bear with us.</p>
  <p class="lead text-center">Thank you</p>
  <hr class="my-4">
  <div class="text-center">
  <a class="btn btn-success btn-lg text-center" href="logout.php" role="button">Logout</a>
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