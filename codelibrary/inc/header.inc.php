<?php


unset($selectFields);
unset($whereFields);
unset($whereVals);

$strSql="";
$strSql="Select * from "._HOMEPAGE_MASTER_TABLE_." where elementId="._HOMEPAGE_BANNER_ID_." ";

$res=getRecords(_HOMEPAGE_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$strSql);

if($res)
{
	while($row=mysql_fetch_array($res))
	{
		$bannerLinkTarget=$row["elementLinkTarget"];
		$bannerLinkUrl=$row["elementLinkUrl"];
		$bannerImage=$row["elementImage"];
	}
}

?>
<div id="header">
<div id="menustrip">
  <a href="mailto:jacob.varghese@pmi.org">Contact Us</a> </div>
  
  <div id="logobox">
  <div id="logo"><a href="http://www.pmi.org.in/"><img src="images/logo.GIF" /></a></div>
  <div id="topad"><a href="<?php echo $bannerLinkUrl; ?>" <?php if($bannerLinkTarget==0) { ?> <?php } else if($bannerLinkTarget==1){ ?>target="_blank" <?php } ?>><img src="userUploads/<?php echo $bannerImage; ?>" /></a></div>
  
  
  </div>
  
  
  
</div>