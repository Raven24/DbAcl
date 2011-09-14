<h1><?= _('Listing clients') ?></h1>

<?php foreach( $clients as $client ) {
    
    echo partial('clients/show.html.php', array('client'=>$client));

} ?>

<style type="text/css">
dl.client { margin: 1px 0; }
form { display: inline-block; }
</style>

<?php content_for('controls'); ?>
<div id="controls">
    <ul>
        <li><a href="<?= url_for('clients','new') ?>" id="createClient"><img src="img/create_client.png" alt="<?= _("New client") ?>" title="<?= _("New client") ?>"></a></li>
    </ul>
</div>
<?php end_content_for(); ?>

<?php content_for('scripts'); ?> 

<?= HTML::script("
$('.edit_client, #createClient').live('click', function() {
    $.getScript(this.href);
    return false;
});
var currentNav = 'clients';
") ?>

<?php end_content_for(); ?>