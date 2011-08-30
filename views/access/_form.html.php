<form action="<?= url_for('/access')?>" method="post" data-remote="true" id="access_form">
    <input type="hidden" name="_method" value="POST">
    <input type="hidden" name="role_id" value="<?= $role['id']?>">

    <div class="field">
        <label>Dienst</label>
        <select name="service_id">
<?php foreach($services as $service) { ?>
            <option value="<?= $service['dienst_id']?>"><?= $service['daemon_name'] ?> auf <?= $service['fqdn'] ?> (<?= $service['dienst_desc'] ?>)</option>
<?php } ?>
        </select>
    </div>

    <div class="actions">
        <input type="submit" value="Speichern">
    </div>
</form>