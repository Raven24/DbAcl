$('dd[data-id=<?= $client['id'] ?>], dl.client[data-id=<?= $client['id'] ?>]').fadeOut('slow', function() {
    $(this).remove();
    handleAggregates();
});
