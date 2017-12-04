<?php 
include_once('codelibrary/inc/constants-defined.inc.php');
include('inc.php');
$resourceId=trim($_REQUEST["resourceId"]);
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
   <?php 
	  $query1news="SELECT * FROM "._RESOURCES_TABLE_."   WHERE resourceId='".$resourceId."' ";
		$sqlquerynews1=mysql_query($query1news);
		$gettotalrows=mysql_num_rows($sqlquerynews1);
		if($gettotalrows>0)
		{
			while($res_news=mysql_fetch_array($sqlquerynews1))	
			{
	?>
	   <li class="top" style="border-top:none;"><strong><a class="anchortagcl"><?php echo $res_news['resourceTitle']; ?></a></strong><br><br>
	<?php if($res_news['resourceFile']!=''){ ?>
	<figure><img src="uploads/<?php echo $res_news['resourceFile']; ?>" class="full-width" width="555" height="400"  alt="<?php echo $res_news['resourceTitle']; ?>"/></figure><br><br>
<?php } ?>

<?php if($res_news["videoLink"]!='') {?>
 <figure> <?php   echo '<iframe width="600" height="400" src="'.$res_news["videoLink"].'" frameborder="0"></iframe>';?></figure>
<?php } ?>
	<div style="font-size:14px;"><?php echo $res_news['description'];?></div>
	</li>
			<?php 
			}
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