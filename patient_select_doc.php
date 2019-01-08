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

   //sort button
  if(isset($_POST['sort']) && !empty($_POST['current_spe'])){
  $current_spe =$_POST['current_spe'];
  $result_type = $current_spe.'s';

}//end sort button



}//end session
?>

<html>
<head>
   <link rel="stylesheet" href="../css/bootstrap.css">
   <link rel="stylesheet" href="../css/w3.css">
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

.row-header{     box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
    height:2em;
    background:#28a745;
    color:white;
    text-align:center;
    width:100%;
    box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
}

.card{
    box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
    }

.card:hover{
    transition: transform .5s;

    transition: opacity 2s cubic-bezier(.165, .84, .44, 1);
    box-shadow: 0 8px 17px 0 rgba(0, 0, 0, .2), 0 6px 20px 0 rgba(0, 0, 0, .15);
    content: '';
    opacity: 1;
    z-index: 1;
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

/* The profile picture animation code */
@keyframes enlarge {
    from {background-color: red;}
    to {background-color: yellow;}
}

.large {
  height: 32em;
  width: 22em; 
  -webkit-animation-name: example; /* Chrome, Safari, Opera */
    -webkit-animation-duration: 4s; /* Chrome, Safari, Opera */
    animation-name: example;
    animation-duration: 4s;
}

.dp {
  cursor: pointer;
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
              <a href="patient_select_doc.php" class="active">Select Doctor</a>
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
<div class="col-8"> 

<div class="row" id="result">
<div class="row-header"> <h5><?php if(isset($result_type)){echo $result_type;} else {echo "All Doctors";}?></h5></div>

<?php 
 //get doctor's details from database
 if (isset($current_spe)){
     $dquery = "SELECT * FROM `doctors` WHERE `speciality`"."='$current_spe' ";

 } else{
     $dquery = " SELECT * FROM `doctors`";
 }

 $dresult = mysqli_query($conn, $dquery);
 if($dresult){
  if(mysqli_num_rows($dresult) == 0){
    echo "<div class='w-100'><p class='text-center mt-3 alert-danger'>No Result Found</p></div>";
  } else {

	while ($drow = mysqli_fetch_assoc($dresult)){

         //get doctors profile pictures
         if($drow['image_url'] == "nopic"){
            $default = "uploads/defaultpic.png";
              $img_src = $default; 
          }else{
          $img_src = "uploads/".$drow['image_url'];
           }

         ?>

  <div class="col-12 col-sm-6 col-md-4 mt-2 mb-2">
  <div class="card" style="width: 16rem;">

          <img class="card-img-top img-fuid dp" src="<?php if(isset($default)){echo $img_src;}else{ echo $img_src;} ?>" alt="Card image cap" style="height:15em; width:15.9em">
 
        <div class="card-body" style="height:5.3em;">
          <h5 class="card-title">Dr. <?php echo $drow['firstname']." ".$drow['lastname'] ?></h5>
          <h6 class="card-title"><?php echo $drow['username'] ?><span style="float:right;"> first ID: <?php echo $drow['did'] ?> </span> </h6> 
         </div>
       <ul class="list-group list-group-flush">
         <li class="list-group-item">Speciality: <?php echo $drow['speciality'] ?></li>
         <li class="list-group-item">Qualification: <?php echo $drow['qualification'] ?></li>
         <li class="list-group-item">Gender: <?php echo $drow['gender'] ?> &nbsp; &nbsp; State: <?php echo $drow['state'] ?></li>
       </ul>
       <div class="card-body">
         <a href="patient_chatscreen.php?did=<?php echo $drow['did']; ?>" class="card-link btn-sm btn-success shadow-lg"> Send Message</a>
          <a href="patient_report_doc.php?did=<?php echo $drow['did']; ?>" class="card-link btn-sm btn-success">Report</a>
       </div>
     </div>

    </div>


    <!-- The photo modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <img style="height:38em; width:40em;" src="<?php if(isset($default)){echo $default;}else{ echo $img_src;} ?>">  

      </div>
      
    </div>
  </div>
</div>
<!-- photo modal end -->
    <?php }} }?>

<!-- sort -->
<?php

?>


   

 </div>        
</div>  
   <!-- end of col 2 -->
<div class="col-2"> 
   
   <div class="row mt-5">
   <div class="col">
   <h6> Sort by Speciality</h6>
   <form name="select_speciality" id="select" class="w-100">
            <div>
              <select name="speciality" id="d_speciality" onchange="selectSpeciality();" class="px-2 custom-select form-control  m-auto">
              <option value="" >--All specialities--</option>
                <option value="Cardiologist">Cardiologist</option>
                <option value="Dermatologist">Dermatologist</option>
                <option value="Gynecologist">Gynecologist</option>
                <option value="Orthopedian">Orthopedian Surgeon</option>
                <option value="Surgeon">Surgeon</option>
                <option value="pediatrician">pediatrician</option>
                <option value="Radiologist">Radiologist</option>
                <option value="Urollogist">Urollogist</option>
                <option value="Destist">Destist</option>
                <option value="GP">GP</option>
              </select>
            </div>
    </form>
    </div>
    </div>



   <div class="row mt-4">
     <div class="col">
    <h6> Search by Name</h6>
        <form name="search" id="search"  class="w-100">
	       <input type="text" name="keyword" onkeyup="findmatch();" class="form-control" placeholder="Enter Name">
        </form>
</div>
</div>

</div>
<!-- end of col 3 -->

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

   //enlarge doc dp

 $(".dp").click(function(){
  if($(this).attr("src") != "uploads/defaultpic.png"){ 
   if(this.style.height != "22em"){
    $(this).animate({
      height: "22em",
      width: "22em"
    });
   } else {
     $(this).animate({
       height: "15em",
       width: "15.9em"
     });
   }
  }
 });

 $(".dp").mouseleave(function(){
   $(this).animate({
       height: "15em",
       width: "15.9em"
   });
 });


// var dpList = document.querySelectorAll(".dp");

// for(i = 0; i < dpList.length; i++){
// 	var dp = dpList[i];
// 	dp.addEventListener("click", function(e){
//     e.target.classList.add("large");
// });
	
// }

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


// search ajax
function findmatch(){
  var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("result").innerHTML = xmlhttp.responseText;

$(".dp").click(function(){
  if($(this).attr("src") != "uploads/defaultpic.png"){ 
   if(this.style.height != "22em"){
    $(this).animate({
      height: "22em",
      width: "22em"
    });
   } else {
     $(this).animate({
       height: "15em",
       width: "15.9em"
     });
   }
  }
 });

 $(".dp").mouseleave(function(){
   $(this).animate({
       height: "15em",
       width: "15.9em"
   });
 });

		}
	}
	xmlhttp.open('GET', 'search.inc.php?keyword='+document.search.keyword.value, true);
	xmlhttp.send();
}


// select speciality ajax
function selectSpeciality(){
  var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("result").innerHTML = xmlhttp.responseText;

$(".dp").click(function(){
  if($(this).attr("src") != "uploads/defaultpic.png"){ 
   if(this.style.height != "22em"){
    $(this).animate({
      height: "22em",
      width: "22em"
    });
   } else {
     $(this).animate({
       height: "15em",
       width: "15.9em"
     });
   }
  }
 });

 $(".dp").mouseleave(function(){
   $(this).animate({
       height: "15em",
       width: "15.9em"
   });
 });

		}
	}
	xmlhttp.open('GET', 'select.inc.php?speciality='+document.select_speciality.speciality.value, true);
	xmlhttp.send();
}

 </script>
</body>
</html>