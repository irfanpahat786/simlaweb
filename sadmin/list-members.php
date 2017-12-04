<?php 
include_once('../codelibrary/inc/constants-defined.inc.php');
include_once('../codelibrary/inc/database.inc.php');
include_once('../codelibrary/inc/functions.inc.php');
include_once('../codelibrary/inc/check-admin-session.php');
$pageIndex=188;

openConn();
$contentType=$_GET['type'];

$msgClass="error_message red_error";

if($_GET["success"]=="1" || $_GET["success"]==1)
{
	$errorMsg="Added Successfully!"; 
	$msgClass="error_message green_msg";
}
else if($_GET["success"]=="2" || $_GET["success"]==2)
{
	$errorMsg="Updated Successfully!";
	$msgClass="error_message green_msg";
}

if($_GET["txtDelAction"]=="")
{

	if($_GET["_j"]==md5("DELETE"))
	{
		if(trim($_GET["txtParam1"])!='' && is_numeric($_GET["txtParam1"]))
		{		
			
			unset($insertFields);
			unset($insertVals);
			unset($whereFields);
			unset($whereVals);
	
			$whereFields[0]="memberId";
	
			$whereVals[0]=$_GET["txtParam1"];
			
			$resUpdateBanner=deleteDB(_MEMBERS_TABLE_,$whereFields,$whereVals,_N_,'');
			if($resUpdateBanner)
			{						
				$errorMsg="Member Deleted Successfully! ";
				$msgClass="red_error";
									
					if(trim($_REQUEST["txtParam4"])!='' && is_file("../uploads/".$_REQUEST["txtParam4"]))
										unlink("../uploads/".$_REQUEST["txtParam4"]);
			}	
		}
	
	}
	else if($_GET["_j"]==md5("UPDATE") && $_GET["validYN"]!='')
	{
		if(trim($_GET["txtParam1"])!='' && is_numeric($_GET["txtParam1"]))
		{
				
				if($_GET["validYN"]=='Y'){ $validYNText=_ACTIVATE_TEXT_;}else{$validYNText=_DEACTIVATE_TEXT_;}
				
				
				unset($insertFields);
				unset($insertVals);
				unset($whereFields);
				unset($whereVals);
				
				$insertFields[0]="validYN";
				
				
				$insertVals[0]=$_GET["validYN"];
	
			
				$whereFields[0]="memberId";
				
				$whereVals[0]=$_GET["txtParam1"];
				
				$resBuilderUpdate=updateDB(_MEMBERS_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');
				$errorMsg="Member has been ".$validYNText.".";
				$msgClass="green_msg";				
				
			}
	}
}


	

	//$action=$_GET["txtDelAction"];
	//echo $_GET["txtDelAction"].' --- '.$action;	
	//print_r($_GET);

	if(clean($_GET["txtDelAction"])=="delall")
	{		$selectedRecords=$_GET["chkdelete"];
		//echo '<br>ssssssssssssss'.$selectedRecords.'ffffffffffffffff'.$_GET["chkdelete"].'xxxxxxxxxxxxx';
		if(count($selectedRecords)<=0)
		{
			$errorMsg="Please select atleast one member to delete";
			$msgClass='red_error';
		}
		if(count($selectedRecords)>1)
		{
			$strs='s';
		}
		if(trim($errorMsg)=='')
		{
			for($iRecord=0;$iRecord<=count($selectedRecords)-1;$iRecord++)
			{
				$delId=$selectedRecords[$iRecord];
				
				unset($whereFields);
				unset($whereVals);
		
				$whereFields[0]="memberId";
		
				$whereVals[0]=$delId;
				$resDel=deleteDB(_MEMBERS_TABLE_,$whereFields,$whereVals,_N_,'');

			}
				
				$errorMsg="Member".$strs." has been deleted successfully. ";
				$msgClass="red_error";
		}
		
	}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<title>List Testimonials</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link href="css/validate.css" rel="stylesheet" type="text/css" />
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/ddaccordion.js"></script>

</head>

<script type="text/JavaScript">
jQuery('#txtDelAction').removeAttr('disabled');
function cmd_del(){
var x= confirm("Do you want to delete ?");
if(x)
{
	jQuery("#txtDelAction").val('delall');
	return true;
}
else 
{
	jQuery("#txtDelAction").val('');
	return false;
}


}

function cmd_singledel(){
var x= confirm("Do you want to delete this record?");
if(x)
{
	return true;
}
else 
{
	return false;
}


}
</script>


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
	<h1>Testimonials</h1>
	<a href="add-edit-members.php" class="graybgbtn" style="float:left;margin-left: 10px;">Add New</a>
	</div>
	
	
	
	<div class="rightbodysec">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="28%" align="left" valign="top"><form id="NewsAndEvents" name="NewsAndEvents" method="get">
		  
            <table width="99%" border="0" align="center" cellpadding="6" cellspacing="0"  class="mainbordersec">
				<?php
				if($_REQUEST["txtNumRows"]!='' && isset($_REQUEST["txtNumRows"]) && is_numeric($_REQUEST["txtNumRows"]))
					$limit=$_REQUEST["txtNumRows"];
				else
					$limit=15;
				
				
				
				if(trim($_REQUEST["txtPageNo"])!="" && is_numeric($_REQUEST["txtPageNo"]))
				{
					$pageNo=$_REQUEST["txtPageNo"];
					$pageNoText=" Page ".$pageNo;
				}
				else
					$pageNo=1;
					
				
				
				
				
			?>
              <tr>
                <td colspan="7" align="left" valign="top" ><table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="left" valign="top"><input name="txtSearch" type="text" id="txtSearch" value="<?php echo $_REQUEST["txtSearch"]; ?>" placeholder="Search by Name" size="40" style="padding: 5px;
border: 1px solid #CCC;
    height: 28px;" /> &nbsp;&nbsp;
                      <select name="validYNStatus" id="validYNStatus" style="width:184px;">
                        <option value="" <?php if($_REQUEST["validYNStatus"]==""){?>selected="selected"<?php } ?>>--- All Testimonials ---</option>
                        <option value="Y" <?php if($_REQUEST["validYNStatus"]=="Y"){?>selected="selected"<?php } ?>>Active Testimonials</option>
                        <option value="N" <?php if($_REQUEST["validYNStatus"]=="N"){?>selected="selected"<?php } ?>>Inactive Testimonials</option>
                    </select>                   </td>
                    <td align="left" valign="top" style="padding-left:10px;"><input name="Search" type="submit" id="Search" value="Search" class="graybgbtn btnLarge" />
                        <?php //if(trim($_REQUEST["txtSearch"])!='' || $_REQUEST["validYNStatus"]!='') { ?>
                        <input type="button" name="Button" value="View All" onclick="javascript: window.location.href='<?php echo htmlentities($_SERVER['PHP_SELF']); ?>';" class="graybgbtn btnLarge" />
                        <?php //} ?></td>
                  </tr>
                </table></td>
              </tr>
				<?php if(trim($errorMsg)!='') { ?>
              <tr>
                <td colspan="7" align="center" valign="top" style="padding:5px;" class="<?php echo $msgClass; ?>"><?php echo $errorMsg; ?></td>
                </tr>
				<?php } ?>
            <?php 
			
				if($_REQUEST["txtNumRows"]!='' && isset($_REQUEST["txtNumRows"]) && is_numeric($_REQUEST["txtNumRows"]))
					$limit=$_REQUEST["txtNumRows"];
				else
					$limit=15;
				
				
				
				if(trim($_REQUEST["txtPageNo"])!="" && is_numeric($_REQUEST["txtPageNo"]))
				{
					$pageNo=$_REQUEST["txtPageNo"];
					$pageNoText=" Page ".$pageNo;
				}
				else
					$pageNo=1;
					
					
			
				unset($selectFields);
				unset($whereFields);
				unset($whereVals);
				
				$sqlQuery="";
				$sqlQuery="Select * from "._MEMBERS_TABLE_." WHERE 1 ";
				if(trim($_REQUEST["txtSearch"])!='')
				{
					$sqlQuery.=" AND memberName like '%".trim(clean($_REQUEST["txtSearch"]))."%' or designation like '%".trim(clean($_REQUEST["txtSearch"]))."%' or phone_number like '%".trim(clean($_REQUEST["txtSearch"]))."%' or email_address like '%".trim(clean($_REQUEST["txtSearch"]))."%' or location like '%".trim(clean($_REQUEST["txtSearch"]))."%' or description like '%".trim(clean($_REQUEST["txtSearch"]))."%' ";
				}
				if($_REQUEST["validYNStatus"]!='')
				{
					 $sqlQuery.=" AND validYN='".trim(clean($_REQUEST["validYNStatus"]))."' ";
				}
				
				
				$sqlQuery.="  order by sortOrder,memberId ASC ";
				
				//echo "<!-- ".$sqlQuery." -->";
				
				$resNews=getRecords(_MEMBERS_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlQuery);
		
				if($resNews)
				{
					$totalRecords=mysql_num_rows($resNews);
			
			?><tr>
			    <td height="35" colspan="7" align="left" valign="top" style="padding:5px;">
				<div id="divdelete">
								<table width="100%" border="0" cellspacing="2" cellpadding="2">
							  <tr>
								<td width="43%" align="left" valign="top" class="graybt">
								  <input name="cmdSubmit" type="submit" id="cmdSubmit" value="Delete"  onclick="javascript: return cmd_del();" class="graybgbtn" style="color:#FFFFFF; background-color:#e43333; border:1px solid #e43333;" />
								  <input name="txtDelAction" type="hidden" id="txtDelAction" />								</td>
							  </tr>							 
								</table>
							</div></td>
			    </tr>
			  <tr>
			    <td width="4%" align="left" valign="top" class="graysecheader" style="padding:5px;"><input type="checkbox" id="chkAllAdd" name="chkAllAdd" /></td>
			    <td width="34%" height="35" align="left" valign="top" class="graysecheader" style="padding:5px;"> Name </td>
				<td width="17%" align="left" valign="top" class="graysecheader" style="padding:5px;">Photo </td>
				<td width="13%" align="left" valign="top" class="graysecheader" style="padding:5px;">Added Date </td>
				<td width="9%" align="left" valign="top" class="graysecheader" style="padding:5px;">Order</td>
				<td width="7%" align="left" valign="top" class="graysecheader" style="padding:5px;"><strong>Status </strong></td>
				<td width="16%" align="left" valign="top" class="graysecheader" style="padding:5px;">Action<span style="float:right; padding-right:5px;"><?php echo $totalRecords; ?> Testimonials</span></td>
              </tr>
              
			<?php
			
				
					
		
		
					$pages=ceil($totalRecords/$limit);
					
					$currentPage=$pageNo-1;
					
					if($currentPage<0 || $currentPage>$pages)
					{
						$currentPage=0;
						$pageNo=1;
					}
		
					$page_min =0;
					$page_max = 0;
					
					
					if($pages>1)
					{
						$range =15;
						$range_min = ($range % 2 == 0) ? ($range / 2) - 1 : ($range - 1) / 2;
						$range_max = ($range % 2 == 0) ? $range_min + 1 : $range_min;
						$page_min = $pageNo- $range_min;
						$page_max = $pageNo+ $range_max;
					
						$page_min = ($page_min < 1) ? 1 : $page_min;
						$page_max = ($page_max < ($page_min + $range - 1)) ? $page_min + $range - 1 : $page_max;
					
						if ($page_max > $pages)
						{
							$page_min = ($page_min > 1) ? $pages - $range + 1 : 1;
							$page_max = $pages;
						}
					
						$page_min = ($page_min < 1) ? 1 : $page_min;
					
						//$page_content .= '<p class="menuPage">';
					
						if ( ($pageNo > ($range - $range_min)) && ($pages > $range) ) {
							$page_pagination .= '<a class="num"  title="First" href="'.$_SERVER['REDIRECT_URL'].'/?page=1">&lt;</a> ';
						}
					
						if ($pageNo != 1) {
							$page_pagination .= '<a class="num" href="'.$_SERVER['REDIRECT_URL'].'?/page='.($pageNo-1). '">Previous</a> ';
						}
					
						for ($i = $page_min;$i <= $page_max;$i++) {
							if ($i == $pageNo)
							$page_pagination .= '<span class="num"><strong>' . $i . '</strong></span> ';
							else
							$page_pagination.= '<a class="num" href="'.$_SERVER['REDIRECT_URL'].'/?page='.$i. '">'.$i.'</a> ';
						}
					
						if ($pageNo < $pages) {
							$page_pagination.= ' <a class="num" href="'.$_SERVER['REDIRECT_URL'].'/?page='.($pageNo + 1) . '">Next</a>';
						}
					
					
						if (($pageNo< ($pages - $range_max)) && ($pages > $range)) {
							$page_pagination .= ' <a class="num" title="Last" href="'.$_SERVER['REDIRECT_URL'].'/?page='.$pages. '">&gt;</a> ';
						}
					
					//	$page['PAGINATION'] ='<p id="pagination">'.$page_pagination.'</p>';
					}		
					else
					{
						$page_min =1;
						$page_max = 1;
					}		
					
						
					$newOffset=$currentPage*$limit;
					$sqlQuery.=" limit ".$newOffset.",".$limit."";
					$resNews=getRecords(_MEMBERS_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlQuery);
					if($resNews)
					{
						$srNo=$newOffset;
						
						$catcount=1;
						$strClass='class="lightgrayrow"';
						$strMouseOutColor='#EFEFEF';
						$month_name='';
						$producer='';
						$categoryName='';
						while($rowNews=mysql_fetch_array($resNews))
						{
							$srNo++;
							
							
								if($strMouseOutColor=='#EAEAEA')
								{
									$strClass='class="white-tr"';
									$strMouseOutColor='#FFFFFF';
								}
								else
								{
									 $strClass='class="white-tr lightgrayrow"';
									 $strMouseOutColor='#EAEAEA';
								}
								
								
								$getDate = strtotime($rowNews["dateAdded"]);
								

?>
						  <tr  <?php echo $strClass; ?>>
						    <td align="left" valign="top"><input name="chkdelete[]" type="checkbox" id="chkdelete<?php echo $counter; ?>" value="<?php echo trim($rowNews["memberId"]); ?>" class="deleteChk" /><?php	//echo $srNo ?></td>
						    <td align="left" valign="top"><?php echo $rowNews["memberName"]; ?></td>
							<td align="left" valign="top"><img src="../uploads/<?php echo $rowNews["uploaded_file"]; ?>" height="100" width="100" /></td>
							<td align="left" valign="top"><?php //echo date("F d,  Y", $rowNews["dateAdded"]); ?><?php echo date("Y/m/d",$rowNews["dateAdded"]); ?></td>
							<td align="left" valign="top"><?php echo $rowNews["sortOrder"]; ?></td>
							<td align="left" valign="top"><?php if($rowNews["validYN"]=='N'){ ?><a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>?validYN=Y&_j=<?php echo md5("UPDATE"); ?>&txtParam1=<?php echo $rowNews["memberId"]; ?>" title="Inactive">Inactive</a><?php }else{?><a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>?validYN=N&_j=<?php echo md5("UPDATE"); ?>&txtParam1=<?php echo $rowNews["memberId"]; ?>" title="Active">Active</a><?php }?></td>
						    <td align="left" valign="top">
                              <table border="0" cellpadding="2" cellspacing="2">
							<tr>
							<td><a href="add-edit-members.php?editid=<?php echo $rowNews["memberId"]; ?>"><img src="images/pencil.png" alt="Edit" width="16" height="16" title="Edit" border="0"></a></td>
							<td>&nbsp;</td>
                            <td><a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>?_b=<?php echo md5("ADMINCRC"); ?>&_j=<?php echo md5("DELETE"); ?>&txtParam1=<?php echo $rowNews["memberId"]; ?>&txtParam2=0&txtParam3=<?php echo $rowNews["coverFileName"]; ?>&txtParam4=<?php echo $rowNews["uploaded_file"]; ?>" onclick="javascript: return cmd_singledel();" title="Delete"><img src="images/cross.png" alt="Delete" width="16" height="16" border="0" /></a></td>
							</tr>
							</table></td>
						  </tr>
			<?php
									
			
			
			}
			?>
						<tr>
						  <td align="center" valign="top" style="padding:5px;">&nbsp;</td>
						  <td align="center" valign="top" style="padding:5px;">&nbsp;</td>
                          <td align="center" valign="top" style="padding:5px;">&nbsp;</td>
                          <td align="center" valign="top" style="padding:5px;">&nbsp;</td>
                          <td align="center" valign="top" style="padding:5px;">&nbsp;</td>
                          <td align="center" valign="top" style="padding:5px;">&nbsp;</td>
                        <td align="center" valign="top" style="padding:5px;">&nbsp;</td>
              </tr>
						<?php 
					}
				}
				else
				{
				
			
			?>
              <tr>
                <td colspan="7" align="center" valign="top" style="padding:5px; color:#FF0000">no record found.</td>
              </tr>
			  <?php } ?>
			   <tr>
                <td colspan="7" align="left" valign="top" style="padding:5px;">&nbsp;</td>
              </tr>
			    <?php 
				if($pages>1)
				{
				?>
              <tr>
                <td colspan="7" align="left" valign="top" style="padding:5px;">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="32%" align="right">
	<?php if($pageNo>1)
	{
		$prevPage=$pageNo-1;
	?>
		<a href="#"  onclick="javascript: document.NewsAndEvents.txtPageNo.value='<?php echo $prevPage; ?>';document.NewsAndEvents.submit();">&lt; previous</a>
	<?php
	}
	?>	</td>
    <td width="41%" align="center">
	<?php if($pageNo>0 && $pages>0)
	{
	?>
	<?php
		$strPages='';
		for($pg=$page_min;$pg<= $page_max;$pg++)
		{
			if($pg==$pageNo)
				$strPages.='<b>'.$pg.'</b> | ';
			else
				$strPages.='<a href="#"  onclick="javascript: document.NewsAndEvents.txtPageNo.value='.$pg.';document.NewsAndEvents.submit();">'.$pg.'</a> | ';
		}
		
		$strPages=trim($strPages," | ");
		
		echo $strPages;
	?>
	<?php
	}
	?>	</td>
    <td width="27%" align="left"><input name="txtPageNo" type="hidden" id="txtPageNo" value="<?php echo $pageNo; ?>" />
	<?php if($pageNo>=1 && $pages>$pageNo)
	{
		$nextPage=$pageNo+1;
	?>
		<a href="#"  onclick="javascript: document.NewsAndEvents.txtPageNo.value='<?php echo $nextPage; ?>';document.NewsAndEvents.submit();">next &gt;</a>
	<?php
	}
	?>	</td>
  </tr>
</table></td>
                </tr>
                
                <?php 
				}
				?> 
            </table>
                    </form>          </td>
          </tr>
      </table>
	</div>
	
	
	
	</div></td>
  </tr>
</table>
<script language="javascript" type="text/javascript">


jQuery(document).ready(function()
{
	jQuery("#divdelete").hide();
	//alert('ok');
	jQuery(".deleteChk").click(function()
	{
		//alert('ok222');
			if(jQuery(".deleteChk:checkbox:checked").length > 0)
			{
				//alert('ok333');
				jQuery("#divdelete").show();
				
			////return true;
			}
			else
			{
			   jQuery("#divdelete").hide();
			   /////return false;
			}
	   
	   
////		var counter = 0;
////		var groupSelector = $("input[name=chkdelete[]]:checked");
////		jQuery.each(groupSelector, function () {
////			 counter++;
////		});
	////alert(counter);
	
	});

	/*jQuery("#frmInquiry").submit(function()
	{
		alert('frm');
		jQuery('#cmdSubmit').removeAttr('disabled');
 		return false; //not to post the  form physically
	});*/
	
	
			$(function(){
			
			// add multiple select / deselect functionality
				$("#chkAllAdd").click(function () {
				  $('.deleteChk').attr('checked', this.checked);
				  if( this.checked==true)
				  $("#divdelete").show();
				  else
				  $("#divdelete").hide();
				});
				
					$(".deleteChk").click(function(){
				
					if($(".deleteChk").length == $(".deleteChk:checked").length) {
						$("#chkAllAdd").attr("checked", "checked");
					} else {
						$("#chkAllAdd").removeAttr("checked");
					}
				
				});
			});
	
	
	
	
});

$("#txtSearch").focus();
</script>
</body>
</html>