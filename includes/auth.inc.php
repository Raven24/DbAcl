<?php

session_start();

// for now, just login without credentials
// normally, you would have to validate a login somewhere around here
$_SESSION['loggedIn'] = 1;


function loggedIn()
{
    return ( $_SESSION['loggedIn'] == 1 );
}

?>