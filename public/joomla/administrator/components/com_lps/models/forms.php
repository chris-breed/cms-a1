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
 * Forms main model.
 */
class LpsModelForms extends JModelAdmin
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

        $sql = "SELECT * FROM `#__lps_forms`";

        //filter by name
        //echo $this->getState('lps_forms_search');
        if ($this->getState('lps_forms_search')){
            $sql .= " WHERE `name` LIKE '%".$this->getState('lps_forms_search')."%'";
        }

        $db->setQuery($sql);
        return $db->loadObjectList();
    }

    public function store($form) {

        //Load calendar table class
        $table =& JTable::getInstance('Forms','LpsTable');        

        if (array_key_exists('id',$form)) {
            $table->load($form['id']);
            $user = JFactory::getUser();
            $form['modifiedby'] = $user->id;
            $form['modified'] = date('Y-m-d H:i:s');
        } else {
            $user = JFactory::getUser();
            $form['modifiedby'] = $user->id;
            $date = date('Y-m-d H:i:s');   
            $form['created'] = $date;   
            $form['modified'] = $date;            
        }

        // Bind the data to the table
        if (!$table->bind($form)) {
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

        return true;
    }

    /**
     * Populate user state requests
     */
    function populateState(){

        $app = JFactory::getApplication();

        //search filter states
        $search = $app->getUserStateFromRequest('lps_forms_search','lps-forms-search','');

        //limits states
        $limit = $app->getUserStateFromRequest('lps_forms_limit','lps_forms_limit',10);
        $limitstart = $app->getUserStateFromRequest('lps_forms_limitstart','lps_forms_limitstart',0);

        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0) ? (floor($limitstart / $limit) * $limit) : 0;
                
        //set states
        $this->setState('lps_forms_search', $search);
        $this->setState('lps_forms_limit', $limit);
        $this->setState('lps_forms_limitstart', $limitstart);
        
    }

    function performBatchAction() {
        $input = JFactory::getApplication()->input; //get the request data

        if ( ($batchActions = $input->getString('art-calendar-batch-actions')) && 
             ($selectedIds = $input->getString('art-calendar-batch-item-ids')) ) {

            $selectedIds = json_decode($selectedIds);
            $batchActions = json_decode($batchActions);

            if ( (count($selectedIds) > 0) && (count($batchActions) > 0) ) {

                $db = JFactory::getDBO();
                $sql = "UPDATE `#__artcalendar_calendar` SET ";
                $set = array();
                $where = " WHERE `id` IN (".implode(',',$selectedIds).")";

                if (in_array('published',$batchActions)) {
                    $set[] = '`published`='.$input->getString('art-calendar-batch-publishing');
                }
                if (in_array('showTitle',$batchActions)) {
                    $set[] = '`title`='.$input->getString('art-calendar-batch-show-title');
                }
                if (in_array('showButtons',$batchActions)) {
                    $set[] = '`buttons`='.$input->getString('art-calendar-batch-show-buttons');
                }
                if (in_array('showTime',$batchActions)) {
                    $set[] = '`showTime`='.$input->getString('art-calendar-batch-show-time');
                }
                if (in_array('access',$batchActions)) {
                    $set[] = '`access`='.$input->getString('art-calendar-batch-access');
                }
                if (in_array('year',$batchActions)) {
                    $set[] = '`year`='.$input->getString('art-calendar-batch-start-year');
                }
                if (in_array('month',$batchActions)) {
                    $set[] = '`month`='.$input->getString('art-calendar-batch-start-month');
                }
                if (in_array('day',$batchActions)) {
                    $set[] = '`weekStart`='.$input->getString('art-calendar-batch-start-day');
                }

                $db->setQuery( $sql.implode(',',$set).$where );
                $db->execute();
                
                return true;

            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    function togglePublishing($state,$formId) {
        $db = JFactory::getDBO();
        $sql = "UPDATE `#__lps_forms` SET `published`=".$state." WHERE `id`=".$formId;
        $db->setQuery($sql);
        $db->execute();
        return true;
    }

    function removeFormItem($formId) {
        $db = JFactory::getDBO();

        //remove the field properties
        $fieldIds = $this->getFormFieldIds($formId);
        if (count($fieldIds) > 0) {
            foreach ($fieldIds as $id) {
                if ($id > 0) {
                    $sql = "DELETE FROM `#__lps_field_properties` WHERE `field_id`=".$id;
                    $db->setQuery($sql);
                    $db->execute();      
                }
            }
        }

        //remove field records that belong to this form
        $sql = "DELETE FROM `#__lps_fields` WHERE `form_id`=".$formId;
        $db->setQuery($sql);
        $db->execute();

        $submissionIds = $this->getSubmissionIds($formId);
        if (count($submissionIds) > 0) {
            foreach ($submissionIds as $id) {
                if ($id > 0) {
                    //remove any submission values from this form
                    $sql = "DELETE FROM `#__lps_submission_values` WHERE `submission_id`=".$id;
                    $db->setQuery($sql);
                    $db->execute();    

                    //remove leads
                    $sql = "DELETE FROM `#__lps_leads` WHERE `submission_id`=".$id;
                    $db->setQuery($sql);
                    $db->execute();    
                }
            }
        }

        //remove submission record
        $sql = "DELETE FROM `#__lps_submissions` WHERE `form_id`=".$formId;
        $db->setQuery($sql);
        $db->execute();        

        //remove form record
        $sql = "DELETE FROM `#__lps_forms` WHERE `id`=".$formId;
        $db->setQuery($sql);
        $db->execute();

        //update any landing pages that were connected to the deleted record
        $sql = "UPDATE `#__lps_landing_pages` SET `form_id`=0 WHERE `form_id`=".$formId;
        $db->setQuery($sql);
        $db->execute();

        return true;
    }

    function getFormFieldIds($formId) {
        $db = JFactory::getDBO();
        $sql = "SELECT `id` FROM `#__lps_fields` WHERE `form_id`=".$formId;
        $db->setQuery($sql);
        $ids = $db->loadObjectList();
        $idArray = array();
        if (count($ids) > 0) {
            foreach($ids as $id) {
                $idArray[] = $id->id;
            }
        }
        return $idArray;
    }

    function getSubmissionIds($formId) {
        $db = JFactory::getDBO();
        $sql = "SELECT `id` FROM `#__lps_submissions` WHERE `form_id`=".$formId;
        $db->setQuery($sql);
        $ids = $db->loadObjectList();
        $idArray = array();
        if (count($ids) > 0) {
            foreach($ids as $id) {
                $idArray[] = $id->id;
            }
        }
        return $idArray;
    }

}