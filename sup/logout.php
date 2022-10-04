<?php
session_start(); 
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 60*60,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
if (isset($_SESSION['hodid'])) {
    unset($_SESSION['hodid']);
}
if (isset($_SESSION['hrid'])) {
    unset($_SESSION['hrid']);
}
session_destroy(); // destroy session
header("location:../index.php"); 
?>

