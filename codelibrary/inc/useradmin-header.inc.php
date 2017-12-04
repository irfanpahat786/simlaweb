	<div id="header">
	<h2><?php echo _WEBSITE_NAME_; ?> Admin</h2>
	<div id="welcomeloginbox">Welcome <?php echo $_SESSION["userAdminName"]; ?>&nbsp;|&nbsp;<a href="logout.php">Logout</a></div>
	
	</div>
	<div id="settingtab" align="right">
	<div class="graybg submenu" align="left" style="display:none">
	  <table border="0" cellspacing="0" cellpadding="3">
      <form name="frmChangeUserAdminPassword" id="frmChangeUserAdminPassword" method="post">
        <tr>
          <td colspan="2"><strong>Change Password </strong></td>
        </tr>
        <tr>
	      <td colspan="2"><span id="changePassMsgBox"></span></td>
        </tr>
        <tr>
          <td><label>Old Password </label></td>
          <td><input name="txtAdminOldPassword" id="txtAdminOldPassword" type="password" class="formfld" size="35" /></td>
        </tr>
        <tr>
          <td>New Password            </td>
          <td><input name="txtAdminNewPassword" id="txtAdminNewPassword" type="password" class="formfld" size="35" /></td>
        </tr>
        <tr>
          <td>Confirm Password </td>
          <td><input name="txtAdminReNewPassword" id="txtAdminReNewPassword" type="password" class="formfld" size="35" /></td>
        </tr>
        <tr>
          <td height="35"></td>
          <td align="left"><img src="images/loader.gif" id="loader" style="visibility:hidden;" /><input type="submit" name="updtPass" id="updtPass" value="Update Password" class="bluebutton" /></td>
        </tr>
        </form>
      </table>
	</div>
	<div class="roundcornerbtngray silverheader" ><a href="javascript: void(0);">Change Password</a></div>
	
	</div>
