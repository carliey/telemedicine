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

         }// end get table data
   }//end query run


   // send message button
   if (isset($_POST['send_message'])){
       if(isset($_POST['message']) && !empty($_POST['message'])){
           $message = $_POST['message'];
          
           $query = "INSERT INTO `conversations` (`cid`, `pid`, `did`, `pm`, `dm`, `time`) VALUES (NULL, '".$_SESSION['id']."', {$did}, '$message', '', CURRENT_TIMESTAMP)";
           if(mysqli_query($conn, $query)){
               //send message
           }
       }
   }// end of send message button
   

    //upload file button
  if(isset($_POST['upload'])){
  
    $statusMsg = '';

    // File upload path
    $targetDir = "med_files/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
    
    if(!empty($_FILES["file"]["name"])){
        // Allow certain file formats
        $allowTypes = array('jpg','JPG','png','PNG','jpeg','JPEG', 'pdf','PDF', 'docx', 'DOCX');
        if(in_array($fileType, $allowTypes)){
            // Upload file to server
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                // Insert image file name into database
               $upload = "INSERT INTO `med_files` (`id`, `pid`, `file`, `date`) VALUES (NULL, '$id', '$fileName', CURRENT_TIMESTAMP);";
                //$insert = $db->query("INSERT into images (file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
                if(mysqli_query($conn, $upload)){
                   $successmsg = "The file ".$fileName. " has been uploaded successfully.";
                }else {
                    $statusMsg = "File upload failed, please try again.";
                } 
            }else{
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        }else{
            $statusMsg = 'Sorry, only JPG, JPEG , PNG, PDF and DOCX files are allowed to upload.';
        }
    }else{
        $statusMsg = 'Please select a file to upload.';
    }
} //end of upload btn

} //end of session
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

.row { 
    margin-right:0;
}


.row-header{     box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
    height:2em;
    background:#28a745;
    color:white;
    text-align:center;
    width:100%;
}

.alert{
    width:100%;
}

.dm{
width:70%;
display:inline-block;

}

.pm{
width:70%;
float:right;
clear:left;
display:inline;
}

.container{
    height:26em;
    overflow: scroll;
}

textarea{
    width:100%;
    border-radius: 10px 0px ;
}

.send{
    border-radius:0px 10px;
    height:2em;
    width:100%;
    padding-left:4px;

}

.msgrow{
    margin-top:1em;
    width:100%;                                                             
}

.med_file_row{
    margin-top:1em;
    width:100%;                                                             
}

.footer{
		width:100%;
		background: #bdf5bd;
		text-align:center;
		padding:2em;
	}

.status{
  width:100%;
  text-align:center;
  background:#bdf5bd;
  color:red;
  border-radius:10px;
}
.success{
  width:100%;
  text-align:center;
  background:#eee;
  color:green;
  border-radius:10px;

}

.update-success{
  width:100%;
  text-align:center;
  background:#eee;
  color:green;
  border-radius:10px;

}
.update-err{
  width:100%;
  text-align:center;
  background:#eee;
  color:red;
  border-radius:10px;

}

.alert-success {
    color: #f8f9fa;
    background-color: #73b783;
    border-color: #c3e6cb;
}

a {
    text-decoration: none;
    background-color: transparent;
    -webkit-text-decoration-skip: objects;
}

.fname{
    display:inline;
    overflow:scroll;
}
.delete{
    display:inline-block;
    position:absolute;
    left:320px;
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
              <a href="patient_select_doc.php">Select Doctor</a>
              <a href="patient_conversation.php" class="active">Conversations</a>
              <a href="patient_report_doc.php?did=<?php if(isset($drow['did'])){ echo $drow['did']; } ?>">Report Doctor</a>
              <a href="patient_bc.php">Admin Broadcasts</a>
              <a href="patient_update_profile">Edit Profile</a>
              <a href="" data-toggle="modal" data-target="#suggestion-modal">suggestion box</a>
              <a href="logout.php">Logout</a>
         </div>
      </div>    
    </div>

<?php
$query = "SELECT * FROM `doctors` WHERE `did` = '$did'";
$result = mysqli_query($conn, $query);
if($result){
if(mysqli_num_rows($result) == 1){
    $drow = mysqli_fetch_assoc($result);
}
}
     ?> 


    <!--  Column 2 -->
 <div class="col-10 col-sm-6 mx-auto mt-4 mt-sm-0 col2"> 
    <div class="row">
        <div class="row-header"> <h5><?php echo "Dr. ".$drow['firstname']." ".$drow['lastname'];  ?></h5></div>
    </div>
     
    <div class="row">
       <div class="col-2 mt-2">
         <div class=""><a href="patient_conversation.php" class="btn btn-sm btn-success">Back &#8656;</a></div>
         <div class="mt-2"><a href="patient_report_doc.php?did=<?php echo $drow['did']; ?>" class="btn btn-sm btn-success">Report Doc</a></div>
       </div>                                             
       
       <div class="col-10">

<div class="row chatrow">
   <div class="container" id="message">
<!-- chats go here by use of ajax -->
   </div>
</div>

<form method="POST" action="patient_chatscreen.php" class="needs-validation" novalidate>

<div class="row msgrow">

    <div class="col-10" style="padding:0;">
      <textarea name="message" rows="2" id="text" required> </textarea>
    </div>

    <div class="col-2" style="padding:0;">
      <input type="submit" value="Send" class=" btn btn-success send" name="send_message" > 
    </div>

</div>
</form>

        </div>
      </div>
   </div>

   <div class="col-10 col-sm-4 mx-auto col2"> 
    <div class="row">
        <div class="row-header"> <h5>Medical Files</h5></div>
   <?php if (isset($statusMsg)){echo "<div class='status'>".$statusMsg."</div>";}?> 
   <?php if (isset($successmsg)){echo "<div class='success'>".$successmsg."</div>";} ?> 
     <div class="container" id="files">
<!-- Files will go here -->
   </div>
</div>

<form method="POST" action="patient_chatscreen.php" enctype="multipart/form-data" class="needs-validation" novalidate>

<div class="row med_file_row">

    <div class="col-10" style="padding:0;">
       <input type="file" name="file" class="form-control" >
      </div>
    
     
    <div class="col-2" style="padding:0;">
      <input type="submit" value="upload" class=" btn btn-success send" name="upload" > 
    </div>

</div>
</form>

        </div>

    </div>
</div>
</div>

<!-- footer row -->
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
                <div class="invalid-feedback">*required </div>                     
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


<!-- dlete customer modal -->
<div class="modal fade" id="delete-teacher-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content ">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="exampleModalLongTitle">Delete</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <input id="delete-teacher-input" type="hidden" name="id"
           value="" >

          <div class="modal-body">
            <p class="lead">Delete this Item? <?php echo $frow['id'];?></p>
          </div>
          <div class="modal-footer m-auto">
            <button type="button" class="btn btn-secondary " data-dismiss="modal">Cancel</button>
            <a href="delete.php?id=<?php echo $frow['id'];?>" type="submit" class="btn btn-danger">Delete</button>
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


   window.onload=function () {
      var objDiv = document.getElementById("message");
      objDiv.scrollTop = objDiv.scrollHeight;
 }

//get chats ajax
function getChat(){
  var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("message").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open('GET', 'chats.inc.php?did=<?php echo $did ?>', true);
	xmlhttp.send();

      var objDiv = document.getElementById("message");
      objDiv.scrollTop = objDiv.scrollHeight;
}

//get chats ajax
function getFiles(){
  var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("files").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open('GET', 'chats.inc.php?p_files=<?php echo $did ?>', true);
	xmlhttp.send();

      var objDiv = document.getElementById("files");
      objDiv.scrollTop = objDiv.scrollHeight;
}

//call get chat function
setInterval(getChat, 1000); // The interval set to 1 second
setInterval(getFiles, 1000); // The interval set to 1 second

document.getElementById("text").onkeypress = function(event){
                if (event.keyCode == 13 || event.which == 13){
                    alert("You are clicked");
                }
            };

//call scroll to bottom function

// objDiv.onscroll = function(){
//     alert('scrolled');
// }

// setInterval(function() {
//       var objDiv = document.getElementById("message");
//       objDiv.scrollTop = objDiv.scrollHeight;
//  }, 1000); // The interval set to 1 second


 </script>
</body>
</html>