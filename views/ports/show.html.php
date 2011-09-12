<div class="port">
    <div class="controls">
        <a href="<?= url_for('ports', $port['id']) ?>" data-method="delete"><img src="img/delete.png" alt="<?= _("Delete port") ?>" title="<?= _("Delete port") ?>"></a>
    </div>

    <strong><?= $port['number'] ?></strong> <?= $port['proto'] ?>
</div>