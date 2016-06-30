
<?php 
include_once 'dbconnect.php'; 

if(isset($_POST['name']))
{
$name=trim($_POST['name']).'%';
$stmt = $mysqli->prepare("SELECT * FROM users WHERE username LIKE ?  ");
$stmt->bind_param("s",$name);
    $stmt->execute();
    $res = $stmt->get_result();
//$query2=mysql_query("SELECT * FROM product WHERE name LIKE '%$name%' OR descr LIKE '%$name%'");
echo "<ul>";
//while($query3=mysql_fetch_array($query2))
while($row=mysqli_fetch_array($res))
{   
?>

<li onclick='fill("<?php echo $row['username']; ?>")'><?php echo $row['username']; ?></li>
<?php
}
}
?>
</ul>