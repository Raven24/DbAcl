var dialog = $('<div id="create_daemon"></div>');
dialog.append(<?= encode_javascript(render('daemons/_form.html.php', null)) ?>);
dialog.find('input[type=submit]').remove();
$('body').append(dialog);

dialog.dialog({
    title: '<?= _("Create daemon") ?>',
    modal: true,
    buttons: [
        {
            text: '<?= _("save") ?>',
            click: function() {
                $('#create_daemon').find('form').submit();
            }
        }
    ]
});