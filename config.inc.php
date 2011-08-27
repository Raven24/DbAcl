<?php

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
    'tblSerber'         => 'server',
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
include('lib/limonade.php');

include('includes/people.php');
include('includes/clients.php');

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
        <a href="'.url_for('zugriffe').'">Zugriff</a>
        <a href="'.url_for('server').'">Server</a>
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