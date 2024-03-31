<?php
    //report errors
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once 'data.php';

    function connect($servername, $usernameDB,$passwordDB)
        {
            $GLOBALS['conn'] = new mysqli($servername, $usernameDB, $passwordDB);
            // Check connection
            if ($GLOBALS['conn']->connect_error)
            {
                echo $GLOBALS['conn']->error;
                return false;
            }
            return true;
        }
        
        function useDB($dbname)
        {
            $sql="create database if not exists ".$dbname;
            $GLOBALS['conn']->query($sql);
            $sql="use ".$dbname;
            $GLOBALS['conn']->query($sql);
            $sql="SET time_zone = '+00:00'";
            $GLOBALS['conn']->query($sql);
        }
        //return codes: 4 is success, 1 is passwords do not match, 2 is username is already on file, 3 is something went wrong
        function signUp($username,$password,$confirmPassword){
            global $db_host;
            global $db_username;
            global $db_password;

            if($password===$confirmPassword){
                $username=addslashes($_POST['username']);
                $password_hash=password_hash(addslashes($password),PASSWORD_DEFAULT);
                $result=connect($db_host,$db_username,$db_password);
                if($result){
                    try{
                        useDB('profiles');
                        $query="Insert into users(username,password) values(?,?);";
                        $stmt = $GLOBALS['conn']->prepare($query);
                        $stmt->bind_param('ss',$username, $password_hash); 
                        $stmt->execute();
                        return 0;
                    }
                    catch(mysqli_sql_exception ){
                        return 2;
                    }
                    finally{
                        $GLOBALS['conn']->close();
                    }
                }
                else{
                    return 3;
                }
            }
            else{
                return 1;
            }
        }
         //return codes: 3 is success, 1 is username/password combination is not on file, 2 is something went wrong
        function login($username,$password){
            global $db_host;
            global $db_username;
            global $db_password;

            $username=addslashes($_POST['username']);
            $result=connect($db_host,$db_username,$db_password);
            if($result){
                useDB('profiles');
                $query="Select username, password from users where username=?;";
                $stmt = $GLOBALS['conn']->prepare($query);
                $stmt->bind_param('s',$username); 
                $stmt->execute();
                $result = $stmt->get_result();
                if($result->num_rows>0){
                    $password=addslashes($_POST['password']);
                    $row=$result->fetch_assoc();
                    if(password_verify($password,$row['password'])){
                        return 3;
                    }
                    else{
                        return 1;
                    }
                }
                else{
                    return 1;
                }
            }
            else{
                return 2;
            }
            $GLOBALS['conn']->close();
        }

        function createProfilePicture($fname,$lname,$caption,$selfie,$cover,$user){
            global $db_host;
            global $db_username;
            global $db_password;

            connect($db_host,$db_username,$db_password);
            useDB("profiles");
            $result = $GLOBALS['conn']->query("select id FROM users where username='$user'");
            if($result->num_rows>0){
                $row=$result->fetch_assoc();
                $user_id=$row['id'];
                try{
                    $query="insert into pictures(fname,lname,caption,selfie,cover,user_id) VALUES (?,?,?,?,?,?)";
                    $stmt = $GLOBALS['conn']->prepare($query);
                    $null = NULL;
                    $stmt->bind_param('sssbbi',$fname,$lname,$caption,$null,$null,$user_id); 
                    $stmt->send_long_data(3,$selfie );
                    $stmt->send_long_data(4,$cover );
                    $stmt->execute();
                    $last_picture_id=$GLOBALS['conn']->insert_id;
                    $sql="select * from pictures where id='$last_picture_id'";
                    $result=$GLOBALS['conn']->query($sql);
                    if(!$result)
                    {
                        echo $GLOBALS['conn']->error;
                        return false;
                    }
                    else
                    {
                        if($result->num_rows>0)
                        {
                            return $result->fetch_assoc();
                        }
                        else
                        {
                            return false;
                        }
                    }
                }
                catch(mysqli_sql_exception){
                   return false;
                }
                finally{
                    $GLOBALS['conn']->close();
                }
            }
            else{
                return false;
            }	
        }
        //return codes: 0 success, 1 no pictures, 2 something went wrong
        function getProfilePictures($user){
            global $db_host;
            global $db_username;
            global $db_password;

            connect($db_host,$db_username,$db_password);
            useDB("profiles");
            $result = $GLOBALS['conn']->query("select id FROM users where username='$user'");
            if($result->num_rows>0){
                $row=$result->fetch_assoc();
                $user_id=$row['id'];
                $result = $GLOBALS['conn']->query("select * FROM pictures where user_id='$user_id'");
                if($result->num_rows>0){
                    return $result;
                }
                else{
                    return 1;
                }
            }
            else{
                return 2;
            }
        }

?>