var form = $(<?= encode_javascript(render('clients/_form.html.php', null, array('person_id'=>$person_id))) ?>);
var abort = $('<button>Cancel</button>');
abort.click(function(){
    form.remove();
    return false;
});
form.find('.actions').append(abort);

$('dl[data-id=<?= $person_id ?>]').append(form);