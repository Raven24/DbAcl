$('dl[data-id=<?= $role['id'] ?>] dd[data-id=<?= $service['id'] ?>]').fadeOut('slow', function(){
    $(this).remove();
});