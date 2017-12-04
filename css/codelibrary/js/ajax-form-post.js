// JavaScript Document
//  Developed by Roshan Bhattarai 
//  Visit http://roshanbh.com.np for this script and more.
//  This notice MUST stay intact for legal use


$(document).ready(function()
{
	
	$("#frmAdminLogin").submit(function()
	{
		//remove all the class add the messagebox classes and start fading
		$("#errorMsgBox").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
		//check the username exists or not from ajax
		$.post("login-submit.inc.php",{ user_name:$('#txtAdminUsername').val(),password:$('#txtAdminPassword').val(),rand:Math.random() } ,function(data)
        {
		  if(data=='yes') //if correct login detail
		  {
		  	$("#errorMsgBox").fadeTo(200,0.1,function()  //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Logging in.....').addClass('messageboxok').fadeTo(900,1,
              function()
			  { 
			  	 //redirect to secure page
				 document.location='index.php';
			  });
			});
		  }
		  else 
		  {
		  	$("#errorMsgBox").fadeTo(200,0.1,function() //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html(data).removeClass().addClass('error_message red_error').fadeTo(900,1);
			  $("#shk").effect("shake", { times:3 }, 100);
			});		
          }
				
        });
 		return false; //not to post the  form physically
	});
	
	
	




	




	$("#frmChangeAdminPassword").submit(function()
	{
		//remove all the class add the messagebox classes and start fading
		////$("#errorMsgBox").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
		$("#loader").css({ visibility: 'visible' });
		$('#updtPass').attr('disabled','disabled');
		//check the username exists or not from ajax
		$.post("change-password.inc.php",{ oldpassword:$('#txtAdminOldPassword').val(),newpassword:$('#txtAdminNewPassword').val(),renewpassword:$('#txtAdminReNewPassword').val(),rand:Math.random() } ,function(data)
        {
			////alert(data);
			dataArray=data.split('|');
		  if(data=='yes') //if correct login detail
		  {
		  	$("#errorMsgBox").fadeTo(200,0.1,function()  //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Password Updated Successfully').addClass('messageboxok').fadeTo(900,1);
			});
		  }
		  else 
		  {
		  	$("#changePassMsgBox").fadeTo(200,0.1,function() //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html(dataArray[1]).removeClass().addClass('messageboxerror').fadeTo(900,1);
				$("#loader").css({ visibility: 'hidden' });
				$('#updtPass').removeAttr('disabled');
			});		
          }
				
        });
 		return false; //not to post the  form physically
	});
	
	
	$("#frmChangeUserAdminPassword").submit(function()
	{
		//remove all the class add the messagebox classes and start fading
		////$("#errorMsgBox").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
		$("#loader").css({ visibility: 'visible' });
		$('#updtPass').attr('disabled','disabled');
		//check the username exists or not from ajax
		$.post("change-password.inc.php",{ oldpassword:$('#txtAdminOldPassword').val(),newpassword:$('#txtAdminNewPassword').val(),renewpassword:$('#txtAdminReNewPassword').val(),rand:Math.random() } ,function(data)
        {
			////alert(data);
			dataArray=data.split('|');
		  if(data=='yes') //if correct login detail
		  {
		  	$("#errorMsgBox").fadeTo(200,0.1,function()  //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Password Updated Successfully').addClass('messageboxok').fadeTo(900,1);
			});
		  }
		  else 
		  {
		  	$("#changePassMsgBox").fadeTo(200,0.1,function() //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html(dataArray[1]).removeClass().addClass('messageboxerror').fadeTo(900,1);
				$("#loader").css({ visibility: 'hidden' });
				$('#updtPass').removeAttr('disabled');
			});		
          }
				
        });
 		return false; //not to post the  form physically
	});
	
	


	
	

	$("#frmAddProject").submit(function()
	{
		if($('#txtProjectTitle').val()=='')
		{
			alert("Please enter Project Title.");
			$('#txtProjectTitle').focus();
			return false;
		}
 		return true;
	});
		

	$("#frmRegister").submit(function()
	{
		
		if($('#txtFirstName').val()=='')
		{
			alert("Please enter First Name.");
			$('#txtFirstName').focus();
			return false;
		}
		if($('#txtEmail').val()=='')
		{
			alert("Please enter Email.");
			$('#txtEmail').focus();
			return false;
		}
		if($('#txtEmail').val()!='')
		{
			if(!isValidEmailStrict($('#txtEmail').val()))
			{
				alert("Please enter Valid Email.");
				$('#txtEmail').focus();
				return false;
			}
		}
		if($('#txtDesignation').val()=='')
		{
			alert("Please enter Your Designation.");
			$('#txtDesignation').focus();
			return false;
		}
		if($('#txtCompany').val()=='')
		{
			alert("Please enter Your Company.");
			$('#txtCompany').focus();
			return false;
		}
		if($('#txtPassword').val()=='')
		{
			alert("Please enter Your Password.");
			$('#txtPassword').focus();
			return false;
		}
		if($('#txtConfirmPassword').val()=='')
		{
			alert("Please enter Confirm Password.");
			$('#txtConfirmPassword').focus();
			return false;
		}
		if($('#txtConfirmPassword').val()!=$('#txtPassword').val())
		{
			alert("Confirm Password do not match.");
			$('#txtConfirmPassword').focus();
			return false;
		}
 		return true;
	});
		



	$("#frmLogin").submit(function()
	{
		if($('#txtUsername').val()=='')
		{
			alert("Please enter Email.");
			$('#txtUsername').focus();
			return false;
		}
		if($('#txtUsername').val()!='')
		{
			if(!isValidEmailStrict($('#txtUsername').val()))
			{
				alert("Please enter Valid Email.");
				$('#txtUsername').focus();
				return false;
			}
		}
		if($('#txtPassword').val()=='')
		{
			alert("Please enter Your Password.");
			$('#txtPassword').focus();
			return false;
		}
		
		
		
		/////$("#loader").css({ visibility: 'visible' });
		/////$('#btnUserLogin').attr('disabled','disabled');
		$("#errorLoginMsgBox").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
		//check the username exists or not from ajax
		$.post("login-submit.inc.php",{ user_name:$('#txtUsername').val(),password:$('#txtPassword').val(),rand:Math.random() } ,function(data)
        {
			//alert(data);
			dataArray=data.split('|');
		  if(dataArray[0]=='yes') //if correct login detail
		  {
		  	////$("#errorLoginMsgBox").fadeTo(200,0.1,function()  //start fading the messagebox
			////{ 
			  //add message and change the class of the box and start fading
			  if(dataArray[1]==0)
				  document.location='first-login.php';
			  else
				  document.location='projects.php';
			////});
		  }
		  else 
		  {
		  	$("#errorLoginMsgBox").fadeTo(200,0.1,function() //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			    $(this).html(dataArray[0]).fadeTo(900,1);
				///$("#loader").css({ visibility: 'hidden' });
				////$('#btnUserLogin').removeAttr('disabled');
			});		
          }
				
        });
 		return false; //not to post the  form physically
	});
		
	
	
	$("#contact-form").submit(function()
	{
		//remove all the class add the messagebox classes and start fading
		$("#contact-form img.ajax-loader").css({ visibility: 'visible' });
		//check the username exists or not from ajax
		$.post("contact-form-submit.inc.php",{ your_name:$('#txtName').val(),your_email:$('#txtEmail').val(),subject:$('#txtSubject').val(),your_message:$('#txtMessage').val(),verfCode:$('#txtVerificationCode').val(),rand:Math.random() } ,function(data)
        {
			////alert("data ");
		  if(data=='yes') //if correct login detail
		  {
		  	$("#contact-form img.ajax-loader").css({ visibility: 'hidden' });
			alert("Thanks for filling up the contact form");
			$('#txtName').val('');
			$('#txtEmail').val('');
			$('#txtSubject').val('');
			$('#txtMessage').val('');
			$('#txtVerificationCode').val('');
			refreshCaptcha();
		  }
		  else 
		  {
		  	$("#contact-form img.ajax-loader").css({ visibility: 'hidden' });
			alert("Error : " + data);
          }
				
        });
 		return false; //not to post the  form physically
	});
	
	









	//FORGOT PASSWORD FORM SUBMIT
	$("#frmForgotPassword").submit(function()
	{
		if($('#txtEmail').val()=='')
		{
			alert("Please enter Email.");
			return false;
		}
		//alert($('#txtEmail').val());
		if($('#txtEmail').val()!='')
		{
			//alert("yy");
			//alert(isValidEmail($('#txtEmail').val()));
			if(!isValidEmail($('#txtEmail').val()))
			{
				alert("Please enter Valid Email.");
				return false;
			}
		}

		//remove all the class add the messagebox classes and start fading
		$("#msgbox").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
		//check the username exists or not from ajax
		$.post("forgot-password-submit.inc.php",{email:$('#txtEmail').val(),rand:Math.random() } ,function(data)
        {
		  if(data=='yes') //if correct login detail
		  {
		  	$("#msgbox").fadeTo(200,0.1,function()  //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Logging in.....').addClass('messageboxok').fadeTo(900,1,
              function()
			  { 
			  	 //redirect to secure page
				 document.location='index.php';
			  });
			  
			});
		  }
		  else 
		  {
		  	$("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html(data).addClass('messageboxerror').fadeTo(900,1);
			});		
          }
				
        });
 		return false; //not to post the  form physically
	});
	




	




	


	$("#txtPostTitle").blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		if($('#txtPostTitle').val()!='' && $('#txtPageTitle').val()=='')
		{
			$('#txtPageTitle').val($('#txtPostTitle').val());
		}
		//check the username exists or not from ajax
		$.post("get-page-url.inc.php",{ user_title:$('#txtPostTitle').val(),current_action:$('#txtAction').val(),rand:Math.random() } ,function(data)
        {
			if(data!='-.htm' && data!='' && data!='.htm')
			{
				$("#urlCheck").val(data);
			}
		
        });
 		return false; //not to post the  form physically
	});



	$("#txtLibraryTitle").blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		if($('#txtLibraryTitle').val()!='' && $('#txtPageTitle').val()=='')
		{
			$('#txtPageTitle').val($('#txtLibraryTitle').val());
		}
		//check the username exists or not from ajax
		$.post("get-page-url.inc.php",{ user_title:$('#txtLibraryTitle').val(),current_action:$('#txtAction').val(),rand:Math.random() } ,function(data)
        {
			if(data!='-.htm' && data!='' && data!='.htm')
			{
				$("#urlCheck").val(data);
			}
		
        });
 		return false; //not to post the  form physically
	});



	$("#txtNoticeTitle").blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		if($('#txtNoticeTitle').val()!='' && $('#txtPageTitle').val()=='')
		{
			$('#txtPageTitle').val($('#txtNoticeTitle').val());
		}
		//check the username exists or not from ajax
		$.post("get-page-url.inc.php",{ user_title:$('#txtNoticeTitle').val(),current_action:$('#txtAction').val(),rand:Math.random() } ,function(data)
        {
			if(data!='-.htm' && data!='' && data!='.htm')
			{
				$("#urlCheck").val(data);
			}
		
        });
 		return false; //not to post the  form physically
	});


	$("#txtActivityTitle").blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		if($('#txtActivityTitle').val()!='' && $('#txtPageTitle').val()=='')
		{
			$('#txtPageTitle').val($('#txtActivityTitle').val());
		}
		//check the username exists or not from ajax
		$.post("get-page-url.inc.php",{ user_title:$('#txtActivityTitle').val(),current_action:$('#txtAction').val(),rand:Math.random() } ,function(data)
        {
			if(data!='-.htm' && data!='' && data!='.htm')
			{
				$("#urlCheck").val(data);
			}
		
        });
 		return false; //not to post the  form physically
	});


	
	
	$("#txtEventTitle").blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		if($('#txtEventTitle').val()!='' && $('#txtPageTitle').val()=='')
		{
			$('#txtPageTitle').val($('#txtEventTitle').val());
		}
		//check the username exists or not from ajax
		$.post("get-page-url.inc.php",{ user_title:$('#txtEventTitle').val(),current_action:$('#txtAction').val(),rand:Math.random() } ,function(data)
        {
			if(data!='-.htm' && data!='' && data!='.htm')
			{
				$("#urlCheck").val(data);
			}
		
        });
 		return false; //not to post the  form physically
	});
	
	
	$("#txtShortDescription").blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		if($('#txtShortDescription').val()!='' && $('#txtMetaDescription').val()=='')
		{
			$('#txtMetaDescription').val($('#txtShortDescription').val());
		}
 		return false; //not to post the  form physically
	});
	
	


	$("#txtNewsTitle").blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		if($('#txtNewsTitle').val()!='' && $('#txtPageTitle').val()=='')
		{
			$('#txtPageTitle').val($('#txtNewsTitle').val());
		}
		//check the username exists or not from ajax
		$.post("get-page-url.inc.php",{ user_title:$('#txtNewsTitle').val(),current_action:$('#txtAction').val(),rand:Math.random() } ,function(data)
        {
			if(data!='-.htm' && data!='' && data!='.htm')
			{
				$("#urlCheck").val(data);
			}
				//////////$("#wait").css({ visibility: 'hidden' });
        });
 		return false; //not to post the  form physically
	});



	$("#txtMemberNewsTitle").blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		if($('#txtMemberNewsTitle').val()!='' && $('#txtPageTitle').val()=='')
		{
			$('#txtPageTitle').val($('#txtMemberNewsTitle').val());
		}
		//check the username exists or not from ajax
		$.post("get-page-url.inc.php",{ user_title:$('#txtMemberNewsTitle').val(),current_action:$('#txtAction').val(),rand:Math.random() } ,function(data)
        {
			if(data!='-.htm' && data!='' && data!='.htm')
			{
				$("#urlCheck").val(data);
			}
				//////////$("#wait").css({ visibility: 'hidden' });
        });
 		return false; //not to post the  form physically
	});


	$("#txtPageName").blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		if($('#txtPageName').val()!='' && $('#txtPageTitle').val()=='')
		{
			$('#txtPageTitle').val($('#txtPageName').val());
			$('#txtHeadingText').val($('#txtPageName').val());
			
		}
		//check the username exists or not from ajax
		$.post("get-page-url.inc.php",{ user_title:$('#txtPageName').val(),current_action:$('#txtAction').val(),rand:Math.random() } ,function(data)
        {
			if(data!='-.htm' && data!='' && data!='.htm')
			{
				$("#urlCheck").val(data);
			}
        });
 		return false; //not to post the  form physically
	});


	$("#txtFeaturedName").blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		if($('#txtFeaturedName').val()!='' && $('#txtPageTitle').val()=='')
		{
			$('#txtPageTitle').val($('#txtFeaturedName').val());
			$('#txtHeadingText').val($('#txtFeaturedName').val());
			
		}
		//check the username exists or not from ajax
		$.post("get-page-url.inc.php",{ user_title:$('#txtFeaturedName').val(),current_action:$('#txtAction').val(),rand:Math.random() } ,function(data)
        {
			if(data!='-.htm' && data!='' && data!='.htm')
			{
				$("#urlCheck").val(data);
			}
        });
 		return false; //not to post the  form physically
	});






	
	
	$("#txtPressTitle").blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		if($('#txtPressTitle').val()!='' && $('#txtPageTitle').val()=='')
		{
			$('#txtPageTitle').val($('#txtPressTitle').val());
		}
		//check the username exists or not from ajax
		$.post("get-page-url.inc.php",{ user_title:$('#txtPressTitle').val(),current_action:$('#txtAction').val(),rand:Math.random() } ,function(data)
        {
			/////alert("data "+data);
			if(data!='-.htm' && data!='' && data!='.htm')
			{
				$("#urlCheck").val(data);
			}
        });
 		return false; //not to post the  form physically
	});
	
	

	$("#txtAnnouncementTitle").blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		if($('#txtAnnouncementTitle').val()!='' && $('#txtPageTitle').val()=='')
		{
			$('#txtPageTitle').val($('#txtAnnouncementTitle').val());
		}
		//check the username exists or not from ajax
		$.post("get-page-url.inc.php",{ user_title:$('#txtAnnouncementTitle').val(),current_action:$('#txtAction').val(),rand:Math.random() } ,function(data)
        {
			
			if(data!='-.htm' && data!='' && data!='.htm')
			{
				$("#urlCheck").val(data);
			}

        });
 		return false; //not to post the  form physically
	});


	$("#txtMomTitle").blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		if($('#txtMomTitle').val()!='' && $('#txtPageTitle').val()=='')
		{
			$('#txtPageTitle').val($('#txtMomTitle').val());
		}
		//check the username exists or not from ajax
		$.post("get-page-url.inc.php",{ user_title:$('#txtMomTitle').val(),current_action:$('#txtAction').val(),rand:Math.random() } ,function(data)
        {
			
			if(data!='-.htm' && data!='' && data!='.htm')
			{
				$("#urlCheck").val(data);
			}

        });
 		return false; //not to post the  form physically
	});



	$("#txtReportsTitle").blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		if($('#txtReportsTitle').val()!='' && $('#txtPageTitle').val()=='')
		{
			$('#txtPageTitle').val($('#txtReportsTitle').val());
		}
		//check the username exists or not from ajax
		$.post("get-page-url.inc.php",{ user_title:$('#txtReportsTitle').val(),current_action:$('#txtAction').val(),rand:Math.random() } ,function(data)
        {
			
			if(data!='-.htm' && data!='' && data!='.htm')
			{
				$("#urlCheck").val(data);
			}

        });
 		return false; //not to post the  form physically
	});


	$("#txtCatTitle").blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		if($('#txtCatTitle').val()!='' && $('#txtPageTitle').val()=='')
		{
			$('#txtPageTitle').val($('#txtCatTitle').val());
		}
		//check the username exists or not from ajax
		$.post("get-page-url.inc.php",{ user_title:$('#txtCatTitle').val(),current_action:$('#txtAction').val(),rand:Math.random() } ,function(data)
        {
			
			if(data!='-.htm' && data!='' && data!='.htm')
			{
				$("#urlCheck").val(data);
			}

        });
 		return false; //not to post the  form physically
	});


	$("#txtLibCatTitle").blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		if($('#txtLibCatTitle').val()!='' && $('#txtPageTitle').val()=='')
		{
			$('#txtPageTitle').val($('#txtLibCatTitle').val());
		}
		//check the username exists or not from ajax
		$.post("get-page-url.inc.php",{ user_title:$('#txtLibCatTitle').val(),current_action:$('#txtAction').val(),rand:Math.random() } ,function(data)
        {
			
			if(data!='-.htm' && data!='' && data!='.htm')
			{
				$("#urlCheck").val(data);
			}

        });
 		return false; //not to post the  form physically
	});


	$("#txtParentId").change(function()
	{
		//remove all the class add the messagebox classes and start fading
		////$("#errorMsgBox").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
		$("#subLoader").css({ visibility: 'visible' });
		
		var selectedParentId=$('#txtParentId').val();
		/////$('#updtPass').attr('disabled','disabled');
		//check the username exists or not from ajax
		$.post("get-parent-category.inc.php",{ getType:"subSub",parentId:selectedParentId,rand:Math.random() } ,function(data)
        {
			////alert(data);
			////dataArray=data.split('|');
		  if(data!='') //if correct login detail
		  {
			$("#txtCatId").empty();  
			  $.each(jQuery.parseJSON(data), function() {
													  $("<option value='"+this['catId']+"'>"+this['catName']+"</option>").appendTo($("#txtCatId"));
			   ////alert(this['catName']);
				////return false;
				});
			  $("#subLoader").css({ visibility: 'hidden' });
		  }
		  else 
		  {
			  alert("No Record found");
          }
				
        });
 		return false; //not to post the  form physically
	});




	$("#txtUserState").change(function()
	{
		//remove all the class add the messagebox classes and start fading
		////$("#errorMsgBox").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
		$("#subLoaderCity").css({ visibility: 'visible' });
		
		var selectedState=$('#txtUserState').val();
		/////$('#updtPass').attr('disabled','disabled');
		//check the username exists or not from ajax
		$.post("get-parent-category.inc.php",{ getType:"state",stateName:selectedState,rand:Math.random() } ,function(data)
        {
			////alert(data);
			////dataArray=data.split('|');
		  if(data!='') //if correct login detail
		  {
			$("#txtUserCity").empty();  
			  $.each(jQuery.parseJSON(data), function() {
													  $("<option value='"+this['catId']+"'>"+this['catName']+"</option>").appendTo($("#txtUserCity"));
			   ////alert(this['catName']);
				////return false;
				});
			  $("#subLoaderCity").css({ visibility: 'hidden' });
		  }
		  else 
		  {
			  alert("No Record found");
          }
				
        });
 		return false; //not to post the  form physically
	});



	$("#frmAdminPosts").submit(function()
	{
		$('#txtPostTitle').removeAttr('disabled');
		$('#urlCheck').removeAttr('disabled');
		//check the username exists or not from ajax
 		return true; //not to post the  form physically
	});

	$("#frmAdminLibrary").submit(function()
	{
		$('#txtLibraryTitle').removeAttr('disabled');
		$('#urlCheck').removeAttr('disabled');
		//check the username exists or not from ajax
 		return true; //not to post the  form physically
	});


	$("#frmAdminNotice").submit(function()
	{
		$('#txtNoticeTitle').removeAttr('disabled');
		$('#urlCheck').removeAttr('disabled');
		//check the username exists or not from ajax
 		return true; //not to post the  form physically
	});


	$("#frmAdminActivity").submit(function()
	{
		$('#txtActivityTitle').removeAttr('disabled');
		$('#urlCheck').removeAttr('disabled');
		//check the username exists or not from ajax
 		return true; //not to post the  form physically
	});



	$("#frmAdminEvent").submit(function()
	{
		$('#txtEventTitle').removeAttr('disabled');
		$('#urlCheck').removeAttr('disabled');
		//check the username exists or not from ajax
 		return true; //not to post the  form physically
	});

	$("#frmAdminCategory").submit(function()
	{
		$('#txtCatTitle').removeAttr('disabled');
		$('#urlCheck').removeAttr('disabled');
		//check the username exists or not from ajax
 		return true; //not to post the  form physically
	});


	$("#frmAdminLibraryCategory").submit(function()
	{
		$('#txtLibCatTitle').removeAttr('disabled');
		$('#urlCheck').removeAttr('disabled');
		//check the username exists or not from ajax
 		return true; //not to post the  form physically
	});


	$("#frmAdminReports").submit(function()
	{
		$('#txtReportsTitle').removeAttr('disabled');
		$('#urlCheck').removeAttr('disabled');
		//check the username exists or not from ajax
 		return true; //not to post the  form physically
	});


	$("#frmAdminMom").submit(function()
	{
		$('#txtMomTitle').removeAttr('disabled');
		$('#urlCheck').removeAttr('disabled');
		//check the username exists or not from ajax
 		return true; //not to post the  form physically
	});


	$("#frmAdminNews").submit(function()
	{
		$('#txtNewsTitle').removeAttr('disabled');
		$('#urlCheck').removeAttr('disabled');
		//check the username exists or not from ajax
 		return true; //not to post the  form physically
	});


	$("#frmAdminMemberNews").submit(function()
	{
		$('#txtMemberNewsTitle').removeAttr('disabled');
		$('#urlCheck').removeAttr('disabled');
		//check the username exists or not from ajax
 		return true; //not to post the  form physically
	});


	$("#frmAdminAnnouncement").submit(function()
	{
		$('#txtAnnouncementTitle').removeAttr('disabled');
		$('#urlCheck').removeAttr('disabled');
		//check the username exists or not from ajax
 		return true; //not to post the  form physically
	});



	$("#frmAdminPress").submit(function()
	{
		$('#urlCheck').removeAttr('disabled');
		$('#txtPressTitle').removeAttr('disabled');
		//check the username exists or not from ajax
 		return true; //not to post the  form physically
	});
	

	$("#frmAdminPage").submit(function()
	{
		$('#txtPageName').removeAttr('disabled');
		$('#urlCheck').removeAttr('disabled');
		//check the username exists or not from ajax
 		return true; //not to post the  form physically
	});

	$("#frmAdminFeatured").submit(function()
	{
		$('#txtFeaturedName').removeAttr('disabled');
		$('#urlCheck').removeAttr('disabled');
		//check the username exists or not from ajax
 		return true; //not to post the  form physically
	});


});


function isValidEmailStrict(address)
{
/*	if (isValidEmail(address) == false) return false;
	var domain = address.substring(address.indexOf('@') + 1);
	if (domain.indexOf('.') == -1) return false;
	if (domain.indexOf('.') == 0 || domain.indexOf('.') == domain.length - 1) return false;
	return true; */


	var hasError = false;
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

	var emailaddressVal = address;	
	
	if(!emailReg.test(emailaddressVal))
	{
		////$("#UserEmail").after('<span class="error">Enter a valid email address.</span>');
		hasError = true;
	}

	if(hasError == true)
	{
		return false;
	}
	else
		return true;
	
}

