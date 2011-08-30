<form action="<?= url_for('/daemons_servers')?>" method="post" data-remote="true" id="daemons_servers_form">
    <input type="hidden" name="_method" value="POST">
    <input type="hidden" name="server_id" value="<?= $server['id']?>">

    <div class="field">
        <label>Daemon</label>
        <select name="daemon_id">
<?php foreach($daemons as $daemon) { ?>
            <option value="<?= $daemon['id']?>"><?= $daemon['name'] ?></option>
<?php } ?>
        </select>
    </div>

    <div class="field">
        <label>Desc</label>
        <input type="text" name="desc" value="">
    </div>

    <div class="actions">
        <input type="submit" value="Speichern">
    </div>
</form>