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
    // share buttons using sharethis
    <script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5915067c889e1c0011156239&product=sticky-share-buttons"></script>

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


    <div class="article-list">
        <div class="container">
            <div class="intro">
                <h2 class="text-center" style="padding:-1px; margin:10px;">
					<?php
                        // pagination used to display each plant
                                 
                        $link = connect();                    
                        $rpp = 1;            // plants per page
                        
                        // check if page is set
                        isset($_GET['page']) ? $page = $_GET['page'] : $page = 1;
                    
                        // check for page 1
                        if($page > 1) {
                            $start = ($page * $rpp) - $rpp;
                        }
                        else {
                            $start = 0;
                        }
                        
                        $sql = "SELECT COUNT(*) as num FROM PLANTS";
                        $result = mysqli_query($link, $sql);
                        $numRows = mysqli_num_rows($result);
                        $totalPages = ($numRows / $rpp);
                        mysqli_free_result($result);
                    
						$sql = "SELECT `ID`, `Common Name`, `Scientific Name`, `Family`, `Category`, `State Distribution` FROM PLANTS ORDER BY `ID` LIMIT $start, $rpp";
						$result = mysqli_query($link, $sql);
						if(mysqli_num_rows($result)>0){
							$row = mysqli_fetch_array($result);
                                                 
              // plant name and ID for use wth Flickr and Disqus                                                 
							$plant_name = $row['Scientific Name'];
							$plant_ID = $row['ID'];
                            
							echo ucfirst($plant_name);
						}
					?>
				        </h2>                
            </div> 
        

    <div class="container-fluid" >
        <div class="row">

            <div class="col-md-3 "></div>

            <div class="col-md-6 col-xs-12"> <!-- start table -->
                
                <table class='table table-striped table-bordered'>
                    <tr>
                    
                        <?php
                        //$sql = "SELECT `Common Name`, `Scientific Name`, `Family`, `Category`, `State Distribution` FROM PLANTS LIMIT 1";

                        if($result = mysqli_query($link, $sql)){
                            if(mysqli_num_rows($result)>0){
                                
                                $row = mysqli_fetch_array($result);
                                $tags = $row['Scientific Name'] . ", " . $row['Common Name'];
                                                                
                                echo "<th rowspan='5' >";
                                $img = get_photo($tags);
                                if (isset($img)){                                    
                                    echo "<img class='mx-auto img-rounded' style='max-height=400px' src='" . $img . "' width=100%>";
                                }
                                else {
                                    echo "<img class=' mx-auto img-rounded' style='max-height=250px' src='assets/img/not_available.jpg' width=100%";
                                }
                                echo "</th>";
                                mysqli_data_seek($result, 0);
                                while($row = mysqli_fetch_array($result)){
                                        echo "<th>Common Name</th>";
                                        echo "<td>" . $row['Common Name'] . "</td>";
                                    echo "</tr>";                        
                                    echo "<tr>";
                                        echo "<th>Scientific Name</th>";
                                        echo "<td>" . $row['Scientific Name'] . "</td>";
                                    echo "</tr>";
                                    echo "<tr>";
                                        echo "<th>Family</th>";
                                        echo "<td>" . $row['Family'] . "</td>";
                                    echo "</tr>";
                                    echo "<tr>";
                                        echo "<th>Category</th>";
                                        echo "<td>" . $row['Category'] . "</td>";
                                    echo "</tr>";
                                    echo "<tr>";
                                        echo "<th>State Distribution</th>";
                                        echo "<td>" . $row['State Distribution'] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                                mysqli_free_result($result);
                            } else{
                                echo "No records matching your query were found.";
                            }
                        } else{
                            echo "ERROR: Unable to execute $sql. " . mysqli_error($link);
                        }
                    ?>
                </div>  <!-- end table -->
            </div>
            
                    <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6 text-center">

                    <div class="row">                        
                        
                        <?php
                        
                            // previous and next button                                   
                            echo "<div class='col-md-6 col-xs-6'>";
                            echo "<div class='btn-group'>";
                            
                            // if page one, button is inactive
                            if($page==1){
                                echo "<a class='btn btn-primary'  role='button'>";
                                echo "<em class='glyphicon'></em> Prev </a>";
                            }
                            else
                            {
                                echo "<a class='btn btn-primary' href='{$_SERVER['PHP_SELF']}?plant=" . ($plant_ID - 1) . "&page=" . ($page - 1) . "' role='button'>";
                                echo "<em class='glyphicon'></em> Prev </a>";                                
                            }
                            echo "</div></div>";
                            echo "<div class='col-md-6 col-xs-6'>";
                            echo "<div class='btn-group'>";
                            echo "<a class='btn btn-primary' href='{$_SERVER['PHP_SELF']}?plant=" . ($plant_ID + 1) . "&page=" . ($page + 1) . "' role='button'>";
                            echo "<em class='glyphicon'></em> Next </a>";
                            echo "</div></div>";
                            
                            $address = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                           
                        ?>
                    </div>
                    
                    </div>                        
                    <div class="col-md-3"></div>
                    </div>
            
                    
            </div>

            <div class="col-md-3"></div>

        </div>
        </div>    
 

     
        <div class="container-fluid">

            <div class="row">  		
                <div class="col-md-2 hidden-xs "></div>

                <div class="col-md-8 col-xs-12">	
                    <div id="disqus_thread"></div>
                </div>

                <div class="col-md-2 hidden-xs "></div>  
            </div>
        </div>        
        
    </div>
			
      <!-- 
        Disqus comment section. New thread for every plant. 
      -->
            
			<script>

			  var disqus_config = function () {
        this.page.url = this.page.url = "<?php echo $address; ?>";
	   	  this.page.identifier = "<?php echo $address; ?>"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
			//this.page.title = "<?php echo '?plant='. $plant_ID . '&page=' . $page; ?>";
			
			};
			
			(function() { // DO NOT EDIT BELOW THIS LINE
			var d = document, s = d.createElement('script');
			s.src = 'https://plant-euphoria.disqus.com/embed.js';
			s.setAttribute('data-timestamp', +new Date());
			(d.head || d.body).appendChild(s);
			})();
			</script>
			<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    
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
    
    <section class="testimonials" style="padding:-1px;margin: 0px;">    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
</body>

</html>