<?php 
include_once('codelibrary/inc/constants-defined.inc.php');
include_once('codelibrary/inc/database.inc.php');
include_once('codelibrary/inc/functions.inc.php');
//include_once('../codelibrary/inc/check-admin-session.php');
$pageIndex=188;

openConn();


if(trim($_GET["pid"])!='' && trim($_GET["mid"])!='')
{
 	
		
		unset($selectFields);
		unset($whereFields);
		unset($whereVals);
		
		$sqlMenues='';
		$sqlMenues="SELECT * FROM "._MENU_MASTER_TABLE_."  WHERE id='".$_GET["pid"]."' ";
		$resAboutUs=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlMenues);
		
		if($resAboutUs)
		{
			while($rowAboutUs=mysql_fetch_array($resAboutUs))
			{	
				$id=stripslashes($rowAboutUs["id"]);
				$menuName=stripslashes($rowAboutUs["menuName"]);
				$aboutDescription=stripslashes($rowAboutUs["pageDescription"]);
			}
		}
		
		unset($selectFields);
		unset($whereFields);
		unset($whereVals);
		
		$sqlMenues1='';
		$sqlMenues1="SELECT * FROM "._MENU_MASTER_TABLE_."  WHERE id='".$_GET["mid"]."'  ";
		$resAboutUs1=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlMenues1);
		
		if($resAboutUs1)
		{
			while($rowAboutUs1=mysql_fetch_array($resAboutUs1))
			{	
				$id1=stripslashes($rowAboutUs1["id"]);
				$menuName1=stripslashes($rowAboutUs1["menuName"]);
				$aboutDescription1=stripslashes($rowAboutUs1["pageDescription"]);
			}
		}

}
else
{

	if(trim($_GET["pid"])!='')
	{
		
			
			unset($selectFields);
			unset($whereFields);
			unset($whereVals);
			
			$sqlMenues='';
			$sqlMenues="SELECT * FROM "._MENU_MASTER_TABLE_."  WHERE id='".$_GET["pid"]."' ";
			$resAboutUs=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlMenues);
			if($resAboutUs)
			{
				while($rowAboutUs=mysql_fetch_array($resAboutUs))
				{	
					$id=stripslashes($rowAboutUs["id"]);
					$menuName=stripslashes($rowAboutUs["menuName"]);
					$aboutDescription=stripslashes($rowAboutUs["pageDescription"]);
				}
			}
			
			unset($selectFields);
			unset($whereFields);
			unset($whereVals);
			
			$sqlMenues1='';
			$sqlMenues1="SELECT * FROM "._MENU_MASTER_TABLE_."  WHERE mainMenuId='".$id."' and menuLevel1 = ".$id." ORDER BY sortOrder ASC LIMIT 0,1";
			$resAboutUs1=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlMenues1);
			
			if($resAboutUs1)
			{
				while($rowAboutUs1=mysql_fetch_array($resAboutUs1))
				{	
					$id1=stripslashes($rowAboutUs1["id"]);
					$menuName1=stripslashes($rowAboutUs1["menuName"]);
					$aboutDescription1=stripslashes($rowAboutUs1["pageDescription"]);
				}
			}
	
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
        <h1><?php echo $menuName1;?></h1>
      </div>
    </div>
  </div>
  </div>
</section>

<section class="about">
  <div class="card">
    <ul class="nav nav-tabs" role="tablist">
      <?php 
if($id1>0)
{
	unset($selectFields);
	unset($whereFields);
	unset($whereVals);
	
	$sqlQuery1='';
	$sqlQuery1="SELECT id,menuName,mainMenuId FROM "._MENU_MASTER_TABLE_."   WHERE mainMenuId=".$id1." ORDER BY menuName ASC ";
	$resContacts1=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlQuery1);
	if($resContacts1)
	{							
		while($res_menu1=mysql_fetch_array($resContacts1))	
		{
?>
	  <li role="presentation" class="active"><a href="tap.php?pid=<?php echo $id; ?>&mid=<?php echo $res_menu1['id']; ?>"><?php echo $res_menu1['menuName']; ?></a></li>
	    <?php 

		}
	}
}
?>
    </ul>
    
    <!-- Tab panes -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="about">
        <div class="gray-bg">
          <div class="container">
            <div class="row about-instro">
              <div class="row overlap-heading">
                <div class="col-md-12">
                  <h1><?php //echo $menuName1;?></h1>
                </div>
              </div>
              <div class="col-md-12">
                <div class="content">
                  <h2><?php echo $menuName1;?></h2>
                  <p><?php echo $aboutDescription1;?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        
      </div>
      
      
    </div>
  </div>
</section>


<section class="common-query-section">
  <div class="container">
    <div class="query-form">
      <h1 class="slideanim">Queries</h1>
      <p class="slideanim">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
      <form class="form-horizontal" id="form-query">
        <div class="form-group">
          <div class="col-sm-6">
            <input type="text" class="form-control" placeholder="Name">
          </div>
          <div class="col-sm-6">
            <select class="selectpicker" >
              <option>Mustard</option>
              <option>Ketchup</option>
              <option>Relish</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6">
            <input type="email" class="form-control" placeholder="E-mail">
          </div>
          <div class="col-sm-6">
            <input type="text" class="form-control" placeholder="Phone no">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <textarea class="form-control" placeholder="Query Details">

</textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <button type="submit" class="btn btn-default submit-query">Submit Query</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

<?php include('footer.php');?>

<?php include('footer-scripts.php');?>
</body>
</html>