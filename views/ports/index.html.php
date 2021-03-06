<h1><?= _('Listing ports') ?></h1>

<?php foreach( $ports as $port ) {
    
    echo partial('ports/show.html.php', array('port'=>$port));

} ?>

<?= HTML::css("
dl.port { margin: 1px 0; }
form { display: inline-block; }
") ?>

<?php content_for('controls'); ?>
<div id="controls">
    <ul>
        <li><a href="<?= url_for('ports','new') ?>" id="createPort"><img src="img/create_port.png" alt="<?= _("New port") ?>" title="<?= _("New port") ?>"></a></li>
    </ul>
</div>
<?php end_content_for(); ?>

<?php content_for('scripts'); ?> 

<?= HTML::script("
$('.edit_port, #createPort').live('click', function() {
    $.getScript(this.href);
    return false;
});

var currentNav = 'ports';
"); ?>

<?php end_content_for(); ?>