<?php 
include_once('../codelibrary/inc/constants-defined.inc.php');
include_once('../codelibrary/inc/database.inc.php');
include_once('../codelibrary/inc/functions.inc.php');
include_once('../codelibrary/inc/check-admin-session.php');
$pageIndex=5;

openConn();
$showInNeList=1;
$action="add";
$btnValue='Submit';

if($_GET["editid"]!='' && $_GET["editid"]!=0 && is_numeric($_GET["editid"]))
{
	unset($selectFields);
	unset($whereFields);
	unset($whereVals);
	$sqlEdit="";
	$sqlEdit="Select * from "._RESOURCES_TABLE_." where resourceId=".$_GET["editid"];
	$resNews=getRecords(_RESOURCES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEdit);
	if($resNews)
	{
		while($rowNews=mysql_fetch_array($resNews))
		{
			$resourceId=trim($rowNews["resourceId"]);
			$resourceTitle=$rowNews["resourceTitle"];
			$resourceFile=trim($rowNews["resourceFile"]);
			$shortDescription=trim($rowNews["shortDescription"]);
			$description=$rowNews["description"];
			$pageType=trim($rowNews["pageType"]);
			$resourceUrl=$rowNews["resourceUrl"];
		}
		$btnValue='Update';
		$action="edit";
	}
	
}
if(isPost())
{
		$errorMsg='';
		$pageType='news';
		$action=$_POST["txtAction"];
	
		$resourceTitle=clean($_POST["resourceTitle"]);		
		$shortDescription=clean($_POST["txtShortDescription"]);		
		$description=clean($_POST["txtDescription"]);
		
		if(trim($description)=='')
		{
			$errorMsg="Please enter description";
		}
		if(trim($resourceTitle)=='')
		{
			$errorMsg="Please enter title name";
		}
		if(trim($resourceTitle)!='')
		{
			$resourceUrl=makeContentUrl($resourceTitle);
		}
		
				
		if(trim($errorMsg)=='')
		{
					if(!empty($_FILES["txtResourceFile"]["name"]))
					{
						$extArray=strtolower(end(explode(".", $_FILES["txtResourceFile"]["name"])));
						if($extArray=='png' || $extArray=='jpg' || $extArray=='jpeg' || $extArray=='gif')
						{
							$size=filesize($_FILES['txtResourceFile']['tmp_name']);
							
							if ($size > 8388608*1024)
							{
								$errorMsg="Please upload File size of upto 8 MB!<br>";
							}
							else
							{
								$resourceFile=rand(0,99).date("Ymdsi");
								$resourceFile=$resourceFile.".".$extArray;
								
									
								$filePath=$_FILES['txtResourceFile']['tmp_name'];
								$imageUploaded=false;
								chmod("../uploads/", 0777);  // octal; correct value of mode
								$imageUploaded=uploadImage($filePath,"../uploads/".$resourceFile);
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
							$resourceFile=$_POST["txtOldFile"];
					}
					else
					{
						//$errorMsg="Please upload .png, .jpg, .jpeg, .gif, files only.";
					}
			}
		
	if(trim(strtolower($action))=="add")
	{
		
			unset($selectFields);
			unset($whereFields);
			unset($whereVals);
	
			$sqlURLcheck="";
			$sqlURLcheck="Select resourceUrl from "._RESOURCES_TABLE_." where pageType='news' and resourceUrl='".$resourceUrl."' ";
			$resURLcheck=getRecords(_RESOURCES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlURLcheck);
			if($resURLcheck)
			{
				$errorMsg="URL '".$resourceUrl."' already exists in database. Please enter another URL";
			}
	
		
		
		if(trim($errorMsg)=='')
		{							
				
				unset($insertFields);
				unset($insertVals);
				
				$insertFields[0]="resourceTitle";
				$insertFields[1]="description";
				$insertFields[2]="resourceFile";
				$insertFields[3]="dateAdded";
				$insertFields[4]="pageType";
				$insertFields[5]="resourceUrl";
				$insertFields[6]="shortDescription";
				
				$insertVals[0]=$resourceTitle;
				$insertVals[1]=$description;
				$insertVals[2]=$resourceFile;
				$insertVals[3]=time();
				$insertVals[4]=$pageType;
				$insertVals[5]=$resourceUrl;
				$insertVals[6]=$shortDescription;
				
				$resMenuInsert=insertDB(_RESOURCES_TABLE_,$insertFields,$insertVals,_N_,'');
				$resourceId=$resMenuInsert;			
				
				header("location:list-news.php?success=1");
				exit();					
		
		}
		
		
	
	}	
	else if(trim(strtolower($action))=="edit")
	{
		
		$resourceId=$_POST["txtParam1"];		
		
		unset($selectFields);
		unset($whereFields);
		unset($whereVals);

		$sqlURLcheck="";
		$sqlURLcheck="Select resourceUrl from "._RESOURCES_TABLE_." where pageType='news' and resourceUrl='".$resourceUrl."' and resourceId!=".$resourceId." ";
		$resURLcheck=getRecords(_RESOURCES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlURLcheck);
		if($resURLcheck)
		{
			$errorMsg="URL '".$resourceUrl."' already exists in database. Please enter another URL";
		}
		
		if(trim($errorMsg)=='')
		{
			unset($insertFields);
			unset($insertVals);
			unset($whereFields);
			unset($whereVals);

			$insertFields[0]="resourceTitle";
			$insertFields[1]="description";
			$insertFields[2]="resourceFile";
			$insertFields[3]="shortDescription";
			$insertFields[4]="pageType";
			$insertFields[5]="resourceUrl";
			
			$insertVals[0]=$resourceTitle;
			$insertVals[1]=$description;
			$insertVals[2]=$resourceFile;
			$insertVals[3]=$shortDescription;
			$insertVals[4]=$pageType;
			$insertVals[5]=$resourceUrl;
		
			$whereFields[0]="resourceId";			
			$whereVals[0]=$resourceId;			
			$resBuilderUpdate=updateDB(_RESOURCES_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');
			
			header("location:list-news.php?success=2");
			exit();
			
		
		}
	
	 }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo ucfirst($action); ?> News</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link href="css/validate.css" rel="stylesheet" type="text/css" />
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="../codelibrary/js/jquery-ui-1.9.1.custom.js"></script>
<script language="JavaScript" type="text/javascript" src="../codelibrary/ckeditor/ckeditor.js"></script>
<script language="JavaScript" type="text/javascript" src="../codelibrary/ckeditor/ckfinder/ckfinder.js"></script>

<script type="text/javascript" language="javascript">
		$(function() {
			$('#resourceDate').datepicker({dateFormat: 'dd-mm-yy'});
		});
</script>
</head>
<body id="homeinnerbg">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10%" align="left" valign="top" style="width:156px;"><?php include("left.php"); ?>
    </td>
    <td width="90%" align="left" valign="top"><div id="rightbody">
        <?php include("header.php"); ?>
        <div class="rightbodysec">
          <h1><?php echo ucfirst($action); ?> News</h1>
        </div>
        <div class="rightbodysec">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="28%" align="left" valign="top"><form action="" method="post" enctype="multipart/form-data" name="frmResources" id="frmResources">
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
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            
                            <tr>
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span>Title</td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_resourceTitle"></div>
                                <input name="resourceTitle" type="text" id="resourceTitle" value="<?php echo $resourceTitle; ?>"  class="fiellength" onkeyup="hideerrordiv(this.id);" /></td>
                            </tr>
                           
                          <!-- <tr>
									  <td width="18%" valign="top" style="padding:5px;"><span class="red_star">*</span>Short Description</td>
									  <td width="82%" style="padding:5px;"><div class="erorfldcls" id="fld_txtShortDescription"></div>
						     <textarea name="txtShortDescription" id="txtShortDescription"  onkchange="hideerrordiv(this.id);"><?php echo $shortDescription; ?></textarea>
							  <script type="text/javascript">
	                var editor = CKEDITOR.replace('txtShortDescription');
					CKFinder.setupCKEditor( editor,'<?php echo _CKFINDER_PATH_; ?>' ) ;
                </script></td>
						    </tr>-->
                            <tr>
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span>Description </td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_txtDescription"></div>
                                <textarea name="txtDescription" id="txtDescription"  onkchange="hideerrordiv(this.id);" <?php echo $editorcr;?>><?php echo $description; ?></textarea>
                                <script type="text/javascript">
	                var editor = CKEDITOR.replace('txtDescription');
					CKFinder.setupCKEditor( editor,'<?php echo _CKFINDER_PATH_; ?>' ) ;
                </script></td>
                            </tr>
							 <?php if ($action=="edit" && $resourceFile!=''){ ?>
                                
							<tr>
                              <td align="left" valign="top" style="padding:5px;"><span class="red_star"></span>Uploaded Image</td>
                              <td align="left" valign="top" style="padding:5px;"><img src="../uploads/<?php echo trim($resourceFile); ?>" height="100" width="150"></td>
                            </tr>
                            <?php } ?>
							<tr>
                              <td align="left" valign="top" style="padding:5px;"><span class="red_star"></span>Upload Image</td>
                              <td align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_txtResourceFile"></div>
                                <input name="txtResourceFile" type="file" id="txtResourceFile"  accept=".png, .jpg, .jpeg, .gif" onchange="hideerrordiv(this.id);" />
                               </td>
                            </tr>
                             
                          </table>
                        </td>
                    </tr>
                   
                   
                    <tr>
                      <td align="left" valign="top" style="padding:5px;">&nbsp;</td>
                      <td align="left" valign="top" style="padding:5px;">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" style="padding:5px;"><input name="txtAction" type="hidden" id="txtAction" value="<?php echo $action; ?>" />
                        <input type="hidden" name="txtParam1" id="txtParam1" value="<?php echo $_GET["editid"]; ?>" />
                        <input name="txtOldFile" type="hidden" id="txtOldFile" value="<?php echo $resourceFile; ?>" />             </td>
                      <td align="left" valign="top" style="padding:5px;"><input name="Submit2" type="submit" class="bluebutton" value="<?php echo $btnValue; ?>" />
                        &nbsp;&nbsp;
                        <input name="button" type="button" class="bluebutton" value="<< Back"  onclick="javascript: window.location.href='list-news.php';"/>                      </td>
                    </tr>
                  </table>
                </form></td>
            </tr>
          </table>
        </div>
      </div></td>
  </tr>
</table>

</body>
</html>
