<?php
session_start();


session_destroy();
header('Location: ../adminMobile/login.php');

?>
