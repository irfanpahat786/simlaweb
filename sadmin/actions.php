<?php 
include_once('../codelibrary/inc/constants-defined.inc.php');
include_once('../codelibrary/inc/database.inc.php');
include_once('../codelibrary/inc/functions.inc.php');
include_once('../codelibrary/inc/check-admin-session.php');
$pageIndex=5;

openConn();

$actionRequired=trim($_POST['actionRequired']);
if(trim($actionRequired)=='removedaction')
{

	$resourceId=trim($_POST['resourceId']);
	$resourceFile=trim($_POST['resourceFile']);

	
	//echo $resourceId.'--22-'.$resourceFile;
	//exit();
	if($resourceId!='' && $resourceFile!='')
	{
	
		
			unset($insertFields);
			unset($insertVals);
			unset($whereFields);
			unset($whereVals);
			
			$insertFields[0]="resourceFile";
	
			$insertVals[0]='';
			
			$whereFields[0]="resourceId";
			
			$whereVals[0]=$resourceId;
			
			$resUpdate=updateDB(_RESOURCES_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');
			if($resUpdate)
			{						
										
					if($resourceFile!='' && is_file("../reports-publications/".$resourceFile))
									unlink("../reports-publications/".$resourceFile);
			
			echo "yes|".$resourceId;
			exit();
			
			}
			else
			{
				echo "no|".$resourceId;
				exit();
			}
		
		
	}
	else
	{
		echo "no|".$resourceId;
		exit();
	}	
	
		
}
else if(trim($actionRequired)=='rmnewsevents')
{

	$resourceId=trim($_POST['resourceId']);
	$resourceFile=trim($_POST['resourceFile']);

	
	//echo $resourceId.'--22-'.$resourceFile;
	//exit();
	if($resourceId!='' && $resourceFile!='')
	{
	
		
			unset($insertFields);
			unset($insertVals);
			unset($whereFields);
			unset($whereVals);
			
			$insertFields[0]="resourceFile";
	
			$insertVals[0]='';
			
			$whereFields[0]="resourceId";
			
			$whereVals[0]=$resourceId;
			
			$resUpdate=updateDB(_RESOURCES_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');
			if($resUpdate)
			{						
										
					if($resourceFile!='' && is_file("../news-events/".$resourceFile))
									unlink("../news-events/".$resourceFile);
			
			echo "yes|".$resourceId;
			exit();
			
			}
			else
			{
				echo "no|".$resourceId;
				exit();
			}
		
		
	}
	else
	{
		echo "no|".$resourceId;
		exit();
	}	
	
		
}

?>