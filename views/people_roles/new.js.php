var form = $(<?= encode_javascript(render('people_roles/_form.html.php', null, array('role'=>$role, 'people'=>$people))) ?>);
var abort = $('<button>Cancel</button>');
abort.click(function(){
    form.remove();
    return false;
});
form.find('.actions').append(abort);

$('dl[data-id=<?= $role['id'] ?>] dd').slideToggle('fast','swing');
$('dl[data-id=<?= $role['id'] ?>]').append(form);