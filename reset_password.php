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
if(isset($_POST['submit'])){
   //check for input fields
   if(isset($_POST['username'])
   && isset($_POST['security_q'])
   && isset($_POST['answer'])
   && isset($_POST['pass1'])
   && isset($_POST['pass2']))
  
   //set variables
   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $question = mysqli_real_escape_string($conn, $_POST['security_q']);
   $answer = mysqli_real_escape_string($conn, $_POST['answer']);
   $pass1 = mysqli_real_escape_string($conn, $_POST['pass1']);
   $pass2 = mysqli_real_escape_string($conn, $_POST['pass2']);
   
   $password = md5($pass1); //set password variable
 
   //Check for username in the database

   //checking the patient table
   if (!empty($username)){
      $query = "SELECT * FROM patients WHERE username = '$username'";
      
      $result = mysqli_query($conn, $query);
      
      if($result){
         if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_assoc($result);
            $p_username = $row['username'];
            $p_password = $row['password_hashed'];
            $p_question = $row['security_q'];
            $p_answer = $row['answer'];

            //check if secuirty quesions matched
            if($question == $p_question && $answer == $p_answer){
               //check if passwords match
               if($pass1 == $pass2){
                  $update = "UPDATE `patients` SET `password_hashed`='$password' WHERE `username` = '$username'";
                  if(mysqli_query($conn, $update)){
                     $success = "Password Changed Successfully, Click <a href='index.php' class='btn btn-sm btn-success'>HERE</a> To Login";
                  }
               } else{
                  $error = "passwords do not match";
               }//end else

            } else {
                     $error = "Username does not match security question and answer";
            }//end else 
         }//end username check
      }//end query run

   }//end patient table


   //checking the doctor's table
   if (!empty($username)){
      $query = "SELECT * FROM doctors WHERE username = '$username'";
      
      $result = mysqli_query($conn, $query);
      
      if($result){
         if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_assoc($result);
            $p_username = $row['username'];
            $p_password = $row['password_hashed'];
            $p_question = $row['security_q'];
            $p_answer = $row['answer'];

            //check if secuirty quesions matched
            if($question == $p_question && $answer == $p_answer){
               //check if passwords match
               if($pass1 == $pass2){
                  $update = "UPDATE `doctor's` SET `password_hashed`='$password' WHERE `username` = '$username'";
                  if(mysqli_query($conn, $update)){
                     echo "success";
                  }
               } else{
                  echo "passwords do not match";
               }//end else

            } else {
                     echo "security question and answer does not match username";
            }//end else 
         } else{
            $error = "Username does not match security question and answer";
        }
      }//end query run


   }//end patient table


   }//end of submit button


?>

<html>
<head>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/telemedicine.css">
	<link rel="stylesheet" href="../css/index.css">
	<style>
	
	.navbar{
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

.jumbotron{
   padding:2em 3em;
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
    		<a class="btn btn-success mb-2 mr-sm-2" href="index.php">Login</a>
    </nav>
		<!-- end of header -->
</div>
</div>

<div class="row">		
<div class="col">
<div class="jumbotron " style="margin-bottom:0;">
<div class="text-center  col-md-5 text-success"><?php if(isset($success)){echo $success;} ?> </div>
<div class="text-center  col-md-5 text-danger"><?php if(isset($error)){echo $error;} ?> </div>
<form id="form" method="POST" action="" class="needs-validation" novalidate>

   <div class="form-group col-md-5">
   <small id="emailHelp" class="form-text text-muted mb-2">Username</small>
    <input type="text" class="form-control" placeholder="Username" name="username" value="<?php if( isset($username)){ echo $username; }?>"
                       required pattern=".{3,10}" title="3 to 10 characters">
     <div class="invalid-feedback">Enter your username</div>

  </div>

   <div class="form-group col-md-5">
       <small id="emailHelp" class="form-text text-muted mb-2">Enter the security question and answer you provided during the registration</small>
     <select class="custom-select" name="security_q" required value="<?php if( isset($question)){ echo $question; } ?>">
       <option value="" name=>Choose Security Question</option>
       <option value="q_one">In what city or town did your mother and father meet?</option>
       <option value="q_two">What was the last name of your favourite teacher?</option>
       <option value="q_three">What was your favorite food as a child?</option>
       <option value="q_four">What was your favorite place to visit as a child?</option>
       <option value="q_five">Where Did you travel for the first time?</option>
     </select>
     <div class="invalid-feedback">Please choose security question</div>
   </div>

   <div class="form-group col-md-5">
      <input type="text" class="form-control" placeholder="Answer" name="answer" required>
      <div class="invalid-feedback">Please Provide an answer</div>
   </div>


   <div class="form-group col-md-5">
   <small id="emailHelp" class="form-text text-muted mb-2">New Password</small>
     <input type="password" class="form-control" placeholder="Password" name="pass1" value="<?php if( isset($pass1)){ echo $pass1; }?>"
                         required pattern=".{6,15}" title="6 to 15 characters">
      <div class="invalid-feedback">*required *6 to 15 characters</div>
  </div>

   <div class="form-group col-md-5">
   <small id="emailHelp" class="form-text text-muted mb-2">New Password Confirmation</small>
       <input type="password" class="form-control" placeholder="Password Confirmation" name="pass2" value="<?php if( isset($pass2)){ echo $pass2; }?>"
                          required pattern=".{6,15}" title="6 to 15 characters">
        <div class="invalid-feedback"> *required *6 to 15 characters</div>
        <div class="exists"><?php if(isset($password_err)){echo $password_err;}?></div>
   </div>

   <input type="submit" name="submit" value="Submit Form" class="btn btn-sm btn-success form-group col-md-5">

</form>
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


<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
     You are signed in now!
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