<!-- start header section  -->
<header>
  <div class="container">
    <div class="row">
      <div class="col-md-12 contener-part">
        <ul class="list-unstyled search-box">
          <li class="active"><a href="testimonials.php?pid=8">Testimonial &#38; Clientele</a><span>|</span></li>
          <li><a href="contact-us.php">Contact us</a></li>
        </ul>
        <ul class="list-unstyled">
          <li class="search">
		  <form method="get" name="frmSearch" action="search.php">
            <div class="form-group">
              <input type="text" class="form-control" id="usr" name="txtSearch" value="<?php echo $_REQUEST["txtSearch"];?>">
            </div>
		 </form>
          </li>
        </ul>
        <ul class="list-unstyled social-icon">
          <li><a href="https://www.facebook.com/simalabs" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
          <li><a href="https://twitter.com/simalabs" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
          <li><a href="https://www.linkedin.com/company/sima-labs-pvt-ltd" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
          <li><a href="https://plus.google.com/105754182854214677834" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
          <li><a href="https://www.youtube.com/watch?v=TnzsiUe6bh4" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
        </ul>
        <ul class="list-unstyled query">
          <li><a href="#form-query"><img src="images/info.png" alt=""/> QUERIES</a></li>
        </ul>
      </div>
    </div>
  </div>
</header>
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand  navbar-brand-centered" href="index.php"><img src="images/logo.png" alt="logo" class="img-responsive" /></a> </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li class="<?php if($pageindex==1){?>active<?php }?>"><a href="index.php">Home</a></li>
        <li class="<?php if($pageindex==2){?>active<?php }?>"><a href="about.php">About Us</a></li>
        <?php 
	 $query1="SELECT id,menuName,mainMenuId FROM "._MENU_MASTER_TABLE_."   WHERE id=3 ";
		$sqlquery1=mysql_query($query1);
											
		while($res_menu1=mysql_fetch_array($sqlquery1))	
		{
?>
	    <li class="dropdown <?php if(trim($_GET["pidsssss"])==$res_menu1['id']){?>active<?php }?>"> <a href="tap.php?pid=<?php echo $res_menu1['id']; ?>" class="dropdown-togglessssssssssssss" data-toggle="dropdownssssssssssssssssss" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $res_menu1['menuName']; ?> <span class="caret"></span></a>
		 <?php 
	 $query12="SELECT id,menuName,mainMenuId FROM "._MENU_MASTER_TABLE_."   WHERE mainMenuId=".$res_menu1['id']." ORDER BY sortOrder ASC ";
				 $sqlquery12=mysql_query($query12);
				$trows= mysql_num_rows($sqlquery12);
				 if($trows>0)
				 {
?>
				  <ul class="dropdown-menu">
					  <?php 
					while($res_menu12=mysql_fetch_array($sqlquery12))	
					{
					  ?>
						<li class="<?php if(trim($_GET["mid"])==$res_menu12['id']){?>active<?php }?>"><a href="tap.php?pid=<?php echo $res_menu1['id']; ?>&mid=<?php echo $res_menu12['id']; ?>"><?php echo $res_menu12['menuName']; ?> </a></li>
					<?php 
			
					}
					?>
				  </ul>
			   <?php 
			   }

?>
        </li>
		  <?php 
		}
?>
        <li class="<?php if($pageindex==4){?>active<?php }?>"><a href="accreditation-and-recognition.php">Accreditation & Recognition</a></li>
        <?php 
		 $query1="";
	 $query1="SELECT id,menuName,mainMenuId FROM "._MENU_MASTER_TABLE_."   WHERE id=8 ";
		$sqlquery1=mysql_query($query1);
											
		while($res_menu1=mysql_fetch_array($sqlquery1))	
		{
?><!--<li class="<?php if($pageindex==8){?>active<?php }?>"><a href="testimonials.php?pid=<?php echo $res_menu1['id']; ?>"><?php echo $res_menu1['menuName']; ?></a></li>-->
 <?php 
		}
?>
          <li class="<?php if($pageindex==9){?>active<?php }?>"><a href="media.php">Media</a></li>
		  <li class="<?php if($pageindex==6){?>active<?php }?>"><a href="careers.php">Careers</a></li>
        <li class="<?php if($pageindex==7){?>active<?php }?>"><a href="our-branches.php" class="last">Our Branches</a></li>
      </ul>
    </div>
  </div>
</nav>
