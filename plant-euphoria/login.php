<?php 

  /*
    HybridAuth open source library used for social media login
    https://hybridauth.github.io/hybridauth/
  */

	include("function.php");    
    session_start();
    
    if(isset($_GET['provider'])){
        $provider = $_GET['provider'];
    }

    try{
        
        if ($provider == "facebook"){

        // change the following paths if necessary
        $config   = dirname(__FILE__) . '/config.php';
        require_once( "./Hybrid/Auth.php" );
        require_once('../vendor/autoload.php');

        $hybridauth = new Hybrid_Auth( $config );
        $facebook = $hybridauth->authenticate( $provider );
        $facebook_user_profile = $facebook->getUserProfile();
        $providerID = $facebook_user_profile->identifier;
        $displayName = $facebook_user_profile->displayName;
            
        // insert user into database table after login
        check_user($provider, $providerID, $displayName);            
        $_SESSION["user_connected"] = get_user($displayName);

        //echo "Logging out..";
        $facebook->logout();
            
        header("Location: https://web.njit.edu/~cs338/capstone/plant-euphoria/");
        }
        
        elseif ($provider == "google"){

        // change the following paths if necessary
        $config   = dirname(__FILE__) . '/config.php';
        require_once( "./Hybrid/Auth.php" );

        $hybridauth = new Hybrid_Auth( $config );
        $google = $hybridauth->authenticate( $provider );
        $google_user_profile = $google->getUserProfile();
        $providerID = $google_user_profile->identifier;
        $displayName = $google_user_profile->displayName;
        
        // insert user into database table after login
        check_user($provider, $providerID, $displayName);
        $_SESSION["user_connected"] = get_user($displayName);

        //echo "Logging out..";
        $google->logout();
        
        header("Location: https://web.njit.edu/~cs338/capstone/plant-euphoria/");
        }
    }
        catch( Exception $e ){

        switch( $e->getCode() ){
          case 0 : echo "Unspecified error."; break;
          case 1 : echo "Hybriauth configuration error."; break;
          case 2 : echo "Provider not properly configured."; break;
          case 3 : echo "Unknown or disabled provider."; break;
          case 4 : echo "Missing provider application credentials."; break;
          case 5 : echo "Authentification failed. "
                      . "The user has canceled the authentication or the provider refused the connection.";
                   break;
          case 6 : echo "User profile request failed. Most likely the user is not connected "
                      . "to the provider and he should authenticate again.";
                   $facebook->logout();
                   $google->logout();
                   break;
          case 7 : echo "User not connected to the provider.";
                   $facebook->logout();
                   $google->logout();
                   break;
          case 8 : echo "Provider does not support this feature."; break;
        }

        // Error message
        echo "<br /><br /><b>Original error message:</b> " . $e->getMessage();
        }

?>