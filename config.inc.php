<?php

# database credentials and table names
$GLOBALS['cfg'] = array(
    'db'                => 'access',
    'db_host'           => 'localhost',
    'db_user'           => 'root',
    'db_pass'           => '',
    'tblClient'         => 'client',
    'tblDaemon'         => 'daemon',
    'tblService'        => 'dienst',
    'tblPerson'         => 'person',
    'tblPort'           => 'port',
    'tblRole'           => 'rolle',
    'tblServer'         => 'server',
    'tblAccess'         => 'zugriff',
    'tblPersonHasRole'  => 'person_has_rolle',
);

# database handling
include('includes/db_handle.php');

$GLOBALS['db'] = new MySQL(
    $GLOBALS['cfg']['db_host'],
    $GLOBALS['cfg']['db_user'],
    $GLOBALS['cfg']['db_pass']
);

$GLOBALS['db']->selectDb( $GLOBALS['cfg']['db'] );

header('Content-Type: text/html; charset=utf-8');

# gettext configuration
$gettext_domain = 'messages';
$gettext_lang   = 'de_AT';

putenv ('LANG='.$gettext_lang);
setlocale(LC_ALL, $gettext_lang);
bindtextdomain($gettext_domain, './locale');
bind_textdomain_codeset($gettext_domain, 'UTF-8');
textdomain($gettext_domain);

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
    /*set('header', '
        <a href="'.url_for().'">Home</a>
        <a href="'.url_for('people').'">Personen</a>
        <a href="'.url_for('roles').'">Rollen</a>
        <a href="'.url_for('access').'">Zugriff</a>
        <a href="'.url_for('servers').'">Server</a>
        <a href="'.url_for('daemons').'">Daemons</a>
    ');*/
    set('header', '
        <img id="header_img" src="img/aclmodel.png" width="850" height="83" usemap="#head_nav">
        <map name="head_nav">
            <area id="daemons_nav" shape="rect" href="'.url_for('daemons').'" coords="682,7,781,28" />
            <area id="servers_nav" shape="rect" href="'.url_for('servers').'" coords="516,7,635,28" />
            <area id="access_nav" shape="rect" href="'.url_for('access').'" coords="391,7,478,28" />
            <area id="roles_nav" shape="rect" href="'.url_for('roles').'" coords="239,7,340,28" />
            <area id="people_nav" shape="rect" href="'.url_for('people').'" coords="74,7,193,28" />
            <area id="clients_nav" shape="rect" href="'.url_for('clients').'" coords="2,55,98,76" />
            <area id="people_roles_nav" shape="rect" href="'.url_for('people_roles').'" coords="176,54,267,75" />
        </map>
    ');
    set('footer', '&copy; 2011 - Florian Staudacher (Frontend), Alexander Philipp Lintenhofer (Backend)');
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