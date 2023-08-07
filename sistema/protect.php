
<?php

if(!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION['codigo'])) {
    header("Location: login.php");
}

?>