<div class="service">
    <div class="controls">
        <a href="<?= url_for('roles', $role['id'], 'service', $service['dienst_id']) ?>" data-method="delete"><img src="img/delete.png" alt="<?= _("Delete service") ?>" title="<?= _("Delete service") ?>"></a>
    </div>

    <?= $service['daemon_name'] ?> <?= _("on") ?> <?= $service['fqdn'] ?> <small>(<?= $service['dienst_desc'] ?>)</small>
</div>
