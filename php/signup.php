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
                Sign Up
            </h1>
        </header>
        <form method='post'>
            <?php
               require_once 'database.php';

                if($_POST){
                    if($_POST['username'] && $_POST['password'] && $_POST['confirmPassword']){
                        $result=signup($_POST['username'],$_POST['password'],$_POST['confirmPassword']);
                        switch($result){
                            case 4 : 
                                echo "<p class='success'>Account created</p>";
                                break;
                            case 1:
                                echo "<p class='error'>Passwords do not match</p>";
                                break;
                            case 2:
                                echo "<p class='error'>Username is already on file.  If you have forgotten your password, please contact IT Support.</p>";
                                break;
                            case 3:
                                echo "<p class='error'>Something went wrong</p>";
                                break;
                        }
                    }
                    else{
                        echo "<p class='error'>Please enter username and password and confirm password to sign in";
                    }
                }
            ?>
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" auto-complete="username">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" autocomplete="new-password">
            </div>
            <div>
                <label for="confirmPassword">Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" autocomplete="new-password">
            </div>
            <div>
                <input type="submit" id="submit" name="submit">
            </div>
        </form>
        <a href="login.php" id="login">Login</a>
    </body>
</html>