<?php

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

/**
 * check whether the current request was issued by ajax
 */
function isAjaxRequest()
{
    if( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            return true;
        }

    return false;
}

/**
 * encode any string for save usage in javascript variables
 */
function encode_javascript($str)
{
    return '"' . addcslashes($str, "\\\"\n\r\t/" . chr(8) . chr(12)) . '"';
}

# prevent error message in php < 4.3.2
if(!function_exists('memory_get_usage'))
{
    function memory_get_usage()
    {
        return 0;
    }
}

# prevent error message in php < 5.1
if( !function_exists('headers_list'))
{
    function headers_list()
    {
        return array();
    }
}

# "backport" of php5
if( !function_exists('array_combine') )
{
    function array_combine($arr1, $arr2) {
        $out = array();

        $arr1 = array_values($arr1);
        $arr2 = array_values($arr2);

        foreach($arr1 as $key1 => $value1) {
            $out[(string)$value1] = $arr2[$key1];
        }

        return $out;
    }
}
?>