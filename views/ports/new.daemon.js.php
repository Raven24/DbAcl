var form = $(<?= encode_javascript(render('ports/_form.html.php', null, array('daemon_id'=>$daemon_id))) ?>);
var abort = $('<button><?= _("cancel") ?></button>');
abort.click(function(){
    form.remove();
    return false;
});
form.find('.actions').append(abort);

$('dl[data-id=<?= $daemon_id ?>]').append(form).find('dd').show();