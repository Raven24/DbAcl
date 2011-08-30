var dialog = $('<div id="edit_server"></div>');
dialog.append(<?= encode_javascript(render('servers/_form.html.php', null, array('server'=>$server))) ?>);
dialog.find('input[type=submit]').remove();
$('body').append(dialog);

dialog.dialog({
    title: 'Server bearbeiten',
    modal: true,
    buttons: [
        {
            text: 'Speichern',
            click: function() {
                $('#edit_server').find('form').submit();
            }
        }
    ]
});