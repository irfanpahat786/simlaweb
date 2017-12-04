<div id="banner" style="position:relative;">
    <h1 style="overflow:hidden;"><div style="float:left;">Excellence Enablers Forum</div><div style="float:right; font-size:15px; font-weight:normal; line-height:20px; text-align:right;"><?php if(isset($_SESSION["sess_memberFirstName"]) && $_SESSION["sess_memberFirstName"]!='') { ?>Welcome <strong class="orangetext"><?php echo $_SESSION["sess_memberFirstName"].' '.$_SESSION["sess_memberLastName"]; ?></strong> | <?php } ?><?php if($_SESSION["memberType"]!='' && is_numeric($_SESSION["memberType"])) { ?><?php if($_SESSION["memberType"]==1) { ?><a href="add-edit-topic.php">Add Topic</a> | <?php } else if($_SESSION["memberType"]==2) {  ?><a href="add-general-topic.php">Add Topic</a> | <?php } ?><?php } ?><?php if($_SESSION["memberId"]>0 && $_SESSION["memberId"]!='' && is_numeric($_SESSION["memberId"])) { ?><a href="profile.php">My Profile</a> | <a href="logout.php">Logout</a><br />
    <?php echo date("F d Y, H:m A"); ?><?php } ?></div>
    </h1>
	
	<div class="blueshadstrip">
	<a href="projects.php" onMouseOver="show_sub_menu('0')" onMouseOut="start_timer()"  <?php if($pageId==_TOPIC_CAT_PROJECTS_ID_) { ?>class="activett"<?php } ?>>PROJECTS</a> <!--<span style="float:left; padding-top:5px;">|</span><a href="#">PROJECT THREADS</a>--> <span style="float:left; padding-top:5px;">|</span><a href="general.php" <?php if($pageId==_TOPIC_CAT_GENERAL_ID_) { ?>class="activett"<?php } ?>>GENERAL</a> <span style="float:left; padding-top:5px;">|</span><a href="faqs.php" <?php if($pageId==_TOPIC_CAT_FAQS_ID_) { ?>class="activett"<?php } ?> >FAQ</a> <span style="float:left; padding-top:5px;">|</span> <a href="announcement.php" <?php if($pageId==_TOPIC_CAT_ANNOUNCE_ID_ || $pageId==0) { ?>class="activett"<?php } ?>>FORUM ANNOUNCEMENTS</a> <span style="float:left; padding-top:5px;">|</span> <a href="pmi-repository.php" <?php if($pageId==6) { ?>class="activett"<?php } ?>>PMI REPOSITORY</a></div>
	 <!-- class="activett" -->
	 
	 <style>
	 .projectdiv{position: absolute;
width: 125px;
overflow: hidden;
border: 1px #c1e7fa solid;
background-color: #FFFFFF;
left: 0px;
top: 126px;
text-align: center; visibility:hidden; }
	 .projectdiv a{padding:6px; display:block;  border-bottom:1px #c1e7fa solid; text-decoration:none; color:#000000;}
	  .projectdiv a:hover{ background-color:#009edd; text-decoration:none; color:#FFFFFF;}
	 
	 </style>
	 
	 <script>
	 var countdown = 300;
var timer = null;
var menu_item = null;

window.show_sub_menu = function(cath) {
    if (menu_item) {
        menu_item.style.visibility = 'hidden'; //Make sure to show one menu at a time
    }

    menu_item = window.document.getElementById("s" + cath);
    menu_item.style.visibility = 'visible'; //Show menu

    if (timer) {
        window.clearTimeout(timer); //Reset timer, so menu is kept open
        timer = null;
    }
};

window.start_timer = function() {
    timer = window.setTimeout(close_sub_menu, countdown);
};

window.close_sub_menu = function() {
    menu_item.style.visibility = 'hidden';
};
	 </script>

	 <div class="projectdiv" id=s0 onMouseOver="show_sub_menu('0')" onMouseOut="start_timer()">
	 <a href="projects.php">Current Projects</a> 
	 <a href="projects.php?p=y">Completed Projects</a>
	 </div>
  </div>