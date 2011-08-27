<?php

session_start();

// for now, just login without credentials
// normally, you would have to validate a login somewhere around here
if( page() == 'login' && $_GET['proceed'] == 1 )
{
    $_SESSION['loggedIn'] = 1;
}

// delete session
if( page() == 'logout' )
{
    session_unset();
    $_SESSION = array();

}

// if we are not logged in, redirect
if( !loggedIn() && page() != 'login' && page() != 'logout' )
{
    redirect(array('page'=>'login'));
}



function loggedIn()
{
    return ( $_SESSION['loggedIn'] == 1 );
}

?>