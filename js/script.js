/* Author: 
  Florian Staudacher
*/

$('.button, button').button();

$('*[data-method=delete]').click(function(){
    if(confirm('are you sure?'))
    {
        $.ajax(this.href, {
            type: 'DELETE',
            success: function(response) {
                location.reload();
            }
        });
    }
    return false;
});

$('*[data-remote=true]').live("submit", function() {
    $.post(this.action, $(this).serialize(), null, 'js');
    return false;
});










