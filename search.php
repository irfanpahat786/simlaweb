<?php 
include_once('codelibrary/inc/constants-defined.inc.php');
include('inc.php');
$strSearch=trim($_REQUEST["txtSearch"]);
if($strSearch!='')
{
	$strWhere=" and resourceTitle like '%".$strSearch."%' OR description like '%".$strSearch."%' ";
}
else
{
	$strSearch='';
	$strWhere='';
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../../favicon.ico">
<title>:: SIMALABS ::</title>
<style>
.anchortagcl{color: #000 !important;
    font-size: 20px !important;
    text-transform: none !important;
    float: none !important;
    font-family: none !important;
    letter-spacing: 0px !important;
    text-decoration: none !important;}
</style>
<?php include('header-scripts.php');?>
</head>

<body>
<?php include('header.php');?>

<div class="card">
    <!-- Tab panes -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="newstab">
        <div class="gray-bg">
          <div class="container">
			 
			  <div class="container careers gray-bg padding-top-bottom" style="padding:0px;">
   <div class="career-container">
    <div class="row">
     <div class="col-md-12">
   <ul class="list-unstyled apply">
    <li class="top" style="border-top:none;">Search result for <strong>"<?php echo $strSearch;?>"</strong><br>
   <?php 
   if($strSearch!='')
   {
	  $query1news="SELECT * FROM "._RESOURCES_TABLE_."   WHERE pageType='news' AND validYN='Y' ".$strWhere."  order by resourceId DESC LIMIT 0,50 ";
		$sqlquerynews1=mysql_query($query1news);
		$gettotalrows=mysql_num_rows($sqlquerynews1);
		if($gettotalrows>0)
		{
			while($res_news=mysql_fetch_array($sqlquerynews1))	
			{
	?>
	   <li class="top" style="border-top:none;"><strong><a class="anchortagcl" href="viewdetail.php?resourceId=<?php echo $res_news['resourceId']; ?>&txtSearch=<?php echo $strSearch;?>"><?php echo $res_news['resourceTitle']; ?></a></strong><br>	
	<div style="font-size:14px;"><?php  
	
	if(strlen($res_news['description']) > 50){ echo $str = substr($res_news['description'], 0, 300) . '...';}else{ echo $res_news['description'];}?></div>
	</li>
			<?php 
			}
		}
?> 
<?php 
	  $query1news1="SELECT * FROM "._RESOURCES_TABLE_."   WHERE pageType='events' AND validYN='Y' ".$strWhere." order by resourceId DESC LIMIT 0,50 ";
		$sqlquerynews11=mysql_query($query1news1);
		$gettotalrows1=mysql_num_rows($sqlquerynews11);
		if($gettotalrows1>0)
		{
			while($res_news1=mysql_fetch_array($sqlquerynews11))	
			{
	?>
	   <li class="top" style="border-top:none;"><strong><a class="anchortagcl" href="viewdetail.php?resourceId=<?php echo $res_news1['resourceId']; ?>&txtSearch=<?php echo $strSearch;?>"><?php echo $res_news1['resourceTitle']; ?></a></strong><br>	
	<div style="font-size:14px;"><?php  
	
	if(strlen($res_news1['description']) > 50){ echo $str = substr($res_news1['description'], 0, 300) . '...';}else{ echo $res_news1['description'];}?></div>
	</li>
			<?php 
			}
		}
?> 
<?php 
	  $query1news11="SELECT * FROM "._RESOURCES_TABLE_."   WHERE pageType='videos' AND validYN='Y' ".$strWhere." order by resourceId DESC LIMIT 0,50 ";
		$sqlquerynews111=mysql_query($query1news11);
		$gettotalrows11=mysql_num_rows($sqlquerynews111);
		if($gettotalrows11>0)
		{
			while($res_news11=mysql_fetch_array($sqlquerynews111))	
			{
	?>
	   <li class="top" style="border-top:none;"><strong><a class="anchortagcl" href="viewdetail.php?resourceId=<?php echo $res_news11['resourceId']; ?>&txtSearch=<?php echo $strSearch;?>"><?php echo $res_news11['resourceTitle']; ?></a></strong>	
	</li>
			<?php 
			}
		}
		
			if($gettotalrows==0 && $gettotalrows1==0 && $gettotalrows11==0)
			{
			?>
			<li class="top" style="border-top:none;">Unable to locate any items containing the <strong>provided search text.</strong> Please try again.</li>
			<?php
			}
		
		}
		else
		{
		?>
		<li class="top" style="border-top:none;">Unable to locate any items containing the <strong>provided search text.</strong> Please try again.</li>
		<?php
		}
?>    
   </ul>
     </div>
    </div>
   </div>
  </div>  
            
          </div>
        </div>
      
        
      </div>
      
      
    </div>
  </div>

<?php include('footer.php');?>

<?php include('footer-scripts.php');?>
</body>
</html>