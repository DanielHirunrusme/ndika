$(document).ready(function(){    
    URL=site+'pages/';
    GET_PAGE=URL+'getpage';
    EDIT_PAGE=URL+'editpage';
    DELETE_PAGE=URL+'deletepage';
    CHANGE_STATUS=URL+'changestatus';
    
    //init data
    //$('#PageList').hide();
    //$('#PageList').load('/cms_morra/pages/pagelist/');
    //$('#PageList').show('fast');
    init();
    mce_init();
    
    var maxPageId=$('#max-page-id').val();
    maxPageId=parseInt(maxPageId);
    
	//submit new template
	$('#PageUploadTemplateForm').submit(function(event){
		if($('#text-template').val()=="")
		{
            alert('Please select a file to upload');
			event.preventDefault();
		}
        else
		{
            document.forms['PageUploadTemplateForm'].submit();
		}
    });
	
	//==========FOR ADD PAGE=================
    //add new page clicked
    $('#add-new-page-form' ).hide();
    $("#add-new-page").click(function(){
        $('#add-new-page-form' ).show();
        $('#tr_add_page').hide();
    }); 

    //cancel clicked
    $('input#add-new-page-form-cancel').click(function(){
        var selector='#add-new-page-form';
        
        $(selector).hide();
        $("#tr_add_page").show();
        //$('div #cms_Main:eq(2)').animate({height:0},'slow');
        //$('div #cms_Main:eq(2)').hide('fast');
    })
    
    //Submit new page
    $('#PageAddpageForm').submit(function(event){
        /* stop form from submitting normally */
        event.preventDefault();

        var action=$('#PageAddpageForm').attr('action');
        var myData=$("#PageAddpageForm").serialize()
        $.post(action,myData,
               function(error){
                    //console.log(error.match('0')==null);
                    //alert("'"+error+"'");
                    if(error.match('0')==null){
                        appandPage();
                        var selector='#add-new-page-form';
                        
                        $(selector).hide();
                        $("#tr_add_page").show();
						
						$("input#title").val('');
                    }else{
                        alert('Page names already exists, please try again');
                    }
                });
    });
    
    $(document).on('click','.page-info',function(){
        $status=$(this).find('a[href|="#status-page"]').html();
        
        //Check Status and invert it
        if($status=='Active'){
            //If status active set to disable on status text
            
            //1. Remove class isBad or isGood
            $(this).find('.cms_Status').removeClass('isGood isBad');
            
            //2. Set correct class
            $(this).find('.cms_Status').addClass('isBad');
            
            //3. Set correct text
            $(this).find('.cms_Status').html('Disabled');
        }else{
            //If status active set to disable on status text
            
            //1. Remove class isBad or isGood
            $(this).find('.cms_Status').removeClass('isGood isBad');
            
            //2. Set correct class
            $(this).find('.cms_Status').addClass('isGood');
            
            //3. Set correct text
            $(this).find('.cms_Status').html('Active');            
        }
    });
    
    //==========FOR Deactive/Active & Delete page=================
    //For status (deactive/active)
    $('a[href|="#status-page"]').live('click',function(event){
        event.preventDefault();
        
        //$(this).html('<p>Hallow Dunia jQuery Aku bingung!!!</p>');
        
        //alert('testing');
        
        //href=#page-{id}
        var n='#status-page'.length;
        n++;
        
        var href=$(this).attr('href');
        //pageid=get the href {id}
        //pageid=id
        var pageid=href.substr(n);

        //Change status on database
        $.get(CHANGE_STATUS+'/'+pageid);
        
        //Change value status to active/disable
        var selector='#status-page-'+pageid;
        
        var status=$(this).html();
        
        if(status=='Active'){
            status='Disabled';
        }
        else
        {
            status='Active';
        }

        //Change status
        $(selector).html($(this).html());
        $(this).html(status);
        
        var theStyle=(status!='Active')?'isGood':'isBad';
        $(selector).removeClass('isBad isGood').addClass(theStyle);
    });
    
    //For Delete Pages
	
	//$('#responseDelete').hide();
	
    $(document).on('click','a[href|="#delete-page"]',function(event){
		
		//$('#responseDelete').hide();
	
        event.preventDefault();

        if(confirm('Are you sure want to delete page?')){
            //href=#page-{id}
            var n='#delete-page'.length;
            n++;
            
            var href=$(this).attr('href');
            //pageid=get the href {id}
            //pageid=id
            var pageid=href.substr(n);
            var sukses=false;
            $.get(DELETE_PAGE+'/'+pageid);
            
            //Get the tr object
            var theParent=$(this).parent().parent().parent();
            theParent.fadeOut();
            theParent.remove();
			
			$('#responseDelete').html('Delete Success');
			$('#responseDelete').show();
			
			//alert('Delete Success');
			
        }
    });
    
    //For edit page -  When page clicked
    $(document).on('click','a[href|="#page"]',function(){
        //alert('show');
        //href=#page-{id}
        var href=$(this).attr('href');
        
        //pageid=get the href {id}
        //pageid=id
        var pageid=href.substr(6);
        //alert(pageid);
        
        //load edit page from action=editpage
        $('div #cms_Main:eq(1)').load(EDIT_PAGE+'/'+pageid,function(data){
            //show edit page;
            $('div #cms_Main:eq(1)').show('fast');
            //$('div #cms_Main:eq(2)').animate({height:582},'slow');
            $('div #cms_Main:eq(1)').animate({backgroundColor: '#FFFF99'},"slow");
            $('div #cms_Main:eq(1)').animate({backgroundColor: '#FFFFFF'},"slow");
            $('div #cms_Main:eq(0)').hide('slow');
            mce_init();
        });
    });
    
    //On Blur di attribut
    $(document).on('blur','form#PagesDetailEditForm',function(){
        var action=$(this).attr('action');
        var myData=$(this).serialize();
        var objForm=this;
        
        $.post(action,myData,
               function(error){
                    //Jika tidak ada error
                    if(error.length==0){
                        $(objForm).find('.Pages-Detail-textbox').animate({backgroundColor: '#669933'},"slow"); //Hijau
                        $(objForm).find('.Pages-Detail-textbox').animate({backgroundColor: '#FFFFFF'},"slow"); //Putih                       
                    }else{
                        $(objForm).find('.Pages-Detail-textbox').animate({backgroundColor: '#FF0000'},"slow"); //Merah
                        $(objForm).find('.Pages-Detail-textbox').animate({backgroundColor: '#FFFFFF'},"slow"); //Putih                       
                    }
                });
    });
    
    $(document).on('submit','form#PagesDetailEditForm',function(event){
        event.preventDefault();
    });
    
    $(document).on('click','#add-new-attribut-cancel',function(){
        $('#add-new-attribut').show();
        $('#add-new-attribut-form').hide();
    });
    
    //Submit Page Content when blur event
    $(document).on('submit','#content-mce',function(event){
        //alert(tinyMCE.get('page_content').getContent());
        event.preventDefault();
        
        var objForm=this;
        $(objForm).find('#save-submit').val('Saving...');        
        
        var action=$(this).attr('action');
        var myData=$(this).serialize();
        
        $.post(action,myData,
            function(error){
                $(objForm).find('#save-submit').val('Saved');        
                
            });
    });
    
    //Edit page BACK button clicked
    $(document).on('click','.edit-page-back-button',function(){
        //Hide Edit Page DIV
        $('div #cms_Main:eq(1)').hide('fast');
        
        //Show List Page again
        $('div #cms_Main:eq(0)').show('fast');
    });
    
    $(document).on('click','a[href="#add-new-attribut"]',function(){
        $('#add-new-attribut').hide();
        $('#add-new-attribut-form').show();
    });
    
    $(document).on('click','#link_atrib',function(){
        //Show Add New Attribut link
        $('#add-new-attribut-form').show();
        
        //Hide this form
        $('#add-new-attribut').hide();
        
    });

    //function
    function appandPage(){
        //Get a page and appand to table 
        $.get(GET_PAGE,function(data){
                //$('#page-'+maxPageId).after(data);
                $('.page-info:last').after(data);
                //maxPageId++;
            });
    }
    
    function init(){
    }
    
    function mce_init(){
        tinyMCE.init({
                // General options
                mode : "exact",
                elements : "page_content",
                theme : "advanced",
                plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
        
                // Theme options
                theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview",
                theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print",
                theme_advanced_buttons4 : "ltr,rtl,|,fullscreen,forecolor,backcolor,|,insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
                theme_advanced_toolbar_location : "top",
                theme_advanced_toolbar_align : "left",
                theme_advanced_statusbar_location : "bottom",
                theme_advanced_resizing : true,
        
                // Example content CSS (should be your site CSS)
                content_css : "css/content.css",
        
                // Drop lists for link/image/media/template dialogs
                template_external_list_url : "lists/template_list.js",
                external_link_list_url : "lists/link_list.js",
                external_image_list_url : "lists/image_list.js",
                media_external_list_url : "lists/media_list.js",
        
                // Replace values for the template plugin
                template_replace_values : {
                        username : "Some User",
                        staffid : "991234"
                }
        });                
    }
});