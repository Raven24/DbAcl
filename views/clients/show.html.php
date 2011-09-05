<dl class="listitem client" data-id="<?= $client['cid'] ?>">
    <dt>
        <div class="controls">
            <a href="<?= url_for('clients', $client['cid'], 'edit') ?>" class="edit_client"><img src="img/edit.png" alt="<?= _("Edit client") ?>" title="<?= _("Edit client") ?>"></a>
            <a href="<?= url_for('clients', $client['cid']) ?>" data-method="delete"><img src="img/delete.png" alt="<?= _("Delete client") ?>" title="<?= _("Delete client") ?>"></a>
        </div>
        <small>[<?= $client['type'] ?>]</small> <?= $client['desc'] ?>: <?= $client['mac'] ?>
    </dt>
    <dd>
        <?= _("belongs to") ?> <strong><?= $client['person']['nachname'] ?></strong> <?= $client['person']['vorname'] ?>
    </dd>
</dl>