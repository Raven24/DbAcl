$('dd[data-id=<?= $port['id'] ?>], dl.port[data-id=<?= $port['id'] ?>]').fadeOut('slow', function() {
    $(this).remove();
});