<link href="css/main-style.css" rel="stylesheet" type="text/css">
<style>

.errormsg{border:2px #f46964 solid;  margin:20px 0px; font-size:15px; padding:10px; border-radius:2px; color:#f00;} 

.successmsg{background-color:#9ef366; border:2px #50a915 solid; color:#275e03; margin:20px 0px; font-size:15px; padding:10px; border-radius:2px;} 

.erorfldcls{color:#FF0000; font-size:12px; margin-bottom:5px; display:none;}
.redtext{color:#f36966;}
.changepass{color:#000; background-color: #595959; color:#FFF;line-height: 16px; padding: 5px 10px; -moz-border-radius: 5px; -khtml-border-radius: 5px; -webkit-border-radius: 11px; border-radius: 5px; width:106px;}
</style>
<div id="header">
	<!--<h2><?php //echo _WEBSITE_NAME_; ?> Admin</h2>-->
	<div id="welcomeloginbox"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Welcome <?php echo $_SESSION["adminFirstName"]; ?>&nbsp;|&nbsp;</td>
    <td><a href="changepassword.php" style="color:#045d23; text-decoration:underline; float:left;">Change Password</a>&nbsp;|&nbsp;</td>
    <td><a href="logout.php" style="color:#045d23; text-decoration:underline;">Logout</a></td>
  </tr>
</table>
</div>
	
	</div>
