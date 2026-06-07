<?php
session_start();
session_destroy();
header("Location: /digital-store/login.php");
exit();
?>