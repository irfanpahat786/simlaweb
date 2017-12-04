<?php 
include_once('codelibrary/inc/constants-defined.inc.php');
include('inc.php');
$pageindex=9;
$pagtab=3;
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
        <h1>EVENTS</h1>
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
      <div role="tabpanel" class="tab-panexxxxxxxxxx" id="Events">
      
           <div class="gray-bg">
          <div class="container">
            <div class="row about-instro">
              <div class="row overlap-heading">
                <div class="col-md-12">
                  <h1>EVENTS</h1>
                </div>
              </div>
            </div>
              <div class="row media-top">
              <?php 
	 $query13="SELECT * FROM "._RESOURCES_TABLE_."   WHERE pageType='events' AND validYN='Y' order by resourceId DESC LIMIT 0,50 ";
		$sqlquery13=mysql_query($query13);
											
		while($res_menu13=mysql_fetch_array($sqlquery13))	
		{
?>
			  
               <div class="col-md-6 col-sm-6">
                  <div class="news-box">
                     <figure><img src="uploads/<?php echo $res_menu13['resourceFile']; ?>" class="full-width" width="555" height="370"  alt="<?php echo $res_menu13['resourceTitle']; ?>"/></figure>
                      <div class="news-discription">
                       <p class="head"><strong><?php echo $res_menu13['resourceTitle']; ?></strong></p>
                          <p> <span class="more"><?php //echo $res_menu13['description']; ?></span></p>
                      </div>
                 </div>
               </div>
			   
               
             
			<?php 
		}
?>  
        </div>         
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