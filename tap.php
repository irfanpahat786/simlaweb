<?php 
include_once('codelibrary/inc/constants-defined.inc.php');
include('inc.php');
$pageindex=3;
$getId=trim($_GET["pid"]);
if($getId!='' && trim($_GET["mid"])!='')
{
 	
			
			
			 $query1="SELECT * FROM "._MENU_MASTER_TABLE_."  WHERE mainMenuId=".trim($_GET["mid"])." and menuLevel1 = ".$getId." ORDER BY sortOrder ASC LIMIT 0,1 ";
				 $sqlquery1=mysql_query($query1);
					$getRowResults1=mysql_fetch_array($sqlquery1);					
					$id1=$getRowResults1["mainMenuId"];
					$mainMenuId=$getRowResults1["mainMenuId"];
					
					$query="SELECT * FROM "._MENU_MASTER_TABLE_."  WHERE id=".trim($_GET["mid"])." ";
					$sqlquery=mysql_query($query);
					$getRowResults=mysql_fetch_array($sqlquery);
					$menuName=$getRowResults["menuName"];
					
					if($_GET["msid"]!='')
					{
						$query="";
						$query="SELECT * FROM "._MENU_MASTER_TABLE_."  WHERE id=".trim($_GET["msid"])." ";
						$sqlquery=mysql_query($query);
						$getRowResults=mysql_fetch_array($sqlquery);
						$sid=$getRowResults["id"];
						$menuName1=$getRowResults["menuName"];
						$aboutDescription=$getRowResults["pageDescription"];
					}
					else
					{
						$query="";
						$query="SELECT * FROM "._MENU_MASTER_TABLE_."  WHERE mainMenuId=".$id1." and menuLevel1=".trim($getId)."  ORDER BY sortOrder ASC LIMIT 0,1";
						$sqlquery=mysql_query($query);
						$getRowResults=mysql_fetch_array($sqlquery);		
						$sid=$getRowResults["id"];
						$menuName1=$getRowResults["menuName"];
						$aboutDescription=$getRowResults["pageDescription"];
					}

}
else
{

	if($getId!='')
	{
	
			  $query1="SELECT * FROM "._MENU_MASTER_TABLE_."  WHERE mainMenuId=".$getId." and menuLevel1 = ".$getId." ORDER BY sortOrder ASC LIMIT 0,1 ";
				 $sqlquery1=mysql_query($query1);
					$getRowResults1=mysql_fetch_array($sqlquery1);
					
					$id1=$getRowResults1["id"];
					$menuName=$getRowResults1["menuName"];
					$mainMenuId=$getRowResults1["mainMenuId"];
					
					$query="";
					$query="SELECT * FROM "._MENU_MASTER_TABLE_."  WHERE mainMenuId=".$id1." and menuLevel1=".trim($getId)."  ORDER BY sortOrder ASC LIMIT 0,1";
					$sqlquery=mysql_query($query);
					$getRowResults=mysql_fetch_array($sqlquery);		
					$sid=$getRowResults["id"];
					$menuName1=$getRowResults["menuName"];
					$aboutDescription=$getRowResults["pageDescription"];
			
					
			
			
	
	}

}


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
        <h1>  <?php
				  if($getId!='' && (trim($_GET["mid"])!='' || trim($_GET["msid"])!=''))
				  { echo $menuName; }else{ ?>SERVICES & PRODUCTS<?php }?></h1>
      </div>
    </div>
  </div>
  </div>
</section>

<section class="about">
  <div class="card">
   <?php
   //echo $getId.'---'.trim($_GET["mid"]).'==='.trim($_GET["msid"]);
				  if($getId!='' && (trim($_GET["mid"])!='' || trim($_GET["msid"])!=''))
				  {
				  ?>
				<ul class="nav nav-tabs" role="tablist">
				  <?php 
			if($id1>0)
			{
				
				
				  $query1="SELECT id,menuName,mainMenuId FROM "._MENU_MASTER_TABLE_."   WHERE mainMenuId=".$id1." ORDER BY sortOrder ASC ";
							 $sqlquery1=mysql_query($query1);
														
					while($res_menu1=mysql_fetch_array($sqlquery1))	
					{
			?>
				  <li role="presentation" class="<?php if(trim($_GET["mid"])==$res_menu1['id'] || $sid==$res_menu1['id']){?>active<?php }?>"><a href="tap.php?pid=<?php echo $getId; ?>&mid=<?php echo $id1; ?>&msid=<?php echo $res_menu1['id']; ?>"><?php echo $res_menu1['menuName']; ?></a></li>
					<?php 
			
					}
				
			}
			?>
				</ul>
				<?php
				}
				?>
    <!-- Tab panes -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="about">
        <div class="gray-bg">
          <div class="container">
            <div class="row about-instro">
              <div class="row overlap-heading">
                <div class="col-md-12">
                  <h1><?php //echo $menuName;?></h1>
                </div>
              </div>
              <div class="col-md-12">
                <div class="content tap">
                  <h2> <?php
				  if($getId!='' && (trim($_GET["mid"])!='' || trim($_GET["msid"])!=''))
				  {?><?php if($getId==3 && trim($_GET["mid"])==11 && trim($_GET["msid"])==22)
				     { echo 'Photo Gallery';}else{ echo $menuName1;}  }?></h2>
                  <p>
				  <?php
				  if($getId!='' && (trim($_GET["mid"])!='' || trim($_GET["msid"])!=''))
				  {
					 
					 if($getId==3 && trim($_GET["mid"])==11 && trim($_GET["msid"])==22)
				     { 
					 ?>
					 <table width="100%" border="0" cellspacing="5" cellpadding="5">
 <?php 
		
 		$query12d="Select * from "._DIR_TABLE_." WHERE parentId=0 order by sortOrder,id ASC ";
		 $sqlquery12d=mysql_query($query12d);
		$trowsd= mysql_num_rows($sqlquery12d);
		 if($trowsd>0)
		 {
		while($res_menu1d=mysql_fetch_array($sqlquery12d))	
		{
?>
  <tr>
    <td width="20%" align="left" valign="top"><a href="dirs.php?pid=<?php echo $getId; ?>&mid=<?php echo $_GET["mid"]; ?>&msid=<?php echo $_GET["msid"]; ?>&pdirid=<?php echo $res_menu1d['id']; ?>"><?php echo $res_menu1d['parentDirName']; ?> </a></td>
    <td width="5%" align="left" valign="top">&nbsp;</td>
    <td width="75%" align="left" valign="top">&nbsp;<br>
<br>
</td>
  </tr>
		 <?php 
		}
		}
?>
</table>
					 <?php
					 }
					 elseif($getId==3 && trim($_GET["mid"])==11 && trim($_GET["msid"])==23)
				     { 
					 ?>
					 <table width="100%" border="0" cellspacing="5" cellpadding="5">
 <?php 
		
 		$query123d="SELECT * FROM "._RESOURCES_TABLE_."   WHERE pageType='clientele' AND validYN='Y' order by resourceId DESC LIMIT 0,50 ";
		 $sqlquery123d=mysql_query($query123d);
		$trowsd3= mysql_num_rows($sqlquery123d);
		 if($trowsd3>0)
		 {
		while($res_menu13=mysql_fetch_array($sqlquery123d))	
		{
?>
  <tr>
    <td width="20%" align="left" valign="top"><?php echo $res_menu13['resourceTitle']; ?></td>
    <td width="5%" align="left" valign="top">&nbsp;</td>
	<td width="80%" align="left" valign="top"> <a class="example-image-link" href="uploads/<?php echo $res_menu13["resourceFile"]; ?>" data-lightbox="example-set"> <img class="example-image" width="200" height="150" src="uploads/<?php echo $res_menu13['resourceFile']; ?>" alt="<?php echo $res_menu13['resourceTitle']; ?>" /></a><br>
<br></td>
    
  </tr>
		 <?php 
		}
		}
?>
</table>
					 <?php
					 }
					 else
					 {
					   echo $aboutDescription;
					 }
				  }
				  else
				  {
				   $query12="SELECT id,menuName,mainMenuId,pageDescription,shortDescription FROM "._MENU_MASTER_TABLE_."   WHERE mainMenuId=3 ORDER BY sortOrder ASC ";
				 $sqlquery12=mysql_query($query12);
				$trows= mysql_num_rows($sqlquery12);
				 if($trows>0)
				 {
				  ?>
<table width="100%" border="0" cellspacing="5" cellpadding="5">
 <?php 
		while($res_menu1=mysql_fetch_array($sqlquery12))	
		{
?>
  <tr>
    <td width="20%" align="left" valign="top"><a href="tap.php?pid=<?php echo $getId; ?>&mid=<?php echo $res_menu1['id']; ?>"><?php echo $res_menu1['menuName']; ?> </a></td>
    <td width="5%" align="left" valign="top">&nbsp;</td>
    <td width="75%" align="left" valign="top"><?php echo $res_menu1['shortDescription']; ?><br>
<br>
</td>
  </tr>
		 <?php 
		}
?>
</table>
		  <?php
		  }
				 }
		  		 ?></p>
                </div>
              </div>
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