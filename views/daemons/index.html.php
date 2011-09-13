<h1><?= _("Listing daemons") ?></h1>

<?php foreach( $daemons as $daemon ) { ?>

<dl class="listitem daemon" data-id="<?= $daemon['did'] ?>">
    <dt>
        <div class="controls">
            <a href="<?= url_for('ports', 'new', array('daemon_id'=>$daemon['did'], 'nested'=>'daemon')) ?>" class="add_port"><img src="img/add.png" alt="<?= _("New port") ?>" title="<?= _("New port") ?>"></a>
            <a href="<?= url_for('daemons', $daemon['did'], 'edit') ?>" class="edit_daemon"><img src="img/edit.png" alt="<?= _("Edit daemon") ?>" title="<?= _("Edit daemon") ?>"></a>
            <a href="<?= url_for('daemons', $daemon['did']) ?>" data-method="delete"><img src="img/delete.png" alt="<?= _("Delete daemon") ?>" title="<?= _("Delete daemon") ?>"></a>
        </div>
        <strong><?= $daemon['name'] ?></strong> <small>(<?= sprintf(ngettext('%d port', '%d ports', count($daemon['ports'])), count($daemon['ports'])) ?>)</small>
    </dt>
<?php
foreach($daemon['ports'] as $port) {
    $daemon['id'] = $daemon['did'];
    $port['id'] = $port['pid'];
?>
    <dd data-id="<?= $port['pid'] ?>">
        <?= render('ports/show.daemon.html.php', null, array('port'=>$port, 'daemon'=>$daemon)) ?>
    </dd>
<?php } ?>
</dl>

<?php } ?>

<?php content_for('controls'); ?>
<div id="controls">
    <ul>
        <li><a href="<?= url_for('daemons','new') ?>" id="createDaemon"><img src="img/create_daemon.png" alt="<?= _("Create daemon") ?>" title="<?= _("Create daemon") ?>"></a></li>
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