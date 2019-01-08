<?php
session_start();
include 'connection/sqlconnect.php';

if(!isset($_SESSION["admin_log"]) || $_SESSION["admin_log"] !== true){
    header('location: index.php');
} else{
         //set session variables
     //get doctor's details from database
   $query = "SELECT * FROM administrator WHERE `id` = '".$_SESSION['id']."'";
   $result = mysqli_query($conn, $query);
   if($result){
       if(mysqli_num_rows($result) == 1){
           $row = mysqli_fetch_assoc($result);
           $id = $row['id'];
           $username = $row['username'];	
           $password = $row['password_hashed'];	
           $image_url = $row['image_url'];

 //set profile picture 
 if($image_url == "nopic"){
    $default = "uploads/defaultpic.png";
      $img_src = $default; 
  }else{
  $img_src = "uploads/".$image_url;
   }

      }
   }// end of database query

   if(isset($_POST['change_username']) && !empty($_POST['username'])){
      $new_username = $_POST['username'];
      if ($new_username == $username){
         $username_err = "Username already exists";
      } else{
         $update = "UPDATE `administrator` SET `username`='{$new_username}' ";
         if(mysqli_query($conn, $update)){
            $username_success = "username changed successfully";
            $username = $new_username;
         }

      }
   }//end of username change

//Password change button

if(isset($_POST['change_pw'])){
  
   if( isset($_POST['pass1']) 
   && isset($_POST['pass2'])
   && isset($_POST['pass3'])){
     //set variables
     $pass1 = mysqli_real_escape_string($conn, $_POST['pass1']);
     $pass2 = mysqli_real_escape_string($conn, $_POST['pass2']);
     $pass3 = mysqli_real_escape_string($conn, $_POST['pass3']);
     
     //hash passowrds
     $old_pw = md5($pass1);
     $new_pw = md5($pass2);
 
      //check old pw in the database
     if($old_pw == $password){
       
       //check for new password match
       if($pass2 == $pass3){
         $update = "UPDATE `administrator` SET `password_hashed`='{$new_pw}'";
          
         if(mysqli_query($conn, $update)){
           $password_success = "password changed successfully";
           
         }
            else {
           $pw_err = "failed, pls try again later";
         }
       } else{
         $pw_nomatch = "passwords do not match";
       }
     } else {
       $incorrect_pw = "incorrect password";
     }
   }//end field check 
   }//end of pw change button

   //upload picture button
  if(isset($_POST['upload'])){
  
   $statusMsg = '';

   // File upload path
   $targetDir = "uploads/";
   $fileName = basename($_FILES["file"]["name"]);
   $targetFilePath = $targetDir . $fileName;
   $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
   
   if(!empty($_FILES["file"]["name"])){
       // Allow certain file formats
       $allowTypes = array('jpg','JPG','png','PNG','jpeg','JPEG');
       if(in_array($fileType, $allowTypes)){
           // Upload file to server
           if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
               // Insert image file name into database
              $upload = "UPDATE `administrator` SET `image_url`='$fileName'";

               //$insert = $db->query("INSERT into images (file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
               if(mysqli_query($conn, $upload)){
                  $successmsg = "The file ".$fileName. " has been uploaded successfully.";
               }else {
                   $statusMsg = "File upload failed, please try again.";
               } 
           }else{
               $statusMsg = "Sorry, there was an error uploading your file.";
           }
       }else{
           $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
       }
   }else{
       $statusMsg = 'Please select a file to upload.';
   }
   
 //set profile picture on submit
 if($image_url == "nopic"){
   $default = "uploads/defaultpic.png";
     $img_src = $default; 
 }else{
 $img_src = "uploads/".$image_url;
  }

 }//end of upload button
 

 //set default profile picture
 if(isset($_POST['setdefault'])){  
 $img_src = "uploads/defaultpic.png";
 $successmsg = "profile picture has been reset to default"; 
 }

}//end of session
?>



<html>
<head>
   <link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/telemedicine.css">
   <link rel="stylesheet" href="../css/registration.css">
   <style> .dropdown-toggle{     box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12) }
.navbar{
     
     background:#bdf5bd;
      }
 /* The sidebar menu */
 .sidenav {     box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important; 
    top: 0; /* Stay at the top */
    left: 0;
    background-color:#28a745; /* Black */
    overflow-x: hidden; /* Disable horizontal scroll */
}

.vertical-menu {
    width: 200px; /* Set a width if you like */
}

.vertical-menu a {
    background-color: #28a745; /* Grey background color */
    color: white; /* Black text color */
    display: block; /* Make the links appear below each other */
    padding: 15px; /* Add some padding */
    text-decoration: none; /* Remove underline from links */

}

.vertical-menu a:hover {
    background-color: #bdf5bd; /* Dark grey background on mouse-over */
    color: #28a745;
}

.vertical-menu a.active {
    background-color: white; /* Add a green color to the "active/current" link */
    color: #28a745;
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
		padding:2em;
}

.row { 
    margin-right:0;
}

.row2{
    border:1px solid white;
    border-radius:5px;
    margin-right:1em;

}

.row2 form{

}
.upload{
   margin-left:5em;
width:100%;
}

.upload form{
   width:100%;
}
/* On smaller screens, where height is less than 450px, change the style of the sidebar (less padding and a smaller font size) */
@media screen and (max-height: 450px) {
    .sidenav {     box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important; padding-top: 15px;}
}
   </style>
</head>
<body>
   <!-- header -->
   <nav class="navbar navbar-light">
      <img src="../images/icons/logo.png" class="mx-auto mx-sm-1 mx-md-1">

    	<div class="dropdown open   ">
                    <button class="btn btn-success  dropdown-toggle float-right mt-3 mr-3" type="button" id="dropdownMenu3"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-sign-out"></i><span class="pr-1"> Logged in as <?php echo $username; ?> </span> </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="logout.php"> <button class="btn btn-success btn-sm">Log Out</button></a>

                    </div>
    </nav>
      <!-- end of header -->
    <!-- section -->

<div class="row">
        <!-- Side navigation column -->
    <div class="col-7 col-sm-2 mx-auto">
        <div class="sidenav">
           <div class="header">
           <img src="<?php if (isset($img_src)){echo $img_src;}else{ echo $default;} ?>" alt="picture" class="img-fluid img-responsive rounded-circle">
           </div>
         <div class="vertical-menu">
              <a href="admin_dashboard.php">Dashboard</a>
              <a href="admin_view_docs.php">Doctors</a>
              <a href="admin_view_patients.php">Patients</a>
              <a href="admin_reports.php">Messages</a>
              <a href="admin_edit_profile" class="active">Edit Profile</a>
              <a href="logout.php">Logout</a>
         </div>
      </div>    
    </div>

    <!-- Profile Update Column -->
    <div class="col-7 col-sm-10 mx-auto">
      <div class="row">
        <div class="col-1">
        </div>

        <div class="col-12 col-md-6">
      <form id="form" method="POST" action="" class="needs-validation" novalidate>
      <h3 class="text-center">Change Username</h3>
      <span style="color:green; text-align:center;"><?php if (isset($username_success)){echo $username_success;} ?></span>
      <hr>
    <div class="form-group row">
             <label for="inputEmail3"  class="col-form-label col-md-4">Username:</label>
                <div class="col-md">
                    <input type="text" class="form-control" placeholder="Username" name="username" value="<?php if( isset($username)){ echo $username; }?>"
                    required pattern=".{3,10}" title="3 to 10 characters">
                    <div class="invalid-feedback"> *required *3 to 10 characters </div>
                     <div class="exists"><?php if(isset($username_err)){echo $username_err;}?></div>
                   </div>
            </div>

            <div class="form-group row">
            <input type="submit" name="change_username" value="Submit" class="btn btn-success btn-sm form-group col-md">
            </div>

    </form>

<form id="form" method="POST" action="" class="needs-validation" novalidate>
   <h3 class="text-center">Change Password</h3>
   <span style="color:green; text-align:center;"><?php if (isset($password_success)){echo $password_success;} ?></span>
   <hr>
          <div class="form-group row">
             <label for="inputEmail3" class="col-form-label col-md-4">Old Password:</label>
             <div class="col-md">
             <input type="password" class="form-control" placeholder="Enter old password" name="pass1" value="<?php if( isset($pass1)){ echo $pass1; }?>"
                         required pattern=".{6,15}" title="6 to 15 characters">
                      <div class="invalid-feedback">*required *6 to 15 characters</div>
                      <div style="color:red;"><?php if (isset($incorrect_pw)){echo $incorrect_pw;}?></div>
            </div>
            </div>

         <div class="form-group row">
             <label for="inputEmail3" class="col-form-label col-md-4">New Password:</label>
             <div class="col-md">
             <input type="password" class="form-control" placeholder="Enter new password" name="pass2" value="<?php if( isset($pass1)){ echo $pass1; }?>"
                         required pattern=".{6,15}" title="6 to 15 characters">
                      <div class="invalid-feedback">*required *6 to 15 characters</div>  
            </div>
            </div>

         
         <div class="form-group row">
             <label for="inputEmail3" class="col-form-label col-md-4">confirm Password:</label>
             <div class="col-md">
             <input type="password" class="form-control" placeholder="Confirm new password" name="pass3" value="<?php if( isset($pass1)){ echo $pass1; }?>"
                         required pattern=".{6,15}" title="6 to 15 characters">
                      <div class="invalid-feedback">*required *6 to 15 characters</div>
                      <div style="color:red;"><?php if (isset($pw_nomatch)){echo $pw_nomatch;}?></div>
            </div>
            </div>

            <div class="form-group row">
            <input type="submit" name="change_pw" value="Submit" class="btn btn-success btn-sm form-group col-md">
            </div>

    </form>


    </div>
   
    <div class=" col-12 col-md-4 mx-auto upload">
   <!-- picture upload form -->
   <?php if (isset($statusMsg)){echo "<div class='status'>".$statusMsg."</div>";}?> 
   <?php if (isset($successmsg)){echo "<div class='success'>".$successmsg."</div>";} ?> 
  <form action="" method="post" enctype="multipart/form-data">
    <h3>Change Profile Photo</h3>
    <div class="form-group row">
    <input type="file" name="file" class="form-control" >
      </div>
    
     <div class="form-group row">
       <input type="submit" name="upload" value="Upload" class="btn btn-success btn-sm form-group col-md">
     </div>
     <div class="form-group row">
       <input type="submit" name="setdefault" value="Unset Profile Picture" class="btn btn-success btn-sm form-group col-md">
     </div>
  </form>

        </div>

</div>

</div>
</div>

<!-- footer row -->
<div class="">
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