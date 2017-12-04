<?php 
include_once('codelibrary/inc/constants-defined.inc.php');
include('inc.php');
$pageindex=1;
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

<section class="service-product">
  <figure class="banner-img"><img src="images/bg.jpg" class="img-responsive"  alt=""/></figure>
  <div class="inner-product home-page-slider">
    <div class="container">
      <div class="ineer-service ser-pro">
        <h1>Service & Products</h1>
        <div class="row">
          <div class="col-md-4 col-sm-4"> <a href="tap.php?pid=3&mid=9">
            <div class="pro-box"> <img src="images/product1.jpg" alt=""/>
              <h2>Testing</h2>
             
            </div>
            </a> </div>
          <div class="col-md-4 col-sm-4"> <a href="tap.php?pid=3&mid=10">
            <div class="pro-box"> <img src="images/product2.jpg" alt=""/>
              <h2>Amc</h2>
            </div>
            </a> </div>
          <div class="col-md-4 col-sm-4"> <a href="tap.php?pid=3&mid=11">
            <div class="pro-box"> <img src="images/product3.jpg" alt=""/>
              <h2>Project</h2>
            </div>
            </a> </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>
<div class="clearfix"></div>
<section class="intro">
  <div class="container">
    <div class="intro-content">
      <h2>Sophisticated Industrial Materials
        Analytic Labs. Pvt. Ltd</h2>
      <p>SIMA LABS PVT.LTD. is a venture by professionally qualified personnels and manned by a team of highly experienced technical staff.</p>
      <p>The Company is engaged in the testing of Drugs, Pharmaceuticals, Chemicals, Cosmetics, Dyes & Dye Intermediates, Food & Food products, Oil & Oil Cakes, Poultry Feed, Water, Waste Water, Air Pollution, Noise Monitoring, EIA & EMP Studies....<a href="about.html">Read more</a></p>
      <iframe class="yvidio" src="https://www.youtube.com/embed/TnzsiUe6bh4" frameborder="0" allowfullscreen></iframe>
     <!-- <figure><a href="https://www.youtube.com/watch?v=TnzsiUe6bh4" target="_blank"> <img src="images/video.jpg" class="img-responsive" alt=""/></a> </figure>-->
    </div>
  </div>
  <div class="bg-gray"> </div>
</section>
<div class="clearfix"></div>
<section class="news">
  <div class="container">
    <div class="news-event">
      <h2 class="slideanim">Latest News and Event</h2>
      <p class="head slideanim">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
      <div class="row">
        <div class="col-md-6 col-sm-6 pad">
          <div class="event-box">
            <figure><img class="img-responsive" src="images/event1.jpg" alt=""></figure>
            <p class="slideanim">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 pad">
          <div class="event-box">
            <figure><img class="img-responsive" src="images/event2.jpg" alt=""></figure>
            <p class="slideanim">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-sm-6 pad">
          <div class="event-box">
            <figure><img class="img-responsive" src="images/event3.jpg" alt=""></figure>
            <p class="slideanim">Lorem Ipsum is simply dummy text of the printing </p>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 pad">
          <div class="other-event-box">
            <div class="row">
              <div class="col-sm-6 col-sm-6 p-0px-r">
                <div class="box-color">
                  <p class="slideanim">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                  <a href="" class="next"><img src="images/next-btn.png" alt=""/></a> </div>
              </div>
              <div class="col-sm-6">
                <div class="box-color">
                  <p class="slideanim">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                  <a href="" class="next"><img src="images/next-btn.png" alt=""/></a> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="testmonia">
  <div class="container">
    <h2 class="slideanim">Testimonial & Clientele</h2>
    <p class="slideanim">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
    <div class="row">
      <div class="col-md-12">
        <div class="owl-carousel" id="textmonia-carousel">
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
		 
		  <div class="item">
            <div class="texmonia-box">
              <div class="texmonia-textarea">
                <p> <em><?php echo $rowMember["description"]; ?></em> </p>
              </div>
              <div class="pic">
                <figure> <img src="uploads/<?php echo $usertestimonialphoto; ?>" alt="<?php echo $rowMember["memberName"]; ?>" style="width:76px; height:77px;"/>
                  <div class="profile-details">
                    <!--<p>
                      <color>J<sub>ohn</sub> D<sub>oe</sub>,</color>
                      U<sub>sa</sub></p>--><p>
                      <color><?php echo $rowMember["memberName"]; ?></color>
                    </p>
                    <p class="destination"><?php echo $rowMember["designation"]; ?></p>
                  </div>
                </figure>
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
</section>

      <?php include('queryform.php');?>

<?php include('footer.php');?>

<?php include('footer-scripts.php');?>

</body>
</html>