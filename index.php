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
		<?php
			function logout(){
				$cookie_options = array (
					'expires' => time() -3600, 
					'path' => '/', 
					'domain' => 'localhost', 
					'secure' => true,    
					'httponly' => true,    
					'samesite' => 'lax'
					);
				setcookie('user','',$cookie_options);
				header('Location: /CreateProfile');
			}
			if(empty($_COOKIE['user'])){
				header("Location: php/login.php");
			}
			if($_POST['logout']){
				logout();
			}
			echo "<p class='logged-in-info'>You are logged in as: ".$_COOKIE['user']."</p>";
		?>
		<header>
			<h1>
				Create your profile picture
			</h1>
		</header>
		<form method="post" enctype="multipart/form-data" action="php/index.php">
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
				<input type="file" id="cover" name="cover" accept="image/png, image/jpeg, image/gif, image/jpg">
			</div>

			<div style="margin-bottom:150px;">
				<label for="caption">
					Caption:
				</label>
				<textarea id="caption" name="caption" cols="25" rows="5"></textarea>
			</div>

			<div>
				<input type="submit" id="create" name="create" value="create">
			</div>
		</form>
		<div id="viewProfilePicturesDiv">
			<button id="viewProfilePictures" onclick="window.open('php/profile-pictures.php')">View Profile Pictures</button>
		</div>
		<form method="post">
			<input type="submit" id="logout" name="logout" value="logout">
		</form>
	</body>
</html>
