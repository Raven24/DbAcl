<?php

# roles index
dispatch('/roles', 'roles_index');
function roles_index()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    # query the database
    $arrRoleAssocs = $db->select(
        "SELECT {$cfg['tblRolle']}.id as rid,
                {$cfg['tblPerson']}.id as pid,
                {$cfg['tblRolle']}.*,
                {$cfg['tblPerson']}.*
        FROM {$cfg['tblRolle']}
        LEFT OUTER JOIN {$cfg['tblPersonHasRolle']}
        ON {$cfg['tblPersonHasRolle']}.rolle_id = {$cfg['tblRolle']}.id
        LEFT OUTER JOIN {$cfg['tblPerson']}
        ON {$cfg['tblPerson']}.id = {$cfg['tblPersonHasRolle']}.person_id
        ORDER BY {$cfg['tblRolle']}.name ASC, {$cfg['tblPerson']}.nachname ASC"
    );

    $currRole = 0;
    $arrRoles = array();
    foreach($arrRoleAssocs as $entry)
    {
        if( $currRole != $entry['rid'] )
        {            
            $currRole = $entry['rid'];
            $arrRoles[$currRole] = $entry;
            $arrRoles[$currRole]['people'] = array();
        }

        array_push( $arrRoles[$currRole]['people'], $entry);
    }

    set('roles', $arrRoles);

    return html('roles/index.html.php');
}

# show form to create a role
dispatch('/roles/new', 'roles_new');
function roles_new()
{
    if( isAjaxRequest() )
    {
        return js('roles/new.js.php', null);
    }
    else
    {
        //html('roles/new.html.php');
        halt(HTTP_NOT_IMPLEMENTED);
    }
}

# save a newly created role
dispatch_post('/roles', 'roles_create');
function roles_create()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $name = $db->escape($_POST['name']);
    $desc = $db->escape($_POST['desc']);

    $result = $db->insert(
        "INSERT INTO {$cfg['tblRolle']}
        (name, `desc`) VALUES
        ('$name', '$desc')"
    );

    if( $result )
        redirect_to('roles');
    else
        halt(SERVER_ERROR);
}

# form to edit an existing role
dispatch('/roles/:id/edit', 'roles_edit');
function roles_edit()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $id = intval(params('id'));

    $arrRole = $db->select(
        "SELECT *
        FROM {$cfg['tblRolle']}
        WHERE id=$id"
    );

    if( $arrRole )
    {
        set('role', $arrRole[0]);

        if(isAjaxRequest())
            return js('roles/edit.js.php', null);
        else
            return html('roles/edit.html.php', null);
    }
    else
        halt(NOT_FOUND);
    
}

# update an existing role
dispatch_put('/roles', 'roles_update');
function roles_update()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $id = intval($_POST['id']);
    $name = $db->escape($_POST['name']);
    $desc = $db->escape($_POST['desc']);

    $result = $db->update(
        "UPDATE {$cfg['tblRolle']}
        SET name='$name', `desc`='$desc'
        WHERE id=$id
        LIMIT 1"
    );

    if( $result )
        redirect_to('roles');
    else
        halt(SERVER_ERROR);
}

#remove a role
dispatch_delete('/roles/:id', 'roles_delete');
function roles_delete()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $id = intval(params('id'));

    $result = $db->delete(
        "DELETE FROM {$cfg['tblRolle']}
        WHERE id=$id
        LIMIT 1"
    );

    if( $result )
    {
        set('role', array('id'=>$id));

        if( isAjaxRequest() )
            return js('roles/delete.js.php', null);
        else
            redirect_to('roles');
    }
    else
        halt(SERVER_ERROR);
}

?>