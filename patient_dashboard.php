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
           
            //set profile picture 
            if($image_url == "nopic"){
               $default = "uploads/defaultpic.png";
                 $img_src = $default; 
             }else{
             $img_src = "uploads/".$image_url;
              }

              if (isset($default)){
                $img_src = $default;
              }

         }// end get table data
   }//end query run

  

//Feedback

   if(isset($_POST["save"])){

    $feedback = $_POST['feedback'];

    //validation of input
    
    if(empty($feedback)){
        $feeback_err = "Field cannot be empty";
    }else{
        $query = "INSERT INTO `feedback` (`id`, `username`, `feedback`, `date`) VALUES (Null, '{$username}', '{$feedback}', CURRENT_TIMESTAMP)";
        $result = mysqli_query($conn, $query);
    if($result){
         $feeback_success = "Feedback submitted, thanks for your contribution";
    }else{
      $feeback_err = "Failed, Please Try Again Later";
    }
    }
   
   } 
  


}//end session
?>


<html>
<head>
   <link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/telemedicine.css">
   <link rel="stylesheet" href="../css/registration.css">
   <style> .dropdown-toggle{     box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12) }
      .navbar{
         background:#bdf5bd;
         max-height:500px;
         /* box-shadow: 0.5px 0.5px 0.5px 0.5px green; */
      }
 /* The sidebar menu */
 .sidenav { 
    top: 0; /* Stay at the top */
    left: 0;
    background-color:#28a745; /* Black */
    overflow-x: hidden; /* Disable horizontal scroll */
    box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;
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
		padding:3em;
	}

.row { 
    margin-right:0;
}

.dropdown-toggle{
    box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)
}

.card{
    box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)
    }

.card:hover{
    transition: transform .5s;

    transition: opacity 2s cubic-bezier(.165, .84, .44, 1);
    box-shadow: 0 8px 17px 0 rgba(0, 0, 0, .2), 0 6px 20px 0 rgba(0, 0, 0, .15);
    content: '';
    opacity: 1;
    z-index: 1;
    }
 

a:hover{
    text-decoration:none;
}


/* On smaller screens, where height is less than 450px, change the style of the sidebar (less padding and a smaller font size) */
@media screen and (max-height: 450px) {
    .sidenav {     box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important; padding-top: 15px;}
     
}
   </style>
</head>
<body>
   <!-- header -->
   <div class="navbar navbar-light navbar-expan">

      <img src="../images/icons/logo.png" class="mx-auto mx-sm-1 mx-md-1">

    	<div class="dropdown open mx-auto mx-sm-1 mx-md-1">
                    <button class="btn btn-success dropdown-toggle mt-3 mr-3" type="button" id="dropdownMenu3"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-sign-out"></i><span class="pr-1"> Logged in as <?php echo $username ?> with Patient ID<?php echo $id; ?></span> </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="logout.php"> <button class="btn btn-success btn-sm">Log Out</button></a>
                    </div>
                    </div>


    </div>
      <!-- end of header -->
    <!-- section -->

<div class="row">
        <!-- Side navigation column -->
        <div class="col-7 col-sm-2 mx-auto">
        <div class="sidenav ">
           <div class="header">
             <img src="<?php echo $img_src; ?>" alt="picture" class="img-fluid img-responsive rounded-circle">
           </div>
         <div class="vertical-menu"> 
             <a href="patient_dashboard.php" class="active" >Dashboard</a>
              <a href="patient_select_doc.php">Select Doctor</a>
              <a href="patient_conversation.php">Conversations</a>
              <a href="patient_report_doc.php?did=<?php if(isset($drow['did'])){ echo $drow['did']; } ?>">Report Doctor</a>
              <a href="patient_bc.php">Admin Broadcasts</a>
              <a href="patient_update_profile">Edit Profile</a>
              <a href="" data-toggle="modal" data-target="#suggestion-modal">suggestion box</a>
              <a href="logout.php">Logout</a>

         </div>
      </div>    
    </div>

    <!--  Column 2 -->
<div class="col-11 col-sm-10 mx-auto"> 

<div class="row">


<div class="col col-12 col-md-6 col-lg-4 p-3">
            <a href="Patient_select_doc.php">
                    <div class="card border-success text-center">
                        <div class="card-body">
                                <img class="invoice" src="../images/icons/doctor.jpg" alt="" style="width:80px; height:80px;">
                            <h5 class="text-dark">
                                Doctors
                            </h5>
                            <p class="text-success">
                            View Our Registered Doctors
                            </p>
                        </div>
               </a>
                    </div>
                </div>

<div class="col col-12 col-md-6 col-lg-4 p-3">
             <a href="patient_conversation.php">
                    <div class="card border-success text-center">
                        <div class="card-body">
                                <img class="invoice" src="../images/icons/consultations.png" alt="" style="width:100px; height:80px;">
                            <h5 class="text-dark">
                                Consultations
                            </h5>
                            <p class="text-success">
                            Resume an Ongoing Consultation
                            </p>
                        </div>
                        </a>
                    </div>
                </div>

<div class="col col-12 col-md-6 col-lg-4 p-3">
             <a href="patient_report_doc.php?did=<?php if(isset($drow['did'])){ echo $drow['did']; } ?>">
                   <div class="card border-success text-center">
                        <div class="card-body">
                                <img class="invoice" src="../images/icons/report.jpg" alt="" style="width:80px; height:80px;">
                            <h5 class="text-dark">
                                 Report Doctor
                            </h5>
                            <p class="text-success">
                            Submit A complaint On Our Doctors
                            </p>
                        </div>
                        </a>
                    </div>
                </div>

<div class="col col-12 col-md-6 col-lg-4 p-3">
               <a href="patient_update_profile.php">
                    <div class="card border-success text-center">
                        <div class="card-body">
                                <img class="invoice" src="../images/icons/profile.png" alt="" style="width:80px; height:80px;">
                            <h5 class="text-dark">
                                Profile
                            </h5>
                            <p class="text-success">
                            Edit Information
                            </p>
                        </div>
                        </a>
                    </div>
                </div>

<div class="col col-12 col-md-6 col-lg-4 p-3">
                <a href="patient_bc.php">
                    <div class="card border-success text-center">
                        <div class="card-body">
                                <img class="invoice" src="../images/icons/bc.png" alt="" style="width:80px; height:80px;">
                            <h5 class="text-dark">
                                Admin Broadcasts
                            </h5>
                            <p class="text-success">
                               Public Posts By The Admin
                            </p>
                        </div>
                        </a>
                    </div>
                </div>
  
     
  <div class="col col-12 col-md-6 col-lg-4 p-3">
               <a href="" data-toggle="modal" data-target="#suggestion-modal">
                    <div class="card border-success text-center">
                        <div class="card-body">
                                <img class="invoice" src="../images/icons/feedback.png" alt="" style="width:80px; height:80px;">
                            <h5 class="text-dark">
                                Suggestion Box
                            </h5>
                            <p class="text-success">
                               Drop a Suggestion To Help Us Improve
                            </p>
                        </div>
                        </a>
                    </div>
                </div>
  
  
    </div>
  </div>
</div>





</div>
<!-- end of col 3 -->
</div>

</div>
<!-- end of row -->

      <!--footer row -->
<div class="row">s
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
                <div class="invalid-feedback"> Please Enter your feedback </div>                     
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