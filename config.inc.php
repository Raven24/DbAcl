<?php

# database credentials and table names
$GLOBALS['cfg'] = array(
    'db'                => 'access',
    'db_host'           => 'localhost',
    'db_user'           => 'root',
    'db_pass'           => '',
    'tblClient'         => 'client',
    'tblDaemon'         => 'daemon',
    'tblDienst'         => 'dienst',
    'tblPerson'         => 'person',
    'tblPort'           => 'port',
    'tblRolle'          => 'rolle',
    'tblServer'         => 'server',
    'tblZugriff'        => 'zugriff',
    'tblPersonHasRolle' => 'person_has_rolle',
);

include('includes/db_handle.php');

$GLOBALS['db'] = new MySQL(
    $GLOBALS['cfg']['db_host'],
    $GLOBALS['cfg']['db_user'],
    $GLOBALS['cfg']['db_pass']
);

$GLOBALS['db']->selectDb( $GLOBALS['cfg']['db'] );

header('Content-Type: text/html; charset=utf-8');

include('includes/functions.inc.php');
include('includes/auth.inc.php');

# limonade micro php framework - http://www.limonade-php.net
include('lib/limonade.php');

# the 'controllers' 
include('includes/people.php');
include('includes/clients.php');
include('includes/roles.php');
include('includes/people_roles.php');
include('includes/daemons.php');
include('includes/ports.php');
include('includes/servers.php');
include('includes/daemons_servers.php');
include('includes/access.php');

# limonade configuration
function configure()
{
    option('env', ENV_DEVELOPMENT);
    option('debug', true);
}

# execute before page rendering
function before()
{
    layout('layouts/default.html.php');
    set('header', '
        <a href="'.url_for().'">Home</a>
        <a href="'.url_for('people').'">Personen</a>
        <a href="'.url_for('roles').'">Rollen</a>
        <a href="'.url_for('access').'">Zugriff</a>
        <a href="'.url_for('servers').'">Server</a>
        <a href="'.url_for('daemons').'">Daemons</a>
    ');
    set('footer', '&copy; 2011 - Alexander Philipp Lintenhofer (Backend), Florian Staudacher (Frontent)');
}

# output after page rendering
function after($output, $route)
{
    if( !isAjaxRequest() )
    {
        $time = number_format( (float)substr(microtime(), 0, 10) - LIM_START_MICROTIME, 6);
        $output .= "\n<!-- page rendered in $time sec., on ".date("D M j G:i:s T Y")." -->\n";
        $output .= "<!-- for route\n";
        $output .= print_r($route, true);
        $output .= "-->";
    }
    
    return $output;
}

?>