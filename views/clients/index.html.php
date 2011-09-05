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
        <!--<li><a href="<?= url_for('servers','new') ?>" id="createServer"><img src="img/create_server.png" alt="Neuer Server" title="Neuer Server"></a></li>-->
    </ul>
</div>
<?php end_content_for(); ?>

<?php content_for('scripts'); ?>
<script type="text/javascript">

$('.edit_client').live("click", function() {
    $.getScript(this.href);
    return false;
});

var currentNav = "clients";

</script>
<?php end_content_for(); ?>