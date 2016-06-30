<?php
echo 'Thank you'.' '.$_FILES['file']['name'];
session_start();
if(isset($_SESSION['user'])!="")
{
	header("Location: home.php");
}
include_once 'dbconnect.php';


	$uname = mysqli_real_escape_string($mysqli,$_POST['uname']);
	$email = mysqli_real_escape_string($mysqli,$_POST['email']);
	$upass = md5(mysqli_real_escape_string($mysqli,$_POST['pass']));
	
	$uname = trim($uname);
	$email = trim($email);
	$upass = trim($upass);
	$file = rand(1000,100000)."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
	$file_size = $_FILES['file']['size'];
	$file_type = $_FILES['file']['type'];
	$folder="uploads/";
	$new_size = $file_size/1024;  
	// new file size in KB
	
	// make file name in lower case
	$new_file_name = strtolower($file);
	// make file name in lower case
	
	$final_file=str_replace(' ','-',$new_file_name);
	move_uploaded_file($file_loc,$folder.$final_file);

	

	
	
	// email exist or not
	$stmt1 = $mysqli->prepare("SELECT email FROM users WHERE email= ? ");
    $stmt1->bind_param("s", $email);
    $stmt1->execute();
    $result = $stmt1->get_result();
	//$query = "SELECT email FROM users WHERE email='$email'";
	//$result = mysql_query($query);
	
	$count = mysqli_num_rows($result); /// if email not found then register
	
	
	if($count == 0){

		$stmt = $mysqli->prepare("INSERT INTO users(username,email,password,file) VALUES( ? , ? , ? , ? )");
        $stmt->bind_param("ssss", $uname,$email,$upass,$final_file);
        $stmt->execute();
        echo 'successfully registered';
       // $res = $stmt->get_result();
        ?> 
			<script>alert('successfully registered ');</script>
			<?php

		
		//if(mysql_query("INSERT INTO users(username,email,password,file) VALUES('$uname','$email','$upass','$final_file')"))
          /*if($res)		
		{
			?>
			<script>alert('successfully registered ');</script>
			<?php
		}
		else
		{
			?>
			<script>alert('error while registering you...');</script>
			<?php
		}*/		
	}
	else{
			?>
			<script>alert('Sorry Email ID already taken ...');</script>
			<?php
	}
	

?>
