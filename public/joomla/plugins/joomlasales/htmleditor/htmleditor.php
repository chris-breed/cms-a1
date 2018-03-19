<?php
/**
 * @version     1.1
 * @package     plg_joomlasales_htmleditor - Joomlasales HTML Editor
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

// no direct access
defined( "_JEXEC" ) or die;
 
jimport("joomla.plugin");

class plgJoomlaSalesHtmlEditor extends JPlugin
{
 
	function __construct( &$subject , $config ) {
	    parent::__construct($subject, $config);
	}

	/**
	 * Plugin method with the same name as the event will be called automatically.
	 */
	 function JoomlaSales_LoadHtmlEditorResources()
	 {	


		  echo "<link rel=\"stylesheet\" href=\"".JURI::root()."plugins/joomlasales/htmleditor/libraries/codemirror/lib/codemirror.css\" type=\"text/css\" />\n";
		  echo "<script src=\"".JURI::root()."plugins/joomlasales/htmleditor/libraries/codemirror/lib/codemirror.js\" type=\"text/javascript\"></script>\n";
		  echo "<script src=\"".JURI::root()."plugins/joomlasales/htmleditor/libraries/codemirror/mode/markdown/markdown.js\" type=\"text/javascript\"></script>\n";
		  echo "<script src=\"".JURI::root()."plugins/joomlasales/htmleditor/libraries/codemirror/addon/mode/overlay.js\" type=\"text/javascript\"></script>\n";
		  echo "<script src=\"".JURI::root()."plugins/joomlasales/htmleditor/libraries/codemirror/mode/xml/xml.js\" type=\"text/javascript\"></script>\n";
		  echo "<script src=\"".JURI::root()."plugins/joomlasales/htmleditor/libraries/codemirror/mode/gfm/gfm.js\" type=\"text/javascript\"></script>\n";
		  echo "<script src=\"".JURI::root()."plugins/joomlasales/htmleditor/libraries/marked/marked.min.js\" type=\"text/javascript\"></script>\n";


		return true;
	}
}
?>