<?php
session_start();
include_once 'dbconnect.php';

if(isset($_SESSION['user'])!="")
{
	header("Location: home.php");
}

if(isset($_POST['btn-login']))
{
	$email = mysqli_real_escape_string($mysqli,$_POST['email']);
	$upass = mysqli_real_escape_string($mysqli,$_POST['pass']);
	
	$email = trim($email);
	$upass = trim($upass);
	$stmt = $mysqli->prepare("SELECT user_id, username, password FROM users WHERE email= ? ");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
	
	//$res=mysqli_query($mysqli,"SELECT user_id, username, password FROM users WHERE email='$email'");
	$row=mysqli_fetch_array($res);
	
	$count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
	
	if($count == 1 && $row['password']==md5($upass))
	{
		$_SESSION['user'] = $row['user_id'];
		header("Location: home.php");
	}
	else
	{
		?>
        <script>alert('Username / Password Seems Wrong !');</script>
        <?php
	}
	
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<link type="text/css" rel="stylesheet" href="materialize.min.css"  media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="style1.css">
</head>
<body>
<center>
<div id="login-form" style="width:40%;">
<form method="post" class="col s12">
<table align="center" width="30%" border="0">
<tr>
<td><input  type="text" name="email" placeholder="Your Email" required /></td>
</tr>
<tr>
<td><input type="password" name="pass" placeholder="Your Password" required /></td>
</tr>
<tr>
<td><button type="submit" name="btn-login">Sign In</button></td>
</tr>
<tr>
<td><a href="register.php">Sign Up Here</a></td>
</tr>
</table>
</form>

</div>
</center>
</body>
</html>