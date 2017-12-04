<?php 
include_once('../codelibrary/inc/constants-defined.inc.php');
include_once('../codelibrary/inc/database.inc.php');
include_once('../codelibrary/inc/functions.inc.php');
include_once('../codelibrary/inc/check-admin-session.php');


openConn();

$action="add";

$pageIndex=8;

if(isPost())
{
	$errorMsg='';		
	
	$action=$_POST["txtAction"];
	
	$categoryId=$_POST["txtParam1"];
		
	$sortOrder=clean($_POST["sortOrder"]);	 
	$categoryName=clean($_POST["categoryName"]);
	if($categoryName!='')
	{
		$categoryUrl=makeContentUrl($categoryName);
	}
	$strCategoryId="";	
	if(trim(strtolower($action))=="edit")
	{
		$strCategoryId="and categoryId!=".$categoryId." ";
	}
	else
	{
		$strCategoryId="";
	}	
	
	
	if(trim($categoryName)=='')
	{
		$errorMsg="Please enter category name !";
	}	
	
	if(trim($errorMsg)=='')
	{
		unset($selectFields);
		unset($whereFields);
		unset($whereVals);

		$sqlcategory="";
		$sqlcategory="Select categoryName from "._CATEGORIES_TABLE_." where categoryName = '".$categoryName."' ".$strCategoryId." ";
		$rescategory=getRecords(_CATEGORIES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlcategory);
		if($rescategory)
		{
			$errorMsg="Category '".$categoryName."' already exists in database";
		}

	}

	
	if(trim(strtolower($action))=="add")
	{

		if(trim($errorMsg)=='')
		{							
				unset($insertFields);
				unset($insertVals);
				
				$insertFields[0]="categoryName";
				$insertFields[1]="dateAdded";
				$insertFields[2]="dateModify";
				$insertFields[3]="sortOrder";
				$insertFields[4]="categoryUrl";
				
				
				$insertVals[0]=$categoryName;
				$insertVals[1]=time();
				$insertVals[2]=time();
				$insertVals[3]=$sortOrder;
				$insertVals[4]=$categoryUrl;
				
				$resMenuInsert=insertDB(_CATEGORIES_TABLE_,$insertFields,$insertVals,_N_,'');
			
			
				header("location:categories.php?success=1");
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
			
			$insertFields[0]="categoryName";
			$insertFields[1]="dateModify";
			$insertFields[2]="categoryUrl";
			$insertFields[3]="sortOrder";
			
			
			$insertVals[0]=$categoryName;
			$insertVals[1]=time();
			$insertVals[2]=$categoryUrl;
			$insertVals[3]=$sortOrder;

		
			$whereFields[0]="categoryId";
			
			$whereVals[0]=$categoryId;
			
			$resBuilderUpdate=updateDB(_CATEGORIES_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');
			
			
			header("location:categories.php?success=2");
			exit();
			
		
		}
	
	}
}

if($_GET["editid"]!='' && is_numeric($_GET["editid"]))
{
	
	unset($selectFields);
	unset($whereFields);
	unset($whereVals);
	
	$sqlEdit="";
	$sqlEdit="Select * from "._CATEGORIES_TABLE_." where categoryId=".$_GET["editid"];
	
	$resNews=getRecords(_CATEGORIES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEdit);
	
	if($resNews)
	{
		while($rowNews=mysql_fetch_array($resNews))
		{
			$categoryId=$rowNews["categoryId"];
			$categoryName=$rowNews["categoryName"];
			$sortOrder=$rowNews["sortOrder"];
		}
		$action="edit";
	}
	
}




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<title><?php echo ucfirst($action); ?> Category</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">

<link href="css/validate.css" rel="stylesheet" type="text/css" />

<link href="css/main.css" rel="stylesheet" type="text/css" />

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript" src="js/jquery.js"></script>

<script type="text/javascript" src="js/ddaccordion.js"></script>
<style>

.erorfldcls{color:#FF0000; font-size:12px; margin-bottom:5px; display:none;}

</style>
</head>

<body id="homeinnerbg">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10%" align="left" valign="top" style="width:156px;">
	<?php include("left.php"); ?>
	
	
	</td>
    <td width="90%" align="left" valign="top">
	<div id="rightbody">
<?php include("header.php"); ?>
	
	<div class="rightbodysec">
	<h1><?php echo ucfirst($action); ?> Category</h1>
	</div>
	
	
	
	<div class="rightbodysec">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="28%" align="left" valign="top"><form action="" method="post" enctype="multipart/form-data" name="frmcategory" id="frmcategory">
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
                <td width="17%" align="left" valign="top" style="padding:5px;"><span class="red_star">*</span>&nbsp;Category Name</td>
                <td width="83%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_categoryName"></div><input name="categoryName" type="text" id="categoryName" value="<?php echo $categoryName; ?>"  class="fiellength" onkeyup="hideerrordiv(this.id);" /></td>
              </tr>
			  
				  <tr>
                <td width="17%" align="left" valign="top" style="padding:5px;">&nbsp;&nbsp; Order</td>
                <td width="83%" align="left" valign="top" style="padding:5px;"><div class="erorfldcls" id="fld_sortOrder"></div><input name="sortOrder" type="text" id="sortOrder" value="<?php echo $sortOrder; ?>"  class="fiellength" onkeyup="hideerrordiv(this.id);" style="width:50px !important;"  onkeypress="return blockNonNumbers(this, event, true, false);" maxlength="3"/></td>
              </tr>
				
              <tr>
                <td align="left" valign="top" style="padding:5px;">&nbsp;</td>
                <td align="left" valign="top" style="padding:5px;">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top" style="padding:5px;"><input name="txtAction" type="hidden" id="txtAction" value="<?php echo $action; ?>" /><input type="hidden" name="txtParam1" id="txtParam1" value="<?php echo $_GET["editid"]; ?>" /></td>
                <td align="left" valign="top" style="padding:5px;"><input name="Submit2" type="submit" class="bluebutton" value="Submit" />&nbsp;&nbsp;
				<a href="javascript:history.back()"><input name="button" type="button" class="bluebutton" value="<< Back" /></a></td>
              </tr>
            </table>
                    </form>          </td>
          </tr>
      </table>
	</div>
	
	
	
	</div></td>
  </tr>
</table>
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
	$("#frmcategory").submit(function()
	{

		var errorFldArray=[];

		var allFldArray=["categoryName"];
			
			
			if($("#categoryName").val().trim()=='')
			{
	
				errorFldArray.push(['categoryName@@@Please enter category name !']);
	
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



$("#categoryName").focus();
</script>
</body>
</html>
