$('dd[data-id=<?= $port['id'] ?>]').fadeOut('slow', function() {
    $(this).remove();
});