var form = $(<?= encode_javascript(render('daemons_servers/_form.html.php', null, array('server'=>$server, 'daemons'=>$daemons))) ?>);
var abort = $('<button>Cancel</button>');
abort.click(function(){
    form.remove();
    return false;
});
form.find('.actions').append(abort);

$('dl[data-id=<?= $server['id'] ?>]').append(form);