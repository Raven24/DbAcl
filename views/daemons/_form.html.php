<?php
$method = (isset($daemon)) ? 'PUT' : 'POST';
?>
<form action="<?= url_for('/daemons') ?>" method="post">
    <input type="hidden" name="_method" value="<?= $method ?>">
    <input type="hidden" name="id" value="<?= $daemon['id'] ?>">

    <div class="field">
        <label><?= _("name") ?></label>
        <input type="text" name="name" value="<?= $daemon['name'] ?>">
    </div>

    <div class="actions">
        <input type="submit" value="<?= _("save") ?>">
    </div>
</form>