<div class="client">
    <div class="controls">
        [<a href="<?= url_for('clients', $client['id'], 'edit') ?>" class="edit_client">edit</a>]
        [<a href="<?= url_for('clients', $client['id']) ?>" data-method="delete">delete</a>]
    </div>
    
    <small>[<span class='type'><?= $client['type'] ?></span>]</small> <span class='desc'><?= $client['desc'] ?></span>:
    <span class='mac'><?= $client['mac'] ?></span>
</div>