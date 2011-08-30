$('dl[data-id=<?= $server['id'] ?>]').fadeOut('slow', function() {
    $(this).remove();
});