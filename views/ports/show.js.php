$('#port_form').wrap('<dd data-id="<?= $port['pid'] ?>"></dd>');
$('#port_form').replaceWith(<?= encode_javascript(render('ports/show'.$nested.'.html.php', null, array('port'=>$port))) ?>);