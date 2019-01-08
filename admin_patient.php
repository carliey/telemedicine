<?php
session_start();

if(isset($_GET['pid'])){
   $_SESSION['pid'] = $_GET['pid']; 
   $pid = $_SESSION['pid'];
}
else{
   $pid = $_SESSION['pid'];
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

<?php
                       
                       // change status
                        if (isset($_POST['change']) && !empty($_POST['status'])){
                             $status = $_POST['status'];
                             $query = "UPDATE `patients` SET `status` = '{$status}' WHERE `pid` = {$pid}";
                             if($result = mysqli_query($conn, $query)){
                                $change_success = "Status Changed Successfully";
                             };
                            }
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

.alert{
   padding:0;
   margin:0;
   text-align:center;
}

.list-group-flush{
    padding-left:0;
}

/* profile photo modal */
.modal-content{
width: 200%;
background:0;
border:0;
}

.modal-body{
padding:0;
}

.close {
    float: right;
    font-size: 2rem;
    font-weight: 500;
    line-height: 1;
    color: white;
    opacity: .8;
    padding:0;
    margin:0;
}

.modal-header .close {
    padding: 0.5em;
    margin: -1rem -1rem -1rem auto;
}

button.close {
    padding: 0;
    color:white;

}

.modal-header{
    border:0;
    display:block;
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
              <a href="admin_view_patients.php"class="active">Patients</a>
              <a href="admin_reports.php">Messages</a>
              <a href="admin_edit_profile">Edit Profile</a>
              <a href="logout.php">Logout</a>
         </div>
      </div>    
    </div>

    <!-- column two -->
    <div class="col-10 row2"> 

<div class="row">

<div class="col-2 mt-4">
<div class=""><a href="admin_view_patients.php" class="btn btn-sm btn-success">Back &#8656;</a></div>
</div>

    <div class="col-7 col-sm-10 mx-auto">

<?php

 //get doctor's details from database
 $query = "SELECT * FROM patients WHERE `pid` = {$pid}";
 $result = mysqli_query($conn, $query);
 if($result){
     if(mysqli_num_rows($result) == 1){
         $row =                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     mysqli_fetch_assoc($result);
        
         //get patients profile pictures
        if($row['image_url'] == "nopic"){
         $default = "uploads/defaultpic.png";
           $img_src = $default; 
       }else{
       $img_src = "uploads/".$row['image_url'];
        }
    }
 }


?>


<div class="container" style="margin:1em 0;">
    <div class="text-center">
        <p style="color:green"><?php if(isset($change_success)) echo $change_success ?></p>
    </div>

<div class="row"> 

<div class="col-md-4 col-sm-2">
  </div>

   <div class="col-md-6 col-sm-8">
      <a href="#" data-toggle="modal" data-target="#exampleModalCenter">
          <img style="height:14em; width:14em;" class="img-thumbnail" src="<?php echo $img_src ?>">  
      </a>
   </div>

<!-- The photo modal -->
<?php 
    $default = "uploads/defaultpic.png";
    if($img_src != $default){
?>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <img style="height:28em; width:30em;" src="<?php echo $img_src ?>">  
      </div>
      
    </div>
  </div>
</div>
    <?php }?>

   <div class="col-md-3 col-sm-2">
  </div>
</div>

<div class="row">
<div class="col-md-4 col-sm-12">
  <nav>
   <ol class=" list-group-flush">
    <li class="list-group-item"><strong class="text-muted">First Name:</strong><span class="text-muted"> <?php echo $row['firstname'];?></span></li>
    <li class="list-group-item"><strong class="text-muted">Lastname:</strong><span class="text-muted"> <?php echo $row['lastname'];?></strong></li>
    <li class="list-group-item"><strong class="text-muted">Username:</strong><span class="text-muted"><?php echo $row['username'];?></li>
    <li class="list-group-item"><strong class="text-muted">id:</strong><span class="text-muted"> <?php echo $row['pid'];?></li>
    <li class="list-group-item" style="padding:0;"></li>
   </ol>
  </nav>
</div>

  <div class="col-md-4 col-sm-12" >
      <nav>
        <ol class=" list-group-flush">
           <li class="list-group-item"><strong class="text-muted">Gender:</strong><span class="text-muted"> <?php echo $row['gender'];?></li>
           <li class="list-group-item"><strong class="text-muted">Age Group:</strong><span class="text-muted"> <?php echo $row['age_group'];?></li>
           <li class="list-group-item"><strong class="text-muted">Genotype:</strong><span class="text-muted"> <?php echo $row['genotype'];?></li>
           <li class="list-group-item"><strong class="text-muted">Blood Group:</strong><span class="text-muted"><?php echo $row['blood_type'];?></li>
           <li class="list-group-item" style="padding:0;"></li>
       </ol>
    </nav>
   </div>

   <div class="col-md-4 col-sm-12">
      <nav>
          <ol class=" list-group-flush">
             <li class="list-group-item"><strong class="text-muted">Contact:</strong><span class="text-muted"> <?php echo $row['contact'];?></li>
             <li class="list-group-item"><strong class="text-muted">State:</strong><span class="text-muted"> <?php echo $row['state'];?></li>
             <li class="list-group-item"><strong class="text-muted">City:</strong><span class="text-muted"> <?php echo $row['city'];?></li>
             <li class="list-group-item"><strong class="text-muted">Address:</strong><span class="text-muted"> <?php echo $row['address'];?></li>
             <li class="list-group-item" style="padding:0;"></li>
          </ol>
     </nav>
   </div>
</div>

<div class="row">

<div class="col-4">
</div>

<div class="col-4">

<?php if ($row['status'] == 'Active'){
                          echo "<div class='alert alert-success' role='alert'>".$row['status']."</div>";
                     }else if($row['status'] == 'Inactive'){
                          echo "<div class='alert alert-danger' role='alert'>".$row['status']."</div>";
                     } else {
                        echo "<div class='alert alert-danger' role='alert'>".$row['status']."</div>";
                     } ?>

</div>

<div class="col-4">
</div>

</div>

<div class="row">

<div class="col-md-4 col-sm-2">
</div>

<div class="col-md-4 col-sm-8">

<form action="" method="POST" class="">
                          <div>
                            <select name="status"  class="px-2 custom-select custom-select-sm form-control  m-auto">
                               <option value="" >Change Status</option>
                               <option value="Inactive">Inactive</option>
                               <option value="Active">Active</option>
                            </select>
                        <input type="hidden" name="cdid" value="<?php ?>">
                        <button name="change" class="btn btn-success btn-sm w-100 mt-2">Change</button>
                       </div>
                    </form>

</div>
</div>

<div class="col-md-4 col-sm-2">
</div>

</div>

</div>

</div><!-- End of container  -->
</div><!-- End of middle column  -->

<div class="col-2">
</div>
</div> <!-- End of 1st row  -->
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
    