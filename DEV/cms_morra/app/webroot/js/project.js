$(document).ready(function(){

	//submit add database
	$('#SimpledbAddForm').submit(function(event){
		if($('#idTitle').val()=="")
		{
            alert('Database name cannot be blank');
			event.preventDefault();
		}
        else
		{
            document.forms['SimpledbAddForm'].submit();
		}
    });
	
	//submit new user
	$('#UserAddForm').submit(function(event){
		if($('#tUsername').val()=="" || $('#tEmail').val()=="" || $('#tPassword1').val()=="" || $('#tPassword2').val()=="")
		{
            alert('Text field cannot be blank');
			event.preventDefault();
		}
        else
		{
            document.forms['UserAddForm'].submit();
		}
    });
	
	//submit edit user
	$('#UserEditUserForm').submit(function(event){
		if($('#eUsername').val()=="" || $('#eEmail').val()=="")
		{
            alert('Text field cannot be blank');
			event.preventDefault();
		}
        else
		{
            document.forms['UserEditUserForm'].submit();
		}
    });
	
	//submit change password
	$('#UserChangePassForm').submit(function(event){
		if($('#cPassword1').val()=="" || $('#cPassword2').val()=="")
		{
            alert('Text field cannot be blank');
			event.preventDefault();
		}
        else
		{
            document.forms['UserChangePassForm'].submit();
		}
    });

//ketika tombol add new atribut di klick
		$('.form_atribut').hide();
		$('#add_new_atrib').click(function(){
			$('.form_atribut').toggle();
			$('#tr_atrib').hide();
		});
		
//ketika tombol add new user di klick
		
	$('#form_user').hide();
	$('#add_new_user').click(function(){
		$('.add_new_user').hide();
		$('#form_user').toggle();
	}); 

	$('#preview').click(function(){
		//alert($('#ProjectListMediaId').val());
		$('#hasil').text($('#ProjectListMediaId').val());
	});

	$('#4').click(function(){
		$('#8').text($('#2 :selected').text());
	});
	
	//ketika tombol add_new_entry di klick
	$('.tambah').hide();
	$('.add_new_entry').click(function(){
		$('.tambah').show();
		$('#tr_entry').hide();
	});
	
	//Ketika tombol cancel diclick
	$('#11').click(function(){
		$('#tr_entry').show();
	});

	//
	$('#14').click(function(){
		$('.form_atribut').toggle();
		$('#tr_atrib').show();						
	});
	
	$('#ilang').hide();
	$('#upload_media').click(function() {
		$('#34').show();
	})
	
	//$('#upload_media').fancybox();
});
		
