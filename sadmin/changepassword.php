<?php 
include_once('../codelibrary/inc/constants-defined.inc.php');
include_once('../codelibrary/inc/database.inc.php');
include_once('../codelibrary/inc/functions.inc.php');
include_once('../codelibrary/inc/check-admin-session.php');

openConn();
$errMsg='';
	
$className='';


if(isPost())
{
	if(trim($_POST["hide"])==1)
	{
				
		$form=1;
		$oldPassword=trim($_POST['txtAdminOldPassword']);
		$newPassword=trim($_POST['txtAdminNewPassword']);
		$renewPassword=trim($_POST['txtAdminReNewPassword']);
		
		if($newPassword!='' && $renewPassword!='')
		{
			if($newPassword!=$renewPassword)
			{
				$errMsg="New and Confirm Password does not match !";
				$className='errormsg';
			}
		}
		
		if($renewPassword=='')
		{
			$errMsg="Please enter confirm password.";
			$className='errormsg';
		}
		if($newPassword!='')
		{
			if(strlen($newPassword)<6)
			{
				$errMsg="Please enter password of at least 6 characters.";
				$className='errormsg';
			}
			if(strlen($newPassword)>50)
			{
				$errMsg="Password exceeded character limit! Can have 50 characters.";
				$className='errormsg';
			}
		}
		if($newPassword=='')
		{
			$errMsg="Please enter new password.";
			$className='errormsg';
		}
		if($oldPassword=='')
		{
			$errMsg="Please enter old password.";
			$className='errormsg';
		}
		$oldPassword=md5($oldPassword);
		$newPassword=md5($newPassword);

		//echo $oldPassword.'-----------'.$newPassword;
		
		

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
					
					$errMsg="Password Updated Successfully Go back to Manage Menu !";
					$className='successmsg';
					
					$_POST['txtAdminOldPassword']='';
					$_POST['txtAdminNewPassword']='';
					$_POST['txtAdminReNewPassword']='';
					
				}
			}
			else
			{
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo _ADMIN_PAGE_TITLE_; ?>| Change Password</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/ddaccordion.js"></script>
<style>

.errormsg{border:2px #f46964 solid;  margin:20px 0px; font-size:15px; padding:10px; border-radius:2px; color:#f00;} 

.successmsg{background-color:#9ef366; border:2px #50a915 solid; color:#275e03; margin:20px 0px; font-size:15px; padding:10px; border-radius:2px;} 

.erorfldcls{color:#FF0000; font-size:12px; margin-bottom:5px; display:none;}
.redtext{color:#f36966;}
.changepass{color:#000; background-color: #595959; color:#FFF;line-height: 16px; padding: 5px 10px; -moz-border-radius: 5px; -khtml-border-radius: 5px; -webkit-border-radius: 11px; border-radius: 5px; width:106px;}
</style>
</head>
<body id="homeinnerbg">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10%" align="left" valign="top" style="width:156px;"><?php include("left.php"); ?>
    </td>
    <td width="90%" align="left" valign="top"><div id="rightbody">
        <?php include("header.php"); ?>
        <div class="rightbodysec">
          <h1>Change Administrator Password</h1></div>
        <div class="rightbodysec">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            
            <tr>
              <td width="28%" align="left" valign="top"><form id="frmChangeAdminPassword" name="frmChangeAdminPassword" method="post" action="" enctype="multipart/form-data">
                  <table width="100%" border="0" cellpadding="0" cellspacing="0"  <?php if($action=="edit"){ ?> style="border:1px solid #000;"<?php } ?> class="mainbordersec<?php if ($action=="edit"){ ?> mainhighlightbordersec<?php } ?>">
                  <?php if($errMsg!=''){?>
				   <tr>
                      <td colspan="2" style="padding:5px;" class="<?php echo $className; ?>"><strong><?php echo $errMsg; ?></strong></td>
                    </tr>
				   <?php }?>
				    <tr>
                      <td colspan="2" class="graysecheader">Change Password</td>
                    </tr>
                   
                    
                    <tr>
                      <td width="30%" style="padding:5px;"><label>Old Password </label><span class="redtext"><strong>*</strong></span></td>
                      <td width="70%" style="padding:5px;"><div class="erorfldcls" id="fld_txtAdminOldPassword"></div>
                       <input name="txtAdminOldPassword" id="txtAdminOldPassword" type="password" class="formfld" size="35" value="<?php echo $_POST['txtAdminOldPassword']; ?>"   onkeyup="hideerrordiv(this.id);" />
                      </td>
                    </tr>
                     <tr>
                      <td width="30%" style="padding:5px;">New Password <span class="redtext"><strong>*</strong></span></td>
                      <td width="70%" style="padding:5px;"><div class="erorfldcls" id="fld_txtAdminNewPassword"></div><input name="txtAdminNewPassword" id="txtAdminNewPassword" type="password" class="formfld" size="35" value="<?php echo $_POST['txtAdminNewPassword']; ?>"  onkeyup="hideerrordiv(this.id);"  />
                      </td>
                    </tr>
					<tr>
                      <td width="30%" style="padding:5px;">Confirm Password <span class="redtext"><strong>*</strong></span></td>
                      <td width="70%" style="padding:5px;"><div class="erorfldcls" id="fld_txtAdminReNewPassword"></div><input name="txtAdminReNewPassword" id="txtAdminReNewPassword" type="password" class="formfld" size="35" value="<?php echo $_POST['txtAdminReNewPassword']; ?>"   onkeyup="hideerrordiv(this.id);" />
                      </td>
                    </tr>
                    
                   
                    <tr>
                      <td style="padding:5px;">&nbsp;</td>
                      <td style="padding:5px;"><input type="submit" name="updtPass" id="updtPass" value="Update Password" class="bluebutton"  /><input type="hidden" name="hide" id="hide" value="1" />
						
                      </td>
                    </tr>
                  </table>
                </form></td>
            </tr>
          </table>
        </div>
      </div></td>
  </tr>
</table>

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

		if($("#txtAdminOldPassword").val().trim()=='')
		{
			errorFldArray.push(['txtAdminOldPassword@@@Please enter old password.']);
		}
		if($("#txtAdminNewPassword").val().trim()=='')
		{
			errorFldArray.push(['txtAdminNewPassword@@@Please enter new password.']);
		}
		if($("#txtAdminReNewPassword").val().trim()=='')
		{
			errorFldArray.push(['txtAdminReNewPassword@@@Please enter confirm password.']);
		}
		if($("#txtAdminNewPassword").val().trim()!='')
		{		
			if(($('#txtAdminNewPassword').val().length)<6)
			{
				errorFldArray.push(['txtAdminNewPassword@@@Please enter password of at least 6 characters.']);
			}
			
			if(isValidateLen($('#txtAdminNewPassword').val().trim(),50))
			{
				errorFldArray.push(['txtAdminNewPassword@@@Password exceeded character limit! Can have 50 characters.']);
			}
		}
		
		if($("#txtAdminNewPassword").val().trim()!='' && $("#txtAdminReNewPassword").val().trim()!='')
		{
			if($("#txtAdminReNewPassword").val().trim()!=$("#txtAdminNewPassword").val().trim())
			{
				errorFldArray.push(['txtAdminReNewPassword@@@Password does not match the confirm password.']);
			}
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
</body>
</html>
