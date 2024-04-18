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
				Your Profile Pictures
			</h1>
		</header>
            <?php
                require_once 'database.php';

                if(empty($_COOKIE['user'])){
                    header("Location: /CreateProfile/php/login.php");
                }

                echo "<p class='logged-in-info'>You are logged in as: ".$_COOKIE['user']."</p>";
                echo '<div id="profilePicturesDisplay">';
                process();
            
                function process(){
                    $result=getProfilePictures($_COOKIE['user']);
                    if(gettype($result)=="object"){
                        echo "	<script type='text/javascript'>
                                    let count=".$result->num_rows.";";
                        while($row=$result->fetch_assoc()){
                            echo "
                                if(count>0){
                                    const profilePicturesDisplay=document.querySelector('#profilePicturesDisplay');
                                    const canvas=document.createElement('canvas');
                                    canvas.id='display';
                                    canvas.width=500;
                                    canvas.height=500;
                                    canvas.style.margin='1rem auto';
                                    canvas.style.border='solid 1px black';
                                    canvas.style.borderRadius='5px';
                                    const ctx=canvas.getContext('2d');
                                    const cover=new Image();
                                    cover.onload=()=>{
                                        ctx.drawImage(cover,0,0,500,500);
                                        const selfie=new Image();
                                        selfie.onload=()=>{
                                            ctx.drawImage(selfie,125,0,250,500);
                                            ctx.font='bold italic 18px serif';
                                            ctx.textBaseline='middle';
                                            ctx.fillStyle='#ffffff';
                                            ctx.fillRect(125,340,250,20);
                                            ctx.fillStyle='#000000';
                                            ctx.fillText('".$row['fname']." ".$row['lname']." - ".$row['caption']."',150,350);
                                        };
                                        selfie.src='data:image/jpeg;base64,".base64_encode( $row['selfie'] )."';
                                        selfie.style.borderRadius='200px';
                                    }
                                    cover.src='data:image/jpeg;base64,".base64_encode( $row['cover'] )."';
                                    profilePicturesDisplay.append(canvas);
                                    count--;
                                }
                             ";
                        }
                        echo "</script>"; 
                    }
                    else if($result==1){
                        echo '<p>You have no profile pictures</p>';
                    }
                    else{
                        echo "<p class='error'>Something went wrong</p>";
                    }
                }
                echo "<div>
                <button id='home' onclick=window.open('/CreateProfile');>Home</button>
            </div>";
            ?>
        </div>
    </body>
</html>