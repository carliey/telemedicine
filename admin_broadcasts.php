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
   }


//Broadcast
if(isset($_POST["post_btn"])){

   $subject = $_POST['subject'];
   $message = $_POST['message'];

   //validation of input
   
   if(empty($subject)){
       $subject_err = "Field cannot be empty";
   }elseif(empty($message)){
      $message_err = "Field cannot be empty";
    } else {
       $query = "INSERT INTO `broadcasts` (`id`, `subject`, `message`, `date`) VALUES (Null, '{$subject}', '{$message}', CURRENT_TIMESTAMP)";
       $result = mysqli_query($conn, $query);
   if($result){
        $message_success = "Broadcast posted successfully";
   }else{
     $post_err = "Failed, Please Try Again Later";
   }
   }
  
  } 


   //search
   if (isset($_POST['search'])){
      $keyword = $_POST['key'];
    if(strlen($keyword) >= 1){
         $search_query = "SELECT * FROM `broadcasts` WHERE `subject` LIKE '%$keyword%' ORDER BY `date` DESC";   
                 } else { echo "Enter username";} 
}

if (isset($_POST['key_date']) && !empty($_POST['key_date'])){
  $keyword = $_POST['key_date'];
if(strlen($keyword) >= 1){
     $search_query = "SELECT * FROM broadcasts where `date` like '%$keyword%'";   

             } else { echo "Enter date";} 
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

.row-header{     box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
    height:2em;
    background:#28a745;
    color:white;
    text-align:center;
    width:100%;
}


.table-striped tbody tr:nth-of-type(odd) {
    background-color:    #e6ffe6
;
}

.container{
    padding:0;
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
              <a href="admin_view_docs.php">Doctors</a>
              <a href="admin_view_patients.php">Patients</a>
              <a href="admin_reports.php" class="active">Messages</a>
              <a href="admin_edit_profile">Edit Profile</a>
              <a href="logout.php">Logout</a>
         </div>
      </div>    
    </div>

    <!-- column two -->
    <div class="col-8 col2"> 
    <div class="row">
    <div class="row-header"> <h5>Broadcasts</h5></div>
    </div>
     
    <div class="card-body">

    <div class="row mt-2">

<div class="col-1 mt-4" style="padding-left:0;">
<div class=""><a href="admin_reports.php" class="btn btn-sm btn-success">Back &#8656;</a></div>
</div>

   <div class="col-5" style="padding-left:3em;">
    <h6> Search by Topic</h6>
        <form action="" method="POST" class="w-100 needs-validation" novalidate>
	       <input type="text" name="key" class="form-control" placeholder="Enter Username" required> 
	       <input type="submit" value="search" name="search" class="btn btn-success btn-sm w-100 mt-2">
        </form>
    </div>     
     
    <div class="col-5" style="padding-left:3em;">
    <h6> Search by Date/Time</h6>
        <form action="" method="POST" class="w-100 needs-validation" novalidate>
	       <input type="text" name="key_date" class="form-control" placeholder="Enter Date/Time" required>
	       <input type="submit" value="search" name="search_date" class="btn btn-success btn-sm w-100 mt-2">
        </form>
    </div>  
    </div> 
    </div>

    <div class="row">


 <div class="col-1">
</div>

 <div class="col-11">

<?php 
 //get doctor's details from database

 if (isset($search_query)){
     $query = $search_query;
 } else {

    $query = "SELECT * FROM broadcasts ORDER BY `broadcasts`.`date` DESC
    ";
 }

     $result = mysqli_query($conn, $query);
     if($result){
	  while ($row = mysqli_fetch_assoc($result)){

         ?>

<div class="card border-success mb-3 mt-4" >
  <div class="card-header bg-transparent border-success">
     <span style="font-weight:bold;">Topic: <?php echo $row['subject']; ?></span>
     <span style="float:right;">Date/Time: <?php echo $row['date']; ?></span> 
  </div>
  <div class="card-body text-success">
    <p class="card-text"><?php echo $row['message']; ?></p>
  <!-- </div>
  <div class="card-footer bg-transparent border-success"> -->
  </div>
</div>

<?php }} ?>

</div>
</div>

                      
<!-- end of col 3 -->
</div>

<div class="col-1" style=" margin-top:75px;">
<div class=""><a href="" data-toggle="modal" data-target="#broadcast-modal" class="btn btn-sm btn-success">Post New Broadcast</a></div>
</div>


</div>
<!-- footer row -->
<div class="">
      <div class="footer">
       <span>Telemedicine Nigeria © 2018</span>
      </div>
   </div>
</div>

<!-- Modal -->

<div class="modal fade" id="broadcast-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="suggestion-modal">Broadcast Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

     <p style="color:red; text-align:center;"><?php if (isset($post_err)){echo $posr_err;}?></p>
     <p style="color:green; text-align:center;"> <?php if (isset($message_success)){echo $message_success;}?></p>

        <form id="form" action="admin_broadcasts.php" method="POST" class="needs-validation" novalidate>
          <div class="modal-body">
        <div class="form-row">

        <div class="col-md-12">
             <input type="text" name="subject"  class="form-control" id="validationCustom01"
             placeholder="Enter Topic" required value="<?php if(isset($_POST['topic'])){echo $_POST['doc_id'];}else{
                 if(isset($did)){echo $did;}
             }?>">
             <div class="invalid-feedback"> Field Cannot Be Empty</div>
        </div>

  </div>


  <div class="form-row mt-5"> 
      <div class="col-md-12">
        <textarea name="message" class="form-control" id="exampleFormControlTextarea1" rows="7" placeholder="Enter Broadcast" required></textarea>
        <div class="invalid-feedback"> Field Cannot Be Empty</div>
        <p style="text-align:center; color:red; font-size:14px;"><?php if (isset($validate_err)){ echo $validate_err;} ?></p>
     </div>
  </div>

  <div class="form-group">
    <input type="submit" name="post_btn" value="Post" class="btn btn-sm btn-success w-100 mt-4"> 
  </div>

</form>
              <button type="button" class="btn btn-secondary btn-sm w-100 " data-dismiss="modal">Close</button>
     
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
$("<?php if(!empty($post_err) || !empty($message_success)) echo'#broadcast-modal'?>").modal('show');

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