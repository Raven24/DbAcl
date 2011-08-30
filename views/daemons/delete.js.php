$('dl[data-id=<?= $daemon['id'] ?>]').fadeOut('slow', function() {
    $(this).remove();
});