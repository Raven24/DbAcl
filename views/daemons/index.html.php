<h1>Listing Daemons</h1>

<?php foreach( $daemons as $daemon ) { ?>

<dl class="listitem daemon" data-id="<?= $daemon['did'] ?>">
    <dt>
        <div class="controls">
            <a href="<?= url_for('ports', 'new', array('daemon_id'=>$daemon['did'])) ?>" class="add_port"><img src="img/add.png" alt="Port eintragen" title="Port eintragen"></a>
            <a href="<?= url_for('daemons', $daemon['did'], 'edit') ?>" class="edit_daemon"><img src="img/edit.png" alt="edit"></a>
            <a href="<?= url_for('daemons', $daemon['did']) ?>" data-method="delete"><img src="img/delete.png" alt="delete"></a>
        </div>
        <strong><?= $daemon['name'] ?></strong>
    </dt>
<?php
foreach($daemon['ports'] as $port) {
    $daemon['id'] = $daemon['did'];
    $port['id'] = $port['pid'];
?>
    <dd data-id="<?= $port['pid'] ?>">
        <?= render('ports/show.html.php', null, array('port'=>$port, 'daemon'=>$daemon)) ?>
    </dd>
<?php } ?>
</dl>

<?php } ?>

<?php content_for('controls'); ?>
<div id="controls">
    <ul>
        <li><a href="<?= url_for('daemons','new') ?>" id="createDaemon"><img src="img/create_daemon.png" alt="Neuer Daemon" title="Neuer Daemon"></a></li>
    </ul>
</div>
<?php end_content_for(); ?>

<?php content_for('scripts'); ?>
<script type="text/javascript">

$('#createDaemon, .edit_daemon, .add_port').click(function() {
   $.getScript(this.href);
   return false;
});

var currentNav = "daemons";

</script>
<?php end_content_for(); ?>