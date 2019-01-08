<?php
   //establish database connection
   require 'connection/sqlconnect.php';

   if(isset($_POST['submit_doc'])){
    //field check
    if (isset($_POST['firstname']) 
    && isset($_POST['lastname']) 
    && isset($_POST['username']) 
    && isset($_POST['pass1']) 
    && isset($_POST['pass2']) 
    && isset($_POST['sps'])
    && isset($_POST['sp_dropdown'])
    && isset($_POST['speciality'])
    && isset($_POST['gender']) 
    && isset($_POST['qualification']) 
    && isset($_POST['radio']) 
    && isset($_POST['school']) 
    && isset($_POST['state'])
    && isset($_POST['city'])
    && isset($_POST['hospital'])
    && isset($_POST['security_q'])
    && isset($_POST['answer']))
    {
   
    //set variables
  $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
  $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $pass1 = mysqli_real_escape_string($conn, $_POST['pass1']);
  $pass2 = mysqli_real_escape_string($conn, $_POST['pass2']);
  $sps = mysqli_real_escape_string($conn, $_POST['sps']);
  $sp_dropdown = mysqli_real_escape_string($conn, $_POST['sp_dropdown']);
  $speciality = mysqli_real_escape_string($conn, $_POST['speciality']);
  $gender = mysqli_real_escape_string($conn, $_POST['gender']);
  $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
  $radio = mysqli_real_escape_string($conn, $_POST['radio']);
  $school = mysqli_real_escape_string($conn, $_POST['school']);
  $state = mysqli_real_escape_string($conn, $_POST['state']);
  $city = mysqli_real_escape_string($conn, $_POST['city']);
  $hospital = mysqli_real_escape_string($conn, $_POST['hospital']);
  $question = mysqli_real_escape_string($conn, $_POST['security_q']);
  $answer = mysqli_real_escape_string($conn, $_POST['answer']);

   //secure passowrd with hashes
   $password_hash = md5($pass1);

    //check for empty optional fields

  if(empty($state)){
    $state = "NULL";
  }
  if(empty($city)){
    $city = "NULL";
  }
  if(empty($hospital)){
    $hospital = "NULL";
  }
  
  //validate speciality field
  if($sps == 'GP'){
    $speciality = $sps;
  } else if (($sps == 'SP') && empty($sp_dropdown)){
    $sp_dropdown_err = "please specify a speciality";
  } else if(($sps == 'SP') && !empty($sp_dropdown) && $sp_dropdown !== 'others'){
    $speciality = $sp_dropdown;
  } else if ($sp_dropdown == 'others'){
  $speciality_err = "please type in your speciality";
  }

   //check for username availability
   if(!empty($username)){
    $query = "SELECT username FROM doctors WHERE username='$username' UNION SELECT username FROM patients WHERE username='$username'";
     $result = mysqli_query($conn, $query);
  
      if (mysqli_num_rows($result) == 1){
        $username_err ="The username '$username' is not available";
       } else {
      //validate password
        if($pass1 !== $pass2){
            $password_err = "password does not match";
         }else{
        //register
          $query = "INSERT INTO `doctors`(`did`, `firstname`, `lastname`, `username`, `password_hashed`, `speciality`, `gender`, `qualification`, `mdcn`, `school`, `state`, `city`, `hospital`,`image_url`, `status`, `security_q`, `answer`) 
          VALUES (NULL,'$firstname', '$lastname', '$username', '$password_hash', '$speciality', '$gender', '$qualification', '$radio', '$school', '$state', '$city', '$hospital', 'nopic', 'pending', '$question', '$answer')";
            if(mysqli_query($conn, $query)){
               header('location: reg_success.php');
           } else echo("Registration Failed, Please Try again");
         }
       }//end of password validation
    }//end of username avaiability

   }//end field check
}//end submit
?>
<html>
<head>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/telemedicine.css">
  <link rel="stylesheet" href="../css/registration.css">
  <style>  
  .footer{
		background: #bdf5bd;
		text-align:center;
    padding:2em 0;}
  
  .note {
    padding-top:8px;
}

legend{
  font-size:17px;
  font-weight:bold;
}


.navbar{
	height: 100px;
	background:#bdf5bd;
}

.navbar img{
 height: 80px;	
}

nav.btn{
	width: 100px;
	display: inline;
}

.container form{
	margin-top: 5px;
}
form .avl{
 width: 100%;
}
fieldset{
	border:1px solid rgba(197, 197, 197, 0.404);
	margin-bottom: 1.5em;
	padding-bottom:0;
}

fieldset p{
	padding: 0 10px;
}

.exists{
	color: red;
}

#dependent-error {
 display: inline;
}
  </style>  
</head>
<body>
	<!-- header -->
  <nav class="navbar" style="background:#bdf5bd;">
	<img src="../images/icons/logo.png">
		<a class="btn btn-outline-success mb-2 mr-sm-2" href="index.php">Login</a>
</nav>
		<!-- end of header -->
<section class="container">
  <div class="row">
    <div class="col">
      Why Register?
      Consult Doctors Anytime.
      No Travel . No Waiting Queue . Comfort of Your Home
      Trusted by millions and serving users world wide.
     </div>
     <div class="col">
		 <ul class="nav nav-tabs" id="myTab" role="tablist">
       <li class="nav-item">
        <a class="nav-link " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Patient</a>
       </li>
       <li class="nav-item">
       <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Doctor</a>
       </li>
     </ul>
      <div class="tab-content" id="myTabContent">
       <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
              <!-- Patients Registration form -->
              <form id="form" method="POST" action="patient_reg.php" class="needs-validation" novalidate>

                <div class="form-row">
                  <div class="form-group col-md-6">
                     <input type="text" class="form-control" placeholder="First name" name="firstname" value="<?php if( isset($firstname)){ echo $firstname; }?>"
                       required pattern=".{2,20}" title=" 2 to 20 characters">
                     <div class="invalid-feedback"> *required *2 to 20 characters </div>
                   </div>
                   <div class="form-group col-md-6">
                     <input type="text" class="form-control" placeholder="Last name" name="lastname" value="<?php if( isset($lastname)){ echo $lastname; }?>"
                       required pattern=".{2,20}" title=" 2 to 20 characters">
                     <div class="invalid-feedback"> *required *2 to 20 characters </div>
                  </div>
                </div>
        
                <div class="form-row">
                   <div class="form-group col-md">
                      <input type="text" class="form-control" placeholder="Username" name="username" value="<?php if( isset($username)){ echo $username; }?>"
                       required pattern=".{3,10}" title="3 to 10 characters">
                       <div class="invalid-feedback"> *required *3 to 10 characters </div>
                         <div class="exists"><?php if(isset($username_err)){echo $username_err;}?></div>
                   </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                      <input type="password" class="form-control" placeholder="Password" name="pass1" value="<?php if( isset($pass1)){ echo $pass1; }?>"
                         required pattern=".{6,15}" title="6 to 15 characters">
                      <div class="invalid-feedback">*required *6 to 15 characters</div>
                     </div>
                     <div class="form-group col-md-6">
                      <input type="password" class="form-control" placeholder="Password Confirmation" name="pass2" value="<?php if( isset($pass2)){ echo $pass2; }?>"
                          required pattern=".{6,15}" title="6 to 15 characters">
                      <div class="invalid-feedback"> *required *6 to 15 characters</div>
                      <div class="exists"><?php if(isset($password_err)){echo $password_err;}?></div>
                    </div>
                </div>
                  <!-- Form Select -->
                  <fieldset>
                      <legend>Select:</legend>

                  <div class="form-row">

                          <div class="form-group col-md-3">
                              <select class="custom-select" name="gender" value="<?php if( isset($gender)){ echo $gender; }?>" required>
                                <option  value="">Gender</option>
                                <option value="male" name="Male">Male</option>
                                <option value="female" name="Female">Female</option>
                              </select>
                              <div class="invalid-feedback">*required</div>
                            </div>

                            <div class="form-group col-md-3">
                                <select class="custom-select" name="age" value="<?php if( isset($age)){ echo $age; }?>" required>
                                  <option  value="">Age Group</option>
                                  <option value="0 To 10" name="0 To 10" >0 To 10</option>
                                  <option value="11 To 18" name="11 To 18">11 To 18</option>
                                  <option value="18 To 30" name="18 To 30">18 To 30</option>
                                  <option value="30 To 45" name="30 To 45">30 To 45</option>
                                  <option value="45 To 65" name="45 To 65">45 To 65</option>
                                  <option value="65 and Above" name="65 and Above">65 and Above</option>
                                </select>
                                <div class="invalid-feedback">*required</div>
                              </div>

                            <div class="form-group col-md-3">
                                <select class="custom-select" name="genotype" value="<?php if( isset($genotype)){ echo $genotype; }?>">
                                  <option value="" name="">Genotype</option>
                                  <option value="aa" name="AA">AA</option>
                                  <option value="as" name="AS">AS</option>
                                  <option value="ss" name="SS">SS</option>
                                  <option value="sc" name="SC">SC</option>
                                </select>
                            </div>

                              <div class="form-group col-md-3">
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
                  </fieldset>
                  <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">+234</span>
                      </div>
                      <input type="text" class="form-control" aria-describedby="basic-addon3" placeholder="Mobile Number" name="contact" value="<?php if( isset($contact) && $contact != "NULL"){ echo $contact; }?>"
                      pattern="[0-9].{9,10}" title="10  to 11 characters *only numbers allowed"> 
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
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
                            <div class="form-group col-md-6">
                                  <input type="text" class="form-control" placeholder="City" name="city" value="<?php if( isset($city) && $city != "NULL"){ echo $city; }?>">
                            </div>
                            </div>
                                <div class="form-group">
                                  <input type="text" class="form-control" placeholder="Address" name="address" value="<?php if( isset($address) && $address != "NULL"){ echo $address; }?>">
                                 </div>

                 <!-- security question -->
                   <fieldset>
                    <legend>Security Question</legend>
                      <div class="form-row">
                        <div class="form-group col-md">
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
                      </div>

                                <div class="form-group">
                                  <input type="text" class="form-control" placeholder="Answer" name="answer" required>
                                  <div class="invalid-feedback">Please Provide an answer</div>
                                 </div>
                  </fieldset>

                  <input type="submit" name="submit" value="Submit Form" class="btn btn-outline-success form-group col-md">
              </form>
       </div>
       <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
             
             
              <!-- Doctors Registration form -->
              <form method="POST" action="doctor_reg.php" class="needs-validation" novalidate>
              <div class="form-row">
                  <div class="form-group col-md-6">
                     <input type="text" class="form-control" placeholder="First name" name="firstname" value="<?php if( isset($firstname)){ echo $firstname; }?>"
                       required pattern=".{2,20}" title=" 2 to 20 characters">
                     <div class="invalid-feedback"> *required *2 to 20 characters </div>
                   </div>
                   <div class="form-group col-md-6">
                     <input type="text" class="form-control" placeholder="Last name" name="lastname" value="<?php if( isset($lastname)){ echo $lastname; }?>"
                       required pattern=".{2,20}" title=" 2 to 20 characters">
                     <div class="invalid-feedback"> *required *2 to 20 characters </div>
                  </div>
                </div>
        
                <div class="form-row">
                   <div class="form-group col-md">
                      <input type="text" class="form-control" placeholder="Username" name="username" value="<?php if( isset($username)){ echo $username; }?>"
                       required pattern=".{3,10}" title="3 to 10 characters">
                       <div class="invalid-feedback"> *required *3 to 10 characters </div>
                         <div class="exists"><?php if(isset($username_err)){echo $username_err;}?></div>
                   </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                      <input type="password" class="form-control" placeholder="Password" name="pass1" value="<?php if( isset($pass1)){ echo $pass1; }?>"
                         required pattern=".{6,15}" title="6 to 15 characters">
                      <div class="invalid-feedback">*required *6 to 15 characters</div>
                     </div>
                     <div class="form-group col-md-6">
                      <input type="password" class="form-control" placeholder="Password Confirmation" name="pass2" value="<?php if( isset($pass2)){ echo $pass2; }?>"
                          required pattern=".{6,15}" title="6 to 15 characters">
                      <div class="invalid-feedback"> *required *6 to 15 characters</div>
                      <div class="exists"><?php if(isset($password_err)){echo $password_err;}?></div>
                    </div>
                </div>
              <!--multi select  -->
              <div class="form-row">
                <p class="col-md">
              <select id="master-dropdown" class="form-control" name="sps" value="<?php if( isset($sps)){ echo $sps; }?>" required>
                <option value="">-- Speciality --</option>
                <option value="GP">General practitioner</option>
                <option value="SP">Specialist</option>
              </select>
              <div class="invalid-feedback">*required</div>

            </p>
                <p>
              <select id="dependent-dropdown" class="form-control" name="sp_dropdown" value="<?php if( isset($sp_dropdown)){ echo $sp_dropdown; }?>">
                <option value="" >--Select Speciality--</option>
                <option value="Cardiologist">Cardiologist</option>
                <option value="Dermatologist">Dermatologist</option>
                <option value="Gynecologist">Gynecologist</option>
                <option value="Orthopedian">Orthopedian Surgeon</option>
                <option value="Surgeon">Surgeon</option>
                <option value="pediatrician">pediatrician</option>
                <option value="Radiologist">Radiologist</option>
                <option value="Urollogist">Urollogist</option>
                <option value="Destist">Destist</option>
                <option value="others">Others(specify)</option>
              </select>
              <p id="dependent-error" class="exists"><?php if(isset($sp_dropdown_err)){echo $sp_dropdown_err;}?></p>

            </p>
          </div>
            <p>
              <input type="text" id="dependent-text" class="form-control" placeholder="Please specify speciality" name="speciality" value="<?php if( isset($speciality)){ echo $speciality; }?>">
              <p id="dependent-label" class="exists"><?php if(isset($speciality_err)){echo $speciality_err;}?></p>
            </p>

            <div class="form-row">

              <div class="form-group col-md-6">
              <select class="custom-select" name="gender" value="<?php if( isset($gender)){ echo $gender; }?>" required>
                    <option  value="">Gender</option>
                    <option value="male" name="Male">Male</option>
                    <option value="female" name="Female">Female</option> 
              </select>
                  <div class="invalid-feedback">*required</div>
                </div>

                <div class="form-group col-md-6">
                    <select class="custom-select" name="qualification" value="<?php if( isset($qualification)){ echo $qualification; }?>" required>
                      <option value="" >Qualification</option>
                      <option value="MBBS" >MBBS</option>
                      <option value="BDS">BDS</option>
                      <option value="Postgraduate">Medical Postgraduate</option>
                    </select>
                    <div class="invalid-feedback">*required</div>
                  </div>
            </div>

                <div class="form-row">

                   <div class="form-group col-md-6">
                   <label for="custom-radio">MDCN Certified?</label>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline1" name="radio" class="custom-control-input" value="Yes" required>
                        <label class="custom-control-label" for="customRadioInline1" >Yes</label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline2" name="radio" class="custom-control-input" value="No" >
                        <label class="custom-control-label" for="customRadioInline2">No</label>
                      </div>
                   </div>
                   <div class="form-group col-md-6">
                         <input type="text" class="form-control" placeholder="Medical School Attended" required name="school" value="<?php if( isset($school)){ echo $school; }?>">
                   </div>
                   <div class="invalid-feedback">*required</div>
                 </div>

                  <!-- optional fields -->
                  <fieldset>
                    <legend>Optional</legend>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                            <select class="custom-select" name="state" value="<?php if( isset($state) && $state != "NULL"){ $state == $state; }?>">
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
                            <div class="form-group col-md-6">
                                  <input type="text" class="form-control" placeholder="City" name="city" value="<?php if( isset($city) && $city != "NULL"){ echo $city; }?>">
                            </div>
                            </div>

                                <div class="form-group">
                                  <input type="text" class="form-control" placeholder="Practice Hospital" name="hospital" value="<?php if( isset($hospital)&& $hospital != "NULL"){ echo $hospital; }?>">
                                 </div>
                  </fieldset>

<!-- security question -->
<fieldset>
                    <legend>Security Question</legend>
                      <div class="form-row">
                        <div class="form-group col-md">
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
                      </div>

                                <div class="form-group">
                                  <input type="text" class="form-control" placeholder="Answer" name="answer" required>
                                  <div class="invalid-feedback">Please Provide an answer</div>
                                 </div>
                  </fieldset>


                  <input type="submit" name="submit_doc" value="Submit Form" class="btn btn-outline-success form-group col-md">

                    
                </form>
       </div>
       </div>
     </div>
    </div>
</section>
	<!-- Optional JavaScript -->
   <!-- jQuery first, then Popper.js, then Bootstrap JS -->
   <script src="../scripts/jquery-3.3.1.js"></script>
	<script src="../scripts/popper.min.js"></script>
   <script src="../scripts/bootstrap.js"></script>
   <script src="../scripts/jquery.dependent.fields.js"></script>


   <script>
$('.depends-on-master-checkbox').dependsOn('#master-checkbox');
   $('#dependent-dropdown').dependsOn('#master-dropdown', ['SP']);
   $('#dependent-text').dependsOn('#dependent-dropdown',['others']);
   $('#dependent-error').dependsOn('#master-dropdown',['SP']);
   $('#dependent-label').dependsOn('#dependent-dropdown',['others']);


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


//prevent redirecting to form processing pages
   </script>
</body>
</html>
	