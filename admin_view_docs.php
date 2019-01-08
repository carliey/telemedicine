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

   //set status variable
   if (isset($status)){
    $status = $status;
   } 
   //sort doctors

   //by speciality
   //sort button
  if(isset($_POST['by_speciality']) && !empty($_POST['speciality'])){
    $speciality =$_POST['speciality'];
    $result_type = $speciality;
    }
   
    //by status
   if(isset($_POST['by_status']) && !empty($_POST['status'])){
    $status =$_POST['status'];
    $result_type = $status;
    }

    //by state
    if(isset($_POST['by_state']) && !empty($_POST['state'])){
        $state =$_POST['state'];
        $result_type = $state;
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

.card{
    box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)
    }

.card a:hover{
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

.alert{
   padding:0;
   margin:0;
   text-align:center;
}

.card:hover{
    transition: transform .5s;

    transition: opacity 2s cubic-bezier(.165, .84, .44, 1);
    box-shadow: 0 8px 17px 0 rgba(0, 0, 0, .2), 0 6px 20px 0 rgba(0, 0, 0, .15);
    content: '';
    opacity: 1;
    z-index: 1;
    }

.dp{
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

    <!-- column two -->
    <div class="col-12 col-sm-10 row2">
    <div class="card-body">

    <div class="row mt-2">

  <div class="col">
   <form name="select_speciality" id="select" class="">
   <h6> Sort by Speciality</h6>
            <div>
              <select name="speciality" id="d_speciality" onchange="selectSpeciality();"  class="px-2 custom-select form-control  m-auto">
              <option value="" >All Specialities</option>
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

    <div class="col">
   <form name="select_status" id="select" class="">
   <h6> Sort by Status</h6>
            <div>
              <select name="status" id="d_status" onchange="selectStatus();"  class="px-2 custom-select form-control  m-auto">
              <option value="" >All Doctors</option>
                <option value="pending">Pending</option>
                <option value="Inactive">Inactive</option>
                <option value="Active">Active</option>
              </select>
            </div>
    </form>
    </div>

<div class="col">
   <form name="select_state" id="select_state">
   <h6> Sort by State</h6>
            <div>
              <select name="state" id="d_state" onchange="selectState();"  class="px-2 custom-select form-control  m-auto">
              <option value="" >All States</option>
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
    </form>
    </div>

   <div class="col">
    <h6> Search by Name</h6>
        <form name="search" id="search" class="w-100">
	       <input type="text" name="keyword" onkeyup="findmatch();" class="form-control" placeholder="Enter Name">
        </form>
    </div>

    </div>
     
<div class="row" id="result">
<div class="row-header"> <h5><?php if(isset($result_type)){echo $result_type;} else {echo "All Doctors";}?></h5></div>


    <?php 

if (isset($speciality)){

$data = "SELECT * FROM `doctors` WHERE `speciality`"."='$speciality' ";

} else if(isset($status)){

$data = "SELECT * FROM `doctors` WHERE `status`"."='$status' ";

} else if(isset($state)){

$data = "SELECT * FROM `doctors` WHERE `state`"."='$state' ";

} else{
    
$data = "select * from doctors ";

}
   $data= mysqli_query($conn, $data);
   if(mysqli_num_rows($data) > 0){

      while ($row=mysqli_fetch_assoc($data))
    {
       //get doctors profile pictures
       if($row['image_url'] == "nopic"){
         $default = "uploads/defaultpic.png";
           $img_src = $default; 
       }else{
       $img_src = "uploads/".$row['image_url'];
        }
   ?>

<div class="col-md-3 mt-2 mb-2">
  <div class="card" style="width: 16rem;">
          <img class="card-img-top img-flud dp" src="<?php if(isset($default)){echo $img_src;}else{ echo $img_src;} ?>" alt="Card image cap" style="height:11em;">
        <div class="card-body" style="height:5.3em;">
          <h5 class="card-title">Dr. <?php echo $row['firstname']." ".$row['lastname'] ?></h5>
          <h6 class="card-title"><?php echo $row['username'] ?><span style="float:right;"> ID: <?php echo $row['did'] ?> </span> </h6> 
         </div>
       <ul class="list-group list-group-flush">
         <li class="list-group-item">Speciality: <?php echo $row['speciality'] ?></li>
         <li class="list-group-item">Gender: <?php echo $row['gender'] ?></li>
         
         <li class="list-group-item"> <?php if ($row['status'] == 'Active'){
                          echo "<div class='alert alert-success' role='alert'>".$row['status']."</div>";
                     }else if($row['status'] == 'Inactive'){
                          echo "<div class='alert alert-danger' role='alert'>".$row['status']."</div>";
                     } else {
                        echo "<div class='alert alert-danger' role='alert'>".$row['status']."</div>";
                     } ?>
         </li>
      </ul>
       
       <div class="card-body">
         <a href="admin_doctor.php?did=<?php echo $row['did']; ?>" class="card-link btn-sm btn-success"> More Details</a>
       </div>
     </div>

    </div>
    <?php }} else{ ?>
    <div class='w-100'><p class='text-center mt-3 alert-danger'>No Result Found</p></div>
    <?php }?>



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

//enlarge dp
$(".dp").click(function(){
  if($(this).attr("src") != "uploads/defaultpic.png"){   
   if(this.style.height != "22em"){
    $(this).animate({
      height: "22em",
      width: "22em"
    });
   } else {
     $(this).animate({
       height: "11em",
       width: "15.9em"
     });
   }
  }
 });

 $(".dp").mouseleave(function(){
   $(this).animate({
       height: "11em",
       width: "15.9em"
   });
 });


   // search ajax
function findmatch(){
  var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("result").innerHTML = xmlhttp.responseText;

//enlarge dp
$(".dp").click(function(){
  if($(this).attr("src") != "uploads/defaultpic.png"){   
   if(this.style.height != "22em"){
    $(this).animate({
      height: "22em",
      width: "22em"
    });
   } else {
     $(this).animate({
       height: "11em",
       width: "15.9em"
     });
   }
  }
 });

 $(".dp").mouseleave(function(){
   $(this).animate({
       height: "11em",
       width: "15.9em"
   });
 });


		}
	}
	xmlhttp.open('GET', 'search.inc.php?a_doc_keyword='+document.search.keyword.value, true);
	xmlhttp.send();
}
  

// select status ajax
function selectStatus(){
  var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("result").innerHTML = xmlhttp.responseText;

//enlarge dp
$(".dp").click(function(){
  if($(this).attr("src") != "uploads/defaultpic.png"){   
   if(this.style.height != "22em"){
    $(this).animate({
      height: "22em",
      width: "22em"
    });
   } else {
     $(this).animate({
       height: "11em",
       width: "15.9em"
     });
   }
  }
 });

 $(".dp").mouseleave(function(){
   $(this).animate({
       height: "11em",
       width: "15.9em"
   });
 });


		}
	}
	xmlhttp.open('GET', 'select.inc.php?d_status='+document.select_status.d_status.value, true);
	xmlhttp.send();
}


// select state ajax
function selectState(){
  var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("result").innerHTML = xmlhttp.responseText;

//enlarge dp
$(".dp").click(function(){
  if($(this).attr("src") != "uploads/defaultpic.png"){   
   if(this.style.height != "22em"){
    $(this).animate({
      height: "22em",
      width: "22em"
    });
   } else {
     $(this).animate({
       height: "11em",
       width: "15.9em"
     });
   }
  }
 });

 $(".dp").mouseleave(function(){
   $(this).animate({
       height: "11em",
       width: "15.9em"
   });
 });


		}
	}
	xmlhttp.open('GET', 'select.inc.php?d_state='+document.select_state.d_state.value, true);
	xmlhttp.send();
}


// select state ajax
function selectSpeciality(){
  var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("result").innerHTML = xmlhttp.responseText;

//enlarge dp
$(".dp").click(function(){
  if($(this).attr("src") != "uploads/defaultpic.png"){   
   if(this.style.height != "22em"){
    $(this).animate({
      height: "22em",
      width: "22em"
    });
   } else {
     $(this).animate({
       height: "11em",
       width: "15.9em"
     });
   }
  }
 });

 $(".dp").mouseleave(function(){
   $(this).animate({
       height: "11em",
       width: "15.9em"
   });
 });


		}
	}
	xmlhttp.open('GET', 'select.inc.php?d_speciality='+document.select_speciality.d_speciality.value, true);
	xmlhttp.send();
}
 </script>
</body>
</html>
