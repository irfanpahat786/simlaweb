// JavaScript Document
//  Developed by Roshan Bhattarai 
//  Visit http://roshanbh.com.np for this script and more.
//  This notice MUST stay intact for legal use



$(document).ready(function()
{
	
	
	
	


	$("#txtCoverType").change(function()
	{
		if($(this).val()==5)
		{
		
			var pid=$("#txtParam1").val();
		
			$('#divFloorPlans').load('get-lookups.inc.php?action=floorPlansForPhoto&pid='+pid);			
			////$("#divFloorPlans").append(strFloorPlans);
			$("#divFloorPlans").show('slow');
			
			return false;
		}
		else
		{
			$('#divFloorPlans').load('get-lookups.inc.php?action=floorPlansForPhoto&pid=0');			
			////$("#divFloorPlans").append(strFloorPlans);
			$("#divFloorPlans").hide('fast');
			
			return false;
		}
		
		
		
 		return false; //not to post the  form physically
	});



	



});

