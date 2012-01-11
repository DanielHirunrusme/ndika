$(document).ready(function(){
    //trigger for all form to show dialog box when user close windows but data didn't(forgot) save
    $('form.notif-change').change(function(){
        window.onbeforeunload=function(){
             return 'You have unsaved changes. Are you sure you want to leave this page?';    
        };
    });
    
    $('form').submit(function(event){
        //alert('halow');
        window.onbeforeunload=function(){};
    });
    
    //Show modal box for add new project
    $('.isNew').click(function(){
        $('.add-new-project').fadeIn('slow');
    });
});

//When click submit on edit page
function editPage(){
    window.onbeforeunload=function(){};
    document.forms['PageEditForm'].submit();
}

function copy(text) {
    if (window.clipboardData) {
        window.clipboardData.setData("Text",text);
    }
}