<div class="daemon">
    <div class="controls">
        [<a href="<?= url_for('servers', $server['id'], 'daemons', $daemon['id']) ?>" data-method="delete">delete</a>]
    </div>

    <strong><small>[<?= $daemon['name'] ?>]</small></strong> <?= $daemon['d_desc'] ?>
</div>