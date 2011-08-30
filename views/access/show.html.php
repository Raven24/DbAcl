<div class="service">
    <div class="controls">
        [<a href="<?= url_for('roles', $role['id'], 'service', $service['dienst_id']) ?>" data-method="delete">delete</a>]
    </div>

    <?= $service['daemon_name'] ?> auf <?= $service['fqdn'] ?> <small>(<?= $service['dienst_desc'] ?>)</small>
</div>
