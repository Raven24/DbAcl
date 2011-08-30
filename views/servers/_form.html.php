<?php
$method = (isset($server)) ? 'PUT' : 'POST';
?>
<form action="<?= url_for('/servers') ?>" method="post">
    <input type="hidden" name="_method" value="<?= $method ?>">
    <input type="hidden" name="id" value="<?= $server['id'] ?>">

    <div class="field">
        <label>FQDN</label>
        <input type="text" name="fqdn" value="<?= $server['fqdn'] ?>">
    </div>

    <div class="field">
        <label>Desc</label>
        <input type="text" name="desc" value="<?= $server['desc'] ?>">
    </div>

    <div class="field">
        <label>IP</label>
        <input type="text" name="ip" value="<?= $server['ip'] ?>">
    </div>
    
    <div class="field">
        <label>Mac</label>
        <input type="text" name="mac" value="<?= $server['mac'] ?>">
    </div>

    <div class="actions">
        <input type="submit" value="Speichern">
    </div>
</form>