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
					
					$query="SELECT * FROM "._MENU_MASTER_TABLE_."  WHERE id=".trim($_GET["mid"])." ";
					$sqlquery=mysql_query($query);
					$getRowResults=mysql_fetch_array($sqlquery);
					
					$menuName=$getRowResults["menuName"];
					$aboutDescription=$getRowResults["pageDescription"];

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
					$aboutDescription=$getRowResults1["pageDescription"];
			
			
			
			
	
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
        <h1><?php echo $menuName;?></h1>
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
	
	
	 $query1="SELECT id,menuName,mainMenuId FROM "._MENU_MASTER_TABLE_."   WHERE mainMenuId=".$id1." ORDER BY sortOrder ASC ";
				 $sqlquery1=mysql_query($query1);
											
		while($res_menu1=mysql_fetch_array($sqlquery1))	
		{
?>
	  <li role="presentation" class="<?php if(trim($_GET["mid"])==$res_menu1['id']){?>active<?php }?>"><a href="tap.php?pid=<?php echo $getId; ?>&mid=<?php echo $res_menu1['id']; ?>"><?php echo $res_menu1['menuName']; ?></a></li>
	    <?php 

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
                  <h1><?php //echo $menuName;?></h1>
                </div>
              </div>
              <div class="col-md-12">
                <div class="content">
                  <h2><?php echo $menuName;?></h2>
                  <p><?php echo $aboutDescription;?></p>
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