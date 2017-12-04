<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-sm-6">
        <h1 class="first">Quick Links</h1>
        <div class="row">
          <div class="col-sm-4">
            <ul class="list-unstyled">
              <li><a href="index.php">Home</a></li>
              <li><a href="about.php">About Us</a></li>
              <li><a href="our-branches.php">Our Branches</a></li>
              <li><a href="careers.php">Careers</a></li>
              <li><a href="media.php">Media</a></li>
            </ul>
          </div>
          <div class="col-sm-8">
            <ul class="list-unstyled">
               <?php 
	 $query1="SELECT id,menuName,mainMenuId FROM "._MENU_MASTER_TABLE_."   WHERE id=3 ";
		$sqlquery1=mysql_query($query1);
											
		while($res_menu1=mysql_fetch_array($sqlquery1))	
		{
?><li><a href="tap.php?pid=<?php echo $res_menu1['id']; ?>"><?php echo ucfirst(strtolower($res_menu1['menuName'])); ?></a></li> <?php 
		}
?>
              <li><a href="accreditation-and-recognition.php">Accreditation & Recognition</a></li>
               <?php 
		 $query1="";
	 $query1="SELECT id,menuName,mainMenuId FROM "._MENU_MASTER_TABLE_."   WHERE id=8 ";
		$sqlquery1=mysql_query($query1);
											
		while($res_menu1=mysql_fetch_array($sqlquery1))	
		{
?><li><a href="testimonials.php?pid=<?php echo $res_menu1['id']; ?>"><?php echo $res_menu1['menuName']; ?></a></li><?php 
		}
?>
              <li><a href="contact-us.php">Contact Us</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <h1 class="first">Get in Touch</h1>
        <ul class="list-unstyled">
          <li><img src="images/phone.png" alt=""/> <a href="tel:+(91)-(11)-43854300">+(91)-(11)-43854300</a></li>
          <li><img src="images/print-out.png" alt=""/> <a href="tel:+(91)-(11)-43854330">+(91)-(11)-43854330</a></li>
          <li class="mial-align"><img src="images/message.png" alt=""/> <a class="pad0" href="mailto:testing@simalab.co.in">testing@simalab.co.in</a><br/>
            <a href="mailto:amc@simalab.co.in">amc@simalab.co.in</a><br/>
            <a href="mailto:projects@simalab.co.in">projects@simalab.co.in</a></li>
        </ul>
      </div>
      <div class="col-md-3 col-sm-6">
        <h2 class="text-left">Find Us on</h2>
        <p>A-3/7, Mayapuri Industrial Area,
          Phase - II, New Delhi-110064 (INDIA)</p>
        <div class="map"> <ul class="list-unstyled pad0">
          <li><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.296919579375!2d77.11999651508236!3d28.62086188242238!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d034971210849%3A0xe7a92865fcfeaa71!2sC-3%2F7%2C+Mayapuri+Industrial+Area+Phase+II%2C+Mayapuri%2C+New+Delhi%2C+Delhi+110064!5e0!3m2!1sen!2sin!4v1503305403595" width="100%" height="150" frameborder="0" style="border:0" allowfullscreen></iframe>  </li></ul></div>
      </div>
    </div>
  </div>
</footer>
<section class="copyright">Copyright &copy; 2007-2017 Sima Labs Pvt. Ltd. - All Rights Reserved</section>