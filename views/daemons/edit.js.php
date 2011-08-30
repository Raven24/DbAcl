var dialog = $('<div id="edit_daemon"></div>');
dialog.append(<?= encode_javascript(render('daemons/_form.html.php', null, array('daemon'=>$daemon))) ?>);
dialog.find('input[type=submit]').remove();
$('body').append(dialog);

dialog.dialog({
    title: 'Daemon bearbeiten',
    modal: true,
    buttons: [
        {
            text: 'Speichern',
            click: function() {
                $('#edit_daemon').find('form').submit();
            }
        }
    ]
});