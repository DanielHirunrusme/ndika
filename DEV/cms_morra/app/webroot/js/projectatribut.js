$(document).ready(function(){
	URL=site+'project_lists/';
    GET_ATRIBUT=URL+'getatribut';
	
    //Submit new page
	$('#ProjectListAddlistForm').submit(function(event){
		if($('#content').val()=="")
		{
            alert('Attribute name cannot be blank');
			event.preventDefault();
		}
        else
		{
			/* stop form from submitting normally */
			event.preventDefault();

			var action=$('#ProjectListAddlistForm').attr('action');
			var myData=$("#ProjectListAddlistForm").serialize();
			$.post(action,myData,
				   function(error){
					//console.log(error.match('0')==null);
					//alert(error.match('0'));
						if(error.match('0')==null){
							appandPage();
							var selector='#add-new-atribut-form';
						
							$(selector).hide();
							$("#tr_atrib").show();
							
							$("input#content").val('');
						}else{
							alert('Attribute already exists, please try again');
						}
					});
		}
	});
	
	
	//function
    function appandPage(){
        //Get a atribut and appand to table 
        $.get(GET_ATRIBUT,function(data){
			$('.project-info:last').after(data);
		});
    }
	
});