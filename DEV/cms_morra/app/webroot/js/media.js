$(document).ready(function(){
    URL=site+'/media/';
    DELETE_PAGE_NOTIF=URL+'mediaused/';
	COPYTAG_PAGE_NOTIF=URL+'tag/';
    
    //#delete-notification
    $('a[href|="#delete-notification"]').live('click',function(event){
        event.preventDefault();

        var n='#delete-notification'.length;
        n++;

        var href=$(this).attr('href');
        //pageid=get the href {id}
        //pageid=id
        var pageid=href.substr(n);
        
        $('.media-notification').load(DELETE_PAGE_NOTIF+pageid,function(data){
            $(this).fadeIn('slow');
        });
    });
    
    $('#button-submit').click(function(){
        if($('#textbox-file').val()=="")
            alert('Please select a file to upload');
        else
            document.forms['MediaAddForm'].submit();
    });
	
	//#copy-notification
    $('a[href|="#copy-notification"]').live('click',function(event){
        event.preventDefault();

        var n='#copy-notification'.length;
        n++;

        var href=$(this).attr('href');
        //pageid=get the href {id}
        //pageid=id
        var pageid=href.substr(n);
        
        $('.tag-notification').load(COPYTAG_PAGE_NOTIF+pageid,function(data){
            $(this).fadeIn('slow');
        });
    });
	
});