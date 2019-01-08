<?php
session_start();
include 'connection/sqlconnect.php';

if(!isset($_SESSION["patient_log"]) || $_SESSION["patient_log"] !== true){
   header('location: index.php');
} else{
   //set session variables
    
    //get patient details from database
   $query = "SELECT * FROM patients WHERE `pid` = '".$_SESSION['id']."'";
			$result = mysqli_query($conn, $query);
			if($result){
				if(mysqli_num_rows($result) == 1){
					$row = mysqli_fetch_assoc($result);
					$id = $row['pid'];
                    $firstname = $row['firstname'];	
                    $lastname = $row['lastname'];	
                    $username = $row['username'];
                    $password = $row['password_hashed'];
                    $gender = $row['gender'];
                    $age = $row['age_group'];
                    $genotype = $row['genotype'];
                    $blood = $row['blood_type'];
                    $contact = $row['contact'];
                    $state = $row['state'];
                    $city = $row['city'];
                    $address = $row['address'];
                    $image_url = $row['image_url'];
                    

                      //set profile picture on page load
                   if($image_url == "nopic"){
                   $default = "uploads/defaultpic.png";
                   $img_src = $default; 
                   }else{
                   $img_src = "uploads/".$image_url;
                   }
                   
                   if (isset($default)){
                     $img_src = "uploads/defaultpic.png";
                   }

                  }// end get table data
            }//end query run
   
    //check the current form on submit
 if(isset($_POST['submit'])){

  if (isset($_POST['firstname']) 
&& isset($_POST['lastname']) 
&& isset($_POST['username']) 
&& isset($_POST['gender'])
&& isset($_POST['age'])
&& isset($_POST['genotype'])
&& isset($_POST['blood']) 
&& isset($_POST['contact'])
&& isset($_POST['state'])
&& isset($_POST['city']) 
&& isset($_POST['address']))
{
  //set variables
  $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
  $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
  $new_username = mysqli_real_escape_string($conn, $_POST['username']);
  $gender = mysqli_real_escape_string($conn, $_POST['gender']);
  $age = mysqli_real_escape_string($conn, $_POST['age']);
  $genotype = mysqli_real_escape_string($conn, $_POST['genotype']);
  $blood = mysqli_real_escape_string($conn, $_POST['blood']);
  $contact = mysqli_real_escape_string($conn, $_POST['contact']);
  $state = mysqli_real_escape_string($conn, $_POST['state']);
  $city = mysqli_real_escape_string($conn, $_POST['city']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);

  
  //check for empty optional fields
  if(empty($genotype)){
    $genotype = $row['genotype'];
  }
  if(empty($blood)){
    $blood = $row['blood_type'];
  }
  if(empty($contact)){
    $contact = $row['contact'];
  }
  if(empty($state)){
    $state = $row['state'];
  }
  if(empty($city)){
    $city = $row['city'];
  }
  if(empty($address)){
    $address = $row['address'];
  }
  if(empty($gender)){
    $gender = $row['gender'];
  }
  if(empty($genotype)){
    $genotype = $row['genotype'];
  }

  //set update sql
  $update = "UPDATE `patients` SET `pid`='$id',`firstname`='$firstname',`lastname`='$lastname',
  `username`='$new_username',`password_hashed`='$password',`gender`='$gender',
  `age_group`='$age',`genotype`='$genotype',`blood_type`='$blood',
  `contact`='$contact',`state`='$state',`city`='$city',`address`='$address' WHERE `pid` = '$id'";

  //check for username availability
  if($new_username == $row['username']){
    //update
      if(mysqli_query($conn, $update)){
        $update_success = "Profile Updated Successfully";
        $username = $new_username;
      } else {
        $update_err = "Update failed, pls try again later";
      }
      
         //if a user tries to change username
    }else if($new_username != $row['username']){
         // checks for existing username
          $query = "SELECT username FROM patients WHERE username='$new_username'";
         $result = mysqli_query($conn, $query);
         if (mysqli_num_rows($result) == 1){
         $username_err ="The username '$new_username' already exists";
         } else{

            $query = "SELECT username FROM doctors WHERE username='$new_username'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) == 1){
            $username_err ="The username '$new_username' already exists";
            } else{

         //update
           if(mysqli_query($conn, $update)){
             $update_success = "profile Updated Successfully";
             $username = $new_username;
             } else {
            $update_err = "Update failed, pls try again later";
            }
          }
          }//end else
        }
   
    
 
}
}//end of profile update

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
        $update = "UPDATE `patients` SET `password_hashed`='$new_pw' WHERE `pid` = '$id'";
         
        if(mysqli_query($conn, $update)){
          echo "password changed successfully";}
           else {
          echo "failed, pls try again later";
        }
      } else{
        echo "passwords do not match";
      }
    } else {
      echo "incorrect password";
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
               $upload = "UPDATE `patients` SET `image_url`='$fileName' WHERE `pid` = '$id'";

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
            $statusMsg = 'Sorry, only JPG, JPEG & PNG files are allowed to upload.';
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
    $default = "uploads/defaultpic.png";
    $img_src = $default;   
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
.row { 
    margin-right:0;
}

.row3{ 
    margin-right:0;
    padding-right:0;
    text-align:center;
    margin-top:1em;

}
.row2{
  text-align:center;
margin-top:1em;
padding-right:2em
}

.row2 form{
  border-right:2px solid #bdf5bd;
  padding-right:2em
}

.row3 .row1{
  border-bottom:2px solid #bdf5bd;
}

.status{
  width:100%;
  text-align:center;
  background:#bdf5bd;
  color:red;
  border-radius:10px;
}
.success{
  width:100%;
  text-align:center;
  background:#eee;
  color:green;
  border-radius:10px;

}

.update-success{
  width:100%;
  text-align:center;
  background:#eee;
  color:green;
  border-radius:10px;

}
.update-err{
  width:100%;
  text-align:center;
  background:#eee;
  color:red;
  border-radius:10px;

}

.footer{
		width:100%;
		background: #bdf5bd;
		text-align:center;
		padding:2em;
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
                        <i class="fa fa-sign-out"></i><span class="pr-1"> Logged in as <?php echo $username ?> with Patient ID: <?php echo $id; ?></span> </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="logout.php"> <button class="btn btn-success btn-sm">Log Out</button></a>

                    </div>
    </nav>
      <!-- end of header -->
    <!-- section -->

<div class="row">
        <!-- Side navigation column -->
    <div class="col-7 col-sm-5 col-md-2 mx-auto">
        <div class="sidenav">
           <div class="header">
             <img src="<?php if (isset($img_src)){echo $img_src;}else{ echo $default;} ?>" alt="picture" class="img-fluid img-responsive rounded-circle">
           </div>
           <div class="vertical-menu">
              <a href="patient_dashboard.php" >Dashboard</a>
              <a href="patient_select_doc.php" >Select Doctor</a>
              <a href="patient_conversation.php">Conversations</a>
              <a href="patient_report_doc.php?did=<?php if(isset($drow['did'])){ echo $drow['did']; } ?>">Report Doctor</a>
              <a href="patient_bc.php">Admin Broadcasts</a>
              <a href="patient_update_profile" class="active">Edit Profile</a>
              <a href="" data-toggle="modal" data-target="#suggestion-modal">suggestion box</a>
              <a href="logout.php">Logout</a>
           </div>
      </div>    
    </div>

    <!-- Profile Update Column -->
    <div class="col-10 col-sm-7 mx-auto row2">
    <?php if (isset($update_success)){echo "<div class='update-success'>".$update_success."</div>";}?> 
    <?php if (isset($update_err)){echo "<div class='update-err'>".$update_err."</div>";}?> 
      <form id="form" method="POST" action="patient_update_profile.php" class="needs-validation" novalidate>
      <h3>Edit Profile</h3>
          <div class="form-row">
          <div class="form-group col-lg-6">
             <label for="inputEmail3" class="col-form-label">FirstName:</label>
              <input type="text" class="form-control" placeholder="First name" name="firstname" value="<?php if( isset($firstname)){ echo $firstname; }?>"
                       required pattern=".{2,20}" title=" 2 to 20 characters">
                     <div class="invalid-feedback"> *required *2 to 20 characters </div>              
          </div>

            <div class="form-group col-lg-6">
              <label for="inputEmail3" class="col-form-label">LastName:</label>
              <input type="text" class="form-control" placeholder="Last name" name="lastname" value="<?php if( isset($lastname)){ echo $lastname; }?>"
                       required pattern=".{2,20}" title=" 2 to 20 characters">
                     <div class="invalid-feedback"> *required *2 to 20 characters </div>      
          </div>
        </div>

            <div class="form-group row">
             <label for="inputEmail3" class="col-sm-2 col-form-label">Username:</label>
                <div class="col-md">
                    <input type="text" class="form-control" placeholder="Username" name="username" value="<?php if( isset($username)){ echo $username; }?>"
                    required pattern=".{3,10}" title="3 to 10 characters">
                    <div class="invalid-feedback"> *required *3 to 10 characters </div>
                     <div class="exists"><?php if(isset($username_err)){echo $username_err;}?></div>
                   </div>
            </div>

             <!-- Form Select -->
             
                  <div class="form-row">

                          <div class="form-group col-md-6">
                              <select class="custom-select" name="gender" value="<?php if( isset($gender)){ echo $gender; }?>" >
                                <option  value="">Gender</option>
                                <option value="male" name="Male">Male</option>
                                <option value="female" name="Female">Female</option>
                              </select>
                            </div>

                            <div class="form-group col-md-6">
                                <select class="custom-select" name="age" value="<?php if( isset($age)){ echo $age; }?>" >
                                  <option  value="">Age Group</option>
                                  <option value="0 To 10" name="0 To 10" >0 To 10</option>
                                  <option value="11 To 18" name="11 To 18">11 To 18</option>
                                  <option value="18 To 30" name="18 To 30">18 To 30</option>
                                  <option value="30 To 45" name="30 To 45">30 To 45</option>
                                  <option value="45 To 65" name="45 To 65">45 To 65</option>
                                  <option value="65 and Above" name="65 and Above">65 and Above</option>
                                </select>
                              </div>

                            <div class="form-group col-md-6">
                                <select class="custom-select" name="genotype" value="<?php if( isset($genotype)){ echo $genotype; }?>">
                                  <option value="" name="">Genotype</option>
                                  <option value="aa" name="AA">AA</option>
                                  <option value="as" name="AS">AS</option>
                                  <option value="ss" name="SS">SS</option>
                                  <option value="sc" name="SC">SC</option>
                                </select>
                            </div>

                              <div class="form-group col-md-6">
                                  <select class="custom-select" name="blood" value="<?php if( isset($blood)){ echo $blood; }?>">
                                    <option value="" name="">Blood Type</option>
                                    <option value="O+" name="Opositive">O+</option>
                                    <option value="O-" name="Onegative">O-</option>
                                    <option value="A+" name="Apositive">A+</option>
                                    <option value="A-" name="Anegative">A-</option>
                                    <option value="B+" name="Bpositive">B+</option>
                                    <option value="B-" name="Bnegative">B-</option>
                                    <option value="AB+" name="ABpositive">AB+</option>
                                    <option value="AB-" name="ABnegative">AB-</option>
                                  </select>
                              </div>
                    </div>

                <div class="form-group row">
                   <label for="inputEmail3" class="col-sm-2 col-form-label">Contact</label>
                   <div class="col-sm-10">
                   <input type="text" class="form-control" aria-describedby="basic-addon3" placeholder="Mobile Number" name="contact" value="<?php if( isset($contact) && $contact != "NULL"){ echo $contact; }?>"
                      pattern="[0-9].{9,10}" title="10  to 11 characters *only numbers allowed"> 
                    </div>    
                  </div>

                  <div class="form-group row">
                   <label for="inputEmail3" class="col-sm-2 col-form-label">State</label>
                   <div class="col-sm-10">
                   <select class="custom-select" name="state" value="<?php if( isset($state)){ $state = $state; }?>">
                                    <option value="" name="">Select Residential State</option>
                                    <option value="Abuja FCT">Abuja FCT</option>
                                    <option value="Abia">Abia</option>
                                    <option value="Adamawa">Adamawa</option>
                                    <option value="Akwa Ibom">Akwa Ibom</option>
                                    <option value="Anambra">Anambra</option>
                                    <option value="Bauchi">Bauchi</option>
                                    <option value="Bayelsa">Bayelsa</option>
                                    <option value="Benue">Benue</option>
                                    <option value="Borno">Borno</option>
                                    <option value="Cross River">Cross River</option>
                                    <option value="Delta">Delta</option>
                                    <option value="Ebonyi">Ebonyi</option>
                                    <option value="Edo">Edo</option>
                                    <option value="Ekiti">Ekiti</option>
                                    <option value="Enugu">Enugu</option>
                                    <option value="Gombe">Gombe</option>
                                    <option value="Imo">Imo</option>
                                    <option value="Jigawa">Jigawa</option>
                                    <option value="Kaduna">Kaduna</option>
                                    <option value="Kano">Kano</option>
                                    <option value="Katsina">Katsina</option>
                                    <option value="Kebbi">Kebbi</option>
                                    <option value="Kogi">Kogi</option>
                                    <option value="Kwara">Kwara</option>
                                    <option value="Lagos">Lagos</option>
                                    <option value="Nassarawa">Nassarawa</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Ogun">Ogun</option>
                                    <option value="Ondo">Ondo</option>
                                    <option value="Osun">Osun</option>
                                    <option value="Oyo">Oyo</option>
                                    <option value="Plateau">Plateau</option>
                                    <option value="Rivers">Rivers</option>
                                    <option value="Sokoto">Sokoto</option>
                                    <option value="Taraba">Taraba</option>
                                    <option value="Yobe">Yobe</option>
                                    <option value="Zamfara">Zamfara</option>
                            </select>
                    </div>    
                  </div>

                    <div class="form-group row">
                   <label for="inputEmail3" class="col-sm-2 col-form-label">city</label>
                   <div class="col-sm-10">
                   <input type="text" class="form-control" placeholder="City" name="city" value="<?php if( isset($city) && $city != "NULL"){ echo $city; }?>">
                    </div>    
                  </div>

                  <div class="form-group row">
                   <label for="inputEmail3" class="col-sm-2 col-form-label">Address</label>
                   <div class="col-sm-10">
                   <input type="text" class="form-control" placeholder="Address" name="address" value="<?php if( isset($address) && $address != "NULL"){ echo $address; }?>">
                    </div>    
                  </div>
                  <input type="submit" name="submit" value="Save" class="btn btn-success btn-sm form-group col-md">

       </form>     
    
    </div>

      <!--password and picture column -->
    <div class="col-7 col-md-3 mx-auto row3">
   
   <div class="row col-md row1">
   <!-- picture upload form -->
   <?php if (isset($statusMsg)){echo "<div class='status'>".$statusMsg."</div>";}?> 
   <?php if (isset($successmsg)){echo "<div class='success'>".$successmsg."</div>";} ?> 
    <form action="patient_update_profile.php" method="post" enctype="multipart/form-data">
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

<div class="row col-md mt-3">
   <form id="form" method="POST" action="patient_update_profile.php" class="needs-validation" novalidate>
   <h3>Change Password</h3>
          <div class="form-group row">
             <label for="inputEmail3" class="col-form-label">Old Password:</label>
             <input type="password" class="form-control" placeholder="Ener old password" name="pass1" value="<?php if( isset($pass1)){ echo $pass1; }?>"
                         required pattern=".{6,15}" title="6 to 15 characters">
                      <div class="invalid-feedback">*required *6 to 15 characters</div>        
            </div>

         <div class="form-group row">
             <label for="inputEmail3" class="col-form-label">New Password:</label>
             <input type="password" class="form-control" placeholder="Enter new password" name="pass2" value="<?php if( isset($pass1)){ echo $pass1; }?>"
                         required pattern=".{6,15}" title="6 to 15 characters">
                      <div class="invalid-feedback">*required *6 to 15 characters</div>         
            </div>
         
         <div class="form-group row">
             <label for="inputEmail3" class="col-form-label">confirm Password:</label>
             <input type="password" class="form-control" placeholder="Confirm new password" name="pass3" value="<?php if( isset($pass1)){ echo $pass1; }?>"
                         required pattern=".{6,15}" title="6 to 15 characters">
                      <div class="invalid-feedback">*required *6 to 15 characters</div>
            </div>

            <div class="form-group row">
            <input type="submit" name="change_pw" value="Submit" class="btn btn-success btn-sm form-group col-md">
            </div>

    </form>
   </div>

    </div>
</div>


      <!--footer -->
     <!--footer row -->
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

        <form id="form" action="patient_dashboard.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
          <div class="modal-body">
                <textarea name="feedback" rows="7" rows="5" class="form-control" required></textarea>
                <div class="invalid-feedback"> Post cannot be empty </div>                     
         </div>

           
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

$(document).ready(function(){
   $("<?php if(!empty($feeback_err) || !empty($feeback_success)) echo'#suggestion-modal'?>").modal('show');
  
  //reset form when modal hides
  $('#suggestion-modal').on('hidden.bs.modal', function (e) {
   $('#form').trigger('reset');
});
   //get value from delete button and put in hidden input of delete modal
   $('.delete-student-btn').on('click',function(){
     const id = this.value;
    //  set value of input
      $("#delete-student-input").val(id);        
   });
   ////
   } );
 </script>
</body>
</html>