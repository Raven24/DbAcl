<?php

# list all daemons
dispatch('/daemons', 'daemons_index');
function daemons_index()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    # query the database
    $arrDaemonsPorts = $db->select(
        "SELECT {$cfg['tblDaemon']}.id as did,
                {$cfg['tblPort']}.id as pid,
                {$cfg['tblDaemon']}.*,
                {$cfg['tblPort']}.*
        FROM {$cfg['tblDaemon']}
        LEFT OUTER JOIN {$cfg['tblPort']}
        ON {$cfg['tblDaemon']}.id = {$cfg['tblPort']}.daemon_id
        ORDER BY {$cfg['tblDaemon']}.name ASC, {$cfg['tblPort']}.number ASC"
    );

    $currDaemon = 0;
    $arrDaemons = array();
    foreach( $arrDaemonsPorts as $entry )
    {
        if( $currDaemon != $entry['did'] )
        {
            $currDaemon = $entry['did'];
            $arrDaemons[$currDaemon] = $entry;
            $arrDaemons[$currDaemon]['ports'] = array();
        }

        array_push( $arrDaemons[$currDaemon]['ports'], $entry);
    }

    set('daemons', $arrDaemons);

    return html('daemons/index.html.php');
}

# show for for new daemon
dispatch('/daemons/new', 'daemons_new');
function daemons_new()
{
    if( isAjaxRequest() )
        return html('daemons/new.js.php', null);
    else
        halt(HTTP_NOT_IMPLEMENTED);
}

# save new daemon
dispatch_post('/daemons', 'daemons_create');
function daemons_create()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $name = $db->escape($_POST['name']);

    $result = $db->insert(
        "INSERT INTO {$cfg['tblDaemon']}
        (name) VALUES
        ('$name')"
    );

    if( !$result )
    {
        halt(SERVER_ERROR);
        return;
    }

    redirect_to('daemons');
    
}

# edit form
dispatch('/daemons/:id/edit', 'daemons_edit');
function daemons_edit()
{
    $id = intval(params('id'));
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $arrDaemon = $db->select(
        "SELECT *
        FROM {$cfg['tblDaemon']}
        WHERE id=$id"
    );

    if( !$arrDaemon )
    {
        halt(NOT_FOUND);
        return;
    }

    set('daemon', $arrDaemon[0]);

    if( isAjaxRequest() )
        return js('daemons/edit.js.php', null);
    else
        halt(HTTP_NOT_IMPLEMENTED);
    
}

# update existing daemon
dispatch_put('/daemons', 'daemons_update');
function daemons_update()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $id = intval($_POST['id']);
    $name = $db->escape($_POST['name']);

    $result = $db->update(
        "UPDATE {$cfg['tblDaemon']}
        SET name='$name'
        WHERE id=$id
        LIMIT 1"
    );

    if( !$result )
    {
        halt(SERVER_ERROR);
        return;
    }

    redirect_to('daemons');

}

# delete a daemon
dispatch_delete('/daemons/:id', 'daemons_delete');
function daemons_delete()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $id = intval(params('id'));

    $result = $db->delete(
        "DELETE FROM {$cfg['tblDaemon']}
        WHERE id=$id
        LIMIT 1"
    );

    $resPortsForeign = $db->delete(
        "DELETE FROM {$cfg['tblPort']}
        WHERE daemon_id=$id"
    );

    $resServiceForeign = $db->delete(
        "DELETE {$cfg['tblDienst']}, {$cfg['tblZugriff']}
        FROM {$cfg['tblDienst']}
        LEFT OUTER JOIN {$cfg['tblZugriff']}
        ON {$cfg['tblDienst']}.id = {$cfg['tblZugriff']}.dienst_id
        WHERE {$cfg['tblDienst']}.daemon_id=$id"
    );

    if( $result && $resPortsForeign && $resServiceForeign)
    {
        set('daemon', array('id'=>$id));

        if( isAjaxRequest() )
            return js('daemons/delete.js.php', null);
        else
            redirect_to('daemons');
    }
    else
        halt(SERVER_ERROR);
}

?>