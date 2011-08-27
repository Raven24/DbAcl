<form action="<?= url_for('/people_roles')?>" method="post" data-remote="true" id="people_role_form">
    <input type="hidden" name="_method" value="POST">
    <input type="hidden" name="role_id" value="<?= $role['id']?>">

    <div class="field">
        <label>Person</label>
        <select name="person_id">
<?php foreach($people as $person) { ?>
            <option value="<?= $person['id']?>"><?= $person['nachname'] ?> <?= $person['vorname'] ?></option>
<?php } ?>
        </select>
    </div>

    <div class="actions">
        <input type="submit" value="Speichern">
    </div>
</form>