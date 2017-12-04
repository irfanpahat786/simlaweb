<?php
include_once('../codelibrary/inc/constants-defined.inc.php');
include_once('../codelibrary/inc/database.inc.php');
include_once('../codelibrary/inc/common.inc.php');
include_once('../codelibrary/inc/functions.inc.php');

?>

<?php
$errMsg='';
	
$className='';
////exit();
openConn();

if(isPost()) // handling the post variables
{

//get the posted values
$oldPassword=md5($_POST['txtAdminOldPassword']);
$newPassword=md5($_POST['txtAdminNewPassword']);
$renewPassword=md5($_POST['txtAdminReNewPassword']);

if($newPassword!=$renewPassword || md5($newPassword)!=md5($renewPassword))
{
	//echo "NO|Both new passwords do not match";
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
?>

<div id="header">
	<h2><?php echo _WEBSITE_NAME_; ?> Admin</h2>
	<div id="welcomeloginbox">Welcome <?php echo $_SESSION["adminFirstName"]; ?>&nbsp;|&nbsp;<a href="logout.php">Logout</a></div>
	
</div>
	<div id="settingtab" align="right">
	<div class="graybg submenu" align="left" style="display:none">
	  <table border="0" cellspacing="0" cellpadding="3">
      <form name="frmChangeAdminPassword" id="frmChangeAdminPassword" method="post">
        <tr>
          <td colspan="2"><strong>Change Password </strong></td>
        </tr>
        <tr>
	      <td colspan="2"><div class="errormsg" style="border:#000 solid 3px; display:none;" id="allErrorMsgHeader">Some required information is missing or incomplete. Please correct your entries and try again.</div><?php 

if(trim($errMsg)!='')

{

?>

<div class="<?php echo $className; ?>" style="margin: auto;  margin-bottom: 20px;"><?php echo $errMsg; ?></div>

<?php 

} 

?><!--<span id="changePassMsgBox"></span>--></td>
        </tr>
        <tr>
          <td><label>Old Password </label><span class="redtext"><strong>*</strong></span></td>
          <td><div class="erorfldcls" id="fld_txtAdminOldPassword"></div><input name="txtAdminOldPassword" id="txtAdminOldPassword" type="password" class="formfld" size="35"   onkeyup="hideerrordiv(this.id);" /></td>
        </tr>
        <tr>
          <td>New Password <span class="redtext"><strong>*</strong></span>            </td>
          <td><div class="erorfldcls" id="fld_txtAdminNewPassword"></div><input name="txtAdminNewPassword" id="txtAdminNewPassword" type="password" class="formfld" size="35"  onkeyup="hideerrordiv(this.id);"  /></td>
        </tr>
        <tr>
          <td>Confirm Password <span class="redtext"><strong>*</strong></span> </td>
          <td><div class="erorfldcls" id="fld_txtAdminReNewPassword"></div><input name="txtAdminReNewPassword" id="txtAdminReNewPassword" type="password" class="formfld" size="35"   onkeyup="hideerrordiv(this.id);" /></td>
        </tr>
        <tr>
          <td height="35"></td>
          <td align="left"><!--<img src="images/loader.gif" id="loader" style="visibility:hidden;" />--><input type="submit" name="updtPass" id="updtPass" value="Update Password" class="bluebutton" /></td>
        </tr>
        </form>
      </table>
	</div>
	<div class="roundcornerbtngray silverheader" ><a href="javascript: void(0);">Change Password</a></div>
	
	</div>
<script>

function hideerrordiv(elemId)
{


	$('#fld_'+elemId).css('display','none');


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



function blockNonNumbers(obj, e, allowDecimal, allowNegative)
{

	var key;

	var isCtrl = false;

	var keychar;

	var reg;

	if(window.event) {
		key = e.keyCode;

		isCtrl = window.event.ctrlKey


	}


	else if(e.which) {

		key = e.which;
		isCtrl = e.ctrlKey;


	}


	if (isNaN(key)) return true;

	keychar = String.fromCharCode(key);


	// check for backspace or delete, or if Ctrl was pressed



	if (key == 8 || isCtrl)

	{

		return true;

	}



	reg = /\d/;



	var isFirstN = allowNegative ? keychar == '-' && obj.value.indexOf('-') == -1 : false;



	var isFirstD = allowDecimal ? keychar == '.' && obj.value.indexOf('.') == -1 : false;


	return isFirstN || isFirstD || reg.test(keychar);



}


$(document).ready(function()
{



	$("#frmChangeAdminPassword").submit(function()
	{



		var errorFldArray=[];



		var allFldArray=["txtAdminOldPassword","txtAdminNewPassword","txtAdminReNewPassword"];


		if($("#txtAdminOldPassword").val().trim()=='' || $("#txtAdminNewPassword").val().trim()=='' || $("#txtAdminReNewPassword").val().trim()=='')

		{

			errorFldArray.push(['txtAdminOldPassword@@@Please enter all passwords!']);

		}



		for (var i = 0; i < allFldArray.length; i++)

		{


			$('#fld_'+allFldArray[i]).css('display','none');



			$('#allErrorMsgHeader').css('display','none');



		}




		for (var i = 0; i < errorFldArray.length; i++)

		{

			$('#allErrorMsgHeader').css('display','block');



			$('html, body').animate({scrollTop: '-100px'}, 0);



			var errorfldrow='';



			var errorfldrownew='';



			errorfldrow=$.trim(errorFldArray[i]);



			errorfldrownew=errorfldrow.split('@@@');



			$('#fld_'+errorfldrownew[0]).css('display','block');



			$('#fld_'+errorfldrownew[0]).text(errorfldrownew[1]);


		}

		if(errorFldArray.length>0)

		{



 			return false;



		}

		else

		{



			return true;



		}


	});


});



$('#txtAdminOldPassword').focus();



</script>
