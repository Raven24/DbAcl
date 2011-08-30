/* Author: 
  Florian Staudacher
*/

$('.button, button').button();

$('*[data-method=delete]').live("click", function(){
    if(confirm('are you sure?'))
    {            
        $.ajax(this.href, {
            type: 'DELETE',
            //dataType: 'script',
            success: function(data, status, xhr) {
                //console.log(xhr.getAllResponseHeaders());
            }                
            
        });
    }
    return false;
});

$('*[data-remote=true]').live("submit", function() {    
    $.post(this.action, $(this).serialize(), null, 'script');
    return false;
});










