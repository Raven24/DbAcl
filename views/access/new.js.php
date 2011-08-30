var form = $(<?= encode_javascript(render('access/_form.html.php', null, array('role'=>$role, 'services'=>$services))) ?>);
var abort = $('<button>Cancel</button>');
abort.click(function(){
    form.remove();
    return false;
});
form.find('.actions').append(abort);

$('dl[data-id=<?= $role['id'] ?>]').append(form);