var seq=new Array('#mr_Footer','#mr_Header','#mr_Body');
var isReady=false;
var color= new Color();
var url= new Url(site);

//function Page(url, classStyle, adjustBG, adjustBlockBg, mrFooter){
var home= new Page('Home',url.HOME, 'isHome', '#f68c14', '#f68c14', '#f2cc4a');
var about= new Page('About',url.ABOUT, 'isAbout', '#c14499', '#af3c8b', '#dfa6cf');
var service= new Page('Services',url.SERVICES, 'isServices', '#4cc2c5', '#43a8ab', '#7ed2d7');
var partner= new Page('Partners', url.PARTNERS, 'isPartners', '#97b93d', '#8ba93e', '#b2e777');
var career= new Page('Career', url.CAREER, 'isCareer', '#ed7464', '#ee6958', '#f29b7c');
var contact= new Page('Contact Us', url.CONTACT_US, 'isContact', '#875bab', '#8051a6', '#aa91d6');

var template=new Array(home,about,service,partner,career,contact);

var transisi=600;

$(document).ready(function(){    
    $('#mr_Navigation li').removeClass();
    
    //Hide all container div
    hideAll();
    
    //Show all container one by one(Animate)
    fadeInAll();
    isReady=true;
    
    loadRightPage();

    //====================Event===============
    //When click link About
    $("[href='#about-us']").click(function(event){
        changePage(this, about);
    });
    
    //When click link Services
    $("[href='#services']").click(function(event){
        changePage(this, service);
    });
    
    //When click link Partners
    $("[href='#partners']").click(function(event){
        changePage(this, partner);
    });
    
    //When click link Career
    $("[href='#career']").click(function(event){
        changePage(this, career);
    });

    //When click link Contact Us
    $("[href='#contact-us']").click(function(event){
        changePage(this, contact);
    });

    //When click link home
    $("[href='#home']").click(function(event){
        changePage(this, home);
    });
    
    $(window).hashchange(function(){
        loadRightPage();
    });
	
    $('a').click(function(){
        $('#mr_Navigation li').removeClass('isSelected');
            $(this).parent().addClass('isSelected');
    });
});

//Load right page depend on hash info
function loadRightPage(){
    var myStr=location.hash;
	var changeId;
	
    if (myStr!=undefined && myStr!=""){
        var pageId=myStr.substring(1);
        var selected=0;
        var pageTitle;
		
		////////////////////////////
		var projectId = new Array();
		//var checkId = new Array();
		//var projectSplit = new Array();
		
		// projectId = pageId.split('-');
		// checkId = pageId.split('|');
		// projectSplit = projectId[1].split('|');
		
		////////////////////////////
		
		projectId = pageId.split('/');
		
		////////////////////////////
		
		if (projectId.length == '1')
		{
			//////////////////////// CEK ID URL PAGE ///////////////////////////
			
			//alert(projectId.length);
			
			$('ul.navigation').find('li').each(function()
			{
				
				////alert('aa : '+$(this).find('div.page-id').html());
				////alert('bb : '+pageId);
			
				if ($(this).find('div.page-id').html() == pageId)
				{
				   
					////alert('masuk');
					
					changeId = $(this).find(".checking").val();
					
					////alert(changeId);
					
					$.get(url.getRoot()+'getpagetitle/'+changeId,function(data){
						pageTitle=data;
						
						selected=0;
						for(x in template){
							//alert(pageTitle);
							if(template[x].title==pageTitle){
								selected=x;
								break;
							}
						}
				
						template[selected].setUrl(url.getRoot()+'getPage/id/'+changeId);
						changePage(this,template[selected]);
						
						var myObj=new MyHash(location.hash);
						//alert('Hash:'+myObj.projectId);
						
						//load project list
					});
					
				}
				
			});

			////////////////////////////////////////////////////////
		
			
			
		}
		else
		{
			
			//alert('a : ' + projectId[0]);
			//alert('b : ' + $(".coba").val());
			
			if (projectId[0] != $(".coba").val())
			{
				$('ul.navigation').find('li').each(function()
				{
					
					////alert('aa : '+$(this).find('div.page-id').html());
					////alert('bb : '+pageId);
				
					if ($(this).find('div.page-id').html() == projectId[0])
					{
					   
						//alert('masuk');
						
						changeId = $(this).find(".checking").val();
						
						////alert(changeId);
						
						$.get(url.getRoot()+'getpagetitle/'+changeId,function(data){
							pageTitle=data;
							
							selected=0;
							for(x in template){
								//alert(pageTitle);
								if(template[x].title==pageTitle){
									selected=x;
									break;
								}
							}
					
							template[selected].setUrl(url.getRoot()+'getPage/id/'+changeId);
							changePage(this,template[selected]);
							
							var myObj=new MyHash(location.hash);
							//alert('Hash:'+myObj.projectId);
							
							//load project list
						});
						
					}
					
				});
				
			}
			else
			{
				$('ol.mr_CareerList').find('li').each(function()
				{
					
					////alert('aa : '+ $(this).find('div.careerDesc').html());
					////alert('bb : '+ projectId[1]);
				
					if ($(this).find('div.careerDesc').html() == projectId[1])
					{	
						//alert('masuk');
					
						changeId = $(this).find('.careerId').val();
						
						$('.dropbox').find('option').removeAttr('selected');
						$('.dropbox').find('option').each(function(){
							if($(this).val()==changeId){
								$(this).attr('selected','selected');
							}
						});	
						
						$('#list-panel').fadeOut('slow',function(){
							$('#info-panel').fadeIn('slow');
							$('#info-panel').find('#project-desc-'+changeId).fadeIn('slow');
						});
						
						lastProjectSelected=changeId;
						
						$('.dropbox').change(function(){

							var projectIdSelected=$(this).val();
							
							//alert(projectIdSelected);
							
							$('#list-panel').fadeOut('slow',function(){
								$('#project-desc-'+lastProjectSelected).fadeOut('slow',function(){
									$('#project-desc-'+projectIdSelected).fadeIn('slow');	
								});
							});
							
							lastProjectSelected=projectIdSelected;
						});
						
						
					}
					
				});
			}
			
			
		}
		
		/////////////////////////////

        
    }
}

//=========Modul============================
//Hide All Container
function hideAll(){

    //Main container
    for(x in seq){
        $(seq[x]).hide();
    }

    //$('#mr_Canvas').fadeTo('slow',0);    
    for(x in seq){
        $(seq[x]).fadeTo('slow',0);
    }
    
    //$('#mr_Canvas').show();
    for(x in seq){
        $(seq[x]).show();
    }
    
}

//Show All Container
function fadeInAll(){
    $('#mr_Body').load(url.getRoot()+'getPage/id/1',function(){
        i=0;    
        (function() {  
            $(seq[i++]).fadeTo(transisi, 1, arguments.callee);  
        })();          
    });
}

function fadeOutAll(){
    i=seq.length-1;    
    (function() {  
        $(seq[i--]).fadeTo('normal', 0, arguments.callee);  
    })();      
}

//========Function for .queue====================
//Show Canvas
function showCanvas(next){
    $('#mr_Canvas').fadeTo('fast',1);
    //next();
}

//Show Header
function showHeader(next){
    $('#mr_Header').fadeTo('slow',1);
    //next();
}

function showFooter(next){
    $('#mr_Footer').fadeTo('slow',1);
    //next();
}

//=======Trasition Change Page===================
function changePage(objLink, pageObj){
    //$('.adjustBG').animate({backgroundColor: hexColor},"slow");
    var div='#mr_Body';
    
    //alert(pageObj.adjustBlockBg);

    //$('#mr_Footer').fadeTo('normal', 0);
    //$('#mr_Header').fadeTo('normal', 0);
    //alert(pageObj.url);
	
	///////////////////////////////////////
	
	var myStr=location.hash;

	var pageId=myStr.substring(1);

	var projectId = new Array();
	
	projectId = pageId.split('/');
			
	// $('ol.mr_CareerList').find('li').each(function()
	// {
		
		// alert('aa : '+ $(this).find('.career-id').html());
		// alert('bb : '+ projectSplit[1]);
	
		// if ($(this).find('.career-id').html() == projectSplit[1])
		// {
		   
			////alert('masuk');
			
			// yeah = $(this).find('input.checkingCareer').val();
			
			// alert(yeah);
		// }
		// else
		// {
			// alert('tidak masuk');
		// }
		
	// });
	
	//////////////////////////////////////
	
    
    $(div).fadeTo(transisi, 0 , function(){
        $(div).load(pageObj.url,function(data){
            //Change Color to dest color
            $('.adjustBG').animate({backgroundColor: pageObj.adjustBg},transisi);
        
            if(pageObj.adjustBlockBg!=null){
                $('.adjustBlockBG').animate({backgroundColor: pageObj.adjustBlockBg},transisi);
            }
            
            $('#mr_Canvas').removeClass().addClass(pageObj.classStyle);
            
    
            //$('#mr_Footer').fadeTo('normal', 1);
            //$('#mr_Header').fadeTo('normal', 1);
            $(div).fadeTo(transisi, 1);
			
			////////////////////////////////////////////////////////
			
			// $('.dropbox').find('option').removeAttr('selected');
			// $('.dropbox').find('option').each(function(){
				// if($(this).val()==projectId[1]){
					// $(this).attr('selected','selected');
				// }
			// });		
			
			// lastProjectSelected=projectId[1];
			
			// $('.dropbox').change(function(){
	
				// var projectIdSelected=$(this).val();
				
				////alert(projectIdSelected);
				
				// $('#list-panel').fadeOut('slow',function(){
					// $('#project-desc-'+lastProjectSelected).fadeOut('slow',function(){
						// $('#project-desc-'+projectIdSelected).fadeIn('slow');	
					// });
				// });
				
				// lastProjectSelected=projectIdSelected;
			// });
			
			if (projectId.length == '2')
			{
				
				//////////////////// CEK ID CAREER ///////////////////////////
			
				$('ol.mr_CareerList').find('li').each(function()
				{
					
					//alert('aa : '+ $(this).find('div.careerDesc').html());
					//alert('bb : '+ projectId[1]);
				
					if ($(this).find('div.careerDesc').html() == projectId[1])
					{	
						//alert('masuk');
					
						changeId = $(this).find('.careerId').val();
						
						$('.dropbox').find('option').removeAttr('selected');
						$('.dropbox').find('option').each(function(){
							if($(this).val()==changeId){
								$(this).attr('selected','selected');
							}
						});	
						
						$('#list-panel').fadeOut('fast',function(){
							$('#info-panel').fadeIn('slow');
							$('#info-panel').find('#project-desc-'+changeId).fadeIn('slow');
						});
						
						lastProjectSelected=changeId;
						
						$('.dropbox').change(function(){

							var projectIdSelected=$(this).val();
							
							//alert(projectIdSelected);
							
							$('#list-panel').fadeOut('fast',function(){
								$('#project-desc-'+lastProjectSelected).fadeOut('slow',function(){
									$('#project-desc-'+projectIdSelected).fadeIn('slow');	
								});
							});
							
							lastProjectSelected=projectIdSelected;
						});
						
						
					}
					
				});

				////////////////////////////////////////////////////
				
			}
			
			
        });    
        
    });
    
    //$('#mr_Navigation li').removeClass('isSelected');
    //$(objLink).parent().addClass('isSelected');
}

//Class
function Color(){
    this.HOME='#f68c14';
    this.ABOUT='#c14499';
    this.SERVICES='#c14499';
    this.PARTNERS='';
}

function Url(siteUrl){
    var MY_ROOT=siteUrl+'users/';
    this.HOME=MY_ROOT+'index_ajax';
    this.ABOUT=MY_ROOT+'about_us';
    this.PARTNERS=MY_ROOT+'partners';
    this.CAREER=MY_ROOT+'careers';
    this.CONTACT_US=MY_ROOT+'contact_us';
    this.SERVICES=MY_ROOT+'services'
    
    this.getRoot=function(){
        return MY_ROOT;
    }
}

function Page(title, url, classStyle, adjustBG, adjustBlockBg, mrFooter){
    this.title=title;
    this.url=url;
    this.classStyle=classStyle;
    this.adjustBg=adjustBG;
    this.adjustBlockBg=adjustBlockBg;
    this.mrFooter=mrFooter;
    
    this.setUrl=function(url){
        this.url=url;
    }
}

function MyHash(hashStr){
    //Constructor==START==
    var str=hashStr.substring(1);
    var arr=str.split('|');
    //Constructor==END==
    
    this.pageId=arr[0];
    this.projectId=arr[1];
}

///////////////////////////////////////////
