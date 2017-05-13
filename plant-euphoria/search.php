<?php

ini_set('date.timezone', 'America/New_York');
require_once( "Hybrid/Auth.php" );
require_once( "Hybrid/Endpoint.php" );
require_once('../vendor/autoload.php');

if (isset($_REQUEST['hauth_start']) || isset($_REQUEST['hauth_done'])) {
    Hybrid_Endpoint::process();
}
session_start();
include ("function.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/lumen/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,400italic">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <link rel="stylesheet" href="assets/css/pagination.css">
</head>

<body style="background-image:url(&quot;none&quot;);">
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
                                echo "<li role='presentation'><a href='pref.php'>Preferences</a></li>";
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
                <h1></h1>
                <h2 class="text-center" style="margin:0px;margin-top:20px;color:rgb(180,42,166);">Plant Search</h2>
                <p class="text-center" style="font-size:27px;color:rgb(242,22,233);"></p>
            </div> 
        

        <div class="container-fluid">
            <div class="row">

                <div class="col-md-2 hidden-xs"></div>

                <div class="col-md-8 col-xs-12 item">

                    <form action="search.php" method="get">

                    <div class="input-group">
                        <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="plant" placeholder="Enter a plant common or scientific name">
                        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary" style="background-color:rgb(201,16,149)">Search</button>
                        </span>
                    </div>  
                    </form>
                
                <br>

                    <?php
                        
                        $adjacents = 2;
                        
                        if(isset($_GET['plant'])) {
                                
                            $link = connect();
                                // search query must begin with a capital or lowercase
                                if(preg_match("/^[A-Za-z]+/", $_GET['plant'])) {
                                                                 
                                    $plant = mysqli_real_escape_string($link, $_GET['plant']); 
                                    
                                    $sql = "SELECT COUNT(*) as num FROM PLANTS WHERE `Common Name` LIKE '" . $plant .  "%' OR `Scientific Name` LIKE '" . $plant . "%'";
                                    
                                    if(!$result = mysqli_query($link, $sql)){

                                        printf("Error: %s\n", mysqli_error($link));
                                    }
                                    
                                    /* Digg-Style pagination used for results
                                     http://www.strangerstudios.com/sandbox/pagination/diggstyle.php
                                    */

                                    $total_pages = mysqli_fetch_array(mysqli_query($link, $sql));
                                    $total_pages = $total_pages['num'];

                                    $targetpage = "search.php?plant={$plant}";
                                    $limit = 20;
                                    isset($_GET['page']) ? $page = $_GET['page'] : $page = 0;

                                    if($page)
                                        $start = ($page - 1) * $limit; 			//first item to display on page
                                    else
                                        $start = 0;
                                
                                $sql = "SELECT `ID`, `Common Name`, `Scientific Name`, `Category`, `State Distribution`, `Genus`, `Species` FROM PLANTS WHERE `Common Name` LIKE '" . $plant .  "%' OR `Scientific Name` LIKE '" . $plant . "%' LIMIT $start, $limit";
                                
                                $result = mysqli_query($link, $sql);                             
                                mysqli_data_seek($result, 0);
                            
                                if ($page == 0) {
                                    $page = 1;					
                                }                                            
                                $prev = $page - 1;
                                $next = $page + 1;
                                $lastpage = ceil($total_pages/$limit);		// last page is = total pages / items per page, rounded up.
                                $lpm1 = $lastpage - 1;

                                $pagination = "";          // empty pagination variable. append to variable depending on page.
                                    
                                        if($lastpage > 1)
                                        {
                                            $pagination .= "<div class=\"pagination\">";
                                            //previous button
                                            if ($page > 1) 
                                                $pagination.= "<a href=\"$targetpage&page=$prev\">� previous</a>";
                                            else
                                                $pagination.= "<span class=\"disabled\">� previous</span>";	

                                            if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
                                            {	
                                                for ($counter = 1; $counter <= $lastpage; $counter++)
                                                {
                                                    if ($counter == $page)
                                                        $pagination.= "<span class=\"current\">$counter</span>";
                                                    else
                                                        $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
                                                }
                                            }
                                            elseif($lastpage > 5 + ($adjacents * 2))
                                            {
                                                // close to beginning of results, only hide later pages
                                                if($page < 1 + ($adjacents * 2))		
                                                {
                                                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                                                    {
                                                        if ($counter == $page)
                                                            $pagination.= "<span class=\"current\">$counter</span>";
                                                        else
                                                            $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
                                                    }
                                                    $pagination.= "...";
                                                    $pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                                                    $pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
                                                }
                                                // in middle section of results, hide some front and some back
                                                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                                                {
                                                    $pagination.= "<a href=\"$targetpage&page=1\">1</a>";
                                                    $pagination.= "<a href=\"$targetpage&page=2\">2</a>";
                                                    $pagination.= "...";
                                                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                                                    {
                                                        if ($counter == $page)
                                                            $pagination.= "<span class=\"current\">$counter</span>";
                                                        else
                                                            $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
                                                    }
                                                    $pagination.= "...";
                                                    $pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                                                    $pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
                                                }
                                                // close to end of results, only hide early pages
                                                else
                                                {
                                                    $pagination.= "<a href=\"$targetpage&page=1\">1</a>";
                                                    $pagination.= "<a href=\"$targetpage&page=2\">2</a>";
                                                    $pagination.= "...";
                                                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                                                    {
                                                        if ($counter == $page)
                                                            $pagination.= "<span class=\"current\">$counter</span>";
                                                        else
                                                            $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
                                                    }
                                                }
                                            }

                                            // next button
                                            if ($page < $counter - 1) 
                                                $pagination.= "<a href=\"$targetpage&page=$next\">next �</a>";
                                            else
                                                $pagination.= "<span class=\"disabled\">next �</span>";
                                            $pagination.= "</div>\n";		
                                        }
                                    
                                        if(mysqli_num_rows($result)>0){
                                            
                                            echo "<h3>Search results for " . $plant . "</h3><br>";

                                            echo "<table class='table table-striped table-responsive'>";
                                                echo "<tr>";
                                                    //echo "<th>ID</th>";
                                                    echo "<th>Common Name</th>";
                                                    echo "<th>Scientific Name</th>";
                                                    echo "<th>Category</th>";
                                                    echo "<th>State Distribution</th>";
                                                    echo "<th>Genus</th>";
                                                    echo "<th>Species</th>";
                                                echo "</tr>";

                                            while($row = mysqli_fetch_array($result)){
                                                echo "<tr>";
                                                    //echo "<td>" . $row['ID'] . "</td>";
                                                    echo "<td>" . $row['Common Name'] . "</td>";
                                                    echo "<td>" . $row['Scientific Name'] . "</td>";
                                                    echo "<td>" . $row['Category'] . "</td>";
                                                    echo "<td>" . $row['State Distribution'] . "</td>";
                                                    echo "<td>" . $row['Genus'] . "</td>";
                                                    echo "<td>" . $row['Species'] . "</td>";
                                                echo "</tr>";                                            
                                            }
                                        echo "</table>";                                           
                                        echo $pagination;  // display pagination after table                                        
                                        }

                                    else {
                                    echo "<p>No results.</p>";
                                }
                                }
                        }
                        
                ?>

                </div>

                <div class="col-md-2 hidden-xs"></div>

            </div>            
            
        </div>

        </div>        
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
    </section>
</body>

</html>