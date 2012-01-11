$(document).ready(function(){
    URL=site+'/site_profiles/';
    
    $('#submit-css').click(function(){
        if($('#textbox-css').val()=="")
            alert('Please select a file to upload');
        else
            document.forms['CssAddForm'].submit();
    });
	
	$('#submit-js').click(function(){
        if($('#textbox-js').val()=="")
            alert('Please select a file to upload');
        else
            document.forms['JsAddForm'].submit();
    });
});