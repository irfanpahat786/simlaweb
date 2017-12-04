     <?php 
if($_SESSION["adminStatus"]==1)
{
  ?>
    <div id="mainleft">

        <div class="inner2">

            <a href="javascript: void(0);">

                <div class="maintablef silverheader">

                    <div class="content1">&nbsp;</div>

                    <div class="content1">Dashboard</div>

                </div>

            </a>

            <div class="navi submenu">

                <a href="index.php">Home</a>

                <!--<a href="admin-settings.php">Settings</a>-->

            </div>

        </div>	

            

		<div class="inner2">

           

           

				

			

				<a href="javascript: void(0);"><div class="maintablefdactive silverheader"><!-- for active use 'maintablef' -->

            <div class="content1">&nbsp;</div>

            <div class="content1">Users</div>

            </div></a>

                <div class="navi submenu">

                   <!-- <a href="add-edit-user.php">Add Incubatees</a>-->

					<a href="list-users.php">List Incubatees</a>

					<!--<a href="list-mentors.php">List Mentors</a>

					<a href="ima-list.php">Incubatee Allocation</a>-->

                </div>

				

			

				

				

				

        </div>

    </div>
  <!-- incubatees and mentors pages-->
  <?php 
  }
else if($_SESSION["adminStatus"]==2 || $_SESSION["adminStatus"]==3 || $_SESSION["adminStatus"]==4)
{
  ?>
  <div id="mainleft">

        <div class="inner2">

            <a href="javascript: void(0);">

                <div class="maintablef silverheader">

                    <div class="content1">&nbsp;</div>

                    <div class="content1">Dashboard</div>

                </div>

            </a>

            <div class="navi submenu">

                <a href="index.php">Home</a>

                <!--<a href="admin-settings.php">Settings</a>-->

            </div>

        </div>	

            

		<div class="inner2"><a href="javascript: void(0);"><div class="maintablefdactive silverheader"><!-- for active use 'maintablef' -->

            <div class="content1">&nbsp;</div>

            <div class="content1">Users</div>

            </div></a>

                <div class="navi submenu">
<?php 
if($_SESSION["adminStatus"]==4)
{
?>
   <a href="list-users.php">List Incubatees</a>
                    
<?php 
}
else if($_SESSION["adminStatus"]==2 || $_SESSION["adminStatus"]==3)
{
?>
  <a href="list-incubatees.php">List Incubatees</a>
                    
<?php
}
?>
                </div>

				

        </div>

    </div>
    
    <?php } ?>