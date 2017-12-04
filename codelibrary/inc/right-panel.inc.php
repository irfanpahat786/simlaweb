<?php





unset($selectFields);
unset($whereFields);
unset($whereVals);

$strSql="";
$strSql="Select * from "._HOMEPAGE_MASTER_TABLE_." where elementId in("._HOMEPAGE_RIGHT_TOP_PIC_ID_.","._HOMEPAGE_VIDEO_ID_.")";

$res=getRecords(_HOMEPAGE_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$strSql);

if($res)
{
	while($row=mysql_fetch_array($res))
	{
		$elementId=$row["elementId"];
		
		switch($elementId)
		{
			case _HOMEPAGE_RIGHT_TOP_PIC_ID_ :
				$rightImageLinkTarget=$row["elementLinkTarget"];
				$rightImageLinkUrl=$row["elementLinkUrl"];
				$rightImage=$row["elementImage"];
				$rightImageTitle=$row["elementTitle"];
			break;
		
			case _HOMEPAGE_VIDEO_ID_ :
				$rightVideoLinkTarget=$row["elementLinkTarget"];
				$rightVideoLinkUrl=$row["elementLinkUrl"];
				$rightVideoImage=$row["elementImage"];
				$rightVideoTitle=$row["elementTitle"];
			break;
		
			default :
			break;
			
			
		}
	}
}


?>
<div id="bodyright">
<?php include_once('codelibrary/inc/right-steering-member.inc.php'); ?>
<div class="contentbox">
  <div class="videobox">
  <a href="<?php echo $rightVideoLinkUrl; ?>" target="<?php if($rightVideoLinkTarget==0) { ?>_self<?php } else if($rightVideoLinkTarget==1){ ?>_blank<?php } ?>"><img src="userUploads/<?php echo $rightVideoImage; ?>" width="320" height="214"    /></a>
    </div>
  </div>
  <div class="contentbox">
  <a href="<?php echo $rightImageLinkUrl; ?>" target="<?php if($rightImageLinkTarget==0) { ?>_self<?php } else if($rightImageLinkTarget==1){ ?>_blank<?php } ?>"><img src="userUploads/<?php echo $rightImage; ?>" style="margin-bottom:5px;" /></a>
  <strong><?php echo $rightImageTitle; ?>  </strong></div>
  
  
 
  
  
  
  </div>