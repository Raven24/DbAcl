<div class="daemon">
    <div class="controls">
        <a href="<?= url_for('servers', $server['id'], 'daemons', $daemon['id']) ?>" data-method="delete"><img src="img/delete.png" alt="<?= _("Delete daemon") ?>" title="<?= _("Delete daemon") ?>"></a>
    </div>

    <strong><small>[<?= $daemon['name'] ?>]</small></strong> <?= $daemon['d_desc'] ?>
</div>