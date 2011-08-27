$('#people_role_form').wrap('<dd data-id="<?= $person['id'] ?>"></dd>');
$('#people_role_form').replaceWith(<?= encode_javascript(render('people/show.html.php', null, array('person'=>$person, 'role'=>$role))) ?>)
