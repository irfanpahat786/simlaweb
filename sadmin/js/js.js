function submenuch(id){
	
var id=$('#'+id).val();

{
$('#cat1').load('subcatinner.php?id='+id);
}

return false;
}






function checkerror(ids){
	
var ids=$('#'+ids).val();



{
$('#eheckdup').load('eheckdup.php?id='+encodeURIComponent(ids));

}

return false;
}










function picday(id){
	

	
var id=$('#'+id).val();

{
$('#pic1').load('picinner.php?id='+id);
}

return false;
}
