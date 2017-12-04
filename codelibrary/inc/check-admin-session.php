<?php
if(trim($_SESSION["adminId"])=="" || trim($_SESSION["adminFirstName"])=="")
{
	header("location:login.php");
}
?>