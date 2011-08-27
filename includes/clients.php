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
    if( isAjaxRequest() )
    {
        return js(print_r($_POST, true));
    }

    return print_r($_POST, true);
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

dispatch_delete('/clients/:id', 'clients_delete');
function clients_delete()
{
    
}

?>