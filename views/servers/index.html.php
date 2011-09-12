<h1><?= _("Listing servers") ?></h1>

<?php foreach( $servers as $server ) { ?>

<dl class="listitem server" data-id="<?= $server['sid'] ?>">
    <dt>
        <div class="controls">
            <a href="<?= url_for('servers', $server['sid'], 'daemons', 'new') ?>" class="add_daemon"><img src="img/add.png" alt="<?= _("New service") ?>" title="<?= _("New daemon") ?>"></a>
            <a href="<?= url_for('servers', $server['sid'], 'edit') ?>" class="edit_role"><img src="img/edit.png" alt="<?= _('Edit service') ?>" title="<?= _('Edit server') ?>"></a>
            <a href="<?= url_for('servers', $server['sid']) ?>" data-method="delete"><img src="img/delete.png" alt="<?= _('Delete service') ?>" title="<?= _('Delete server') ?>"></a>
        </div>
        <strong><?= $server['fqdn'] ?></strong> <span><?= $server['desc'] ?></span> <small>(<?= sprintf(ngettext('%d daemon', '%d daemons', count($server['daemons'])), count($server['daemons'])) ?>)</small><br>
        <?= $server['mac'] ?> - <?= $server['ip'] ?>
    </dt>
<?php
foreach($server['daemons'] as $daemon) {
    $server['id'] = $server['sid'];
    $daemon['id'] = $daemon['did'];
?>
    <dd data-id="<?= $daemon['id'] ?>">
        <?= render('daemons/show.html.php', null, array('daemon'=>$daemon, 'server'=>$server)) ?>
    </dd>
<?php } ?>
</dl>

<?php } ?>

<?php content_for('controls'); ?>
<div id="controls">
    <ul>
        <li><a href="<?= url_for('servers','new') ?>" id="createServer"><img src="img/create_server.png" alt="<?= _("Create server") ?>" title="<?= _("Create server") ?>"></a></li>
    </ul>
</div>
<?php end_content_for(); ?>

<?php content_for('scripts'); ?>
<script type="text/javascript">

$('#createServer, .edit_role, .add_daemon').click(function() {
   $.getScript(this.href);
   return false;
});

var currentNav = "servers";

</script>
<?php end_content_for(); ?>