$('#client_form').wrap('<dd data-id="<?= $client['id'] ?>"></dd>');
$('#client_form').replaceWith(<?= encode_javascript(render('clients/show.html.php', null, array('client'=>$client))) ?>);