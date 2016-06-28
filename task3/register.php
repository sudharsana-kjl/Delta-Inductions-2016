<?php
session_start();
if(isset($_SESSION['user'])!="")
{
	header("Location: home.php");
}
include_once 'dbconnect.php';

if(isset($_POST['btn-signup']))
{
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

	// new file size in KB
	$new_size = $file_size/1024;  
	// new file size in KB
	
	// make file name in lower case
	$new_file_name = strtolower($file);
	// make file name in lower case
	
	$final_file=str_replace(' ','-',$new_file_name);
	move_uploaded_file($file_loc,$folder.$final_file);
	/*if(move_uploaded_file($file_loc,$folder.$final_file))
	{
		$sql="INSERT INTO tbl_uploads(file,type,size) VALUES('$final_file','$file_type','$new_size')";
		mysql_query($sql);
		?>
		<script>
		alert('successfully uploaded');
        window.location.href='index.php?success';
        </script>
		<?php
	}
	else
	{
		?>
		<script>
		alert('error while uploading file');
        window.location.href='index.php?fail';
        </script>
		<?php
	}
	*/
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
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Register</title>
<link type="text/css" rel="stylesheet" href="materialize.min.css"  media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="style1.css">

</head>
<body>
<center>
<div id="login-form" style="width:40%;">
<form method="post" enctype="multipart/form-data" >
<table align="center" width="30%" border="0">
<tr>
<td><input type="text" name="uname" placeholder="User Name" required /></td>
</tr>
<tr>
<td><input type="email" name="email" placeholder="Your Email" required /></td>
</tr>
<tr>
<td><input type="password" name="pass" placeholder="Your Password" required /></td>
</tr>
<tr>
	<td>	<input type="file" name="file" required /> </td>
</tr>
<tr>
<td><button type="submit" name="btn-signup">Sign Me Up</button></td>
</tr>
<tr>
<td><a href="index.php">Sign In Here</a></td>
</tr>
</table>
</form>

</div>
</center>
</body>
</html>