var dialog = $('<div id="create_daemon"></div>');
dialog.append(<?= encode_javascript(render('daemons/_form.html.php', null)) ?>);
dialog.find('input[type=submit]').remove();
$('body').append(dialog);

dialog.dialog({
    title: 'Daemon erstellen',
    modal: true,
    buttons: [
        {
            text: 'Speichern',
            click: function() {
                $('#create_daemon').find('form').submit();
            }
        }
    ]
});