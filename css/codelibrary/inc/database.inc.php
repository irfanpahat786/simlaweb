<?php
error_reporting(0);

function openConn()
{
	//Connect to database
	
	$dataCon=mysql_connect (_DATABASE_HOST_, _DATABASE_USERNAME_, _DATABASE_PASSWORD_)or die("Could not connect: ".mysql_error());
	mysql_select_db(_DATABASE_NAME_) or die(mysql_error());
}

function closeConn()
{
	mysql_close();
}


function insertDB($tableName,$insertArray,$valArray,$isQuery,$sqlQuery)
{
	$strInsert="";
	$strVal="";
	$strQuery="";


	if(strtolower($isQuery)=="yes")
	{
		$strQuery=$sqlQuery;
	}
	else
	{
		if(!isArray($insertArray))
		{
			$errorMsg="Fields array incorrect";
			echo $errorMsg;
			exit();
		}
	
		if(!isArray($valArray))
		{
			$errorMsg="Val array incorrect";
			echo $errorMsg;
			exit();
		}

		if(countArray($insertArray)!=countArray($valArray))
		{
			$errorMsg="Fields and Val Fields does not match";
			echo $errorMsg;
			exit();
		}
		
		
		for($i=0;$i<=countArray($insertArray)-1;$i++)
		{
			if(trim($strInsert)=="")
			{
				$strInsert=$insertArray[$i];
			}
			else
			{
				$strInsert=$strInsert.",".$insertArray[$i];
			}
		}
		
		for($i=0;$i<=count($valArray)-1;$i++)
		{
			if(trim($strVal)=="")
			{
				$strVal="'".$valArray[$i]."'";
			}
			else
			{
				$strVal=$strVal.",'".$valArray[$i]."'";
			}
		}
		
		$strQuery="Insert into ".$tableName."(".$strInsert.") values (".$strVal.")";
	}
	
	
//	echo $strQuery;
	//exit();
	
	if(trim($strQuery)!="")
	{	
		$res=mysql_query($strQuery) or die();
		
		if($res)
		{
//			echo " kk ".mysql_insert_id();
			//exit();
			$lastId=0;
			$lastId=mysql_insert_id();
			//echo " <br> tt ".$lastId;
			return $lastId;
		}
		else
		{
			return -1;
		}
	}
	else
	{
		$errorMsg="Insert query Error";
		echo $errorMsg;
		exit();
	}
}




function updateDB($tableName,$insertArray,$valArray,$whereArray,$wherevalArray,$isQuery,$sqlQuery)
{
	$strInsert="";
	$strVal="";
	$strQuery="";


	if($isQuery=="yes")
	{
		$strQuery=$sqlQuery;
	}
	else
	{
		if(!isArray($insertArray))
		{
			$errorMsg="Fields array incorrect";
			echo $errorMsg;
			exit();
		}
	
		if(!isArray($valArray))
		{
			$errorMsg="Val array incorrect";
			echo $errorMsg;
			exit();
		}
	
	/*	if(!isArray($whereArray))
		{
			$errorMsg="Where Fields incorrect array";
			echo $errorMsg;
			exit();
		}
	
		if(!isArray($wherevalArray))
		{
			$errorMsg="Where Val array incorrect";
			echo $errorMsg;
			exit();
		}*/

		if(countArray($insertArray)!=countArray($valArray))
		{
			$errorMsg="Fields and Val Fields does not match";
			echo $errorMsg;
			exit();
		}
		
		

		if(countArray($whereArray)!=countArray($wherevalArray))
		{
			$errorMsg="Where Fields and Val Fields does not match";
			echo $errorMsg;
			exit();
		}
		
		
		for($i=0;$i<=countArray($insertArray)-1;$i++)
		{
			if(trim($strInsert)=="")
			{
				$strInsert=$insertArray[$i]."='".$valArray[$i]."'";
			}
			else
			{
				$strInsert=$strInsert.",".$insertArray[$i]."='".$valArray[$i]."'";
			}
		}
		
		for($i=0;$i<=countArray($whereArray)-1;$i++)
		{
			if(trim($strWhere)=="")
			{
				$strWhere=$whereArray[$i]."='".$wherevalArray[$i]."'";
			}
			else
			{
				$strWhere=$strWhere." and ".$whereArray[$i]."='".$wherevalArray[$i]."'";
			}
		}
		
		if(trim($strWhere)!='')
		{
			$strWhere=" where ".$strWhere."";
		}
		
		$strQuery="Update ".$tableName." set ".$strInsert." ".$strWhere."";
	}
	
	
	////echo $strQuery;
	////exit();
	
	if(trim($strQuery)!="")
	{	
		$res=mysql_query($strQuery) or die();
		
		if(!$res===false)
		{
			return 1;
		}
		else
		{
			return -1;
		}
	}
	else
	{
		$errorMsg="Update query error";
		echo $errorMsg;
		exit();
	}
}




function deleteDB($tableName,$whereArray,$wherevalArray,$isQuery,$sqlQuery)
{
	$strInsert="";
	$strVal="";
	$strQuery="";


	if($isQuery=="yes")
	{
		$strQuery=$sqlQuery;
	}
	else
	{
		if(!isArray($whereArray))
		{
			$errorMsg="Where Fields incorrect array";
			echo $errorMsg;
			exit();
		}
	
		if(!isArray($wherevalArray))
		{
			$errorMsg="Where Val Fields array incorrect";
			echo $errorMsg;
			exit();
		}

		if(countArray($whereArray)!=countArray($wherevalArray))
		{
			$errorMsg="Where Fields and Val Fields does not match";
			echo $errorMsg;
			exit();
		}
		
		
		for($i=0;$i<=countArray($whereArray)-1;$i++)
		{
			if(trim($strWhere)=="")
			{
				$strWhere=$whereArray[$i]."='".$wherevalArray[$i]."'";
			}
			else
			{
				$strWhere=$strWhere." and ".$whereArray[$i]."='".$wherevalArray[$i]."'";
			}
		}
		
		
		if(trim($strWhere)!='')
		{
			$strWhere=" where ".$strWhere."";
		}
		
		$strQuery="Delete from ".$tableName."  ".$strWhere."";
	}
	
	
	//echo $strQuery;
	//exit();
	
	if(trim($strQuery)!="")
	{	
		$res=mysql_query($strQuery) or die();
		
		if($res)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		$errorMsg="Error in query";
		echo $errorMsg;
		exit();
	}
	

}


function getRecords($tableName,$fieldArray,$whereArray,$valsArray,$isQuery,$sqlQuery,$orderBy='',$orderSort='',$limit='',$newOffset='')
{
	$strSelect="";
	$strWhere="";
	$strVal="";
	$strQuery="";


	if($isQuery=="yes")
	{
		$strQuery=$sqlQuery;
	}
	else
	{
		if(!isArray($fieldArray))
		{
			$errorMsg="Fields array not set for get records";
			echo $errorMsg;
			exit();
		}


		if(isArray($whereArray) && isArray($valsArray))
		{	
			if(count($whereArray)!=count($valsArray))
			{
				$errorMsg="Where Fields array and Where vals array does not match";
				echo $errorMsg;
				exit();
			}
		}			
		
		for($i=0;$i<=count($fieldArray)-1;$i++)
		{
			if(trim($strSelect)=="")
			{
				$strSelect=$fieldArray[$i];
			}
			else
			{
				$strSelect=$strSelect.",".$fieldArray[$i];
			}
		}
		
		for($i=0;$i<=count($whereArray)-1;$i++)
		{
			if(trim($strWhere)=="")
			{
				$strWhere=" where ".$whereArray[$i]."='".$valsArray[$i]."'";
			}
			else
			{
				$strWhere=$strWhere." and ".$whereArray[$i]."='".$valsArray[$i]."'";
			}
		}
		
		$strOrder='';
		
		if(trim($orderBy)!='' && trim($orderSort)!='')
		{
			$strOrder=" order by ".$orderBy." ".$orderSort;
		}
		
		$strLimit='';
		
		if(trim($limit)!='' && trim($newOffset)!='' && is_numeric($limit) && is_numeric($newOffset))
		{
			$strLimit=" LIMIT ".$newOffset.",".$limit;
		}
		
		
		
		$strQuery="Select ".$strSelect." from ".$tableName."  ".$strWhere." ".$strOrder."  ".$strLimit;
		
	}
	
	
	////echo "<br>".$strQuery;
	//exit();
	
	if(trim($strQuery)!="")
	{	
		$res=mysql_query($strQuery) or die();////." -- ".$strQuery
		
		if(!$res===false && mysql_num_rows($res)>0)
		{
			return $res;
		}
		else
		{
			return false;
		}
	}
	else
	{
		$errorMsg="Query not set for get records";
		echo $errorMsg;
		exit();
	}
}

function getRowsNum($recordSet)
{
	if($recordSet)	
		return mysql_num_rows($recordSet);
	else
		return 0;
}

function getTableRecordCount($tableName)
{
	$rowCount=0;
	
	unset($selectFields);
	unset($whereFields);
	unset($whereVals);
	
	$strSql="";
	$strSql="Select * from ".$tableName;
	
	$resRecords=getRecords($tableName,$selectFields,$whereFields,$whereVals,_Y_,$strSql);
	
	if($resRecords)
	{
		$rowCount=mysql_num_rows($resRecords);
	}
	
	return $rowCount;
}

?>