<?php 
include_once('codelibrary/inc/constants-defined.inc.php');
include('inc.php');
$pageindex=6;
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
	
	  <?php }?>
	  
	   <?php if($_GET["s"]==2){?>
	 
	 <h2 style=" color:#FF0000;text-transform:none;border-bottom: none;">Something is wrong. You have not successfully applyied for this job!</h2>
	
	  <?php }?>
      </div>
    </div>
  </div>
  </div>
</section>
<div class="clearfix"></div>
<section class="careers gray-bg">

  <div class="container">
   <div class="row overlap-heading">
    <div class="col-md-12">
     <h1>Careers</h1>
    </div>
   </div>
   <div class="career-container">
    <div class="row job-apply">
	
	  
     <div class="col-md-12">
     
     <h2 class="career-top app-job-head">Designation Analyst / Senior Analyst-Environment Science</h2>
      <p><strong>Job Description </strong></p>
      <p>To take samples to analyze from the Incharge, Analysis of samples as per specification, Submitting of reports to Sr. Analyst / Leader,Maintenance of records</p>
      <p><strong>Desired Profile</strong></p>
      <p>(UG - B.Sc.- Chemistry, Environmental science) OR (PG - Specialization, Chemistry, Environmental science) Anlysis & Testing of Water, Air & Pharma Products</p>
      <p><strong>Age :</strong> 25 - 35 </p>
      <p><strong>Experience :</strong> 2 - 5 years </p>
      <p><strong>Remuneration :</strong> As per Company Norms</p>
      <p><strong>Location :</strong> New Delhi</p>
      <p><strong>Contact :</strong> Mr.Birendra Dutt</p>
      <p><strong>Email :</strong> hrd@simalab.co.in</p>
     </div>
	
    </div>
    <div class="apply-job-form">
  <div class="row">
   <div class="col-md-12">
    <div class="apply-job-form-border">
     <h2 class="slide">Apply For This Job</h2>
     
     <form class="form-horizontal" method="post" action="action.php">
        <div class="form-group">
          <div class="col-sm-6">
            <input class="form-control" placeholder="Name" name="username" type="text" required>
          </div>
          <div class="col-sm-6">
            <input class="form-control" placeholder="Location" name="location" type="text">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6">
            <input class="form-control" placeholder="E-mail" type="email" name="useremail" required>
          </div>
          <div class="col-sm-6">
            <input class="form-control" placeholder="Phone no" type="text" name="userphone" required>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <input class="form-control" placeholder="No file selected" type="text" name="fileofno">
          </div>
          
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <textarea class="form-control" placeholder="Write or paste why you're a good fit for this position" name="userquerydetails">
</textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <button type="submit" class="btn btn-default submit-query">Apply</button>
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

<section class="careers gray-bg padding-top-bottom">

  <div class="container">
   
   <div class="career-container">
    <div class="row">
     <div class="col-md-12">
      <h2 class="text-left slide">Current Openings</h2>
     </div>
    </div>
    <div class="row">
     <div class="col-md-12">
   <ul class="list-unstyled apply">
   <li class="top">Designation Analyst / Senior Analyst-Environment Science <a href="">Apply Now <i class="fa fa-long-arrow-right bounce" aria-hidden="true"></i>
</a></li>
   <li>Senior Analyst-Environment Science <a href="">Apply Now <i class="fa fa-long-arrow-right bounce" aria-hidden="true"></i>
</a></li>
   <li>Designation Analyst / Senior Analyst-Environment Science <a href="">Apply Now <i class="fa fa-long-arrow-right bounce" aria-hidden="true"></i>
</a></li>
   <li>Senior Analyst-Environment Science <a href="">Apply Now <i class="fa fa-long-arrow-right bounce" aria-hidden="true"></i>
</a></li>
   
   </ul>
     </div>
    </div>
   </div>
  </div>
 
</section>
<?php include('footer.php');?>

<?php include('footer-scripts.php');?>
</body>
</html>