<div class="person">
    <div class="controls">
        <a href="<?= url_for('roles', $role['id'], 'people', $person['id']) ?>" data-method="delete"><img src="img/delete.png" alt="<?= _("Delete person") ?>" title="<?= _("Delete person") ?>"></a>
    </div>

    <strong><?= $person['nachname'] ?></strong> <?= $person['vorname'] ?>
</div>