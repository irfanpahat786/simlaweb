<?php 
include_once('codelibrary/inc/constants-defined.inc.php');
include('inc.php');
$pageindex=9;
$pagtab=2;
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
        <h1>Videos</h1>
      </div>
    </div>
  </div>
  </div>
</section>

<section class="media2">
  <div class="card">
   <?php include('nev.inc.php');?>
    
    <!-- Tab panes -->
    <div class="tab-content">      
      <div role="tabpanel" class="tab-panexxxxxxxxxx" id="Videos">
        <div class="gray-bg">
          <div class="container">
            <div class="row about-instro">
              <div class="row overlap-heading">
                <div class="col-md-12">
                  <h1>VIDEOS</h1>
                </div>
              </div>
            </div>
                <div class="row career media-top1">           
               <?php 
	 $queryvideos="SELECT * FROM "._RESOURCES_TABLE_."   WHERE pageType='videos' AND validYN='Y' order by resourceId DESC LIMIT 0,50 ";
		$sqlqueryvideos=mysql_query($queryvideos);
											
		while($res_menuvideos=mysql_fetch_array($sqlqueryvideos))	
		{
?>
                    <div class="col-md-4 col-sm-6">
      <div class="media-box1">
     
      <figure> <?php if ($res_menuvideos["videoLink"]!='') { echo '<iframe width="360" height="227" src="'.$res_menuvideos["videoLink"].'" frameborder="0"></iframe>'; } ?></figure>
     
      <div class="caption"><?php echo $res_menuvideos['resourceTitle']; ?></div>
      </div>

     </div>
     
    
            <?php 
		}
?>   </div>
          </div>
        </div>
       
      </div>
      
    </div>
  </div>
</section>

<?php include('queryform.php');?>

<?php include('footer.php');?>

<?php include('footer-scripts.php');?>
</body>
</html>