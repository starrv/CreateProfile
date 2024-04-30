<?php

    //report errors
    /*ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);*/

    require_once 'app-data-prod.php';
    require_once 'database.php';

    global $domain;

    if(!empty($_POST)){
        if(!empty($_POST['username']) && !empty($_POST['password'])){
            $result=login($_POST['username'],$_POST['password']);
            switch($result){
                case 3:
                    $cookie_options = array (
                        'expires' => time() + 60*60*24*30, 
                        'path' => '/', 
                        'domain' => $domain, 
                        'secure' => true,    
                        'httponly' => true,    
                        'samesite' => 'lax'
                        );
                    setcookie('user',$_POST['username'],$cookie_options);
                    header("Location: /");
                    exit;
                case 1:
                    echo "<p class='error'>The username/password combination is not on file";
                    break;
                case 2:
                    echo "<p class='error'>Something went wrong</p>";
                    break;
            }
        }
        else{
            echo "<p class='error'>Please enter username and password to sign in";
        }
    }
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../css/style.css" type="text/css">
        <link rel="shortcut icon" href="../images/icon.png" type="image/png">
		<script defer type="text/javascript" src="../js/script.js"></script>
	</head>
	<body>
        <header>
            <h1>
                Login
            </h1>
        </header>
        <form method='post'>
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" auto-complete="username">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" autocomplete="password">
            </div>
            <div>
                <input type="submit" id="submit" name="submit">
            </div>
        </form>
        <a href="/signup" id="signup">Sign Up</a>
    </body>
</html>