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


.container{
    padding:0;
    margin:0;
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
    <div class="col-10 col2"> 

<div class="row">

<div class="col-1 mt-2">
         <div class=""><a href="admin_dashboard.php" class="btn btn-sm btn-success">Back &#8656;</a></div>
</div>                      

<div class="col-5" style="position:relative;">
<div class="col col-sm-12 col-md- p-3" style="max-width:auto;">
                            <a href="admin_doc_reports.php">
                    <div class="card border-success text-center">
                        <div class="card-body">
                                <img class="invoice" src="../images/icons/report.jpg" alt="" style="width:100px; height:80px;">
                            <h5 class="text-dark">
                                Patients Reports
                            </h5>
                            <p class="text-success">
                            View Patients Complaints
                            </p>
                        </div>
                    </div>
                    </a>
</div>
</div>


                
 <div class="col-5" style="position:relative;">
 
                <div class="col col-sm-12  p-3">
                <a href="admin_suggestions.php">
                    <div class="card border-success text-center">
                        <div class="card-body">
                                <img class="invoice" src="../images/icons/feedback.png" alt="" style="width:100px; height:80px;">
                            <h5 class="text-dark">
                                Suggestions
                            </h5>
                            <p class="text-success">
                            View Users Suggestions
                            </p>
                        </div>
                    </div>
                </a>
                </div>
  </div>
               

<div class="col-5" style="position:relative; left:6em;">
 
 <div class="col col-sm-12  p-3">
 <a href="admin_to_doc.php?did=<?php if(isset($drow['did'])){ echo $drow['did']; } ?>">
     <div class="card border-success text-center">
         <div class="card-body">
                 <img class="invoice" src="../images/icons/admintodoc.jpg" alt="" style="width:100px; height:80px;">
             <h5 class="text-dark">
                 Doctors Messages
             </h5>
             <p class="text-success">
             View Messages From Doctors
             </p>
         </div>
     </div>
 </a>
 </div>
</div>


 <div class="col-5" style="position:relative; left:6em;">
 
 <div class="col col-sm-12  p-3">
 <a href="admin_broadcasts.php">
     <div class="card border-success text-center card_one">
         <div class="card-body">
                 <img class="invoice" src="../images/icons/bc.png" alt="" style="width:100px; height:80px;">
             <h5 class="text-dark">
                 Broadcasts
             </h5>
             <p class="text-success">
             View Messages From Doctors
             </p>
         </div>
     </div>
 </a>
 </div>
</div>



</div>
<!-- end of col 3 -->
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
    