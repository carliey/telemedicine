<?php
session_start();
include 'connection/sqlconnect.php';
$id = $_GET['id'];

$delete = "DELETE FROM `med_files` where `id`='{$id}'";
$result = mysqli_query($conn, $delete);
if($result){
   echo "deleted";
} else {
   echo "couldnt run query";
}

header("location: patient_chatscreen.php");

?>