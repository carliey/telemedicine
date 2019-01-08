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

   

    //search
    if (isset($_POST['search_pid']) && !empty($_POST['pid_keyword'])){
          $keyword = $_POST['pid_keyword'];
        if(strlen($keyword) >= 1){
             $search_query = "SELECT * FROM patients INNER JOIN reports ON patients.pid = '%$keyword%'";   
 
                     } else { echo "Enter PID";} 
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
    <div class="col-10 row2">
    <div class="card-body">

    <div class="row mt-2">

<div class="col-1 mt-4" style="padding-left:0;">
<div class=""><a href="admin_reports.php" class="btn btn-sm btn-success">Back &#8656;</a></div>
</div>

   <div class="col-5">
    <h6> Search by Patient ID</h6>
        <form action="" method="POST" class="w-100">
	       <input type="text" name="pid_keyword" class="form-control" placeholder="Enter ID">
	       <input type="submit" value="search" name="search_pid" class="btn btn-success btn-sm w-100 mt-2">
        </form>
    </div>     
     
    <div class="col-5">
    <h6> Search by Doctor ID</h6>
        <form action="" method="POST" class="w-100">
	       <input type="text" name="did_keyword" class="form-control" placeholder="Enter ID">
	       <input type="submit" value="search" name="search_did" class="btn btn-success btn-sm w-100 mt-2">
        </form>
    </div>  
    </div> 
    </div>

    <div class="row">


 <div class="col-1">
</div>

 <div class="col-10">

<?php 
 //get doctor's details from database

 if (isset($search_query)){
     $query = $search_query;
 } else {

    $query = "SELECT * FROM patients INNER JOIN reports ON reports.pid = patients.pid ORDER BY `date` DESC";
 }

     $result = mysqli_query($conn, $query);
     if($result){
	  while ($row = mysqli_fetch_assoc($result)){

      $dquery = "SELECT * FROM `doctors` WHERE `did` = '".$row['did']."'";

       $dresult = mysqli_query($conn, $dquery);
       $did= $row['did'];
       if($dresult){
       if(mysqli_num_rows($dresult) >= 1){
           $drow = mysqli_fetch_assoc($dresult);
         ?>

<div class="card border-success mb-3 mt-4" >
  <div class="card-header bg-transparent border-success">
     <span style="font-weight:bold;">By: <?php echo $row['firstname']." ".$row['lastname']." id: ".$row['pid']; ?></span>
     <span style="padding-left:3em; font-weight:bold;">Doctor: <?php echo $drow['firstname']." ".$drow['lastname']." id: ".$row['did']; ?></span> 
     <span style="float:right;">Date/Time: <?php echo $row['date']; ?></span> 
  </div>
  <div class="card-body text-success">
    <p class="card-text"><?php echo $row['report']; ?></p>
  </div>
  <div class="card-footer bg-transparent border-success">
    <a href="admin_to_doc_chat.php?did=<?php echo $drow['did']; ?>" type="submit" class="btn btn-success btn-sm">Contact Doctor</a>
  </div>
</div>

<?php }}}} ?>

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
</body>
</html>
    