$(document).ready(function(){
	URL=site+'site_profiles/';
    GET_ATRIBUT=URL+'getatribut';
	
	//////////////////////// UPLOAD MEDIA /////////////////////
	
	$('#upload_media').click(function() {
		$('#34').show();
	})
	
	//==========FOR ADD PAGE=================
    //add new page clicked
    $('#add-new-atribut-form').hide();
    $("#add_new_atrib").click(function(){
        $('#add-new-atribut-form' ).show();
        $('#tr_add_atrib').hide();
    }); 

    //cancel clicked
    $('input#add-new-atrib-form-cancel').click(function(){
        var selector='#add-new-atribut-form';
        
        $(selector).hide();
        $("#tr_add_atrib").show();
    });
	
	//submit css
	$('#SiteProfileUploadCssForm').submit(function(event){
		if($('#text-css').val()=="")
		{
            alert('Please select a file to upload');
			event.preventDefault();
		}
        else
		{
            document.forms['SiteProfileUploadCssForm'].submit();
		}
    });
	
	//submit js
	$('#SiteProfileUploadJsForm').submit(function(event){
		if($('#text-js').val()=="")
		{
            alert('Please select a file to upload');
			event.preventDefault();
		}
        else
		{
            document.forms['SiteProfileUploadJsForm'].submit();
		}
    });
	
	//submit new attribute
	$('#SiteProfileAddForm').submit(function(event){
		if($('#content').val()=="")
		{
            alert('Attribute name cannot be blank');
			event.preventDefault();
		}
        else
		{
            /* stop form from submitting normally */
			event.preventDefault();

			var action=$('#SiteProfileAddForm').attr('action');
			var myData=$("#SiteProfileAddForm").serialize()
			$.post(action,myData,
			   function(error){
				//console.log(error.match('0')==null);
				//alert("'"+error+"'");
					//alert(error);
					if(error.match('0')==null)
					{
						appandPage();
						var selector='#add-new-atribut-form';
					
						$(selector).hide();
						$("#tr_add_atrib").show();
						
						$("input#content").val('');
					}
					else
					{
						alert('Attribute already exists, please try again');
					}
				});
		}
    });
    
    //Submit new page
	// $('#SiteProfileAddForm').submit(function(event){
		// /* stop form from submitting normally */
			////alert("aaaa");
			// event.preventDefault();

			// var action=$('#SiteProfileAddForm').attr('action');
			// var myData=$("#SiteProfileAddForm").serialize()
			// $.post(action,myData,
				   // function(error){
			////		console.log(error.match('0')==null);
			////		alert("'"+error+"'");
						// if(error.match('0')==null){
							// appandPage();
							// var selector='#add-new-atribut-form';
						
							// $(selector).hide();
							// $("#tr_add_atrib").show();
						// }else{
							// alert('Please try again');
						// }
					// });
	// });
	
	
	//function
    function appandPage(){
        //Get a atribut and appand to table 
        $.get(GET_ATRIBUT,function(data){
			$('.site-info:last').after(data);
		});
    }
	
});