var dialog = $('<div id="create_role"></div>');
dialog.append(<?= encode_javascript(render('roles/_form.html.php', null)) ?>);
dialog.find('input[type=submit]').remove();
$('body').append(dialog);

dialog.dialog({
    title: 'Rolle erstellen',
    modal: true,
    buttons: [
        {
            text: 'Speichern',
            click: function() {
                $('#create_role').find('form').submit();
            }
        }
    ]
});