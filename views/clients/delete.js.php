$('dd[data-id=<?= $client['id'] ?>]').fadeOut('slow', function() {
    $(this).remove();
});