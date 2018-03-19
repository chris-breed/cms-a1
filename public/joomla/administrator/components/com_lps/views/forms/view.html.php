<?php
/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

// no direct access
defined('_JEXEC') or die; 

jimport('joomla.application.component.view');

/**
 * Landing pages view class for a list of landing pages.
 */
class LpsViewForms extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$model = $this->getModel();
		$input = JFactory::getApplication()->input;

		$this->state		= $this->get('State');
		//$this->settings = ArtCalendarHelper::getArtCalendarSettings();
		$this->items = $model->getListItems();

		$document = JFactory::getDocument();
		$document->addScriptDeclaration('window.FormItems = '.json_encode($this->items).';');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
        
		$this->addToolbar();
		$this->addLpsScripts();
        
        //$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add events javascript in body.
	 *
	 * @since	1.6
	 */
	protected function addLpsScripts() {
		echo "<script type=\"text/javascript\" src=\"components/com_lps/assets/js/forms.js\"></script>\n";
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		JToolBarHelper::title(JText::_('LPs - '.JText::_('COM_LPS_FORMS_TITLE')), 'forms');
		$document = JFactory::getDocument();
		$document->addStyleDeclaration('.icon-forms {background-image: url("components/com_lps/assets/images/joomlasales-trans-16.png");}');        
	}

    
}
