$('#port_form').wrap('<dd data-id="<?= $port['id'] ?>"></dd>');
$('#port_form').replaceWith(<?= encode_javascript(render('ports/show.html.php', null, array('port'=>$port))) ?>);