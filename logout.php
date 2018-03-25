<?php
session_start();
$_SESSION["userid"]=NULL;
$_SESSION["user"]=NULL;
session_destroy();
header('location:LOGIN.php');
?>