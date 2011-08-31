var dialog = $('<div id="editPerson"></div>');
dialog.append(<?= encode_javascript(render('people/_form.html.php', null, array('person'=>$person))) ?>);
dialog.find('input[type=submit]').remove();
$('body').append(dialog);

dialog.dialog({
    title: '<?= _('Edit person') ?>',
    modal: true,
    buttons: [
        {
            text: '<?= _('save') ?>',
            click: function() {
                $('#editPerson').find('form').submit();
            }
        }
    ]
});
