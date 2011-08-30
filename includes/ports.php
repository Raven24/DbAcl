<?php

# show form for new port
dispatch('/ports/new', 'ports_new');
function ports_new()
{
    set('daemon_id', $_GET['daemon_id']);

    if( isAjaxRequest() )
    {
        return js('ports/new.js.php', null);
    }

    halt(HTTP_NOT_IMPLEMENTED);
}

# save new port
dispatch_post('/ports', 'ports_create');
function ports_create()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $number    = intval($_POST['number']);
    $proto     = $db->escape($_POST['proto']);
    $daemon_id = intval($_POST['daemon_id']);

    $result = $db->insert(
        "INSERT INTO {$cfg['tblPort']}
        (number, proto, daemon_id) VALUES
        ('$number', '$proto', '$daemon_id')"
    );

    $id = $db->insertId();

    if( !$result )
    {
        halt(SERVER_ERROR);
        return;
    }

    set('port', array(
        'id'        =>$id,
        'number'    =>$number,
        'proto'     =>$proto,
        'daemon_id' =>$daemon_id
    ));

    if( isAjaxRequest() )
        return js('ports/show.js.php', null);
    else
        halt(HTTP_NOT_IMPLEMENTED);
   
}

# delete a port
dispatch_delete('/ports/:id', 'ports_delete');
function ports_delete()
{
    $id = intval(params('id'));
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $result = $db->delete(
        "DELETE FROM {$cfg['tblPort']}
        WHERE id=$id
        LIMIT 1"
    );

    if( !$result )
    {
        halt(SERVER_ERROR);
        return;
    }

    set('port', array('id'=>$id));

    if( isAjaxRequest() )
        return js('ports/delete.js.php', null);
    else
        halt(HTTP_NOT_IMPLEMENTED);
}

?>