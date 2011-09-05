<dd data-id="<?= $client['cid'] ?>">
    <div class="client">
        <div class="controls">
            <a href="<?= url_for('clients', $client['cid'], 'edit', array('nested'=>'person')) ?>" class="edit_client"><img src="img/edit.png" alt="edit"></a>
            <a href="<?= url_for('clients', $client['cid']) ?>" data-method="delete"><img src="img/delete.png" alt="delete"></a>
        </div>

        <small>[<span class='type'><?= $client['type'] ?></span>]</small> <span class='desc'><?= $client['desc'] ?></span>:
        <span class='mac'><?= $client['mac'] ?></span>
    </div>
</dd>