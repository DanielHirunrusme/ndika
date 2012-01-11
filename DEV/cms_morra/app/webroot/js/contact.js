 $(document).ready(function(){
	$('#responseName').hide();
	$('#responseEmail').hide();
	$('#responseSubject').hide();
	$('#responseMessage').hide();
	$('#responseReport').hide();
 
	$(".mr_SendButton").click(function(event) {
	
		// $.get('/cms_morra/users/sendmail',function(response){
			// if(response=='1'){ //sukses
				// alert('Sukses');
			// }else alert('Gagal');
		// });
		
		// $.post(action,data,function(response){
			// if(response){ //sukses
				// $('#response').html('Sukses');
			// }else{
				// $('#response').html('Gagal');
			// }
		// });
		
		// $('#response').html('Sukses');
	
		$('#responseName').hide();
		$('#responseEmail').hide();
		$('#responseSubject').hide();
		$('#responseMessage').hide();
		$('#responseReport').hide();
	
		event.preventDefault();
		var name = $("#dname").val();
		var email = $("#demail").val();
		var subject = $("#dsubject").val();
		var message = $("#dmessage").val();
		var checkEmail = !email.match(/^([a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,4}$)/i);
		
		if (name=='' || checkEmail || subject=='' || message=='')
		{
			if (name=='') {
				$('#responseName').html('*Name is required.');
				$('#responseName').show();
			}
			if (checkEmail) {
				$('#responseEmail').html('*Valid email is required.');
				$('#responseEmail').show();
			}
			if (subject=='') {
				$('#responseSubject').html('*Subject is required.');
				$('#responseSubject').show();
			}
			if (message=='') {
				$('#responseMessage').html('*Message is required.');
				$('#responseMessage').show();
			}
		}
        else
		{
			var action=$('#UserSendmailForm').attr('action');
			var myData=$("#UserSendmailForm").serialize()
			
			$.post(action,myData,
               function(error){
					if(error=='0'){
						$('#responseName').hide();
						$('#responseEmail').hide();
						$('#responseSubject').hide();
						$('#responseMessage').hide();
						
						$('#responseReport').html('*Email has been send.');
						$('#responseReport').show();
                    }
					else
					{
						$('#responseName').hide();
						$('#responseEmail').hide();
						$('#responseSubject').hide();
						$('#responseMessage').hide();
						
						$('#responseReport').html('*Failed to send email.');
						$('#responseReport').show();
                    }
					
					$("input").val('');
					$("textarea").val('');
					
                });
				
		}	
	});
	
});
