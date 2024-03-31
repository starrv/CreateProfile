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
            <?php
                require_once 'database.php';

                if($_POST){
                    if($_POST['username'] && $_POST['password']){
                        $result=login($_POST['username'],$_POST['password']);
                        switch($result){
                            case 3:
                                $cookie_options = array (
                                    'expires' => time() + 60*60*24*30, 
                                    'path' => '/', 
                                    'domain' => 'localhost', 
                                    'secure' => true,    
                                    'httponly' => true,    
                                    'samesite' => 'lax'
                                    );
                                setcookie('user',$_POST['username'],$cookie_options);
                                header('Location: /CreateProfile');
                                break;
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
        <a href="signup.php" id="signup">Sign Up</a>
    </body>
</html>