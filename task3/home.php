<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
  header("Location: index.php");
}

$stmt = $mysqli->prepare("SELECT * FROM users WHERE user_id= ? ");
$stmt->bind_param("s", $_SESSION['user']);
$stmt->execute();
$res = $stmt->get_result();
//$res=mysqli_query($mysqli,"SELECT * FROM users WHERE user_id=".$_SESSION['user']);
$userRow=mysqli_fetch_array($res);
?>
<!DOCTYPE html>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['username']; ?></title>
<link type="text/css" rel="stylesheet" href="materialize.min.css"  media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="style1.css">

</head>
<body>
    <nav>
<div class = "teal nav-wrapper">
  
            <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="logout.php?logout">Log out</a></li>
        
      </ul>
          
        
</div>
</nav>

<div id="body">
  
    <img src="uploads/<?php echo $userRow['file'] ?>" style="width:100px; height:100px;">
     <h3>UserName: <?php echo $userRow['username'];?></h3>
    <h3>Email: <?php echo $userRow['email'];?></h3>
    <a href="edit.php">Edit</a>
</div>

</body>
</html>