<?php

# show form for connecting people with roles
dispatch('/roles/:id/people/new', 'people_roles_new');
function people_roles_new()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];
    
    $role_id = intval(params('id'));
    set('role', array('id'=> $role_id));

    $arrPeople = $db->select(
        "SELECT *
        FROM {$cfg['tblPerson']}
        ORDER BY nachname ASC"
    );

    set('people', $arrPeople);

    if( isAjaxRequest() )
        return js('people_roles/new.js.php', null);
    else
        halt(NOT_IMPLEMENTED);
}

# associate a person with a role
dispatch_post('/people_roles', 'people_roles_create');
function people_roles_create()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $role_id = intval($_POST['role_id']);
    $person_id = intval($_POST['person_id']);

    $result = $db->insert(
        "INSERT INTO {$cfg['tblPersonHasRolle']}
        (person_id, rolle_id) VALUES
        ('$person_id', '$role_id')"
    );

    if( !$result )
    {
        halt(SERVER_ERROR);
        return;
    }

    $arrPerson = $db->select(
        "SELECT *
        FROM {$cfg['tblPerson']}
        WHERE id=$person_id"
    );

    if( !$arrPerson )
    {
        halt(SERVER_ERROR);
        return;
    }

    set('person', $arrPerson[0]);
    set('role', array('id'=>$role_id));

    if( isAjaxRequest() )
        return js('people_roles/show.js.php', null);
    else
        halt(NOT_IMPLEMENTED);
}

# delete the link between role and person
dispatch_delete('/roles/:role_id/people/:person_id', 'people_roles_delete');
function people_roles_delete()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $role_id = intval(params('role_id'));
    $person_id = intval(params('person_id'));

    $result = $db->delete(
        "DELETE FROM {$cfg['tblPersonHasRolle']}
        WHERE rolle_id='$role_id'
        AND person_id='$person_id'
        LIMIT 1"        
    );

    if( !$result )
    {
        halt(SERVER_ERROR);
        return;
    }

    set('role', array('id'=>$role_id));
    set('person', array('id'=>$person_id));

    if( isAjaxRequest() )
        return js('people_roles/delete.js.php', null);
    else
        halt(NOT_IMPLEMENTED);
}

?>