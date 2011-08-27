<div class="person">
    <div class="controls">
        [<a href="<?= url_for('roles', $role['id'], 'people', $person['id']) ?>" data-method="delete">delete</a>]
    </div>

    <strong><?= $person['nachname'] ?></strong> <?= $person['vorname'] ?>
</div>