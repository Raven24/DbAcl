<?php

# render a view for connecting roles with services
dispatch('/roles_services', 'roles_services_index');
function roles_services_index() 
{
	$cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];
    
    $arrRoles = fetchRolesServices();
    set('roles', $arrRoles);
    
    $arrServices = $db->select(
        "SELECT {$cfg['tblService']}.id as sid,
                {$cfg['tblService']}.`desc` as service_desc,
                {$cfg['tblDaemon']}.name as daemon_name,
                {$cfg['tblServer']}.fqdn as fqdn
        FROM {$cfg['tblService']}
        LEFT OUTER JOIN {$cfg['tblServer']}
        ON {$cfg['tblServer']}.id = {$cfg['tblService']}.server_id
        LEFT OUTER JOIN {$cfg['tblDaemon']}
        ON {$cfg['tblDaemon']}.id = {$cfg['tblService']}.daemon_id
        ORDER BY {$cfg['tblDaemon']}.name ASC"
    );
    set('services', $arrServices);
    
	return html('roles_services/index.html.php');
}

/**
 * Fetch roles with services and return them as array
 * @param string sql where statement
 * @return array entries
 */
function fetchRolesServices($where='WHERE 1') {
	$cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];
    
    # query the database for all roles
    $arrRoleAssocs = $db->select(
    	"SELECT {$cfg['tblRole']}.id as rid,
                {$cfg['tblService']}.id as sid,
                {$cfg['tblServer']}.id as server_id,
                {$cfg['tblDaemon']}.id as daemon_id,
                {$cfg['tblRole']}.name as role_name,
                {$cfg['tblRole']}.`desc` as role_desc,
                {$cfg['tblServer']}.`desc` as server_desc,
                {$cfg['tblService']}.`desc` as service_desc,
                {$cfg['tblDaemon']}.name as daemon_name,
                {$cfg['tblRole']}.*,
                {$cfg['tblServer']}.*,
                {$cfg['tblDaemon']}.*
        FROM {$cfg['tblRole']}
        LEFT OUTER JOIN {$cfg['tblAccess']}
        ON {$cfg['tblAccess']}.rolle_id = {$cfg['tblRole']}.id
        LEFT OUTER JOIN {$cfg['tblService']}
        ON {$cfg['tblService']}.id = {$cfg['tblAccess']}.dienst_id
        LEFT OUTER JOIN {$cfg['tblServer']}
        ON {$cfg['tblServer']}.id = {$cfg['tblService']}.server_id
        LEFT OUTER JOIN {$cfg['tblDaemon']}
        ON {$cfg['tblDaemon']}.id = {$cfg['tblService']}.daemon_id
        $where
        ORDER BY {$cfg['tblRole']}.name ASC, {$cfg['tblDaemon']}.name ASC"
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
            $arrRoles[$currRole]['services'] = array();
        }

        if( isset($entry['sid']) )
            array_push( $arrRoles[$currRole]['services'], $entry);
    }

    return $arrRoles;
}

?>