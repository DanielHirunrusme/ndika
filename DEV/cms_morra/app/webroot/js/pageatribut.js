$(document).ready(function(){
	URL=site+'pages/';
    GET_ATRIBUT=URL+'getatribut';
	
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
    })
    
    //Submit new page
	$('#PageAddForm').submit(function(event){
		if($('#content').val()=="")
		{
            alert('Attribute name cannot be blank');
			event.preventDefault();
		}
        else
		{
			/* stop form from submitting normally */
			event.preventDefault();

			var action=$('#PageAddForm').attr('action');
			var myData=$("#PageAddForm").serialize()
			$.post(action,myData,
				   function(error){
					//console.log(error.match('0')==null);
					//alert("'"+error+"'");
						if(error.match('0')==null){
							appandPage();
							var selector='#add-new-atribut-form';
						
							$(selector).hide();
							$("#tr_add_atrib").show();
							
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
			$('.page-info:last').after(data);
		});
    }
	
});