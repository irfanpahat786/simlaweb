<?php 
include_once('codelibrary/inc/constants-defined.inc.php');
include('inc.php');


if(trim($_POST["username"])!='' && trim($_POST["useremail"])!='')
{

  $sql_ins="INSERT INTO "._ENQUIRY_TABLE_." SET name= '".addslashes($_SESSION["username"])."',phone= '".addslashes($_SESSION["userphone"])."',email= '".addslashes($_SESSION["useremail"])."',comments= '".addslashes($_SESSION["userquerydetails"])."',post= '".addslashes($_SESSION["dropdownvalue"])."',enquiry_date= '".time()."' ";
$resresult2=mysql_query($sql_ins) or die(mysql_error());

	
$createdate=date('Y-m-d');

$to=_ADMIN_MAIL_ID_;
$dname=DOMAIN_NAME;

$customerMailBody='';
$customerMailBody='Dear Administrator,<br><br> 
Following are the details of query posted on Query form page on simlaweb.com<br>
<br>';
$customerMailBody.='<table border="0"><tr><td><strong>Name</strong></td><td>'.addslashes($_SESSION["username"]).'</td></tr><tr><td><strong>Email</strong></td><td>'.addslashes($_SESSION["useremail"]).'</td></tr><tr><td><strong>Mobile</strong></td><td>'.addslashes($_SESSION["userphone"]).'</td></tr><tr><td><strong>Selectpicker</strong></td><td>'.addslashes($_SESSION["dropdownvalue"]).'</td></tr><tr><td><strong>Message</strong></td><td>'.addslashes($_SESSION["userquerydetails"]).'</td></tr><tr><td><strong>Dated</strong></td><td>'.$createdate.'</td></tr></table>';
$customerMailBody.='<br><br><br><br>Regards,<br>Team<br>simalab.com<br><br>';

		$headers ='';
		$headers = 'From: simlaweb<do_not_reply@'.$dname.'>' . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";	

		if( @mail( $to, "Query posted on simalab.com", $customerMailBody, $headers ))
		{
				
		}
	
		header("Location:thankyou.php");
		exit();

}
else
{
header("Location:error.php");
exit();
}


?>