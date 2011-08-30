<?php

# people index
dispatch('/people', 'people_index');
function people_index()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];
    
    # query the database
    $arrClients = $db->select(
        "SELECT {$cfg['tblPerson']}.id as pid,
                {$cfg['tblClient']}.id as cid,
                {$cfg['tblPerson']}.*,
                {$cfg['tblClient']}.*

        FROM {$cfg['tblPerson']}
        LEFT JOIN {$cfg['tblClient']}
        ON {$cfg['tblClient']}.person_id = {$cfg['tblPerson']}.id
        ORDER BY {$cfg['tblPerson']}.nachname ASC"
    );

    # create a nested array of people with their clients
    $currPerson = 0;
    $arrPersonen = array();
    foreach($arrClients as $entry)
    {
        if( $currPerson != $entry['pid'] )
        {
            $currPerson = $entry['pid'];
            $arrPersonen[$currPerson] = $entry;
            $arrPersonen[$currPerson]['clients'] = array();
        }

        array_push($arrPersonen[$currPerson]['clients'], $entry);
    }

    set('people', $arrPersonen);

    return html('people/index.html.php');
}

# show form for new person
dispatch('/people/new', 'people_new');
function people_new()
{
    if( isAjaxRequest() )
    {
        return html('people/new.js.php', null);
    }
    
    return html('people/new.html.php');
}

# do stuff with newly created person
dispatch_post('/people', 'people_create');
function people_create()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $vorname = $db->escape($_POST['vorname']);
    $nachname = $db->escape($_POST['nachname']);

    $result = $db->insert(
        "INSERT INTO {$cfg['tblPerson']}
        (vorname, nachname) VALUES
        ('$vorname', '$nachname')"
    );

    if( $result )
        redirect_to('people');
    else
        halt(SERVER_ERROR);
}

# edit form
dispatch('/people/:id/edit', 'people_edit');
function people_edit()
{
    $id = intval(params('id'));
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];
    
    $arrPerson = $db->select(
        "SELECT *
        FROM {$cfg['tblPerson']}
        WHERE id=$id"
    );
    
    if( $arrPerson )
    {
        set('person', $arrPerson[0]);
        
        if( isAjaxRequest() )
        {
            return html('people/edit.js.php', null);
        }
        
        return html('people/edit.html.php');
    }

    halt(NOT_FOUND);
}

# update existing person
dispatch_put('/people', 'people_update');
function people_update()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $id = intval($_POST['id']);
    $vorname = $db->escape($_POST['vorname']);
    $nachname = $db->escape($_POST['nachname']);

    $result = $db->update(
        "UPDATE {$cfg['tblPerson']}
        SET vorname='$vorname', nachname='$nachname'
        WHERE id=$id
        LIMIT 1"
    );

    if( $result )
        redirect_to('people');
    else
        halt(SERVER_ERROR);
    
}

# remove a person
dispatch_delete('/people/:id', 'people_delete');
function people_delete()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $id = intval(params('id'));

    $result = $db->delete(
        "DELETE FROM {$cfg['tblPerson']}
        WHERE id=$id
        LIMIT 1"
    );

    $resClientForeign = $db->delete(
        "DELETE FROM {$cfg['tblClient']}
        WHERE person_id=$id"
    );

    $resHasRolleForeign = $db->delete(
        "DELETE FROM {$cfg['tblPersonHasRole']}
        WHERE person_id=$id"
    );

    if( $result && $resClientForeign && $resHasRolleForeign )
    {
        set('person', array('id'=>$id));
    
        if( isAjaxRequest() )
            return js('people/delete.js.php', null);
        else
            redirect_to('people');
    }
    else
        halt(SERVER_ERROR);
}

?>