$('dl[data-id=<?= $person['id'] ?>]').fadeOut('slow', function() {
    $(this).remove();
});