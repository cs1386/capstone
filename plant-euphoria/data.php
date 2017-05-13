<?php

ini_set('date.timezone', 'America/New_York');
require_once( "Hybrid/Auth.php" );
require_once( "Hybrid/Endpoint.php" );
require_once('../vendor/autoload.php');

if (isset($_REQUEST['hauth_start']) || isset($_REQUEST['hauth_done'])) {
    Hybrid_Endpoint::process();
}
session_start();
include ("function.php")
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

<style>
    
	div.sglspread {
		width: 30%;
		height: auto;
    margin-left: auto;
   margin-right: auto;	
    }

    table td, th {
	  border = 1px black;
      //border-collapse: collapse;
    }
    th, td {
      padding: 5px;
      text-align: left;
    }
	
</style>

<br><br>
  <h2 class="text-center">Plant Database</h2><br><br><br>
<div class="article-list">    
    
<div class="sglspread">             


			
			<?php
        $link = connect();
				$sql = "SELECT * FROM PLANTS LIMIT 100";
    
                if($result = mysqli_query($link, $sql)){
                    if(mysqli_num_rows($result)>0){
                        echo "<table name='data1'>";                        
                            echo "<tr>";
                                //echo "<th>ID</th>";
                                echo "<th>Symbol Key</th>";
                                echo "<th>Scientific Name</th>";
                                echo "<th>Common Name</th>";
                                echo "<th>Family</th>";
                                echo "<th>Category</th>";
                                /*echo "<th>Division</th>";
                                echo "<th>US Nativity</th>";
                                echo "<th>US/NA Plant</th>";
                                echo "<th>State Distribution</th>";
                                echo "<th>Growth Habit</th>";
                                echo "<th>Duration</th>";
                                echo "<th>XGenus</th>";
                                echo "<th>Genus</th>";
                                echo "<th>XSpecies</th>";
                                echo "<th>Species</th>";
                                echo "<th>Ssp</th>";
                                echo "<th>Subspecies</th>";
                                echo "<th>Var</th>";
                                echo "<th>Variety</th>";
                                echo "<th>Forma</th>";
                                echo "<th>Genera Author</th>";
                                echo "<th>Binomial Author</th>";
                                echo "<th>Trinomial Author</th>";
                                echo "<th>Quadranomial Author</th>";
                                echo "<th>Federal Noxious Status</th>";
                                echo "<th>Federal Noxious Common Name</th>";
                                echo "<th>State Noxious Status</th>";
                                echo "<th>State Noxious Common Name</th>";
                                echo "<th>PLANTS Invasive Status</th>";
                                echo "<th>Federal T/E Status</th>";
                                echo "<th>Federal T/E Common Name</th>";
                                echo "<th>State T/E Status</th>";
                                echo "<th>State T/E Common Name</th>";
                                echo "<th>National Wetland Indicator Status</th>";
                                echo "<th>Characteristics Data</th>";*/
                        while($row = mysqli_fetch_array($result)){
                            echo "</tr>";                        
                            echo "<tr>";
                                //echo "<td>" . $row['ID'] . "</td>";
                                echo "<td>" . $row['Symbol Key'] . "</td>";
                                echo "<td>" . $row['Scientific Name'] . "</td>";
                                echo "<td>" . $row['Common Name'] . "</td>";
                                echo "<td>" . $row['Family'] . "</td>";
                                echo "<td>" . $row['Category'] . "</td>";
                                /*echo "<td>" . $row['Division'] . "</td>";
                                echo "<td>" . $row['US Nativity'] . "</td>";
                                echo "<td>" . $row['US/NA Plant'] . "</td>";
                                echo "<td>" . $row['State Distribution'] . "</td>";
                                echo "<td>" . $row['Growth Habit'] . "</td>";
                								echo "<td>" . $row['XGenus'] . "</td>";
                								echo "<td>" . $row['Genus'] . "</td>";
                								echo "<td>" . $row['XSpecies'] . "</td>";
                								echo "<td>" . $row['Species'] . "</td>";
                								echo "<td>" . $row['Ssp'] . "</td>";
                								echo "<td>" . $row['Subspecies'] . "</td>";
                								echo "<td>" . $row['Var'] . "</td>";
                								echo "<td>" . $row['Variety'] . "</td>";
                								echo "<td>" . $row['Forma'] . "</td>";
                								echo "<td>" . $row['Genera Author'] . "</td>";
                								echo "<td>" . $row['Binomial Author'] . "</td>";
                								echo "<td>" . $row['Trinomial Author'] . "</td>";
                								echo "<td>" . $row['Quadranomial Author'] . "</td>";
                								echo "<td>" . $row['Federal Noxious Status'] . "</td>";
                								echo "<td>" . $row['Federal Noxious Common Name'] . "</td>";
                								echo "<td>" . $row['PLANTS Invasive Status'] . "</td>";
                								echo "<td>" . $row['Federal T/E Status'] . "</td>";
                								echo "<td>" . $row['Federal T/E Common Name'] . "</td>";
                								echo "<td>" . $row['State T/E Status'] . "</td>";
                								echo "<td>" . $row['State T/E Common Name'] . "</td>";
                								echo "<td>" . $row['National Wetland Indicator Status'] . "</td>";
                								echo "<td>" . $row['Characteristics Data'] . "</td>";*/
                            echo "</tr>";
                            
                        }
                        echo "</table>";
                        // release result
                        mysqli_free_result($result);
                    } else{
                        echo "No records matching your query were found.";
                    }
                } else{
                    echo "ERROR: Unable to execute $sql. " . mysqli_error($link);
                }
        mysqli_close($link);
			?>
			

        </div>        
    </div>
</div></div>
    <br><br>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        
</body>

</html>