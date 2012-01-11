$(document).ready(function(){
	var lastProjectSelected;
	// $('.show').click(function(){
		
		// var projectId=$(this).find('.project-id').html();
		
		//alert(projectId);
		
		// lastProjectSelected=projectId;
		
		//alert(lastProjectSelected);
		
		// $('#list-panel').fadeOut('slow',function(){
			// $('#info-panel').fadeIn('slow');
			// $('#info-panel').find('#project-desc-'+projectId).fadeIn('slow');
		// });
		
		// updateSelectedItem(projectId);
	// });
	
	// $('.dropbox').change(function(){
	
		// var projectIdSelected=$(this).val();
		
		//alert(projectIdSelected);
		
		// $('#list-panel').fadeOut('slow',function(){
			// $('#project-desc-'+lastProjectSelected).fadeOut('slow',function(){
				// $('#project-desc-'+projectIdSelected).fadeIn('slow');	
			// });
		// });
		
		// lastProjectSelected=projectIdSelected;
	// });
	
	update selected item on drop box
	function updateSelectedItem(projectId){
	
		//alert(projectId);
	
		$('.dropbox').find('option').removeAttr('selected');
		$('.dropbox').find('option').each(function(){
			if($(this).val()==projectId){
				$(this).attr('selected','selected');
			}
		});
		
	}
});