<?php
include_once('../codelibrary/inc/constants-defined.inc.php');
include_once('../codelibrary/inc/database.inc.php');
include_once('../codelibrary/inc/functions.inc.php');

?>

<?php

////exit();
openConn();

if(isPost()) // handling the post variables
{

	$errMsg='';
	
	$className='';
	

	$username=htmlspecialchars($_POST['txtAdminUsername'],ENT_QUOTES);
	$pass=md5($_POST['txtAdminPassword']);
	///echo  $username.'-----------'.$pass;
	if(trim($username)=='') // validating if username is blank

	{

		$errMsg='Please enter username';

		$className='errormsg';

	}

	if(trim($pass)=='') // validating if password is blank

	{

		$errMsg='Please enter Password';

		$className='errormsg';

	}


	if(trim($errMsg)=='')
	{
	
		unset($selectFields);
		unset($whereFields);
		unset($whereVals);
		
		$selectFields[0]="adminId";
		$selectFields[1]="adminName";
		$selectFields[2]="adminEmail";
		$selectFields[3]="adminStatus";
		
		$whereFields[0]="adminUsername";
		$whereFields[1]="adminPassword";
		
		$whereVals[0]=$username;
		$whereVals[1]=$pass;
		
		
		$res=getRecords(_ADMIN_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_N_,'');
		
		if($res)
		{
			while($row=mysql_fetch_array($res))
			{
				if($row["adminStatus"]==1)
				{
					$_SESSION["adminId"]=$row["adminId"];
					$_SESSION["adminFirstName"]=$row["adminName"];
					$_SESSION["adminEmail"]=$row["adminEmail"];
					$_SESSION["adminStatus"]=$row["adminStatus"];
					
					
				
					/*echo "<script>window.location.href='http://scgindia.in/ara/php/admin/index.php';</script>";*/
					echo "<script>window.location.href='index.php';</script>";
				
					exit();
					//$errMsg="xxxxxxxxxxxx";
					//$className='errormsg';
				}
				else
				{
					//echo "Username '".$username."' is not active.";
					//exit();
					
					$errMsg="Username '".$username."' is not active.";
					$className='errormsg';
				}
			}
			//closeConn();
			//echo "yes";
			//exit();
			
			
								
								
		}
		else
		{
			//closeConn();
			//echo "Invalid Login";
			//exit();
			$errMsg="Invalid Login";
			$className='errormsg';
		}
	
	}


}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo _ADMIN_PAGE_TITLE_; ?> | Login</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/main-style.css" rel="stylesheet" type="text/css" />
<script src="../codelibrary/js/jquery-1.7.1.js"></script>
<link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<!--  style="background-color:#FF9900;"-->
<body>
<div id="login_contenor">
<div style="color:#000000; text-align:center;">LOGIN<!--<img src="images/logo.png"/>--></div>
<div id="errorMsgBox" class="">&nbsp;</div>
<div class="innerdiv" id="shk" >
  <form id="frmAdminLogin" class="login_form" name="frmAdminLogin" method="post" action="">
<?php 

if(trim($errMsg)!='')

{

?>

<div class="<?php echo $className; ?>" style="margin: auto;  margin-bottom: 20px;"><?php echo $errMsg; ?></div>

<?php 

} 

?>
  
  <label>Username<input type="text" id="txtAdminUsername" name="txtAdminUsername" class="login_input" autocomplete="off"  /></label>
  
	<label>Password
	<input type="password" id="txtAdminPassword" name="txtAdminPassword" class="login_input" autocomplete="off" /></label>
	
	<!-- <label style="float:left;"><input name="" type="checkbox" value="" /> Remember Me</label> -->
	<label>
	
	</label>
	<input type="submit" name="Submit2" value="Submit" class="loginBtn" />
  </form>
  </div>


  <div id="blkpop" style="display:none;"></div>

<div id="popouter" style="display:none;">

<div id="popinner">

<div id="head">Error</div>

<div id="txt"></div>

<div style="text-align:center; margin-bottom:20px;"><input name="Submit" type="button" class="alrtBtn" value="OK" onclick="closepopaleT();" /><input type="hidden" name="txtElemId" id="txtElemId" /></div>

</div>

</div>

</div>
<script>

function popalertmsg(almsg,eleid)

{

	$('#blkpop').css("display", "block");

	$('#popouter').slideDown();

	$('#txt').text(almsg);

	$('#txtElemId').val(eleid);

}



function closepopaleT()

{

	$('#blkpop').css("display", "none");

	$('#popouter').slideUp();

	var elemid=$('#txtElemId').val();

	$('#'+elemid).focus();

}



function isValidateLen(txtID,lnth)

{

	if(txtID.length > lnth)

	{

		return true;

	}

	else

	{

		return false;

	}

}



$(document).ready(function()

{



	$("#frmAdminLogin").submit(function()

	{

		if($("#txtAdminUsername").val()=='')

		{

			popalertmsg('Please enter username','txtAdminUsername');

			return false;

		}


		if($("#txtAdminPassword").val()=='')

		{

			popalertmsg('Please enter password','txtAdminPassword');

			return false;

		}

 		return true;

	});



});

$('#txtAdminUsername').focus();

</script>

</body>
</html>
