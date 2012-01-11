$(document).ready(function(){
    var GET_NEWEST_ATRIBUT=site+'ProjectListAtributs/getNewestAtribut'
    //Upload from media button when clicked
    $('#cms_Modal').fadeOut();
    $('#upload_media').click(function(){
		//clearSelected();
	
        //$('#cms_Modal').show('slow');
        $('.eMedia').fadeIn('slow');
        //alert('halow');
    });
    
    //Cancel button when click -> hide pop up
    $('.cms_ModalFooter input.isOff').click(function(){
        $('#cms_Modal').fadeOut('fast');    
    });
	
	//For browse project media list form modal pop up.
	$('#project-list-media .cms_Thumbnail').click(function(){
        var formId='#SiteProfileAddMediaForm';
        var mediaId;
        
        // if($(this).hasClass('isSelected')){
            // $(this).removeClass('isSelected');
            // mediaId=$(this).find('.media-id').html();
            // $(formId).find('input:hidden').each(function(i){
                // if($(this).val()==mediaId)
                    // $(this).remove();
            // });
        // }else{
            $(this).addClass('isSelected');
            mediaId = $(this).find('.media-id').html();
			$(formId).find('input:hidden').remove();
			$(formId).append('<input type="hidden" name="data[SiteProfile][icon]" value="'+mediaId+'" />');
        //}
    });
	
	///////////////////////////////////////////
    
    // $('.cms_ModalFooter input.space10').click(function(){
        // var formId='#ProjectListAddMediaForm';
        // var action=$(formId).attr('action');
        // var myData=$(formId).serialize();
        ////alert(action);
        ////alert(myData);
        // $.post(action,myData,
			// function(error){
				// window.location.reload();                
			// });
    // });
	
	$('.cms_ModalFooter input.space10').click(function(){
        var formId='#SiteProfileAddMediaForm';
        var action=$(formId).attr('action');
        var myData=$(formId).serialize();
        //alert(action);
        //alert(myData);
        $.post(action,myData,
			function(error){
				//$.get('http://localhost/cms_morra/site_profiles/getfavicon', function(data) {
				$.get(site+'site_profiles/getfavicon', function(data) {
					$('#fav').html(data);
				});
				//window.location.reload();                
			});
    });
		
	$('a#deleteIcon').click(function(){
	
		var formId='#SiteProfileDeleteFaviconForm';
        var action=$(formId).attr('action');
        var myData=$(formId).serialize();
		
		$.post(action,myData,
			function(error){
				//$.get('http://localhost/cms_morra/site_profiles/getfavicon', function(data) {
				$.get(site+'site_profiles/getfavicon', function(data) {
					$('#fav').html(data);
				});                
			});
		
    });
	
	// $('input#sFavicon').click(function(){
		// var formId='#SiteProfileAddFaviconForm';
        // var action=$(formId).attr('action');
        // var myData=$(formId).serialize();
		
		// $.post(action,myData,
			// function(error){
				// $.get('http://localhost/cms_morra/site_profiles/getfavicon', function(data) {
					// $('#fav').html(data);
				// });                
			// });
		
    // });
	
	////////////////////////////////////////////////
    
    //Browse primary image
    $('#primary-image .cms_Thumbnail').click(function(){
        var mediaId;
        
        //Clear all selected class
        //$('#primary-image').find('.cms_Thumbnail').removeClass('isSelected');
        
        //Check isSelected class have set or not
        var isSelected=$(this).hasClass('isSelected');

        if(!isSelected){
            //Set class that have clicked
            $(this).addClass('isSelected');
            mediaId=$(this).find('.media-id').html();
        }else{
            //Remove isSelected class that have clicked
            $(this).removeClass('isSelected');
        }
        
        //Change value on hidden textfield with id #ProjectListMediaId
        //$('#ProjectListMediaId').val(mediaId);
        
        src=$(this).find('img').attr('src');
        //alert(src);
        //$('#primary-image-show').attr('src',src);
    });
    
    // $('a[href="#set-as-primary-image"]').click(function(event){
        // event.preventDefault();
        // var objImg=$('#primary-image').find('.isSelected');
        // var n=objImg.size();
        // if(n==1){
            // var mediaId=objImg.find('.media-id').html();
            
            ////Change value on hidden textfield with id #ProjectListMediaId
            ////alert(mediaId);
            // $('#ProjectListMediaId').val(mediaId);
            
            // src=objImg.find('img').attr('src');
            ////alert(src);
            // $('#primary-image-show').attr('src',src);
            
            ////Remove all selected image
            // $('#primary-image').find('.cms_Thumbnail').removeClass('isSelected');
        // }else if(n<1){
            // alert('Please select an image first');
            // clearSelected();
        // }else{
            // alert('Please select one image only')
            // clearSelected();
        // }
    // });
    
    //Clear selected image on cms_Thumnail
    function clearSelected(){
        $('#primary-image').find('.cms_Thumbnail').removeClass('isSelected');        
    }
    
    // $('a[href="#delete-image"]').click(function(event){
        // event.preventDefault();
        
        ////alert('Halow');
        // var childSelected=$('#primary-image').find('.cms_Thumbnail.isChild.isSelected').length;
        // if(childSelected<=0)
            // $('#primary-image').find('.cms_Thumbnail.isParent.isSelected').each(function(i){
                // $(this).remove();
                // var mediaId=$(this).find('.media-id').html();
    
                // var htmlElement='<input type="hidden" name="data[delete][mediaid][]" value="'+mediaId+'" />';
                ////alert(htmlElement);
                // $('#deleted-images').append(htmlElement);
            // });
        // else alert('Child images cannot be deleted. Please try again');
        
        // clearSelected();
    // });

    //$('#ProjectListAtributAddForm').submit(function(event){
        /* stop form from submitting normally */
    //    event.preventDefault();
        
    //    var formObj=this;
    //    var arrayIndex=$(this).find('#array-index').html();
    //    var projectId=$(this).find('#project-id').html();
    //    var action=$(this).attr('action');
    //    var myData=$(this).serialize()
        
        //alert(projectId);
        
    //    $.post(action,myData,
    //           function(error){
                    //console.log(error.match('0')==null);
                    //alert("'"+error+"'");
    //                if(error.match('0')==null){
    //                    appandPage(arrayIndex,projectId);
                        //alert(arrayIndex+1);
    //                    $(formObj).find('#array-index').text(parseInt(arrayIndex)+1);
                        //alert($(this).find('#array-index').html());
                        
                        //var selector='#add-new-page-form';
                        //
                        //$(selector).hide();
                        //$("#tr_add_page").show();
    //                }else{
    //                    alert('Please try again');
    //                }
    //	           });
    //});
    
    //function
    //function appandPage(index,projectId){
        //Get a page and appand to table 
    //    $.get(GET_NEWEST_ATRIBUT+'/'+index+'/'+projectId,function(data){
                //$('#page-'+maxPageId).after(data);
    //            $('.atribut:last').after(data);
                //maxPageId++;
    //        });
    //}
	
	function clearSelected(){
        $('#primary-image').find('.cms_Thumbnail').removeClass('isSelected');        
    }

});