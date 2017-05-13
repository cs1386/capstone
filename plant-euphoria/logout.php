<?php
	
	//logs out and ends session
	session_start();
  $_SESSION = array();
 
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

  if(isset($_SERVER['HTTP_REFERER'])) {
   header('Location: '.$_SERVER['HTTP_REFERER']);  
  } else {
   header('Location: index.php');  
  }
  exit;

  //$_SESSION["user_connected"]
?>