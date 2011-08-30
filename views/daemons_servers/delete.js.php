$('dl[data-id=<?= $server['id'] ?>] dd[data-id=<?= $daemon['id'] ?>]').fadeOut('slow', function(){
    $(this).remove();
});