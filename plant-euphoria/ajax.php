<?php
	
	include("function.php");
	
	extract($_POST);
	$user_ip = $_SERVER['REMOTE_ADDR'];
	link = connect();

	// check if the user has clicked on  like or dislike	0 = false, 1 = true
		$dislike_sql = "SELECT COUNT(*) as num FROM likes WHERE ip = '" .$user_ip . "' and plantID = '" . $plantID . "' and dislike = 1";
		$dislike_count = mysqli_fetch_array(mysqli_query($link, $dislike_sql));
		if (!$dislike_count) {
                            printf("Error: %s\n", mysqli_error($link));
                            exit();
                        }
		$dislike_count = $dislike_count['num'];

		$like_sql = "SELECT COUNT(*) as num FROM likes WHERE ip = '" . $user_ip . "' and plantID = '" . $plantID . "' and likes = 1";
        $like_count = mysqli_fetch_array(mysqli_query($link, $like_sql));
		if (!$like_count) {
                            printf("Error: %s\n", mysqli_error($link));
                            exit();
                        }
		$like_count = $like_count['num'];
	
	//if user clicks on like
	if($act == 'like'): 
		if(($like_count == 0) && ($dislike_count == 0)){
			$sql = "INSERT INTO likes (plantID, ip, likes) VALUES ('" . $plantID . "', '" . $user_ip . "', 1)";
			mysqli_query($link, $sql);

		}
		if($dislike_count == 1){
			$sql = "UPDATE likes SET dislike = 0 WHERE plantID = " . $plantID . " and ip = " . $user_ip;
			mysqli_query($link, $sql);
		}

	endif;
	
	//if user clicks on dislike
	if($act == 'dislike'):
		if(($like_count == 0) && ($dislike_count == 0)){
			mysqli_query($link, 'INSERT INTO likes (plantID, ip, dislike) VALUES ("'.$plantID.'", "'.$user_ip.'", "1")');
		}
		if($like_count == 1){
			mysqli_query($link, "UPDATE likes SET like = 0 WHERE plantID = '" . $plantID . "' and ip = '" . $user_ip . "'");
		}

	endif;
?>