var dialog = $('<div id="create_port"></div>');
dialog.append(<?= encode_javascript(render('ports/_form.html.php', null, array('remote'=>'false'))) ?>);
dialog.find('input[type=submit]').remove();
$('body').append(dialog);

dialog.dialog({
    title: '<?= _('Create port') ?>',
    modal: true,
    buttons:[
        {
            text: '<?= _('save') ?>',
            click: function() {
                $('#create_port').find('form').submit();
            }
        }
    ]
});
