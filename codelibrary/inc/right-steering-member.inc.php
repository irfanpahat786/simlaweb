<link rel="stylesheet" href="css/colorbox.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="codelibrary/js/jquery.colorbox.js"></script>
		<script>
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
			});
		</script>
 <div class="contentbox">
  
 <div class="commetebox"> <div class="gryheader">Steering Committee Members</div>
 <div style="overflow:auto; height:100px;">
<?php
unset($selectFields);
unset($whereFields);
unset($whereVals);

$strSqlSteeringMembers="";
$strSqlSteeringMembers="Select * from "._MEMBER_MASTER_TABLE_." where memberType=1 and memberStatus=1 order by memberId DESC";

$resSteeringMembers=getRecords(_HOMEPAGE_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$strSqlSteeringMembers);

if($resSteeringMembers)
{
	$steeringMemberName="";
	$steeringmemberDesignation="";
	$steeringmemberCompany="";
	$steeringmemberPhoto="";
	$steeringmemberInterests="";
	while($rowSteeringMembers=mysql_fetch_array($resSteeringMembers))
	{
				$steeringMemberName=stripslashes($rowSteeringMembers["memberFirstName"]).' '.stripslashes($rowSteeringMembers["memberLastName"]);
				$steeringmemberDesignation=stripslashes($rowSteeringMembers["memberDesignation"]);
				$steeringmemberCompany=stripslashes($rowSteeringMembers["memberCompany"]);
				$steeringmemberPhoto=stripslashes($rowSteeringMembers["memberPhoto"]);
				$steeringmemberInterests=stripslashes($rowSteeringMembers["memberInterests"]);
				$steeringmemberId=$rowSteeringMembers["memberId"];

?>
 <div class="shadebox">
 <div class="imgborder"><img src="memberPhotos/<?php echo $steeringmemberPhoto; ?>" onerror="this.src='images/usericon.GIF'" width="58" height="89" /></div>
 <div class="contents"><strong><?php echo $steeringMemberName; ?></strong><br />
   <span class="11text" style="font-size:11px;"><?php echo $steeringmemberDesignation; ?><br>
<?php echo $steeringmemberCompany; ?></span><br />
<br />
<?php echo $steeringmemberInterests; ?>.
<?php
if(isset($_SESSION["memberId"]) && is_numeric($_SESSION["memberId"]))
{
?>
<br />
<a href="send-message.php?st=<?php echo $steeringmemberId; ?>" class="iframe"><img src="images/msg_icon.png" border="0" /></a>
<?php
}
?>
</div>
 
 
 </div>
 <?php 
	}
}
 ?>
 </div>
  </div>
  
  </div>