<div class="port">
    <div class="controls">
        [<a href="<?= url_for('ports', $port['id']) ?>" data-method="delete">delete</a>]
    </div>

    <strong><?= $port['number'] ?></strong> <?= $port['proto'] ?>
</div>