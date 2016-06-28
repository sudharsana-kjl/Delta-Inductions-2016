<?php

 $mysqli = new mysqli("localhost", "root", "", "dbtest1");
 if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }




/*error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE );
if(!mysqli_connect("localhost","root",""))
{
	die('oops connection problem ! --> '.mysqli_error());
}
if(!mysqli_select_db("dbtest1"))
{
	die('oops database selection problem ! --> '.mysqli_error());
}
*/
?>