<?php
$method = (isset($client)) ? 'PUT' : 'POST';
?>
<form action="<?= url_for('/clients')?>" method="post" data-remote="true" id="client_form">
    <input type="hidden" name="_method" value="<?= $method ?>">
    <input type="hidden" name="id" value="<?= $client['id'] ?>">
    <input type="hidden" name="person_id" value="<?= (!empty($person_id)) ? $person_id : $client['person_id']  ?>">

    <div class="field">
        <label>Typ</label>
        <select name="type">
            <option value="desktop" <?= ($client['type']=='desktop') ? 'selected="selected"' : '' ?>>desktop</option>
            <option value="laptop"  <?= ($client['type']=='laptop')  ? 'selected="selected"' : '' ?>>laptop</option>
        </select>
    </div>

    <div class="field">
        <label>Desc</label>
        <input type="text" name="desc" value="<?= $client['desc'] ?>">
    </div>

    <div class="field">
        <label>Mac</label>
        <input type="text" name="mac" value="<?= $client['mac'] ?>">
    </div>

    <div class="actions">
        <input type="submit" value="Speichern">
    </div>

</form>