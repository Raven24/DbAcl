var form = $(<?= encode_javascript(render('clients/_form.html.php', null, array('person_id'=>$person_id, 'nested'=>$nested))) ?>);
var abort = $('<button><?= _("cancel") ?></button>');
abort.click(function(){
    form.remove();
    return false;
});
form.find('.actions').append(abort);

$('dl[data-id=<?= $person_id ?>]').append(form).find('dd').show();