<h1><?= _('Assign services to roles') ?></h1>

<div class="dragitems services">
<?php 
foreach($services as $service) { 
	echo partial('roles_services/_service.html.php', array('service' => $service));
}	
?>
</div>

<div class="dropitems roles">
<?php 
foreach( $roles as $role ) { 
	echo partial('roles_services/_role.html.php', array('role'=>$role));    	
} 
?>
</div>

<?= HTML::css("
span.service { display: inline-block; font-size: .84em; text-align: center; color: #666; background: #FAFAFA; padding: 2px 4px; margin: 2px 2px 0 0; }
span.service strong { font-size: 1.1em; } 
") ?>

<?php content_for('scripts'); ?> 

<?= HTML::script("
$('.dragitems > div, span.service').css('cursor','move').draggable(dragDefaults);

$('body').droppable({
    accept: function(param) {
        if( param.is('span.service') )
            return true;

        return false;
    },
    drop: function(event, ui) {
        showOverlay();
        
        $.post('".url_for('roles_services') ."', {
            serivce_id : ui.draggable.data('id'),
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
        if ( param.is('span.service') )
            return false;
            
        if( $.inArray(param.data('id'), $(this).data('containing')) != -1 )
            return false;
        else
            return true;
    },
    drop: function(event, ui) {
        showOverlay();

        $.post('". url_for('roles_services') ."', {
            role_id   : $(this).data('id'),
            service_id : ui.draggable.data('id'),
            connect   : 1
        }, null, 'script');
        
    }
});
var currentNav = 'roles_services';
") ?>

<?php end_content_for(); ?>