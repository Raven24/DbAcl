<form action="<?= url_for('/ports')?>" method="post" data-remote="true" id="port_form">
    <input type="hidden" name="id" value="<?= $port['id'] ?>">
    <input type="hidden" name="daemon_id" value="<?= $daemon_id ?>">

    <div class="field">
        <label><?= _("number") ?></label>
        <input type="text" name="number" value="<?= $port['number'] ?>">
    </div>

    <div class="field">
        <label><?= _("protocol") ?></label>
        <select name="proto">
            <option value="tcp" <?= ($port['proto']=='tcp') ? 'selected="selected"' : '' ?>>tcp</option>
            <option value="udp" <?= ($port['proto']=='udp') ? 'selected="selected"' : '' ?>>udp</option>
        </select>
    </div>

    <div class="actions">
        <input type="submit" value="<?= _("save") ?>">
    </div>

</form>