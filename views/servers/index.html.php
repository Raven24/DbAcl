<h1>Listing Servers</h1>

<?php foreach( $servers as $server ) { ?>

<dl class="listitem server" data-id="<?= $server['sid'] ?>">
    <dt>
        <div class="controls">
            [<a href="<?= url_for('servers', $server['sid'], 'daemons', 'new') ?>" class="add_daemon">Dienst hinzufügen</a>]
            [<a href="<?= url_for('servers', $server['sid'], 'edit') ?>" class="edit_role">edit</a>]
            [<a href="<?= url_for('servers', $server['sid']) ?>" data-method="delete">delete</a>]
        </div>
        <strong><?= $server['fqdn'] ?></strong> <small><?= $server['desc'] ?></small><br>
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
        <li><a href="<?= url_for('servers','new') ?>" id="createServer">Neuer Server</a></li>
    </ul>
</div>
<?php end_content_for(); ?>

<?php content_for('scripts'); ?>
<script type="text/javascript">

$('#createServer, .edit_role, .add_daemon').click(function() {
   $.getScript(this.href);
   return false;
});

</script>
<?php end_content_for(); ?>