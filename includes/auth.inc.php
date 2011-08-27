<?php

session_start();

// for now, just login without any credentials
// normally, you would have to implement and validate a login somewhere around here
$_SESSION['loggedIn'] = 1;


function loggedIn()
{
    return ( $_SESSION['loggedIn'] == 1 );
}

?>