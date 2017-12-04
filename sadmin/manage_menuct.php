<?php 
include_once('../codelibrary/inc/constants-defined.inc.php');
include_once('../codelibrary/inc/database.inc.php');
include_once('../codelibrary/inc/functions.inc.php');
include_once('../codelibrary/inc/check-admin-session.php');

openConn();
$pageIndexval=2;
$action="add";
$errorMsgColor='#FF0000';

if($_GET["success"]=="1" || $_GET["success"]==1)
{
	$errorMsg="Added Successfully !"; 
	$errorMsgColor='#009900';
}
if(strtolower($_REQUEST["txtAction"])=="delete" && is_numeric($_REQUEST["id"]) && $_REQUEST["id"]!=0)   /*-----------------Delete Commond---------------*/
{
		
		unset($whereFields);
		unset($whereVals);
		
		$whereFields[0]="id";
		$whereVals[0]=$_REQUEST["id"];

		$resDelete=deleteDB(_MENU_MASTER_TABLE_,$whereFields,$whereVals,_N_,'');
		
		/*-----------------Delete Instructions---------------*/
		// if we want delete submenu 1st level 2nd level and 3rd level  ///

/*		unset($selectFields);
		unset($whereFields);
		unset($whereVals);

		$sqlContact="";
		$sqlContact="Select * from "._MENU_MASTER_TABLE_." where mainMenuId = '".$_REQUEST["id"]."'  ";
		$resMatching=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlContact);
		if($resMatching)
		{
		
			while($res_menu=mysql_fetch_array($resContacts))
			{	
				$id=$res_menu["id"];
			}	
			
		}
*/		
		unset($whereFields);
		unset($whereVals);
		
		$whereFields[0]="mainMenuId";
		$whereVals[0]=$id;

		//$resDelete=deleteDB(_MENU_MASTER_TABLE_,$whereFields,$whereVals,_N_,'');
		
		unset($whereFields);
		unset($whereVals);
		
		$whereFields[0]="mainMenuId";
		$whereVals[0]=$_REQUEST["id"];

		//$resDelete=deleteDB(_MENU_MASTER_TABLE_,$whereFields,$whereVals,_N_,'');

		$errorMsg="Deleted Successfully !";
		$errorMsgColor='#FF0000';

}



if(isPost())
{

		$action=$_POST["txtAction"];
	
		$errorMsg='';
		$menuName=clean($_POST["menuName"]);
		$sortOrder=clean($_POST["txtSortOrder"]);
		
		/*if($menuName!='')
		{
			$pageUrl=strtolower(str_replace(" ","-",(str_replace("/","-",$menuName))));
		}*/
		
		if($menuName!='')
		{
			$pageUrl=makeContentUrl($menuName);
			//$pageUrl=$pageUrl.".php";
		}


		if(trim($_POST["menuType"])!='')
		{
			$menuType=clean($_POST["menuType"]);
		}
		else
		{
			$menuType="listing";
		}
		
		if(trim($_POST["mainMenuId2"])!='' && trim($_POST["mainMenuId2"])!=0)
		{
			$mainMenuId=clean($_POST["mainMenuId2"]);
			$menuLevel1=clean($_POST["mainMenuId"]);
			$menuLevel2=clean($_POST["mainMenuId1"]);
			$menuLevel3=clean($_POST["mainMenuId2"]);
		}
		else if(trim($_POST["mainMenuId1"])!='' && trim($_POST["mainMenuId1"])!=0)
		{
			$mainMenuId=clean($_POST["mainMenuId1"]);
			$menuLevel1=clean($_POST["mainMenuId"]);
			$menuLevel2=clean($_POST["mainMenuId1"]);
			$menuLevel3=clean($_POST["mainMenuId2"]);
		}
		else if(trim($_POST["mainMenuId"])!='' && trim($_POST["mainMenuId"])!=0)
		{
			$mainMenuId=clean($_POST["mainMenuId"]);
			$menuLevel1=clean($_POST["mainMenuId"]);
			$menuLevel2=clean($_POST["mainMenuId1"]);
			$menuLevel3=clean($_POST["mainMenuId2"]);
		}
		
	
	if(trim($errorMsg)=='')
	{
		if(!empty($_FILES["txtMenuIcon"]["name"]))
		{
			$extArray=strtolower(end(explode(".", $_FILES["txtMenuIcon"]["name"])));
			if($extArray=='png' || $extArray=='jpg' || $extArray=='jpeg' || $extArray=='gif')
			{
				$size=filesize($_FILES['txtMenuIcon']['tmp_name']);
				
				if ($size > MAX_SIZE*1024)
				{
					$errorMsg="Please upload File size of upto 2 MB!<br>";
					$errorMsgColor='#FF0000';
				}
				else
				{
					$menuIcon=rand(0,99).date("Ymdsi");
					$menuIcon=$menuIcon.".".$extArray;
					
						
					$filePath=$_FILES['txtMenuIcon']['tmp_name'];
					$imageUploaded=false;
					chmod("../images/", 0777);  // octal; correct value of mode
					$imageUploaded=uploadImage($filePath,"../images/".$menuIcon);
					chmod("../images/", 0755);  // octal; correct value of mode
					
					if(!$imageUploaded)
						$errorMsg.="File not uploaded.<br>";
					else
					{
						if(trim($_POST["txtOldFile"])!='' && is_file("../images/".$_POST["txtOldFile"]))
							unlink("../images/".$_POST["txtOldFile"]);
					}
				}
			}
			else
			{
				$errorMsg="Please upload .png, .jpg, .jpeg, .gif, files only.";
				$errorMsgColor='#FF0000';
			}	
		}
		else if(trim($_POST["txtOldFile"])!='')
		{
				$menuIcon=$_POST["txtOldFile"];
		}
	}
	
	//print_r($_POST);
	if(trim(strtolower($action))=="add")    /*-----------------Add Commond---------------*/
	{

		if($menuName=='')
		{
			$errorMsg="Please enter menu name.";
			$errorMsgColor='#FF0000';
		}
		if($mainMenuId=='' || $mainMenuId==0)
		{
			$errorMsg="Please select menu !";
			$errorMsgColor='#FF0000';
		}

		if(trim($errorMsg)=='')
		{
			unset($selectFields);
			unset($whereFields);
			unset($whereVals);

			$sqlContact="";
			$sqlContact="Select id,pageUrl,mainMenuId from "._MENU_MASTER_TABLE_." where pageUrl = '".$pageUrl."' and mainMenuId=".$mainMenuId." ";
			$resMatching=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlContact);
			if($resMatching)
			{
				while($rowAboutUs=mysql_fetch_array($resMatching))
				{	
					$existsMainMenuId2=sanitizedboutput($rowAboutUs["mainMenuId"]);
					$existsMainMenuId1=sanitizedboutput($rowAboutUs["id"]);
				}
				$errorMsg="Menu Name '".$menuName."' already exists in database";
				$errorMsgColor='#FF0000';
			}

		}

		if(trim($errorMsg)=='')
		{
			

			unset($insertFields);
			unset($insertVals);

			$insertFields[0]="menuName";
			$insertFields[1]="pageUrl";
			$insertFields[2]="mainMenuId";
			$insertFields[3]="sortOrder";
			$insertFields[4]="addedDate";
			$insertFields[5]="addedBy";
			$insertFields[6]="menuType";
			$insertFields[7]="menuLevel1";
			$insertFields[8]="menuLevel2";
			$insertFields[9]="menuLevel3";
			$insertFields[10]="menuIcon";

			$insertVals[0]=$menuName;
			$insertVals[1]=$pageUrl;
			$insertVals[2]=$mainMenuId;
			$insertVals[3]=$sortOrder;
			$insertVals[4]=time();
			$insertVals[5]=$_SESSION["adminId"];
			$insertVals[6]=$menuType;
			$insertVals[7]=$menuLevel1;
			$insertVals[8]=$menuLevel2;
			$insertVals[9]=$menuLevel3;
			$insertVals[10]=$menuIcon;

			$resMenuInsert=insertDB(_MENU_MASTER_TABLE_,$insertFields,$insertVals,_N_,'');
			$resMenuId=$resMenuInsert;
			
			/*-----------------For Menu Level Columns code Instructions---------------*/
			// mainMenuId column must be not change . because searching and menu format are working correct by this mainMenuId column.
			// This is used for selected menu bars. If we want all menu dropdown options must be selected then given below columns are perfectly use and working. but adit code not working for these columns.   I mean it is correct code for all three dropdowns 
			if($menuLevel1!=0 && $menuLevel2!=0)
			{
				$menuLevel2=$menuLevel2;
				
				
				if($menuLevel3!=0)
				{
					$menuLevel3=$menuLevel3;
				}
				else
				{
					if($menuLevel2!=0)
					{
					   $menuLevel3=$resMenuId;
					}
					else
					{
						$menuLevel3=0;
					}
				}	
			}
			else
			{
				if($menuLevel2!=0)
				{
				   $menuLevel3=$menuLevel2;
				}
				else
				{
					$menuLevel3=0;
				}
				
				$menuLevel2=$resMenuId;
				
			}

			
			unset($insertFields);
			unset($insertVals);
			unset($whereFields);
			unset($whereVals);

			$insertFields[0]="menuLevel1";
			$insertFields[1]="menuLevel2";
			$insertFields[2]="menuLevel3";


			$insertVals[0]=$menuLevel1;
			$insertVals[1]=$menuLevel2;
			$insertVals[2]=$menuLevel3;

			$whereFields[0]="id";
			$whereVals[0]=$resMenuId;

			$resUpdate=updateDB(_MENU_MASTER_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');
			
			$menuName='';
			$pageUrl='';
			$mainMenuId='';
			$sortOrder='';
			$menuType='';
			$menuLevel1='';
			$menuLevel2='';
			$menuLevel3='';
			/*echo "<script>window.location.href='manage_menuct.php?success=1'</script>";*/
			header('Location:manage_menuct.php?success=1');
			exit();
		}

	}
	else if(trim(strtolower($action))=="edit") 
	{
		$id=trim($_POST["txtParam1"]);

		if($menuName=='')
		{
			$errorMsg="Please enter menu name.";
			$errorMsgColor='#FF0000';
		}
		
		
	
		if(trim($errorMsg)=='')
		{

			unset($insertFields);
			unset($insertVals);
			unset($whereFields);
			unset($whereVals);

			$insertFields[0]="menuName";
			$insertFields[1]="menuType";
			$insertFields[2]="sortOrder";
			$insertFields[3]="modifyDate";
			$insertFields[4]="modifyBy";
			$insertFields[5]="menuIcon";
			//$insertFields[6]="pageUrl";

			$insertVals[0]=$menuName;
			$insertVals[1]=$menuType;
			$insertVals[2]=$sortOrder;
			$insertVals[3]=time();
			$insertVals[4]=$_SESSION["adminId"];
			$insertVals[5]=$menuIcon;
			//$insertVals[6]=$pageUrl;

			$whereFields[0]="id";
			$whereVals[0]=$id;

			$resUpdate=updateDB(_MENU_MASTER_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');

			$errorMsg="Updated Successfully !";
			$errorMsgColor='#009900';

			$menuName='';
			$pageUrl='';
			$mainMenuId='';
			$sortOrder='';

		}

	}
	

}
///echo ' ===id=== '.$id.' ===mainMenuId=== '.$mainMenuId.' ===menuLevel1=== '.$menuLevel1.' ===menuLevel2=== '.$menuLevel2.' ===menuLevel3=== '.$menuLevel3;



if($_GET["rmfile"]==1 && ($_GET["id"]!='' && is_numeric($_GET["id"])))
{
	$errorMsg="File removed successfully !";
	$errorMsgColor='#FF0000';
}
else if($_GET["updateid"]==1 && ($_GET["id"]!='' && is_numeric($_GET["id"])))
{
	$errorMsg="Updated Successfully !";
	$errorMsgColor='#009900';
}
else if($_GET["id"]!='' && is_numeric($_GET["id"]))
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
			$mainMenuId=trim($rowDetails["mainMenuId"]);
			$menuLevel1=trim($rowDetails["menuLevel1"]);
			$menuLevel2=trim($rowDetails["menuLevel2"]);
			$menuLevel3=trim($rowDetails["menuLevel3"]);
			$menuType=trim($rowDetails["menuType"]);
			$menuIcon=trim($rowDetails["menuIcon"]);
			
			
			if($mainMenuId!='' && $mainMenuId!=0)
			{
				unset($selectFields);
				unset($whereFields);
				unset($whereVals);
			
				$selectFields[0]="*";
				$whereFields[0]="id";
				$whereVals[0]=$mainMenuId;
			
				$resDetails1=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_N_,'');
				if($resDetails1)
				{
					while($rowDetails1=mysql_fetch_array($resDetails1))
					{
						$mainMenuId1=trim($rowDetails1["mainMenuId"]);
						$id1=$rowDetails1["id"];
					}
				}
				else
				{
					$id1=0;
					$mainMenuId1=0;
				}
			}
			
			
			
			
			if($mainMenuId1!='' && $mainMenuId1!=0)
			{
				unset($selectFields);
				unset($whereFields);
				unset($whereVals);
			
				$selectFields[0]="*";
				$whereFields[0]="id";
				$whereVals[0]=$mainMenuId1;
			
				$resDetails2=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_N_,'');
				if($resDetails2)
				{
					while($rowDetails2=mysql_fetch_array($resDetails2))
					{
						$mainMenuId2=trim($rowDetails2["mainMenuId"]);
						$id2=$rowDetails2["id"];
					}
				}
				else
				{
					$mainMenuId2=0;
					$id2=0;
				}
			}




			if($mainMenuId2!='' && $mainMenuId2!=0)
			{
				unset($selectFields);
				unset($whereFields);
				unset($whereVals);
			
				$selectFields[0]="*";
				$whereFields[0]="id";
				$whereVals[0]=$mainMenuId2;
			
				$resDetails3=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_N_,'');
				if($resDetails3)
				{
					while($rowDetails3=mysql_fetch_array($resDetails3))
					{
						$mainMenuId3=trim($rowDetails3["mainMenuId"]);
						$id3=$rowDetails3["id"];
					}
				}
				else
				{
					$mainMenuId3=0;
					$id3=0;
				}
			}


		}

			

		$action="edit";	

	}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo _ADMIN_PAGE_TITLE_; ?>| List Pages</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link href="css/validate.css" rel="stylesheet" type="text/css" />
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
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
</head>
<body id="homeinnerbg">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10%" align="left" valign="top" style="width:156px;"><?php include("left.php"); ?>
    </td>
    <td width="90%" align="left" valign="top"><div id="rightbody">
        <?php include("header.php"); ?>
        <div class="rightbodysec">
          <h1>Manage  Pages</h1>
          <a href="manage_menuct.php" class="graybgbtn" style="float:left; margin-left: 10px;">Add New</a> </div>
        <div class="rightbodysec">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="3" align="center" height="25" valign="top"><span style="color:<?php echo $errorMsgColor; ?>;"><strong><?php echo $errorMsg; ?></strong></span></td>
            </tr>
            <tr>
              <td width="28%" align="left" valign="top"><form id="frmMenu" name="frmMenu" method="post" action="" enctype="multipart/form-data">
                  <table width="100%" border="0" cellpadding="0" cellspacing="0"  <?php if($action=="edit"){ ?> style="border:1px solid #000;"<?php } ?> class="mainbordersec<?php if ($action=="edit"){ ?> mainhighlightbordersec<?php } ?>">
                    <tr>
                      <td colspan="2" class="graysecheader"><?php if ($action=="edit"){ ?>
                        Edit Pages
                        <?php } else { ?>
                        Add New
                        <?php } ?></td>
                    </tr>
                    <tr>
                      <td colspan="2" style="padding:5px;"><!--<div class="errormsg" style="border:#000 solid 3px; display:none;" id="allErrorMsg">Some required information is missing or incomplete. Please correct your entries and try again.</div>--></td>
                    </tr>
                    <?php if ($action!="edit"){ ?>
                    <tr>
                      <td valign="top" style="padding:5px;">Parent Pages<span class="redtext"><strong>*</strong></span></td>
                      <td style="padding:5px;"><div class="erorfldcls" id="fld_mainMenuId"></div>
                        <select name="mainMenuId" id="mainMenuId"  style="  width: 230px;">
                          <option value="0" <?php if($_POST["mainMenuId"]=="0"){?>selected="selected"<?php } ?>>Select</option>
<?php 
$showBubMenuDrop='display:none;';
if($existsMainMenuId2!='' && $existsMainMenuId2!=0 && is_numeric($existsMainMenuId2))
{
	
	if($_POST['mainMenuId1']>0)
	{
		$id3=$_POST['mainMenuId'];		
		$id2=$existsMainMenuId1;
		$mainMenuId2=$existsMainMenuId2;
	}
	else
	{
		$id3=$existsMainMenuId2;
		//$mainMenuId2=$existsMainMenuId2;
	}
	$showBubMenuDrop='display:block;';
}
unset($selectFields);
unset($whereFields);
unset($whereVals);

$sqlQuery='';
$sqlQuery="SELECT id,menuName,mainMenuId FROM "._MENU_MASTER_TABLE_."  WHERE mainMenuId=0  and id NOT IN(4,6) ORDER BY menuName ASC ";
$resContacts=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlQuery);
if($resContacts)
{							
while($res_menu=mysql_fetch_array($resContacts)){	

	if(strtolower($res_menu['menuName'])=="home")
	{	
		$disabled='disabled="disabled"';
	}
	else
	{
		$disabled='';
	}		
?>
                          <option <?php echo $disabled; ?> value="<?php echo $res_menu['id']; ?>" <?php if($res_menu['id']==$id3){?>selected="selected"<?php } ?>><?php echo $res_menu['menuName']; ?></option>
                          <?php 

}
}

?>
                        </select>
						<div id="hidemainMenuId1" style=" <?php echo $showBubMenuDrop; ?> ">
                        <br />
                        &nbsp;
                        <select name="mainMenuId1" id="mainMenuId1"  style="  width: 230px;margin-left: -8px;">
                          <option value="0" selected="selected">Sub Pages </option>
<?php 
if($mainMenuId2>0)
{
	unset($selectFields);
	unset($whereFields);
	unset($whereVals);
	
	$sqlQuery1='';
	$sqlQuery1="SELECT id,menuName,mainMenuId FROM "._MENU_MASTER_TABLE_."   WHERE mainMenuId=".$mainMenuId2." ORDER BY menuName ASC ";
	$resContacts1=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlQuery1);
	if($resContacts1)
	{							
		while($res_menu1=mysql_fetch_array($resContacts1))	
		{
?>
                          <option value="<?php echo $res_menu1['id']; ?>" <?php if($res_menu1['id']==$id2){?>selected="selected"<?php } ?>><?php echo $res_menu1['menuName']; ?></option>
                          <?php 

		}
	}
}
?>
                        </select></div>
                       <!-- <br />
                        <br />
                        &nbsp;
                        <select name="mainMenuId2" id="mainMenuId2"  style="  width: 230px;margin-left: -8px;">
                          <option value="0" selected="selected">Sub Sub Menu </option>
                          <?php 
if($mainMenuId1>0)
{
	unset($selectFields);
	unset($whereFields);
	unset($whereVals);
	
	$sqlQuery2='';
	$sqlQuery2="SELECT * FROM "._MENU_MASTER_TABLE_."  WHERE mainMenuId=".$mainMenuId1." ORDER BY menuName ASC ";
	$resContacts2=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlQuery2);
	if($resContacts2)
	{							
		while($res_menu2=mysql_fetch_array($resContacts2))	
		{
?>
                          <option value="<?php echo $res_menu2['id']; ?>" <?php if($res_menu2['id']==$id1){?>selected="selected"<?php } ?>><?php echo $res_menu2['menuName']; ?></option>
                          <?php 

		}
	}
}
?>
                        </select>-->
                      </td>
                    </tr>
                    <?php } ?>
                    <tr>
                      <td width="30%" style="padding:5px;">Pages<span class="redtext"><strong>*</strong></span> </td>
                      <td width="70%" style="padding:5px;"><div class="erorfldcls" id="fld_menuName"></div>
                        <input name="menuName" type="text" class="formfld" id="menuName" value="<?php echo stripslashes($menuName); ?>"  onkeyup="hideerrordiv(this.id);" style="width:223px;" />
                      </td>
                    </tr>
                     <?php if($action=="edit" && $menuIcon!='') {?>
                    <tr>
                      <td>&nbsp;</td>
                      <td width="85%" align="left"  valign="top" style="padding:5px;"><img src="../images/<?php echo $menuIcon; ?>" border="0" width="26" height="26" style="background-color:black;" /> </td>
                    </tr>
                    <?php } ?>
                   <!-- <tr>
                      <td width="30%" style="padding:5px;">Menu Icon </td>
                      <td width="70%" style="padding:5px;">
                         <input name="txtMenuIcon" type="file" id="txtMenuIcon" /><br />
						Width:26px * Height:26px
                      </td>
                    </tr>-->
                    <tr>
                      <td width="30%" style="padding:5px;">Pages Type</td>
                      <td width="70%" style="padding:5px;"><input type="checkbox" name="menuType" id="menuType" value="content" onclick="hideerrordiv(this.id);" style="opacity: 1;" <?php if($menuType=="content" || $menuType=="") echo "checked"; ?> />
                        &nbsp;
                        
                        Content</td>
                    </tr>
                    <tr>
                      <td style="padding:5px;"> Order: </td>
                      <td style="padding:5px;"><div class="erorfldcls" id="fld_txtSortOrder"></div>
                        <input style="width: 86px;" name="txtSortOrder" type="text" class="formfld" id="txtSortOrder" value="<?php  echo $sortOrder; ?>" onkeypress="return blockNonNumbers(this, event, true, false);"/>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding:5px;">&nbsp;</td>
                      <td style="padding:5px;"><?php if ($action=="edit"){ ?>
                        <input name="Submit2" type="submit" class="bluebutton" value="Update" />
                        <input name="txtAction" type="hidden" id="txtAction" value="<?php echo $action; ?>" />
                        <input name="txtParam1" type="hidden" id="txtParam1" value="<?php echo $id; ?>" />
                        <?php } else { ?>
                        <input name="Submit2" type="submit" class="bluebutton" value="Add" />
                        <?php
						if($_POST["txtSearchMenu"]!='' && $_POST["txtSearchMenu"]!=0)
						{
							$action="add";
						}
						?>
                        <input name="txtAction" type="hidden" id="txtAction" value="<?php echo $action; ?>" />
                        <?php } ?>
                      </td>
                    </tr>
                  </table>
                </form></td>
              <td width="1%" align="left" valign="top">&nbsp;&nbsp;</td>
              <form id="frmSearch" name="frmSearch" method="post">
                <td width="71%" align="left" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0" class="mainbordersec">
                    <tr>
                      <td colspan="3" valign="top"><select name="txtSearchMenu" id="txtSearchMenu" style="  width: 290px;"  onchange="document.frmSearch.submit();">
                        <option value="0" <?php if($_POST["txtSearchMenu"]==0) echo "selected"; ?>>All</option>
                        <?php
									echo getMenuSubordinates($_SESSION["adminId"],$_POST['txtSearchMenu']);
									
									?>
                      </select></td>
                    </tr>
                    <tr>
                      <td width="47%" align="left" valign="top" class="graysecheader" style="padding:0px;">Edit Pages</td>
                      <td width="12%" align="left" valign="top" class="graysecheader" style="padding:0px;">Order</td>
                      <td width="41%" align="left" valign="top" class="graysecheader" style="padding:0px;">Edit Content</td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" colspan="3"><?php


if($_POST["txtSearchMenu"]!='' && $_POST["txtSearchMenu"]!=0)   
{             													  
	$nav_query = MYSQL_QUERY("SELECT * FROM "._MENU_MASTER_TABLE_."  WHERE mainMenuId=".$_POST["txtSearchMenu"]."  ORDER BY menuName ASC");
}
elseif($_POST["txtSearchMenu"]==0)
{
	$nav_query = MYSQL_QUERY("SELECT * FROM "._MENU_MASTER_TABLE_."  WHERE mainMenuId=0  ORDER BY menuName ASC");
}
else
{
	$nav_query = MYSQL_QUERY("SELECT * FROM "._MENU_MASTER_TABLE_."  WHERE mainMenuId=0  ORDER BY menuName ASC");
}
$num_rows=mysql_num_rows($nav_query);
if($num_rows==0)
{ 
	echo '<div style="color: #C50202; margin-top: 23px; text-align: center;"><strong>No options available!</strong></div>'; 
}

$tree = "";                         // Clear the directory tree
$depth = 1;                         // Child level depth.
$top_level_on = 1;               // What top-level category are we on?
$exclude = ARRAY();               // Define the exclusion array
ARRAY_PUSH($exclude, 0);     // Put a starting value in it
 
WHILE ( $nav_row = MYSQL_FETCH_ARRAY($nav_query) )
{
     $goOn = 1;               // Resets variable to allow us to continue building out the tree.
     FOR($x = 0; $x < COUNT($exclude); $x++ )          // Check to see if the new item has been used
     {
          IF ( $exclude[$x] == $nav_row['id'] )
          {
               $goOn = 0;
               BREAK;                    // Stop looking b/c we already found that it's in the exclusion list and we can't continue to process this node
          }
     }
     IF ( $goOn == 1 )
     {
	 		 if($_GET["id"]==$nav_row['id'])
			 {
			 	$bgC='color: #2EAD0B !important; font-weight: bold;';
			 }
			 else
			 {
			 	$bgC='';
			 }
          
			  if($nav_row["mainMenuId"]==0)
			  {
				//$nav_URL='#';
				$nav_URL='manage_menuct.php?id=' .$nav_row['id'] .'';
				$style='style="text-align:justify; font-weight:bold;"';
				$delQuery='';
			  }
			  else
			  {
				$nav_URL='manage_menuct.php?id=' .$nav_row['id'] .'';
				$style='style="text-align:justify;"';
				$delQuery='&nbsp; <a href="manage_menuct.php?txtAction=delete&id=' .$nav_row['id'] .'" title="Delete"  onclick="return cmd_del()" style="margin-left:100px;"><img src="images/cross.png" alt="Delete" width="16" height="16" border="0"  /></a>';
			  }
		 	  
			  $treeLink=' <a href='.$nav_URL.'>  <span '.$style.'>'. $nav_row['menuName'] .'</span>  </a><div style="width: 51%; float: right; text-align-:center;'.$bgC.'">' .$nav_row['sortOrder'] .'&nbsp;&nbsp;<a href="content.php?id=' .$nav_row['id'] .'&type=' .$nav_row['menuType'] .'" style="margin-left:65px;'.$bgC.'">Update Content </a>'.$delQuery.'</div>';
		 
		  
		  $tree .= ''.$treeLink. "<br><br>";                    // Process the main tree node
          ARRAY_PUSH($exclude, $nav_row['id']);          // Add to the exclusion list
          IF ( $nav_row['id'] < 6 )
          { $top_level_on = $nav_row['id']; }
 
          $tree .= build_childTest($nav_row['id']);          // Start the recursive function of building the child tree
     }
}

 
FUNCTION build_childTest($oldID)               // Recursive function to get all of the children...unlimited depth
{
     GLOBAL $exclude, $depth;               // Refer to the global array defined at the top of this script
     $child_query = MYSQL_QUERY("SELECT * FROM "._MENU_MASTER_TABLE_."  WHERE mainMenuId=".$oldID." ");
     WHILE ( $child = MYSQL_FETCH_ARRAY($child_query) )
     {
          IF ( $child['id'] != $child['mainMenuId'] )
          {
               FOR ( $c=0;$c<$depth;$c++ )               // Indent over so that there is distinction between levels
               { $tempTree .= "&nbsp;- "; }
              
			 if($_GET["id"]==$child['id'])
			 {
			 	$bgCC='color: #2EAD0B !important; font-weight: bold;';
			 }
			 else
			 {
			 	$bgCC='';
			 }

				 $tempTreeLink=' <a href="manage_menuct.php?id=' .$child['id'] .'"> <span style="text-align:justify;'.$bgCC.'">'. $child['menuName'] .'</span> </a><div style="width: 51%; float: right; text-align-:center;'.$bgCC.'">' .$child['sortOrder'] .'&nbsp;&nbsp;<a href="content.php?id=' .$child['id'] .'&type=' .$child['menuType'] .'" style="margin-left:65px;'.$bgCC.'">Update Content </a>&nbsp; <a href="manage_menuct.php?txtAction=delete&id=' .$child['id'] .'" title="Delete"  onclick="return cmd_del()" style="margin-left:100px;"><img src="images/cross.png" alt="Delete" width="16" height="16" border="0"  /></a></div>';
			  
		  
			  
			   $tempTree .=  $tempTreeLink . "<br><br>";
               $depth++;          // Incriment depth b/c we're building this child's child tree  (complicated yet???)
               $tempTree .= build_childTest($child['id']);          // Add to the temporary local tree
               $depth--;          // Decrement depth b/c we're done building the child's child tree.
               ARRAY_PUSH($exclude, $child['id']);               // Add the item to the exclusion list
          }
		  
		  
     }

 
     RETURN $tempTree;          // Return the entire child tree
}
 
ECHO $tree;



			//echo "<div style='color: #C50202; margin-top: 23px; text-align: center;'><strong>No options available!</strong></div>";



?></td>
                    </tr>
                </table></td>
              </form>
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


		var allFldArray=["mainMenuId","menuName","txtSortOrder","txtAction"];


		if($("#txtAction").val().trim()!='edit')
		{
			if($("#mainMenuId").val().trim()=='' || $("#mainMenuId").val().trim()==0)
			{
				errorFldArray.push(['mainMenuId@@@Please Select Pages !']);
			}
		}


		if($("#menuName").val().trim()=='')
		{
			errorFldArray.push(['menuName@@@Please enter Menu Name!']);
		}

		//if($("#txtSortOrder").val().trim()!='')
//		{		
//			if(isValidateLen($('#txtSortOrder').val().trim(),2))
//			{
//				//errorFldArray.push(['txtSortOrder@@@Sort Order exceeded digits limit! Can have 2 digits.']);
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

$('#mainMenuId').focus();

</script>
<script language="javascript" type="text/javascript">



jQuery(document).ready(function()

{

	









	jQuery("#mainMenuId").change(function() 

	{

			var SubMenuId=jQuery(this).val();

	

				//alert(SubMenuId);

				
			jQuery('#hidemainMenuId1').hide();
			jQuery.post("get-menues.php",{ selected_option:SubMenuId,txtAction:'getsubmenu',rand:Math.random() }, function(data){

			//alert(data);

				if(data!='')

				{
					jQuery('#hidemainMenuId1').show();
					jQuery('#mainMenuId1').empty();

					

					jQuery.each(jQuery.parseJSON(data), function() {

	

					jQuery("<option value='"+this['id']+"'>"+this['name']+"</option>").appendTo(jQuery("#mainMenuId1"));

	

					});

	

				}

				else

				{

					//jQuery('#hidemainMenuId1').hide();
					jQuery('#mainMenuId1').empty();

					jQuery("<option value='0'>Sub Menu</option>").appendTo(jQuery("#mainMenuId1"));

				}

			});

				return false; 			 

	}); 

	jQuery("#mainMenuId1").change(function() 

	{

			var SubSubMenuId=jQuery(this).val();

	

				//alert(SubSubMenuId);

				

			jQuery.post("get-menues.php",{ selected_option1:SubSubMenuId,txtAction:'getsusubbmenu',rand:Math.random() }, function(data){

			//alert(data);

				if(data!='')

				{

					jQuery('#mainMenuId2').empty();

					

					jQuery.each(jQuery.parseJSON(data), function() {

	

					jQuery("<option value='"+this['id']+"'>"+this['name']+"</option>").appendTo(jQuery("#mainMenuId2"));

	

					});

	

				}

				else

				{

					jQuery('#mainMenuId2').empty();

					jQuery("<option value='0'>Sub Sub Menu</option>").appendTo(jQuery("#mainMenuId2"));

				}

			});

				return false; 			 

	}); 






});



</script>
</body>
</html>
