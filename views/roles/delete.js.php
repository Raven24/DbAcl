$('dl[data-id=<?= $role['id'] ?>]').fadeOut('slow', function() {
    $(this).remove();
});