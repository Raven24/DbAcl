<?php

$wrapper_current_db = "";
$db_connection = null;
$wrapper_host = $GLOBALS['cfg']['db_host'];
$wrapper_user = $GLOBALS['cfg']['db_user'];
$wrapper_pwd  = $GLOBALS['cfg']['db_pass'];


// define some wrapper functions to abstract the db-specific calls

function wrapper_select_db($db) {
	global $db_connection, $wrapper_current_db;

	if (!mysql_select_db($db, $db_connection)) {
		echo "Kann DB nicht wechseln.\n";
		exit;
	}
	$wrapper_current_db = $db;
}

function wrapper_query($sql) {
	global $db_connection;

	return mysql_query($sql, $db_connection);
}

function wrapper_num_rows($result) {
	return mysql_num_rows($result);
}

function wrapper_fetch_row($result) {
	return mysql_fetch_row($result);
}

function wrapper_free_result($result) {
	return mysql_free_result($result);
}

function wrapper_escape($string) {
	return mysql_escape_string($string);
}

function wrapper_unescape($string) {
	return ereg_replace("\\\\\\\\","\\",ereg_replace("\\\\'","'",ereg_replace("\\\\\"","\"",$string)));
}

function wrapper_insert_id($dbConn=null) {
    global $db_connection;

    if( $dbConn != null ) {
        $db_connection = $dbConn;
    }
    
	return mysql_insert_id($db_connection);
}

// ==========================================================================================================
// ==========================================================================================================
// LiHo-code, converted

function wrapper_error($text='Query failed!') {
	$nr = mysql_errno();
	$msg = mysql_error ();
	echo "$text - ( $nr : $msg )<br>";
	exit;
}
// ==========================================================================================================
function wrapper_init($dbase) {
	global $db_connection, $wrapper_current_db, $wrapper_host, $wrapper_user, $wrapper_pwd;

	$db_connection = mysql_connect($wrapper_host,$wrapper_user,$wrapper_pwd);
	if ($db_connection) {
		if (!mysql_select_db($dbase, $db_connection)) {
			wrapper_error("No connection to database!");
		}
	} else {
		wrapper_error("Database not found!");
	}
	$wrapper_current_db = $dbase;
	return true;
}
// ==========================================================================================================
function wrapper_query($sql="") {
	global $db_connection;

	if (empty($sql)) {
		return false;
	}
	if (!eregi("^select",$sql)) {
		echo "Invalid query!";
		return false;
	}
	if (!empty($db_connection)) {
		$resultat = mysql_query($sql, $db_connection);
	} else {
		return false;
	}
		if ((!$resultat) || (empty($resultat))) {
		return false;
	}
	$i=0;
	$arrDaten = array();
	while ($reihe = mysql_fetch_row($resultat)) {
		$arrDaten[$i++] = $reihe;
	}
	mysql_free_result($resultat);
	return $arrDaten;
}
// ==========================================================================================================
function wrapper_query_in_hash($sql="", $dbConn=null) {
	global $db_connection;

    if( $dbConn != null ) {
        $db_connection = $dbConn;
    }
    
	if (empty($sql)) {
		return false;
	}
	if (!eregi("^select",$sql)) {
		echo "Invalid query!";
		return false;
	}
	if (!empty($db_connection)) {
		$resultat = mysql_query($sql, $db_connection);
	} else {
		return false;
	}
		if ((!$resultat) || (empty($resultat))) {
		return false;
	}

	$arrDaten = array();

	while ($hash_reihe = mysql_fetch_array($resultat,MYSQL_ASSOC)) {
		array_push($arrDaten,$hash_reihe);
	}

	mysql_free_result($resultat);
	return $arrDaten;
}
// ==========================================================================================================
function wrapper_query_in_singlelist($sql="") {
    global $db_connection;

    if (empty($sql)) {
        return false;
    }
    if (!eregi("^select",$sql)) {
        echo "Invalid query!";
        return false;
    }
    if (!empty($db_connection)) {
        $resultat = mysql_query($sql, $db_connection);
    } else {
        return false;
    }
        if ((!$resultat) || (empty($resultat))) {
        return false;
    }

    $arrDaten = array();

    while ($currItem = mysql_fetch_row($resultat)) {
        array_push($arrDaten,$currItem[0]);
    }

    mysql_free_result($resultat);
    return $arrDaten;
}
// ==========================================================================================================
function wrapper_single_query($sql="") {
	global $db_connection;

	if (empty($sql)) {
		return false;
	}
	if (!eregi("^select",$sql)) {
		echo "Invalid query!";
		return false;
	}
	if (!empty($db_connection)) {
		$resultat = mysql_query($sql, $db_connection);
	} else {
		return false;
	}
		if ((!$resultat) || (empty($resultat))) {
		return false;
	}

	if (mysql_num_rows($resultat)==1)
	{
	    $hash_reihe = mysql_fetch_array($resultat,MYSQL_ASSOC);
    }
    else $hash_reihe = false;

	mysql_free_result($resultat);

	return $hash_reihe;
}
// ==========================================================================================================
function wrapper_insert($sql="", $dbConn=null) {
	global $db_connection;

    if( $dbConn != null ) {
        $db_connection = $dbConn;
    }

	if (empty($sql)) {
		return false;
	}
	if (!eregi("^insert",$sql)) {
		echo "Invalid query!";
		return false;
	}
	if (empty($db_connection)) {
		return false;
	}
	$resultat = mysql_query($sql, $db_connection);
	/*if ($resultat) {
		$resultat = mysql_insert_id();
		return $resultat;
	} else {
		return false;
	}*/
	return $resultat;
}
// ==========================================================================================================
function wrapper_update($sql="", $dbConn=null) {
	global $db_connection;

    if( $dbConn != null ) {
        $db_connection = $dbConn;
    }
    
	if (empty($sql)) {
		return false;
	}
	if (!eregi("^update",$sql)) {
		echo "Invalid query!";
		return false;
	}
	if (empty($db_connection)) {
		return false;
	}
	$resultat = mysql_query($sql, $db_connection);
	return $resultat;
}
// ==========================================================================================================
function wrapper_delete($sql="", $dbConn=null) {
	global $db_connection;

    if( $dbConn != null ) {
        $db_connection = $dbConn;
    }

	if (empty($sql)) {
		return false;
	}
	if (!eregi("^delete",$sql)) {
		echo "Invalid query!";
		return false;
	}
	if (empty($db_connection)) {
		return false;
	}
	$resultat = mysql_query($sql, $db_connection);
	return $resultat;
}
// ==========================================================================================================
function wrapper_optimize($tabelle) {
	global $db_connection;

	$sql = "OPTIMIZE TABLE ".$tabelle;
	if (empty($db_connection)) {
		return false;
	}
	$resultat = mysql_query($sql, $db_connection);
	return $resultat;
}
// ==========================================================================================================

/**
 * mysql database class
 * provides the default database actions and some debugging methods
 * 
 * @author Florian Staudacher
 */
class MySQL
{
    var $lastQuery = '';
    var $lastResult = null;
    var $currentDb = '';
    var $dbConn = null;
    var $debug = false;

    /**
     * constructor
     */
    function MySQL($_host, $_user, $_pwd)
    {
        $this->dbConn = mysql_connect($_host, $_user, $_pwd) or $this->dbg();
        $this->setCharset("utf8");
    }

    /**
     * select database
     */
    function selectDb($_db)
    {
        mysql_select_db($_db, $this->dbConn) or $this->dbg();
        $this->currentDb = $_db;
    }

    /**
     * set connection charset
     */
    function setCharset($chr='utf8')
    {
        $this->query("SET NAMES '$chr'");
        $this->query("SET CHARACTER SET '$chr'");
    }

    /**
     * execute an arbitrary query and return the result
     */
    function query($_sql='')
    {
        if(empty($_sql)) {
            return false;
        }

        $this->lastResult = mysql_query($_sql, $this->dbConn) or $this->dbg();
        return $this->lastResult;
    }

    /**
     * execute a select statement
     */
    function select($_sql)
    {
        $this->lastQuery = $_sql;
        $this->lastResult = wrapper_query_in_hash($_sql, $this->dbConn) or $this->dbg();
        
        return $this->lastResult;
    }

    /**
     * execute an insert query
     */
    function insert($_sql)
    {
        $this->lastQuery = $_sql;
        $this->lastResult = wrapper_insert($_sql, $this->dbConn) or $this->dbg();

        return $this->lastResult;
    }

    /**
     * execute an update query
     */
    function update($_sql)
    {
        $this->lastQuery = $_sql;
        $this->lastResult = wrapper_update($_sql, $this->dbConn) or $this->dbg();

        return $this->lastResult;
    }

    /**
     * execute a delete query
     */
    function delete($_sql)
    {
        $this->lastQuery = $_sql;
        $this->lastResult = wrapper_delete($_sql, $this->dbConn) or $this->dbg();

        return $this->lastResult;
    }

    /**
     * number of rows returned by the last result
     */
    function numRows()
    {
        if( $this->lastResult )
            return wrapper_num_rows($this->lastResult);

        return 0;
    }

    /**
     * return the id of the last inserted row
     */
    function insertId()
    {
        if( $this->lastResult )
            return wrapper_insert_id();

        return 0;
    }

    /**
     * escape a string for safe usage in queries
     */
    function escape($str='')
    {
        return mysql_real_escape_string($str, $this->dbConn);
    }

    /**
     * generates some human-readable debug output and exits
     * in case mysql experiences some sort of error, trigger a php error, too
     */
    function dbg($echo=false)
    {
        if( $this->debug || $echo )
        {
            echo "Last Query: {$this->lastQuery}<br>";
            
            if( !$this->lastResult ) 
                trigger_error(wrapper_error(), E_USER_ERROR);
                
            ob_end_flush();
            exit;
        }

        return false;
    }
}
?>