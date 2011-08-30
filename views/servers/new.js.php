var dialog = $('<div id="create_server"></div>');
dialog.append(<?= encode_javascript(render('servers/_form.html.php', null)) ?>);
dialog.find('input[type=submit]').remove();
$('body').append(dialog);

dialog.dialog({
    title: 'Server erstellen',
    modal: true,
    buttons: [
        {
            text: 'Speichern',
            click: function() {
                $('#create_server').find('form').submit();
            }
        }
    ]
});