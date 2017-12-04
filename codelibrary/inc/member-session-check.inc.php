<?php
if($_SESSION["memberId"]=="" || $_SESSION["memberId"]==0 || !is_numeric($_SESSION["memberId"]))
{
	header("location:login.php");
}
elseif(isset($_SESSION["memberId"]) && $_SESSION["memberId"]!="" && $_SESSION["memberId"]!=0 && !is_numeric($_SESSION["memberId"]) && $_SESSION["firstLogin"]==0)
{
	header("location:first-login.php");
}
?>