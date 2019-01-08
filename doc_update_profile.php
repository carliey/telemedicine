<?php
session_start();
include 'connection/sqlconnect.php';

if(!isset($_SESSION["doctor_log"]) || $_SESSION["doctor_log"] !== true){
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
           //$image_url = $row['image_url'];

           //set profile picture 
           if($image_url == "nopic"){
            $default = "uploads/defaultpic.png";
              $img_src = $default; 
          }else{
          $img_src = "uploads/".$image_url;
           }
       
       
        }//end get table data
    }//end query run

       //check the current form on submit
 if(isset($_POST['submit'])){

    if (isset($_POST['firstname']) 
  && isset($_POST['lastname']) 
  && isset($_POST['username']) 
  && isset($_POST['state'])
  && isset($_POST['city'])
  && isset($_POST['hospital']))
  {

  //set variables
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $new_username = mysqli_real_escape_string($conn, $_POST['username']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $hospital = mysqli_real_escape_string($conn, $_POST['hospital']);

    //assign database values to empty fiels
    if(empty($state)){
        $state = $row['state'];
      }
      if(empty($city)){
        $city = $row['city'];
      }
      if(empty($hospital)){
        $hospital = $row['hospital'];
      }

      //set update sql
        $update = "UPDATE `doctors` SET `firstname`='$firstname',`lastname`='$lastname',
        `username`='$new_username',`state`='$state',`city`='$city',`hospital`='$hospital' WHERE `did` = '$id'";

        //check for username availability
        if($new_username == $row['username']){
       //update
         if(mysqli_query($conn, $update)){
           $update_success = "Profile Updated Successfully";
           $username = $new_username;
          } else {
          $update_err = "registration failed, pls try again later";
        }

         //if a user tries to change username
          }else if($new_username != $row['username']){
        // checks for existing username in doctor's table
         $query = "SELECT username FROM doctors WHERE username='$new_username'";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) == 1){
        $username_err ="The username '$new_username' already exists";
        } else{
               // check username in Patient table
               $query = "SELECT username FROM patients WHERE username='$new_username'";
               $result = mysqli_query($conn, $query);
          
               if (mysqli_num_rows($result) == 1){
               $username_err ="The username '$new_username' already exists";
               } else{
                     //update
                    if(mysqli_query($conn, $update)){
                    $update_success = "Profile Updated Successfully";
                    $username = $new_username;
                    } else {
                    $update_err = "registration failed, pls try again later";
           }
        }
      }
    }

}//end set variables
}//end of proile update

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
               $upload = "UPDATE `doctors` SET `image_url`='$fileName' WHERE `did` = '$id'";

               $img_src = "uploads/".$image_url;

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
    $upload = "UPDATE `doctors` SET `image_url`='nopic' WHERE `did` = '$id'";
    if(mysqli_query($conn, $upload)){
  $successmsg = "profile picture has been reset to default"; 
  }
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
    border-right:2px solid #bdf5bd;
    border-radius:5px;
}
.row3{
    border-right:2px solid #bdf5bd;
    border-radius:5px;
    padding-right:2px;
}
.row4{
    border-radius:5px;
    padding-right:2px;

}

.row form{
   text-align:center;
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
                        <i class="fa fa-sign-out"></i><span class="pr-1"> Logged in as <?php echo $username ?> with Doctor ID: <?php echo $id; ?></span> </button>
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
             <a href="doc_dashboard.php">Dashboard</a>
              <a href="doc_select_doc.php">View Doctors</a>
              <a href="doc_messages.php">Messages</a>
              <a href="doc_update_profile.php" class="active">Edit Profile</a>
              <a href="doc_bc.php">Admin Broadcasts</a>
              <a href="" data-toggle="modal" data-target="#suggestion-modal">suggestion box</a>
              <a href="logout.php">Logout</a>
         </div>
      </div>    
    </div>

    <!-- Profile Update Column -->
    <div class=" col-10 col-md-4 mx-auto pt-4 row2">
    <?php if (isset($update_success)){echo "<div class='update-success'>".$update_success."</div>";}?> 
    <?php if (isset($update_err)){echo "<div class='update-err'>".$update_err."</div>";}?> 
      <form id="form" method="POST" action="doc_update_profile.php" class="needs-validation" novalidate>
      <h3>Edit Profile</h3>
         
      <div class="form-group row">
                 <label for="inputEmail3" class="col-sm-2 col-form-label">firstname:</label>
               <div class="col-md">
                 <input type="text" class="form-control" placeholder="FirstName" name="firstname" value="<?php if( isset($firstname)){ echo $firstname; }?>"
                       required pattern=".{2,20}" title=" 2 to 20 characters">
                     <div class="invalid-feedback"> *required *2 to 20 characters </div>  
               </div>    
          </div>



            <div class="form-group row">
                 <label for="inputEmail3" class="col-sm-2 col-form-label">LastName:</label>
               <div class="col-md">
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
                   <input type="text" class="form-control" placeholder="Enter City" name="city" value="<?php if( isset($city) && $city != "NULL"){ echo $city; }?>">
                    </div>    
                  </div>

                  <div class="form-group row">
                   <label for="inputEmail3" class="col-sm-2 col-form-label">Hospital</label>
                   <div class="col-sm-10">
                   <input type="text" class="form-control" placeholder="Enter Hospital" name="hospital" value="<?php if( isset($hospital) && $hospital != "NULL"){ echo $hospital; }?>">
                    </div>    
                  </div>
                  <input type="submit" name="submit" value="Save" class="btn btn-outline-success form-group col-md">

       </form>     
</div>

<!-- Profile photo column -->
     <div class=" col-10 col-md-3 mx-auto pt-4 row3">   
   <?php if (isset($statusMsg)){echo "<div class='status'>".$statusMsg."</div>";}?> 
   <?php if (isset($successmsg)){echo "<div class='success'>".$successmsg."</div>";} ?> 
    <form action="doc_update_profile.php" method="post" enctype="multipart/form-data">
    <h3>Change Profile Photo</h3>
    <div class="form-group row">
    <input type="file" name="file" class="form-control" >
      </div>
    
     <div class="form-group row">
       <input type="submit" name="upload" value="Upload" class="btn btn-outline-success form-group col-md">
     </div>
     <div class="form-group row">
       <input type="submit" name="setdefault" value="Unset Profile Picture" class="btn btn-outline-success form-group col-md">
     </div>
</form>
</div>

<!-- password change -->
<div class=" col-10 col-md-3 mx-auto pt-4 row4">

   <form id="form" method="POST" action="doc_update_profile.php" class="needs-validation" novalidate>
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
            <input type="submit" name="change_pw" value="Submit" class="btn btn-outline-success form-group col-md">
            </div>

    </form>
   
</div>
</div>


<!-- footer row -->
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

        <form id="form" action="doc_dashboard.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
          <div class="modal-body">
                <textarea name="feedback" rows="7" rows="5" class="form-control" required></textarea>
                <div class="invalid-feedback"> Please Enter and Verify the doctor's ID </div>                     
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