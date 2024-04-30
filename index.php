<?php

	//report errors
	/*ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);*/

	require_once 'php/app-data-prod.php';

	if(empty($_COOKIE['user'])){
		header("Location: /login");
		exit;
	}

	function logout(){
		global $domain;
		$cookie_options = array (
			'expires' => time() -3600, 
			'path' => '/', 
			'domain' => $domain, 
			'secure' => true,    
			'httponly' => true,    
			'samesite' => 'lax'
			);
		setcookie('user','',$cookie_options);
		header("Location: /login");
		exit;
	}
	if(!empty($_POST['logout'])){
		logout();
	}
	echo "<p class='logged-in-info'>You are logged in as: ".$_COOKIE['user']."</p>";
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="css/style.css" type="text/css">
		<link rel="shortcut icon" href="images/icon.png" type="image/png">
		<script defer type="text/javascript" src="js/script.js"></script>
	</head>
	<body>
		<header>
			<h1>
				Create your profile picture
			</h1>
		</header>
		<form id="createProfilePictureForm" method="post" enctype="multipart/form-data" action="/add-picture">
            <div>
				<label for="fname">
					Enter your first name:
				</label>
				<input type="text" id="fname" name="fname">
			</div>

            <div>
				<label for="lname">
					Enter your last name:
				</label>
				<input type="text" id="lname" name="lname">
			</div>

			<div>
				<label for="selfie">Upload a selfie:</label>
				<input type="file" id="selfie" name="selfie" capture="user" accept="image/*">
			</div>

			<div>
				<label for="cover">
					Upload a cover photo:
				</label>
				<input type="file" id="cover" name="cover" accept="image/png, image/jpeg, image/gif, image/jpg, image/webp">
			</div>

			<div>
				<label for="caption">
					Caption:
				</label>
				<input type="text" id="caption" name="caption">
			</div>

			<div>
				<input type="submit" id="create" name="create" value="create">
			</div>
		</form>
		<div id="viewProfilePicturesDiv">
			<button id="viewProfilePictures" onclick="window.open('/profile-pictures','_self')">View Profile Pictures</button>
		</div>
		<form method="post">
			<input type="submit" id="logout" name="logout" value="logout">
		</form>
	</body>
</html>
