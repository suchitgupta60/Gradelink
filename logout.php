<?php 
include "connect.php"; 
$_SESSION['blossomAdmin']="";
session_destroy();
header("location:index.php");

?>