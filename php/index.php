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
		<div id="profilePicturesDisplay">'
			<?php

				require_once 'database.php';

				function process(){
					$fname=addslashes($_POST['fname']);
					$lname=addslashes($_POST['lname']);
					$caption=addslashes($_POST['caption']);
					$selfie = file_get_contents($_FILES['selfie']['tmp_name']);
					$cover = file_get_contents($_FILES['cover']['tmp_name']);
					return createProfilePicture($fname,$lname,$caption,$selfie,$cover,$_COOKIE['user']);
				}
				

				if(!empty($_POST['create']))
				{
					if(!empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['caption']) && !empty($_FILES['selfie']['tmp_name']) && !empty($_FILES['cover']['tmp_name']))
					{
						$row=process();
						if($row){
							echo "	<script type='text/javascript'>
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
										</script>";
						}
						else{
							echo "<p class='error'>Something went wrong</p>";
						}
						
					}
				}
				else{
					header("Location: /CreateProfile");
					exit;
				}
			?>
		</div>
	</body>
</html>