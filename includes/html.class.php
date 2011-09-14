<?php

class HTML extends Object 
{
	
	// the preferred html version
	function html_version() {
		return 5;	
	}
	
	/**
	 * return a style tag
	 */
	function css($content='') 
	{
		$tag = 'style';
		
		$attr = array();
		// html5 specifies default values for type attributes
		if( HTML::html_version() != 5 )
			$attr['type'] = 'text/css';
		
		return HTML::tag($tag, $attr, $content);
	}
	
	/**
	 * return a script tag
	 */
	function script($content='')
	{
		$tag = 'script';
		
		$attr = array();
		// html5 specifies default values for type attributes
		if( HTML::html_version() != 5 ) 
			$attr['type'] = 'text/javascript';
		
		return HTML::tag($tag, $attr, $content);
	}
	
	/**
	 * return the html code for a generic tag
	 * 
	 * @param string $name
	 * @param array $attributes
	 * @param string $content
	 * @param boolean $closing
	 */
	function tag($tag='html', $attributes=array(), $content='', $closing=true ) 
	{
		// specify a general html tag template
		$tmpl = '<%1$s %2$s />';
		if( $closing )
		{
			$tmpl = '<%1$s %2$s>%3$s</%1$s>';
		}
		
		$strAttr = "";
		foreach( $attributes as $name=>$val )
		{
			$strAttr .= addslashes($name).'="'.addslashes($val).'" ';
		}
		
		return sprintf($tmpl, $tag, $strAttr, $content);
	}
	
}

?>