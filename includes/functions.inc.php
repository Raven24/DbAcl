<?php

/**
 * redirect the visitor to a page
 */
function redirect($address='')
{
    if( is_array($address) && !empty($address['page']) )
    {
        $strAddress = generateLink($address);
    }
    elseif( is_string($address) )
    {
        $strAddress = $address;
    }

    if( headers_sent() )
    {
        // output already started, use javascript to redirect
        echo "
        <script type='text/javascript'>
            window.location.href = '$strAddress';
        </script>";
    }
    else
    {
        // http redirect, also sends 302 (REDIRECT) status code
        header("Location: $strAddress");
    }
}

/**
 * generate an address from an array
 */
function generateLink($parameters)
{
    // put together the redirect url
    $strAddress = 'index.php?page='.$parameters['page'];
    unset($parameters['page']);

    if( count($parameters) > 0 )
    {
        // handle the other parameters
        foreach( $parameters as $name=>$value )
        {
            $strAddress .= '&'.$name.'='.$value;
        }
    }

    return $strAddress;
}

/**
 * return the name of the currently requested page, cleaned
 */
function page()
{
    return preg_replace('/[^a-z]/', '', $_GET['page']);
}

/**
 * debug output
 */
function dbg($var)
{
    $out = "<pre>";
    $out .= print_r($var, true);
    $out .= "</pre>";
    
    return $out;
}

?>