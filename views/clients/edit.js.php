var form = $(<?= encode_javascript(render('clients/_form.html.php', null, array('client'=>$client, 'nested'=>$nested))) ?>);
var target = $('dd[data-id=<?= $client['id'] ?>], dl.client[data-id=<?= $client['id'] ?>]');
var oldElem = target.clone(true, true);

var abort = $('<button>Cancel</button>');
abort.click(function(){
    form.replaceWith(oldElem);
    handleAggregates();
    return false;
});
form.find('.actions').append(abort);

$('dd[data-id=<?= $client['id'] ?>], dl.client[data-id=<?= $client['id'] ?>]').replaceWith(form);