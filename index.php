<?php
  // Initialize the session
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

if(isset($_POST['login'])){

	//check fields
	if (isset($_POST['username']) && isset($_POST['password'])){
		//set variables
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$password_hash = md5($password);
		
		//check is user is a patient
		if (!empty($username) && !empty($password)){
			$query = "SELECT * FROM patients WHERE username = '$username' and password_hashed = '$password_hash'";
			
			$result = mysqli_query($conn, $query);
			
			if($result){
				if(mysqli_num_rows($result) == 1){
					$row = mysqli_fetch_assoc($result);
					$username = $row['username'];
					$id = $row['pid'];
					$status = $row['status'];

					if($status == "Inactive"){
						$_SESSION['inactive'] = true;
						$_SESSION['username'] = $username;
						$_SESSION['id'] = $id;
						header('location: inactive.php');
					} else {
						session_start();
					   $_SESSION['patient_log'] = true;
					   $_SESSION['username'] = $username;
				   	$_SESSION['id'] = $id;
				   	header('location: patient_dashboard.php');
					}
					
				}
			}
		//check if user is a doctor
			$query = "SELECT * FROM doctors WHERE username = '$username' and password_hashed = '$password_hash'";
			
			$result = mysqli_query($conn, $query);
			
			if($result){
				if(mysqli_num_rows($result) == 1){
					$row = mysqli_fetch_assoc($result);
					$id = $row['did'];
					$username = $row['username'];
					$status = $row['status'];

					if($status == "pending"){
						session_start();
						$_SESSION['pending'] = true;
						$_SESSION['id'] = $id;
						$_SESSION['username'] = $username;
						header('location: pending.php');
					} elseif($status == "Inactive"){
						session_start();
						$_SESSION['inactive'] = true;
						$_SESSION['id'] = $id;
						$_SESSION['username'] = $username;
						header('location: inactive.php');
					} else {
						session_start();
					   $_SESSION['doctor_log'] = true;
				    	$_SESSION['id'] = $id;
				   	$_SESSION['username'] = $username;
				   	header('location: doc_dashboard.php');
					}// end of 
				}
			} 
		//check if the user is an admin
			$query = "SELECT * FROM administrator WHERE username = '$username' and password_hashed = '$password_hash'";
		
			$result = mysqli_query($conn, $query);
			if($result){
				if(mysqli_num_rows($result) == 1){
					$row = mysqli_fetch_assoc($result);
					$id = $row['id'];
					$username = $row['username'];
					session_start();
					$_SESSION['admin_log'] = true;
					$_SESSION['id'] = $id;
					$_SESSION['admin'] = $username;
					header('location: admin_dashboard.php');
				
				}else {
					$notmatch_err = "Incorrect username or password";
				}
			}   

		}  
		
	}//end fieldcheck
}//end submit
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
		cursor:pointer;
}

	.user_err{
		color:red;
		border:1px solid;
	}
	.invalid-feedback{
		color:red;
		width:180px;
	}
	.nomatch{
		color:red;
		margin-left:400px;
	}

.row { 
    margin-right:0;
}

   .footer{
		width:100%;
		background: #bdf5bd;
		text-align:center;
		padding:2em;
	}

	a:hover{
		text-decoration:none;
	}

	.col{
		padding-right:0;
	}
	
	.col-5{
		padding-right:0;
	}

.reset{
	color: #218838;
}

.reset:hover{
	color:#218838;
	text-decoration:underline;
	border-radius:10px;
}

.invalid-feedback{
	width:40%;
  margin:0; 
	padding:0;
}

	</style>
</head>
<body>

    <nav class="navbar navbar-light row navbar-row ">

<!-- <div class="col-md-2 col-sm-12 mx-auto mx-sm-1 mx-md-1"> -->
	<!-- header -->
		 <img src="../images/icons/logo.png" class="mx-auto mx-md-1" >
<!-- </div> -->

<!-- <div class="col-md-5 col-sm-2">
<small style="float:right; color:red; font-size:80%; padding-bottom:25px;"><?php if( isset($notmatch_err)){ echo $notmatch_err; }?></small>
</div>

<div class="col-md-5 col-sm-8">
   <form class="needs-validation" action="index.php" method="POST" novalidate>
		 <div class="form-group row">
	        <input type="text" class="form-control col-md-3 col-sm-4 mb-2 mr-sm-2" id="usernameInput" placeholder="Enter Username" name="username" required pattern=".{3,15}" title="3 to 10 characters" value="<?php if( isset($username)){ echo $username; }?>">
		     <input type="password" class="form-control col-md-3 col-sm-3 mb-2 mr-sm-2" id="passwordInput" placeholder="Enter Password" name="password" required pattern=".{6,15}" title="6 to 15 characters" >
	    	  <input class="btn-sm btn-success form-control col-md-2 col-sm-2 mb-2 mr-sm-2" type="submit" value="login" name="login">
		     <a class="btn-sm text-center btn-success form-control col-md-2 col-sm-2 mb-2 mr-sm-2 pt-2" href="registration.php">Register</a>
		     <div class="invalid-feedback" id="inlineFormInputName2"> *username and password are required</div>
			   <a class="reset" href="reset_password.php"><?php if( isset($notmatch_err)){ echo 'Forgot Password?'; }?></a>
		</div>
	</form>
</div> -->

<form class=" needs-validation mx-auto mx-md-1" action="index.php" method="POST" novalidate>
	<div class="form-row">
    <div class="form-group mb-2 mx-auto p-1 col-8 col-sm-3">
       <input type="text" class="form-control form-control-sm  mb-2 mr-sm-2" id="validationCustom01" placeholder="Enter Username" name="username" required pattern=".{3,15}" title="3 to 10 characters" value="<?php if( isset($username)){ echo $username; }?>">
		 <div class="invalid-feedback w-100"> *Username is required </div>
		 <small style="color:red;"><?php if( isset($notmatch_err)){ echo $notmatch_err; }?></small>    
    </div>
    <div class="form-group mb-2 mx-auto p-1 col-8 col-sm-3">
       <input type="password" class="form-control form-control-sm mb-2 mr-sm-2" id="validationCustom02" placeholder="Enter Password" name="password" required pattern=".{6,15}" title="6 to 15 characters" >
		 <div class="invalid-feedback w-100"> *Password is required </div>
		 <a class="reset w-100" href="reset_password.php"><small><?php if( isset($notmatch_err)){ echo 'Forgot Password?'; }?></small></a>
		</div>
  <div class="form-group mb-2 mx-auto p-1 col-8 col-sm-3">
  <input class="btn btn-sm btn-success form-control mb-2 mr-sm-2" type="submit" value="login" name="login">
  </div>
  <div class="form-group mb-2 mx-auto p-1 col-8 col-sm-3">
  <a class="btn-sm text-center btn-success form-control mb-2 mr-sm-2" href="registration.php">Register</a>
  </div>
</div>

</form>    	

</nav>
		<!-- end of header -->

<div class="row">		
<div class="col">
<section>
	<div class="card text-white">
		 <img src="../images/bg-large.jpg" alt="Card image">
       <div class="card-img-overlay">
          <h1 class="card-title text-center display-4 text-white">Consult Online Doctors Anytime</h1>
			 <ul class="list-group list-group-flush mt-5 pt-3">
			    <h4 class="text-center display-5">Why Telemedicine?</h4>
				 <li class="list-group-item"> - Save Time</li>
				 <li class="list-group-item"> - Save Money</li>
				 <li class="list-group-item"> - Comfort Of Your Home</li>
			 </ul>
       </div>
  </div>
</section>
</div>
</div>

<div class="row">
   <div class="col">
      <div class="footer">
		<span>Telemedicine Nigeria © 2018</span>
      </div>
   </div>
</div>

<!-- Modal -->

<div class="modal fade" id="suggestion-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="suggestion-modal">Enter Suggestion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

     <p style="color:red; text-align:center;"><?php if (isset($feeback_err)){echo $feeback_err;}?></p>
     <p style="color:green; text-align:center;"> <?php if (isset($feeback_success)){echo $feeback_success;}?></p>
            <div class="text-center">
              <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
              <button type="submit" name="save" value="" class="btn btn-success ">Send</button>
            </div>
          </div>

          <!-- modal-body-end -->
        </form>
      </div>
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