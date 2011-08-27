<?php

# report all php errors
error_reporting(E_ALL ^ E_NOTICE);

require_once('config.inc.php');

# define what to do when the user requests the index '/'
dispatch('/', 'acl_home');
function acl_home()
{
    return html('home/index.html.php');
}

# do the magic
run();

?>
