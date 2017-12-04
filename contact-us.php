<?php 
include_once('codelibrary/inc/constants-defined.inc.php');
include('inc.php');

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
        <?php if($_GET["s"]==1){?>
	
	 <h2 style="color:#fff; text-transform:none;border-bottom: none;">You have successfully applyied for this job!</h2>
	
	  <?php }else if($_GET["s"]==2){?>
	 
	 <h2 style=" color:#FF0000;text-transform:none;border-bottom: none;">Something is wrong. You have not successfully applyied for this job!</h2>
	
	  <?php }else{?><h1>Contact Us</h1><?php }?>
      </div>
    </div>
  </div>
  </div>
</section>
<div class="clearfix"></div>
<section class="our-braches gray-bg">

  <div class="container">
   <div class="row overlap-heading">
    <div class="col-md-12">
     <h1>Contact Us</h1>
    </div>
   </div>
   <div class="row branches-map">
    <div class="col-md-12">
    <h2>Find Us on <br/>Google Map</h2>
    <figure><img src="images/branches-map.jpg" class="img-responsive" alt=""/></figure>
    </div>
   </div>
   <div class="clearfix"></div>
   <div class="contact-container">
   <div class="apply-job-form">
  <div class="row">
   <div class="col-md-12">
    <div class="apply-job-form-border">
     <h2 class="slide">Apply For This Job</h2>
     
     <form class="form-horizontal" method="post" action="actioncontactus.php">
     <div class="form-group">
          <div class="col-sm-12">
            <input class="form-control" placeholder="Organisation / Company Name" name="usercopanyorganisation" type="text" required>
          </div>
          
        </div>
        <div class="form-group">
          <div class="col-sm-6">
            <input class="form-control" placeholder="Contact Person" name="username" type="text" required>
          </div>
          <div class="col-sm-6">
            <input class="form-control" placeholder="Designations" type="text" name="userdesignations" required>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6">
             <textarea class="form-control" placeholder="Address 1" name="useraddress1">
</textarea>
          </div>
          <div class="col-sm-6">
            <textarea class="form-control" placeholder="Address 2" name="useraddress2">
</textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6">
            <input class="form-control" placeholder="City / State " name="userstatecity" type="text">
          </div>
          <div class="col-sm-6">
            <input class="form-control" placeholder="ZIP / Postal Code" name="userpostalcode" type="text">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6">
            <input class="form-control" placeholder="Country" name="usercountry" type="text">
          </div>
          <div class="col-sm-6">
            <input class="form-control" placeholder="Phone" name="userphone" type="text" required>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6">
            <input class="form-control" placeholder="Your Email" name="useremail" type="email" required>
          </div>
          <div class="col-sm-6">
            <input class="form-control" placeholder="Your Website" type="text" name="userwebsite">
          </div>
        </div>
      
        <div class="form-group">
          <div class="col-sm-12">
            <textarea class="form-control" placeholder="Description" name="userdescription">
</textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <button type="submit" class="btn btn-default submit-query">Submit</button>
          </div>
        </div>
      </form>
    </div>
   </div>
  </div>
  
  </div>
  </div>
  </div>
  
</section>
<?php include('footer.php');?>
<?php include('footer-scripts.php');?>
</body>
</html>