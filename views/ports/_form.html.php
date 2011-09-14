<?php
$method = (isset($client))  ? 'PUT'   : 'POST';
$remote = (!isset($remote)) ? 'true'  : $remote;

/**
 * If the form is not displayed as nested element, show a selector for daemons,
 * otherwise just put the daemon_id in a hidden field. That means you can change
 * the associated daemon only if you are in the 'ports' view, not from the 
 * 'daemons' view.
 * 
 * The 'nested' variable determines which partial to render after the form was
 * sent. If it's empty, the default 'show' view will be rendered.
 */

$daemon_id = (isset($daemon_id)) ? $daemon_id : $port['daemon_id'];
if( $daemon_id == 0 ) $daemon_id = "";
?>
<form action="<?= url_for('/ports')?>" method="post" data-remote="<?= $remote ?>" id="port_form">
    <input type="hidden" name="_method" value="<?= $method ?>">    
    <input type="hidden" name="nested" value="<?= $nested ?>">
    <input type="hidden" name="id" value="<?= $port['id'] ?>">
<?php if( !empty($nested) ) { ?>
    <input type="hidden" name="daemon_id" value="<?= $daemon_id ?>">
<?php } ?>

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
    
<?php if( empty($nested) ) { ?>
    <div class="field">
        <label><?= _("daemon") ?></label>
        <select name="daemon_id">
<?php
foreach($daemons as $daemon) {
    $selected = ($daemon_id == $daemon['id']) ? 'selected="selected"' : '';
?>
            <option value="<?= $daemon['id']?>" <?= $selected ?>><?= $daemon['name'] ?></option>
<?php } ?>
        </select>
    </div>
<?php } ?>    

    <div class="actions">
        <input type="submit" value="<?= _("save") ?>">
    </div>

</form>