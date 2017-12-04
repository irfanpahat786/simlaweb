<?php 
include_once('../codelibrary/inc/constants-defined.inc.php');
include_once('../codelibrary/inc/database.inc.php');
include_once('../codelibrary/inc/functions.inc.php');
include_once('../codelibrary/inc/check-admin-session.php');
$pageIndex=188;

openConn();

$action="add";
$btnValue='Submit';
if($_GET["editid"]!='' && is_numeric($_GET["editid"]))
{
	
	unset($selectFields);
	unset($whereFields);
	unset($whereVals);
	
	$sqlEdit="";
	$sqlEdit="Select * from "._MEMBERS_TABLE_." where memberId=".$_GET["editid"];
	$resNews=getRecords(_MEMBERS_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEdit);
	if($resNews)
	{
		while($rowNews=mysql_fetch_array($resNews))
		{
			$memberId=trim($rowNews["memberId"]);
			$mainMenuId=trim($rowNews["mainMenuId"]);
			$memberName=$rowNews["memberName"];
			$uploaded_file=trim($rowNews["uploaded_file"]);
			$description=$rowNews["description"];
			$pdf_uploaded_file=$rowNews["pdf_uploaded_file"];
			$designation=$rowNews["designation"];
			$pageTypeMember=$rowNews["pageTypeMember"];
			$phone_number=$rowNews["phone_number"];
			$email_address=$rowNews["email_address"];
			$location=$rowNews["location"];
			$sortOrder=$rowNews["sortOrder"];
		}
		$btnValue='Update';
		$action="edit";
	}
	
}
if(isPost())
{
		$errorMsg='';
		$action=$_POST["txtAction"];
		
		$pageTypeMember=trim($_POST["pageTypeMember"]);
		
		$memberId=$_POST["txtParam1"];
				
		
			$memberName=clean($_POST["txtName"]);

			$phone_number=trim($_POST["phone_number"]);
			$email_address=trim($_POST["email_address"]);
			$description=addslashes($_POST["description"]);
			$designation=addslashes($_POST["designation"]);
			$mainMenuId=clean($_POST["mainMenuId"]);
			$sortOrder=clean($_POST["sortOrder"]);

		
			if(trim($description)=='')
			{
				$errorMsg="Please enter profile description !";
			}
			if(trim($designation)=='')
			{
				$errorMsg="Please enter designation !";
			}
		
			if(trim($email_address)=='')
			{
				$errorMsg="Please enter email address !";
			}
			if(trim($phone_number)=='')
			{
				$errorMsg="Please enter phone snumber !";
			}
			if(trim($memberName)=='')
			{
				$errorMsg="Please enter name !";
			}
		
			if(trim($pageTypeMember)=='' || trim($pageTypeMember)=='0')
			{
				$errorMsg="Please select member type !";
			}
			
			if($memberName!='')
			{
				$resourceUrl=makeContentUrl($memberName);
			}
			
			unset($selectFields);
			unset($whereFields);
			unset($whereVals);
			$sqlEdit1="";
			$sqlEdit1="Select memberId,resourceUrl from "._MEMBERS_TABLE_." where resourceUrl='".$resourceUrl."' ";
			$resNews1=getRecords(_MEMBERS_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEdit1);
			if(mysql_num_rows($resNews1)>0)
			{
				if($memberId!='' || $memberId!=0 && is_numeric($memberId))
				{
					while($rowNews1=mysql_fetch_array($resNews1))
					{
						$existsmemberId=trim($rowNews1["memberId"]);
						$existsResourceUrl=trim($rowNews1["resourceUrl"]);
					}
					if($existsResourceUrl==$resourceUrl && $existsmemberId==$memberId)
					{
						$resourceUrl=$existsResourceUrl;
					}
					else
					{
						$strLastId='-'.$memberId;	
						$resourceUrl=$resourceUrl.$strLastId;	
					}
				}
				else
				{
					unset($selectFields);
					unset($whereFields);
					unset($whereVals);
					$sqlEdit12="";
					$sqlEdit12="SELECT AUTO_INCREMENT AS id FROM information_schema.tables WHERE table_name = '"._MEMBERS_TABLE_."'";
					$resNews12=getRecords(_MEMBERS_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEdit12);
					if(mysql_num_rows($resNews12)>0)
					{
						while($rowNews12=mysql_fetch_array($resNews12))
						{
							$last_id=trim($rowNews12["id"]);
							$strLastId='-'.$last_id;
							$resourceUrl=$resourceUrl.$strLastId;	
						}
					}
				}
				
				
				
			}
			
			
			if(trim($errorMsg)=='')
			{
					if(!empty($_FILES["txtuploaded_file"]["name"]))
					{
						$extArray=strtolower(end(explode(".", $_FILES["txtuploaded_file"]["name"])));
						if($extArray=='jpg' || $extArray=='gif' || $extArray=='jpeg' || $extArray=='png')
						{
							$size=filesize($_FILES['txtuploaded_file']['tmp_name']);
							
							if ($size > MAX_SIZE*1024)
							{
								$errorMsg="Please upload File size of upto 2 MB!<br>";
							}
							else
							{
								$uploaded_file=rand(0,99).date("Ymdsi");
								$uploaded_file=$uploaded_file.".".$extArray;
								
									
								$filePath=$_FILES['txtuploaded_file']['tmp_name'];
								$imageUploaded=false;
								chmod("../uploads/", 0777);  // octal; correct value of mode
								$imageUploaded=uploadImage($filePath,"../uploads/".$uploaded_file);
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
							$errorMsg="Please upload .jpg, .gif, .jpeg, .png, etc.  files only.";
						}	
					}
					else if(trim($_POST["txtOldFile"])!='')
					{
							$uploaded_file=$_POST["txtOldFile"];
					}
					else
					{
						//$errorMsg="Please upload .jpg, .gif, .jpeg, .png, etc.  files only.";
					}
			}
		
			if(trim(strtolower($action))=="add")
			{
		
		
				if(trim($errorMsg)=='')
				{							
						
						unset($insertFields);
						unset($insertVals);
						
						$insertFields[0]="memberName";
						$insertFields[1]="description";
						$insertFields[2]="uploaded_file";
						$insertFields[3]="pdf_uploaded_file";
						$insertFields[4]="dateAdded";
						$insertFields[5]="mainMenuId";
						$insertFields[6]="resourceUrl";
						$insertFields[7]="designation";
						$insertFields[8]="pageTypeMember";
						$insertFields[9]="phone_number";
						$insertFields[10]="email_address";
						$insertFields[11]="location";
						$insertFields[12]="sortOrder";
						
						$insertVals[0]=$memberName;
						$insertVals[1]=$description;
						$insertVals[2]=$uploaded_file;
						$insertVals[3]=$pdf_uploaded_file;
						$insertVals[4]=time();
						$insertVals[5]=$mainMenuId;
						$insertVals[6]=$resourceUrl;
						$insertVals[7]=$designation;
						$insertVals[8]=$pageTypeMember;
						$insertVals[9]=$phone_number;
						$insertVals[10]=$email_address;
						$insertVals[11]=$location;
						$insertVals[12]=$sortOrder;
						
						$resMenuInsert=insertDB(_MEMBERS_TABLE_,$insertFields,$insertVals,_N_,'');
						$memberId=$resMenuInsert;
						
						
						header("location:list-members.php?success=1");
						exit();
						
						
				
				}
				
				
			
			}	
			else if(trim(strtolower($action))=="edit")
			{
				
				if(trim($errorMsg)=='')
				{
				
		
					unset($insertFields);
					unset($insertVals);
					unset($whereFields);
					unset($whereVals);
		
					$insertFields[0]="memberName";
					$insertFields[1]="description";
					$insertFields[2]="uploaded_file";
					$insertFields[3]="pdf_uploaded_file";
					$insertFields[4]="dateModify";
					$insertFields[5]="mainMenuId";
					$insertFields[6]="resourceUrl";
					$insertFields[7]="designation";
					$insertFields[8]="pageTypeMember";
					$insertFields[9]="phone_number";
					$insertFields[10]="email_address";
					$insertFields[11]="location";
					$insertFields[12]="sortOrder";
					
					$insertVals[0]=$memberName;
					$insertVals[1]=$description;
					$insertVals[2]=$uploaded_file;
					$insertVals[3]=$pdf_uploaded_file;
					$insertVals[4]=time();
					$insertVals[5]=$mainMenuId;
					$insertVals[6]=$resourceUrl;
					$insertVals[7]=$designation;
					$insertVals[8]=$pageTypeMember;
					$insertVals[9]=$phone_number;
					$insertVals[10]=$email_address;
					$insertVals[11]=$location;
					$insertVals[12]=$sortOrder;
				
					$whereFields[0]="memberId";
					
					$whereVals[0]=$memberId;
					
					$resBuilderUpdate=updateDB(_MEMBERS_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');
					
					header("location:list-members.php?success=2");
					exit();
					
				
				}
			
			}
}

$divPagesFields='display:table-row;';
$divReportPublicationFields='display:none;';
if($pageTypeMember=="1" || $pageTypeMember=="2")
{
 $divPagesFields='display:table-row;';
 $divReportPublicationFields='display:none;';
}
else if($pageTypeMember=="3")
{
 $divPagesFields='display:none;';
 $divReportPublicationFields='display:table-row;';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo ucfirst($action); ?> Testimonials</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link href="css/validate.css" rel="stylesheet" type="text/css" />
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="../codelibrary/js/jquery-ui-1.9.1.custom.js"></script>
<script language="JavaScript" type="text/javascript" src="../codelibrary/ckeditor/ckeditor.js"></script>
<script language="JavaScript" type="text/javascript" src="../codelibrary/ckeditor/ckfinder/ckfinder.js"></script>
<!--<script src="../js/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
	 myNicEditor = new nicEditor({iconsPath : 'nicEditorIcons.gif',fullPanel : true}).panelInstance('description');
});

</script>-->

</head>
<body id="homeinnerbg">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10%" align="left" valign="top" style="width:156px;"><?php include("left.php"); ?>
    </td>
    <td width="90%" align="left" valign="top"><div id="rightbody">
        <?php include("header.php"); ?>
        <div class="rightbodysec">
          <h1><?php echo ucfirst($action); ?> Testimonials</h1>
        </div>
        <div class="rightbodysec">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="28%" align="left" valign="top"><form action="" method="post" enctype="multipart/form-data" name="frmMembers" id="frmMembers">
                  
                  <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="mainbordersec">
                    <?php
					if($errorMsg!='')
					{
					?>
                    <tr>
                      <td colspan="2" align="center" valign="top" class="red_error" style="padding:5px;"><?php echo $errorMsg; ?></td>
                    </tr>
                    <?php
					  }
					 ?>
                    
                    <tr>
                      <td align="left" valign="top" style="padding:5px;" colspan="2">
                        <div id="divNewsLetters" style=" <?php //echo $divNewsLetters; ?> ">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
						  
						  <!--<tr>
                      <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span> Member type </td>
                      <td width="82%" align="left" valign="top"><div class="erorfldcls" id="fld_pageTypeMember"></div>
					  <input type="radio" name="pageTypeMember" id="pageTypeMember" value="1" onchange="showHideFormFieldsFunc(this.value); hideerrordiv(this.id);" style="opacity: 1;" <?php if($pageTypeMember==1 || $pageTypeMember=='') echo "checked"; ?> />Leadership/JBG Members&nbsp;&nbsp; <input type="radio" name="pageTypeMember" id="pageTypeMember" value="2" onchange="showHideFormFieldsFunc(this.value); hideerrordiv(this.id);" style="opacity: 1;" <?php if($pageTypeMember==2) echo "checked"; ?> />Reports/Publications Members&nbsp;&nbsp;<div class="mandatoryfields"><span class="red_star">*</span>Indicates mandatory fields</div></td>
                    </tr>-->
                            
				  <!-- <tr>
						  <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span> Member type </td>
						  <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_pageTypeMember"></div>
							<select name="pageTypeMember" id="pageTypeMember"  onchange="showHideFormFieldsFunc(this.value); hideerrordiv(this.id);" style="  width:240px;" >
							  <option value="0" <?php if($pageTypeMember=="0"){ ?>selected="selected"<?php } ?>> Select Member type </option>
							  <option value="1" <?php if($pageTypeMember=="1"){ ?>selected="selected"<?php } ?>> Leadership </option>
							  <option value="2" <?php if($pageTypeMember=="2"){ ?>selected="selected"<?php } ?>> JBG </option>
							  <option value="3" <?php if($pageTypeMember=="3"){ ?>selected="selected"<?php } ?>> Reports/Publications </option>
							  
							</select></td>
						</tr> --> 
						  
                     <tr  id="divPagesFields" style=" <?php echo $divPagesFields;?> ">
                      <td align="left" valign="top" colspan="2">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
						  
						  <tr>
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span>  Name</td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_txtName"></div>
                                <input name="txtName" type="text" id="txtName" value="<?php echo $memberName; ?>"  class="fiellength" onkeyup="hideerrordiv(this.id);" style="width: 877px !important;"/></td>
                            </tr>
							
                             <tr>
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span> Phone</td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_phone_number"></div>
                                <input name="phone_number" type="text" id="phone_number" value="<?php echo $phone_number; ?>"  class="fiellength" onkeyup="hideerrordiv(this.id);" style="width: 877px !important;"/></td>
                            </tr>
							
							 <tr>
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span> Email</td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_email_address"></div>
                                <input name="email_address" type="text" id="email_address" value="<?php echo $email_address; ?>"  class="fiellength" onkeyup="hideerrordiv(this.id);" style="width: 877px !important;"/></td>
                            </tr>
							<tr>
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span> Designation </td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_designation"></div>
                                <input name="designation" type="text" id="designation" value="<?php echo $designation; ?>"  class="fiellength" onkeyup="hideerrordiv(this.id);" style="width: 877px !important;"/></td>
                            </tr>
							
                            <tr>
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span> Profile </td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_description"></div>
                                <textarea name="description" id="description"  onkchange="hideerrordiv(this.id);" <?php echo $editorcr;?>><?php echo $description; ?></textarea>
                                <script type="text/javascript">
	                var editor = CKEDITOR.replace('description');
					CKFinder.setupCKEditor( editor,'<?php echo _CKFINDER_PATH_; ?>' ) ;
                </script></td>
                            </tr>
                          </table>
						  </td>
						  </tr>
						  
						  
                           <tr>
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star"></span>Photo </td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_txtuploaded_file"></div>
                                <input name="txtuploaded_file" type="file" id="txtuploaded_file" onchange="hideerrordiv(this.id);" /><br />
(.jpeg, .jpg, .gif, .png image only)</td>
                            </tr>
							<?php if ($action=="edit" && $uploaded_file!=''){ ?>
                           <tr>
                      <td align="left" valign="top" style="padding:5px;">&nbsp;</td>
                      <td align="left" valign="top" style="padding:5px;"> <img src="../uploads/<?php echo $uploaded_file; ?>" border="0" title="<?php echo $memberName; ?>" width="96" height="100" /></td>
                    </tr>
					 <?php } ?> <tr>
                              <td width="18%" align="left" valign="top" style="padding:5px;"> Order </td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_sortOrder"></div>
                                <input name="sortOrder" type="number" id="sortOrder" value="<?php echo $sortOrder; ?>"  class="fiellength" onkeyup="hideerrordiv(this.id);" style="width: 877px !important;"/></td>
                            </tr>
                       <tr>
                      <td align="left" valign="top" style="padding:5px;">&nbsp;</td>
                      <td align="left" valign="top" style="padding:5px;">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" style="padding:5px;">&nbsp;</td>
                      <td align="left" valign="top" style="padding:5px;"><input name="txtAction" type="hidden" id="txtAction" value="<?php echo $action; ?>" />
                        <input type="hidden" name="txtParam1" id="txtParam1" value="<?php echo $_GET["editid"]; ?>" />
                        <input name="txtOldFile" type="hidden" id="txtOldFile" value="<?php echo $uploaded_file; ?>" />
						<input name="Submit2" type="submit" class="bluebutton" value="<?php echo $btnValue; ?>" /><input type="hidden" name="pageTypeMember" id="pageTypeMember" value="1" />
                        &nbsp;&nbsp;
                        <input name="button" type="button" class="bluebutton" value="<< Back"  onclick="javascript: window.location.href='list-members.php';"/>
                      </td>
                    </tr>                
                             
                          </table>
                        </div></td>
                    </tr>
                    
                    

                  </table>
                </form></td>
            </tr>
          </table>
        </div>
      </div></td>
  </tr>
</table>
<script language="javascript" type="text/javascript">
function showHideFormFieldsFunc(val)
{
	if(val==3)
	{
		
		/*document.getElementById('divPagesFields').style.display='none';
		document.getElementById('divReportPublication').style.display='table-row';*/
		/*document.getElementById('open_in_tab').style.display='none';*/
	}
	else if(val==1 || val==2)
	{
		document.getElementById('divPagesFields').style.display='table-row';
		document.getElementById('divReportPublication').style.display='none';
/*		document.getElementById('pdfonly').style.display='none';*/
	}
	else
	{
		//document.getElementById('divPagesFields').style.display='none';
		//document.getElementById('divReportPublication').style.display='none';
		/*document.getElementById('open_in_tab').style.display='none';*/
	}
}
</script>
<script language="javascript" type="text/javascript">
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

function isValidEmailStrict(address)
{



	var hasError = false;



	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;







	var emailaddressVal = address;	



	



	if(!emailReg.test(emailaddressVal))



	{



		hasError = true;



	}







	if(hasError == true)



	{



		return false;



	}



	else



		return true;



	



}
$(document).ready(function()
{
	$("#frmMembers").submit(function()
	{

		var errorFldArray=[];

		var allFldArray=["pageTypeMember","txtName","description","txtuploaded_file","txtOldFile","designation","phone_number","email_address"];
			
			   //var pageTypeMember = $("input[name='pageTypeMember']:checked").val();var pageTypeMember = $("input[name='pageTypeMember']:checked").val();
			   //alert(pageTypeMember);

			   
				var pageTypeMember = $("#pageTypeMember").val();
				//alert(pageTypeMember);
				if(pageTypeMember=='' || pageTypeMember==0)
				{
					errorFldArray.push(['pageTypeMember@@@Please select member type !']);
				}
				
					//alert($("#description").val());
					if($("#description").val()=='' || $("#description").val()=='<br>')
					{
						errorFldArray.push(['description@@@Please enter profile description!']);
					}
				  
				    if($("#txtName").val()=='')
					{
						errorFldArray.push(['txtName@@@Please enter name !']);
					}
					
					if($("#phone_number").val()=='')
					{
						errorFldArray.push(['phone_number@@@Please enter phone number !']);
					}
					if($("#designation").val()=='')
					{
						errorFldArray.push(['designation@@@Please enter designation !']);
					}
					if($("#email_address").val()=='')
					{
						errorFldArray.push(['email_address@@@Please enter email address !']);
					}
					else
					{
						if($("#email_address").val().trim()!='')
						{
							if(!isValidEmailStrict($("#email_address").val().trim()))
							{
								errorFldArray.push(['email_address@@@Please enter valid Email!']);
							}
						}
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


$("#mainMenuId").focus();
</script>
</body>
</html>
