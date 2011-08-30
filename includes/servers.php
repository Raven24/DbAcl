<?php

# list all servers with their daemons
dispatch('/servers', 'servers_index');
function servers_index()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    # query the database
    $arrServersDaemons = $db->select(
        "SELECT {$cfg['tblServer']}.id as sid,
                {$cfg['tblDaemon']}.id as did,
                {$cfg['tblService']}.desc as d_desc,
                {$cfg['tblServer']}.*,
                {$cfg['tblDaemon']}.*
        FROM {$cfg['tblServer']}
        LEFT OUTER JOIN {$cfg['tblService']}
        ON {$cfg['tblServer']}.id = {$cfg['tblService']}.server_id
        LEFT OUTER JOIN {$cfg['tblDaemon']}
        ON {$cfg['tblDaemon']}.id = {$cfg['tblService']}.daemon_id
        ORDER BY {$cfg['tblServer']}.fqdn ASC, {$cfg['tblDaemon']}.name ASC"
    );

    $currServer = 0;
    $arrServers = array();
    foreach( $arrServersDaemons as $entry )
    {
        if( $currServer != $entry['sid'] )
        {
            $currServer = $entry['sid'];
            $arrServers[$currServer] = $entry;
            $arrServers[$currServer]['daemons'] = array();
        }

        array_push( $arrServers[$currServer]['daemons'], $entry);
    }

    set('servers', $arrServers);

    return html('servers/index.html.php');
}

# show for for new server
dispatch('/servers/new', 'servers_new');
function servers_new()
{
    if( isAjaxRequest() )
        return html('servers/new.js.php', null);
    else
        halt(HTTP_NOT_IMPLEMENTED);
}

# save new server
dispatch_post('/servers', 'servers_create');
function servers_create()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $fqdn = $db->escape($_POST['fqdn']);
    $desc = $db->escape($_POST['desc']);
    $ip   = $db->escape($_POST['ip']);
    $mac  = $db->escape($_POST['mac']);

    $result = $db->insert(
        "INSERT INTO {$cfg['tblServer']}
        (fqdn, `desc`, ip, mac) VALUES
        ('$fqdn', '$desc', '$ip', '$mac')"
    );

    if( !$result )
    {
        halt(SERVER_ERROR);
        return;
    }

    redirect_to('servers');

}

# edit form
dispatch('/servers/:id/edit', 'servers_edit');
function servers_edit()
{
    $id = intval(params('id'));
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $arrServer = $db->select(
        "SELECT *
        FROM {$cfg['tblServer']}
        WHERE id=$id"
    );

    if( !$arrServer )
    {
        halt(NOT_FOUND);
        return;
    }

    set('server', $arrServer[0]);

    if( isAjaxRequest() )
        return js('servers/edit.js.php', null);
    else
        halt(HTTP_NOT_IMPLEMENTED);

}

# update existing daemon
dispatch_put('/servers', 'servers_update');
function servers_update()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $id   = intval($_POST['id']);
    $fqdn = $db->escape($_POST['fqdn']);
    $desc = $db->escape($_POST['desc']);
    $ip   = $db->escape($_POST['ip']);
    $mac  = $db->escape($_POST['mac']);

    $result = $db->update(
        "UPDATE {$cfg['tblServer']}
        SET fqdn='$fqdn', `desc`='$desc', ip='$ip', mac='$mac'
        WHERE id=$id
        LIMIT 1"
    );

    if( !$result )
    {
        halt(SERVER_ERROR);
        return;
    }

    redirect_to('servers');

}

# delete a server
dispatch_delete('/servers/:id', 'servers_delete');
function servers_delete()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $id = intval(params('id'));

    $result = $db->delete(
        "DELETE FROM {$cfg['tblServer']}
        WHERE id=$id
        LIMIT 1"
    );

    $resForeign = $db->delete(
        "DELETE {$cfg['tblService']}, {$cfg['tblZugriff']}
        FROM {$cfg['tblService']}
        LEFT OUTER JOIN {$cfg['tblZugriff']}
        ON {$cfg['tblService']}.id = {$cfg['tblZugriff']}.dienst_id
        WHERE {$cfg['tblService']}.server_id=$id"
    );

    if( $result && $resForeign )
    {
        set('server', array('id'=>$id));

        if( isAjaxRequest() )
            return js('servers/delete.js.php', null);
        else
            redirect_to('servers');
    }
    else
        halt(SERVER_ERROR);
}

?>