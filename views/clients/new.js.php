var dialog = $('<div id="create_client"></div>');
dialog.append(<?= encode_javascript(render('clients/_form.html.php', null, array('remote'=>'false'))) ?>);
dialog.find('input[type=submit]').remove();
$('body').append(dialog);

dialog.dialog({
    title: '<?= _('Create client') ?>',
    modal: true,
    buttons:[
        {
            text: '<?= _('save') ?>',
            click: function() {
                $('#create_client').find('form').submit();
            }
        }
    ]
});
