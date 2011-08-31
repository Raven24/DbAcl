var dialog = $('<div id="create_person"></div>');
dialog.append(<?= encode_javascript(render('people/_form.html.php', null)) ?>);
dialog.find('input[type=submit]').remove();
$('body').append(dialog);

dialog.dialog({
    title: '<?= _('Create person') ?>',
    modal: true,
    buttons:[
        {
            text: '<?= _('save') ?>',
            click: function() {
                $('#create_person').find('form').submit();
            }
        }
    ]
});
