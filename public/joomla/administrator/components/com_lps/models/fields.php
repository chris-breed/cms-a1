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
 * Fields main model.
 */
class LpsModelFields extends JModelAdmin
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
    public function getTable($type = 'LandingPages', $prefix = 'LpsTable', $config = array())
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
        $sql = "SELECT f.* FROM `#__lps_fields` AS f";

        $where = array();
        //filter by name
        if ($this->getState('lps_fields_search')){
            $sql .= " LEFT JOIN `#__lps_field_properties` AS fp ON fp.field_id=f.id";
            $where[] = "fp.property_name='NAME' AND fp.property_value LIKE '%".$this->getState('lps_fields_search')."%'";
        }

        //filter by name
        if ($this->getState('lps_fields_form')){
            $where[] = "f.form_id=".$this->getState('lps_fields_form');
        }

        if (count($where) > 0) {
            $sql = $sql." WHERE ".implode(' AND ',$where);
        }

        if ($this->getState('lps_fields_form')){
            $sql .= " ORDER BY `order` ASC";
        }
        $db->setQuery($sql);
        if ($fields = $db->loadObjectList()) {
            $fieldContainer = array();
            foreach ($fields as $field) {
                $field->properties = $this->getFieldProperties($field->id);
                $fieldContainer[] = $field;
            }
            return $fieldContainer;
        } else {
            return array();
        }
    }

    public function getFieldProperties($fieldId) {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM `#__lps_field_properties` WHERE `field_id`=".$fieldId;
        $db->setQuery($sql);
        if ($properties = $db->loadObjectList()) {
            $propertyContainer = array();
            foreach ($properties as $property) {
                $propertyContainer[$property->property_name] = $property->property_value;
            }
            return $propertyContainer;
        } else {
            return array();
        }
    }

    public function getFieldTypes() {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM `#__lps_field_types`";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }

    public function store($field) {

        //Load calendar table class
        $fieldsTable =& JTable::getInstance('Fields','LpsTable'); 
           
        if (array_key_exists('id',$field)) {
            $fieldsTable->load($field['id']);
            $newField['id'] = $field['id'];
        } else {
            $maxOrder = $this->getFormFieldMaxOrdering($field['form_id']);
            $newField['order'] = $maxOrder + 1; 
        }

        $newField = array();
        $newField['type_id'] = $field['type_id'];
        $newField['form_id'] = $field['form_id'];
        $newField['published'] = 1; 

        // Bind the data to the table
        if (!$fieldsTable->bind($newField)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        // Make sure the record is valid
        if (!$fieldsTable->check()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
     
        // Store the web link table to the database
        if (!$fieldsTable->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        if (array_key_exists('id',$field)) { //we're editing
            $this->editFieldProperties($field['values'],$field['id']);
        } else { //we're creating new
            $this->storeFieldProperty($field['values'],$fieldsTable->id);
        }
        


        return true;
    }

    public function getFormFieldMaxOrdering($formId) {
        $db = JFactory::getDBO();
        $sql = "SELECT MAX(`order`) FROM `#__lps_fields` WHERE `form_id`=".$formId;
        $db->setQuery($sql);
        if ($maxId = $db->loadResult()) {
            return $maxId;
        } else {
            return 0;
        }
    }

    public function storeFieldProperty($properties,$fieldId) {

        if (count($properties) > 0) {
            foreach ($properties as $propertyName => $propertyValue) {
                $fieldPropertiesTable =& JTable::getInstance('FieldProperties','LpsTable');  
                
                $newProperty = array();
                $newProperty['field_id'] = $fieldId;
                $newProperty['property_name'] = strtoupper($propertyName);
                $newProperty['property_value'] = $propertyValue;

                // Bind the data to the table
                if (!$fieldPropertiesTable->bind($newProperty)) {
                    $this->setError($this->_db->getErrorMsg());
                    return false;
                }

                // Make sure the record is valid
                if (!$fieldPropertiesTable->check()) {
                    $this->setError($this->_db->getErrorMsg());
                    return false;
                }
             
                // Store the web link table to the database
                if (!$fieldPropertiesTable->store()) {
                    $this->setError($this->_db->getErrorMsg());
                    return false;
                }

            }
        }

        return true; 
    }

    public function editFieldProperties($properties,$fieldId) {

        if (count($properties) > 0) {
            foreach ($properties as $propertyName => $propertyValue) {
                $fieldPropertiesTable =& JTable::getInstance('FieldProperties','LpsTable');  
                
                $newProperty = array();
                $fieldPropertyId = $this->getFieldPropertyId($fieldId,$propertyName);

                //load the correct field property record
                if ($fieldPropertyId) {
                    $fieldPropertiesTable->load($fieldPropertyId);
                    $newProperty['id'] = $fieldPropertyId;
                } else {
                    continue; //go to next property
                }

                $newProperty['field_id'] = $fieldId;
                $newProperty['property_name'] = strtoupper($propertyName);
                $newProperty['property_value'] = $propertyValue;

                // Bind the data to the table
                if (!$fieldPropertiesTable->bind($newProperty)) {
                    $this->setError($this->_db->getErrorMsg());
                    continue;
                }

                // Make sure the record is valid
                if (!$fieldPropertiesTable->check()) {
                    $this->setError($this->_db->getErrorMsg());
                    continue;
                }
             
                // Store the web link table to the database
                if (!$fieldPropertiesTable->store()) {
                    $this->setError($this->_db->getErrorMsg());
                    continue;
                }

            }
        }

        return true;         
    }

    public function getFieldPropertyId($fieldId,$propertyName) {
        $db = JFactory::getDBO();
        $sql = "SELECT `id` FROM `#__lps_field_properties` 
                WHERE `field_id`=".$fieldId." AND `property_name`='".strtoupper($propertyName)."'";
        $db->setQuery($sql);
        return $db->loadResult();
    }

    public function saveFieldOrdering($ordering) {
        $db = JFactory::getDBO();
        if (count($ordering) > 0) {
            foreach ($ordering as $order) {
                $sql = "UPDATE `#__lps_fields` SET `order`=".$order->order." WHERE `id`=".$order->id;
                //echo $sql;
                $db->setQuery($sql);
                $db->execute();
            }
        
            return true;    
        }

        return false;
    }

    /**
     * Populate user state requests
     */
    function populateState(){

        $app = JFactory::getApplication();

        //search filter states
        $search = $app->getUserStateFromRequest('lps_fields_search','lps-fields-search','');
        $form = $app->getUserStateFromRequest('lps_fields_form','lps-fields-form',''); 

        //pagination
        //limits states
        //$limit = $app->getUserStateFromRequest('_limit','art_calendar_calendar_limit',10);
        //$limitstart = $app->getUserStateFromRequest('_limitstart','art_calendar_calendar_limitstart',0);
        // In case limit has been changed, adjust it
        //$limitstart = ($limit != 0) ? (floor($limitstart / $limit) * $limit) : 0;
                
        //set states
        $this->setState('lps_fields_search', $search);
        $this->setState('lps_fields_form', $form);
        //pagination vars    
        //$this->setState('_limit', $limit);
        //$this->setState('_limitstart', $limitstart);
        
    }

    function togglePublishing($state,$fieldId) {
        $db = JFactory::getDBO();
        $sql = "UPDATE `#__lps_fields` SET `published`=".$state." WHERE `id`=".$fieldId;
        $db->setQuery($sql);
        $db->execute();
        return true;
    }

    function removeFieldItem($fieldId) {
        $db = JFactory::getDBO();

        //remove the field properties
        $sql = "DELETE FROM `#__lps_field_properties` WHERE `field_id`=".$fieldId;
        $db->setQuery($sql);
        $db->execute();      

        //remove the submission values connected to this field
        $sql = "DELETE FROM `#__lps_submission_values` WHERE `field_id`=".$fieldId;
        $db->setQuery($sql);
        $db->execute();    

        //remove the field
        $sql = "DELETE FROM `#__lps_fields` WHERE `id`=".$fieldId;
        $db->setQuery($sql);
        $db->execute();

        return true;
    }



}