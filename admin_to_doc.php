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

if(!isset($_SESSION["admin_log"]) || $_SESSION["admin_log"] !== true){
    header('location: index.php');
} else{
         //set session variables
     //get admin's details from database
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
   }

    
}// end of session
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
    top:; /* Stay at the top */
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
		background: #bdf5bd;
		text-align:center;
		padding:2em 0;
}

.row { 
    margin-right:0;
    padding:0;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color:    #e6ffe6
;
}

.container{
    padding:0;
    margin:0;
}

.row-header{     box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
    height:2em;
    background:#28a745;
    color:white;
    text-align:center;
    width:100%;
}

.alert{
   padding:1em;
   margin:0;
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
              <a href="admin_view_docs.php" class="active">Doctors</a>
              <a href="admin_view_patients.php">Patients</a>
              <a href="admin_reports.php">Messages</a>
              <a href="admin_edit_profile">Edit Profile</a>
              <a href="logout.php">Logout</a>
         </div>
      </div>    
    </div>


    <!-- 2nd Column -->
    <div class="col-12 mt-2 mt-sm-0 col-sm-10 col2"> 
<div class="row">
<div class="row-header"> <h5>Doctors</h5></div>
</div> 

<div class="row">
       <div class="col-2 mt-2">
         <div class=""><a href="admin_reports.php" class="btn btn-sm btn-success">Back &#8656;</a></div>
       </div>                                             
       
       <div class="col-10">
<?php
 
 $cquery = "SELECT * FROM `admin_to_doc` WHERE `aid` = '".$_SESSION['id']."' GROUP BY did";
 $cresult = mysqli_query($conn, $cquery);
if($cresult){
   while ($crow = mysqli_fetch_assoc($cresult)){
       $query = "SELECT * FROM `doctors` WHERE `did` = '".$crow['did']."'";

       $result = mysqli_query($conn, $query);
       $did= $crow['did'];
       if($result){
       if(mysqli_num_rows($result) >= 1){
           $row = mysqli_fetch_assoc($result);
            ?> 

<div class="alert alert-success mt-3 w-100" role="alert">
<a href="admin_to_doc_chat.php?did=<?php echo $did; ?>" class="alert-link"><?php echo $row['firstname']." ".$row['lastname']; ?></a>
</div>

<?php 
      }
    }
   }
  } 
 ?>

</div>
</div>
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