<?php 
include_once('../codelibrary/inc/constants-defined.inc.php');
include_once('../codelibrary/inc/database.inc.php');
include_once('../codelibrary/inc/functions.inc.php');
include_once('../codelibrary/inc/check-admin-session.php');



$strReturn="";



openConn();



$action=$_REQUEST["txtAction"];

$selectedOption=$_REQUEST["selected_option"];

$selectedOption1=$_REQUEST["selected_option1"];


//print_r($_REQUEST);

if(trim(strtolower($action))=="getsubmenu") //////////main
{	
	
	$strReturn="";
	$strReturn='{"id" : "0","name" : "Sub Menu"},';
	
	unset($selectFields);

	unset($whereFields);

	unset($whereVals);


	$sqlUser="";

	$sqlUser="Select * from "._MENU_MASTER_TABLE_." where  mainMenuId=".$selectedOption." and mainMenuId!=0  order by mainMenuId,menuName ASC";

	

	$res=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlUser);

	

	if($res)

	{

		$num_rows=mysql_num_rows($res);
	

		while($row=mysql_fetch_array($res))

		{
			//if($num_rows>0)
			//{
				$strReturn.='{"id" : "'.$row["id"].'","name" : "'.$row["menuName"].' "},';
			//}

		}

			$strReturn=trim($strReturn,",");

			$strReturn='['.$strReturn.']';

			echo $strReturn;

		

		closeConn();

		exit();	

	}

}
else if(trim(strtolower($action))=="getsusubbmenu") 
{	
	
	$strReturn="";
	$strReturn='{"id" : "0","name" : "Sub Sub Menu"},';
	
	unset($selectFields);

	unset($whereFields);

	unset($whereVals);


	$sqlUser="";

	$sqlUser="Select * from "._MENU_MASTER_TABLE_." where  mainMenuId=".$selectedOption1." and mainMenuId!=0  order by mainMenuId,menuName ASC";

	

	$res=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlUser);

	

	if($res)

	{

		$num_rows=mysql_num_rows($res);
	

		while($row=mysql_fetch_array($res))

		{
				$strReturn.='{"id" : "'.$row["id"].'","name" : "'.$row["menuName"].' "},';

		}

			$strReturn=trim($strReturn,",");

			$strReturn='['.$strReturn.']';

			echo $strReturn;

		

		closeConn();

		exit();	

	}

}
else if(trim(strtolower($action))=="getsubservices") 
{	
	
	$strReturn="";
	$strReturn='{"id" : "0","name" : "Sub Page"},';
	
	unset($selectFields);
	unset($whereFields);
	unset($whereVals);

	$sqlUser="";
	$sqlUser="Select * from "._MENU_MASTER_TABLE_." where  mainMenuId=".$selectedOption." and mainMenuId!=0  order by mainMenuId,menuName ASC";
	$res=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlUser);
	if($res)
	{
		$num_rows=mysql_num_rows($res);
		while($row=mysql_fetch_array($res))
		{
				$strReturn.='{"id" : "'.$row["id"].'","name" : "'.$row["menuName"].' "},';
		}

			$strReturn=trim($strReturn,",");
			$strReturn='['.$strReturn.']';
			echo $strReturn;		

		closeConn();

		exit();
	}
}





?>