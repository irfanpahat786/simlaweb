// JavaScript Document
function deleteRecord(id,formName)
{
	if(confirm("This will delete the selected record"))
	{
		document.getElementById("txtParam1").value=id;
		document.getElementById("txtAction").value="DELETE";
		document.getElementById(formName).submit();
	}
}



function changeStatus(id,status,formName)
{
	document.getElementById("txtParam1").value=id;
	document.getElementById("txtParam2").value=status;
	document.getElementById("txtAction").value="CHANGESTATUS";
	document.getElementById(formName).submit();
}

