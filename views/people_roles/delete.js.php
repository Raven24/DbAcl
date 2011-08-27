$('dl[data-id=<?= $role['id'] ?>] dd[data-id=<?= $person['id'] ?>]').fadeOut('slow', function(){
    $(this).remove();
});