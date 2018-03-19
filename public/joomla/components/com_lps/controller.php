<?php
/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */
 
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class LpsController extends JControllerLegacy {
	/**
	 * Method to display a view.
	 *
	 * @param	boolean			$cachable	If true, the view output will be cached
	 * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$view = JFactory::getApplication()->input->getCmd('view', 'landingpages');
        JFactory::getApplication()->input->set('view', $view);

        //add UI js dependency
        //$this->addUIkitJs();

		parent::display($cachable, $urlparams);

		return $this;
	}

	/**
	* Method to add UIkit main js file to body of document
	* We're going to utilize j3x core jquery version to run this UI
	*
	*/
	function addUIkitJs() {
		echo "<script type=\"text/javascript\" src=\"components/com_lps/assets/libraries/uikit/js/uikit.js\"></script>\n";
	}
}