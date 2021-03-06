<?php

ini_set('date.timezone', 'America/New_York');
require_once( "Hybrid/Auth.php" );
require_once( "Hybrid/Endpoint.php" );
require_once('../vendor/autoload.php');

if (isset($_REQUEST['hauth_start']) || isset($_REQUEST['hauth_done'])) {
    Hybrid_Endpoint::process();
}
session_start();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plants Real Home page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/lumen/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,400italic">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <link rel="stylesheet" type="text/css" href="css/zocial.css" />
</head>

<body>
	<div>
        <nav class="navbar navbar-inverse navigation-clean">
            <div class="container">
                <div class="navbar-header"><a class="navbar-brand navbar-link" href="#"><strong>Plant Euphoria</strong></a>
                    <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </div>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav navbar-right">
                                            <li role="presentation"><a href="index.php">Home</a></li>
                        <li role="presentation"><a href="display.php">Plants</a></li>
                        <li role="presentation"><a href="data.php">Database</a></li>
                        <li role="presentation"><a href="search.php">Search</a></li>
                        
                        <?php                    
                            if(isset($_SESSION["user_connected"])){
                                
                                echo "<li class='dropdown'><a class='dropdown-toggle' data-toggle='dropdown' aria-expanded='false' href='#'>" . $_SESSION['user_connected'] . "<span class='caret'></span></a>";
                                echo "<ul class='dropdown-menu' role='menu'>";
                                echo "<li role='presentation'><a href='#'>Preferences</a></li>";
                                echo "<li role='presentation'><a href='logout.php'>Log out</a></li>
                                </ul>
                                </li>";
                            }
                            else{
                                echo "<li class='dropdown'><a class='dropdown-toggle' data-toggle='dropdown' aria-expanded='false' href='#'>Sign In<span class='caret'></span></a>
                                <ul class='dropdown-menu' role='menu'>
                                <li role='presentation'><a href='login.php?provider=facebook'>Facebook</a></li>
                                <li role='presentation'><a href='login.php?provider=google'>Google</a></li>
                                </ul>
                                </li>";
                            }                
                        ?>
                        
                    </ul>
                </div>
            </div>
        </nav>
    </div>
  <div class="footer-basic">
          <footer>
              <ul class="list-inline">
                  <li><a href="index.php">Home</a></li>
                  <li><a href="#">Services</a></li>
                  <li><a href="#">About</a></li>
                  <li><a href="#">Terms</a></li>
                  <li><a href="#">Privacy Policy</a></li>
              </ul>
              <p class="copyright">Plant Euphoria</p>
          </footer>
      </div>
      <section class="testimonials" style="padding:-1px;margin:161px;">
         
          <h2 class="text-center"></h2></section>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
</body>

</html>