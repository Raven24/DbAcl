<?php
$method = (isset($person)) ? 'PUT' : 'POST';
?>
<form action="<?= url_for('/people')?>" method="post">
    <input type="hidden" name="_method" value="<?= $method ?>">
    <input type="hidden" name="id" value="<?= $person['id'] ?>">

    <div class="field">
        <label>Vorname</label>
        <input type="text" name="vorname" value="<?= $person['vorname'] ?>">
    </div>

    <div class="field">
        <label>Nachname</label>
        <input type="text" name="nachname" value="<?= $person['nachname'] ?>">
    </div>

    <div class="actions">
        <input type="submit" value="Speichern">
    </div>

</form>