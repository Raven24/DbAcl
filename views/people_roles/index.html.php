<h1><?= _('Assign people to their roles') ?></h1>

<div class="dragitems people">

    <?php foreach($people as $person) { ?><div data-id="<?= $person['pid'] ?>" class="person">
        <img src="img/person.png" height="22" width="22" alt="<?= _('person') ?>" title="<?= _('person') ?>">
        <span class="name"><strong><?= $person['nachname'] ?></strong> <?= $person['vorname'] ?></span><br>
        <small>(<?= sprintf(ngettext('%d client', '%d clients', count($person['clients'])), count($person['clients'])) ?>)</small>
    </div><?php } ?>

</div>


<div class="dropitems roles">

<?php
foreach($roles as $role) { 
    echo partial('people_roles/_role.html.php', array('role'=>$role));    
}
?>

</div>

<?php content_for('scripts'); ?>
<script type="text/javascript">

// let text 'fade out' if too long
var dragBg = $('.dragitems > div').css('background-color');
var dragBgRGB = getRGB(dragBg);
$('.dragitems > div').css('position', 'relative').append(
    $('<div></div>').css({
        'width' : '1.5em',
        'position' : 'absolute',
        'right' : 0,
        'top' : 0,
        'bottom' : 0,
    }).attr('style', function(i, val) {
        var style = val;
        style += 'background-image: -webkit-gradient(linear, left bottom, right bottom, color-stop(0, rgba('+dragBgRGB[0]+', '+dragBgRGB[1]+', '+dragBgRGB[2]+', 0.0)), color-stop(0.75, '+dragBg+'));\
            background-image: -moz-linear-gradient(left, rgba('+dragBgRGB[0]+', '+dragBgRGB[1]+', '+dragBgRGB[2]+', 0.0) 0%, '+dragBg+' 75%)';
        return style;
    })
);


$('.dragitems > div, span.person').css('cursor','move').draggable(dragDefaults);

$('body').droppable({
    //activeClass: 'dropHighlight',
    //hoverClass: 'dropHover',
    accept: function(param) {
        if( param.is('span.person') )
            return true;

        return false;
    },
    drop: function(event, ui) {
        showOverlay();
        
        $.post('<?= url_for('people_roles') ?>', {
            person_id : ui.draggable.data('id'),
            role_id   : ui.draggable.data('role_id'),
            '_method' : 'DELETE',
            connect   : 1
        }, null, 'script');
    }
});

$('.dropitems > div').droppable({
    activeClass: 'dropHighlight',
    hoverClass: 'dropHover',
    accept: function(param) {
        if ( param.is('span.person') )
            return false;
            
        if( $.inArray(param.data('id'), $(this).data('containing')) != -1 )
            return false;
        else
            return true;
    },
    drop: function(event, ui) {
        showOverlay();

        $.post('<?= url_for('people_roles') ?>', {
            role_id   : $(this).data('id'),
            person_id : ui.draggable.data('id'),
            connect   : 1
        }, null, 'script');
        
    }
});

var currentNav = "people_roles";

</script>
<?php end_content_for(); ?>