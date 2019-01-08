<?php
require 'connection/sqlconnect.php';

if(isset($_POST['submit'])){

  if (isset($_POST['firstname']) 
&& isset($_POST['lastname']) 
&& isset($_POST['username']) 
&& isset($_POST['pass1']) 
&& isset($_POST['pass2']) 
&& isset($_POST['gender'])
&& isset($_POST['age'])
&& isset($_POST['genotype'])
&& isset($_POST['blood']) 
&& isset($_POST['contact'])
&& isset($_POST['state'])
&& isset($_POST['city']) 
&& isset($_POST['address'])
&& isset($_POST['security_q'])
&& isset($_POST['answer'])

)
{
  //set variables
  $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
  $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $pass1 = mysqli_real_escape_string($conn, $_POST['pass1']);
  $pass2 = mysqli_real_escape_string($conn, $_POST['pass2']);
  $gender = mysqli_real_escape_string($conn, $_POST['gender']);
  $age = mysqli_real_escape_string($conn, $_POST['age']);
  $genotype = mysqli_real_escape_string($conn, $_POST['genotype']);
  $blood = mysqli_real_escape_string($conn, $_POST['blood']);
  $contact = mysqli_real_escape_string($conn, $_POST['contact']);
  $state = mysqli_real_escape_string($conn, $_POST['state']);
  $city = mysqli_real_escape_string($conn, $_POST['city']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $question = mysqli_real_escape_string($conn, $_POST['security_q']);
  $answer = mysqli_real_escape_string($conn, $_POST['answer']);

  //secure passowrd with hashes
  $password_hash = md5($pass1);
  
  //check for empty optional fields
  if(empty($genotype)){
    $genotype = "NULL";
  }
  if(empty($blood)){
    $blood = "NULL";
  }
  if(empty($contact)){
    $contact = "NULL";
  }
  if(empty($state)){
    $state = "NULL";
  }
  if(empty($city)){
    $city = "NULL";
  }
  if(empty($address)){
    $address = "NULL";
  }

  //check for username availability
  if(!empty($username)){
    $query = "SELECT username FROM doctors WHERE username='$username' UNION SELECT username FROM patients WHERE username='$username'";
     $result = mysqli_query($conn, $query);
  
    if (mysqli_num_rows($result) == 1){
      $username_err ="The username '$username' is not available";
    }else{
      //validate password
         if($pass1 !== $pass2){
         $password_err = "password does not match";
        }else{
        //register
          $query = "INSERT INTO `patients` (`pid`, `firstname`, `lastname`, `username`, `password_hashed`, `gender`, `age_group`, `genotype`, `blood_type`, `contact`, `state`, `city`, `address`, `image_url`, `status`, `security_q`, `answer`) 
          VALUES (NULL,'$firstname', '$lastname', '$username', '$password_hash', '$gender', '$age', '$genotype', '$blood', '$contact', '$state', '$city', '$address', 'nopic', 'Active', '$question', '$answer')";
          if(mysqli_query($conn, $query)){
          header('location: reg_success.php');
          } else {
          echo "registration failed, pls try again later";
          }

       }
    } //end else
}

}
}

include 'registration.php';

?>