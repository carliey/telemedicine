<?php
  require 'connection/sqlconnect.php';
  
  //check for input fields
  // Processing form data when form is submitted

 if(isset($_POST['submit'])){

   $firstname = $_POST['firstname'];
   $lastname = $_POST['lastname'];
   $username = $_POST['username'];
   $pass1 = $_POST['pass1'];
   $pass2 = $_POST['pass2'];
   $gender = $_POST['gender'];
   $age = $_POST['age'];
   $genotype = $_POST['genotype'];
   $blood = $_POST['blood'];
   $contact = $_POST['contact'];
   $state = $_POST['state'];
   $city = $_POST['city'];
   $address = $_POST['address'];
   
   if(!empty($username)){
      $query = "SELECT username FROM patients WHERE username='$username'";
      $result = mysqli_query($conn, $query);
      
      if($result){
        if (mysqli_num_rows($result) == 1){
           echo "Username not available";
   }
}

 }
}
?>