<?php
session_start();
require_once("lib3.php");

logout();
header("Location: login.php");
exit;

?>