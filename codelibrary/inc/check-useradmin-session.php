<?php
if(trim($_SESSION["memberId"])=="" || trim($_SESSION["userAdminName"])=="")
{
	header("location:login.php");
}
?>