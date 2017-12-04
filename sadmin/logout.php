<?php
include_once("../codelibrary/inc/constants-defined.inc.php");
include_once("../codelibrary/inc/database.inc.php");
include_once("../codelibrary/inc/common.inc.php");
include_once("../codelibrary/inc/functions.inc.php");
include_once('../codelibrary/inc/check-admin-session.php');


//unset($_SESSION["username"]);
unset($_SESSION["adminFirstName"]);
unset($_SESSION["adminId"]);
header("location:login.php");
?>