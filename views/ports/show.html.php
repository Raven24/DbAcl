<dl class="listitem port" data-id="<?= $port['pid'] ?>">
    <dt>
	    <div class="controls">
	        <a href="<?= url_for('ports', $port['pid']) ?>" data-method="delete"><img src="img/delete.png" alt="<?= _("Delete port") ?>" title="<?= _("Delete port") ?>"></a>
	    </div>
	    <small>[<?= $port['proto'] ?> <?= _("port") ?>]</small> <strong><?= $port['number'] ?></strong>
	</dt>
	<dd>
        <?= _("belongs to") ?> <strong><?= $port['daemon']['name'] ?></strong>
    </dd>
</dl>