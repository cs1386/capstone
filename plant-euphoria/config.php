<?php

  /*
    config file for facebook and google login api
    id and secret key provided by facebook and google
  */
return
		array(
			"base_url" => "https://web.njit.edu/~cs338/capstone/plant-euphoria/",
			"providers" => array(
				// openid providers
				"OpenID" => array(
					"enabled" => true
				),
				"Google" => array(
					"enabled" => true,
					"keys" => array("id" => "384927127862-4al5q8eoqfruo466llimo7vdsvtc0t67.apps.googleusercontent.com", "secret" => "wVVqRbHYKF1WybeEH3V3SMU7"),
					"scope" => "profile email"    // information request from google
				),
				"Facebook" => array(
					"enabled" => true,
					"keys" => array("id" => "260261697777495", "secret" => "06ae0516021480a9e10207c2f6f628fe"),
					"scope" => "public_profile, email",  // information requested from facebook
					"display" => "iframe",
					"trustForwarded" => false,
				)
			),
			// If you want to enable logging, set 'debug_mode' to true.
			// You can also set it to
			// - "error" To log only error messages. Useful in production
			// - "info" To log info and error messages (ignore debug messages)
			"debug_mode" => false,
			// Path to file writable by the web server. Required if 'debug_mode' is not false
			"debug_file" => "debug.txt",
);

?>