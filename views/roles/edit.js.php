var dialog = $('<div id="edit_role"></div>');
dialog.append(<?= encode_javascript(render('roles/_form.html.php', null, array('role'=>$role))) ?>);
dialog.find('input[type=submit]').remove();
$('body').append(dialog);

dialog.dialog({
    title: 'Rolle bearbeiten',
    modal: true,
    buttons: [
        {
            text: 'Speichern',
            click: function() {
                $('#edit_role').find('form').submit();
            }
        }
    ]
});