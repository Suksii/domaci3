<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "library_db");
$_SESSION = [];
session_unset();
session_destroy();
header("Location: login.php");
?>