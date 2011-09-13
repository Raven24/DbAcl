<?php
$method = (isset($client))  ? 'PUT'   : 'POST';
$remote = (!isset($remote)) ? 'true'  : $remote;

/**
 * If the form is not displayed as nested element, show a selector for people,
 * otherwise just put the person_id in a hidden field. That means you can change
 * the associated person only if you are in the 'clients' view, not from the 
 * 'people' view.
 * 
 * The 'nested' variable determines which partial to render after the form was
 * sent. If it's empty, the default 'show' view will be rendered.
 */
 
$person_id = (isset($person_id)) ? $person_id : $client['person_id'];
if( $person_id == 0 ) $person_id = "";
?>
<form action="<?= url_for('/clients')?>" method="post" data-remote="<?= $remote ?>" id="client_form">
    <input type="hidden" name="_method" value="<?= $method ?>">
    <input type="hidden" name="nested" value="<?= $nested ?>">
    <input type="hidden" name="id" value="<?= $client['id'] ?>">
<?php if( !empty($nested) ) { ?>
    <input type="hidden" name="person_id" value="<?= $person_id  ?>">
<?php } ?>

    <div class="field">
        <label><?= _("type") ?></label>
        <select name="type">
            <option value="desktop" <?= ($client['type']=='desktop') ? 'selected="selected"' : '' ?>>desktop</option>
            <option value="laptop"  <?= ($client['type']=='laptop')  ? 'selected="selected"' : '' ?>>laptop</option>
        </select>
    </div>

    <div class="field">
        <label><?= _("description") ?></label>
        <input type="text" name="desc" value="<?= $client['desc'] ?>">
    </div>

    <div class="field">
        <label><?= _("MAC address") ?></label>
        <input type="text" name="mac" value="<?= $client['mac'] ?>">
    </div>

<?php if( empty($nested) ) { ?>
    <div class="field">
        <label><?= _("person") ?></label>
        <select name="person_id">
<?php
foreach($people as $person) {
    $selected = ($person_id == $person['id']) ? 'selected="selected"' : '';
?>
            <option value="<?= $person['id']?>" <?= $selected ?>><?= $person['nachname'] ?> <?= $person['vorname'] ?></option>
<?php } ?>
        </select>
    </div>
<?php } ?>

    <div class="actions">
        <input type="submit" value="<? _("save") ?>">
    </div>

</form>