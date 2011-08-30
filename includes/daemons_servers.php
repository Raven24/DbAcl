<?php

# show form for connecting servers with daemons
dispatch('/servers/:server_id/daemons/new', 'daemons_servers_new');
function daemons_servers_new()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $server_id = intval(params('server_id'));
    set('server', array('id'=> $server_id));

    $arrDaemons = $db->select(
        "SELECT *
        FROM {$cfg['tblDaemon']}
        ORDER BY name ASC"
    );

    set('daemons', $arrDaemons);

    if( isAjaxRequest() )
        return js('daemons_servers/new.js.php', null);
    else
        halt(HTTP_NOT_IMPLEMENTED);
}

# associate a person with a role
dispatch_post('/daemons_servers', 'daemons_servers_create');
function daemons_servers_create()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $server_id = intval($_POST['server_id']);
    $daemon_id = intval($_POST['daemon_id']);
    $desc      = $db->escape($_POST['desc']);

    $result = $db->insert(
        "INSERT INTO {$cfg['tblDienst']}
        (server_id, daemon_id, `desc`) VALUES
        ('$server_id', '$daemon_id', '$desc')"
    );

    if( !$result )
    {
        halt(SERVER_ERROR);
        return;
    }

    $arrDaemon = $db->select(
        "SELECT *
        FROM {$cfg['tblDaemon']}
        WHERE id=$daemon_id"
    );

    if( !$arrDaemon )
    {
        halt(SERVER_ERROR);
        return;
    }

    $arrDaemon[0]['d_desc'] = $desc;
    set('daemon', $arrDaemon[0]);
    set('server', array('id'=>$server_id));

    if( isAjaxRequest() )
        return js('daemons_servers/show.js.php', null);
    else
        halt(HTTP_NOT_IMPLEMENTED);
}

# delete the link between daemon and server
dispatch_delete('/servers/:server_id/daemons/:daemon_id', 'daemons_servers_delete');
function daemons_servers_delete()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $server_id = intval(params('server_id'));
    $daemon_id = intval(params('daemon_id'));

    $arrService = $db->select(
        "SELECT id
        FROM {$cfg['tblDienst']}
        WHERE server_id='$server_id'
        AND daemon_id='$daemon_id'"
    );

    if( !$arrService )
    {
        halt(SERVER_ERROR);
        return;
    }

    $id = $arrService[0]['id'];

    $result = $db->delete(
        "DELETE FROM {$cfg['tblDienst']}
        WHERE id='$id'
        LIMIT 1"
    );

    $resultForeign = $db->delete(
        "DELETE FROM {$cfg['tblZugriff']}
        WHERE dienst_id='$id'"
    );

    if( !$result || !$resultForeign )
    {
        halt(SERVER_ERROR);
        return;
    }

    set('server', array('id'=>$server_id));
    set('daemon', array('id'=>$daemon_id));

    if( isAjaxRequest() )
        return js('daemons_servers/delete.js.php', null);
    else
        halt(HTTP_NOT_IMPLEMENTED);
}

?>