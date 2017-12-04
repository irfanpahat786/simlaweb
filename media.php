<?php 
include_once('codelibrary/inc/constants-defined.inc.php');
include('inc.php');
$pageindex=9;
$pagtab=1;
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
        <h1>Media</h1>
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
      <div role="tabpanel" class="tab-pane active" id="newstab">
        <div class="gray-bg">
          <div class="container">
            <div class="row about-instro">
              <div class="row overlap-heading">
                <div class="col-md-12">
                  <h1>NEWS</h1>
                </div>
              </div>
            </div>
              <div class="row media-top">
             <?php 
	 $query1news="SELECT * FROM "._RESOURCES_TABLE_."   WHERE pageType='news' AND validYN='Y' order by resourceId DESC LIMIT 0,50 ";
		$sqlquerynews1=mysql_query($query1news);
		$s1=0;								
		while($res_news=mysql_fetch_array($sqlquerynews1))	
		{
		
?>
			  
               <div class="col-md-6 col-sm-6">
                  <div class="<?php if($s1>0){?>ne-ws-box<?php }else{?>news-box<?php }?>">
                     <figure><img src="uploads/<?php echo $res_news['resourceFile']; ?>" class="full-width" width="555" height="370"  alt="<?php echo $res_news['resourceTitle']; ?>"/></figure>
                      <div class="news-discription">
                       <p class="head"><strong><?php echo $res_news['resourceTitle']; ?></strong></p>
                          <p> <span class="more"><?php //echo strip_tags($res_news['description'], '<p></p>');
						   $text=str_replace('<p>','',$res_news['description']);					   
						   $text=str_replace('</p>','',$res_news['description']); ?><?php echo $text;//echo $res_news['description']; ?></span></p>
                      </div>
                 </div>
               </div>
               
                         
           <?php 
		$s1++;}
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