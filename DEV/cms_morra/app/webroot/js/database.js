$(document).ready(function()
{
	URL=site+'/project_lists/';
    DELETE_DATABASE=URL+'deletedatabase/';

	$(".space10").click(function() {
		var name = $("#idTitle").val();

		if (name=='')
		{
			alert('Please enter database name');
		}
		else
		{
			send_form(document.data[Post][Title],"simpledb/add");
		}
		
		return false;
		
	});
	
	//==========FOR CHECK EMPTY DATABASE NAME=============
	
	$("#hello").click(function()
	{
		var name = $("#title").val();

		if (name=='')
		{
			alert('Please enter database name');
		}
		else
		{
			send_form(document.data[Post][Title],"simpledb/add");
		}
		
		return false;
		
	});
	
	//==========FOR ADD DATABASE=================
	
    //add new database clicked
    $('#add-new-database-form' ).hide();
    $("#add-new-database").click(function(){
        $('#add-new-database-form' ).show();
        $('#tr_add_database').hide();
    }); 

    //cancel clicked
    $('input#add-new-database-form-cancel').click(function(){
        var selector='#add-new-database-form';
        
        $(selector).hide();
        $("#tr_add_database").show();
    })
	
	//==========FOR DELETE DATABASE=================
	
    $(document).on('click','a[href|="#delete-database"]',function(event){
        event.preventDefault();

        if(confirm('Are you sure want to delete database?')){
            //href=#page-{id}
            var n='#delete-database'.length;
            n++;
            
            var href=$(this).attr('href');
            //pageid=get the href {id}
            //pageid=id
            var databaseid=href.substr(n);
            
			alert(databaseid);
			
			//send_form(document.data[Post][Title],"simpledb/add/23");
        }
    });
	
});
		
