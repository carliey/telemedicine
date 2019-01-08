<?php
session_start();

if(isset($_GET['did'])){
    $_SESSION['did'] = $_GET['did']; 
    $did = $_SESSION['did'];
}
else{
    $did = $_SESSION['did'];
}

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

   if ( isset($_POST['report_btn'])){

    if(isset($_POST['doc_id']) && isset($_POST['report'])){
        $doc_id = $_POST['doc_id'];
        $report = $_POST['report'];
        
        if(!empty($report)){

        $report_query = "INSERT INTO `reports` (`id`, `pid`, `did`, `report`, `date`) 
        VALUES (NULL, '{$id}', '{$doc_id}', '{$report}', CURRENT_TIMESTAMP)";
        $result = mysqli_query($conn, $report_query);
        if($result){
            $success = "Report Submitted Successfully";
            }
        }else{
            $validate_err = "Please Enter The Report";
        }

    }// end of variable set if     
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

section{
    border:1px solid;
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
                        <i class="fa fa-sign-out"></i><span class="pr-1"> Logged in as <?php echo $username ?> with Patient ID<?php echo $id; ?></span> </button>
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
             <img src="<?php echo $img_src; ?>" alt="picture" class="img-fluid img-responsive rounded-circle">
           </div>
         <div class="vertical-menu">
              <a href="patient_dashboard.php" >Dashboard</a>
              <a href="patient_select_doc.php" >Select Doctor</a>
              <a href="patient_conversation.php">Conversations</a>
              <a href="patient_report_doc.php?did=<?php if(isset($drow['did'])){ echo $drow['did']; } ?> " class="active">Report Doctor</a>
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
   
<div class="col-2"></div>


<div class="col-8 mt-5" style="border:2px solid #bdf5bd; border-radius:10px; padding:2em; ">

<p style="text-align:center; color:green;"><?php if (isset($success)){ echo $success;} ?></p>
<form method="POST" action="" class="needs-validation w-100" novalidate>
   <div class="form-row">

       <div class="col-md-3">
         <p>Doctor's ID</p>
        </div>

        <div class="col-md-6">
             <input type="text" name="doc_id"  class="form-control" id="validationCustom01"
             placeholder="Enter Doctor's ID" required value="<?php if(isset($_POST['doc_id'])){echo $_POST['doc_id'];}else{
                 if(isset($did)){echo $did;}
             }?>">
             <div class="invalid-feedback"> Please Enter and Verify the doctor's ID </div>
        </div>

        <div class="col-md-3">
             <input type="submit" value="Verify" name="check_btn" class="btn btn-success" > 
        </div>

  </div>

<!-- verification table -->

<?php 
if (isset($_POST['check_btn'])){

    //get doctor's details from database
     if (isset($_POST['doc_id'])){

         $doc_id = $_POST['doc_id'];
      $dquery = "SELECT * FROM `telemedicine`.`doctors` WHERE `did` = '{$doc_id}'";
       $dresult = mysqli_query($conn, $dquery);
        if($dresult){
          if(mysqli_num_rows($dresult) == 1){
              // Retrieve doctor's  information
             $drow = mysqli_fetch_assoc($dresult);
             $doc_id = $drow['did'];
             $doc_firstname = $drow['firstname'];
             $doc_lastname = $drow['lastname'];
             $doc_username = $drow['username'];
             $doc_speciality = $drow['speciality'];
?>

<table class="table table-sm mt-3">
  <thead style="background:#bdf5bd">
    <tr>
      <th scope="col">Firstname</th>
      <th scope="col">Lastname</th>
      <th scope="col">Username</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php if (isset($doc_firstname)){echo $doc_firstname;}?></td>
      <td><?php if (isset($doc_lastname)){echo $doc_lastname;}?></td>
      <td><?php if (isset($doc_username)){echo $doc_username;}?></td>
    </tr>
    </tbody>
    </table>
<?php
}else{
      $id_err = "ID: ".$_POST['doc_id']." does not Exist ";
    ?>

   <p style="text-align:center; color:red; font-size:12px;"><?php if (isset($id_err)){echo $id_err;}?></p>

<?php 
}
}
} 
}//end check btn
?>
   <p style="text-align:center; color:red; font-size:12px;"><?php if (isset($id_err)){echo $id_err;}?></p>


  <div class="form-row mt-5">
      <div class="col-md-3">
         <p>Report</p>
      </div>    
      <div class="col-md-6">
        <textarea name="report" class="form-control" id="exampleFormControlTextarea1" rows="7" placeholder="Enter your report here" ></textarea>
        <p style="text-align:center; color:red; font-size:14px;"><?php if (isset($validate_err)){ echo $validate_err;} ?></p>
     </div>
  </div>

  <div class="form-group">
    <input type="submit" name="report_btn" class="btn btn-sm btn-success w-100 mt-4"> 
  </div>

</form>
</div>

</div>


<div class="col-2"></div>

</div>        
</div>
<!-- end of row -->

      <!--footer row -->
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