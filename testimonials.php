<?php 
include_once('codelibrary/inc/constants-defined.inc.php');
include('inc.php');
$pageindex=8;
if(trim($_GET["pid"])!='')
{
 	
		
		 $query="SELECT * FROM "._MENU_MASTER_TABLE_."  WHERE id=".trim($_GET["pid"])." ";
				 $sqlquery=mysql_query($query);
					$getRowResults=mysql_fetch_array($sqlquery);
					
					$id=$getRowResults["id"];
					$menuName=$getRowResults["menuName"];
					$aboutDescription=$getRowResults["pageDescription"];

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

<?php include('header-scripts.php');?>
</head>

<body>
<?php include('header.php');?>
<section class="common-header-image">
  <figure class="banner-img"><img src="images/innerpage-banner.jpg" class="img-responsive"  alt=""/></figure>
  <div class="inner-product">
    <div class="container">
      <div class="ineer-service ser-pro">
        <h1><?php echo $menuName;?></h1>
      </div>
    </div>
  </div>
  </div>
</section>
<div class="clearfix"></div>
<section class="testimonials gray-bg">
  <div class="container">
   <div class="row overlap-heading">
    <div class="col-md-12">
     <h1>testimonials</h1>
    </div>
   </div>
    <div class="testmonis-container">
   <div class="row test-top">
   <div class="col-md-12">
    <?php 
					
					$query1="SELECT * FROM "._MEMBERS_TABLE_." WHERE validYN='Y' ORDER BY sortOrder,memberId ASC ";
				 $resMember=mysql_query($query1);
											
					while($rowMember=mysql_fetch_array($resMember))	
					{
					
						if($rowMember["uploaded_file"]!='')
						{
						  $usertestimonialphoto=$rowMember["uploaded_file"];
						}
						else
						{
						  $usertestimonialphoto="default-user.jpg";
						}
						
					?>
						<div class="testimonials-box">
						  <figure><img src="uploads/<?php echo $usertestimonialphoto; ?>" alt="<?php echo $rowMember["memberName"]; ?>"/></figure>
						  <div class="testimonials-details">
						  <p><em><?php echo $rowMember["description"]; ?></em></p>
						  <p class="name"><?php echo $rowMember["memberName"]; ?></p>
						  <p><?php echo $rowMember["designation"]; ?></p>
						  <p class="border"></p>
						  </div>
						</div>
						<?php 
											
					}
					?> 
	
   </div>
   </div>
   </div>
  </div>
</section>

<?php include('footer.php');?>

<?php include('footer-scripts.php');?>
</body>
</html>