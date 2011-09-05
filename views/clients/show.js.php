$('#client_form').replaceWith(<?= encode_javascript(render('clients/show'.$nested.'.html.php', null, array('client'=>$client))) ?>);

handleAggregates();
