<?php 
include_once('../codelibrary/inc/constants-defined.inc.php');
include_once('../codelibrary/inc/database.inc.php');
include_once('../codelibrary/inc/functions.inc.php');
include_once('../codelibrary/inc/check-admin-session.php');

mb_internal_encoding('UTF-8'); //or whatever character set works for you
mb_http_output('SJIS');
mb_http_input('UTF-8');
mb_regex_encoding('UTF-8'); 

$pageIndex=5;
$pageTitle="Reports and Publications";
openConn();
$action="add";
$autofocus='categoryId';
$btnValue='Submit';
$textareafocus='';
/*$shortDescription='
<br><br><br>
<div class="docs_links_txt">
				本記事の日本語版要約は、<span><a href="#">こちら</a></span>をご覧下さい。<br><br>
					なお、BMR Edgeの英語版原文の一覧は、<span><a href="http://www.bmradvisors.com/insights-bmr-edge.html" target="_blank">こちら</a></span>にてご覧いただけます。
				</div>';*/
				
$shortDescription='
<div class="docs_links_txt">
法規制に関する発表や裁判所の判決等、インドにおけるビジネスニュースのうち、<br />
特に重要なニュースをピックアップし、その詳細を記事にした<strong>BMR Edge</strong>が発行されました。<br />
<br />
今回発行された記事は以下となります：<br />
<strong>Post title goes here</strong><br />
<br />
本記事の英語版原文・日本語版要約は、こちらをご覧下さい（<a href="http://www.bmradvisors.com/insights-bmr-edge.html" target="_blank">英語版</a> ・<a href="#">日本語版</a>）。
</div>';
				
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
			$resourceFileSize=trim($rowNews["resourceFileSize"]);
			$finalresourceDate=trim($rowNews["resourceDate"]);
			$expresourceDate=explode("-",$finalresourceDate);
			$resourceDate=$expresourceDate[2]."-".$expresourceDate[1]."-".$expresourceDate[0];
			$description=$rowNews["description"];
			$metaKeywords=$rowNews["metaKeywords"];
			$homePageStatus=trim($rowNews["homePageStatus"]);
			$showInNeList=trim($rowNews["showInNeList"]);
			$resourceUrl=trim($rowNews["resourceUrl"]);
			$shortDescription=trim($rowNews["shortDescription"]);
			$categoryId=trim($rowNews["categoryId"]);
			$categoryIdArr=explode(",",$categoryId);
			$memberId=trim($rowNews["memberId"]);
			$memberIdArr=explode(",",$memberId);
			
			$strInWhere="and memberId IN(".$memberId.")";
			$strNotInWhere="and memberId NOT IN(".$memberId.")";
		}
		$btnValue='Update';
		$action="edit";
	}
	
}


if(isPost())
{
		$errorMsg='';
		$pageType=_REPORTS_PUBLICATIONS_VALUE_;
		$action=$_POST["txtAction"];
		
		$resourceType=1;

		$resourceTitle=clean($_POST["newsLetterTitle"]);
		$shortDescription=clean($_POST["txtShortDescription"]);
		$description=clean($_POST["articleDescription"]);
		$resourceDate=clean($_POST["resourceDate"]);
		$userId=trim($_POST["txtUserId"]);

		$homePageStatus=clean($_POST["homePageStatus"]);
		$showInNeList=clean($_POST["showInNeList"]);
		$mostPopular=clean($_POST["mostPopular"]);
		$resourceUrl=str_replace(" ","-",clean($_POST["resourceUrl"]));
		
		$metaKeywords=clean($_POST["txtKeywords"]);
		if($metaKeywords!='')
		{
			$metaKeywords=createMetaTags($resourceTitle,$metaKeywords);
		}
		else
		{	
			$metaKeywords=$resourceTitle;
		}
		
	/*	if($resourceUrl!='')
		{
			$resourceUrl=$resourceUrl;
			if($resourceUrl=='')
			{
				$notvalid=1;
			}
		}
		else
		{
			$resourceUrl=makeContentUrl($resourceTitle);
		}*/
		
		if(trim($description)=='')
		{
			$errorMsg="Please enter description";
			$autofocus='articleDescription';
			$textareafocus=2;
		}
		if(trim($shortDescription)=='')
		{
			$errorMsg="Please enter short description";
			$autofocus='txtShortDescription';
			$textareafocus=1;
		}
		if(trim($resourceDate)=='')
		{
			$errorMsg="Please enter published date";
			$autofocus='resourceDate';
		}
		//if(trim($resourceUrl)=='' && $notvalid==1)
//		{
//			$errorMsg="Please enter valid URL";
//		}
		if (strpos($resourceUrl, '#') !== false) {
			$errorMsg="Please enter valid article URL";
		}
		if(trim($resourceUrl)=='')
		{
			$errorMsg="Please enter URL";
		}
		if(trim($resourceTitle)=='')
		{
			$errorMsg="Please enter title name";
			$autofocus='newsLetterTitle';
		}
		if(count($_POST["txtUserId"])<=0)
		{
			$errorMsg="Please select atleast one member";
		}
		if(count($_POST["categoryId"])<=0)
		{
			$errorMsg="Please select atleast one category";
		}
		
		
		
		
		if(count($_POST["txtUserId"])>0)
		{	
			$memberId='';
			for($k=0; $k<=count($_POST["txtUserId"]);  $k++)
			{
				if(trim($_POST["txtUserId"][$k])!='' && trim($_POST["txtUserId"][$k])!='0')
				{
					if(is_numeric(trim($_POST["txtUserId"][$k])))
					{
						$memberId.=','.$_POST["txtUserId"][$k];
					}
				}
			}
				$memberId=trim($memberId,',');
				
				$memberIdArr=explode(",",$memberId);
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
			$sqlURLcheck="Select resourceUrl from "._RESOURCES_TABLE_." where pageType='"._REPORTS_PUBLICATIONS_VALUE_."' and resourceUrl = '".$resourceUrl."' ";
			$resURLcheck=getRecords(_RESOURCES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlURLcheck);
			if($resURLcheck)
			{
				$errorMsg="URL '".$resourceUrl."' already exists in database. Please enter another URL";
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
					
						
						/*unset($selectFields);
						unset($whereFields);
						unset($whereVals);
				
						$sqlFilecheck="";
						$sqlFilecheck="Select resourceFile from "._RESOURCES_TABLE_." where pageType='"._REPORTS_PUBLICATIONS_VALUE_."' and  resourceFile = '".$_FILES["txtResourceFile"]["name"]."' ";
						$resFilecheck=getRecords(_RESOURCES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlFilecheck);
						if($resFilecheck)
						{
							$errorMsg="This file name '".$_FILES["txtResourceFile"]["name"]."' already exists in database. Please enter another URL";
						}*/
				
						//if(trim($errorMsg)=='')
						//{
							//$resourceFile=rand(0,99).date("Ymdsi");
							//$resourceFile=$resourceFile.".".$extArray;	
							
							$resourceFile2=$_FILES["txtResourceFile"]["name"];	//Original file name				
							$resourceFile=$resourceUrl.".".$extArray;
							$filePath=$_FILES['txtResourceFile']['tmp_name'];
							$imageUploaded=false;
							//chmod("../reports-publications/", 0777);  // octal; correct value of mode
							//move_uploaded_file($filePath2,"../reports-publications/".$resourceFile2);
							//$imageUploaded=uploadImage($filePath,"../reports-publications/".$resourceFile);
							
							copy($_FILES['txtResourceFile']['tmp_name'],"../reports-publications/".$resourceFile2);
							$imageUploaded=copy($_FILES['txtResourceFile']['tmp_name'],"../reports-publications/".$resourceFile);
							
							//chmod("../reports-publications/", 0755);  // octal; correct value of mode
							
							if(!$imageUploaded)
								$errorMsg.="File not uploaded.<br>";
							else
							{
								if(trim($_POST["txtOldFile"])!='' && is_file("../reports-publications/".$_POST["txtOldFile"]))
									unlink("../reports-publications/".$_POST["txtOldFile"]);
									
									if(trim($_POST["txtOldResourceFile2"])!='' && is_file("../reports-publications/".$_POST["txtOldResourceFile2"]))
									unlink("../reports-publications/".$_POST["txtOldResourceFile2"]);
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
				$insertFields[14]="shortDescription";
				$insertFields[15]="memberId";
				$insertFields[16]="dateModify";
				$insertFields[17]="resourceFile2";
				$insertFields[18]="showInNeList";
				
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
				$insertVals[14]=$shortDescription;
				$insertVals[15]=$memberId;
				$insertVals[16]=time();
				$insertVals[17]=$resourceFile2;
				$insertVals[18]=$showInNeList;
				
				$resMenuInsert=insertDB(_RESOURCES_TABLE_,$insertFields,$insertVals,_N_,'');
				$resourceId=$resMenuInsert;
				
				
				header("location:list-reports-publications.php?success=1");
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
			$sqlURLcheck="Select resourceUrl from "._RESOURCES_TABLE_." where pageType='"._REPORTS_PUBLICATIONS_VALUE_."' and resourceUrl = '".$resourceUrl."' and resourceId!=".$resourceId." ";
			$resURLcheck=getRecords(_RESOURCES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlURLcheck);
			if($resURLcheck)
			{
				$errorMsg="URL '".$resourceUrl."' already exists in database. Please enter another URL";
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
					
						/*unset($selectFields);
						unset($whereFields);
						unset($whereVals);
				
						$sqlFilecheck="";
						$sqlFilecheck="Select resourceFile from "._RESOURCES_TABLE_." where pageType='"._REPORTS_PUBLICATIONS_VALUE_."' and  resourceFile = '".$_FILES["txtResourceFile"]["name"]."'  and resourceId!=".$resourceId." ";
						$resFilecheck=getRecords(_RESOURCES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlFilecheck);
						if($resFilecheck)
						{
							$errorMsg="This file name '".$_FILES["txtResourceFile"]["name"]."' already exists in database. Please enter another URL";
						}*/
					
					
						//if(trim($errorMsg)=='')
						//{
							//$resourceFile=rand(0,99).date("Ymdsi");
							//$resourceFile=$resourceFile.".".$extArray;	
							
							$resourceFile2=$_FILES["txtResourceFile"]["name"];					
							$resourceFile=$resourceUrl.".".$extArray;
							$filePath=$_FILES['txtResourceFile']['tmp_name'];
							$imageUploaded=false;
							//chmod("../reports-publications/", 0777);  // octal; correct value of mode
							//move_uploaded_file($filePath2,"../reports-publications/".$resourceFile2);
							//$imageUploaded=uploadImage($filePath,"../reports-publications/".$resourceFile);
							//chmod("../reports-publications/", 0755);  // octal; correct value of mode
							
							
							copy($_FILES['txtResourceFile']['tmp_name'],"../reports-publications/".$resourceFile2);
							$imageUploaded=copy($_FILES['txtResourceFile']['tmp_name'],"../reports-publications/".$resourceFile);
							
							if(!$imageUploaded)
								$errorMsg.="File not uploaded.<br>";
							else
							{
								/*if(trim($_POST["txtOldFile"])!='' && is_file("../reports-publications/".$_POST["txtOldFile"]))
									unlink("../reports-publications/".$_POST["txtOldFile"]);*/
									
									if(trim($_POST["txtOldResourceFile2"])!='' && is_file("../reports-publications/".$_POST["txtOldResourceFile2"]))
									unlink("../reports-publications/".$_POST["txtOldResourceFile2"]);
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
			$insertFields[14]="shortDescription";
			$insertFields[15]="memberId";
			$insertFields[16]="resourceFile2";
			$insertFields[17]="showInNeList";
			
			
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
			$insertVals[14]=$shortDescription;
			$insertVals[15]=$memberId;
			$insertVals[16]=$resourceFile2;
			$insertVals[17]=$showInNeList;

		
			$whereFields[0]="resourceId";
			
			$whereVals[0]=$resourceId;
			
			$resBuilderUpdate=updateDB(_RESOURCES_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');
			
			header("location:list-reports-publications.php?success=2");
			exit();
			
		
		}
	
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo ucfirst($action); ?> <?php echo $pageTitle;?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link href="css/validate.css" rel="stylesheet" type="text/css" />
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="../codelibrary/js/jquery-ui-1.9.1.custom.js"></script>
<!--<script language="JavaScript" type="text/javascript" src="../codelibrary/ckeditor/ckeditor.js"></script>
<script language="JavaScript" type="text/javascript" src="../codelibrary/ckeditor/ckfinder/ckfinder.js"></script>-->
<!--<script src="../codelibrary/js/jquery.min.js" type="text/javascript"></script>-->
<!--<script src="../codelibrary/js/nicEdit.js" type="text/javascript"></script>-->
<script src="../js/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
	 myNicEditor = new nicEditor({iconsPath : 'nicEditorIcons.gif',fullPanel : true}).panelInstance('txtShortDescription');
	 myNicEditor = new nicEditor({iconsPath : 'nicEditorIcons.gif',fullPanel : true}).panelInstance('articleDescription');
});

</script>
<script type="text/javascript" language="javascript">
//document.getElementById("<?php echo $autofocus;?>").focus();
//document.frmResources.<?php echo $autofocus;?>.focus();
<?php if($textareafocus==1){?>
//$('textarea').focus();
<?php }?>
$("#<?php echo $autofocus;?>").focus();


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
          <h1><?php echo ucfirst($action); ?> <?php echo $pageTitle;?></h1>
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
                      <td align="left" valign="top" colspan="2"><div class="mandatoryfields"><span class="red_star">*</span>Indicates mandatory fields</div></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" style="padding:5px;" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span>Category</td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_categoryId"></div>
                               <select name="categoryId[]" id="categoryId" multiple="multiple" onchange="hideerrordiv(this.id);" style="width:250px; height:120px; -webkit-appearance:none; background-color:#fff;">
                                  <option value="0" disabled="disabled" <?php if($categoryId=="0"){ ?>selected="selected"<?php } ?>>Select Category</option>
                                  <?php 
									unset($selectFields);
									unset($whereFields);
									unset($whereVals);
									
									$sqlNews='';
									echo $sqlNews="SELECT * FROM "._CATEGORIES_TABLE_."  WHERE validYN='Y' ORDER BY sortOrder ASC ";
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
						   <!-- <tr>
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span>Members</td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_txtUserId"></div>
                                <select name="txtUserId[]" id="txtUserId" multiple="multiple" onchange="hideerrordiv(this.id);" style="width:250px; height:120px; -webkit-appearance:none; background-color:#fff;">
     <option value="0" disabled="disabled">Select Members</option>
     <?php
							unset($selectFields);
							unset($whereFields);
							unset($whereVals);					

							$strMemberSql="";
							$strMemberSql="SELECT memberId,memberName FROM "._JP_MEMBERS_TABLE_." WHERE  pageTypeMember!=0  order by memberName ";
							$resMemberSql=getRecords(_JP_MEMBERS_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$strMemberSql);
							if($resMemberSql)
							{
							  	while($rowMemberSql=mysql_fetch_array($resMemberSql))
								{
									if(is_array($memberIdArr))
									{
										if(in_array($rowMemberSql["memberId"],$memberIdArr))
											$strSelected="selected='selected'";
										else
											$strSelected="";
									}
									else
									{
										$strSelected="";
									}
							  ?>
     <option value="<?php echo $rowMemberSql["memberId"]; ?>" <?php echo $strSelected; ?>><?php echo ucfirst($rowMemberSql["memberName"]); ?></option>
     <?php
							  	}
                            }
							?>
   </select>
				  </td>
                            </tr>-->
							
							 <tr>
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span>Members</td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><!--<div class="erorfldcls" id="fld_txtUserId"></div>-->
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="29%" valign="top"><select name="selectfrom" id="select-from" multiple size="5" style="width:250px; height:120px; -webkit-appearance:none; background-color:#fff;">
								   <option value="0" disabled="disabled">Select Members</option>
     <?php
							unset($selectFields);
							unset($whereFields);
							unset($whereVals);					

							$strMemberSql="";
							$strMemberSql="SELECT memberId,memberName FROM "._JP_MEMBERS_TABLE_." WHERE  pageTypeMember!=0 ".$strNotInWhere." order by memberName ";
							$resMemberSql=getRecords(_JP_MEMBERS_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$strMemberSql);
							if($resMemberSql)
							{
							  	while($rowMemberSql=mysql_fetch_array($resMemberSql))
								{
									if(is_array($memberIdArr))
									{
										if(in_array($rowMemberSql["memberId"],$memberIdArr))
											$strSelected="selected='selected'";
										else
											$strSelected="";
									}
									else
									{
										$strSelected="";
									}
							  ?>
     <option value="<?php echo $rowMemberSql["memberId"]; ?>" <?php echo $strSelected; ?>><?php echo ucfirst($rowMemberSql["memberName"]); ?></option>
     <?php
							  	}
                            }
							?>
   </select>
								</select></td>
    <td width="13%" align="left" valign="top"><a href="JavaScript:void(0);" id="btn-add">Add &raquo;</a></td>
    <td width="9%" align="left" valign="top"><a href="JavaScript:void(0);" id="btn-remove"><!-- onmouseleave="autoselectedfun();"-->&laquo; Remove</a></td>
    <td width="30%" valign="top"><div class="erorfldcls" id="fld_txtUserId"></div>
	<select name="txtUserId[]" id="txtUserId" multiple size="5" onchange="hideerrordiv(this.id);" style="width:250px; height:120px; -webkit-appearance:none; background-color:#fff;">
						    <?php
							if($memberId!='')
							{
								
								$expMemberArr=explode(",",$memberId);
								foreach ($expMemberArr as $key => $val) {
								
								unset($selectFields);
								unset($whereFields);
								unset($whereVals);					
	
								$strMemberSql1="";
								$strMemberSql1="SELECT memberId,memberName FROM "._JP_MEMBERS_TABLE_." WHERE memberId='".$val."' ";
								$resMemberSql1=getRecords(_JP_MEMBERS_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$strMemberSql1);
								if($resMemberSql1)
								{
									while($rowMemberSql1=mysql_fetch_array($resMemberSql1))
									{
										if(is_array($memberIdArr))
										{
											if(in_array($rowMemberSql1["memberId"],$memberIdArr))
												$strSelected1="selected='selected'";
											else
												$strSelected1="";
										}
										else
										{
											$strSelected1="";
										}
								  ?>
		 <option value="<?php echo $rowMemberSql1["memberId"]; ?>" <?php echo $strSelected1; ?>><?php echo ucfirst($rowMemberSql1["memberName"]); ?></option>
		 <?php
									}
								}
								}
							
							}
							?>
								</select></td>
    <td width="19%" align="left" valign="top"><a href="JavaScript:void(0);" id="btn-up"><!-- onmouseleave="autoselectedfun();"-->Up</a><br />
      <br />
<br>
      <br><br>
      <br>

								<a href="JavaScript:void(0);" id="btn-down"><!-- onmouseleave="autoselectedfun();"-->Down</a></td>
  </tr>
</table>

								
								
								
								
								
  							</td>
                            </tr>
							
                            <tr>
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span>Title</td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_newsLetterTitle"></div>
                              <input name="newsLetterTitle" type="text" id="newsLetterTitle" value="<?php echo $resourceTitle; ?>"  class="fiellength" onkeyup="hideerrordiv(this.id);" /></td>
                            </tr>
							
							 <tr>
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span>Article URLs</td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_resourceUrl"></div>
                              <input name="resourceUrl" type="text" id="resourceUrl" value="<?php echo $resourceUrl; ?>"  class="fiellength" onkeyup="hideerrordiv(this.id);" /></td>
                            </tr>
							
                             <tr>
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span>Published Date </td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_resourceDate"></div>
                                <input name="resourceDate" type="text" id="resourceDate" value="<?php echo $resourceDate; ?>"  class="fiellength" style="width: 240px !important;" onchange="hideerrordiv(this.id);"  autocomplete="off"/>
                               &nbsp;&nbsp;</td>
                            </tr>
                           <tr>
									  <td width="18%" valign="top" style="padding:5px;"><span class="red_star">*</span>Short Description</td>
									  <td width="82%" style="padding:5px;"><div class="erorfldcls" id="fld_txtShortDescription"></div>
									  <textarea name="txtShortDescription" id="txtShortDescription" onkchange="hideerrordiv(this.id);" <?php echo $editorcr;?>><?php echo $shortDescription; ?></textarea>
						     <!--<script type="text/javascript">
	                var editor = CKEDITOR.replace('txtShortDescription');
					CKFinder.setupCKEditor( editor,'<?php echo _CKFINDER_PATH_; ?>' ) ;
                </script>--></td>
					      </tr>
                            <tr>
                              <td width="18%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span>Description </td>
                              <td width="82%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_articleDescription"></div>
                                <textarea name="articleDescription" id="articleDescription"  onkchange="hideerrordiv(this.id);" <?php echo $editorcr;?>><?php echo $description; ?></textarea>
                              <!--<script type="text/javascript">
	                var editor = CKEDITOR.replace('articleDescription');
					CKFinder.setupCKEditor( editor,'<?php echo _CKFINDER_PATH_; ?>' ) ;
                </script>--></td>
                            </tr>
							<tr>
                      <td align="left" valign="top" style="padding:5px;">&nbsp;</td>
                      <td align="left" valign="top" style="padding:5px;">&nbsp;</td>
                    </tr>
                          
                          </table></td>
                    </tr>
                      <!--<tr id="pdfonly2" style=" <?php echo $divContentFields;?> ;">
                              <td align="left" valign="top" style="padding:5px;"><span class="red_star"></span>Upload (.doc, .docx only)</td>
                              <td align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_txtResourceFile2"></div>
                                <input name="txtResourceFile2" type="file" id="txtResourceFile2"  accept=".doc,.DOC,.docx,.DOCX" onchange="hideerrordiv(this.id);" />
                                <?php if ($action=="edit" && $resourceFile2!=''){ ?>
                                Current file: <a href="../reports-publications/<?php echo $resourceFile2; ?>" target="_blank">View</a>
                                <?php } ?></td>
                            </tr>-->
                    <tr id="pdfonly" style=" <?php echo $divContentFields;?> ;">
                              <td align="left" valign="top" style="padding:5px;"><span class="red_star"></span>PDF (.pdf only)</td>
                              <td align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_txtResourceFile"></div>
                                <input name="txtResourceFile" type="file" id="txtResourceFile"  accept=".pdf,.PDF" onchange="hideerrordiv(this.id);" />
                                <?php if ($action=="edit" && $resourceFile!=''){ ?>
                                Current file: <a href="../reports-publications/<?php echo $resourceFile; ?>" target="_blank"><!--<img src="images/pdf_icon.gif" border="0" title="Download" />-->View</a>
                                <?php } ?></td>
                            </tr>
                            <tr>
                              <td width="18%" style="padding:5px;">Show on Homepage</td>
                              <td width="82%"><input type="checkbox" name="homePageStatus" id="homePageStatus" value="1" onclick="hideerrordiv(this.id);" style="opacity: 1;" <?php if($homePageStatus==1) echo "checked"; ?> />
                              &nbsp; </td>
                            </tr>
                            <tr>
                              <td width="18%" style="padding:5px;">Show on News/Events List</td>
                              <td width="82%"><input type="checkbox" name="showInNeList" id="showInNeList" value="1" onclick="hideerrordiv(this.id);" style="opacity: 1;" <?php if($showInNeList==1) echo "checked"; ?> />
                              &nbsp; </td>
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
                      <td align="left" valign="top" style="padding:5px;"><input name="Submit2" type="submit" class="bluebutton" value="<?php echo $btnValue; ?>"  onmousemove="autoselectedfun();"/>
                        &nbsp;&nbsp;
                        <input name="button" type="button" class="bluebutton" value="<< Back"  onclick="javascript: window.location.href='list-reports-publications.php';"/>                      </td>
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
function autoselectedfun()
{
	//alert('yes');
	$('select#txtUserId').find('option').each(function() {
	  $(this).prop('selected', true);
	  //alert($('#txtUserId').val());
});

}
/*set multiple ordering code Start*/

$(document).ready(function() {
    $('#btn-add').click(function(){
        $('#select-from option:selected').each( function() {
                $('#txtUserId').append("<option value='"+$(this).val()+"' selected='selected'>"+$(this).text()+"</option>");
            $(this).remove();
        });
    });
    $('#btn-remove').click(function(){
        $('#txtUserId option:selected').each( function() {
            $('#select-from').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");
            $(this).remove();
        });
    });
    $('#btn-up').bind('click', function() {
        $('#txtUserId option:selected').each( function() {
            var newPos = $('#txtUserId option').index(this) - 1;
            if (newPos > -1) {
                $('#txtUserId option').eq(newPos).before("<option value='"+$(this).val()+"' selected='selected'>"+$(this).text()+"</option>");
                $(this).remove();
            }
        });
    });
    $('#btn-down').bind('click', function() {
        var countOptions = $('#txtUserId option').size();
        $('#txtUserId option:selected').each( function() {
            var newPos = $('#txtUserId option').index(this) + 1;
            if (newPos < countOptions) {
                $('#txtUserId option').eq(newPos).after("<option value='"+$(this).val()+"' selected='selected'>"+$(this).text()+"</option>");
                $(this).remove();
            }
        });
    });
});

/*set multiple ordering code end*/



function resourceFun(resourceVal)
{
	if(resourceVal==1 || resourceVal==2)
	{	
		document.getElementById('divPublications').style.display='none';
		document.getElementById('divVideo').style.display='none';		
	}
	else if(resourceVal=='')
	{
		document.getElementById('divPublications').style.display='none';
		document.getElementById('divVideo').style.display='none';
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


$(document).ready(function()
{


	$("#frmResources").submit(function()
	{

		var errorFldArray=[];

		var allFldArray=["txtResourceType","newsLetterTitle","txtShortDescription","resourceDate","txtResourceFile","txtOldFile","categoryId","txtUserId","resourceUrl"];
			
				
				if($("#categoryId").val()==null)
				{
					errorFldArray.push(['categoryId@@@Please select atleast one category']);
				}
				//alert($("#txtUserId").val());
				if($("#txtUserId").val()==null)
				{
					errorFldArray.push(['txtUserId@@@Please select atleast one member']);
				}

				if($("#newsLetterTitle").val()=='')
				{
					errorFldArray.push(['newsLetterTitle@@@Please enter title name']);
		
				}
				if($("#resourceUrl").val()=='')
				{
					errorFldArray.push(['resourceUrl@@@Please enter article URL']);
		
				}
				if($("#resourceDate").val()=='')
				{
					errorFldArray.push(['resourceDate@@@Please enter date']);
				}
				//if($("#txtShortDescription").val()=='')
//				{
//					errorFldArray.push(['txtShortDescription@@@Please enter short description']);
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
						errorFldArray.push(['txtResourceFile@@@File size exceeded limit! Please upload PDF file size maximum 2MB.@@@file']);
					}
				}
//				if($("#txtResourceFile2").val().trim()!='')
//				{
//					var uploadedFile = document.getElementById('txtResourceFile2');
//					var fileSize = uploadedFile.files[0].size;
//					//alert(fileSize);
//					if(fileSize<=0)
//					{
//						errorFldArray.push(['txtResourceFile2@@@File size is 0. Please upload a valid doc file!@@@file']);
//					}
//					else if(fileSize>2097152)
//					{
//						errorFldArray.push(['txtResourceFile2@@@File size exceeded limit! Please upload doc file size maximum 2MB.@@@file']);
//					}
//				}

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
   {
   		$self.removeAttr("selected");
          //$self.prop("selected", false);
   }
   else
   {
       //$self.prop("selected", true);
	   $self.addAttr("selected");
	   //$(this).prop('selected', true);
   }

   return false;
});
/* users multiselect code end*/
});
</script>
</body>
</html>
