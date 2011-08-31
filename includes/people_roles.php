<?php

# render a view for connecting people with roles
dispatch('/people_roles', 'people_roles_index');
function people_roles_index()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $arrRoles = fetchRoles();

    # query the database for all people
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
    $arrPeople = array();
    foreach($arrClients as $entry)
    {
        if( $currPerson != $entry['pid'] )
        {
            $currPerson = $entry['pid'];
            $arrPeople[$currPerson] = $entry;
            $arrPeople[$currPerson]['clients'] = array();
        }

        if( isset($entry['cid']) )
            array_push($arrPeople[$currPerson]['clients'], $entry);
    }

    set('roles', $arrRoles);
    set('people', $arrPeople);

    return html('people_roles/index.html.php');
}

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
        halt(HTTP_NOT_IMPLEMENTED);
}

# associate a person with a role
dispatch_post('/people_roles', 'people_roles_create');
function people_roles_create()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $role_id   = intval($_POST['role_id']);
    $person_id = intval($_POST['person_id']);
    $connect   = isset($_POST['connect']) ? true : false;

    $result = $db->insert(
        "INSERT INTO {$cfg['tblPersonHasRole']}
        (person_id, rolle_id) VALUES
        ('$person_id', '$role_id')"
    );

    if( !$result )
    {
        halt(SERVER_ERROR);
        return;
    }

    if( isAjaxRequest() )
    {
        if( $connect )
        {
            $arrRoles = fetchRoles("WHERE {$cfg['tblRole']}.id = $role_id");
                       
            return js('people_roles/role.js.php', null, array('role'=>array_pop($arrRoles)));
        }
        else
        {
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
            return js('people_roles/show.js.php', null);
        }
    }
    else
    {
        halt(HTTP_NOT_IMPLEMENTED);
    }
}

# delete the link between role and person
dispatch_delete('/roles/:role_id/people/:person_id', 'people_roles_delete');
dispatch_delete('/people_roles', 'people_roles_delete');
function people_roles_delete()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $role_id = intval(params('role_id'));
    $person_id = intval(params('person_id'));
    
    $connect   = isset($_POST['connect']) ? true : false;
    if( $connect )
    {
        $role_id   = intval($_POST['role_id']);
        $person_id = intval($_POST['person_id']);
    }
    
    $result = $db->delete(
        "DELETE FROM {$cfg['tblPersonHasRole']}
        WHERE rolle_id='$role_id'
        AND person_id='$person_id'
        LIMIT 1"        
    );

    if( !$result )
    {
        halt(SERVER_ERROR);
        return;
    }

    if( isAjaxRequest() )
    {
        if( $connect )
        {
            $arrRoles = fetchRoles("WHERE {$cfg['tblRole']}.id = $role_id");

            return js('people_roles/role.js.php', null, array('role'=>array_pop($arrRoles)));
        }
        else
        {
            set('role', array('id'=>$role_id));
            set('person', array('id'=>$person_id));
            return js('people_roles/delete.js.php', null);
        }
    }
    else
    {
        halt(HTTP_NOT_IMPLEMENTED);
    }
}

/**
 * function to fetch roles and return them with their assigned people in
 * an array
 */
function fetchRoles($where='WHERE 1')
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];
    
    # query the database for all roles
    $arrRoleAssocs = $db->select(
        "SELECT {$cfg['tblRole']}.id as rid,
                {$cfg['tblPerson']}.id as pid,
                {$cfg['tblRole']}.*,
                {$cfg['tblPerson']}.*
        FROM {$cfg['tblRole']}
        LEFT OUTER JOIN {$cfg['tblPersonHasRole']}
        ON {$cfg['tblPersonHasRole']}.rolle_id = {$cfg['tblRole']}.id
        LEFT OUTER JOIN {$cfg['tblPerson']}
        ON {$cfg['tblPerson']}.id = {$cfg['tblPersonHasRole']}.person_id
        $where
        ORDER BY {$cfg['tblRole']}.name ASC, {$cfg['tblPerson']}.nachname ASC"
    );

    # create nested array with roles and their assigned people
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

        if( isset($entry['pid']) )
            array_push( $arrRoles[$currRole]['people'], $entry);
    }

    return $arrRoles;
}
?>