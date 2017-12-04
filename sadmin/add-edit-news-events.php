<?php 
include_once('../codelibrary/inc/constants-defined.inc.php');
include_once('../codelibrary/inc/database.inc.php');
include_once('../codelibrary/inc/functions.inc.php');
include_once('../codelibrary/inc/check-admin-session.php');
$pageIndex=7;

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
			$resourceType=trim($rowNews["resourceType"]);
			$resourceTitle=$rowNews["resourceTitle"];
			$resourceFile=trim($rowNews["resourceFile"]);
			$resourceFile2=trim($rowNews["resourceFile2"]);
			$finalresourceDate=trim($rowNews["resourceDate"]);
			$expresourceDate=explode("-",$finalresourceDate);
			$resourceDate=$expresourceDate[2]."-".$expresourceDate[1]."-".$expresourceDate[0];
			$shortDescription=trim($rowNews["shortDescription"]);
			$description=$rowNews["description"];
			$metaKeywords=$rowNews["metaKeywords"];
			$videoLink=trim($rowNews["videoLink"]);
			$pageType=trim($rowNews["pageType"]);
			$coverFileName=trim($rowNews["coverFileName"]);
			$resourceFileSize=trim($rowNews["resourceFileSize"]);
			$homePageStatus=trim($rowNews["homePageStatus"]);
			$linkOpenTab=trim($rowNews["linkOpenTab"]);
			$linkType=trim($rowNews["linkType"]);
			$externalUrl=trim($rowNews["externalUrl"]);
			$resourceUrl=$rowNews["resourceUrl"];
			$categoryId=trim($rowNews["categoryId"]);
			$categoryIdArr=explode(",",$categoryId);
			

		
		}
		$btnValue='Update';
		$action="edit";
	}
	
}
if(isPost())
{
		$errorMsg='';
		$pageType=_NEWS_EVENTS_VALUE_;
		$action=$_POST["txtAction"];
	
		$resourceType=$_POST["txtResourceType"];
		$resourceTitle=clean($_POST["newsLetterTitle"]);		
		$shortDescription=clean($_POST["txtShortDescription"]);
		$resourceDate=clean($_POST["resourceDate"]);
	
		$linkType=clean($_POST["linkType"]);
			
		$homePageStatus=clean($_POST["homePageStatus"]);	
		$linkOpenTab=clean($_POST["linkOpenTab"]);
		$videoLink='';
		$resourceUrl=str_replace(" ","-",clean($_POST["resourceUrl"]));			
		$externalUrl=$_POST["externalUrl"];
		$metaKeywords=clean($_POST["txtKeywords"]);
		
		$strFieldWhere="";
		$strFieldWhereUrl="";
		if($linkType==1)
		{
			$strFieldWhere="and externalUrl = '".$externalUrl."'";
			$strFieldWhereUrl=$externalUrl;
		}
		elseif($linkType==2)
		{
			$strFieldWhere="and resourceUrl = '".$resourceUrl."'";
			$strFieldWhereUrl=$resourceUrl;
		}
		
		
		if($resourceTitle!='' && ($resourceType=="1" || $resourceType=="2"))
		{
			
			if($metaKeywords!='')
			{
				$metaKeywords=createMetaTags($resourceTitle,$metaKeywords);
			}
			else
			{	
				$metaKeywords=$resourceTitle;
			} 
			
		
				if(trim($resourceDate)=='')
				{
					$errorMsg="Please enter published date";
				}
				//if(trim($shortDescription)=='')
//				{
//					$errorMsg="Please enter short description";
//				}

				if($linkType=="1")
				{
					
					if(trim($externalUrl)=='')
					{
						$errorMsg="Please enter external URL";
					}
					
					if(trim($errorMsg)=='')
					{	
						$resourceFile=$_POST["txtOldFile"]='';
						$resourceFile2=$_POST["txtOldResourceFile2"]='';
						$resourceFileSize='';
						$resourceFileSize2='';
						$resourceUrl='';					
						$description='';
											
						if(trim($_POST["txtOldFile"])!='' && is_file("../news-events/".$_POST["txtOldFile"]))
						unlink("../news-events/".$_POST["txtOldFile"]);
						
						if(trim($_POST["txtOldResourceFile2"])!='' && is_file("../news-events/".$_POST["txtOldResourceFile2"]))
						unlink("../news-events/".$_POST["txtOldResourceFile2"]);
					}
				}
				else
				{
					    
						$description=clean($_POST["txtDescription"]);		
						//$externalUrl='';
						if(trim($resourceUrl)=='')
						{
							$errorMsg="Please enter URL";
						}
						
						if(trim($description)=='')
						{
							$errorMsg="Please enter description";
						}
				
				
				}
	
			}
			
		if(trim($resourceTitle)=='')
		{
			$errorMsg="Please enter title name";
		}
		
		if (strpos($resourceUrl, '#') !== false) {
			$errorMsg="Please enter valid article URL";
		}			

		if(count($_POST["categoryId"])<=0)
		{
			$errorMsg="Please select atleast one category";
		}
		if(trim($resourceType)=='')
		{
			$errorMsg="Please select atleast one News or Events";
		}
		
		if(count($_POST["categoryId"])>0)
		{	
			$categoryId='';
			for($k=0; $k<=count($_POST["categoryId"]);  $k++)
			{
				if(trim($_POST["categoryId"][$k])!='' && trim($_POST["categoryId"][$k])!='0')
				{
					if(is_numeric(trim($_POST["categoryId"][$k])))
					{
						$categoryId.=','.$_POST["categoryId"][$k];
					}
				}
			}
				$categoryId=trim($categoryId,',');
				$categoryIdArr=explode(",",$categoryId);
		}
		
	if(trim(strtolower($action))=="add")
	{
		if(trim($errorMsg)=='')
		{
			unset($selectFields);
			unset($whereFields);
			unset($whereVals);
	
			$sqlURLcheck="";
			$sqlURLcheck="Select resourceUrl from "._RESOURCES_TABLE_." where pageType='"._NEWS_EVENTS_VALUE_."'  ".$strFieldWhere." ";
			$resURLcheck=getRecords(_RESOURCES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlURLcheck);
			if($resURLcheck)
			{
				$errorMsg="URL '".$strFieldWhereUrl."' already exists in database. Please enter another URL";
			}
	
		}
		
		if(trim($errorMsg)=='')
		{	
			if(!empty($_FILES["txtResourceFile"]["name"]))
			{
				$extArray=strtolower(end(explode(".", $_FILES["txtResourceFile"]["name"])));
				if($extArray=='pdf')
				{
					$resourceFileSize=filesize($_FILES['txtResourceFile']['tmp_name']);
					
					if ($resourceFileSize >  8388608*1024)
					{
						$errorMsg="Please upload file size of upto 2 MB<br>";
					}
					else
					{
					
						/*
						unset($selectFields);
						unset($whereFields);
						unset($whereVals);
				
						$sqlFilecheck="";
						$sqlFilecheck="Select resourceFile from "._RESOURCES_TABLE_." where resourceFile = '".$_FILES["txtResourceFile"]["name"]."' ";
						$resFilecheck=getRecords(_RESOURCES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlFilecheck);
						if($resFilecheck)
						{
							$errorMsg="This file name '".$_FILES["txtResourceFile"]["name"]."' already exists in database. Please enter another URL";
						}*/
				
						$resourceFile=$resourceUrl.".".$extArray;
						/*$fileStatus=checkTempFileName('news-events',$resourceFile);
						if($fileStatus=='yes')
						{
							$errorMsg="Article URL file name '".$resourceFile."' already exists in database. Please enter another URL";
						}*/
						

						//if(trim($errorMsg)=='')
						//{
							//$resourceFile=rand(0,99).date("Ymdsi");
							//$resourceFile=$resourceFile.".".$extArray;	
							
							$resourceFile2=$_FILES["txtResourceFile"]["name"];	
							$filePath=$_FILES['txtResourceFile']['tmp_name'];
							$imageUploaded=false;
/*							chmod("../news-events/", 0777);  // octal; correct value of mode
							$imageUploaded=uploadImage($filePath,"../news-events/".$resourceFile2);
							$imageUploaded=uploadImage($filePath,"../news-events/".$resourceFile);
							chmod("../news-events/", 0755);  // octal; correct value of mode*/
							
							
							copy($_FILES['txtResourceFile']['tmp_name'],"../news-events/".$resourceFile2);
							$imageUploaded=copy($_FILES['txtResourceFile']['tmp_name'],"../news-events/".$resourceFile);
							
							if(!$imageUploaded)
								$errorMsg.="File not uploaded.<br>";
							else
							{
								/*if(trim($_POST["txtOldFile"])!='' && is_file("../news-events/".$_POST["txtOldFile"]))
									unlink("../news-events/".$_POST["txtOldFile"]);*/
							}
						
						//}
					}
				}
				else
				{
					$errorMsg="Please upload .pdf file only";
				}	
			}
			else if(trim($_POST["txtOldFile"])!='')
			{
				$resourceFile=$_POST["txtOldFile"];
				$resourceFile2=$_POST["txtOldResourceFile2"];
				$resourceFileSize=$_POST["resourceFileSize"];
			}
			else
			{
				//$errorMsg="Please upload .pdf file only";
			}
		
						
		}
		
		if(trim($errorMsg)=='')
		{							
				$expresourceDate=explode("-",$resourceDate);
				$resourceDate=$expresourceDate[2]."-".$expresourceDate[1]."-".$expresourceDate[0];
				
				unset($insertFields);
				unset($insertVals);
				
				$insertFields[0]="resourceTitle";
				$insertFields[1]="description";
				$insertFields[2]="resourceDate";
				$insertFields[3]="metaKeywords";
				$insertFields[4]="resourceFile";
				$insertFields[5]="dateAdded";
				$insertFields[6]="addedBy";
				$insertFields[7]="resourceType";
				$insertFields[8]="categoryId";
				$insertFields[9]="pageType";
				$insertFields[10]="coverFileName";
				$insertFields[11]="resourceFileSize";
				$insertFields[12]="homePageStatus";
				$insertFields[13]="resourceUrl";
				$insertFields[14]="linkOpenTab";
				$insertFields[15]="linkType";
				$insertFields[16]="dateModify";
				$insertFields[17]="resourceFile2";
				$insertFields[18]="shortDescription";
				$insertFields[19]="showInNeList";
				$insertFields[20]="externalUrl";
				
				$insertVals[0]=$resourceTitle;
				$insertVals[1]=$description;
				$insertVals[2]=$resourceDate;
				$insertVals[3]=$metaKeywords;
				$insertVals[4]=$resourceFile;
				$insertVals[5]=time();
				$insertVals[6]=$_SESSION["adminId"];
				$insertVals[7]=$resourceType;
				$insertVals[8]=$categoryId;
				$insertVals[9]=$pageType;
				$insertVals[10]=$coverFileName;
				$insertVals[11]=$resourceFileSize;
				$insertVals[12]=$homePageStatus;
				$insertVals[13]=$resourceUrl;
				$insertVals[14]=$linkOpenTab;
				$insertVals[15]=$linkType;
				$insertVals[16]=time();
				$insertVals[17]=$resourceFile2;
				$insertVals[18]=$shortDescription;
				$insertVals[19]=$showInNeList;
				$insertVals[20]=$externalUrl;
				
				$resMenuInsert=insertDB(_RESOURCES_TABLE_,$insertFields,$insertVals,_N_,'');
				$resourceId=$resMenuInsert;
				
				
				header("location:list-news-events.php?success=1");
				exit();
				
				
		
		}
		
		
	
	}	
	else if(trim(strtolower($action))=="edit")
	{
		
		$resourceId=$_POST["txtParam1"];
		
		if(trim($errorMsg)=='')
		{
			unset($selectFields);
			unset($whereFields);
			unset($whereVals);
	
			$sqlURLcheck="";
			$sqlURLcheck="Select resourceUrl from "._RESOURCES_TABLE_." where pageType='"._NEWS_EVENTS_VALUE_."' ".$strFieldWhere." and resourceId!=".$resourceId." ";
			$resURLcheck=getRecords(_RESOURCES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlURLcheck);
			if($resURLcheck)
			{
				$errorMsg="URL '".$strFieldWhereUrl."' already exists in database. Please enter another URL";
			}
	
		}
		
		
		if(trim($errorMsg)=='')
		{	
			if(!empty($_FILES["txtResourceFile"]["name"]))
			{
				$extArray=strtolower(end(explode(".", $_FILES["txtResourceFile"]["name"])));
				if($extArray=='pdf')
				{
					$resourceFileSize=filesize($_FILES['txtResourceFile']['tmp_name']);
					
					if ($resourceFileSize >  8388608*1024)
					{
						$errorMsg="Please upload file size of upto 2 MB<br>";
					}
					else
					{
					
						/*
						unset($selectFields);
						unset($whereFields);
						unset($whereVals);
				
						$sqlFilecheck="";
						$sqlFilecheck="Select resourceFile from "._RESOURCES_TABLE_." where resourceFile = '".$_FILES["txtResourceFile"]["name"]."' ";
						$resFilecheck=getRecords(_RESOURCES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlFilecheck);
						if($resFilecheck)
						{
							$errorMsg="This file name '".$_FILES["txtResourceFile"]["name"]."' already exists in database. Please try another.";
						}*/
				
						//$resourceFile='Untitled.png';
						$resourceFile=$resourceUrl.".".$extArray;
						/*$fileStatus=checkTempFileName('news-events',$resourceFile);
						if($fileStatus=='yes')
						{
							$errorMsg="Article URL file name '".$resourceFile."' already exists in database. Please try another.";
						}*/
						
						//print_r($fileStatus);
					
						//if(trim($errorMsg)=='')
						//{
							//$resourceFile=rand(0,99).date("Ymdsi");
							//$resourceFile=$resourceFile.".".$extArray;	
							
							$resourceFile2=$_FILES["txtResourceFile"]["name"];	
							
							if(trim($_POST["txtOldFile"])!='' && is_file("../news-events/".$_POST["txtOldFile"]))//delete old file in first
							{
								unlink("../news-events/".$_POST["txtOldFile"]);
							}
							
							if(trim($_POST["txtOldResourceFile2"])!='' && is_file("../news-events/".$_POST["txtOldResourceFile2"]))//delete old file in first
							{
								unlink("../news-events/".$_POST["txtOldResourceFile2"]);
							}	
								
							$filePath=$_FILES['txtResourceFile']['tmp_name'];
							$imageUploaded=false;
/*							chmod("../news-events/", 0777);  // octal; correct value of mode
							$imageUploaded=uploadImage($filePath,"../news-events/".$resourceFile2);
							$imageUploaded=uploadImage($filePath,"../news-events/".$resourceFile);
							chmod("../news-events/", 0755);  // octal; correct value of mode*/
							
							copy($_FILES['txtResourceFile']['tmp_name'],"../news-events/".$resourceFile2);
							$imageUploaded=copy($_FILES['txtResourceFile']['tmp_name'],"../news-events/".$resourceFile);
							
							if(!$imageUploaded)
								$errorMsg.="File not uploaded.<br>";
							else
							{
								/*if(trim($_POST["txtOldFile"])!='' && is_file("../news-events/".$_POST["txtOldFile"]))
									unlink("../news-events/".$_POST["txtOldFile"]);*/
									
							}
						
						//}
					}
				}
				else
				{
					$errorMsg="Please upload .pdf file only";
				}	
			}
			else if(trim($_POST["txtOldFile"])!='')
			{
				$resourceFile=$_POST["txtOldFile"];
				$resourceFile2=$_POST["txtOldResourceFile2"];
				$resourceFileSize=$_POST["resourceFileSize"];
			}
			else
			{
				//$errorMsg="Please upload .pdf file only";
			}
		
						
		}
		
		if(trim($errorMsg)=='')
		{
		
			$expresourceDate=explode("-",$resourceDate);
			$resourceDate=$expresourceDate[2]."-".$expresourceDate[1]."-".$expresourceDate[0];
		

			unset($insertFields);
			unset($insertVals);
			unset($whereFields);
			unset($whereVals);

			$insertFields[0]="resourceTitle";
			$insertFields[1]="description";
			$insertFields[2]="resourceDate";
			$insertFields[3]="metaKeywords";
			$insertFields[4]="resourceFile";
			$insertFields[5]="dateModify";
			$insertFields[6]="modifyBy";
			$insertFields[7]="resourceType";
			$insertFields[8]="categoryId";
			$insertFields[9]="pageType";
			$insertFields[10]="coverFileName";
			$insertFields[11]="resourceFileSize";
			$insertFields[12]="homePageStatus";
			$insertFields[13]="resourceUrl";
			$insertFields[14]="linkOpenTab";
			$insertFields[15]="linkType";
			$insertFields[16]="resourceFile2";
			$insertFields[17]="shortDescription";
			$insertFields[18]="showInNeList";
			$insertFields[19]="externalUrl";
			
			
			$insertVals[0]=$resourceTitle;
			$insertVals[1]=$description;
			$insertVals[2]=$resourceDate;
			$insertVals[3]=$metaKeywords;
			$insertVals[4]=$resourceFile;
			$insertVals[5]=time();
			$insertVals[6]=$_SESSION["adminId"];
			$insertVals[7]=$resourceType;
			$insertVals[8]=$categoryId;
			$insertVals[9]=$pageType;
			$insertVals[10]=$coverFileName;
			$insertVals[11]=$resourceFileSize;
			$insertVals[12]=$homePageStatus;
			$insertVals[13]=$resourceUrl;
			$insertVals[14]=$linkOpenTab;
			$insertVals[15]=$linkType;
			$insertVals[16]=$resourceFile2;
			$insertVals[17]=$shortDescription;
			$insertVals[18]=$showInNeList;
			$insertVals[19]=$externalUrl;

		
			$whereFields[0]="resourceId";
			
			$whereVals[0]=$resourceId;
			
			$resBuilderUpdate=updateDB(_RESOURCES_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');
			
			header("location:list-news-events.php?success=2");
			exit();
			
		
		}
	
	 }
}

$LinkURL='display:none;';
$divContentFields='display:table-row;';
$divarticleurlid='display:none;';
if($linkType=="1")
{
 $LinkURL='display:table-row;';
 $divContentFields='display:none;';
 $divarticleurlid='display:none;';
}
else
{
 $LinkURL='display:none;';
 $divContentFields='display:table-row;';
 $divarticleurlid='display:table-row;';
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo ucfirst($action); ?> News & Events</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link href="css/validate.css" rel="stylesheet" type="text/css" />
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="../codelibrary/js/jquery-ui-1.9.1.custom.js"></script>
<!--<script language="JavaScript" type="text/javascript" src="../codelibrary/ckeditor/ckeditor.js"></script>
<script language="JavaScript" type="text/javascript" src="../codelibrary/ckeditor/ckfinder/ckfinder.js"></script>-->

<script src="../js/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
	 myNicEditor = new nicEditor({iconsPath : 'nicEditorIcons.gif',fullPanel : true}).panelInstance('txtDescription');
});

</script>
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
          <h1><?php echo ucfirst($action); ?> News & Events</h1>
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
                      <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span>News & Events </td>
                      <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_txtResourceType"></div>&nbsp;
					  <input type="radio" name="txtResourceType" id="txtResourceType" value="1" onclick="hideerrordiv(this.id);" style="opacity: 1;" <?php if($resourceType==1) echo "checked"; ?> /><?php echo _NEWS_;?>&nbsp;&nbsp; <input type="radio" name="txtResourceType" id="txtResourceType" value="2" onclick="hideerrordiv(this.id);" style="opacity: 1;" <?php if($resourceType==2) echo "checked"; ?> /><?php echo _EVENTS_;?> &nbsp;&nbsp;<div class="mandatoryfields"><span class="red_star">*</span>Indicates mandatory fields</div></td>
                    </tr>
					
					<tr>
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span>Category</td>
                              <td width="82%" align="left" valign="top" style="padding:5px; padding-left:7px;"><div class="erorfldcls" id="fld_categoryId"></div>
                               <select name="categoryId[]" id="categoryId" multiple="multiple" onchange="hideerrordiv(this.id);" style="width:250px; height:120px; -webkit-appearance:none; background-color:#fff;">
                                  <option value="0" disabled="disabled" <?php if($categoryId=="0"){ ?>selected="selected"<?php } ?>>Select Category</option>
                                  <?php 
									unset($selectFields);
									unset($whereFields);
									unset($whereVals);
									
									$sqlNews='';
									$sqlNews="SELECT * FROM "._CATEGORIES_TABLE_."  WHERE validYN='Y' ORDER BY sortOrder ASC ";
									$resNews=getRecords(_CATEGORIES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlNews);
									if($resNews)
									{							
										while($res_News=mysql_fetch_array($resNews)){
												
												if(is_array($categoryIdArr))
												{
													if(in_array($res_News["categoryId"],$categoryIdArr))
														$strSelected="selected='selected'";
													else
														$strSelected="";
												}
												else
												{
													$strSelected="";
												}
									 ?>
																	  <option value="<?php echo $res_News['categoryId']; ?>"  <?php echo $strSelected; ?>><?php echo $res_News['categoryName']; ?></option>
																	  <?php 
															  
									}
									}
									?>
               				</select></td>
                    </tr>
					
                    <tr>
                      <td align="left" valign="top" style="padding:5px;" colspan="2">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            
                            <tr>
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span>Title</td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_newsLetterTitle"></div>
                                <input name="newsLetterTitle" type="text" id="newsLetterTitle" value="<?php echo $resourceTitle; ?>"  class="fiellength" onkeyup="hideerrordiv(this.id);" /></td>
                            </tr>
							<tr id="articleurlid" style=" <?php echo $divarticleurlid;?> ">
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span>Article URL</td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_resourceUrl"></div>
                              <input name="resourceUrl" type="text" id="resourceUrl" value="<?php echo $resourceUrl; ?>"  class="fiellength" onkeyup="hideerrordiv(this.id);" /></td>
                            </tr>
                            <tr>
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span>Published Date </td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_resourceDate"></div>
                                <input name="resourceDate" type="text" id="resourceDate" value="<?php echo $resourceDate; ?>"  class="fiellength" style="width: 240px !important;" onchange="hideerrordiv(this.id);" />
                                &nbsp;&nbsp;</td>
                            </tr>
                            <tr>
								<td width="18%" style="padding:5px;"><span class="red_star">*</span>URL/Content</td>
									  <td width="82%" style="padding:5px;"><div class="erorfldcls" id="fld_linkType"></div>
									  <select name="linkType" id="linkType" class="pro_textbox" onchange="showFooterdiv(this.value);hideerrordiv(this.id);" style="width:253px;">
		  							<option value="1" <?php if($linkType=='1') echo "selected";?>>URL</option>
									<option value="2" <?php if($linkType=='2' || $linkType=='') echo "selected";?>>Content</option>
							  </select> </td>
						    </tr>
							
							
							
				
			  
			  <tr id="open_in_tab" style=" <?php echo $divUrlFields;?> ">
                <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span>Open URL </td>
                <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_linkOpenTab"></div>
				<select name="linkOpenTab" id="linkOpenTab" class="pro_textbox" style="width:253px;" onchange="hideerrordiv(this.id);">
						<option value="1" <?php if($linkOpenTab=='1') echo "selected";?>>New window</option>
						<option value="2" <?php if($linkOpenTab=='2' || $linkOpenTab=='') echo "selected";?>>Same window</option>
				</select></td>
              </tr>
			  
			  <tr id="showurl" style=" <?php echo $LinkURL;?> ">
                <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span>Article URL </td>
                <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_externalUrl"></div><input name="externalUrl" type="text" id="externalUrl" value="<?php echo $externalUrl; ?>"  class="fiellength" onkeyup="hideerrordiv(this.id);" /></td>
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
                            <tr id="showcontent" style=" <?php echo $divContentFields;?> ;">
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span>Description </td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_txtDescription"></div>
                                <textarea name="txtDescription" id="txtDescription"  onkchange="hideerrordiv(this.id);" <?php echo $editorcr;?>><?php echo $description; ?></textarea>
                                <!--<script type="text/javascript">
	                var editor = CKEDITOR.replace('txtDescription');
					CKFinder.setupCKEditor( editor,'<?php echo _CKFINDER_PATH_; ?>' ) ;
                </script>--></td>
                            </tr>
                         
                           <!-- <tr id="pdfonly2" style=" <?php echo $divContentFields;?> ;">
                              <td align="left" valign="top" style="padding:5px;"><span class="red_star"></span>Upload (.doc, .docx only)</td>
                              <td align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_txtResourceFile2"></div>
                                <input name="txtResourceFile2" type="file" id="txtResourceFile2"  accept=".doc,.DOC,.docx,.DOCX" onchange="hideerrordiv(this.id);" />
                                <?php if ($action=="edit" && $resourceFile2!=''){ ?>
                                Current file: <a href="../news-events/<?php echo $resourceFile2; ?>" target="_blank">View</a>
                                <?php } ?></td>
                            </tr>-->
							
							<tr id="pdfonly" style=" <?php echo $divContentFields;?> ;">
                              <td align="left" valign="top" style="padding:5px;"><span class="red_star"></span>PDF (.pdf only)</td>
                              <td align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_txtResourceFile"></div>
                                <input name="txtResourceFile" type="file" id="txtResourceFile"  accept=".pdf,.PDF" onchange="hideerrordiv(this.id);" />
                                <?php if ($action=="edit" && $resourceFile!=''){ ?>
                                Current file: <a href="../news-events/<?php echo $resourceFile; ?>" target="_blank"><!--<img src="images/pdf_icon.gif" border="0" title="Download" />-->View</a>
                                <?php } ?></td>
                            </tr>
							
                            <tr>
                              <td style="padding:5px;">Show on Homepage</td>
                              <td><input type="checkbox" name="homePageStatus" id="homePageStatus" value="1" onclick="hideerrordiv(this.id);" style="opacity: 1;" <?php if($homePageStatus==1) echo "checked"; ?> />
                                &nbsp; </td>
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
                        <input name="txtOldFile" type="hidden" id="txtOldFile" value="<?php echo $resourceFile; ?>" />
                        <input name="txtOldResourceFile2" type="hidden" id="txtOldResourceFile2" value="<?php echo $resourceFile2; ?>" />
                        <input name="txtOldCoverFileName" type="hidden" id="txtOldCoverFileName" value="<?php echo $coverFileName; ?>" />
                        <input name="txtOldPreviewImage" type="hidden" id="txtOldPreviewImage" value="<?php echo $coverFileName; ?>" />
                        <input name="resourceFileSize" type="hidden" id="resourceFileSize" value="<?php echo $resourceFileSize; ?>" />
                        <input name="resourceFileSize2" type="hidden" id="resourceFileSize2" value="<?php echo $resourceFileSize2; ?>" />
                        <input name="txtHiddenResourceType" type="hidden" id="txtHiddenResourceType" value="<?php echo $resourceType; ?>" />                      </td>
                      <td align="left" valign="top" style="padding:5px;"><input name="Submit2" type="submit" class="bluebutton" value="<?php echo $btnValue; ?>" />
                        &nbsp;&nbsp;
                        <input name="button" type="button" class="bluebutton" value="<< Back"  onclick="javascript: window.location.href='list-news-events.php';"/>                      </td>
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
function showFooterdiv(val)
{
	
	if(val==1)
	{
		//alert(val+'url');
		document.getElementById('showurl').style.display='table-row';
		//document.getElementById('open_in_tab').style.display='table-row';
		document.getElementById('showcontent').style.display='none';
		document.getElementById('pdfonly').style.display='none';
		//document.getElementById('pdfonly2').style.display='none';
		document.getElementById('articleurlid').style.display='none';
	}
	else if(val==2)
	{
		//alert(val+'content');
		document.getElementById('showurl').style.display='none';
		document.getElementById('showcontent').style.display='table-row';
		document.getElementById('pdfonly').style.display='table-row';
		//document.getElementById('pdfonly2').style.display='table-row';
		//document.getElementById('open_in_tab').style.display='none';
		document.getElementById('articleurlid').style.display='table-row';

	}
	else
	{
		/*alert(val+'else');
		document.getElementById('showurl').style.display='none';
		document.getElementById('showcontent').style.display='none';
		document.getElementById('pdfonly').style.display='none';
		document.getElementById('pdfonly2').style.display='none';
		//document.getElementById('open_in_tab').style.display='none';
		document.getElementById('articleurlid').style.display='none';*/
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
function ValidateURL(urlToCheck) {

    // Below regular expression can validate input URL with or without http:// etc

    var pattern = new RegExp("^((http|https|ftp)\://)*([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&%\$#\=~_\-]+))*$");

    return pattern.test(urlToCheck);

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
	$("#frmResources").submit(function()
	{

		var errorFldArray=[];

		var allFldArray=["txtResourceType","newsLetterTitle","txtShortDescription","linkType","resourceDate","txtResourceFile","txtOldFile","categoryId","resourceUrl"];
			
			if ($('input[name^=txtResourceType]:checked').length <= 0) 
			{
				errorFldArray.push(['txtResourceType@@@Please choose News or Events']);
			}
			if($("#categoryId").val()==null)
			{
				errorFldArray.push(['categoryId@@@Please select atleast one category']);
			}
			if($("#newsLetterTitle").val()=='')
			{
				errorFldArray.push(['newsLetterTitle@@@Please enter title name']);
			} 
			if($("#resourceDate").val()=='')
			{
				errorFldArray.push(['resourceDate@@@Please enter date']);
			} 
			 
		    if($("#linkType").val()=='1')
			{
				if($("#externalUrl").val()=='')
				{
					errorFldArray.push(['externalUrl@@@Please enter URL']);
				}
				else
				{
	
				   if($("#externalUrl").val().trim()!='')
				   {
						if(!ValidateURL($("#externalUrl").val().trim()))
						{
							errorFldArray.push(['externalUrl@@@Please enter valid URL']);
						}
					}
				 }
				
			}
			else if($("#linkType").val()=='2')
			{
				if($("#resourceUrl").val()=='')
				{
					errorFldArray.push(['resourceUrl@@@Please enter article URL']);
				}
				
					/* if($("#resourceUrl").val().trim()!='')
				    {
						if(!ValidateURL($("#resourceUrl").val().trim()))
						{
							errorFldArray.push(['resourceUrl@@@Please enter valid article URL!']);
						}
					 }*/
			
			}
		
				//if($("#txtShortDescription").val()=='')
//				{
//					errorFldArray.push(['txtShortDescription@@@Please enter short description !']);
//		
//				}
		
		if($("#txtResourceFile").val().trim()!='')
		{
			var uploadedFile = document.getElementById('txtResourceFile');
			var fileSize = uploadedFile.files[0].size;
			//alert(fileSize);
			if(fileSize<=0)
			{
				errorFldArray.push(['txtResourceFile@@@File size is 0. Please upload a valid PDF file@@@file']);
			}
			else if(fileSize>2097152)
			{
				errorFldArray.push(['txtResourceFile@@@File size exceeded limit! Please upload PDF file size maximum 2MB@@@file']);
			}
		}
		//if($("#txtResourceFile2").val().trim()!='')
//		{
//			var uploadedFile = document.getElementById('txtResourceFile2');
//			var fileSize = uploadedFile.files[0].size;
//			//alert(fileSize);
//			if(fileSize<=0)
//			{
//				errorFldArray.push(['txtResourceFile2@@@File size is 0. Please upload a valid doc file!@@@file']);
//			}
//			else if(fileSize>2097152)
//			{
//				errorFldArray.push(['txtResourceFile2@@@File size exceeded limit! Please upload doc file size maximum 2MB.@@@file']);
//			}
//		}
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


</script>
<script>

$(document).ready(function()
{

/* users multiselect code start*/

$("select[multiple] option").mousedown(function(){
   var $self = $(this);

   if ($self.prop("selected"))
   		$self.removeAttr("selected");
          //$self.prop("selected", false);
   else
       //$self.prop("selected", true);
	   $self.addAttr("selected");

   return false;
});
/* users multiselect code end*/
});
</script>
</body>
</html>
