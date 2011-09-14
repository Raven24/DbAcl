<?php

/**
 * 'nice' debug output
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
 * encode any string for safe usage in javascript variables
 */
function encode_javascript($str)
{
    return '"' . addcslashes($str, "\\\"\n\r\t/" . chr(8) . chr(12)) . '"';
}

/**
 * get and return the nesting of another model
 * 
 * the nesting is also available in a view under the "$nested" variable
 * a nesting specified via GET will take precedence over one specified in POST
 */
function get_nesting()
{
	$nesting = addslashes($_GET['nested']);
	if( empty($nesting) ) $nesting = addslashes($_POST['nested']);
	
    set('nested', $nesting);
    if( !empty($nesting) ) $nesting = '.'.$nesting;
    return $nesting;
}

/**
 * include files by name
 * 
 * optionally add a dot-seperated pre- or suffix
 * e.g.: prefix.filename.suffix.php
 * 
 * @param array filenames
 */
function include_files($names)
{
	$prefix = $suffix = '';
	if( isset($names['prefix'])) 
	{
		$prefix = $names['prefix'].'.';
		unset($names['prefix']);
	}
	if( isset($names['suffix']))
	{
		$suffix = '.'.$names['suffix'];
		unset($names['suffix']);
	}
	
	foreach( $names as $name ) 
	{
		include(dirname(__FILE__) . '/' . $prefix . $name . $suffix . '.php');
	}
}

/**
 * php 4 compatibility functions.
 * simulate some functions that are available only in newer php versions
 */

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
    function array_combine($arr1, $arr2) 
    {
        $out = array();

        $arr1 = array_values($arr1);
        $arr2 = array_values($arr2);

        foreach($arr1 as $key1 => $value1) 
        {
            $out[(string)$value1] = $arr2[$key1];
        }

        return $out;
    }
}
?>