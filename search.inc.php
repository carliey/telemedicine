<?php 
session_start();
include 'connection/sqlconnect.php';


 //get keyword for dr search
 if(isset($_GET['keyword'])){
	$keyword = $_GET['keyword']; 
//Beginning of Doctors search for patient

if(!empty($keyword)){ 
	 
	 $result_type = $keyword;
	 echo '<div class="row-header"> <h5>'.$keyword.'</h5></div>';

	$dquery = "SELECT * FROM `doctors` WHERE `firstname` LIKE '%$keyword%' || `lastname` LIKE '%$keyword%'";    

 $dresult = mysqli_query($conn, $dquery);
 if($dresult){

	 if(mysqli_num_rows($dresult) == 0){
		 echo "<div class='w-100'><p class='text-center mt-3 alert-danger'>No Match Found</p></div>";
	 } else{

	while ($drow = mysqli_fetch_assoc($dresult)){

         //get doctors profile pictures
         if($drow['image_url'] == "nopic"){
            $default = "uploads/defaultpic.png";
							$img_src = $default; 
							
          }else{
          $img_src = "uploads/".$drow['image_url'];
					 }
					 
         ?>

   <div class="col-md-4 mt-2 mb-2">
  <div class="card" style="width: 16rem;">
        <img class="card-img-top img-fuid dp" src="<?php if(isset($default)){echo $img_src;}else{ echo $img_src;} ?>" alt="Card image cap" style="height:15em; width:15.9em">
         <div class="card-body" style="height:5.3em;">
           <h5 class="card-title">Dr. <?php echo $drow['firstname']." ".$drow['lastname'] ?></h5>
           <h6 class="card-title"><?php echo $drow['username'] ?><span style="float:right;"> third ID: <?php echo $drow['did'] ?> </span> </h6> 
          </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">Speciality: <?php echo $drow['speciality'] ?></li>
          <li class="list-group-item">Qualification: <?php echo $drow['qualification'] ?></li>
          <li class="list-group-item">Gender: <?php echo $drow['gender'] ?> &nbsp; &nbsp; State: <?php echo $drow['state'] ?></li>
        </ul>
        <div class="card-body">
          <a href="patient_chatscreen.php?did=<?php echo $drow['did']; ?>" class="card-link btn-sm btn-success"> Send Message</a>
           <a href="patient_report_doc.php?did=<?php echo $drow['did']; ?>" class="card-link btn-sm btn-success">Report</a>
        </div>
      </div>

    </div>
     <?php }}}} else {
	//get doctor's details from database
		 $dquery = " SELECT * FROM `doctors`";
	
  
	$dresult = mysqli_query($conn, $dquery);
	if($dresult){
		echo '<div class="row-header"> <h5>All doctors</h5></div>';

	  while ($drow = mysqli_fetch_assoc($dresult)){
  
			  //get doctors profile pictures
			  if($drow['image_url'] == "nopic"){
				  $default = "uploads/defaultpic.png";
					 $img_src = $default; 
				}else{
				$img_src = "uploads/".$drow['image_url'];
				 }
  
			  ?>
  
	 <div class="col-md-4 mt-2 mb-2">
	 <div class="card" style="width: 16rem;">
	       <img class="card-img-top img-fuid dp" src="<?php if(isset($default)){echo $img_src;}else{ echo $img_src;} ?>" alt="Card image cap" style="height:15em; width:15.9em">
			 <div class="card-body" style="height:5.3em;">
				<h5 class="card-title">Dr. <?php echo $drow['firstname']." ".$drow['lastname'] ?></h5>
				<h6 class="card-title"><?php echo $drow['username'] ?><span style="float:right;"> ID: <?php echo $drow['did'] ?> </span> </h6> 
			  </div>
			<ul class="list-group list-group-flush">
			  <li class="list-group-item">Speciality: <?php echo $drow['speciality'] ?></li>
			  <li class="list-group-item">Qualification: <?php echo $drow['qualification'] ?></li>
			  <li class="list-group-item">Gender: <?php echo $drow['gender'] ?> &nbsp; &nbsp; State: <?php echo $drow['state'] ?></li>
			</ul>
			<div class="card-body">
			  <a href="patient_chatscreen.php?did=<?php echo $drow['did']; ?>" class="card-link btn-sm btn-success"> Send Message</a>
				<a href="patient_report_doc.php?did=<?php echo $drow['did']; ?>" class="card-link btn-sm btn-success">Report</a>
			</div>
		 </div>
  
		</div>
		<?php }
}	
} 

 }// end get keyword
?>
				<!-- End of doctor's search  -->

<!-- Beginning of doctors search for doctors -->
<?php
 //get keyword for dr search
 if(isset($_GET['dd_keyword'])){
	$keyword = $_GET['dd_keyword']; 
//Beginning of Doctors search for patient

if(!empty($keyword)){ 
	 
	 $result_type = $keyword;
	 echo '<div class="row-header"> <h5>'.$keyword.'</h5></div>';

	$dquery = "SELECT * FROM `doctors` WHERE `firstname` LIKE '%$keyword%' || `lastname` LIKE '%$keyword%'";    

 $dresult = mysqli_query($conn, $dquery);
 if($dresult){

	 if(mysqli_num_rows($dresult) == 0){
		 echo "<div class='w-100'><p class='text-center mt-3 alert-danger'>No Match Found</p></div>";
	 } else{

	while ($drow = mysqli_fetch_assoc($dresult)){

         //get doctors profile pictures
         if($drow['image_url'] == "nopic"){
            $default = "uploads/defaultpic.png";
							$img_src = $default; 
							
          }else{
          $img_src = "uploads/".$drow['image_url'];
					 }

					 // hide self
          if($_SESSION['id'] == $drow['did']){
	          //do nothing
           } else {					 
					 
         ?>

  <div class="col-md-4 mt-2 mb-2">
  <div class="card" style="width: 16rem;">
        <img class="card-img-top img-fuid dp" src="<?php if(isset($default)){echo $img_src;}else{ echo $img_src;} ?>" alt="Card image cap" style="height:15em; width:15.9em">
        <div class="card-body" style="height:5.3em;">
          <h5 class="card-title">Dr. <?php echo $drow['firstname']." ".$drow['lastname'] ?></h5>
          <h6 class="card-title"><?php echo $drow['username'] ?><span style="float:right;"> ID: <?php echo $drow['did'] ?> </span> </h6> 
         </div>
       <ul class="list-group list-group-flush">
         <li class="list-group-item">Speciality: <?php echo $drow['speciality'] ?></li>
         <li class="list-group-item">Qualification: <?php echo $drow['qualification'] ?></li>
         <li class="list-group-item">Gender: <?php echo $drow['gender'] ?> &nbsp; &nbsp; State: <?php echo $drow['state'] ?></li>
       </ul>
       <div class="card-body">
         <a href="doc_to_doc_chat.php?did_2=<?php echo $drow['did']; ?>" class="card-link btn-sm btn-success"> Send Message</a>
       </div>
     </div>
    </div>
	 
		 <?php
					 }//end hide 
		}}}} else {
	//get doctor's details from database
		 $dquery = " SELECT * FROM `doctors`";
	
  
	$dresult = mysqli_query($conn, $dquery);
	if($dresult){
		echo '<div class="row-header"> <h5>All doctors</h5></div>';

	  while ($drow = mysqli_fetch_assoc($dresult)){
  
			  //get doctors profile pictures
			  if($drow['image_url'] == "nopic"){
				  $default = "uploads/defaultpic.png";
					 $img_src = $default; 
				}else{
				$img_src = "uploads/".$drow['image_url'];
				 }
	
				  // hide self
           if($_SESSION['id'] == $drow['did']){
	         	//do nothing
          	} else {
			  ?>
  
  <div class="col-md-4 mt-2 mb-2">
  <div class="card" style="width: 16rem;">
        <img class="card-img-top img-fuid dp" src="<?php if(isset($default)){echo $img_src;}else{ echo $img_src;} ?>" alt="Card image cap" style="height:15em; width:15.9em">
        <div class="card-body" style="height:5.3em;">
          <h5 class="card-title">Dr. <?php echo $drow['firstname']." ".$drow['lastname'] ?></h5>
          <h6 class="card-title"><?php echo $drow['username'] ?><span style="float:right;"> ID: <?php echo $drow['did'] ?> </span> </h6> 
         </div>
       <ul class="list-group list-group-flush">
         <li class="list-group-item">Speciality: <?php echo $drow['speciality'] ?></li>
         <li class="list-group-item">Qualification: <?php echo $drow['qualification'] ?></li>
         <li class="list-group-item">Gender: <?php echo $drow['gender'] ?> &nbsp; &nbsp; State: <?php echo $drow['state'] ?></li>
       </ul>
       <div class="card-body">
         <a href="doc_to_doc_chat.php?did_2=<?php echo $drow['did']; ?>" class="card-link btn-sm btn-success"> Send Message</a>
       </div>
     </div>
    </div>
		<?php 
		}//end hide
		}
}	
} 

 }// end get keyword
?>
<!-- End of doc search doc-->


				<!-- Beginning of admin search -->
				<!-- admin search patients -->
<?php

if(isset($_GET['patient_keyword'])){
	$keyword = $_GET['patient_keyword'];

				if(!empty($keyword)){ 
					$result_type = $keyword;
					echo '<div class="row-header"> <h5>'.$keyword.'</h5></div>';

					$data = "SELECT * FROM `patients` WHERE `firstname` LIKE '%$keyword%' || `lastname` LIKE '%$keyword%'";    

					$data= mysqli_query($conn, $data);

					if(mysqli_num_rows($data) == 0){
						echo "<div class='w-100'><p class='text-center mt-3 alert-danger'>No Match Found</p></div>";
					} else{
			 
    while ($row=mysqli_fetch_assoc($data))
    { 
       //get profile pictures
       if($row['image_url'] == "nopic"){
         $default = "uploads/defaultpic.png";
           $img_src = $default; 
       }else{
       $img_src = "uploads/".$row['image_url'];
        } 
      ?>

                <div class="col-md-3 mt-2 mb-2">
  <div class="card" style="width: 16rem;">
       <img class="card-img-top img-flid dp" src="<?php if(isset($default)){echo $img_src;}else{ echo $img_src;} ?>" alt="Card image cap" style="height:11em;">
        <div class="card-body" style="height:5.3em;">
          <h5 class="card-title"> <?php echo $row['firstname']." ".$row['lastname'] ?></h5>
          <h6 class="card-title"><?php echo $row['username'] ?><span style="float:right;"> ID: <?php echo $row['pid'] ?> </span> </h6> 
         </div>
       <ul class="list-group list-group-flush">
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
         <a href="admin_patient.php?pid=<?php echo $row['pid']; ?>" class="card-link btn-sm btn-success"> More Details</a>
       </div>
     </div>

    </div>
    <?php }} } else {

			 $data = "select * from patients ";
			 echo '<div class="row-header"> <h5>All Patients</h5></div>';

         
			
					$data= mysqli_query($conn, $data);
					if(mysqli_num_rows($data)>0){

	while ($row=mysqli_fetch_assoc($data))
	{ 
		 //get  profile pictures
		 if($row['image_url'] == "nopic"){
			 $default = "uploads/defaultpic.png";
				 $img_src = $default; 
		 }else{
		 $img_src = "uploads/".$row['image_url'];
			} 
		?>

							<div class="col-md-3 mt-2 mb-2">
<div class="card" style="width: 16rem;">
    <img class="card-img-top img-flid dp" src="<?php if(isset($default)){echo $img_src;}else{ echo $img_src;} ?>" alt="Card image cap" style="height:11em;">
			<div class="card-body" style="height:5.3em;">
				<h5 class="card-title"> <?php echo $row['firstname']." ".$row['lastname'] ?></h5>
				<h6 class="card-title"><?php echo $row['username'] ?><span style="float:right;"> ID: <?php echo $row['pid'] ?> </span> </h6> 
			 </div>
		 <ul class="list-group list-group-flush">
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
			 <a href="admin_patient.php?pid=<?php echo $row['pid']; ?>" class="card-link btn-sm btn-success"> More Details</a>
		 </div>
	 </div>

	</div>
	<?php }} } 
}//end of get patient keyword

	//Admin search doctor's
	if (isset($_GET['a_doc_keyword'])){
		$keyword = $_GET['a_doc_keyword'];

		if(!empty($keyword)){ 
	 
			$result_type = $keyword;
			echo '<div class="row-header"> <h5>'.$keyword.'</h5></div>';
	 
		 $dquery = "SELECT * FROM `doctors` WHERE `firstname` LIKE '%$keyword%' || `lastname` LIKE '%$keyword%'";    
	 
		$dresult = mysqli_query($conn, $dquery);
		if($dresult){
	 
			if(mysqli_num_rows($dresult) == 0){
				echo "<div class='w-100'><p class='text-center mt-3 alert-danger'>No Match Found</p></div>";
			} else{

				while ($row=mysqli_fetch_assoc($dresult)){

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
			<img class="card-img-top img-flid dp" src="<?php if(isset($default)){echo $img_src;}else{ echo $img_src;} ?>" alt="Card image cap" style="height:11em;">
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
				<?php }}}} else{ 
	//get doctor's details from database
		 $dquery = " SELECT * FROM `doctors`";
	
  
	$dresult = mysqli_query($conn, $dquery);
	if($dresult){
		echo '<div class="row-header"> <h5>All doctors</h5></div>';

		while ($row=mysqli_fetch_assoc($dresult)){

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
 <img class="card-img-top img-flid dp" src="<?php if(isset($default)){echo $img_src;}else{ echo $img_src;} ?>" alt="Card image cap" style="height:11em;">
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
	 <?php }}}}?>


<?php
//Verify Entered ID on patient report doc page
if (isset($_GET['report_id'])){
	 $did = $_GET['report_id'];
	if(!empty($did)){
		$dquery = "SELECT * FROM `telemedicine`.`doctors` WHERE `did` = '{$did}'";
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
      $id_err = "ID: ".$did." does not Exist ";
    ?>

   <p style="text-align:center; color:red; font-size:12px;"><?php if (isset($id_err)){echo $id_err;}?></p>

<?php 
}
}
} 
}//end check
?>

<?php
// Search doctors username in patient conversations list
if(isset($_GET['doc_cid'])){
	session_start();
	$doc_name = $_GET['doc_cid'];
 
	if(!empty($doc_name)){
		echo '<div class="row-header"> <h5>'.$doc_name.'</h5></div>';
		// $query = "SELECT * FROM `doctors` WHERE `firstname` LIKE '%$doc_name%' || `lastname` LIKE '%$doc_name%'";
		$cquery = "SELECT * FROM `conversations` WHERE `pid` = '".$_SESSION['id']."' GROUP BY did";
 $cresult = mysqli_query($conn, $cquery);
if($cresult){
	while ($crow = mysqli_fetch_assoc($cresult)){
		$query = "SELECT * FROM `doctors` WHERE `did` = '".$crow['did']."'  && `firstname` LIKE '%$doc_name%' || `did` = '".$crow['did']."'  && `lastname` LIKE '%$doc_name%'";
		$result = mysqli_query($conn, $query);
       $did = $crow['did'];
       if($result){
       while($row = mysqli_fetch_assoc($result)){
            ?> 
<div class="alert alert-success mt-3 w-100" role="alert">
<a href="patient_chatscreen.php?did=<?php echo $did; ?>" class="alert-link"><?php echo "Dr. ".$row['firstname']." ".$row['lastname']; ?></a>
</div>

<?php 
}
   }
      }
        }
           } else {

				echo '<div class="row-header"> <h5>Conversations</h5></div>';
				$cquery = "SELECT * FROM `conversations` WHERE `pid` = '".$_SESSION['id']."' GROUP BY did";
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
			  <a href="patient_chatscreen.php?did=<?php echo $did; ?>" class="alert-link"><?php echo "Dr. ".$row['firstname']." ".$row['lastname']; ?></a>
			  </div>
			  
			  <?php 
					  }
					}
				  }
				 } 
	}
}//end of search doc conv


// Search patient username in doctors conversations list
if(isset($_GET['pat_cid'])){
	session_start();
	$pat_name = $_GET['pat_cid'];
 
	if(!empty($pat_name)){
		echo '<div class="row-header"> <h5>'.$pat_name.'</h5></div>';
		// $query = "SELECT * FROM `doctors` WHERE `firstname` LIKE '%$doc_name%' || `lastname` LIKE '%$doc_name%'";
		$cquery = "SELECT * FROM `conversations` WHERE `did` = '".$_SESSION['id']."' GROUP BY pid";
 $cresult = mysqli_query($conn, $cquery);
if($cresult){
	while ($crow = mysqli_fetch_assoc($cresult)){
		$query = "SELECT * FROM `patients` WHERE `pid` = '".$crow['pid']."'  && `firstname` LIKE '%$pat_name%' || `pid` = '".$crow['pid']."'  && `lastname` LIKE '%$pat_name%'";
		$result = mysqli_query($conn, $query);
       $pid = $crow['pid'];
       if($result){
       while($row = mysqli_fetch_assoc($result)){
            ?> 
<div class="alert alert-success mt-3 w-100" role="alert">
<a href="doc_chatscreen.php?pid=<?php echo $pid; ?>" class="alert-link"><?php echo $row['firstname']." ".$row['lastname']; ?></a>
</div>

<?php 
}
   }
      }
        }
           } else {

				echo '<div class="row-header"> <h5>Patients</h5></div>';
				$cquery = "SELECT * FROM `conversations` WHERE `did` = '".$_SESSION['id']."' GROUP BY pid";
				$cresult = mysqli_query($conn, $cquery);
			  if($cresult){
				  while ($crow = mysqli_fetch_assoc($cresult)){
						$query = "SELECT * FROM `patients` WHERE `pid` = '".$crow['pid']."'";
			  
						$result = mysqli_query($conn, $query);
						$pid= $crow['pid'];
						if($result){
						if(mysqli_num_rows($result) >= 1){
							 $row = mysqli_fetch_assoc($result);
							  ?> 
			  
			  <div class="alert alert-success mt-3 w-100" role="alert">
			  <a href="doc_chatscreen.php?pid=<?php echo $pid; ?>" class="alert-link"><?php echo $row['firstname']." ".$row['lastname']; ?></a>
			  </div>
			  
			  <?php 
					  }
					}
				  }
				 } 
	}
}//end of search pat conv

// Search doctor username in doctors conversations list
if(isset($_GET['doc_to_doc_cid'])){
	$doc_name = $_GET['doc_to_doc_cid'];
 
	if(!empty($doc_name)){
		echo '<div class="row-header"> <h5>'.$doc_name.'</h5></div>';
		// $query = "SELECT * FROM `doctors` WHERE `firstname` LIKE '%$doc_name%' || `lastname` LIKE '%$doc_name%'";
		$cquery = "SELECT * FROM `doc_to_doc` WHERE `did_1` = '".$_SESSION['id']."' GROUP BY did_2";
		$cresult = mysqli_query($conn, $cquery);
if($cresult){
	while ($crow = mysqli_fetch_assoc($cresult)){
		$query = "SELECT * FROM `doctors` WHERE `did` = '".$crow['did_2']."'  && `firstname` LIKE '%$doc_name%' || `did` = '".$crow['did_2']."'  && `lastname` LIKE '%$doc_name%'";
		$result = mysqli_query($conn, $query);
       $did_2 = $crow['did_2'];
       if($result){
       while($row = mysqli_fetch_assoc($result)){
            ?> 
<div class="alert alert-success mt-3 w-100" role="alert">
<a href="doc_to_doc_chat.php?did_2=<?php echo $did_2; ?>" class="alert-link"><?php echo "Dr. ".$row['firstname']." ".$row['lastname']; ?></a>
</div>

<?php 
}
   }
      }
        }
           } else {

				echo '<div class="row-header"> <h5>Doctors</h5></div>';
				$cquery = "SELECT * FROM `doc_to_doc` WHERE `did_1` = '".$_SESSION['id']."' GROUP BY did_2";
            $cresult = mysqli_query($conn, $cquery);
            if($cresult){
               while ($crow = mysqli_fetch_assoc($cresult)){
                    $query = "SELECT * FROM `doctors` WHERE `did` = '".$crow['did_2']."'";

                    $result = mysqli_query($conn, $query);
                    $did_2 = $crow['did_2'];
                    if($result){
                    if(mysqli_num_rows($result) >= 1){
                     $row = mysqli_fetch_assoc($result);
            ?> 

<div class="alert alert-success mt-3 w-100" role="alert">
<a href="doc_to_doc_chat.php?did_2=<?php echo $did_2; ?>" class="alert-link"><?php echo "Dr. ".$row['firstname']." ".$row['lastname']; ?></a>
</div>

			  <?php 
					  }
					}
				  }
				 } 
	}
}//end of search doc conv


	?> 