/*
  Jquery Validation using jqBootstrapValidation
   example is taken from jqBootstrapValidation docs 
  */
$(function() {

 //$("input,textarea").jqBootstrapValidation(
 $("#smsg").jqBootstrapValidation(
    {
     preventSubmit: true,
     submitError: function($form, event, errors) {
      // something to have when submit produces an error ?
      // Not decided if I need it yet
     },
     submitSuccess: function($form, event) {
      event.preventDefault(); // prevent default submit behaviour
       // get values from FORM
       var name = $("input#uname").val();  
       var email = $("input#uemail").val(); 
       var message = $("textarea#umessage").val();
	   var type = $("select#utype").val();
	  
	   var title = $("input#utitle").val();
	   //必填
	   if (email !='' && message !='' && title !='' && name !=''  ){
		   
	  
      /*  var firstName = name; // For Success/Failure Message
           // Check for white space in name for Success/Fail message
        if (firstName.indexOf(' ') >= 0) {
	   firstName = name.split(' ').slice(0, -1).join(' ');
         }*/        
	 $.ajax({
                url: "../www/contact_me.php",
            	type: "POST",            	
				data: {'name': name, 'email': email, 'message': message,'type': type,'title': title},
            	cache: false,
            	success: function() {  
            	// Success message
            	   $('#success').html("<div class='alert alert-success'>");
            	   $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            		.append( "</button>");
            	  $('#success > .alert-success')
            		.append("<strong>我們已收到您反應的寶貴意見了，非常的感謝您 </strong>");
 		  $('#success > .alert-success')
 			.append('</div>');
 						    
 		  //clear all fields
 		  $('#form1').trigger("reset");
 	      },
 	   error: function() {		
 		// Fail message
 		 $('#success').html("<div class='alert alert-danger'>");
            	$('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            	 .append( "</button>");
            	$('#success > .alert-danger').append("<strong> "+firstName+" 君 您好!!<BR>~很抱歉!! 目前信件主機異常，正在處理中...</strong><br>為了保留您寶貴的意見，請點選 <a href='mailto:skingned6665@gmail.com?Subject=豐富科技您好，我有意見反應，請儘速與我連絡&bcc="+ email +"' >skingned6665@gmail.com</a> 寄出您的資訊！<br>造成您的不便，深感抱歉!");
 	        $('#success > .alert-danger').append('</div>');
 		//clear all fields
 		$('#form1').trigger("reset");
		
 	    },
           });
		    }else{
				alert('資料未輸入!!');				
			}//if
         },
         filter: function() {
                   return $(this).is(":visible");
         },
       });

      $("a[data-toggle=\"tab\"]").click(function(e) {
                    e.preventDefault();
                    $(this).tab("show");
        });
  });
 

/*When clicking on Full hide fail/success boxes */ 
$('#name').focus(function() {
     $('#success').html('');
  });
