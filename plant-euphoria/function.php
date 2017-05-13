<?php
    
    define("HOST", "sql2.njit.edu");
    define("USER", "cs338");
    define("PASS", "ZSzJT9idz");
    define("DATABASE", "cs338");
    
    define("api_key", "96779d9e9d74c0bd87eeb7695f2a60de");	// flickr api key

    function connect(){

        $link = mysqli_connect(HOST, USER, PASS, DATABASE);

        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        else
            return $link;        
    }

    function check_user($provider, $providerID, $displayName) {

        $link = connect();
        $sql = "SELECT * FROM users1 WHERE providerID='$providerID'";
        $result = mysqli_query($link, $sql);        

        if(mysqli_num_rows($result)>=1){
          //echo "<br>User exists";
          return true;
          }
          else{
            $sql = "INSERT INTO users1 (userID, providerName, providerID, displayName) VALUES (NULL, '$provider', '$providerID', '$displayName')";
            $result = mysqli_query($link, $sql);
            //echo "New record created successfully";
            }
        mysqli_close($link);
    }

    function get_user($displayName){
        
        $link = connect();
        $sql = "SELECT displayName FROM users1 WHERE displayName='$displayName'";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);
        
        return $row["displayName"];
        mysqli_close($link);        
        
    }

  	function get_photo($tags) {
  		
      // request photo from flickr by sending common and scientific name and get a json response 
      
  		$tag = rawurlencode($tags);
  		$perPage = 1;
  
  		$url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search';
  		$url.= '&api_key='. api_key;
  		$url.= '&tag=' . $tag;
  		$url.= '&text=' . $tag;
  		$url.= '&sort=relevance';
  		$url.= '&safe_search=1';
  		$url.= '&"machine_tags=>*:title="' . $tag;
  		$url.= '&extras=owner_name';
  		$url.= '&per_page='.$perPage;
  		$url.= '&format=json';
  		$url.= '&nojsoncallback=1';	 
  
  		$response = json_decode(file_get_contents($url));
  		$photo_array = $response->photos->photo;
  		 
  		 /*	show results
  		 print ("<pre>");
  		 print_r($response);
  		 print ("</pre>");
  		*/
  
  		foreach($photo_array as $single_photo){
  		 
  			$farm_id = $single_photo->farm;
  			$server_id = $single_photo->server;
  			$photo_id = $single_photo->id;
  			$secret_id = $single_photo->secret;
  			$photo_owner = $single_photo->ownername; 
  			$title = $single_photo->title;
  			 
  			$photo_url = 'https://farm' . $farm_id . '.staticflickr.com/' . $server_id . '/' . $photo_id . '_' . $secret_id . '.' . 'jpg';			 
  
  		}		
  		return $photo_url;
  	}

?>