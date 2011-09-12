<?php

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
    	$this->beforeQuery('', $_sql);
        $this->lastResult = mysql_query($_sql, $this->dbConn) or $this->dbg();
        return $this->lastResult;
    }

    /**
     * execute a select statement
     */
    function select($_sql)
    {
        $this->beforeQuery('SELECT', $_sql);
        $this->lastResult = $this->query($_sql) or $this->dbg();

        $arrData = array();
        while( $row = mysql_fetch_array($this->lastResult, MYSQL_ASSOC))
        {
        	array_push($arrData, $row);
        }
        
        return $arrData;
    }

    /**
     * execute an insert query
     */
    function insert($_sql)
    {
        $this->beforeQuery('INSERT', $_sql);
        $this->lastResult = $this->query($_sql) or $this->dbg();
        return $this->lastResult;
    }

    /**
     * execute an update query
     */
    function update($_sql)
    {
        $this->beforeQuery('UPDATE', $_sql);
        $this->lastResult = $this->query($_sql) or $this->dbg();
        return $this->lastResult;
    }
    
    /**
     * execute a delete query
     */
    function delete($_sql)
    {
        $this->beforeQuery('DELETE', $_sql);
        $this->lastResult = $this->query($_sql) or $this->dbg();
        return $this->lastResult;
    }
    
    /**
     * free last mysql result
     */
    function freeResult() {
    	if( is_resource($this->lastResult) )
    	{
    		$retVal = mysql_free_result($this->lastResult);
    		unset($this->lastResult);
    		return $retVal; 
    	}	
    }
    
    /**
     * optimize table
     */
	function optimize($_table='')
	{
		$sql = "OPTIMIZE TABLE ".$_table;
		$this->beforeQuery("OPTIMIZE TABLE", $sql);
		if( empty($_table) ) $this->debug(true);
		
		$this->lastResult = $this->query($sql) or $this->dbg();
		return $this->lastResult;
	}

    /**
     * number of rows returned by the last result
     */
    function numRows()
    {
        if( $this->lastResult )
            return mysql_num_rows($this->lastResult);

        return 0;
    }

    /**
     * return the id of the last inserted row
     */
    function insertId()
    {
        if( $this->lastResult )
            return mysql_insert_id($this->dbConn);

        return 0;
    }

    /**
     * escape a string for safe usage in queries
     */
    function escape($str='')
    {
    	if( $this->dbConn )
        	return mysql_real_escape_string($str, $this->dbConn);
        
        return $str;
    }
    
    /**
     * do some rudimental checking to see if the query is valid
     * 
     * @access private
	 * @param String query type
	 * @param String sql query
	 * @return boolean
     */
    function checkQuery($type="", $sql)
    {
    	if( empty($sql) ) return false;
	    return preg_match("/^".$type."/i", $sql);
    }
    
    /**
     * some actions that should be done before the query
     * 
     * @access private
     * @param String query type
     * @param String query string
     */
    function beforeQuery($type='', $sql)
    {
    	$this->freeResult();
    	$this->lastQuery = $sql;
    	if( !$this->dbConn ) $this->dbg(true);
    	if( !$this->checkQuery($type, $sql) ) $this->dbg(true);
    }

    /**
     * generates some human-readable debug output and exits
     * in case mysql experiences some sort of error, trigger a php error, too
     * 
     * @param boolean if true (or $this->debug is true), force output and exit
     */
    function dbg($echo=false)
    {
        if( $this->debug || $echo )
        {
            $strDebug = "Last Query: {$this->lastQuery}<br>";
            
            if( !$this->lastResult ) 
            {
            	$nr = mysql_errno();
				$msg = mysql_error ();
            	$strError = "$strDebug - ( $nr : $msg )<br>";
            	
            	trigger_error($strError, E_USER_ERROR);
            }
            
            echo $strDebug;    
            ob_end_flush();
            
            exit;
        }

        return false;
    }
}
?>