<?php

session_start();

include 'connection/sqlconnect.php';

//beginning of admin select
 //get patient by status
 if(isset($_GET['p_status'])){
    $selected = $_GET['p_status'];

    if(!empty($selected)){ 
   
      $result_type = $selected;
      echo '<div class="row-header"> <h5>'.$selected.'</h5></div>';

      $data = "SELECT * FROM `patients` WHERE `status`"."='$selected' ";

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
 <img class="card-img-top img-flud dp" src="<?php if(isset($default)){echo $img_src;}else{ echo $img_src;} ?>" alt="Card image cap" style="height:11em;">
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
  <img class="card-img-top img-flud dp dp" src="<?php if(isset($default)){echo $img_src;}else{ echo $img_src;} ?>" alt="Card image cap" style="height:11em;">
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
<?php }} } }


//get patient by state

 if(isset($_GET['p_state'])){
    $selected = $_GET['p_state'];

    if(!empty($selected)){ 
   
      $result_type = $selected;
      echo '<div class="row-header"> <h5>'.$selected.'</h5></div>';

      $data = "SELECT * FROM `patients` WHERE `state`"."='$selected' ";

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
 <img class="card-img-top img-flud dp dp" src="<?php if(isset($default)){echo $img_src;}else{ echo $img_src;} ?>" alt="Card image cap" style="height:11em;">
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
  <img class="card-img-top img-flud dp dp" src="<?php if(isset($default)){echo $img_src;}else{ echo $img_src;} ?>" alt="Card image cap" style="height:11em;">
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
}//end of select by status


//Select Doctor By Status

if(isset($_GET['d_status'])){
    $selected = $_GET['d_status'];

   if(!empty($selected)){

      $result_type = $selected;
      echo '<div class="row-header"> <h5>'.$selected.'</h5></div>';

      $dquery = "SELECT * FROM `doctors` WHERE `status`"."='$selected' ";

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
							<img class="card-img-top img-flud dp dp" src="<?php if(isset($default)){echo $img_src;}else{ echo $img_src;} ?>" alt="Card image cap" style="height:11em;">
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
				 <img class="card-img-top img-flud dp dp" src="<?php if(isset($default)){echo $img_src;}else{ echo $img_src;} ?>" alt="Card image cap" style="height:11em;">
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
    <?php }}}
    }// end of get doctor by status

    //Select Doctor By Speciality

if(isset($_GET['d_speciality'])){
   $selected = $_GET['d_speciality'];

  if(!empty($selected)){

     $result_type = $selected;
     echo '<div class="row-header"> <h5>'.$selected.'</h5></div>';

     $dquery = "SELECT * FROM `doctors` WHERE `speciality`"."='$selected' ";

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
                    <img class="card-img-top img-flud dp dp" src="<?php if(isset($default)){echo $img_src;}else{ echo $img_src;} ?>" alt="Card image cap" style="height:11em;">
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
   <?php }}}
   }// end of get doctor by Speciality

   
if(isset($_GET['d_state'])){
   $selected = $_GET['d_state'];

  if(!empty($selected)){

     $result_type = $selected;
     echo '<div class="row-header"> <h5>'.$selected.'</h5></div>';

     $dquery = "SELECT * FROM `doctors` WHERE `state`"."='$selected' ";

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
   <?php }}}
   }// end of get doctor by state
   // end of admin select doctor



   // beginning of patient and doctor select doctor
    //Select Doctor By Speciality

if(isset($_GET['speciality'])){
   $selected = $_GET['speciality'];

  if(!empty($selected)){

     $result_type = $selected;
     echo '<div class="row-header"> <h5>'.$selected.'s</h5></div>';

     $dquery = "SELECT * FROM `doctors` WHERE `speciality`"."='$selected' ";

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
             <h6 class="card-title"><?php echo $drow['username'] ?><span style="float:right;"> first ID: <?php echo $drow['did'] ?> </span> </h6> 
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
       <?php }} }} else {
          
      echo '<div class="row-header"> <h5>All doctors</h5></div>';

     $dquery = " SELECT * FROM `doctors`";

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

  <div class="col-md-4 mt-2 mb-2">
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
         <a href="patient_chatscreen.php?did=<?php echo $drow['did']; ?>" class="card-link btn-sm btn-success"> Send Message</a>
          <a href="patient_report_doc.php?did=<?php echo $drow['did']; ?>" class="card-link btn-sm btn-success">Report</a>
       </div>
     </div>

    </div>
    <?php }} }}
   }// end of get speciality
   ?>
   

<?php
// beginning of doctor   select doctor
    //Select Doctor By Speciality

if(isset($_GET['dd_speciality'])){
   $selected = $_GET['dd_speciality'];

  if(!empty($selected)){

     $result_type = $selected;
     echo '<div class="row-header"> <h5>'.$selected.'s</h5></div>';

     $dquery = "SELECT * FROM `doctors` WHERE `speciality`"."='$selected' ";

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
      }} }} else {
          
      echo '<div class="row-header"> <h5>All doctors</h5></div>';

     $dquery = " SELECT * FROM `doctors`";

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
  }} }}
   }// end of get speciality
   ?>
   




<script></script>