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

jimport('joomla.application.component.modeladmin');

/**
 * Templates main model.
 */
class LpsModelTemplates extends JModelAdmin
{
    /**
     * @var     string  The prefix to use with controller messages.
     * @since   1.6
     */
    protected $text_prefix = 'COM_LPS';


    /**
     * Returns a reference to the Table object, always creating it.
     *
     * @param   type    The table type to instantiate
     * @param   string  A prefix for the table class name. Optional.
     * @param   array   Configuration array for model. Optional.
     * @return  JTable  A database object
     * @since   1.6
     */
    public function getTable($type = 'Templates', $prefix = 'LpsTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param   array   $data       An optional array of data for the form to interogate.
     * @param   boolean $loadData   True if the form is to load its own data (default case), false if not.
     * @return  JForm   A JForm object on success, false on failure
     * @since   1.6
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Initialise variables.
        $app    = JFactory::getApplication();

        // Get the form.
        $form = $this->loadForm('com_lps.edit', 'edit', array('control' => 'jform', 'load_data' => $loadData));
        
        
        if (empty($form)) {
            return false;
        }

        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return  mixed   The data for the form.
     * @since   1.6
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_lps.edit.edit.data', array());

        if (empty($data)) {
            $data = $this->getItem();
            
        }

        return $data;
    }

    /**
     * Method to get a single record.
     *
     * @param   integer The id of the primary key.
     *
     * @return  mixed   Object on success, false on failure.
     * @since   1.6
     */
    public function getItem($pk = null)
    {
        if ($item = parent::getItem($pk)) {

            //Do any procesing on fielDIRECTORY_SEPARATOR here if needed

        }

        return $item;
    }

    public function getListItems() {
        $db = JFactory::getDBO();

        $sql = "SELECT * FROM `#__lps_templates`";

        //filter by name
        echo $this->getState('lps_templates_search');
        if ($this->getState('lps_templates_search')){
            $sql .= " WHERE `name` LIKE '%".$this->getState('lps_templates_search')."%'";
        }

        $db->setQuery($sql);
        return $db->loadObjectList();
    }

    function getTemplate($templateId) {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM `#__lps_templates` WHERE `id` = ".$templateId;
        $db->setQuery($sql);
        return $db->loadObject();
    }

    public function store() {

        $input = JFactory::getApplication()->input;
        $data = array();

        //Load calendar table class
        $table =& JTable::getInstance('Templates','LpsTable');        

        //get all applicable data vars
        if ($input->getString('lps-templates-name') !="") {
            $data['name'] = $input->getString('lps-templates-name');
        }        
        if (LpsHelper::isValueNumeric( $input->getInt('lps-templates-published') )) {
            $data['published'] = $input->getInt('lps-templates-published');
        }
        if ($input->getString('lps-templates-description') !="") {
            $data['description'] = $input->getString('lps-templates-description');
        }

        if ($input->getString('lps-templates-layout') !="") {
            $data['layout'] = $input->getString('lps-templates-layout');
        }

        if ($input->getString('lps-templates-form-show-title') !="") {
            $data['show_form_title'] = $input->getString('lps-templates-form-show-title');
        }

        if ($input->getString('lps-templates-form-container') !="") {
            $data['form_container'] = $input->getString('lps-templates-form-container');
        }

        if ($input->getString('lps-templates-form-field-width') !="") {
            $data['field_width'] = $input->getString('lps-templates-form-field-width');
        }

        if ($input->getString('lps-templates-form-field-size') !="") {
            $data['field_size'] = $input->getString('lps-templates-form-field-size');
        }

        if ($input->getString('lps-templates-form-field-labeling') !="") {
            $data['field_labeling'] = $input->getString('lps-templates-form-field-labeling');
        }

        //if we're editing
        if ($input->getInt('lps-templates-edit-item-id')) { 
            $data['id'] = $input->getInt('lps-templates-edit-item-id');
            $table->load($data['id']);
        } else {
            $data['created'] = date('Y-m-d H:i:s');
        }

        /*if ($input->getString('lp-templates-selected-layout-editing') !="") {
            $data['content'] = $input->getString('lp-templates-selected-layout-editing','','RAW');
        }*/

        //var_dump($data);die();//debug

        $user = JFactory::getUser();
        $data['modifiedby'] = $user->id;
        $data['modified'] = date('Y-m-d H:i:s');
        

        // Bind the data to the table
        if (!$table->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        // Make sure the record is valid
        if (!$table->check()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
     
        // Store the web link table to the database
        if (!$table->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        $db = $table->getDBO();
        return $db->insertid();
    }

    function storeHtmlContent($templateId,$htmlContent) {
        $db = JFactory::getDBO();
        $sql = "UPDATE `#__lps_templates` SET `content`='".$db->escape($htmlContent)."' WHERE `id`=".$templateId;
        $db->setQuery($sql);
        $db->execute();
        return true;
    }

    /**
     * Populate user state requests
     */
    function populateState(){

        $app = JFactory::getApplication();

        //search filter states
        $search = $app->getUserStateFromRequest('lps_templates_search','lps-templates-search','');

        //limits states
        $limit = $app->getUserStateFromRequest('lps_templates_limit','lps_templates_limit',10);
        $limitstart = $app->getUserStateFromRequest('lps_templates_limitstart','lps_templates_limitstart',0);

        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0) ? (floor($limitstart / $limit) * $limit) : 0;
                
        //set states
        $this->setState('lps_templates_search', $search);
        $this->setState('lps_templates_limit', $limit);
        $this->setState('lps_templates_limitstart', $limitstart);
        
    }

    function togglePublishing($state,$templateId) {
        $db = JFactory::getDBO();
        $sql = "UPDATE `#__lps_templates` SET `published`=".$state." WHERE `id`=".$templateId;
        $db->setQuery($sql);
        $db->execute();
        return true;
    }

    function removeTemplateItem($templateId) {
        $db = JFactory::getDBO();

        //remove the template record
        $sql = "DELETE FROM `#__lps_templates` WHERE `id`=".$templateId;
        $db->setQuery($sql);
        $db->execute();

        //update any landing pages that were connected to the deleted record
        $sql = "UPDATE `#__lps_landing_pages` SET `template_id`=0 WHERE `template_id`=".$templateId;
        $db->setQuery($sql);
        $db->execute();

        return true;
    }

    function editTemplateItem() {

        $db = JFactory::getDBO();
        $input = JFactory::getApplication()->input;
        $set = array();

        $sql = "UPDATE `#__lps_templates` ";

        if ($templateId = $input->getInt('lps-templates-edit-item-id')) {

        } else {
            return false;
        }
        if ($input->getString('lps-templates-edit-name') !="") {
            $set[] = "`name`='".$db->escape($input->getString('lps-templates-edit-name'))."'";
        }        
        if (LpsHelper::isValueNumeric( $input->getInt('lps-templates-edit-published') )) {
            $set[] = "`published`=".$input->getInt('lps-templates-edit-published');
        }
        if ($input->getString('lps-templates-edit-description') !="") {
            $set[] = "`description`='".$db->escape($input->getString('lps-templates-edit-description'))."'";
        }

        if (count($set) > 0) {
            $sql .= "SET ".implode(",",$set)." WHERE `id`=".$templateId;
            $db->setQuery($sql);
            $db->execute();
        } else {
            return false;
        }

        return true;        
    }

}