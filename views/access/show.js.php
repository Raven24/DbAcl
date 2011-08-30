$('#access_form').wrap('<dd data-id="<?= $service['dienst_id'] ?>"></dd>');
$('#access_form').replaceWith(<?= encode_javascript(render('access/show.html.php', null, array('service'=>$service))) ?>)
