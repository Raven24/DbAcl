<?php

# show a list of clients
dispatch('/clients', 'clients_index');
function clients_index()
{
    $arrClients = fetchClients();

    set('clients', $arrClients);

    return html('clients/index.html.php');
}

# show the form for a new client
dispatch('/clients/new', 'clients_new');
function clients_new()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    set('person_id', $_GET['person_id']);

    $nesting = get_nesting();

    // fetch people for the dropdown
    $arrPeople = $db->select(
        "SELECT *
        FROM {$cfg['tblPerson']}
        ORDER BY nachname ASC"
    );
    set('people', $arrPeople);

    if( isAjaxRequest() )
    {
        return js('clients/new'.$nesting.'.js.php', null);
    }

    return html('clients/new.html.php');
}

# save a new client
dispatch_post('/clients', 'clients_create');
function clients_create()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    // sets which view to render
    $nested = get_nesting();

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

	if( !$result )
    {
        halt(SERVER_ERROR);
        return;
    }
    
    $arrClient = fetchClients("WHERE {$cfg['tblClient']}.id=$id");
    set('client', array_pop($arrClient));

    if( isAjaxRequest() )
    	return js('clients/show.js.php', null, array('nested'=>$nested));
    else
  		redirect_to('clients');
    
}

# show form to edit an existing client
dispatch('/clients/:id/edit', 'clients_edit');
function clients_edit()
{
    $id = intval(params('id'));
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    // sets which view to render
    $nested = addslashes($_GET['nested']);

    $arrPeople = $db->select(
        "SELECT *
        FROM {$cfg['tblPerson']}
        ORDER BY nachname ASC"
    );

    set('people', $arrPeople);

    $arrClient = $db->select(
        "SELECT {$cfg['tblClient']}.id as cid, {$cfg['tblClient']}.*
        FROM {$cfg['tblClient']}
        WHERE id=$id"
    );

    if( $arrClient )
    {
        set('client', $arrClient[0]);
        
        if( isAjaxRequest() )
        {
            return js('clients/edit.js.php', null, array('nested'=>$nested));
        }

        return html('clients/edit.html.php');
    }

    halt(NOT_FOUND);
}

# update an existing client
dispatch_put('/clients', 'clients_update');
function clients_update()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    // sets which view to render
    $nested = addslashes($_POST['nested']);
    if( !empty($nested) ) $nested = '.'.$nested;

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
        $arrClient = fetchClients("WHERE {$cfg['tblClient']}.id=$id");

        set('client', array_pop($arrClient));
        
        if( isAjaxRequest() )
            return js('clients/show.js.php', null, array('nested'=>$nested));
        else
            redirect_to('clients');
    }
    else
        halt(SERVER_ERROR);
}

# remove a client
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

/**
 * fetch clients and return them with the associated person
 * in an array
 */
function fetchClients($where='WHERE 1')
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    # query the database
    $arrClientsPeople = $db->select(
        "SELECT {$cfg['tblClient']}.id as cid,
                {$cfg['tblPerson']}.id as pid,
                {$cfg['tblClient']}.*,
                {$cfg['tblPerson']}.*
        FROM {$cfg['tblClient']}
        LEFT JOIN {$cfg['tblPerson']}
        ON {$cfg['tblClient']}.person_id = {$cfg['tblPerson']}.id
        $where
        ORDER BY {$cfg['tblClient']}.desc ASC, {$cfg['tblClient']}.mac ASC"
    );

    # put the person data in it's own array
    $arrClients = array();
    foreach( $arrClientsPeople as $entry )
    {
        if( isset($entry['pid']) )
        {
            $entry['person'] = $entry;
        }
        array_push($arrClients, $entry);
    }

    return $arrClients;
}

?>