<?php 
include_once('../codelibrary/inc/constants-defined.inc.php');
include_once('../codelibrary/inc/database.inc.php');
include_once('../codelibrary/inc/functions.inc.php');
include_once('../codelibrary/inc/check-admin-session.php');
openConn();

$action="add";
$errorMsgColor='#FF0000';
if(trim($_GET['type'])=='content')
{
	$pageIndexval=2;
}
else if(trim($_GET['type'])=='listing')
{
	$pageIndexval=5;
}

if($_GET["id"]!='' && is_numeric($_GET["id"]))
{
	unset($selectFields);
	unset($whereFields);
	unset($whereVals);
	
	$selectFields[0]="*";

	$whereFields[0]="id";

	$whereVals[0]=$_GET["id"];
	
	$resDetails=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_N_,'');
	
	if($resDetails)
	{
		while($rowDetails=mysql_fetch_array($resDetails))
		{
			$id=$rowDetails["id"];
			
			$menuName=$rowDetails["menuName"];
			$pageUrl=$rowDetails["pageUrl"];
			$sortOrder=$rowDetails["sortOrder"];
			$pageDescription=$rowDetails["pageDescription"];
			$uploadedFileName=$rowDetails["uploadedFileName"];
			$metaTags=$rowDetails["metaTags"];
			$mainMenuId=$rowDetails["mainMenuId"];
			$header_contents=$rowDetails["header_contents"];
			$footer_contents=$rowDetails["footer_contents"];
			$meta_description=$rowDetails["meta_description"];
			$shortDescription=$rowDetails["shortDescription"];
		}
			


		$action="edit";	
	}
}

$serviceMenuId=3;

if(isPost())
{
	$action=$_POST["txtAction"];
	$errorMsg='';
	

//echo "<pre>";
//   print_r($_POST);
//echo "</pre>";

	if(trim(strtolower($action))=="edit") /*-----------------Edit Commond---------------*/
	{
		$id=trim($_POST["txtParam1"]);
		$menuName=clean($_POST["menuName"]);
		$pageUrl=$_POST["pageUrl"];
		$pageDescription=clean($_POST["txtDescription"]);
		$shortDescription=clean($_POST["shortDescription"]);
		
		$header_contents=clean($_POST["header_contents"]);
		$footer_contents=clean($_POST["footer_contents"]);
		
		if($_POST["metaTitle"]!='')
		{		
			$metaTags=clean($_POST["metaTitle"]);
		}
		else
		{
			$metaTags=clean($_POST["metaTags"]);
		}
		
		$meta_description=clean($_POST["meta_description"]);
		
		if($pageUrl!='')
		{
			$pageUrl=makeContentUrl($pageUrl);
		}
		else
		{
			if($menuName!='')
			{
				//$pageUrl=makeContentUrl($menuName);
			}
		}

		 if($metaTags!='')
		 {
				$arrayx=$menuName;
				$array1=explode(",&nbsp;",$arrayx);
				
				$arrayy=$metaTags;
				$array2=explode(",&nbsp;",$arrayy);
				
				$array_merge = array_merge($array1, $array2);
				$array_unique = array_unique($array_merge);
				
				$metaTags=implode(",&nbsp;", $array_unique);
			}
			else
			{	
				$metaTags=$menuName;
			} 
		


		
		
		if($id==233 || $id==236 || $id==238)
		{
			if($pageUrl=='')
			{
				$errorMsg="Please enter page URL.";
			}
		}
		else
		{
			if($menuName=='')
			{
				$errorMsg="Please enter page Title.";
			}
		}
		
		if(trim($errorMsg)=='')
		{
			if(!empty($_FILES["bannerfield"]["name"]))
			{
				$extArray=strtolower(end(explode(".", $_FILES["bannerfield"]["name"])));
				if($extArray=='png' || $extArray=='jpg' || $extArray=='jpeg' || $extArray=='gif')
				{
					$size=filesize($_FILES['bannerfield']['tmp_name']);
					
					if ($size > MAX_SIZE*1024)
					{
						$errorMsg="Please upload File size of upto 2 MB!<br>";
					}
					else
					{
						$uploadedFileName=rand(0,99).date("Ymdsi");
						$uploadedFileName=$uploadedFileName.".".$extArray;
						
							
						$filePath=$_FILES['bannerfield']['tmp_name'];
						$imageUploaded=false;
						chmod("../uploads/", 0777);  // octal; correct value of mode
						$imageUploaded=uploadImage($filePath,"../uploads/".$uploadedFileName);
						chmod("../uploads/", 0755);  // octal; correct value of mode
						
						if(!$imageUploaded)
							$errorMsg.="File not uploaded.<br>";
						else
						{
							if(trim($_POST["txtOldFile"])!='' && is_file("../uploads/".$_POST["txtOldFile"]))
								unlink("../uploads/".$_POST["txtOldFile"]);
						}
					}
				}
				else
				{
					$errorMsg="Please upload .png, .jpg, .jpeg, .gif, files only.";
				}	
			}
			else if(trim($_POST["txtOldFile"])!='')
			{
					$uploadedFileName=$_POST["txtOldFile"];
			}
			else
			{
				//$errorMsg="Please upload .png, .jpg, .jpeg, .gif, files only.";
			}
		}

		
		if(trim($errorMsg)=='')
		{
		
			
			unset($insertFields);
			unset($insertVals);
			unset($whereFields);
			unset($whereVals);
			
			$insertFields[0]="menuName";
			$insertFields[1]="pageDescription";
			$insertFields[2]="modifyDate";
			$insertFields[3]="modifyBy";
			$insertFields[4]="metaTags";
			$insertFields[5]="uploadedFileName";
			$insertFields[6]="header_contents";
			$insertFields[7]="footer_contents";
			$insertFields[8]="meta_description";
			$insertFields[9]="shortDescription";
			if($pageUrl!='')
			{
			$insertFields[10]="pageUrl";
			}

			$insertVals[0]=$menuName;
			$insertVals[1]=$pageDescription;
			$insertVals[2]=time();
			$insertVals[3]=$_SESSION["adminId"];
			$insertVals[4]=$metaTags;
			$insertVals[5]=$uploadedFileName;
			$insertVals[6]=$header_contents;
			$insertVals[7]=$footer_contents;
			$insertVals[8]=$meta_description;
			$insertVals[9]=$shortDescription;
			if($pageUrl!='')
			{
			$insertVals[10]=$pageUrl;
			}
			
			$whereFields[0]="id";
			
			$whereVals[0]=$id;
			
			$resUpdate=updateDB(_MENU_MASTER_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');

			
			if($_POST["Submit3"]!='')
			{
				unset($insertFields);
				unset($insertVals);
				unset($whereFields);
				unset($whereVals);
				
				$insertFields[0]="uploadedFileName";
	
				$insertVals[0]='';
				
				$whereFields[0]="id";
				
				$whereVals[0]=$id;
				
				$resUpdate=updateDB(_MENU_MASTER_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');
				if($resUpdate)
				{						
											
						if(trim($_POST["txtOldFile"])!='' && is_file("../uploads/".$_POST["txtOldFile"]))
											unlink("../uploads/".$_POST["txtOldFile"]);
				
				}
				
				
			}
			
			if($_POST["Submit3"]!='')
			{
				/*echo "<script>window.location.href='manage_menuct.php?rmfile=1&id=".$id."'</script>";*/
				header('Location:manage_menuct.php?rmfile=1&id='.$id.'');
				exit();
			}
			else
			{
				/*echo "<script>window.location.href='manage_menuct.php?updateid=1&id=".$id."'</script>";*/
				header('Location:manage_menuct.php?updateid=1&id='.$id.'');
				exit();
				$errorMsg="Updated Successfully !";
				$errorMsgColor='#009900';
			}
			
			
			
		}
	
	}
	

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo _ADMIN_PAGE_TITLE_; ?>|<?php echo $menuName; ?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link href="css/validate.css" rel="stylesheet" type="text/css" />
<link href="css/main.css" rel="stylesheet" type="text/css" />

<script language="JavaScript" type="text/javascript" src="../codelibrary/ckeditor/ckeditor.js"></script>
<script language="JavaScript" type="text/javascript" src="../codelibrary/ckeditor/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/ddaccordion.js"></script>

<script type="text/JavaScript">

function cmd_del(){

var x= confirm("Do you want to delete this Menu?");

if(x)

return true;

else 

return false;



}
</script>
<style>
.erorfldcls {
	color:#FF0000;
	font-size:12px;
	margin-bottom:5px;
	display:none;
}
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
          <h1>Manage: Menu Pages<?php //echo $menuName; //if(strtolower($menuName)=='home') echo " (What we do?)"; ?></h1>
        </div>
        <div class="rightbodysec">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="3" align="center" height="25" valign="top"><span style="color:<?php echo $errorMsgColor; ?>;"><strong><?php echo $errorMsg; ?></strong></span></td>
            </tr>
            <tr>
              <td align="left" valign="top"><form id="frmMenu" name="frmMenu" method="post" action="" enctype="multipart/form-data">
                  <table width="100%" border="0" cellpadding="0" cellspacing="0"  <?php if($action=="edit"){ ?> style="border:1px solid #000;"<?php } ?> class="mainbordersec<?php if ($action=="edit"){ ?> mainhighlightbordersec<?php } ?>">
                    <tr>
                      <td colspan="2" class="graysecheader"><?php if ($action=="edit"){ ?>
                        <strong>Edit:</strong> <?php echo $menuName;  } ?></td>
                    </tr>
                    <tr>
                      <td colspan="2" style="padding:5px;"><div class="errormsg" style="border:#000 solid 3px; display:none;" id="allErrorMsg">Some required information is missing or incomplete. Please correct your entries and try again.</div></td>
                    </tr>
					<?php
					if($_GET["id"]==233 || $_GET["id"]==236 || $_GET["id"]==238)
					{
					?>
					<input name="menuName" type="hidden" class="formfld" id="menuName" value="<?php echo $menuName;  ?>" style="width: 484px;"  onkeyup="hideerrordiv(this.id);" />
					<?php
					}
					else
					{
					?>
                    <tr>
                      <td width="19%" style="padding:5px;"> Title<span class="redtext"><strong>*</strong></span> </td>
                      <td width="81%" style="padding:5px;"><div class="erorfldcls" id="fld_menuName"></div>
                        <input name="menuName" type="text" class="formfld" id="menuName" value="<?php echo $menuName;  ?>" style="width: 484px;"  onkeyup="hideerrordiv(this.id);" />					  </td>
					</tr>
                    <?php 
					 }
					 
					if(trim($_GET['type'])=='content')
					{
					
					if($mainMenuId==$serviceMenuId)
					{
					?>
					<tr>
                <td width="10%" align="left" valign="top" style="padding:5px;"><span class="red_star"></span>Short Description</td>
                <td width="90%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_shortDescription"></div><textarea name="shortDescription" id="shortDescription"  onkeyup="hideerrordiv(this.id);" cols="50" rows="7" style="width:487px;"><?php echo $shortDescription; ?></textarea></td>
              </tr><?php
					}
					
					if($_GET["id"]!=39)
					{
					?>
                    <tr>
                      <td width="19%" style="padding:5px;">Description</td>
                      <td width="81%" style="padding:5px;"><textarea name="txtDescription" id="txtDescription" <?php echo $editorcr;?>><?php echo stripslashes($pageDescription); ?></textarea>
                        <script type="text/javascript">
	                var editor = CKEDITOR.replace('txtDescription');
					CKFinder.setupCKEditor( editor,'<?php echo _CKFINDER_PATH_; ?>' ) ;
                </script></td>
                    </tr>
                     <?php 
					 }
					if($mainMenuId==$serviceMenuId)
					{
					?>
					
					<!--<tr>
                      <td width="19%" style="padding:5px;">Header Details</td>
                      <td width="81%" style="padding:5px;"><textarea name="header_contents" id="header_contents"><?php echo stripslashes($header_contents); ?></textarea>
                        <script type="text/javascript">
	                var editor = CKEDITOR.replace('header_contents');
					CKFinder.setupCKEditor( editor,'<?php echo _CKFINDER_PATH_; ?>' ) ;
                </script></td>
                    </tr>
					<tr>
                      <td width="19%" style="padding:5px;">Footer Details</td>
                      <td width="81%" style="padding:5px;"><textarea name="footer_contents" id="footer_contents"><?php echo stripslashes($footer_contents); ?></textarea>
                        <script type="text/javascript">
	                var editor = CKEDITOR.replace('footer_contents');
					CKFinder.setupCKEditor( editor,'<?php echo _CKFINDER_PATH_; ?>' ) ;
                </script></td>
                    </tr>-->
					<?php
					}
					?>
					<!--<tr>
                <td width="10%" align="left" valign="top" style="padding:5px;"><span class="red_star"></span>Meta Title</td>
                <td width="90%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_MetaTitle"></div><input name="MetaTitle" type="text" class="formfld" id="MetaTitle" value="<?php echo $metaTags;  ?>" style="width: 484px;"  onkeyup="hideerrordiv(this.id);" /><br />
(Maximum Characters 60)</td>
              </tr>
					<tr>
                <td width="10%" align="left" valign="top" style="padding:5px;"><span class="red_star"></span>Meta Description</td>
                <td width="90%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_meta_description"></div><textarea name="meta_description" id="meta_description"  onkeyup="hideerrordiv(this.id);" cols="50" rows="7" style="width:487px;"><?php echo $meta_description; ?></textarea><br />
(Maximum Characters 250)</td>
              </tr>-->
					<?php
						if($_GET["id"]!=186)
						{
							 if($action=="edit" && $uploadedFileName!='')
							 {
					 ?>
                   <!-- <tr>
                      <td></td>
                      <td width="81%" align="left"  valign="top" style="padding:5px;"><img src="../uploads/<?php echo $uploadedFileName; ?>" border="0" title="<?php echo $menuName; ?>" width="200" /> </td>
                    </tr>-->
                    <?php } ?>
                    <!--<tr>
                      <td align="left" valign="top" style="padding:5px;">Upload Image</td>
                      <td align="left" valign="top" style="padding:5px;"><input name="bannerfield" type="file" id="bannerfield" onchange="hideerrordiv(this.id);" /> &nbsp;&nbsp;
                        <?php if ($action=="edit" && $uploadedFileName!=''){ ?>
                        <input name="Submit3" type="submit" class="bluebutton" value="Remove Image" />
                        <input name="txtAction" type="hidden" id="txtAction" value="delete" />
                        <?php } ?>                      </td>
                    </tr>-->  <tr>
                      <td align="left" valign="top" style="padding:5px;">&nbsp;</td>
                      <td align="left" valign="top" style="padding:5px;">&nbsp;</td>
                    </tr>
                    <?php 
							}
					}
					else if(trim($_GET['type'])=='listing')
					{
						if($_GET["id"]==233 || $_GET["id"]==236 || $_GET["id"]==238)
						{
					?>
                    <tr>
                      <td width="19%" style="padding:5px;"> Page URL </td>
                      <td width="81%" style="padding:5px;"><input name="pageUrl" type="text" class="formfld" id="pageUrl" value="<?php echo stripslashes($pageUrl); ?>" size="48"  onkeyup="hideerrordiv(this.id);" /></td>
                    </tr>
                    <?php 
						}
					}
					?>
                    <tr>
                      <td style="padding:5px;">&nbsp;</td>
                      <td style="padding:5px;"><?php if ($action=="edit"){ ?>
                        <input name="Submit2" type="submit" class="bluebutton" value="Update" />
                        <input name="txtAction" type="hidden" id="txtAction" value="<?php echo $action; ?>" />
                        <input name="txtParam1" type="hidden" id="txtParam1" value="<?php echo $id; ?>" />
                        <input name="txtOldFile" type="hidden" id="txtOldFile" value="<?php echo $uploadedFileName; ?>" />
                        <?php } ?>
                        <input type="button" name="back" value="<< back" class="bluebutton" onclick="javascript: window.location.href='manage_menuct.php';"  />                      </td>
                    </tr>
                  </table>
                </form></td>
              <td width="1%" align="left" valign="top">&nbsp;&nbsp;</td>
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



	$("#frmMenu").submit(function()
	{



		var errorFldArray=[];



		var allFldArray=["menuName"];



		if($("#menuName").val().trim()=='')

		{

			errorFldArray.push(['menuName@@@Please enter page Title!']);

		}


		for (var i = 0; i < allFldArray.length; i++)

		{


			$('#fld_'+allFldArray[i]).css('display','none');



			$('#allErrorMsg').css('display','none');



		}




		for (var i = 0; i < errorFldArray.length; i++)

		{

			$('#allErrorMsg').css('display','block');



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



$('#menuName').focus();



</script>
</body>
</html>
