<?php
function makeContentUrl($contentText)
{
	$url='-';
	
	if(trim($contentText)!='')
		$url=strtolower(trim(preg_replace("/[\s-]+/", "-", preg_replace( "/[^a-zA-Z0-9\-]/", '-', $contentText)),"-"));
	
	return $url;
}


function generateRandom ($length = 4)
{

  // start with a blank password
  $uniqnum = "";

  // define possible characters
  $possiblenum = "0123456789"; 
    
  // set up a counter
  $i = 0; 
    
  // add random characters to $password until $length is reached
  while ($i < $length) { 

    // pick a random character from the possible ones
    $char = substr($possiblenum, mt_rand(0, strlen($possiblenum)-1), 1);
        
    // we don't want this character if it's already in the password
    if (!strstr($uniqnum, $char)) { 
      $uniqnum .= $char;
      $i++;
    }

  }
  // done!
  return $uniqnum;

}


function getTables()
{
	$table= new database();
	$table=mysql_list_tables($table->database);
	return $table;
}



function uploadImage($tempPath, $destPath)
{
	if($tempPath!="" && $destPath!="")
	{
		move_uploaded_file($tempPath,$destPath) or die("The picture can not be uploaded. Please try again?"); 
		return true;
	}
	else
	{
		return false;
	}
}

function validatewebURL($webaddress){

		$webaddress = strtolower(trim($webaddress));
		$len_webaddress = strlen($webaddress);

		$index_webaddress_space = strrpos($webaddress," ");			

		if($index_webaddress_space){
			$error = "found_space";		
		}					
		

		$index_webaddress_httpwww = strpos($webaddress,"www");		

		if($index_webaddress_httpwww <= 0 || $index_webaddress_httpwww === false){

			$error = "found_www";
		}

		$index_lastslash = strrpos($webaddress,"\\");		

		if($index_lastslash){
			$error = "found_slash";
		}
		
		$explode_dot = explode('.',$webaddress);

		for($i = 0 ; $i < count($explode_dot) ; $i++){
			$arr_alldot_position[$i] = strlen($explode_dot[$i]); 
		}
		for($i = 0 ; $i < count($arr_alldot_position) ; $i++){
			if($arr_alldot_position[$i] <= 0){
				$error = "found_alldotposition";
			}
		}
		if(count($explode_dot) <= 2){
			$error = "found_more than one";		
		}
		$index_webaddress_dot = strpos($webaddress,"www.");
		if($index_webaddress_dot <= 0){
			$error = "not found_dot near www";				
		}		

		if($error!=""){
			return false;
		}else{
			return true;
		}
}

function resizeImage($originalImage,$toWidth,$toHeight)
{
	// Get the original geometry and calculate scales
	list($width, $height) = getimagesize($originalImage);
	$xscale=$width/$toWidth;
	$yscale=$height/$toHeight;

    // Recalculate new size with default ratio
    if ($yscale>$xscale)
	{
        $new_width = round($width * (1/$yscale));
        $new_height = round($height * (1/$yscale));
    }
    else
	{
        $new_width = round($width * (1/$xscale));
        $new_height = round($height * (1/$xscale));
    }

	// Resize the original image
    $imageResized = imagecreatetruecolor($new_width, $new_height);
    $imageTmp     = imagecreatefromjpeg ($originalImage);
    imagecopyresampled($imageResized, $imageTmp, 0, 0, 0, 0, $new_width, $new_height, $width, $height);	
	
	return $imageResized;
}


function clean($str)
{
	$str = @trim($str);
	$str=preg_replace( '/\s+/', ' ',($str));
	if(get_magic_quotes_gpc())
	{
		$str = stripslashes($str);
	}
	return mysql_real_escape_string($str);
}


function isPost()
{
	if(trim(strtolower($_SERVER['REQUEST_METHOD']))=="post")
	{
		return true;
	}
	else
	{
		return false;
	}
}

function inStr ($needle, $haystack) 
{ 
  $needlechars = strlen($needle); //gets the number of characters in our needle 
  $i = 0; 
  for($i=0; $i < strlen($haystack); $i++) //creates a loop for the number of characters in our haystack 
  { 
    if(substr($haystack, $i, $needlechars) == $needle) //checks to see if the needle is in this segment of the haystack 
    { 
      return true; //if it is return true 
    } 
  } 
  return false; //if not, return false 
}  


function getUniqueNumber()
{
	$numReturn=0;
	
	$randNum=rand(0,9999);
	
	$numReturn=$randNum.date("YmdHis");
	
	return $numReturn;
}

function isValidURL($url) 
{ 
 return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url); 
}



function generatePassword ($length = 8)
{

  // start with a blank password
  $password = "";

  // define possible characters
  $possible = "012UVX3789bcmn456jkpqvArstwxByzCDcEFGHJdhIKLMNOPfgQRSTYZ"; 
    
  // set up a counter
  $i = 0; 
    
  // add random characters to $password until $length is reached
  while ($i < $length) { 

    // pick a random character from the possible ones
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
        
    // we don't want this character if it's already in the password
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }

  }
  // done!
  return $password;

}


function getLocalTime()
{
	$hour = gmdate("H");
	$minute = gmdate("i");
	$seconds = gmdate("s");
	$day = gmdate("d");
	$month = gmdate("m");
	$year = gmdate("Y");
	// This is the offset from the server time to Bangladesh time.
	$hour = $hour + 5;
	$minute = $minute + 30;

	return date("h:i:s", mktime ($hour,$minute,$seconds,$month,$day,$year));
}


function chkNumeric($numericVal)
{
	if(is_numeric($numericVal))
	{
		return true;
	}
	else
	{
		return false;
	}
}


function error_invalid_email($email){
   if(!eregi('^([._a-z0-9-]+[._a-z0-9-]*)@(([a-z0-9-]+\.)*([a-z0-9-]+)(\.[a-z]{2,3})?)$',$email)){
 		return "1";
	}
}


function isValidEmailFunc($email){
    if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $email)){
 		$isEmailValid='n';
		return $isEmailValid;
	}
	else
	{
		$isEmailValid='y';
		return $isEmailValid;
	}
}


function isValidPasswordFunc($password)
{
    if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8}$/i", $password)) //Password must 8 characters, and must include at least one upper case letter, one lower case letter, and one numeric digit
	{
 		$isPasswordValid='n';
		return $isPasswordValid;
	}
	else
	{
		$isPasswordValid='y';
		return $isPasswordValid;
	}
}

function upload_image($image_name,$image_size,$image,$image_type,$upload_dir,$upload_valid,$display)
{		
	
	$error_msg="";
	$filename=$image_name;
	$filesize=$image_size;
	$file=$image;
	$filetype=$image_type;
	
	$temp_name=explode(".",$filename);

	//CODE FOR CHECKING AND CREATING THE FOLDER, WHERE MEMBER IMAGE WOULD BE STORE...
	
	
	$dir_name=$upload_dir;

	if(!is_dir($dir_name))
	{
		mkdir($dir_name,0777);
	}
	

	$error_msg="";
	$upload_dir=$dir_name;
	$max_size=512000;

	$valid=0;
	if($upload_valid=="image")
	{
		if(eregi("image",$filetype)||($temp_name[1]=="tif")||($temp_name[1]=="tiff"))
	     	{
			$valid=1;		
		}
	}
	if(!empty($filename))
	{
		if($valid==1)
	     	{
	     		if($filesize<=$max_size)
		     	{
				copy($file,"$upload_dir/$filename");	
				//print "$upload_dir/$filename";
			}
			else
			{
				$error_msg.="<B>$display cannot be uploaded. The maximum file size is 500 KB. Please either reduce its file size, or choose another product photo.</B><BR>";
			}
		}
		else
		{
			if($upload_valid=="image")
			{
				$error_msg.="<B>$display you are trying to upload has the wrong format. Please go back and choose another file.</B><BR>";
			}
		}
	}
	else
	{
		$error_msg="<B>Please specify $display to be uploaded.</B><BR>";
	}
	return $error_msg;
}

function encode($text)
{ 
	$result="";
	for ($count=0; $count<strlen($text); $count++)
	{
		$char=substr($text,$count,1); 
		$num=strrpos(_REF_,$char);
		$encodeChar=substr(_REF_,$num+1,1) ;
		$result .= $encodeChar;
	}

	return $result;
}

function countArray($arrayVar)
{
	if(!is_array($arrayVar))
	{
		return 0;
	}
	else
	{
		return count($arrayVar);
	}
	
}

function isArray($arrayVar)
{
	if(!is_array($arrayVar))
	{
		return false;
	}
	else
	{
		return true;
	}
}

function getFormatedDate($format,$date) // $date has to be in YYYY-MM-DD format
{
	if($date!="")
	{
		$dateArray=split("-",$date);

		if($format!="")
			return date($format,strtotime($date));
		else
			return date("F d, Y",mktime(0,0,0,$dateArray[1],$dateArray[2],$dateArray[0]));
	}
	else
		return date("F d, Y",mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
}

function getServerCurrentTime($format)
{
	//date_default_timezone_set('UTC');

	if($format!="")
		return date($format,mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
	else
		return date("H:i:s",mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
}

function getServerCurrentDate($format)
{
	//date_default_timezone_set('UTC');
	if($format!="")
		return date($format,mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
	else
		return date("Y-m-d",mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
}


function getCurrentTime($format)
{
	if($format!="")
		return date($format,mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
	else
		return date("H:i:s",mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
}

function getCurrentDate($format)
{
	if($format!="")
		return date($format,mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
	else
		return date("Y-m-d",mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
}


function getCurrentDateTime($format)
{
	if($format!="")
		return date($format,mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
	else
		return date("Y-m-d H:i:s",mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
}

function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
	  $_SESSION["errorMessage"]="@ missing";
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
		 $_SESSION["errorMessage"]="local part length exceeded";
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
		 $_SESSION["errorMessage"]="domain part length exceeded";
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
		 $_SESSION["errorMessage"]="local part starts or ends with '.'";
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
		 $_SESSION["errorMessage"]="local part has two consecutive dots";
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
		 $_SESSION["errorMessage"]="character not valid in domain part";
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
		 $_SESSION["errorMessage"]="domain part has two consecutive dots";
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
			$_SESSION["errorMessage"]="character not valid in local part";
        }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
		 $_SESSION["errorMessage"]="domain not found in DNS";
      }
   }
   return $isValid;
}


function expl($str)
{
	$str = explode(".", $str);
	
	if(count($str)>1)
	{
	//echo $str." - ".strlen($str[1]);
	//exit();
		if(strlen($str[1])<=1)
			$decimal = substr($str[1], 0, 2)."0";
		else
			$decimal = substr($str[1], 0, 2);
	
	//	$decimal = substr($str[1], 0, 2);
	}
	else
	{
		$decimal = "00";
	}
	return $str[0].'.'.$decimal;
}

function get_time_difference( $start, $end )
{
    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );
    if( $uts['start']!==-1 && $uts['end']!==-1 )
    {
        if( $uts['end'] >= $uts['start'] )
        {
            $diff    =    $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff );            
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
    return false;
}

function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
  {
    return true;
  }
  else
  {
    return false;
  }
}

function sanitizedboutput($str){
	return stripslashes($str);
}


function url_exists($url) 
{
	if (!$fp = curl_init($url)) return false;
	return true;
}


function search($array, $key, $value)
{
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
        }
    }

    return $results;
}




function copyzol_pdf_count_get_number_of_pages($filepath) {
    $filepath = realpath("./$filepath");
    $fp = @fopen($filepath,"r");
    $max = 0;
    while(!feof($fp)) {
            $line = fgets($fp,255);
            if (preg_match('/\/Count [0-9]+/', $line, $matches)){
                    preg_match('/[0-9]+/',$matches[0], $matches2);
                    if ($max<$matches2[0]) $max=$matches2[0];
            }
    }
    fclose($fp);

    if($max == 0 && class_exists('imagick')){
        $im = new imagick($filepath);
        $max = $im->getNumberImages();
    }

    if ($max == 0)
        $max = 1;

    return $max;
}


function getMenuSubordinates($strUserId,$selectedVal)
{

	unset($selectFields);
	unset($whereFields);
	unset($whereVals);
	
	$strUsers="";
	$strUsers="SELECT * FROM "._MENU_MASTER_TABLE_."  WHERE mainMenuId=0 and id NOT IN(4,6) ORDER BY menuName ASC";

	$nav_query=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$strUsers);
	
	$tree = "";                         // Clear the directory tree
	$depth = 1;                         // Child level depth.
	$top_level_on = 1;               // What top-level category are we on?
	global $exclude ;
	$exclude = array();               // Define the exclusion array
	array_push($exclude, 0);     // Put a starting value in it

		while ( $nav_row = mysql_fetch_array($nav_query) )
		{
			 $goOn = 1;               // Resets variable to allow us to continue building out the tree.
			 for($x = 0; $x < count($exclude); $x++ )          // Check to see if the new item has been used
			 {
				  if ( $exclude[$x] == $nav_row['id'] )
				  {
					   $goOn = 0;
					   break;                    // Stop looking b/c we already found that it's in the exclusion list and we can't continue to process this node
				  }
			 }
			 
			 


			 if ( $goOn == 1 )
			 {
				  /////$tree .= $nav_row['menuName'] . "<br>";                    // Process the main tree node
					
					if(strtolower($nav_row['menuName'])=="home")
					{	
						$disabled='disabled="disabled"';
					}
					else
					{
						$disabled='';
					}
							
				   if($selectedVal==$nav_row['id'])
				   {
					$tree .= '<option '.$disabled.' value="'.$nav_row['id'].'" selected="selected">'.$nav_row['menuName'].' </option>';
				   }
				   else
				   {
					$tree .= '<option '.$disabled.' value="'.$nav_row['id'].'">'.$nav_row['menuName'].' </option>';
				   }
				  //// . "<br>";                    // Process the main tree node
				  
				  
				  array_push($exclude, $nav_row['id']);          // Add to the exclusion list
				  /*IF ( $nav_row['id'] < 6 )
				  { $top_level_on = $nav_row['id']; }*/
		 
				  $tree .= build_child($nav_row['id'],$selectedVal);          // Start the recursive function of building the child tree
			 }
		}
return $tree;
}
function getServicesSubordinates($strUserId,$selectedVal)
{

	unset($selectFields);
	unset($whereFields);
	unset($whereVals);
	
	$strUsers="";
	$strUsers="SELECT * FROM "._MENU_MASTER_TABLE_."  WHERE mainMenuId=158 ORDER BY menuName ASC";

	$nav_query=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$strUsers);
	
	$tree = "";                         // Clear the directory tree
	$depth = 1;                         // Child level depth.
	$top_level_on = 1;               // What top-level category are we on?
	global $exclude ;
	$exclude = array();               // Define the exclusion array
	array_push($exclude, 0);     // Put a starting value in it

		while ( $nav_row = mysql_fetch_array($nav_query) )
		{
			 $goOn = 1;               // Resets variable to allow us to continue building out the tree.
			 for($x = 0; $x < count($exclude); $x++ )          // Check to see if the new item has been used
			 {
				  if ( $exclude[$x] == $nav_row['id'] )
				  {
					   $goOn = 0;
					   break;                    // Stop looking b/c we already found that it's in the exclusion list and we can't continue to process this node
				  }
			 }
			 
			 


			 if ( $goOn == 1 )
			 {
				  /////$tree .= $nav_row['menuName'] . "<br>";                    // Process the main tree node
					
					if(strtolower($nav_row['menuName'])=="home")
					{	
						$disabled='disabled="disabled"';
					}
					else
					{
						$disabled='';
					}
							
				   if($selectedVal==$nav_row['id'])
				   {
					$tree .= '<option '.$disabled.' value="'.$nav_row['id'].'" selected="selected">'.$nav_row['menuName'].' </option>';
				   }
				   else
				   {
					$tree .= '<option '.$disabled.' value="'.$nav_row['id'].'">'.$nav_row['menuName'].' </option>';
				   }
				  //// . "<br>";                    // Process the main tree node
				  
				  
				  array_push($exclude, $nav_row['id']);          // Add to the exclusion list
				  /*IF ( $nav_row['id'] < 6 )
				  { $top_level_on = $nav_row['id']; }*/
		 
				  $tree .= build_child($nav_row['id'],$selectedVal);          // Start the recursive function of building the child tree
			 }
		}
return $tree;
}
function build_child($oldID,$selectedVal)               // Recursive function to get all of the children...unlimited depth
{
     global $exclude, $depth;               // Refer to the global array defined at the top of this script
	unset($selectFields);
	unset($whereFields);
	unset($whereVals);
	
	$strChildUsers="";
	$strChildUsers="SELECT * FROM "._MENU_MASTER_TABLE_." WHERE  mainMenuId=" . $oldID."  ORDER BY menuName ASC ";

	$child_query=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$strChildUsers);
	if($child_query)
	{
     while ( $child = mysql_fetch_array($child_query) )
     {
          if ( $child['id'] != $child['mainMenuId'] )
          {$tempTree1 = "&nbsp;&nbsp; ";
              
				for ( $c=0;$c<$depth;$c++ )               // Indent over so that there is distinction between levels
               { $tempTree1.= "&nbsp;&nbsp;  "; }
			  
			   if($selectedVal==$child['id'])
			   {
               	$tempTree .=  '<option value="'.$child['id'].'" selected="selected">'.$tempTree1.$child['menuName'].' </option>';
			   }
			   else
			   {
			   	$tempTree .=  '<option value="'.$child['id'].'">'.$tempTree1.$child['menuName'].' </option>';
			   }
               $depth++;          // Incriment depth b/c we're building this child's child tree  (complicated yet???)
               $tempTree .= build_child($child['id'],$selectedVal);          // Add to the temporary local tree
               $depth--;          // Decrement depth b/c we're done building the child's child tree.
               array_push($exclude, $child['id']);               // Add the item to the exclusion list
          }
     }
	}
 
     return $tempTree;          // Return the entire child tree
}

///get authors name
function getAuthorsName($strAuthorsId)  
{


	$arrAuthorIds=explode(",",$strAuthorsId);
	$strAuthorIds='';
	$authorName='';
	$myLastElement = end($arrAuthorIds);
	for($i=0; $i<=count($arrAuthorIds)-1; $i++)
	{
			$strAuthorIds=trim($arrAuthorIds[$i]);
			$sqlDetail="";
			$sqlDetail="Select *  from "._AUTHORS_TABLE_."   where id=".$strAuthorIds."  order by authorName ASC  ";
			$resDetail=getRecords(_AUTHORS_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlDetail);
			if($resDetail)
			{	
				while($rowDetail=mysql_fetch_array($resDetail))
				{
						$authorName=trim($rowDetail["authorName"]);
				}
				
			}
			
				if($myLastElement==$strAuthorIds)
				{
					$coma="";
				}
				else 
				{
					if(is_numeric($strAuthorIds))
					{
						$coma=", ";
					}
				}
				
				echo $authorName.=$coma;
			
	}
 
														 
								
}

///get areas name
function getAreasName($strAreasId)  
{
	$arrAreasds=explode(",",$strAreasId);
	$strAreasIds='';
	$jobLocation='';
	$myLastElement = end($arrAreasds);
	for($i=0; $i<=count($arrAreasds)-1; $i++)
	{
			$strAreasIds=trim($arrAreasds[$i]);
			$sqlDetail="";
			$sqlDetail="Select *  from "._LOCATIONS_TABLE_."   where id=".$strAreasIds."  order by locationName ASC  ";
			$resDetail=getRecords(_LOCATIONS_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlDetail);
			if($resDetail)
			{	
				while($rowDetail=mysql_fetch_array($resDetail))
				{
						$locationName=trim($rowDetail["locationName"]);
				}
				
			}
			
				if($myLastElement==$strAreasIds)
				{
					$coma="";
				}
				else 
				{
					if(is_numeric($strAreasIds))
					{
						$coma=", ";
					}
				}
				
				echo $locationName.=$coma;
			
	}
	 
								
}

///get Categories
function getCategories($strCategoryId)  
{
	$arrCategoryds=explode(",",$strCategoryId);
	$strCategoryIds='';
	$jobLocation='';
	$myLastElement = end($arrCategoryds);
	for($i=0; $i<=count($arrCategoryds)-1; $i++)
	{
			$strCategoryIds=trim($arrCategoryds[$i]);
			$sqlDetail="";
			$sqlDetail="Select *  from "._CATEGORIES_TABLE_."   where categoryId=".$strCategoryIds."  ORDER BY categoryName ASC  ";
			$resDetail=getRecords(_CATEGORIES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlDetail);
			if($resDetail)
			{	
				while($rowDetail=mysql_fetch_array($resDetail))
				{
						$categoryName=trim($rowDetail["categoryName"]);
				}
				
			}
			
				if($myLastElement==$strCategoryIds)
				{
					$coma="";
				}
				else 
				{
					if(is_numeric($strCategoryIds))
					{
						$coma=", ";
					}
				}
				
				echo $categoryName.=$coma;
			
	}
	 
								
}


function getMenuBreadCrumbs($menuId)
{
		
		unset($selectFields);
		unset($whereFields);
		unset($whereVals);
		
		$selectFields[0]="*";
	
		$whereFields[0]="id";
	
		$whereVals[0]=$menuId;
		
		$resAboutUs=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_N_,'');
		
		if($resAboutUs)
		{
			while($rowAboutUs=mysql_fetch_array($resAboutUs))
			{	
				$Lastid=trim($rowAboutUs["id"]);
				$menuLevel1=trim($rowAboutUs["menuLevel1"]);
				$menuLevel2=trim($rowAboutUs["menuLevel2"]);
				$menuLevel3=trim($rowAboutUs["menuLevel3"]);
				$menuName=stripslashes($rowAboutUs["menuName"]);
			}
		}
		
					
			
			
			if($menuLevel1!='' && $menuLevel1!=0)
			{
				unset($selectFields);
				unset($whereFields);
				unset($whereVals);
			
				$selectFields[0]="menuName";
				$whereFields[0]="id";
				$whereVals[0]=$menuLevel1;
				$resDetails1=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_N_,'');
				if($resDetails1)
				{
					while($rowDetails1=mysql_fetch_array($resDetails1))
					{
						$menuName1=stripslashes($rowDetails1["menuName"]);
					
					}
				}
				
			}
			
			
			if($Lastid==$menuLevel2)
			{
				$menuName2='';
			}
			else
			{
				unset($selectFields);
				unset($whereFields);
				unset($whereVals);
			
				$selectFields[0]="menuName";
				$whereFields[0]="id";
				$whereVals[0]=$menuLevel2;
				$resDetails2=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_N_,'');
				if($resDetails2)
				{
					while($rowDetails2=mysql_fetch_array($resDetails2))
					{
						$menuName2=stripslashes($rowDetails2["menuName"]);
					}
				}
				
			}
			
			if($Lastid==$menuLevel3)
			{
				$menuName3='';
			}
			else
			{
				unset($selectFields);
				unset($whereFields);
				unset($whereVals);
			
				$selectFields[0]="menuName";
				$whereFields[0]="id";
				$whereVals[0]=$menuLevel3;
				$resDetails3=getRecords(_MENU_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_N_,'');
				if($resDetails3)
				{
					while($rowDetails3=mysql_fetch_array($resDetails3))
					{
						$menuName3=stripslashes($rowDetails3["menuName"]);
					}
				}
				
			}

		
			
	




	if($menuName3!="")
	{
	 $pipe=" | ";
	} 
	
	$MenuTitles='';
	if($menuName1!="")
	{
	 $MenuTitles.=$menuName1; 
	}
	if($menuName2!="")
	{
	 $MenuTitles." | ".$menuName2; 
	}
	if($menuName3!="")
	{
	 $MenuTitles.=" | ".$menuName3;
	}
	
	if($menuName1!="" || $menuName2!="" || $menuName3!="")
	{
	 $MenuTitles.=" | ".$menuName; 
	}
	else
	{
	 $MenuTitles.=$menuName; 
	}
	
	echo $MenuTitles; 
	//.'-333-'.$menuLevel3.'-222-'.$menuLevel2.'-1111-'.$menuLevel1
	
}
function getMenuName($menuId,$colName){

$reAct="select $colName from "._MENU_MASTER_TABLE_." WHERE id='".$menuId."'";

$re2Act=mysql_query($reAct) or die(mysql_error());

$rowGetName=mysql_fetch_array($re2Act);

return $rowGetName[$colName];

}

function createMetaTags($titleName,$metaTags)
{

		$arrayx=$titleName;
		$array1=explode(",",$arrayx);
		
		$arrayy=$metaTags;
		$array2=explode(",",$arrayy);
		
		$array_merge = array_merge($array1, $array2);
		$array_unique = array_unique($array_merge);
		
		$metaTags=implode(",", $array_unique);
		
		return $metaTags;
}

function checkTempFileName($tempdir,$src)
{
		$filename = '../'.$tempdir.'/'.$src;
		if (trim($src)!='' && file_exists($filename))
		{
			$file='yes';
		}
		return $file;
}
?>