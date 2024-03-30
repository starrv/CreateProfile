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
		}
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

	if(!empty($_POST['upload']))
	{
		if(!empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['caption']) && !empty($_FILES['selfie']['tmp_name']) && !empty($_FILES['cover']['tmp_name']))
		{
			connect($host,$username,$password);
			useDB("profiles");
			$fname=addslashes($_POST['fname']);
			$lname=addslashes($_POST['lname']);
			$caption=addslashes($_POST['caption']);
			$cover = addslashes(file_get_contents($_FILES['cover']['tmp_name']));
			$selfie = addslashes(file_get_contents($_FILES['selfie']['tmp_name']));
			$sql="insert into pictures(fname,lname,caption,selfie,cover) VALUES ('$fname','$lname','$caption','$selfie','$cover')";
			$result=$GLOBALS['conn']->query($sql);
			if(!$result)
			{
				echo $GLOBALS['conn']->error;
			}
			else
			{
				$last_picture_id=$GLOBALS['conn']->insert_id;
				$sql="select * from pictures where id='$last_picture_id'";
				$result=$GLOBALS['conn']->query($sql);
				if(!$result)
				{
					echo $GLOBALS['conn']->error;
				}
				else
				{
					if($result->num_rows>0)
					{
						$row=$result->fetch_assoc();
						echo "	<script type='text/javascript'>
									document.body=document.createElement('body');;
									const body=document.body;
									console.log('body: ',body);
									const canvas=document.createElement('canvas');
									canvas.id='display';
									canvas.width='500';
									canvas.height='500';
									canvas.style.margin='1rem auto';
									canvas.style.border='solid 1px black';
									canvas.style.borderRadius='5px';
									const ctx=canvas.getContext('2d');
									const background=new Image();
									background.onload=()=>{
										ctx.drawImage(background,0,0,500,500);
										const selfie=new Image();
										selfie.onload=()=>{
											ctx.drawImage(selfie,125,0,250,500);
											ctx.font='bold italic 18px serif';
											ctx.textBaseline='middle';
											ctx.fillStyle='#ffffff';
											ctx.fillRect(125,440,250,20);
											ctx.fillStyle='#000000';
											ctx.fillText('".$row['fname']." ".$row['lname']." - ".$row['caption']."',150,450);
										};
										selfie.src='data:image/jpeg;base64,".base64_encode( $row['selfie'] )."';
										selfie.style.borderRadius='200px';
									}
									background.src='data:image/jpeg;base64,".base64_encode( $row['cover'] )."';
									body.append(canvas);
								</script>";
						/*echo "
									<img src='data:image/jpeg;base64,".base64_encode( $row['selfie'] )."' width='200' height='200'><p>".
									$row['fname']." ".$row['lname']." - ".$row['caption']."</p";*/
					}
					else
					{
						echo "something went wrong :(";
					}
				}
			}
			$GLOBALS['conn']->close();
		}
		else
		{
			echo "Please enter first name, last name, caption, cover photo, and selfie to create profile";
		}
	}
	else{
		header("Location: /CreateProfile");
		exit;
	}
?>
			