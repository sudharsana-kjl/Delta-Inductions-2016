
<?php



function renderform($username, $email,$pass,$file)
{ ?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit</title>
<link type="text/css" rel="stylesheet" href="materialize.min.css"  media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="style1.css">

</head>
<body>
<center>
<div id="login-form" style="width:40%;">
<form method="post" enctype="multipart/form-data" >
<table align="center" width="30%" border="0">
<tr>
<td><input type="text" name="uname" value="<?php echo $username; ?>" placeholder="User Name" required /></td>
</tr>
<tr>
<td><input type="email" name="email" value="<?php echo $email; ?>" placeholder="Your Email" required /></td>
</tr>
<tr>
<td><input type="password" name="pass" value="" placeholder="Your Password" required /></td>
</tr>
<tr>
<td><img src="uploads/<?php echo $file ;?>" style="width:100px; height:100px;"></td>
</tr>
<tr>
	<td>	<input type="file" name="file" /> </td>
</tr>
<tr>
<td><button type="submit" name="btn-signup">Update</button></td>
</tr>
<tr>
<td><a href="logout.php?logout">Log out</a></td>
</tr>

</table>
</form>

</div>
</center>
</body>
</html>

<?php


}
session_start();
include_once 'dbconnect.php';
if(!isset($_SESSION['user']))
{
	header("Location: index.php");
}




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
	$new_size = $file_size/1024;  
	// new file size in KB
	
	// make file name in lower case
	$new_file_name = strtolower($file);
	// make file name in lower case
	
	$final_file=str_replace(' ','-',$new_file_name);
	move_uploaded_file($file_loc,$folder.$final_file);

	if($uname =='' || $email==''||$upass==''){
		renderform($uname,$email,$upass,$final_file);
	}
	else {

	$stmt1 = $mysqli->prepare("SELECT email FROM users WHERE email= ? ");
    $stmt1->bind_param("s", $email);
    $stmt1->execute();
    $result = $stmt1->get_result();

    $count = mysqli_num_rows($result);

    if($count == 1 || $count == 0 ){ //he can have same email or new email

		$stmt = $mysqli->prepare("UPDATE users SET username= ? ,email= ? ,password= ?,file= ?  WHERE user_id= ? ");
        $stmt->bind_param("sssss", $uname,$email,$upass,$final_file,$_SESSION['user']);
        $stmt->execute();
       // $res = $stmt->get_result();
        ?>
			<script>alert('successfully updated ');</script>
			<?php
                  header("Location: home.php");
			}
	else{
			?>
			<script>alert('Sorry Email ID already taken ...');</script>
			<?php
	}
}
}
else {
	
	
	$stmt = $mysqli->prepare("SELECT * FROM users WHERE user_id= ? ");
$stmt->bind_param("s", $_SESSION['user']);
$stmt->execute();
$res = $stmt->get_result();
//$res=mysqli_query($mysqli,"SELECT * FROM users WHERE user_id=".$_SESSION['user']);
$userRow=mysqli_fetch_array($res);
$username = $userRow['username'];
$email = $userRow['email'];
$pass = $userRow['password'];
$file = $userRow['file'];
renderform($username,$email,$pass,$file);
}


