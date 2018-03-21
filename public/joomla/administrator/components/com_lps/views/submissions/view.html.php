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
 * Submissions view class for a list of form submissions.
 */
class LpsViewSubmissions extends JViewLegacy
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
		$this->items = $model->getListItems();
		$this->leads = LpsHelper::getLeads();

		$document = JFactory::getDocument();
		$document->addScriptDeclaration('window.SubmissionItems = '.json_encode($this->items).';');
		$document->addScriptDeclaration('window.LeadItems = '.json_encode($this->leads).';');

		//list filter
		$this->item_count = $model->getListItemPaginationCount();
		$this->limit = $this->state->get('limit');
		$this->limitstart = $this->state->get('limitstart'); 

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
		echo "<script type=\"text/javascript\" src=\"components/com_lps/assets/js/pagination.js\"></script>\n";		
		echo "<script type=\"text/javascript\" src=\"components/com_lps/assets/js/submissions.js\"></script>\n";
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{

		JToolBarHelper::title(JText::_('LPs - '.JText::_('COM_LPS_SUBMISSIONS_TITLE')), 'submissions');
		$document = JFactory::getDocument();
		$document->addStyleDeclaration('.icon-submissions {background-image: url("components/com_lps/assets/images/joomlasales-trans-16.png");}');
        
	}

    
}