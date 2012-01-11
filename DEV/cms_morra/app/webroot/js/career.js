$(document).ready(function(){
	
	var myStr=location.hash;
    
	if(myStr!=undefined && myStr!="")
	{
        var pageId=myStr.substring(1);
		
		var checkId = new Array();
		checkId = pageId.split('|');
		
		if (checkId.length == '2')
		{
			$('#list-panel').hide();
			$('#info-panel').show();
			$('#project-desc-'+checkId[1]).show();
		}	
	}
});