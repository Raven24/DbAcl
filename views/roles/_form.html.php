<?php
$method = (isset($role)) ? 'PUT' : 'POST';
?>

<form action="<?= url_for('/roles') ?>" method="post">
    <input type="hidden" name="_method" value="<?= $method ?>">
    <input type="hidden" name="id" value="<?= $role['id'] ?>">

    <div class="field">
        <label>Name</label>
        <input type="text" name="name" value="<?= $role['name'] ?>">
    </div>

    <div class="field">
        <label>Desc</label>
        <input type="text" name="desc" value="<?= $role['desc'] ?>">
    </div>

    <div class="actions">
        <input type="submit" value="Speichern">
    </div>    

</form>