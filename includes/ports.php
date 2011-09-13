<?php

# show a list of clients
dispatch('/ports', 'ports_index');
function ports_index()
{
    $arrPorts = fetchPorts();

    set('ports', $arrPorts);

    return html('ports/index.html.php');
}

# show form for new port
dispatch('/ports/new', 'ports_new');
function ports_new()
{
	$cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];
    
    set('daemon_id', $_GET['daemon_id']);
    
    $nesting = get_nesting();
    
    // fetch all daemons for dropdown
    $arrDaemons = $db->select(
        "SELECT *
        FROM {$cfg['tblDaemon']}
        ORDER BY name ASC"
    );
    set('daemons', $arrDaemons);

    if( isAjaxRequest() )
    {
        return js('ports/new'.$nesting.'.js.php', null);
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

/**
 * fetch ports and return them with the associated daemon
 * in an array
 */
function fetchPorts($where='WHERE 1')
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];

    # query the database
    $arrPortsDaemons = $db->select(
        "SELECT {$cfg['tblPort']}.id as pid,
                {$cfg['tblDaemon']}.id as did,
                {$cfg['tblPort']}.*,
                {$cfg['tblDaemon']}.*
        FROM {$cfg['tblPort']}
        LEFT JOIN {$cfg['tblDaemon']}
        ON {$cfg['tblPort']}.daemon_id = {$cfg['tblDaemon']}.id
        $where
        ORDER BY {$cfg['tblPort']}.number ASC"
    );

    # put the person data in it's own array
    $arrPorts = array();
    foreach( $arrPortsDaemons as $entry )
    {
        if( isset($entry['pid']) )
        {
            $entry['daemon'] = $entry;
        }
        array_push($arrPorts, $entry);
    }

    return $arrPorts;
}

?>