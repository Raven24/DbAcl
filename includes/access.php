<?php

# show the list of roles and their associated services
dispatch('/access', 'access_index');
function access_index()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    # query the database
    $arrRoleAssocs = $db->select(
        "SELECT {$cfg['tblRole']}.id as rolle_id,
                {$cfg['tblService']}.id as dienst_id,
                {$cfg['tblServer']}.id as server_id,
                {$cfg['tblDaemon']}.id as daemon_id,
                {$cfg['tblRole']}.name as rolle_name,
                {$cfg['tblRole']}.`desc` as rolle_desc,
                {$cfg['tblServer']}.`desc` as server_desc,
                {$cfg['tblService']}.`desc` as dienst_desc,
                {$cfg['tblDaemon']}.name as daemon_name,
                {$cfg['tblRole']}.*,
                {$cfg['tblServer']}.*,
                {$cfg['tblDaemon']}.*
        FROM {$cfg['tblRole']}
        LEFT OUTER JOIN {$cfg['tblZugriff']}
        ON {$cfg['tblZugriff']}.rolle_id = {$cfg['tblRole']}.id
        LEFT OUTER JOIN {$cfg['tblService']}
        ON {$cfg['tblService']}.id = {$cfg['tblZugriff']}.dienst_id
        LEFT OUTER JOIN {$cfg['tblServer']}
        ON {$cfg['tblServer']}.id = {$cfg['tblService']}.server_id
        LEFT OUTER JOIN {$cfg['tblDaemon']}
        ON {$cfg['tblDaemon']}.id = {$cfg['tblService']}.daemon_id
        ORDER BY {$cfg['tblRole']}.name ASC, {$cfg['tblDaemon']}.name ASC"
    );

    $currRole = 0;
    $arrRoles = array();
    foreach($arrRoleAssocs as $entry)
    {
        if( $currRole != $entry['rolle_id'] )
        {
            $currRole = $entry['rolle_id'];
            $arrRoles[$currRole] = $entry;
            $arrRoles[$currRole]['services'] = array();
        }

        array_push( $arrRoles[$currRole]['services'], $entry);
    }

    set('roles', $arrRoles);

    return html('access/index.html.php');
}

# form for new role-service association
dispatch('/roles/:role_id/service/new', 'access_new');
function access_new()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $role_id = intval(params('role_id'));
    set('role', array('id'=> $role_id));

    $arrServices = $db->select(
        "SELECT {$cfg['tblService']}.id as dienst_id,
                {$cfg['tblService']}.`desc` as dienst_desc,
                {$cfg['tblDaemon']}.name as daemon_name,
                {$cfg['tblServer']}.fqdn as fqdn
        FROM {$cfg['tblService']}
        LEFT OUTER JOIN {$cfg['tblServer']}
        ON {$cfg['tblServer']}.id = {$cfg['tblService']}.server_id
        LEFT OUTER JOIN {$cfg['tblDaemon']}
        ON {$cfg['tblDaemon']}.id = {$cfg['tblService']}.daemon_id
        ORDER BY {$cfg['tblServer']}.fqdn ASC"
    );

    set('services', $arrServices);

    if( isAjaxRequest() )
        return js('access/new.js.php', null);
    else
        halt(HTTP_NOT_IMPLEMENTED);
}

# save new role-service association
dispatch_post('/access', 'access_create');
function access_create()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $role_id   = intval($_POST['role_id']);
    $dienst_id = intval($_POST['service_id']);

    $result = $db->insert(
        "INSERT INTO {$cfg['tblZugriff']}
        (dienst_id, rolle_id) VALUES
        ('$dienst_id', '$role_id')"
    );

    if( !$result )
    {
        halt(SERVER_ERROR);
        return;
    }

    $arrService = $db->select(
        "SELECT {$cfg['tblService']}.id as dienst_id,
                {$cfg['tblService']}.`desc` as dienst_desc,
                {$cfg['tblDaemon']}.name as daemon_name,
                {$cfg['tblServer']}.fqdn as fqdn
        FROM {$cfg['tblService']}
        LEFT OUTER JOIN {$cfg['tblServer']}
        ON {$cfg['tblServer']}.id = {$cfg['tblService']}.server_id
        LEFT OUTER JOIN {$cfg['tblDaemon']}
        ON {$cfg['tblDaemon']}.id = {$cfg['tblService']}.daemon_id
        WHERE {$cfg['tblService']}.id=$dienst_id"
    );

    if( !$arrService )
    {
        halt(SERVER_ERROR);
        return;
    }

    set('service', $arrService[0]);
    set('role', array('id'=>$role_id));

    if( isAjaxRequest() )
        return js('access/show.js.php', null);
    else
        halt(HTTP_NOT_IMPLEMENTED);
}

# remove a role-service association
dispatch_delete('/roles/:role_id/service/:service_id', 'access_delete');
function access_delete()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    $role_id   = intval(params('role_id'));
    $dienst_id = intval(params('service_id'));

    $result = $db->delete(
        "DELETE FROM {$cfg['tblZugriff']}
        WHERE rolle_id='$role_id'
        AND dienst_id='$dienst_id'
        LIMIT 1"
    );

    if( !$result )
    {
        halt(SERVER_ERROR);
        return;
    }

    set('role', array('id'=>$role_id));
    set('service', array('id'=>$dienst_id));

    if( isAjaxRequest() )
        return js('access/delete.js.php', null);
    else
        halt(HTTP_NOT_IMPLEMENTED);
}

?>