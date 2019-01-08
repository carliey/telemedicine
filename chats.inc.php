<?php 
session_start();
include 'connection/sqlconnect.php';

//get and set did
if(isset($_GET['did'])){
	$did = $_GET['did'];

  $cquery = "SELECT * FROM `conversations` WHERE `pid` = '".$_SESSION['id']."' and did={$did}";
  $cresult = mysqli_query($conn, $cquery);
 if($cresult){
    while ($crow = mysqli_fetch_assoc($cresult)){
        
       if ($crow['dm'] !=""){ 
           echo "<div class='alert alert-success mt-2 dm' role='alert'><p>".$crow['dm']."</p></div>";


       } 

       if ($crow['pm'] !=""){ echo "<div class='alert alert-primary mt-2 pm' role='alert'><p>".$crow['pm']."</p></div>";
    } 
   
    }
}
}

// delete button <a class='btn btn-sm btn-danger delete'>Delete</a>
// get med files
if(isset($_GET['p_files'])){
   $pid = $_GET['p_files'];

$fquery = "SELECT * FROM `med_files` WHERE `pid` = '".$_SESSION['id']."'";
$fresult = mysqli_query($conn, $fquery);
if($fresult){
  while ($frow = mysqli_fetch_assoc($fresult)){
      
         echo "<div class='alert alert-primary mt-2 role='alert'><a target='_blank' href='med_files/".$frow['file']."'><p class='fname'>".$frow['file']."
         </p></a></div>";

     } 
  }
}

//get and set did
//get messages for doctor
if(isset($_GET['pid'])){
   $pid = $_GET['pid'];
   
  $cquery = "SELECT * FROM `conversations` WHERE `did` = '".$_SESSION['id']."' and pid={$pid}";
  $cresult = mysqli_query($conn, $cquery);
 if($cresult){
    while ($crow = mysqli_fetch_assoc($cresult)){
        
       if ($crow['dm'] !=""){  echo "<div class='alert alert-primary mt-2 dm' role='alert'><p>".$crow['dm']."</p></div>";


       } 

       if ($crow['pm'] !=""){ echo "<div class='alert alert-success mt-2 pm' role='alert'><p>".$crow['pm']."</p></div>";
    } 
   
    }
}
}


?>