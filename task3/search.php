<?php 
include_once 'dbconnect.php'; ?> <html > <head> <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> <title>Untitled Document</title> <link rel="stylesheet" href="style2.css" type="text/css"><script type="text/javascript" src="jquery-1.12.1.js"></script>
<script type="text/javascript">
function fill(Value)
{
$('#name').val(Value);
//$('#display').hide();
}

$(document).ready(function(){
$("#name").keyup(function() {
var name = $('#name').val();

if(name=="")
{
$("#display").html("");
}
else
{
$.ajax({
type: "POST",
url: "ajax.php",
data: "name="+ name ,
success: function(html){
$("#display").html(html).show();
}
});
}
});
});
</script>
</head>
<body>
<div id="content">
<?php
$val='';
if(isset($_POST['submit']))
{
if(!empty($_POST['name']))
{
$val=$_POST['name'];
}
else
{
$val='';
}
}
?>

<form method="post" action="search.php">
Search : <input type="text" name="name" id="name" autocomplete="off"
value="<?php echo $val;?>">
<input type="submit" name="submit" id="submit" value="Search">
</form>
<div id="display"></div>
<?php
if(isset($_POST['submit']))
{
if(!empty($_POST['name']))
{
$name=$_POST['name'];
$stmt = $mysqli->prepare("SELECT * FROM users WHERE username LIKE ?  ");
    $stmt->bind_param("s",$name);
    $stmt->execute();
    $res = $stmt->get_result();
//$query3=mysql_query("SELECT * FROM users WHERE username LIKE '%$name%' ");
//while($query4=mysql_fetch_array($query3))
    while($row=mysqli_fetch_array($res))
{
echo "<div id='box'>";
echo "<b>".$row['username']."</b>";
echo "<div id='clear'></div>";
echo $row['email'];
echo "<div id='clear'></div>";
echo $row['file'];
echo "<img src='uploads/".$row['file']."'/>";
//echo $query4['descr'];
echo "</div>";
}
}
else
{
echo "No Results";
}
}
?>
</div>
</body>
</html>