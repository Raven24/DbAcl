<?php

dispatch('/clients/new', 'clients_new');
function clients_new()
{
    set('person_id', $_GET['person_id']);

    if( isAjaxRequest() )
    {
        return js('clients/new.js.php', null);
    }

    return html('clients/new.html.php');
}

dispatch_post('/clients', 'clients_create');
function clients_create()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $type      = $db->escape($_POST['type']);
    $mac       = $db->escape($_POST['mac']);
    $desc      = $db->escape($_POST['desc']);
    $person_id = intval($_POST['person_id']);
    
    $result = $db->insert(
        "INSERT INTO {$cfg['tblClient']}
        (type, mac, `desc`, person_id) VALUES
        ('$type', '$mac', '$desc', '$person_id')"
    );

    $id = $db->insertId();

    if( $result )
    {
        set('client', array(
            'id'       =>$id,
            'type'     =>$type,
            'mac'      =>$mac,
            'desc'     =>$desc,
            'person_id'=>$person_id
        ));
        
        if( isAjaxRequest() )
            return js('clients/show.js.php', null);
        else
            redirect_to('clients');
    }
    else
    {
        halt(SERVER_ERROR);
    }
}

dispatch('/clients/:id/edit', 'clients_edit');
function clients_edit()
{
    $id = intval(params('id'));
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $arrClient = $db->select(
        "SELECT *
        FROM {$cfg['tblClient']}
        WHERE id=$id"
    );

    if( $arrClient )
    {
        set('client', $arrClient[0]);
        
        if( isAjaxRequest() )
        {
            return js('clients/edit.js.php', null);
        }

        return html('clients/edit.html.php');
    }

    halt(NOT_FOUND);
}

dispatch_put('/clients', 'clients_update');
function clients_update()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $id        = intval($_POST['id']);
    $person_id = intval($_POST['person_id']);
    $type      = $db->escape($_POST['type']);
    $mac       = $db->escape($_POST['mac']);
    $desc      = $db->escape($_POST['desc']);

    $result = $db->update(
        "UPDATE {$cfg['tblClient']}
        SET person_id='$person_id', type='$type', mac='$mac', `desc`='$desc'
        WHERE id=$id
        LIMIT 1"
    );

    if( $result )
    {
        set('client', array(
            'id'       =>$id,
            'type'     =>$type,
            'mac'      =>$mac,
            'desc'     =>$desc,
            'person_id'=>$person_id
        ));
        
        if( isAjaxRequest() )
            return js('clients/show.js.php', null);
        else
            redirect_to('clients');
    }
    else
        halt(SERVER_ERROR);
}

dispatch_delete('/clients/:id', 'clients_delete');
function clients_delete()
{
    $id = intval(params('id'));
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $result = $db->delete(
        "DELETE FROM {$cfg['tblClient']}
        WHERE id=$id
        LIMIT 1"
    );

    if( $result )
    {
        set('client', array('id'=>$id));
        
        if( isAjaxRequest() )
            return js('clients/delete.js.php', null);
        else
            redirect_to('clients');
    }
    else
        halt(SERVER_ERROR);
}

?>