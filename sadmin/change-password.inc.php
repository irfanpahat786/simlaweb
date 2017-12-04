<?php 
include_once('../codelibrary/inc/constants-defined.inc.php');
include_once('../codelibrary/inc/database.inc.php');
include_once('../codelibrary/inc/functions.inc.php');
include_once('../codelibrary/inc/check-admin-session.php');


openConn();


//session_start();

error_reporting(0);
?>

<?php

$errMsg='';
	
$className='';
////exit();

///print_r($_POST);

if(isPost()) // handling the post variables
{
	if(trim($_POST["hide"])==1)
	{
		
$form=1;
//get the posted values
$oldPassword=md5($_POST['txtAdminOldPassword']);
$newPassword=md5($_POST['txtAdminNewPassword']);
$renewPassword=md5($_POST['txtAdminReNewPassword']);
//echo $oldPassword.'-----------'.$newPassword;
if($newPassword!=$renewPassword || md5($newPassword)!=md5($renewPassword))
{
	//echo "NO|Both new passwords do not match";
	//exit();
	//header("location:http://scgindia.in/ara/php/admin/list-products.php?type=4&editid=4");
	//exit();
	$errMsg="New and Confirm Password does not match !";
	$className='errormsg';
}


////echo "NO|".$oldPassword;
////exit();

if(trim($errMsg)=='')
{
	unset($selectFields);
	unset($whereFields);
	unset($whereVals);
	
	$selectFields[0]="adminId";
	$selectFields[1]="adminPassword";
	
	$whereFields[0]="adminId";
	
	$whereVals[0]=$_SESSION["adminId"];
	
	
	$res=getRecords(_ADMIN_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_N_,'');
	
	if($res)
	{
		while($row=mysql_fetch_array($res))
		{
			$passwordToCheck=$row["adminPassword"];
		}
		
		if($passwordToCheck!=$oldPassword)
		{
			//closeConn();
			//echo "NO|Old Password does not match in database";
			//exit();
			$errMsg="Incorrect Old Password !";
			$className='errormsg';
		}
		else
		{
			unset($insertFields);
			unset($insertVals);
			unset($whereFields);
			unset($whereVals);
			
			$insertFields[0]="adminPassword";
	
			$insertVals[0]=$newPassword;
	
			$whereFields[0]="adminId";
			
			$whereVals[0]=$_SESSION["adminId"];
			
			$resUpdate=updateDB(_ADMIN_MASTER_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');
			
			//closeConn();
			//echo "yes|Password changed successfully";
			//exit();
			//$errMsg="Password Changed Successfully !";
			$errMsg="Updated Successfully Go back to Manage Menu !";
			$className='successmsg';
			
		}
	}
	else
	{
		//closeConn();
		//echo "NO|Existing Password do not match in database.";
		//exit();
		$errMsg="Existing Password do not match !";
		$className='errormsg';
	}
	
	
	}
	}
	else
	{
	
		$errMsg="Form Not Submited !";
		$className='errormsg';
	}
}
?>